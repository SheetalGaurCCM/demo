<!-- resources/views/books/create.blade.php -->

@extends('books.layout')

@section('content')
    <div class="container">
        <h1>Create a New Book</h1>
        @include('books.form',['formAction'=>route('books.store')])
    </div>
@endsection