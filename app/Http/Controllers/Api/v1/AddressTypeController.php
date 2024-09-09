<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressTypeStoreRequest;
use App\Http\Requests\AddressTypeUpdateRequest;
use App\Http\Resources\AddressTypeCollection;
use App\Http\Resources\AddressTypeResource;
use App\Models\AddressType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AddressTypeController extends Controller
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

        $risorsa = AddressType::filter()->sort()->get();
        return new AddressTypeCollection($risorsa);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddressTypeStoreRequest $request)
    {
        if(Gate::allows("create")){
            $dati = $request->validated();
            $addressType = AddressType::create($dati);
            return new AddressTypeResource($addressType);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AddressType $addressType)
    {
        return new AddressTypeResource($addressType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AddressTypeUpdateRequest $request, AddressType $addressType)
    {
        if(Gate::allows("edit")){
            $dati = $request->validated();
            $addressType->fill($dati);
            $addressType->save();
            return new AddressTypeResource($addressType);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Remove the specified AddressType.
     */
    public function destroy(AddressType $addressType)
    {
        if(Gate::allows("delete")){
            $addressType->deleteOrFail();
            return response()->noContent();
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }
}
