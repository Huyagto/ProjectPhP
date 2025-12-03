<?php
require_once __DIR__ . '/../helpers.php';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Thêm đạo diễn</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="container">
<h2>Thêm đạo diễn</h2>

<form method="post" action="director_save.php">
    <div class="form-group">
        <label>Tên đạo diễn</label>
        <input class="form-control" name="tendd" required>
    </div>

    <button class="btn">Lưu</button>
    <a class="btn" href="director.php">Hủy</a>
</form>
</div>

</body>
</html>
