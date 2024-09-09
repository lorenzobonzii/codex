<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Genre;
use OzdemirBurak\JsonCsv\File\Csv;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csv = new Csv(storage_path("app/csv/genres.csv"));
        $csv->setConversionKey('options', JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $json = $csv->convert();
        $json = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $json); //Aggiunto perchè come chiave veniva usato \ufeffid al posto di id
        $genres = json_decode($json, true);
        foreach ($genres as $genre) {
            $genere = new Genre;
            $genere->id = $genre['id'];
            $genere->nome = $genre['nome'];
            $genere->save();
        }
    }
}
