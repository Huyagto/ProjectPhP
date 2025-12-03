<?php
require_once __DIR__ . '/../helpers.php';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Thêm thể loại phim</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="container">
<h2>Thêm thể loại phim</h2>

<form method="post" action="genre_save.php">
    <div class="form-group">
        <label>Mã thể loại</label>
        <input class="form-control" name="maloai" required>
    </div>

    <div class="form-group">
        <label>Tên thể loại</label>
        <input class="form-control" name="tenloai" required>
    </div>

    <button class="btn">Lưu</button>
    <a class="btn" href="genre.php">Hủy</a>
</form>
</div>
</body>
</html>
