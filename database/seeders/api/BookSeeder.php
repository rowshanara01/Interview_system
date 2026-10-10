<?php

namespace Database\Seeders\api;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        // Get user IDs
        $johnDoe = User::where('email', 'imalbab1@gmail.com')->first();
        $alice = User::where('email', 'alice@example.com')->first();
        $bob = User::where('email', 'bob@example.com')->first();
        $charlie = User::where('email', 'charlie@example.com')->first();

        // Create books for each user
        if ($johnDoe) {
            Book::create([
                'title' => 'The Great Gatsby',
                'author' => 'F. Scott Fitzgerald',
                'description' => 'A classic American novel about the Jazz Age',
                'user_id' => $johnDoe->id
            ]);

            Book::create([
                'title' => 'To Kill a Mockingbird',
                'author' => 'Harper Lee',
                'description' => 'A gripping tale of racial injustice',
                'user_id' => $johnDoe->id
            ]);
        }

        if ($alice) {
            Book::create([
                'title' => '1984',
                'author' => 'George Orwell',
                'description' => 'A dystopian social science fiction novel',
                'user_id' => $alice->id
            ]);

            Book::create([
                'title' => 'Pride and Prejudice',
                'author' => 'Jane Austen',
                'description' => 'A romantic novel of manners',
                'user_id' => $alice->id
            ]);
        }

        if ($bob) {
            Book::create([
                'title' => 'The Catcher in the Rye',
                'author' => 'J.D. Salinger',
                'description' => 'A story about teenage rebellion and angst',
                'user_id' => $bob->id
            ]);

            Book::create([
                'title' => 'Brave New World',
                'author' => 'Aldous Huxley',
                'description' => 'A dystopian novel set in a futuristic World State',
                'user_id' => $bob->id
            ]);
        }

        if ($charlie) {
            Book::create([
                'title' => 'The Lord of the Rings',
                'author' => 'J.R.R. Tolkien',
                'description' => 'An epic high-fantasy novel',
                'user_id' => $charlie->id
            ]);

            Book::create([
                'title' => 'Harry Potter and the Sorcerer\'s Stone',
                'author' => 'J.K. Rowling',
                'description' => 'The first novel in the Harry Potter series',
                'user_id' => $charlie->id
            ]);
        }
    }
}
