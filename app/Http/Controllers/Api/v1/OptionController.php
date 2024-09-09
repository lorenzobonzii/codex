<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\OptionStoreRequest;
use App\Http\Requests\OptionUpdateRequest;
use App\Http\Resources\OptionCollection;
use App\Http\Resources\OptionResource;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OptionController extends Controller
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

        $risorsa = Option::filter()->sort()->get();
        return new OptionCollection($risorsa);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OptionStoreRequest $request)
    {
        if (Gate::allows("create")) {
            $dati = $request->validated();
            $option = Option::create($dati);
            return new OptionResource($option);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Option $option)
    {
        return new OptionResource($option);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OptionUpdateRequest $request, Option $option)
    {
        if (Gate::allows("edit")) {
            $dati = $request->validated();
            $option->fill($dati);
            $option->save();
            return new OptionResource($option);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Remove the specified Option.
     */
    public function destroy(Option $option)
    {
        if (Gate::allows("delete")) {
            $option->deleteOrFail();
            return response()->noContent();
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }
}
