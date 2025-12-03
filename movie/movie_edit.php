<?php
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../models.php';

$id = $_GET['id'] ?? null;
$movie = getMovie($pdo, $id);

if (!$movie) {
    flash("Không tìm thấy phim!");
    header("Location: ../index.php");
    exit;
}

$genres = getAllGenres($pdo);
$directors = getAllDirectors($pdo);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Sửa phim</title>
<link rel="stylesheet" href="../assets/style.css">
<script src="../assets/script.js"></script>
</head>
<body>
<div class="container">
<h2>Sửa phim</h2>

<form method="post" action="movie_update.php" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= e($movie['maphim']) ?>">
    <input type="hidden" name="poster_old" value="<?= e($movie['poster']) ?>">

    <div class="form-group">
        <label>Tên phim</label>
        <input class="form-control" name="tenphim" value="<?= e($movie['tenphim']) ?>" required>
    </div>

    <div class="form-group">
        <label>Mô tả</label>
        <textarea class="form-control" name="mota"><?= e($movie['mota']) ?></textarea>
    </div>

    <div class="form-group">
        <label>Năm sản xuất</label>
        <input class="form-control" type="number" name="namsx" value="<?= e($movie['namsx']) ?>">
    </div>

    <div class="form-group">
        <label>Thời lượng</label>
        <input class="form-control" type="number" name="thoiluong" value="<?= e($movie['thoiluong']) ?>">
    </div>

    <div class="form-group">
        <label>Giá</label>
        <input class="form-control" type="number" name="gia" step="0.01" value="<?= e($movie['gia']) ?>">
    </div>

    <div class="form-group">
        <label>Thể loại</label>
        <select class="form-control" name="maloai">
            <option value="">--Chọn--</option>
            <?php foreach ($genres as $g): ?>
            <option value="<?= e($g['maloai']) ?>" <?= ($g['maloai']==$movie['maloai'])?'selected':'' ?>>
                <?= e($g['tenloai']) ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Đạo diễn</label>
        <select class="form-control" name="madd">
            <option value="">--Chọn--</option>
            <?php foreach ($directors as $d): ?>
            <option value="<?= e($d['madd']) ?>" <?= ($d['madd']==$movie['madd'])?'selected':'' ?>>
                <?= e($d['tendd']) ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>

    <label>Poster hiện tại</label><br>
    <?php if ($movie['poster']): ?>
        <img src="../uploads/<?= e($movie['poster']) ?>" width="150">
    <?php else: ?>
        Không có
    <?php endif; ?>

    <div class="form-group">
        <label>Đổi poster</label>
        <input type="file" name="poster" onchange="previewPoster(this,'prev')">
        <img id="prev" style="max-width:150px;margin-top:10px;">
    </div>

    <button class="btn">Cập nhật</button>
    <a class="btn" href="../index.php">Hủy</a>
</form>

</div>
