<?php

namespace Database\Seeders;

use App\Models\Municipality;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MunicipalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csv = storage_path("app/csv/comuniItaliani.csv");
        $file = fopen($csv, "r");
        while (($data = fgetcsv($file, 200, ",")) !== false) {
            Municipality::create(
                [
                    "id" => $data[0],
                    "comune" => $data[1],
                    "regione" => $data[2],
                    "provincia" => $data[3],
                    "sigla" => $data[4],
                    "codice_belfiore" => $data[5],
                    "cap" => $data[8],
                ]
            );
        }
    }
}
