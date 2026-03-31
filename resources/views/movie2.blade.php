@foreach($movies as $index => $movie)
    {{ $index + 1 }}. Tên phim: {{ $movie->movie_name }} | Ngày phát hành: {{ $movie->release_date }} | Điểm bình chọn: {{ $movie->vote_average }} <br>
@endforeach