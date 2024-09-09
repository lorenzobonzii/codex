<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Nation;
use App\Http\Controllers\Controller;
use App\Http\Requests\NationStoreRequest;
use App\Http\Requests\NationUpdateRequest;
use App\Http\Resources\NationCollection;
use App\Http\Resources\NationResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class NationController extends Controller
{
    /**
     * Display a listing of the Nation.
     */
    public function index(Request $request)
    {
        $request->validate([
            /** @query */
            'filters[]' => ["array"],
        ]);

        $risorsa = Nation::filter()->sort()->get();
        return new NationCollection($risorsa);
    }

    /**
     * Store a newly created Nation.
     */
    public function store(NationStoreRequest $request)
    {
        if (Gate::allows("create")) {
            $dati = $request->validated();
            $nation = Nation::create($dati);
            return new NationResource($nation);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Display the specified Nation.
     */
    public function show(Nation $nation)
    {
        return new NationResource($nation);
    }

    /**
     * Update the specified Nation.
     */
    public function update(NationUpdateRequest $request, Nation $nation)
    {
        if (Gate::allows("edit")) {
            $dati = $request->validated();
            $nation->fill($dati);
            $nation->save();
            return new NationResource($nation);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Remove the specified Nation.
     */
    public function destroy(Nation $nation)
    {
        if (Gate::allows("delete")) {
            $nation->deleteOrFail();
            return response()->noContent();
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }
}
