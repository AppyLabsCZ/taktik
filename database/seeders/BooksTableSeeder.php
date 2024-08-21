<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();
        $authors = Author::all();

        for ($i = 0; $i < 20; $i++) {
            DB::table('books')->insert([
                'title' => $faker->sentence(3, true),
                'author_id' => $faker->randomElement($authors)->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
