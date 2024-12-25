<?php

namespace App\Repositories;

use App\Models\Book;

class BookRepository
{
    protected $model;

    public function __construct(Book $model)
    {
        $this->model = $model;
    }

    // Get all books
    public function getAll()
    {
        return $this->model->all();
    }

    // Find a book by ID
    public function findById($id)
    {
        return $this->model->find($id);
    }

    // Create a new book
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    // Update an existing book
    public function update($id, array $data)
    {
        $book = $this->findById($id);

        if ($book) {
            $book->update($data);
            return $book;
        }

        return null;
    }

    // Delete a book
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
