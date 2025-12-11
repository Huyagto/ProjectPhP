<?php require __DIR__."/../layout/user.php"; ?>

<!-- HERO SLIDER -->
<div class="hero-slider">
    <div class="slide active" style="background-image: url('https://wallpapercave.com/wp/wp8814978.jpg');"></div>
    <div class="slide" style="background-image: url('https://wallpapercave.com/wp/wp7997552.jpg');"></div>
    <div class="slide" style="background-image: url('https://wallpapercave.com/wp/wp6220893.jpg');"></div>
    <div class="slide" style="background-image: url('https://wallpapercave.com/wp/wp5739890.jpg');"></div>
</div>
<script src="<?= BASE_URL ?>/assets/js/home-user.js"></script>
<!-- TOP 10 -->
<h2 class="section-title">🏆 Top 10 hôm nay</h2>

<div class="top10-row">
<?php foreach (array_slice($movies, 0, 10) as $i => $m): ?>

    <?php 
        $poster = str_starts_with($m["poster"], "/")
            ? "https://image.tmdb.org/t/p/w500{$m['poster']}"
            : BASE_URL . "/uploads/" . $m["poster"];
    ?>

    <div class="top10-card">
        <div class="rank"><?= $i+1 ?></div>
        <img src="<?= $poster ?>">
    </div>

<?php endforeach; ?>
</div>


<!-- MOVIE GRID -->
<h2 class="section-title">🔥 Phim mới cập nhật</h2>

<div class="movie-grid">

<?php foreach ($movies as $m): ?>

    <?php 
        $poster = str_starts_with($m["poster"], "/")
            ? "https://image.tmdb.org/t/p/w500{$m['poster']}"
            : BASE_URL . "/uploads/" . $m["poster"];
    ?>

    <a href="<?= BASE_URL ?>/movie/<?= $m['id'] ?>" class="movie-card">
        <img src="<?= $poster ?>">

        <div class="preview-popup">
            <div class="movie-title"><?= $m['title'] ?></div>
            <div class="movie-year"><?= $m['year'] ?></div>
            <div class="movie-extra">⭐ <?= $m['rating'] ?? "Chưa có đánh giá" ?></div>
        </div>
    </a>

<?php endforeach; ?>

</div>
</div> <!-- end nf-content -->

<footer class="nf-footer">
    MovieFlix © <?= date("Y") ?>
</footer>

</body>
</html>
