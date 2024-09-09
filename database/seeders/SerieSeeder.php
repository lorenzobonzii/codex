<?php

namespace Database\Seeders;

use App\Models\Episode;
use App\Models\Genre;
use App\Models\Nation;
use App\Models\Season;
use App\Models\Serie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use OzdemirBurak\JsonCsv\File\Csv;

class SerieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $indici = ["", "2", "3", "4"];
        foreach ($indici as $indice) {
            $csv = new Csv(storage_path("app/csv/series" . $indice . ".csv"));
            $csv->setConversionKey('options', JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            $json = $csv->convert();
            //$json = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $json); //Aggiunto perchè come chiave veniva usato \ufeffid al posto di id
            $films = json_decode($json, true);
            foreach ($films as $film) {
                if (!isset($film["copertina"]["v"])  || !isset($film["copertina"]["o"]) || !isset($film["nation"]["iso"]))
                    continue;
                $nation = Nation::where("iso", $film["nation"]["iso"])->first();
                if (!$nation)
                    continue;
                $serie = Serie::create(
                    [
                        "titolo" => $film["titolo"],
                        "anno" => $film["anno"],
                        "regia" => $film["regia"] ?? "",
                        "attori" => $film["attori"] ?? "",
                        "trama" => $film["trama"] ?? "",
                        "lingua" => $film["lingua"] ?? "",
                        "copertina_v" => $film["copertina"]["v"], //copertina_v nel csv viene visto come copertina[v]
                        "copertina_o" => $film["copertina"]["o"], //copertina_o nel csv viene visto come copertina[o]
                        "anteprima" => $film["anteprima"] ?? "",
                        "nation_id" => $nation->id, //nation_iso nel csv viene visto come nation[iso]
                    ]
                );
                $genre_ids = explode(',', $film["genre"]["ids"]);
                $serie->genres()->sync($genre_ids);
                $stagioni = json_decode($film["stagioni"], true);
                foreach ($stagioni as $s) { //genre_ids nel csv viene visto come genre[ids]
                    $stagione = Season::create(
                        [
                            "titolo" => $s["titolo"],
                            "anno" => $s["anno"],
                            "trama" => $s["trama"] ?? "",
                            "ordine" => $s["ordine"] ?? "",
                            "copertina" => $s["copertina"] ?? "",
                            "serie_id" => $serie->id,
                        ]
                    );
                    $episodi = $s["episodi"];
                    foreach ($episodi as $e) { //genre_ids nel csv viene visto come genre[ids]
                        $episodio = Episode::create(
                            [
                                "titolo" => $e["titolo"],
                                "durata" => $e["durata"] ?? 0,
                                "descrizione" => $e["descrizione"] ?? "",
                                "ordine" => $e["ordine"] ?? "",
                                "copertina" => $e["copertina"] ?? "",
                                "season_id" => $stagione->id
                            ]
                        );
                    }
                }
            }
        }
    }
}
