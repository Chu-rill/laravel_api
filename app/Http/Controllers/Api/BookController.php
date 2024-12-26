<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    // Fetch all books
    public function index()
    {
        $books = $this->bookService->getAllBooks();
        // return response()->json($books);
        return BookResource::collection($books);
    }

    // Fetch a single book
    public function show($id)
    {
        $book = $this->bookService->getBookById($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        return response()->json([
            "message"=> 'Book  found',
            "data"=> new BookResource($book) 
        ],200);
    }

    // Create a new book
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'author' => 'required',
            'description'=> 'required',
            'published_year' => 'required|integer',
        ]);

        $book = $this->bookService->createBook($validatedData);
        return response()->json([
            "message"=>"Book Created",
            "data"=> new BookResource($book)
        ], 201);
    }

    // Update an existing book
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'sometimes|required',
            'author' => 'sometimes|required',
            'borrowed'=> 'sometimes|required|boolean',
            'published_year' => 'sometimes|required|integer',
        ]);

        $book = $this->bookService->updateBook($id, $validatedData);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        return response()->json([
            "message"=>"Book Updated",
            "data"=> new BookResource($book)
        ], 200);
    }

    // Delete a book
    public function destroy($id)
    {
        $result = $this->bookService->deleteBook($id);

        if (!$result) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        return response()->json(['message' => 'Book deleted successfully']);
    }
}
