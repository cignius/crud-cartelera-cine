<?php

namespace Database\Seeders;

use App\Models\Movie;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 5) as $index) {
            $movie = new Movie();
            $movie->title = $faker->sentence;
            $movie->director = $faker->name;

            //Generate a random duration in the format '0h 00m'.
            $hours = str_pad($faker->numberBetween(0, 9), 1, '0', STR_PAD_LEFT);
            $minutes = str_pad($faker->numberBetween(0, 59), 2, '0', STR_PAD_LEFT);
            $movie->duration = $hours . 'h ' . $minutes . 'm';

            $movie->classification = $faker->randomElement(['aa', 'a', 'b', 'b15', 'c', 'd']);

            //Generate a random filename with 50 characters
            $randomToken = Str::random(40);
            $movie->image = $randomToken . '.jpg';

            $movie->start_exhibition = $faker->dateTimeBetween('-1 month', '+1 month');
            $movie->finish_exhibition = $faker->dateTimeBetween($movie->start_exhibition, '+3 months');

            $now = new \DateTime();
            if ($now < $movie->start_exhibition) {
                $movie->status = 'Preestreno';
            } elseif ($now >= $movie->start_exhibition && $now <= $movie->finish_exhibition) {
                $movie->status = 'En cartelera';
            } elseif ($now > $movie->finish_exhibition) {
                $movie->status = 'Fuera de Cartelera';
            }

            $movie->token = $randomToken;

            // Generate an image with specific dimensions and random colors. Use intervention
            $image = Image::canvas(1024, 720, $faker->hexColor);
            $image->save(public_path('movies/' . $randomToken . '.jpg'));

            $movie->save();
        }
    }
}
