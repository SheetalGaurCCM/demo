<?php

// app/Http/Controllers/BookController.php

namespace App\Http\Controllers;


use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CustomRequest;

class BookController extends Controller
{
    // Display a listing of the books
    public function index()
    {
        $books = Book::all();
        return view('books.index', compact('books'));
    }

    // Show the form for creating a new book
    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    // Store a newly created book in the database
    public function store(CustomRequest $request)
    {
        

        $book = Book::create([
            'title' =>$request->input('title'),
            'author_name' =>$request->input('author_name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
        ]);

        $book->categories()->attach($request->input('category_name',[]));

        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }

    // Show the form for editing the specified book
    public function edit(Book $book)
    {
        $categories = Category::all(); 

        return view('books.edit', compact('book', 'categories'));
    }


    // Update the specified book in the database
    public function update(CustomRequest $request, $id)
    {
        

        $book = Book::findOrFail($id);

        $book->update([
            'title' => $request->input('title'),
            'author_name' => $request->input('author_name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
        ]);

        $book->categories()->sync( $request->input('category_name',[]));

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    // Remove the specified book from the database
    public function destroy($id)
    {


        try {
            $book = Book::findOrFail($id);
            $book->categories()->detach();

        // Delete the book
        $book->delete();
    
            // Return a response indicating success
            return response()->json(['message' => 'Book deleted successfully']);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            // Return a response indicating failure
            return response()->json(['message' => 'Failed to delete book'], 500);
        }
    }
}