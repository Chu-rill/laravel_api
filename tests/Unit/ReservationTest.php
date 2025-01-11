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
        
        Event::assertDispatched(ReservationController::class);
        
        $response->assertJson([
            "msg" => "Reservation Created."
        ]);
        
        $this->assertDatabaseHas('reservations', [
            'id' => Reservation::first()->id,
            'user_id' => $user->id,
            'book_id' => $book->id,
            'reserved_at'=> now(),
            'due_date'=> now()->addWeek(),
            'status' => 'pending',
        ]);
    }

    // public function test_update_reservation()
    // {
    //     $reservation = Reservation::factory()->create();

    //     $reservation->update([
    //         'status' => 'completed',
    //     ]);

    //     $this->assertDatabaseHas('reservations', [
    //         'id' => $reservation->id,
    //         'status' => 'completed',
    //     ]);
    // }

    // public function test_delete_reservation()
    // {
    //     $reservation = Reservation::factory()->create();

    //     $reservation->delete();

    //     $this->assertDatabaseMissing('reservations', [
    //         'id' => $reservation->id,
    //     ]);
    // }

    // public function test_reservation_belongs_to_user()
    // {
    //     $reservation = Reservation::factory()->create();

    //     $this->assertInstanceOf(User::class, $reservation->user);
    // }

    // public function test_reservation_belongs_to_book()
    // {
    //     $reservation = Reservation::factory()->create();

    //     $this->assertInstanceOf(Book::class, $reservation->book);
    // }

    // public function test_create_book()
    // {
    //     $data = [
    //         'title' => 'Test Book',
    //         'author' => 'Test Author',
    //         'description' => 'Test Description',
    //         'published_year' => 2024,
    //         'borrowed' => false,
    //     ];

    //     $response = $this->postJson('/api/books', $data);

    //     $response->assertStatus(201)
    //              ->assertJson([
    //                  'data' => [
    //                      'title' => $data['title'],
    //                      'author' => $data['author'],
    //                  ],
    //              ]);

    //     $this->assertDatabaseHas('books', $data);
    // }

    // public function test_create_user()
    // {
    //     $data = [
    //         'name' => 'Test User',
    //         'email' => 'test@example.com',
    //         'password' => 'password',
    //         'password_confirmation' => 'password',
    //     ];

    //     $response = $this->postJson('/api/register', $data);

    //     $response->assertStatus(201)
    //              ->assertJson([
    //                  'message' => 'User created successfully',
    //                  'user' => [
    //                      'name' => $data['name'],
    //                      'email' => $data['email'],
    //                  ],
    //              ]);

    //     $this->assertDatabaseHas('users', [
    //         'name' => $data['name'],
    //         'email' => $data['email'],
    //     ]);
    // }
}