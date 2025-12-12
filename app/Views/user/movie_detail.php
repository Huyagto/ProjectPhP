<?php require __DIR__."/../layout/user.php"; ?>

<?php
// Poster chính
$backdrop = !empty($movie["backdrop"])
    ? "https://image.tmdb.org/t/p/original{$movie['backdrop']}"
    : "https://image.tmdb.org/t/p/w500{$movie['poster']}";

// Trailer key
$youtubeKey = $movie["trailer"] ?? null;
?>

<style>
/* ===========================
   HERO (Netflix Style)
=========================== */
.movie-hero {
    position: relative;
    height: 500px;
    overflow: hidden;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.movie-hero::before {
    content: "";
    position: absolute;
    inset: 0;
    background-image: url('<?= $backdrop ?>');
    background-size: cover;
    background-position: center;
    filter: brightness(65%);
}

.movie-hero::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.95));
    z-index: 1;
}

/* HERO CONTENT */
.hero-content {
    position: relative;
    z-index: 5;
    top: 140px;
    left: 60px;
    max-width: 45%;
    color: white;
}

.hero-title {
    font-size: 48px;
    font-weight: 900;
}
.hero-info {
    font-size: 18px;
    opacity: 0.9;
    margin: 15px 0 25px;
}

/* BUTTONS */
.nf-btn {
    padding: 12px 26px;
    border-radius: 6px;
    font-size: 18px;
    cursor: pointer;
    border: none;
    font-weight: 600;
}

.nf-btn.play {
    background: white;
    color: black;
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

.nf-btn.more {
    margin-left: 10px;
    background: rgba(255,255,255,0.2);
    color: white;
}

/* ===========================
   TOAST MESSAGE
=========================== */
.toast {
    position: fixed;
    bottom: 40px;
    left: 50%;
    transform: translateX(-50%);
    padding: 14px 20px;
    background: rgba(0,0,0,0.75);
    color: #fff;
    border-radius: 6px;
    font-size: 18px;
    opacity: 0;
    transition: all 0.35s ease;
    z-index: 99999;
}
.toast.show {
    opacity: 1;
    bottom: 60px;
}

/* ===========================
   TRAILER POPUP
=========================== */
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
    border-radius: 12px;
}

.close-trailer {
    position: absolute;
    top: 40px;
    right: 60px;
    font-size: 40px;
    cursor: pointer;
    color: white;
}

/* ===========================
   DETAILS SECTION
=========================== */
.details-section {
    padding: 40px 60px;
    color: white;
}

.details-desc {
    font-size: 18px;
    line-height: 1.6;
    max-width: 70%;
    opacity: 0.9;
    margin-bottom: 40px;
}

.suggest-title {
    font-size: 26px;
    font-weight: 700;
    margin-bottom: 18px;
}

.suggest-grid {
    display: flex;
    gap: 18px;
}

.suggest-card img {
    width: 160px;
    height: 240px;
    border-radius: 6px;
    transition: .3s;
    object-fit: cover;
}
.suggest-card img:hover {
    transform: scale(1.15);
}
</style>


<!-- ===========================
     HERO SECTION
=========================== -->
<div class="movie-hero">
    <div class="hero-content">

        <div class="hero-title"><?= $movie["title"] ?></div>

        <div class="hero-info">
            <?= $movie["year"] ?> • 
            <?= $movie["duration"] ?> phút • 
            ⭐ <?= $movie["rating"] ?>
        </div>

        <button class="nf-btn play" onclick="showTrailer()">
            <i class="fa-solid fa-play"></i> Xem ngay
        </button>

        <!-- WATCHLIST BUTTON (AJAX) -->
       <button id="watchlist-btn" class="nf-btn more" onclick="toggleWatchlist(<?= $movie['id'] ?>)">
    <?php if ($isAdded): ?>
        <i class="fa-solid fa-check"></i> Đã thêm
    <?php else: ?>
        <i class="fa-solid fa-plus"></i> Thêm vào danh sách
    <?php endif; ?>
</button>


    </div>
</div>


<!-- ===========================
     DETAILS SECTION
=========================== -->
<div class="details-section">

    <div class="details-desc">
        <?= nl2br($movie["description"] ?? "Hiện chưa có mô tả cho phim này.") ?>
    </div>

    <div class="suggest-title">Phim tương tự</div>

    <div class="suggest-grid">
        <?php foreach ($related_movies as $rm): ?>
            <?php 
                $p = str_starts_with($rm["poster"], "/")
                    ? "https://image.tmdb.org/t/p/w500{$rm["poster"]}"
                    : BASE_URL . "/uploads/{$rm["poster"]}";
            ?>
            <a class="suggest-card" href="<?= BASE_URL ?>/movie/<?= $rm["id"] ?>">
                <img src="<?= $p ?>" alt="">
            </a>
        <?php endforeach; ?>
    </div>
</div>


<!-- ===========================
     TRAILER POPUP
=========================== -->
<div id="trailerPopup" class="trailer-popup">
    <div class="close-trailer" onclick="closeTrailer()">&times;</div>

    <?php if ($youtubeKey): ?>
        <iframe id="trailerFrame" src="" allowfullscreen></iframe>
    <?php else: ?>
        <h2 style="color:white">⛔ Phim này chưa có trailer.</h2>
    <?php endif; ?>
</div>


<!-- ===========================
     TOAST
=========================== -->
<div id="toast" class="toast"></div>


<script>
// Show Trailer
function showTrailer() {
    const popup = document.getElementById("trailerPopup");
    const frame = document.getElementById("trailerFrame");

    popup.style.display = "flex";
    frame.src = "https://www.youtube.com/embed/<?= $youtubeKey ?>?autoplay=1";
}

function closeTrailer() {
    const popup = document.getElementById("trailerPopup");
    const frame = document.getElementById("trailerFrame");

    popup.style.display = "none";
    frame.src = "";
}

// Toast message
function showToast(message) {
    const toast = document.getElementById("toast");
    toast.innerText = message;
    toast.classList.add("show");

    setTimeout(() => toast.classList.remove("show"), 2500);
}

// Add to Watchlist (AJAX)
function addToWatchlist(movieId) {
    fetch("<?= BASE_URL ?>/watchlist/add", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "movie_id=" + movieId
    })
    .then(() => {
        showToast("Đã thêm vào danh sách!");

        const btn = document.getElementById("watchlist-btn");
        btn.innerHTML = "<i class='fa-solid fa-check'></i> Đã thêm";
        btn.style.background = "#2ecc71";
        btn.style.color = "white";
        btn.disabled = true;
    });
}
</script>
<script>
function toggleWatchlist(movieId) {

    fetch("<?= BASE_URL ?>/watchlist/toggle", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "movie_id=" + movieId
    })
    .then(res => res.text())
    .then(result => {

        const btn = document.getElementById("watchlist-btn");

        if (result === "added") {
            btn.innerHTML = "<i class='fa-solid fa-check'></i> Đã thêm";
            btn.style.background = "#2ecc71";
            btn.style.color = "white";
            showToast("Đã thêm vào danh sách!");
        }

        if (result === "removed") {
            btn.innerHTML = "<i class='fa-solid fa-plus'></i> Thêm vào danh sách";
            btn.style.background = "rgba(255,255,255,0.2)";
            btn.style.color = "white";
            showToast("Đã xoá khỏi danh sách!");
        }
    });
}
</script>
