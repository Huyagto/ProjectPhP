<?php require __DIR__."/../layout/header.php"; ?>
<form action="<?= BASE_URL ?>/search" method="GET">
    <input type="text" name="q" placeholder="Tìm phim..." 
           style="padding:6px 10px; border-radius:6px;">
</form>

<style>
.movie-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 22px;
    padding: 30px 40px;
}
.movie-card {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    transition: transform .25s ease;
}
.movie-card:hover {
    transform: scale(1.12);
}
.movie-card img {
    width: 100%;
    height: 260px;
    object-fit: cover;
}
.movie-info {
    position: absolute;
    bottom: 0;
    width: 100%;
    padding: 10px;
    background: linear-gradient(to top, rgba(0,0,0,0.85), transparent);
    opacity: 0;
    transition: .3s;
}
.movie-card:hover .movie-info { opacity: 1; }
.movie-title { font-weight: bold; font-size: 16px; }
.movie-year { font-size: 12px; color:#ccc; }
</style>

<h2 style="color:white; margin-left:40px;">🔥 Phim mới</h2>

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

