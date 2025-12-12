<!-- =========================
     HERO SLIDER (NETFLIX)
========================== -->
<div class="hero-slider">

<?php foreach ($slider as $i => $movie): ?>

    <?php
        $bg = $movie["backdrop"]
            ? "https://image.tmdb.org/t/p/original{$movie['backdrop']}"
            : "https://image.tmdb.org/t/p/w500{$movie['poster']}";
    ?>

    <div class="slide <?= $i === 0 ? 'active' : '' ?>"
         style="background-image: url('<?= $bg ?>');">

        <div class="overlay"></div>

        <div class="slide-content">
            <h1 class="slide-title"><?= htmlspecialchars($movie["title"]) ?></h1>

            <p class="slide-desc">
                <?= htmlspecialchars(substr($movie["description"], 0, 130)) ?>...
            </p>

            <div class="slide-buttons">

                <?php if (!empty($movie["trailer"])): ?>
                    <button class="play-btn"
                            data-trailer="<?= htmlspecialchars($movie['trailer'], ENT_QUOTES) ?>">
                        <i class="fa fa-play"></i> Phát
                    </button>
                <?php endif; ?>

                <a href="<?= BASE_URL ?>/movie/<?= $movie['id'] ?>" class="info-btn">
                    <i class="fa fa-info-circle"></i> Chi tiết
                </a>

            </div>
        </div>

    </div>

<?php endforeach; ?>

</div>


<!-- =========================
     TOP 10
========================== -->
<h2 class="section-title">🏆 Top 10 hôm nay</h2>

<div class="top10-row">
<?php foreach (array_slice($movies, 0, 10) as $i => $m): ?>

    <?php
        $poster = str_starts_with($m["poster"], "/")
            ? "https://image.tmdb.org/t/p/w500{$m['poster']}"
            : BASE_URL . "/uploads/" . $m["poster"];
    ?>

    <div class="top10-card">
        <div class="rank"><?= $i + 1 ?></div>
        <img src="<?= $poster ?>" alt="<?= htmlspecialchars($m['title']) ?>">
    </div>

<?php endforeach; ?>
</div>


<!-- =========================
     MOVIE GRID
========================== -->
<h2 class="section-title">🔥 Phim mới cập nhật</h2>

<div class="movie-grid">

<?php foreach ($movies as $m): ?>

    <?php
        $poster = str_starts_with($m["poster"], "/")
            ? "https://image.tmdb.org/t/p/w500{$m['poster']}"
            : BASE_URL . "/uploads/" . $m["poster"];
    ?>

    <a href="<?= BASE_URL ?>/movie/<?= $m['id'] ?>" class="movie-card">
        <img src="<?= $poster ?>" alt="<?= htmlspecialchars($m['title']) ?>">

        <div class="preview-popup">
            <div class="movie-title"><?= $m['title'] ?></div>
            <div class="movie-year"><?= $m['year'] ?></div>
            <div class="movie-extra">⭐ <?= $m['rating'] ?? "Chưa có đánh giá" ?></div>
        </div>
    </a>

<?php endforeach; ?>

</div>


<!-- =========================
     TRAILER POPUP
========================== -->
<div id="trailerPopup" class="trailer-popup">
    <div class="trailer-box">
        <span class="close-btn">✖</span>
        <iframe id="trailerFrame" width="100%" height="400" src="" frameborder="0" allowfullscreen></iframe>
    </div>
</div>


<!-- =========================
     PAGE SCRIPTS
========================== -->
<script src="<?= BASE_URL ?>/assets/js/home-user.js"></script>
