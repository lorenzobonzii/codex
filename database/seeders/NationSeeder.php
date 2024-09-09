<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Nation;

class NationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csv = storage_path("app/csv/nazioni.csv");
        $file = fopen($csv, "r");
        while (($data = fgetcsv($file, 200, ",")) !== false) {
            Nation::create(
                [
                    "id" => $data[0],
                    "nome" => $data[1],
                    "continente" => $data[2],
                    "iso" => $data[3],
                    "iso3" => $data[4],
                    "prefisso_telefonico" => $data[5],
                ]
            );
        }
    }
}
