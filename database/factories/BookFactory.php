<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(){
        return [
            'title' => $this->faker->title,
            'author_id' => Author::factory(),
            'description' => $this->faker->paragraph,
            'published_date' => $this->faker->date,
        ];
    }
}
