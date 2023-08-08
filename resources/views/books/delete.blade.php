<!-- resources/views/books/delete.blade.php -->

@extends('books.layout')

@section('content')
    <div class="container">
        <h1>Confirm Book Deletion</h1>
        <p>Are you sure you want to delete the book: {{ $book->title }}?</p>
        <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
            <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
