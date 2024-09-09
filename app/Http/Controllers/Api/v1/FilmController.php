<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Film;
use App\Http\Controllers\Controller;
use App\Http\Requests\FilmStoreRequest;
use App\Http\Requests\FilmUpdateRequest;
use App\Http\Resources\FilmCollection;
use App\Http\Resources\FilmResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class FilmController extends Controller
{
    /**
     * Display a listing of the Film.
     */
    public function index(Request $request)
    {
        $request->validate([
            /** @query */
            'filters[]' => ["array"],
        ]);

        if (Gate::allows("read")) {
            $risorsa = Film::filter()->sort()->get();
            return new FilmCollection($risorsa);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Store a newly created Film.
     */
    public function store(FilmStoreRequest $request)
    {
        if (Gate::allows("create")) {
            $dati = $request->validated();
            $film = DB::transaction(function () use ($dati, $request) {
                $film = new Film();
                $film->titolo = $dati["titolo"];
                $film->anno = $dati["anno"];
                $film->durata = $dati["durata"];
                $film->regia = $dati["regia"];
                $film->attori = $dati["attori"];
                $film->trama = $dati["trama"];
                $film->lingua = $dati["lingua"];
                $film->anteprima = $dati["anteprima"];
                $film->nation_id = $dati["nation_id"];
                $film->save();
                $film->genres()->sync($dati["genres"]);
                if ($request->copertina_v)
                    $film->setCopertinaVFromBase64($request->copertina_v);
                if ($request->copertina_o)
                    $film->setCopertinaOFromBase64($request->copertina_o);
                return $film;
            });
            return new FilmResource($film);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Display the specified Film.
     */
    public function show(Film $film)
    {
        if (Gate::allows("read")) {
            return new FilmResource($film);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Update the specified Film.
     */
    public function update(FilmUpdateRequest $request, Film $film)
    {
        if (Gate::allows("edit")) {
            $dati = $request->validated();
            $film = DB::transaction(function () use ($dati, $film, $request) {
                $film->titolo = $dati["titolo"];
                $film->anno = $dati["anno"];
                $film->durata = $dati["durata"];
                $film->regia = $dati["regia"];
                $film->attori = $dati["attori"];
                $film->trama = $dati["trama"];
                $film->lingua = $dati["lingua"];
                $film->anteprima = $dati["anteprima"];
                $film->nation_id = $dati["nation_id"];
                $film->save();
                $film->genres()->sync($dati["genres"]);
                if ($request->copertina_v)
                    $film->setCopertinaVFromBase64($request->copertina_v);
                if ($request->copertina_o)
                    $film->setCopertinaOFromBase64($request->copertina_o);
                return $film;
            });
            return new FilmResource($film);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Remove the specified Film.
     */
    public function destroy(Film $film)
    {
        if (Gate::allows("delete")) {
            $film->genres()->sync([]);
            $film->deleteOrFail();
            return response()->noContent();
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }
}
