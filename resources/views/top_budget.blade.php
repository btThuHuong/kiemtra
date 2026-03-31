<h2>Top 10 Movie Budget</h2>

@foreach($movies as $m)

<p>
Tên phim: {{ $m->movie_name }} <br>
Ngày phát hành: {{ $m->release_date }} <br>
Budget: {{ $m->budget }}
</p>

<hr>

@endforeach