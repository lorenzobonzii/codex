<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Serie;
use App\Http\Controllers\Controller;
use App\Http\Requests\SerieStoreRequest;
use App\Http\Requests\SerieUpdateRequest;
use App\Http\Resources\SerieCollection;
use App\Http\Resources\SerieResource;
use App\Http\Resources\SerieResourceApi;
use App\Models\Episode;
use App\Models\Season;
use App\Models\SerieApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class SerieController extends Controller
{
    /**
     * Display a listing of the Serie.
     */
    public function index(Request $request)
    {
        $request->validate([
            /** @query */
            'filters[]' => ["array"],
        ]);

        if (Gate::allows("read")) {
            $risorsa = Serie::filter()->sort()->get();
            return new SerieCollection($risorsa);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Store a newly created Serie.
     */
    public function store(SerieStoreRequest $request)
    {
        if (Gate::allows("create")) {
            $dati = $request->validated();
            $serie = DB::transaction(function () use ($dati, $request) {
                $serie = new Serie();
                $serie->titolo = $dati["titolo"];
                $serie->anno = $dati["anno"];
                $serie->regia = $dati["regia"];
                $serie->attori = $dati["attori"];
                $serie->trama = $dati["trama"];
                $serie->lingua = $dati["lingua"];
                $serie->anteprima = $dati["anteprima"];
                $serie->nation_id = $dati["nation_id"];
                $serie->save();
                $serie->genres()->sync($dati["genres"]);
                if ($request->copertina_v)
                    $serie->setCopertinaVFromBase64($request->copertina_v);
                if ($request->copertina_o)
                    $serie->setCopertinaOFromBase64($request->copertina_o);
                if ($dati["seasons"]) {
                    foreach ($dati["seasons"] as $a) {
                        if ($a["id"]) {
                            $season = Season::find($a["id"]);
                            if (!$season)
                                $season = new Season();
                        } else
                            $season = new Season();
                        $season->titolo = $a["titolo"];
                        $season->ordine = $a["ordine"];
                        $season->anno = $a["anno"];
                        $season->trama = $a["trama"];
                        $season->serie_id = $serie->id;
                        $season->save();
                        if ($a["copertina"])
                            $season->setCopertinaFromBase64($a["copertina"]);
                        if ($a["episodes"]) {
                            foreach ($a["episodes"] as $b) {
                                if ($b["id"]) {
                                    $episode = Episode::find($b["id"]);
                                    if (!$episode)
                                        $episode = new Episode();
                                } else
                                    $episode = new Episode();
                                $episode->titolo = $b["titolo"];
                                $episode->ordine = $b["ordine"];
                                $episode->durata = $b["durata"];
                                $episode->descrizione = $b["descrizione"];
                                $episode->season_id = $season->id;
                                $episode->save();
                                if ($b["copertina"])
                                    $episode->setCopertinaFromBase64($b["copertina"]);
                            }
                        }
                    }
                }
                return $serie;
            });
            return new SerieResource($serie);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Display the specified Serie.
     */
    public function show(Serie $serie)
    {
        if (Gate::allows("read")) {
            return new SerieResourceApi($serie);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Update the specified Serie.
     */
    public function update(SerieUpdateRequest $request, Serie $serie)
    {
        if (Gate::allows("edit")) {
            $dati = $request->validated();
            $serie = DB::transaction(function () use ($dati, $serie, $request) {
                $serie->titolo = $dati["titolo"];
                $serie->anno = $dati["anno"];
                $serie->regia = $dati["regia"];
                $serie->attori = $dati["attori"];
                $serie->trama = $dati["trama"];
                $serie->lingua = $dati["lingua"];
                $serie->anteprima = $dati["anteprima"];
                $serie->nation_id = $dati["nation_id"];
                $serie->save();
                $serie->genres()->sync($dati["genres"]);
                if ($request->copertina_v)
                    $serie->setCopertinaVFromBase64($request->copertina_v);
                if ($request->copertina_o)
                    $serie->setCopertinaOFromBase64($request->copertina_o);
                $old_seasons_id = $serie->seasons->pluck('id')->toArray();
                $new_seasons_id = [];
                if ($dati["seasons"]) {
                    foreach ($dati["seasons"] as $a) {
                        if ($a["id"]) {
                            $season = Season::find($a["id"]);
                            if (!$season)
                                $season = new Season();
                            $new_seasons_id[] = $a["id"];
                        } else {
                            $season = new Season();
                        }
                        $season->titolo = $a["titolo"];
                        $season->ordine = $a["ordine"];
                        $season->anno = $a["anno"];
                        $season->trama = $a["trama"];
                        $season->serie_id = $serie->id;
                        $season->save();
                        if ($a["copertina"])
                            $season->setCopertinaFromBase64($a["copertina"]);
                        $old_episodes_id = $season->episodes->pluck('id')->toArray();
                        $new_episodes_id = [];
                        if ($a["episodes"]) {
                            foreach ($a["episodes"] as $b) {
                                if ($b["id"]) {
                                    $episode = Episode::find($b["id"]);
                                    if (!$episode)
                                        $episode = new Episode();
                                    $new_episodes_id[] = $b["id"];
                                } else {
                                    $episode = new Episode();
                                }
                                $episode->titolo = $b["titolo"];
                                $episode->ordine = $b["ordine"];
                                $episode->durata = $b["durata"];
                                $episode->descrizione = $b["descrizione"];
                                $episode->season_id = $season->id;
                                $episode->save();
                                if ($b["copertina"])
                                    $episode->setCopertinaFromBase64($b["copertina"]);
                            }
                        }
                        $episodes_deleted_id = array_diff($old_episodes_id, $new_episodes_id);
                        $episodes_delete = Episode::where('season_id', $season->id)->whereIn('id', $episodes_deleted_id)->get();
                        foreach ($episodes_delete as $e) {
                            $e->delete();
                        }
                    }
                }
                $seasons_deleted_id = array_diff($old_seasons_id, $new_seasons_id);
                $seasons_delete = Season::where('serie_id', $serie->id)->whereIn('id', $seasons_deleted_id)->get();
                foreach ($seasons_delete as $s) {
                    $s->episodes->delete();
                    $s->delete();
                }
                return $serie;
            });
            return new SerieResource($serie);
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }

    /**
     * Remove the specified Serie.
     */
    public function destroy(Serie $serie)
    {
        if (Gate::allows("delete")) {
            $serie->genres()->sync([]);
            foreach ($serie->seasons as $s) {
                $s->episodes()->delete();
            }
            $serie->seasons()->delete();
            $serie->deleteOrFail();
            return response()->noContent();
        } else {
            abort(403, "PERMISSION DENIED");
        }
    }
}
