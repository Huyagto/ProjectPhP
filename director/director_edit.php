<?php
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../models.php';

$id = $_GET['id'];
$director = getDirector($pdo, $id);

if (!$director) {
    flash("Không tìm thấy đạo diễn!");
    header("Location: director.php");
    exit;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Sửa đạo diễn</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="container">
<h2>Sửa đạo diễn</h2>

<form method="post" action="director_update.php">
    <input type="hidden" name="madd" value="<?= e($director['madd']) ?>">

    <div class="form-group">
        <label>Tên đạo diễn</label>
        <input class="form-control" name="tendd" value="<?= e($director['tendd']) ?>" required>
    </div>

    <button class="btn">Cập nhật</button>
    <a class="btn" href="director.php">Hủy</a>
</form>

</div>

</body>
</html>
