<?php require __DIR__."/../layout/user.php"; ?>

<?php
// Detect poster or backdrop
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

/* CONTENT OVER HERO */
.hero-content {
    position: absolute;
    bottom: 40px;
    left: 50px;
    max-width: 50%;
}

.hero-title {
    font-size: 48px;
    font-weight: 900;
    margin-bottom: 10px;
}
.play-btn {
    background: white;
    color: black;
    padding: 13px 32px;
    border-radius: 4px;
    font-size: 18px;
    display: inline-flex;
    align-items: center;
    gap: 12px;
    font-weight: 600;
    box-shadow: 0 3px 8px rgba(0,0,0,.4);
}

.hero-info {
    font-size: 16px;
    color: #ccc;
    margin-bottom: 20px;
}

.nf-btn {
    padding: 12px 20px;
    border-radius: 6px;
    font-size: 16px;
    margin-right: 10px;
    cursor: pointer;
    font-weight: bold;
    border: none;
}
.nf-btn.play {
    background: #fff;
    color: #000;
    font-weight: bold;
    padding: 12px 26px;
    border-radius: 6px;
    font-size: 18px;
    display: inline-flex;
    align-items: center;
    gap: 10px;

    /* GIÚP NỔI LÊN */
    box-shadow: 0 4px 12px rgba(0,0,0,0.45);
    opacity: 1 !important;
}

.nf-btn.play:hover {
    background: #e6e6e6;
}

.nf-btn.more {
    background: rgba(255,255,255,0.3);
    color: white;
}

/* DESCRIPTION SECTION */
.details-section {
    padding: 40px 50px;
}

.details-desc {
    font-size: 18px;
    line-height: 1.6;
    margin-bottom: 30px;
    max-width: 70%;
}

/* SUGGESTED MOVIES */
.suggest-title {
    font-size: 24px;
    margin-bottom: 20px;
}

.suggest-grid {
    display: flex;
    gap: 16px;
    overflow-x: auto;
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

        <button class="nf-btn play">
            <i class="fa-solid fa-play"></i> Xem ngay
        </button>

        <button class="nf-btn more">
            <i class="fa-solid fa-plus"></i> Thêm vào danh sách
        </button>

    </div>
</div>


<!-- DETAILS SECTION -->
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
