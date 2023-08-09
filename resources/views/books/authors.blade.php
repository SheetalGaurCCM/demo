@extends('books.layout')

@section('content')
  <div style="display:flex; justify-content:center; align-items:center;">
    <div class="card" style="width: 30rem; margin-top:10px;">
      <div class="card-header">
        Authors
      </div>
      <ul class="list-group list-group-flush">
        @foreach($books as $book)
        <li class="list-group-item">{{$book->author_name}}</li>
        @endforeach
      </ul>
    </div>
  </div>
  
@endsection