<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       
        $faker = Faker::create();

        for ($i = 0; $i < 5; $i++) {
            DB::table('users')->insert([
                'pseudo' => $faker->unique()->userName,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'two_factor_secret' => null,
                'two_factor_confirmed_at' => null,
                'remember_token' => null,
                'current_team_id' => null,
                'profile_photo_path' => null,
                'short_description' => $faker->text(80),
                'long_description' => $faker->text(200),
                'country' => $faker->country,
                'city' => $faker->city,
                'date_naissance' => $faker->dateTimeBetween('-50 years', '-20 years'),
                'nom' => $faker->lastName,
                'prenom' => $faker->firstName,
                'rating' => $faker->numberBetween(0, 5),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
