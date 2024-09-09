<?php

use App\Http\Controllers\Api\v1\AddressController;
use App\Http\Controllers\Api\v1\AddressTypeController;
use App\Http\Controllers\Api\v1\AllController;
use App\Http\Controllers\Api\v1\CapabilityController;
use App\Http\Controllers\Api\v1\ContactController;
use App\Http\Controllers\Api\v1\ContactTypeController;
use App\Http\Controllers\Api\v1\EpisodeController;
use App\Http\Controllers\Api\v1\NationController;
use App\Http\Controllers\Api\v1\GenreController;
use App\Http\Controllers\Api\v1\FilmController;
use App\Http\Controllers\Api\v1\ImportFromTMDB;
use App\Http\Controllers\Api\v1\LoginController;
use App\Http\Controllers\Api\v1\SignupController;
use App\Http\Controllers\Api\v1\MunicipalityController;
use App\Http\Controllers\Api\v1\SerieController;
use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\Api\v1\OptionController;
use App\Http\Controllers\Api\v1\ProvinceController;
use App\Http\Controllers\Api\v1\RoleController;
use App\Http\Controllers\Api\v1\SeasonController;
use App\Http\Controllers\Api\v1\StateController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

if (!defined('_VERS')) {
    define('_VERS', 'v1');
}

Route::get(_VERS . '/import-from-tmdb', [ImportFromTMDB::class, 'index']);

//REGISTRAZIONE
Route::post(_VERS . '/signup', [SignupController::class, 'signup']);

//LOGIN
Route::post(_VERS . '/login', [LoginController::class, 'login']);

//VERIFICA TOKEN
Route::get(_VERS . '/verifyToken', [LoginController::class, 'verifyToken']);

//CONFIGURAZIONE
Route::get(_VERS . '/options', [OptionController::class, 'index']);
Route::get(_VERS . '/options/{option}', [OptionController::class, 'show']);

//TIPOLOGIA INDIRIZZI
Route::get(_VERS . '/addressTypes', [AddressTypeController::class, 'index']);
Route::get(_VERS . '/addressTypes/{addressType}', [AddressTypeController::class, 'show']);

//TIPOLOGIA RECAPITI
Route::get(_VERS . '/contactTypes', [ContactTypeController::class, 'index']);
Route::get(_VERS . '/contactTypes/{contactType}', [ContactTypeController::class, 'show']);

//NAZIONI
Route::get(_VERS . '/nations', [NationController::class, 'index']);
Route::get(_VERS . '/nations/{nation}', [NationController::class, 'show']);

//COMUNI
Route::get(_VERS . '/municipalities', [MunicipalityController::class, 'index']);
Route::get(_VERS . '/municipalities/{municipality}', [MunicipalityController::class, 'show']);

//PROVINCE
Route::get(_VERS . '/provinces', [ProvinceController::class, 'index']);
Route::get(_VERS . '/provinces/{province:sigla}', [ProvinceController::class, 'show']);

//STATI UTENTE
Route::get(_VERS . '/states', [StateController::class, 'index']);
Route::get(_VERS . '/states/{state}', [StateController::class, 'show']);

//RUOLI UTENTE
Route::get(_VERS . '/roles', [RoleController::class, 'index']);
Route::get(_VERS . '/roles/{role}', [RoleController::class, 'show']);

//ABILITA' UTENTE
Route::get(_VERS . '/capabilities', [CapabilityController::class, 'index']);
Route::get(_VERS . '/capabilities/{capability}', [CapabilityController::class, 'show']);

/////////////////////////////////////////////////////////////////////////////////////////////////////////

//UTENTE
Route::middleware(['authentication', 'userrole:Utente,Admin'])->group(function () {
    //TOKEN
    Route::post(_VERS . '/token', [LoginController::class, 'verificaToken']);

    //UTENTE
    Route::get(_VERS . '/users/{user}', [UserController::class, 'show']);
    Route::put(_VERS . '/users/{user}', [UserController::class, 'update']);

    //PROFILE
    Route::put(_VERS . '/profile/{user}', [SignupController::class, 'update']);

    //INDIRIZZO
    Route::get(_VERS . '/addresses/{address}', [AddressController::class, 'show']);
    Route::put(_VERS . '/addresses/{address}', [AddressController::class, 'update']);
    Route::post(_VERS . '/addresses', [AddressController::class, 'store']);

    //RECAPITO
    Route::get(_VERS . '/contacts/{contact}', [ContactController::class, 'show']);
    Route::put(_VERS . '/contacts/{contact}', [ContactController::class, 'update']);
    Route::post(_VERS . '/contacts', [ContactController::class, 'store']);

    //GENERI
    Route::get(_VERS . '/genres', [GenreController::class, 'index']);
    Route::get(_VERS . '/genres/{genre}', [GenreController::class, 'show']);
    Route::get(_VERS . '/genres/{genre}/films', [GenreController::class, 'showFilms']);
    Route::get(_VERS . '/genres/{genre}/series', [GenreController::class, 'showSeries']);

    //TUTTO (FILM + SERIE)
    Route::get(_VERS . '/all', [AllController::class, 'index']);

    //FILM
    Route::get(_VERS . '/films', [FilmController::class, 'index']);
    Route::get(_VERS . '/films/{film}', [FilmController::class, 'show']);

    //SERIE
    Route::get(_VERS . '/series', [SerieController::class, 'index']);
    Route::get(_VERS . '/series/{serie}', [SerieController::class, 'show']);

    //STAGIONI
    Route::get(_VERS . '/seasons', [SeasonController::class, 'index']);
    Route::get(_VERS . '/seasons/{season}', [SeasonController::class, 'show']);

    //EPISODI
    Route::get(_VERS . '/episodes', [EpisodeController::class, 'index']);
    Route::get(_VERS . '/episodes/{episode}', [EpisodeController::class, 'show']);
});

/////////////////////////////////////////////////////////////////////////////////////////////////////////

//ADMIN
Route::middleware(['authentication', 'userrole:Admin'])->group(function () {
    //UTENTI
    Route::get(_VERS . '/users', [UserController::class, 'index']);
    Route::post(_VERS . '/users', [UserController::class, 'store']);
    Route::delete(_VERS . '/users/{user}', [UserController::class, 'destroy']);

    //GENERI
    Route::post(_VERS . '/genres', [GenreController::class, 'store']);
    Route::put(_VERS . '/genres/{genre}', [GenreController::class, 'update']);
    Route::delete(_VERS . '/genres/{genre}', [GenreController::class, 'destroy']);

    //FILM
    Route::post(_VERS . '/films', [FilmController::class, 'store']);
    Route::put(_VERS . '/films/{film}', [FilmController::class, 'update']);
    Route::delete(_VERS . '/films/{film}', [FilmController::class, 'destroy']);

    //SERIE
    Route::post(_VERS . '/series', [SerieController::class, 'store']);
    Route::put(_VERS . '/series/{serie}', [SerieController::class, 'update']);
    Route::delete(_VERS . '/series/{serie}', [SerieController::class, 'destroy']);

    //STAGIONI
    Route::post(_VERS . '/seasons', [SeasonController::class, 'store']);
    Route::put(_VERS . '/seasons/{season}', [SeasonController::class, 'update']);
    Route::delete(_VERS . '/seasons/{season}', [SeasonController::class, 'destroy']);

    //EPISODI
    Route::post(_VERS . '/episodes', [EpisodeController::class, 'store']);
    Route::put(_VERS . '/episodes/{episode}', [EpisodeController::class, 'update']);
    Route::delete(_VERS . '/episodes/{episode}', [EpisodeController::class, 'destroy']);

    //INDIRIZZI
    Route::get(_VERS . '/addresses', [AddressController::class, 'index']);
    Route::delete(_VERS . '/addresses/{address}', [AddressController::class, 'destroy']);

    //RECAPITI
    Route::get(_VERS . '/contacts', [ContactController::class, 'index']);
    Route::delete(_VERS . '/contacts/{contact}', [ContactController::class, 'destroy']);

    //NAZIONI
    Route::post(_VERS . '/nations', [NationController::class, 'store']);
    Route::put(_VERS . '/nations/{nation}', [NationController::class, 'update']);
    Route::delete(_VERS . '/nations/{nation}', [NationController::class, 'destroy']);

    //COMUNI
    Route::post(_VERS . '/municipalities', [MunicipalityController::class, 'store']);
    Route::put(_VERS . '/municipalities/{municipality}', [MunicipalityController::class, 'update']);
    Route::delete(_VERS . '/municipalities/{municipality}', [MunicipalityController::class, 'destroy']);

    //OPZIONI
    Route::post(_VERS . '/options', [OptionController::class, 'store']);
    Route::put(_VERS . '/options/{option}', [OptionController::class, 'update']);
    Route::delete(_VERS . '/options/{option}', [OptionController::class, 'destroy']);
});
