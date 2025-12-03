<?php
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../models.php';

// Lấy danh sách đạo diễn từ cơ sở dữ liệu
$directors = getAllDirectors($pdo);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Quản lý đạo diễn</title>
  <link rel="stylesheet" href="../assets/styleDirector.css"> <!-- Áp dụng CSS cho đạo diễn -->
</head>
<body>
  <div class="container">
    <h2>Quản lý đạo diễn</h2>

    <!-- Các nút hành động: Thêm đạo diễn và Quay lại -->
    <a class="btn primary" href="director_create.php">+ Thêm đạo diễn</a>
    <a class="btn secondary" href="../index.php">Quay lại</a>

    <!-- Bảng hiển thị danh sách đạo diễn -->
    <table class="table" style="margin-top:15px">
      <tr>
        <th>ID</th>
        <th>Tên đạo diễn</th>
        <th>Hành động</th>
      </tr>

      <?php foreach ($directors as $d): ?>
        <tr>
          <td><?= e($d['madd']) ?></td>  <!-- Mã đạo diễn -->
          <td><?= e($d['tendd']) ?></td> <!-- Tên đạo diễn -->
          <td>
            <!-- Các nút hành động: sửa và xóa -->
            <a class="btn primary" href="director_edit.php?id=<?= e($d['madd']) ?>">Sửa</a>
            <a class="btn danger" href="director_delete.php?id=<?= e($d['madd']) ?>" onclick="return confirm('Xóa đạo diễn này?')">Xóa</a>
          </td>
        </tr>
      <?php endforeach; ?>

    </table>
  </div>
</body>
</html>
