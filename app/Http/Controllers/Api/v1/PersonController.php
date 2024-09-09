<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PersonStoreRequest;
use App\Http\Requests\PersonUpdateRequest;
use App\Http\Resources\PersonCollection;
use App\Http\Resources\PersonResource;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PersonController extends Controller
{
    /**
     * Display a listing of the Person.
     */
    public function index(Request $request)
    {
        $request->validate([
            /** @query */
            'filters[]' => ["array"],
        ]);

        if(Gate::allows("read")){
            $risorsa = Person::filter()->sort()->get();
            return new PersonCollection($risorsa);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Store a newly created Person.
     */
    public function store(PersonStoreRequest $request)
    {
        if(Gate::allows("create")){
            $dati = $request->validated();
            $dati["password"] = sha1($dati["password"]);
            $person = Person::create($dati);
            return new PersonResource($person);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Display the specified Person.
     */
    public function show(Person $person)
    {
        if(Gate::allows("read")){
            $utente = Auth::getPerson();
            if($utente->role_id==1 || $utente->role->nome=="Admin" || $utente->id==$person->user->id){
                return new PersonResource($person);
            } else {
                abort(403, "ACCESS DENIED");
            }
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Update the specified Person.
     */
    public function update(PersonUpdateRequest $request, Person $person)
    {
        $utente = Auth::getPerson();
        if(Gate::allows("edit") || $utente->role_id==1 || $utente->role->nome=="Admin" || $utente->id==$person->user->id){
            $dati = $request->validated();
            $person->fill($dati);
            $person->save();
            return new PersonResource($person);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Remove the specified Person.
     */
    public function destroy(Person $person)
    {
        if(Gate::allows("delete")){
            $person->deleteOrFail();
            return response()->noContent();
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }
}
