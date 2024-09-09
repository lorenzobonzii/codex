<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactStoreRequest;
use App\Http\Requests\ContactUpdateRequest;
use App\Http\Resources\ContactCollection;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            /** @query */
            'filters[]' => ["array"],
        ]);

        if(Gate::allows("read")){
            $risorsa = Contact::filter()->sort()->get();
            return new ContactCollection($risorsa);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactStoreRequest $request)
    {
        if(Gate::allows("create") || Gate::allows("read")){
            $dati = $request->validated();
            $contact = Contact::create($dati);
            return new ContactResource($contact);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        if(Gate::allows("read")){
            $utente = Auth::getUser();
            if($utente->role_id==1 || $utente->role->nome=="Admin" || $utente->id==$contact->person->user->id){
                return new ContactResource($contact);
            } else {
                abort(403, "ACCESS DENIED");
            }
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContactUpdateRequest $request, Contact $contact)
    {
        $utente = Auth::getUser();
        if(Gate::allows("edit") || $utente->role_id==1 || $utente->role->nome=="Admin" || $utente->id==$contact->person->user->id){
            $dati = $request->validated();
            $contact->fill($dati);
            $contact->save();
            return new ContactResource($contact);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        if(Gate::allows("delete")){
            $contact->deleteOrFail();
            return response()->noContent();
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }
}
