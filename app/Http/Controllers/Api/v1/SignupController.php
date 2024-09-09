<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\SignupStoreRequest;
use App\Http\Resources\UserResource;
use App\Models\Address;
use App\Models\Contact;
use App\Models\Password;
use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SignupController extends Controller
{
    /**
     * Register a newly created User.
     * @unauthenticated
     */
    public function signup(SignupStoreRequest $request)
    {
        $dati = $request->validated();
        DB::transaction(function () use ($dati) {
            $person = new Person();
            $person->nome = $dati["nome"];
            $person->cognome = $dati["cognome"];
            $person->data_nascita = $dati["data_nascita"];
            $person->sesso = $dati["sesso"];
            $person->cf = $dati["cf"];
            $person->save();
            $user = new User();
            $user->role_id = 2;
            $user->person_id = $person->id;
            $user->state_id = 2;
            $user->user = $dati["user"];
            $user->save();
            $password = new Password();
            $password->user_id = $user->id;
            $password->password = $dati["password"];
            $password->save();
            if ($dati["addresses"]) {
                foreach ($dati["addresses"] as $a) {
                    if ($a["id"] != null) {
                        $address = Address::find($a["id"]);
                    }
                    if (!isset($address))
                        $address = new Address();
                    $address->address_type_id = $a["address_type_id"];
                    $address->CAP = $a["CAP"];
                    $address->civico = $a["civico"];
                    $address->indirizzo = $a["indirizzo"];
                    $address->municipality_id = $a["municipality_id"];
                    $address->nation_id = $a["nation_id"];
                    $address->person_id = $user->person->id;
                    $address->save();
                }
            }
            if ($dati["contacts"]) {
                foreach ($dati["contacts"] as $a) {
                    if ($a["id"] != null) {
                        $contact = Contact::find($a["id"]);
                    }
                    if (!isset($contact))
                        $contact = new Contact();
                    $contact->contact_type_id = $a["contact_type_id"];
                    $contact->contatto = $a["contatto"];
                    $contact->person_id = $user->person->id;
                    $contact->save();
                }
            }
        });
        return true;
    }

    /**
     * Update the specified User.
     */
    public function update(ProfileUpdateRequest $request, User $user)
    {
        $utente = Auth::getUser();
        if (Gate::allows("edit") || $utente->id == $user->id) {
            $dati = $request->validated();
            DB::transaction(function () use ($dati, $user) {
                $user->person->nome = $dati["nome"];
                $user->person->cognome = $dati["cognome"];
                $user->person->data_nascita = $dati["data_nascita"];
                $user->person->sesso = $dati["sesso"];
                $user->person->cf = $dati["cf"];
                $user->person->save();
                $user->user = $dati["user"];
                $user->save();
                if (isset($dati["password"])) {
                    $user->passwords()->delete();
                    $password = new Password();
                    $password->user_id = $user->id;
                    $password->password = $dati["password"];
                    $password->save();
                }
                $old_addresses_id = $user->person->addresses->pluck('id')->toArray();
                $new_addresses_id = [];
                if ($dati["addresses"]) {
                    foreach ($dati["addresses"] as $a) {
                        //die(json_encode($a));
                        if ($a["id"] != null) {
                            $address = Address::find($a["id"]);
                            $new_addresses_id[] = $a["id"];
                        }
                        if (!isset($address))
                            $address = new Address();
                        $address->address_type_id = $a["address_type_id"];
                        $address->CAP = $a["CAP"];
                        $address->civico = $a["civico"];
                        $address->indirizzo = $a["indirizzo"];
                        $address->municipality_id = $a["municipality_id"];
                        $address->nation_id = $a["nation_id"];
                        $address->person_id = $user->person->id;
                        $address->save();
                    }
                }
                $addresses_deleted_id = array_diff($old_addresses_id, $new_addresses_id);
                Address::where('person_id', $user->person->id)->whereIn('id', $addresses_deleted_id)->delete();
                $old_contacts_id = $user->person->contacts->pluck('id')->toArray();
                //abort(403, json_encode($old_contacts_id));
                $new_contacts_id = [];
                if ($dati["contacts"]) {
                    foreach ($dati["contacts"] as $a) {
                        if ($a["id"] != null) {
                            $contact = Contact::find($a["id"]);
                            $new_contacts_id[] = $a["id"];
                        }
                        if (!isset($contact))
                            $contact = new Contact();
                        $contact->contact_type_id = $a["contact_type_id"];
                        $contact->contatto = $a["contatto"];
                        $contact->person_id = $user->person->id;
                        $contact->save();
                    }
                }
                $contacts_deleted_id = array_diff($old_contacts_id, $new_contacts_id);
                Contact::where('person_id', $user->person->id)->whereIn('id', $contacts_deleted_id)->delete();
            });
            return new UserResource($user);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }
}
