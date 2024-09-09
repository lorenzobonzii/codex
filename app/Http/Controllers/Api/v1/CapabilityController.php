<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CapabilityStoreRequest;
use App\Http\Requests\CapabilityUpdateRequest;
use App\Http\Resources\CapabilityCollection;
use App\Http\Resources\CapabilityResource;
use App\Models\Capability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CapabilityController extends Controller
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

        $risorsa = Capability::filter()->sort()->get();
        return new CapabilityCollection($risorsa);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CapabilityStoreRequest $request)
    {
        if(Gate::allows("create")){
            $dati = $request->validated();
            $capability = Capability::create($dati);
            return new CapabilityResource($capability);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Capability $capability)
    {
        return new CapabilityResource($capability);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CapabilityUpdateRequest $request, Capability $capability)
    {
        if(Gate::allows("edit")){
            $dati = $request->validated();
            $capability->fill($dati);
            $capability->save();
            return new CapabilityResource($capability);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Remove the specified Capability.
     */
    public function destroy(Capability $capability)
    {
        if(Gate::allows("delete")){
            $capability->deleteOrFail();
            return response()->noContent();
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }
}
