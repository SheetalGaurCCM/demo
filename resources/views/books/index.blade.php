<!-- resources/views/books/index.blade.php -->

@extends('books.layout')

@section('content')
    <div class="container">
        <h1>Books</h1>
        <a href="{{ route('books.create') }}" class="btn btn-primary">Add New Book</a>
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
