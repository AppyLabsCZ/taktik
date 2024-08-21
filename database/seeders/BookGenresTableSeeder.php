<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Genre;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookGenresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $books = Book::all();
        $genres = Genre::all();

        foreach ($books as $book) {
            DB::table('book_genres')->insert([
                'book_id' => $book->id,
                'genre_id' => $faker->randomElement($genres)->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($faker->boolean(30)) {
                DB::table('book_genres')->insert([
                    'book_id' => $book->id,
                    'genre_id' => $faker->randomElement($genres)->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
