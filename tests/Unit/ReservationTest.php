<?php

namespace Tests\Unit;

use App\Models\Reservation;
use App\Models\User;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_reservation()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $reservation = Reservation::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'reserved_at' => now(),
            'due_date' => now()->addWeek(),
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('reservations', [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'status' => 'pending',
        ]);
    }

    public function test_update_reservation()
    {
        $reservation = Reservation::factory()->create();

        $reservation->update([
            'status' => 'completed',
        ]);

        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'status' => 'completed',
        ]);
    }

    public function test_delete_reservation()
    {
        $reservation = Reservation::factory()->create();

        $reservation->delete();

        $this->assertDatabaseMissing('reservations', [
            'id' => $reservation->id,
        ]);
    }

    public function test_reservation_belongs_to_user()
    {
        $reservation = Reservation::factory()->create();

        $this->assertInstanceOf(User::class, $reservation->user);
    }

    public function test_reservation_belongs_to_book()
    {
        $reservation = Reservation::factory()->create();

        $this->assertInstanceOf(Book::class, $reservation->book);
    }
}