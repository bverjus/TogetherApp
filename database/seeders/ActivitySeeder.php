<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ActivitySeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('fr_BE');
        $categories = DB::table('categories')->pluck('id')->toArray();
        $users = DB::table('users')->pluck('id')->toArray();

        for ($i = 0; $i < 10; $i++) {
            $city = $faker->city;
            // Vérifier que la ville est en Belgique
            while ($faker->country != 'Belgique') {
                $city = $faker->city;
            }
            DB::table('activities')->insert([
                'title' => $faker->sentence,
                'place' => $city,
                'description' => $faker->text,
                'participants_max' => $faker->numberBetween(5, 20),
                'image' => $faker->imageUrl(),
                'date_activity' => $faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
                'category_id' => $faker->randomElement($categories),
                'user_id' => $faker->randomElement($users),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
