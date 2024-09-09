<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressStoreRequest;
use App\Http\Requests\AddressUpdateRequest;
use App\Http\Resources\AddressCollection;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AddressController extends Controller
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
            $risorsa = Address::filter()->sort()->get();
            return new AddressCollection($risorsa);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddressStoreRequest $request)
    {
        if(Gate::allows("create") || Gate::allows("read")){
            $dati = $request->validated();
            $address = Address::create($dati);
            return new AddressResource($address);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Address $address)
    {
        if(Gate::allows("read")){
            $utente = Auth::getUser();
            if($utente->role_id==1 || $utente->role->nome=="Admin" || $utente->id==$address->person->user->id){
                return new AddressResource($address);
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
    public function update(AddressUpdateRequest $request, Address $address)
    {
        $utente = Auth::getUser();
        if(Gate::allows("edit") || $utente->role_id==1 || $utente->role->nome=="Admin" || $utente->id==$address->person->user->id){
            $dati = $request->validated();
            $address->fill($dati);
            $address->save();
            return new AddressResource($address);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        if(Gate::allows("delete")){
            $address->deleteOrFail();
            return response()->noContent();
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }
}
