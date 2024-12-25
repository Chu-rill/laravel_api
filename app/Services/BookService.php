<?php

namespace App\Services;

use App\Repositories\BookRepository;

class BookService
{
    protected $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    // Get all books
    public function getAllBooks()
    {
        return $this->bookRepository->getAll();
    }

    // Get a single book by ID
    public function getBookById($id)
    {
        return $this->bookRepository->findById($id);
    }

    // Create a new book
    public function createBook(array $data)
    {
        return $this->bookRepository->create($data);
    }

    // Update an existing book
    public function updateBook($id, array $data)
    {
        $book = $this->bookRepository->findById($id);

        if (!$book) {
            return null;
        }

        return $this->bookRepository->update($id, $data);
    }

    // Delete a book
    public function deleteBook($id)
    {
        $book = $this->bookRepository->findById($id);

        if (!$book) {
            return false;
        }

        return $this->bookRepository->delete($id);
    }
}
