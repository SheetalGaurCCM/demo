<?php

// app/Http/Controllers/BookController.php

namespace App\Http\Controllers;


use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\BookRequest;
use Illuminate\Support\Facades\Auth;
use App\Notifications\BookAdded;
use App\Imports\BookImport;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use Excel;

class BookController extends Controller
{
    
    // Display a listing of the books
    public function index(Request $request)
    {      
        $categories = Category::all();
        $uniqueAuthors = Book::where('user_id', Auth::id())->distinct('author_name')->pluck('author_name');

        $author_name = $request->input('author_name', null); 
        $category_id = $request->input('category_id', null); 

        $query = Book::where('user_id', Auth::id())
        ->when($author_name !== null, function($query)  use ($author_name){
            $query->where('author_name', 'like', "%$author_name%");
        })
        ->when($category_id !== null, function($query){
            $query->whereHas('categories', function ($query) use ($category_id) {
                $query->where('categories.id', $category_id);
            });
        }); 

        $books = $query->paginate(5);
        
        return view('books.index', compact('books', 'categories', 'author_name', 'category_id', 'uniqueAuthors'));
    }

    // Show the form for creating a new book
    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    public function authors(){
        $authors=Book::select('author_name',DB::raw('count(*) as books_count'))->groupby('author_name')->get();
        $authorNames=$authors->pluck('author_name');
        $booksCount=$authors->pluck('books_count');
        return view('books.authors',compact('authorNames','booksCount'));
    }

    // Store a newly created book in the database
    public function store(BookRequest $request)
    {
        
        $validatedData = $request->validated();
        
        if($request->hasFile('image')){
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            $path = $request->file('image')->storeAs('public/images', $fileNameToStore);
           
        } 

        $validatedData['image'] = $fileNameToStore;
        $book = Auth::user()->books()->create($validatedData);
        $book->categories()->attach($validatedData['category_name']??[]);
        $user=Auth::user();
        $user->notify(new BookAdded($book));
        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }

    public function import(Request $request)
    {
   

        $validator = Validator::make($request->all(), [
            'file' => 'file|mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/excel',
        ]);
    
        if ($validator->fails()) {
            // Validation failed, handle errors here
            return redirect()->back()->withErrors($validator);
        }

        Excel::import(new BookImport, $request->file);
        return redirect()->route('books.index')->with('success', 'Books Imported Successfully');
    }



    // Show the form for editing the specified book
    public function edit(Book $book)
    {
        $this->authorize('update',$book);
        $categories = Category::all(); 

        return view('books.edit', compact('book', 'categories'));
    }


    // Update the specified book in the database
    public function update(BookRequest $request, $id)
    {
        
        $book = Book::findOrFail($id);
        $this->authorize('update', $book);

        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $path = $request->file('image')->storeAs('public/images', $fileNameToStore);

            // Delete the previous image if it exists
            if ($book->image && Storage::exists('public/images/' . $book->image)) {
                Storage::delete('public/images/' . $book->image);
            }

            $validatedData['image'] = $fileNameToStore;
        }

        $book->update([
            'title' => $validatedData['title'],
            'author_name' => $validatedData['author_name'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'image' => $validatedData['image'], // Update the image field
        ]);

        $book->categories()->sync($validatedData['category_name'] ?? []);

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }


    // Remove the specified book from the database
    public function destroy($id)
    {


        try {
            
            $book = Book::findOrFail($id);
            $this->authorize('delete',$book);
            $book->categories()->detach();
            if ($book->image && Storage::exists('public/images/' . $book->image)) {
                Storage::delete('public/images/' . $book->image);
            }
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