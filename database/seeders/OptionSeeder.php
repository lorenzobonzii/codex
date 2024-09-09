<?php

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Console\OptimizeCommand;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Option::create(["chiave" => "durata_sessione", "valore" => 120000]);
        Option::create(["chiave" => "durata_sfida", "valore" => 120]);
        Option::create(["chiave" => "max_tentativi", "valore" => 5]);
        Option::create(["chiave" => "storico_password", "valore" => 3]);
        Option::create(["chiave" => "durata_password", "valore" => 60 * 60 * 24 * 90]);
    }
}
