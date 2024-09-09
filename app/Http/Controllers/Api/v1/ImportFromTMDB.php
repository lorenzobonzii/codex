<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Genre;
use App\Http\Controllers\Controller;
use App\Http\Requests\GenreStoreRequest;
use App\Http\Requests\GenreUpdateRequest;
use App\Http\Resources\FilmCollection;
use App\Http\Resources\GenreResource;
use App\Http\Resources\GenreCollection;
use App\Http\Resources\SerieCollection;
use App\Models\Film;
use App\Models\Nation;
use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use OzdemirBurak\JsonCsv\File\Json;


class ImportFromTMDB extends Controller
{
    private $api_key = "eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJlODRlMWM1Y2Y2YmQ5MzBlYzk5YjZjMGMwNzkzYWZjMyIsIm5iZiI6MTcyMTkwMTc4MC45NDA0NDksInN1YiI6IjY2YTBiZTk1MTFkNjc3ZDkzMDI2MzZhZiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.LIZnAhhDCwX5wHszQ-QiWhosUtHf8m-4atZ4xQHVOYc";
    private $url_base = "https://api.themoviedb.org/3/";
    public function index(Request $request)
    {
        //$this->importGenresCsv();
        //$this->importFilmsCsv();
        $this->importSeriesCsv();
        /*$films = [];
        for ($i = 1; $i <= 1; $i++) {
            $get = $this->get($this->url_base . 'discover/movie?include_adult=false&include_video=false&language=it-IT&page=' . $i . '&primary_release_date.gte=2000-01-01&region=IT&sort_by=vote_count.desc')["results"];
            $films = array_merge($films, $get);
        }
        $films = array_map(function ($film) {
            $dettagli = $this->get($this->url_base . 'movie/' . $film['id'] . '?language=it_IT&append_to_response=videos,images,credits');
            echo json_encode($dettagli);
        }, $films);
        */
    }

    private function importFilmsCsv()
    {
        $films = [];
        for ($i = 1; $i <= 40; $i++) {
            //$get = $this->get($this->url_base . 'movie/popular?language=it-IT&page=' . $i . '&region=it')["results"];
            $get = $this->get($this->url_base . 'discover/movie?include_adult=false&include_video=false&language=it-IT&page=' . $i . '&primary_release_date.gte=2000-01-01&region=IT&sort_by=vote_count.desc')["results"];
            $films = array_merge($films, $get);
        }
        $films = array_map(function ($film) {
            $dettagli = $this->get($this->url_base . 'movie/' . $film['id'] . '?language=it_IT&append_to_response=videos,images,credits');
            //$dettagli = $this->get($this->url_base . 'movie/' . $film['id'] . '?language=it_IT');
            //          $credits = $this->get($this->url_base . 'movie/' . $film['id'] . '/credits?language=it_IT');
            //$anteprima = $this->get($this->url_base . 'movie/' . $film['id'] . '/videos?language=it_IT')["results"];;
            $credits = $dettagli["credits"];
            $anteprima = $dettagli["videos"]["results"];
            if (count($dettagli["spoken_languages"]) == 0)
                $lingua = " ";
            else
                $lingua = $dettagli['spoken_languages'][0]["name"];
            if (count($anteprima) > 0)
                $anteprima = $anteprima[0]["key"];
            else
                $anteprima = null;
            if (count($credits["crew"]) > 0)
                $regista = $credits["crew"][0]["name"];
            else
                $regista = '';
            $attori = '';
            for ($i = 0; $i < min(3, count($credits["cast"])); $i++) {
                if ($i > 0)
                    $attori .= ", ";
                $attori .= $credits["cast"][$i]["name"];
            }
            return array(
                'id' => $film['id'],
                'titolo' => $film['title'],
                'regia' => $regista,
                'anno' => Date("Y", strtotime($film['release_date'])),
                'durata' => $dettagli['runtime'],
                'lingua' => $lingua,
                'copertina_v' => $film['poster_path'],
                'copertina_o' => $film['backdrop_path'],
                'anteprima' => $anteprima,
                'attori' => $attori,
                'trama' => $film['overview'],
                'nation_iso' => $dettagli["origin_country"][0],
                'genre_ids' => join(",", $film["genre_ids"])
            );
        }, $films);
        echo json_encode($films);
        $this->array_csv($films, "/films.csv");
    }

    private function importSeriesCsv()
    {
        $films = [];
        for ($i = 16; $i <= 20; $i++) {
            //$get = $this->get($this->url_base . 'movie/popular?language=it-IT&page=' . $i . '&region=it')["results"];
            $get = $this->get($this->url_base . 'discover/tv?include_adult=false&language=it-IT&page=' . $i . '&first_air_date.gte=2000-01-01&sort_by=vote_count.desc')["results"];
            $films = array_merge($films, $get);
        }
        $films = array_map(function ($film) {
            $dettagli = $this->get($this->url_base . 'tv/' . $film['id'] . '?language=it_IT&append_to_response=videos,credits&include_video_language=it%2Cnull');
            //$dettagli = $this->get($this->url_base . 'movie/' . $film['id'] . '?language=it_IT');
            //          $credits = $this->get($this->url_base . 'movie/' . $film['id'] . '/credits?language=it_IT');
            //$anteprima = $this->get($this->url_base . 'movie/' . $film['id'] . '/videos?language=it_IT')["results"];;
            $credits = $dettagli["credits"];
            $anteprima = $dettagli["videos"]["results"];
            if (count($dettagli["spoken_languages"]) == 0)
                $lingua = " ";
            else
                $lingua = $dettagli['spoken_languages'][0]["name"];
            if (count($anteprima) > 0)
                $anteprima = $anteprima[0]["key"];
            else
                $anteprima = null;
            if (count($credits["crew"]) > 0)
                $regista = $credits["crew"][0]["name"];
            else
                $regista = '';
            $attori = '';
            for ($i = 0; $i < min(3, count($credits["cast"])); $i++) {
                if ($i > 0)
                    $attori .= ", ";
                $attori .= $credits["cast"][$i]["name"];
            }
            $stagioni = [];
            foreach ($dettagli["seasons"] as $s) {
                $stagione = [];
                $stagione["anno"] = Date("Y", strtotime($s['air_date']));
                $stagione["titolo"] = $s["name"];
                $stagione["trama"] = $s["overview"];
                $stagione["ordine"] = $s["season_number"];
                $stagione["copertina"] = $s["poster_path"];
                $dettagli_episodi = $this->get($this->url_base . 'tv/' . $film['id'] . "/season/" . $s["season_number"] . '?language=it_IT&append_to_response=videos,credits&include_video_language=it%2Cnull')["episodes"];
                $episodi = [];
                foreach ($dettagli_episodi as $e) {
                    $episodio = [];
                    $episodio["titolo"] = $e["name"];
                    $episodio["descrizione"] = $e["overview"];
                    $episodio["ordine"] = $e["episode_number"];
                    $episodio["durata"] = $e["runtime"];
                    $episodio["copertina"] = $e["still_path"];
                    $episodi[] = $episodio;
                }
                $stagione["episodi"] = $episodi;
                $stagioni[] = $stagione;
            }

            return array(
                'id' => $film['id'],
                'titolo' => $film['name'],
                'regia' => $regista,
                'anno' => Date("Y", strtotime($film['first_air_date'])),
                'lingua' => $lingua,
                'copertina_v' => $film['poster_path'],
                'copertina_o' => $film['backdrop_path'],
                'anteprima' => $anteprima,
                'attori' => $attori,
                'trama' => $film['overview'],
                'nation_iso' => $dettagli["origin_country"][0],
                'genre_ids' => join(",", $film["genre_ids"]),
                'stagioni' => json_encode($stagioni)
            );
        }, $films);
        $this->array_csv($films, "/series4.csv");
    }
    private function importGenresCsv()
    {
        $genres1 = $this->get($this->url_base . 'genre/movie/list?language=it');
        $genres2 = $this->get($this->url_base . 'genre/tv/list?language=it');
        $genres = $this->unique_multidim_array(array_merge($genres1["genres"],  $genres2["genres"]), "id");
        $this->ordina_array_oggetti($genres, "name");
        $genres = $this->change_key($genres, "name", "nome");
        $genres = array_map(function ($genre) {
            return array(
                'id' => $genre['id'],
                'nome' => $genre['name']
            );
        }, $genres);
        $this->array_csv($genres, "/genres.csv");
    }

    private function array_csv($array, $filename)
    {
        $json = new Json();
        $json->fromString(json_encode($array))->convert();
        //$csvString = (new Json())->fromString('{"name": "Buddha", "age": 80}')->convert();
        $json->setConversionKey('utf8_encoding', true);
        $json->convertAndSave(__DIR__ . "/../../../../../storage/app/csv" . $filename);
        //$json->convertAndDownload();
    }

    private function get($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers = array();
        $headers[] = 'Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJlODRlMWM1Y2Y2YmQ5MzBlYzk5YjZjMGMwNzkzYWZjMyIsIm5iZiI6MTcyMTkwMTc4MC45NDA0NDksInN1YiI6IjY2YTBiZTk1MTFkNjc3ZDkzMDI2MzZhZiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.LIZnAhhDCwX5wHszQ-QiWhosUtHf8m-4atZ4xQHVOYc';
        $headers[] = 'Accept: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            return null;
        } else {
            return json_decode($result, true);
        }
        curl_close($ch);
    }

    private function unique_multidim_array($array, $key)
    {
        $temp_array = array();
        $key_array = array();
        foreach ($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[] = $val[$key];
                $temp_array[] = $val;
            }
        }
        return $temp_array;
    }

    private function ordina_array_oggetti($array, $key)
    {
        return usort($array, function ($object1, $object2) use ($key) {
            return $object1[$key] > $object2[$key];
        });
    }

    private function change_key($arrays, $old_key, $new_key)
    {
        foreach ($arrays as $array) {
            if (!array_key_exists($old_key, $array))
                return $array;

            $keys = array_keys($array);
            $keys[array_search($old_key, $keys)] = $new_key;

            $array = array_combine($keys, $array);
        }
        return $arrays;
    }
}
