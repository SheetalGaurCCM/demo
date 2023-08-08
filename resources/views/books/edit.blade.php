<!-- resources/views/books/edit.blade.php -->

@extends('books.layout')

@section('content')
    <div class="container">
        <h1>Edit Book</h1>
        @include('books.form', ['formAction' => route('books.update', $book->id)])
    </div>
@endsection