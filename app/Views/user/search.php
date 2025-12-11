<h2 style="color:white;">Kết quả cho: <?= htmlspecialchars($keyword) ?></h2>

<div style="display:flex; flex-wrap:wrap; gap:20px;">
    <?php foreach ($movies as $m): ?>
        <a href="<?= BASE_URL ?>/movie/<?= $m['id'] ?>" 
           style="color:white;">
            <img src="https://image.tmdb.org/t/p/w500<?= $m['poster_path'] ?>" 
                 style="width:150px; border-radius:8px;">
            <p><?= $m['title'] ?></p>
        </a>
    <?php endforeach; ?>
</div>
