<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Municipality;
use App\Http\Controllers\Controller;
use App\Http\Requests\MunicipalityStoreRequest;
use App\Http\Requests\MunicipalityUpdateRequest;
use App\Http\Resources\MunicipalityCollection;
use App\Http\Resources\MunicipalityResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MunicipalityController extends Controller
{
    /**
     * Display a listing of the Municipality.
     */
    public function index(Request $request)
    {
        $request->validate([
            /** @query */
            'filters[]' => ["array"],
        ]);

        $risorsa = Municipality::filter()->sort()->get();
        return new MunicipalityCollection($risorsa);
    }

    /**
     * Store a newly created Municipality.
     */
    public function store(MunicipalityStoreRequest $request)
    {
        if (Gate::allows("create")) {
            $dati = $request->validated();
            $municipality = Municipality::create($dati);
            return new MunicipalityResource($municipality);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Display the specified Municipality.
     */
    public function show(Municipality $municipality)
    {
        return new MunicipalityResource($municipality);
    }

    /**
     * Update the specified Municipality.
     */
    public function update(MunicipalityUpdateRequest $request, Municipality $municipality)
    {
        if (Gate::allows("edit")) {
            $dati = $request->validated();
            $municipality->fill($dati);
            $municipality->save();
            return new MunicipalityResource($municipality);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Remove the specified Municipality.
     */
    public function destroy(Municipality $municipality)
    {
        if (Gate::allows("delete")) {
            $municipality->deleteOrFail();
            return response()->noContent();
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }
}
