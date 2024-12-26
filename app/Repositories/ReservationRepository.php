<?php

namespace App\Repositories;

use App\Models\Reservation;

class ReservationRepository {
    protected $model;

    public function __construct(Reservation $model)
    {
        $this->model = $model;
    }
     // Get all reservations
     public function getAll()
     {
         return $this->model->all();
     }
 
     // Find a reservation by ID
     public function findById($id)
     {
         return $this->model->find($id);
     }
 
     // Create a new reservation
     public function create(array $data)
     {
         return $this->model->create($data);
     }
 
     // Update an existing reservation
     public function update($id, array $data)
     {
         $book = $this->findById($id);
 
         if ($book) {
             $book->update($data);
             return $book;
         }
 
         return null;
     }
 
     // Delete a reservation
     public function delete($id)
     {
         $book = $this->findById($id);
 
         if ($book) {
             $book->delete();
             return true;
         }
 
         return false;
     }
}