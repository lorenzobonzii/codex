<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\EpisodeStoreRequest;
use App\Http\Requests\EpisodeUpdateRequest;
use App\Http\Resources\EpisodeCollection;
use App\Http\Resources\EpisodeResource;
use App\Models\Episode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EpisodeController extends Controller
{
    /**
     * Display a listing of the Episode.
     */
    public function index(Request $request)
    {
        $request->validate([
            /** @query */
            'filters[]' => ["array"],
        ]);

        if(Gate::allows("read")){
            $risorsa = Episode::filter()->sort()->get();
            return new EpisodeCollection($risorsa);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Store a newly created Episode.
     */
    public function store(EpisodeStoreRequest $request)
    {
        if(Gate::allows("create")){
            $dati = $request->validated();
            $episode = Episode::create($dati);
            return new EpisodeResource($episode);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Display the specified Episode.
     */
    public function show(Episode $episode)
    {
        if(Gate::allows("read")){
            return new EpisodeResource($episode);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Update the specified Episode.
     */
    public function update(EpisodeUpdateRequest $request, Episode $episode)
    {
        if(Gate::allows("edit")){
            $dati = $request->validated();
            $episode->fill($dati);
            $episode->save();
            return new EpisodeResource($episode);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Remove the specified Episode.
     */
    public function destroy(Episode $episode)
    {
        if(Gate::allows("delete")){
            $episode->deleteOrFail();
            return response()->noContent();
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }
}
