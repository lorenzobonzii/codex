<?php

namespace Database\Seeders;

use App\Models\Capability;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CapabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Capability::create(["nome" => "read"]);
        Capability::create(["nome" => "edit"]);
        Capability::create(["nome" => "create"]);
        Capability::create(["nome" => "delete"]);

        $admin = Role::where('nome',"Admin")->first();
        $utente = Role::where('nome',"Utente")->first();

        $capability = Capability::where('nome',"read")->first();
        $capability->roles()->attach([$admin->id, $utente->id]);
        $capability = Capability::where('nome',"edit")->first();
        $capability->roles()->attach([$admin->id]);
        $capability = Capability::where('nome',"create")->first();
        $capability->roles()->attach([$admin->id]);
        $capability = Capability::where('nome',"delete")->first();
        $capability->roles()->attach([$admin->id]);

    }
}
