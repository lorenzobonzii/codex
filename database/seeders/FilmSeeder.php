<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Film;
use App\Models\Genre;
use App\Models\Nation;
use OzdemirBurak\JsonCsv\File\Csv;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // CSV to JSON
        $csv = new Csv(storage_path("app/csv/films.csv"));
        $csv->setConversionKey('options', JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $json = $csv->convert();
        //$json = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $json); //Aggiunto perchè come chiave veniva usato \ufeffid al posto di id
        $films = json_decode($json, true);
        foreach ($films as $film) {
            if (!isset($film["copertina"]["v"])  || !isset($film["copertina"]["o"]))
                continue;
            $new = Film::create(
                [
                    "titolo" => $film["titolo"],
                    "anno" => $film["anno"],
                    "durata" => $film["durata"],
                    "regia" => $film["regia"] ?? "",
                    "attori" => $film["attori"] ?? "",
                    "trama" => $film["trama"] ?? "",
                    "lingua" => $film["lingua"] ?? "",
                    "copertina_v" => $film["copertina"]["v"], //copertina_v nel csv viene visto come copertina[v]
                    "copertina_o" => $film["copertina"]["o"], //copertina_o nel csv viene visto come copertina[o]
                    "anteprima" => $film["anteprima"] ?? "",
                    "nation_id" => Nation::where("iso", $film["nation"]["iso"])->first()->id, //nation_iso nel csv viene visto come nation[iso]
                ]
            );
            $genre_ids = explode(',', $film["genre"]["ids"]);
            $new->genres()->sync($genre_ids);
        }
    }
}
