<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Helpers\AppHelpers;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserUpdateRequestApi;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\Address;
use App\Models\Contact;
use App\Models\Nation;
use App\Models\Password;
use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the User.
     */
    public function index(Request $request)
    {
        $request->validate([
            /** @query */
            'filters[]' => ["array"],
        ]);

        if (Gate::allows("read")) {
            $risorsa = User::filter()->sort()->with('state', 'role', 'person', 'person.addresses', 'person.contacts')->get();
            return new UserCollection($risorsa);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Store a newly created User.
     */
    public function store(UserStoreRequest $request)
    {
        if (Gate::allows("create")) {
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
                $user->role_id = $dati["role_id"];;
                $user->person_id = $person->id;
                $user->state_id = $dati["state_id"];;
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
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Display the specified User.
     */
    public function show(User $user)
    {
        if (Gate::allows("read")) {
            $utente = Auth::getUser();
            if ($utente->role_id == 1 || $utente->role->nome == "Admin" || $utente->id == $user->id) {
                return new UserResource($user);
            } else {
                abort(403, "ACCESS DENIED");
            }
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Update the specified User.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $utente = Auth::getUser();
        if (Gate::allows("edit") || $utente->role_id == 1 || $utente->role->nome == "Admin" || $utente->id == $user->id) {
            $dati = $request->validated();
            DB::transaction(function () use ($dati, $user) {
                $user->person->nome = $dati["nome"];
                $user->person->cognome = $dati["cognome"];
                $user->person->data_nascita = $dati["data_nascita"];
                $user->person->sesso = $dati["sesso"];
                $user->person->cf = $dati["cf"];
                $user->person->save();
                $user->role_id = $dati["role_id"];
                $user->state_id = $dati["state_id"];;
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

    /**
     * Remove the specified User.
     */
    public function destroy(User $user)
    {
        if (Gate::allows("delete")) {
            $user->sessions()->delete();
            $user->loginAttempts()->delete();
            $user->passwords()->delete();
            $user->person->contacts()->delete();
            $user->person->addresses()->delete();
            $user->person->delete();
            $user->deleteOrFail();
            return response()->noContent();
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }
}
