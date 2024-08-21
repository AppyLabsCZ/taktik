<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $books = Book::all();
        $authors = Author::all();
        $users = User::all();

        foreach ($books as $book) {
            // náhodně určíme, kolik recenzí vytvoříme pro danou knihu (0-3)
            $reviewsCount = rand(0, 3);
            for ($i = 0; $i < $reviewsCount; $i++) {
                DB::table('reviews')->insert([
                    'user_id' => $faker->randomElement($users)->id,
                    'body' => $faker->paragraph,
                    'rating' => $faker->numberBetween(1, 5),
                    'reviewable_id' => $book->id,
                    'reviewable_type' => Book::class,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        foreach ($authors as $author) {
            $reviewsCount = rand(0, 3);
            for ($i = 0; $i < $reviewsCount; $i++) {
                DB::table('reviews')->insert([
                    'user_id' => $faker->randomElement($users)->id,
                    'body' => $faker->paragraph,
                    'rating' => $faker->numberBetween(1, 5),
                    'reviewable_id' => $author->id,
                    'reviewable_type' => Author::class,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
