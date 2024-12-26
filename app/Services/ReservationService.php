<?php

namespace App\Services;

use App\Repositories\ReservationRepository;

class ReservationService{
    protected $ReservationRepository;

    public function __construct(ReservationRepository $ReservationRepository)
    {
        $this->ReservationRepository = $ReservationRepository;
    }
     // Get all reservations
     public function getAllReservations()
     {
         return $this->ReservationRepository->getAll();
     }
 
     // Get a single reservation by ID
     public function getReservationById($id)
     {
         return $this->ReservationRepository->findById($id);
     }
 
     // Create a new reservation
     public function createRservation(array $data)
     {
         return $this->ReservationRepository->create($data);
     }
 
     // Update an existing reservation
     public function updateRservation($id, array $data)
     {
         $book = $this->ReservationRepository->findById($id);
 
         if (!$book) {
             return null;
         }
 
         return $this->ReservationRepository->update($id, $data);
     }
 
     // Delete a reservation
     public function deleteRservation($id)
     {
         $book = $this->ReservationRepository->findById($id);
 
         if (!$book) {
             return false;
         }
 
         return $this->ReservationRepository->delete($id);
     }
}