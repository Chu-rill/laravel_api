<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReservationResource;
use App\Services\ReservationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    
    protected $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    // Fetch all books
    public function index()
    {
        $reservation = $this->reservationService->getAllReservations();
        // return response()->json($books);
        return ReservationResource::collection($reservation);
    }

    // Fetch a single book
    public function show($id)
    {
        $reservation = $this->reservationService->getReservationById($id);

        if (!$reservation) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        return response()->json([
            "message"=> 'Book  found',
            "data"=> new ReservationResource($reservation) 
        ],200);
    }

    // Create a new book
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'book_id' => 'required',
            'reserved_at'=> 'sometimes|required',
            'due_date' => 'required',
        ]);

        $reservation = $this->reservationService->createReservation($validatedData);
        return response()->json([
            "message"=>"Reservation Created",
            "data"=> new ReservationResource($reservation)
        ], 201);
    }

        // Update an existing book
        public function update(Request $request, $id)
        {
            $validatedData = $request->validate([
                'user_id' => 'sometimes|required',
                'book_id' => 'sometimes|required',
                'reserved_at'=> 'sometimes|required',
                'due_date' => 'sometimes|required',
                'status'=> 'sometimes|required',
            ]);

            
    
            $reservation = $this->reservationService->updateReservation($id, $validatedData);
    
            if (!$reservation) {
                return response()->json(['message' => 'Reservation not found'], 404);
            }
    
            return response()->json([
                "message"=>"Reservation Updated",
                "data"=> new ReservationResource($reservation)
            ], 200);
        }
    
        // Delete a book
        public function destroy($id)
        {
            $result = $this->reservationService->deleteReservation($id);
    
            if (!$result) {
                return response()->json(['message' => 'Reservation not found'], 404);
            }
    
            return response()->json(['message' => 'Reservation deleted successfully']);
        }
}
