<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Contact;
use App\Models\Municipality;
use App\Models\Nation;
use App\Models\Password;
use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use function PHPSTORM_META\map;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $person = Person::create([
            "nome" => "Admin",
            "cognome" => "Admin",
            "sesso" => 'M',
            "data_nascita" => "2004-08-13",
            "cf" => "BNZLNZ04M13A944B"
        ]);

        $user = User::create([
            "role_id" => 1,
            "user" => "admin@codex.it",
            "state_id" => 1,
            "person_id" => $person->id
        ]);

        Password::create([
            "user_id" => $user->id,
            "password" => hash("sha512", "Admin2024!")
        ]);

        Address::create([
            "person_id" => $person->id,
            "address_type_id" => 1,
            "indirizzo" => "Via Po",
            "civico" => "1",
            "municipality_id" => Municipality::where('comune', "Bologna")->first()->id,
            "CAP" => "40139",
            "nation_id" => Nation::where('nome', "Italia")->first()->id,
        ]);
        Contact::create([
            "person_id" => $person->id,
            "contact_type_id" => 1,
            "contatto" => "+39 1234567889",
        ]);



        $person = Person::create([
            "nome" => "User",
            "cognome" => "User",
            "sesso" => 'M',
            "data_nascita" => "2004-08-13",
            "cf" => "BNZLNZ04M13A944B"
        ]);

        $user = User::create([
            "role_id" => 2,
            "user" => "user@codex.it",
            "state_id" => 1,
            "person_id" => $person->id
        ]);

        Password::create([
            "user_id" => $user->id,
            "password" => hash("sha512", "User2024!")
        ]);

        Address::create([
            "person_id" => $person->id,
            "address_type_id" => 1,
            "indirizzo" => "Via Po",
            "civico" => "1",
            "municipality_id" => Municipality::where('comune', "Bologna")->first()->id,
            "CAP" => "40139",
            "nation_id" => Nation::where('nome', "Italia")->first()->id,
        ]);
        Contact::create([
            "person_id" => $person->id,
            "contact_type_id" => 1,
            "contatto" => "+39 1234567889",
        ]);
    }
}
