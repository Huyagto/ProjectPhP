<?php
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../models.php';

// Lấy danh sách thể loại từ cơ sở dữ liệu
$genres = getAllGenres($pdo);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Quản lý thể loại phim</title>
  <link rel="stylesheet" href="../assets/styleGenre.css"> <!-- Áp dụng CSS cho thể loại -->
</head>
<body>
<div class="container">
  <h2>Quản lý thể loại phim</h2>

  <!-- Các nút hành động: Thêm thể loại và Quay lại -->
  <a class="btn primary" href="genre_create.php">+ Thêm thể loại</a>
  <a class="btn secondary" href="../index.php">Quay lại</a>

  <!-- Bảng hiển thị danh sách thể loại -->
  <table class="table" style="margin-top:20px;">
    <tr>
      <th>Mã</th>
      <th>Tên thể loại</th>
      <th>Hành động</th>
    </tr>

    <?php foreach ($genres as $g): ?>
      <tr>
        <td><?= e($g['maloai']) ?></td>  <!-- Mã thể loại -->
        <td><?= e($g['tenloai']) ?></td> <!-- Tên thể loại -->
        <td>
          <!-- Các nút hành động: sửa và xóa -->
          <a class="btn primary" href="genre_edit.php?id=<?= e($g['maloai']) ?>">Sửa</a>
          <a class="btn danger" href="genre_delete.php?id=<?= e($g['maloai']) ?>" onclick="return confirm('Xóa thể loại này?')">Xóa</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>
</body>
</html>
