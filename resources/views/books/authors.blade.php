@extends('books.layout')

@section('content')
  <div style="display:flex; justify-content:center; align-items:center;">
    <div class="card" style="width: 30rem; margin-top:10px;">
      <div class="card-header">
        Authors
      </div>
      <ul class="list-group list-group-flush">
        @foreach($authorNames as $name)
        <li class="list-group-item">{{$name}}</li>
        @endforeach
      </ul>
    </div>
  </div>

  <div class="d-flex justify-content-center align-items-center"  style="height:30rem;">
    <canvas id="authorBooksChart" width="100" height="100"></canvas>
</div>
  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const authorNames = @json($authorNames);
        const bookCounts = @json($booksCount);
        console.log(authorNames);
        console.log(bookCounts);
        var ctx = document.getElementById('authorBooksChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',

            data: {
                labels: authorNames,
                datasets: [{
                    label: 'Number of Books Published',
                    data: bookCounts,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection