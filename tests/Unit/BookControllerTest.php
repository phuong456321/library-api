<?php
// Code by: @DEV_Phuong
namespace Tests\Unit;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_all_books(){
        Book::factory()->count(3)->create();
        $response = $this->get('/api/book');
        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_store_creates_a_book(){
        $bookData = [
            'title' => 'Test Book',
            'author_id' => Author::factory()->create()->id,
            'description' => 'Test Description',
            'published_date' => '2024-01-01',
        ];
        $response = $this->post('/api/book', $bookData);
        $response->assertStatus(201);
        $this->assertDatabaseHas('books', $bookData);
    }

    public function test_show_returns_a_book(){
        $book = Book::factory()->create();
        $response = $this->get('/api/book/' . $book->id);
        $response->assertStatus(200);
        $response->assertJson($book->toArray());
    }

    public function test_update_updates_a_book(){
        $book = Book::factory()->create();
        $updatedData = Book::factory()->make();
        $response = $this->put('/api/book/' . $book->id, $updatedData->toArray());
        $response->assertStatus(200);
        $this->assertDatabaseHas('books', $updatedData->toArray());
    }

    public function test_destroy_deletes_a_book(){
        $book = Book::factory()->create();
        $response = $this->delete('/api/book/' . $book->id);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

}
