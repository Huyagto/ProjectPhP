<?php
$backdrop = $movie["backdrop"]
    ? "https://image.tmdb.org/t/p/original{$movie['backdrop']}"
    : "https://image.tmdb.org/t/p/w500{$movie['poster']}";

$youtubeKey = $movie["trailer"] ?? null;
?>

<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/movie_detail.css">

<script>
const youtubeTrailerUrl = "https://www.youtube.com/embed/<?= $youtubeKey ?>?autoplay=1";
const baseUrl = "<?= BASE_URL ?>";
</script>


<div class="movie-hero" style="--bg:url('<?= $backdrop ?>')">
    <style>.movie-hero::before{background-image:url('<?= $backdrop ?>');}</style>

    <div class="hero-content">
        <div class="hero-title"><?= $movie["title"] ?></div>
        <div class="hero-info">
            <?= $movie["year"] ?> • <?= $movie["duration"] ?> phút • ⭐ <?= $movie["rating"] ?>
        </div>

        <button class="nf-btn play" onclick="showTrailer()">
            <i class="fa-solid fa-play"></i> Xem ngay
        </button>

        <button id="watchlist-btn" class="nf-btn more" onclick="toggleWatchlist(<?= $movie['id'] ?>)">
            <?= $isAdded ? "<i class='fa-solid fa-check'></i> Đã thêm" 
                         : "<i class='fa-solid fa-plus'></i> Thêm vào danh sách" ?>
        </button>
    </div>
</div>

<div class="details-section">
    <div class="details-desc">
        <?= nl2br($movie["description"]) ?>
    </div>

    <div class="suggest-title">Phim tương tự</div>

    <div class="suggest-grid">
        <?php foreach ($related_movies as $rm): ?>
            <?php
                $img = str_starts_with($rm["poster"], "/")
                    ? "https://image.tmdb.org/t/p/w500{$rm["poster"]}"
                    : BASE_URL . "/uploads/{$rm["poster"]}";
            ?>
            <a class="suggest-card" href="<?= BASE_URL ?>/movie/<?= $rm["id"] ?>">
                <img src="<?= $img ?>">
            </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- Trailer popup -->
<div id="trailerPopup" class="trailer-popup">
    <div class="close-trailer" onclick="closeTrailer()">&times;</div>

    <?php if ($youtubeKey): ?>
        <iframe id="trailerFrame" allowfullscreen></iframe>
    <?php else: ?>
        <h2 style="color:white">⛔ Chưa có trailer.</h2>
    <?php endif; ?>
</div>

<div id="toast" class="toast"></div>

<script src="<?= BASE_URL ?>/assets/js/movie_detail.js"></script>
