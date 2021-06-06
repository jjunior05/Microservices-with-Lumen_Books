<?php

namespace Database\Seeders;

use App\Models\Book;
use Database\Factories\BookFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Book::factory()->count(50)->create();
    }
}
