<?php
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../models.php';

$id = $_GET['id'];
$genre = getGenre($pdo, $id);

if (!$genre) {
    flash("Không tìm thấy thể loại!");
    header("Location: genre.php");
    exit;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Sửa thể loại phim</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="container">
<h2>Sửa thể loại phim</h2>

<form method="post" action="genre_update.php">
    <input type="hidden" name="maloai" value="<?= e($genre['maloai']) ?>">

    <div class="form-group">
        <label>Tên thể loại</label>
        <input class="form-control" name="tenloai" value="<?= e($genre['tenloai']) ?>" required>
    </div>

    <button class="btn">Cập nhật</button>
    <a class="btn" href="genre.php">Hủy</a>
</form>

</div>
</body>
</html>
