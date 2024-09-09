<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(
            [
                OptionSeeder::class,
                RoleSeeder::class,
                StateSeeder::class,
                CapabilitySeeder::class,
                NationSeeder::class,
                MunicipalitySeeder::class,
                AddressTypeSeeder::class,
                ContactTypeSeeder::class,
                UserSeeder::class,
                GenreSeeder::class,
                FilmSeeder::class,
                SerieSeeder::class,
            ]
        );
    }
}
