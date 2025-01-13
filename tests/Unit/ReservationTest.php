<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\ReservationController;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_reservation()
    {
        Event::fake();

        $user = User::factory()->create();
        $book = Book::factory()->create();

        $response = $this->json('POST', '/api/v1/reservations', [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'reserved_at' => now(),
            'due_date' => now()->addWeek(),
            'status' => 'pending',
        ]);

        $response->assertStatus(201)->assertJson([
            "message" => "Reservation Created",
            "data" => [
                "id" => $response->json('data.id'),
                "user_id" => (string) $user->id,
                "book_id" => (string) $book->id,
                "reserved_at" => now()->startOfSecond()->toJSON(),
                "due_date" => now()->addWeek()->startOfSecond()->toJSON(),
                "status" => "pending",
            ],
        ]);

        $this->assertDatabaseHas('reservations', [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'status' => 'pending',
        ]);
    }

    public function test_update_reservation()
    {
        Event::fake();

        $user = User::factory()->create();
        $book = Book::factory()->create();

        $reservation = Reservation::factory()->create();

        $response = $this->json('PUT', "/api/v1/reservations/{$reservation->id}", [
            'status' => 'completed',
        ]);

        $response->assertStatus(200)->assertJson([
            "message" => "Reservation Updated",
            "data" => [
                "id" => $response->json('data.id'),
                "user_id" => (string) $user->id,
                "book_id" => (string) $book->id,
                "reserved_at" => now()->startOfSecond()->toJSON(),
                "due_date" => now()->addWeek()->startOfSecond()->toJSON(),
                "status" => "completed",
            ],
        ]);

        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'status' => 'completed',
        ]);
    }

    public function test_delete_reservation()
    {
        $reservation = Reservation::factory()->create();

        $response = $this->json('DELETE', "/api/v1/reservations/3");

        $response->assertStatus(200)->assertJson([
            "message" => "Reservation deleted successfully",
        ]);

        $this->assertDatabaseMissing('reservations', [
            'id' => $reservation->id,
        ]);
    }

   

    public function test_create_book()
    {
        $data = [
            'title' => 'Test Book',
            'author' => 'Test Author',
            'description' => 'Test Description',
            'published_year' => 2024,
            'borrowed' => false,
        ];

        $response = $this->json('POST', '/api/v1/books', $data);

        $response->assertStatus(201)->assertJson([
            "message" => "Book Created",
            "data" => [
                "title" => $data['title'],
                "author" => $data['author'],
            ],
        ]);

        $this->assertDatabaseHas('books', $data);
    }

    public function test_create_user()
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->json('POST', '/api/v1/register', $data);

        $response->assertStatus(201)->assertJson([
            "message" => "User created successfully",
            "user" => [
                "name" => $data['name'],
                "email" => $data['email'],
            ],
        ]);

        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }
}
