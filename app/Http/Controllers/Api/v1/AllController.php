<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Film;
use App\Models\Serie;
use App\Http\Controllers\Controller;
use App\Http\Resources\FilmCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AllController extends Controller
{
  /**
   * Display a listing of Films and Series.
   */
  public function index(Request $request)
  {
    $request->validate([
      /** @query */
      'filters[]' => ["array"],
    ]);

    if (Gate::allows("read")) {
      $film = Film::all();
      $serie = Serie::all();
      $collection = $film->merge($serie)->all();
      return new FilmCollection($collection);
    } else {
      abort(403, "PERMISSION DENIED");
    }
  }
}
