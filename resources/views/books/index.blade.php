<!-- resources/views/books/index.blade.php -->

@extends('books.layout')

@section('content')
    <div class="container">
        <h1>Books</h1>
        <div class="d-flex">
            <a href="{{ route('books.create') }}" class="btn btn-primary" style="margin:5px;">Add New Book</a>
            <form action="/search" method="get">
                <input type="text" name="author_name" placeholder="Search by Author" value="{{ isset($author_name)? $author_name : '' }}">
                <button type="submit" class="btn" style="background-color:#0d6efd;color:white;">Search</button>
            </form>

            <form action="/searchCategory" method="get">
                <select name="category_id" id="category_id" >
                <option value="">All</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">
                        {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn" style="background-color:#0d6efd;color:white;">Search</button>
            </form>
           

            
        </div>
        
      
        
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Price</th>
                    <th>Categories</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author_name }}</td>
                    <td>${{ number_format($book->price) }}</td>
                    <td>
                        @foreach($book->categories as $category)
                            {{ $category->name }} @if(!$loop->last),@endif
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-info">Edit</a>
                       
                        <button class="btn btn-sm btn-danger delete-button" data-book-id="{{ $book->id }}">Delete</button>
                        
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


<script>
    // your-script.js
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delete-button');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const bookId = button.getAttribute('data-book-id');

            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/books/${bookId}`)
                        .then(response => {
                            Swal.fire(
                                'Deleted!',
                                'The book has been deleted.',
                                'success'
                            );
                           
                        })
                        .catch(error => {
                            Swal.fire(
                                'Error!',
                                'An error occurred while deleting the book.',
                                'error'
                            );
                        });
                }
            });
        });
    });
});



</script>

@endsection
