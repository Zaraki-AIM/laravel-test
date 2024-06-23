<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BooksTableSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 50; $i++) {
            Book::create([
                'title' => 'Book Title ' . $i,
                'author' => 'Author ' . $i,
                'genre' => ['Science Fiction', 'Biography', 'Fantasy', 'History', 'Mystery'][rand(0, 4)],
                'published_date' => now()->subYears(rand(1, 10)),
                'status' => ['available', 'borrowed'][rand(0, 1)]
            ]);
        }
    }
}
