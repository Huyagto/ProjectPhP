<?php require __DIR__."/../layout/user.php"; ?>

<?php
$poster = str_starts_with($movie["poster"], "/")
    ? "https://image.tmdb.org/t/p/original{$movie['poster']}"
    : BASE_URL . "/uploads/" . $movie["poster"];
?> 

<style>
/* HERO BANNER */
.movie-hero {
    position: relative;
    height: 480px;
    background-image: url('<?= $poster ?>');
    background-size: cover;
    background-position: center;
}
.movie-hero::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, transparent, rgba(0,0,0,0.95));
}

.hero-content {
    position: absolute;
    bottom: 100px;
    left: 50px;
    max-width: 50%;
}

.hero-title {
    font-size: 48px;
    font-weight: 900;
    margin-bottom: 10px;
}
.hero-info {
    font-size: 16px;
    color: #ccc;
    margin-bottom: 20px;
}

.nf-btn {
    padding: 12px 26px;
    border-radius: 6px;
    font-size: 18px;
    cursor: pointer;
    border: none;
    font-weight: bold;
}
.nf-btn.play {
    background: white;
    color: black;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.45);
}
.nf-btn.more {
    background: rgba(255,255,255,0.3);
    color: white;
}

/* DESCRIPTION */
.details-section {
    padding: 40px 50px;
}

.details-desc {
    font-size: 18px;
    line-height: 1.6;
    max-width: 70%;
    margin-bottom: 30px;
}

/* RELATED MOVIES */
.suggest-title {
    font-size: 24px;
    margin-bottom: 20px;
}

.suggest-grid {
    display: flex;
    gap: 16px;
}
.suggest-card img {
    width: 160px;
    height: 240px;
    border-radius: 8px;
    object-fit: cover;
    transition: .3s;
}
.suggest-card img:hover {
    transform: scale(1.15);
}

/* TRAILER POPUP */
.trailer-popup {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.85);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}
.trailer-popup iframe {
    width: 900px;
    height: 500px;
    border: none;
    border-radius: 12px;
}
.close-trailer {
    position: absolute;
    top: 40px;
    right: 60px;
    font-size: 40px;
    color: white;
    cursor: pointer;
}
</style>

<!-- HERO BANNER -->
<div class="movie-hero">
    <div class="hero-content">

        <div class="hero-title"><?= $movie['title'] ?></div>

        <div class="hero-info">
            <?= $movie['year'] ?> • 
            <?= $movie['duration'] ?? '120' ?> phút • 
            ⭐ <?= $movie['rating'] ?? '7.5' ?>
        </div>

        <button class="nf-btn play" onclick="showTrailer()">
            <i class="fa-solid fa-play"></i> Xem ngay
        </button>

        <button class="nf-btn more">
            <i class="fa-solid fa-plus"></i> Thêm vào danh sách
        </button>

    </div>
</div>

<!-- DETAILS -->
<div class="details-section">

    <div class="details-desc">
        <?= nl2br($movie["description"] ?? "Chưa có mô tả cho phim này.") ?>
    </div>

    <h3 class="suggest-title">Phim tương tự</h3>

    <div class="suggest-grid">
        <?php foreach ($related_movies as $rm): ?>

            <?php 
                $p = str_starts_with($rm["poster"], "/")
                    ? "https://image.tmdb.org/t/p/w500{$rm['poster']}"
                    : BASE_URL . "/uploads/" . $rm["poster"];
            ?>

            <a href="<?= BASE_URL ?>/movie/<?= $rm['id'] ?>" class="suggest-card">
                <img src="<?= $p ?>" alt="">
            </a>

        <?php endforeach; ?>
    </div>

</div>

<!-- TRAILER POPUP -->
<div id="trailerPopup" class="trailer-popup">
    <div class="close-trailer" onclick="closeTrailer()">&times;</div>

    <?php if (!empty($youtubeKey)): ?>
        <iframe id="trailerFrame" src="" allowfullscreen></iframe>
    <?php else: ?>
        <h2 style="color:white">⛔ Phim này không có trailer.</h2>
    <?php endif; ?>
</div>

<script>
function showTrailer() {
    const popup = document.getElementById("trailerPopup");
    const frame = document.getElementById("trailerFrame");

    popup.style.display = "flex";

    <?php if (!empty($youtubeKey)): ?>
        frame.src = "https://www.youtube.com/embed/<?= $youtubeKey ?>?autoplay=1";
    <?php endif; ?>
}

function closeTrailer() {
    const popup = document.getElementById("trailerPopup");
    const frame = document.getElementById("trailerFrame");

    popup.style.display = "none";
    frame.src = ""; // stop video
}
</script>
