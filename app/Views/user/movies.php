<?php require __DIR__."/../layout/header.php"; ?>

<h2 class="section-title">🔥 Phim mới</h2>

<div class="movie-grid">

<?php foreach ($movies as $m): ?>

    <?php 
        $poster = $m["poster"]
            ? (str_starts_with($m["poster"], "/") 
                ? "https://image.tmdb.org/t/p/w500{$m['poster']}" 
                : BASE_URL . "/uploads/" . $m["poster"])
            : BASE_URL . "/assets/img/no-image.png";
    ?>

    <a href="<?= BASE_URL ?>/movie/<?= $m['id'] ?>" class="movie-card">
        <img src="<?= $poster ?>">
        <div class="movie-info">
            <div class="movie-title"><?= $m['title'] ?></div>
            <div class="movie-year"><?= $m['year'] ?></div>
        </div>
    </a>

<?php endforeach; ?>

</div>

<?php require __DIR__."/../layout/footer.php"; ?>
