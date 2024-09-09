<?php

namespace Database\Seeders;

use App\Models\AddressType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AddressType::create(["nome" => "Residenza"]);
        AddressType::create(["nome" => "Domicilio"]);
        AddressType::create(["nome" => "Indirizzo Spedizioni"]);
        AddressType::create(["nome" => "Ufficio"]);
        AddressType::create(["nome" => "Sede legale"]);
        AddressType::create(["nome" => "Sede operativa"]);
    }
}
