<?php
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../models.php';

$genres = getAllGenres($pdo);
$directors = getAllDirectors($pdo);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thêm phim</title>
    <link rel="stylesheet" href="../assets/styleCreate.css">
    <script src="../assets/script.js"></script>
</head>
<body>
<div class="container">
<h2>Thêm phim mới</h2>

<form method="post" action="movie_store.php" enctype="multipart/form-data">
    <div class="form-group">
        <label>Tên phim</label>
        <input class="form-control" name="tenphim" required>
    </div>

    <div class="form-group">
        <label>Mô tả</label>
        <textarea class="form-control" name="mota"></textarea>
    </div>

    <div class="form-group">
        <label>Năm sản xuất</label>
        <input class="form-control" type="number" name="namsx">
    </div>

    <div class="form-group">
        <label>Thời lượng (phút)</label>
        <input class="form-control" type="number" name="thoiluong">
    </div>

    <div class="form-group">
        <label>Giá</label>
        <input class="form-control" type="number" name="gia" step="0.01">
    </div>

    <div class="form-group">
        <label>Thể loại</label>
        <select class="form-control" name="maloai">
            <option value="">-- Chọn --</option>
            <?php foreach ($genres as $g): ?>
            <option value="<?= e($g['maloai']) ?>"><?= e($g['tenloai']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Đạo diễn</label>
        <select class="form-control" name="madd">
            <option value="">-- Chọn --</option>
            <?php foreach ($directors as $d): ?>
            <option value="<?= e($d['madd']) ?>"><?= e($d['tendd']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Poster</label>
        <input type="file" name="poster" accept="image/*" onchange="previewPoster(this,'prev')">
        <img id="prev" style="max-width:150px; margin-top:10px;">
    </div>

    <button class="btn">Thêm phim</button>
    <button class="btn secondary" href="../index.php">Hủy</button>
</form>

</div>
</body>
</html>
