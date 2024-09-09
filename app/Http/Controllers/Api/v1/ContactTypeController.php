<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactTypeStoreRequest;
use App\Http\Requests\ContactTypeUpdateRequest;
use App\Http\Resources\ContactTypeCollection;
use App\Http\Resources\ContactTypeResource;
use App\Models\ContactType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ContactTypeController extends Controller
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

        $risorsa = ContactType::filter()->sort()->get();
        return new ContactTypeCollection($risorsa);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactTypeStoreRequest $request)
    {
        if(Gate::allows("create")){
            $dati = $request->validated();
            $contactType = ContactType::create($dati);
            return new ContactTypeResource($contactType);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactType $contactType)
    {
        return new ContactTypeResource($contactType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContactTypeUpdateRequest $request, ContactType $contactType)
    {
        if(Gate::allows("edit")){
            $dati = $request->validated();
            $contactType->fill($dati);
            $contactType->save();
            return new ContactTypeResource($contactType);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Remove the specified ContactType.
     */
    public function destroy(ContactType $contactType)
    {
        if(Gate::allows("delete")){
            $contactType->deleteOrFail();
            return response()->noContent();
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }
}
