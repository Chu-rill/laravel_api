<?php

namespace App\Services;

use App\Repositories\ReservationRepository;

class ReservationService{
    protected $reservationRepository;

    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }
     // Get all reservations
     public function getAllReservations()
     {
         return $this->reservationRepository->getAll();
     }
 
     // Get a single reservation by ID
     public function getReservationById($id)
     {
         return $this->reservationRepository->findById($id);
     }
 
     // Create a new reservation
     public function createReservation(array $data)
     {
         return $this->reservationRepository->create($data);
     }
 
     // Update an existing reservation
     public function updateReservation($id, array $data)
     {
         $book = $this->reservationRepository->findById($id);
 
         if (!$book) {
             return null;
         }
 
         return $this->reservationRepository->update($id, $data);
     }
 
     // Delete a reservation
     public function deleteReservation($id)
     {
         $book = $this->reservationRepository->findById($id);
 
         if (!$book) {
             return false;
         }
 
         return $this->reservationRepository->delete($id);
     }
}