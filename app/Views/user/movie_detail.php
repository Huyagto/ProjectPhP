<h1 style="color:white;"><?= $movie['title'] ?></h1>

<img src="https://image.tmdb.org/t/p/w500<?= $movie['poster_path'] ?>" 
     style="border-radius:10px; width:300px;">

<p style="color:white; max-width:700px;"><?= $movie['overview'] ?></p>

<p style="color:yellow;">⭐ Điểm đánh giá: <?= $movie['vote_average'] ?></p>
<p style="color:white;">Ngày chiếu: <?= $movie['release_date'] ?></p>
