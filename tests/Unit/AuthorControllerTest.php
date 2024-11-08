<?php

namespace Tests\Unit;

use App\Models\Author;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_all_authors(){
        Author::factory()->count(3)->create();
        $response = $this->get('/api/author');
        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_store_creates_an_author(){
        $author = Author::factory()->create();
        $response = $this->post('/api/author', $author->toArray());
        $response->assertStatus(201);
        $this->assertDatabaseHas('authors', $author->toArray());
    }

    public function test_show_returns_a_single_author(){
        $author = Author::factory()->create();
        $response = $this->get("/api/author/{$author->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $author->id,
            'name' => $author->name,
            'bio' => $author->bio,
        ]);
    }

    public function test_update_updates_an_author(){
        $author = Author::factory()->create();
        $updatedData = [
            'name' => 'Updated Name',
            'bio' => 'Update Bio'
        ];
        $response = $this->put("/api/author/{$author->id}", $updatedData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('authors', $updatedData);
    }

    public function test_destroy_deletes_an_author(){
        $author = Author::factory()->create();
        $response = $this->delete("/api/author/{$author->id}");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('authors', ['id' => $author->id]);
    }
}
