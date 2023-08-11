<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books PDF</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
        }
    </style>
</head>
<body>
    <h1>Books List</h1>
    
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Price</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
            <tr>
                
                <td><img src="{{ public_path('storage/images/' . $book->image) }}" alt="{{ $book->title }}" width="100"></td>
                <td>{{ $book->title }}</td>
             
                </td>
                <td>{{ $book->author_name }}</td>
                <td>{{ $book->categories->implode('name', ', ') }}</td>
                <td>{{ $book->price }}</td>
                <td>{{ $book->description }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
