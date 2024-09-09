<?php

namespace Database\Seeders;

use App\Models\ContactType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactType::create(["nome" => "Telefono"]);
        ContactType::create(["nome" => "Email"]);
        ContactType::create(["nome" => "Fax"]);
        ContactType::create(["nome" => "Sito web"]);
        ContactType::create(["nome" => "Instagram"]);
        ContactType::create(["nome" => "Facebook"]);
        ContactType::create(["nome" => "Linkedin"]);
    }
}
