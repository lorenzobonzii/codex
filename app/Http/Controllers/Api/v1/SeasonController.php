<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeasonStoreRequest;
use App\Http\Requests\SeasonUpdateRequest;
use App\Http\Resources\SeasonCollection;
use App\Http\Resources\SeasonResource;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SeasonController extends Controller
{
    /**
     * Display a listing of the Season.
     */
    public function index(Request $request)
    {
        $request->validate([
            /** @query */
            'filters[]' => ["array"],
        ]);

        if(Gate::allows("read")){
            $risorsa = Season::filter()->sort()->get();
            return new SeasonCollection($risorsa);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Store a newly created Season.
     */
    public function store(SeasonStoreRequest $request)
    {
        if(Gate::allows("create")){
            $dati = $request->validated();
            $season = Season::create($dati);
            return new SeasonResource($season);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Display the specified Season.
     */
    public function show(Season $season)
    {
        if(Gate::allows("read")){
            return new SeasonResource($season);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Update the specified Season.
     */
    public function update(SeasonUpdateRequest $request, Season $season)
    {
        if(Gate::allows("edit")){
            $dati = $request->validated();
            $season->fill($dati);
            $season->save();
            return new SeasonResource($season);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Remove the specified Season.
     */
    public function destroy(Season $season)
    {
        if(Gate::allows("delete")){
            $season->deleteOrFail();
            return response()->noContent();
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }
}
