<?php
require_once 'helpers.php';
require_once 'models.php';

$filters = [];
$q = $_GET['q'] ?? '';
$filters['q'] = trim($q);
$filters['maloai'] = $_GET['maloai'] ?? '';
$filters['madd'] = $_GET['madd'] ?? '';
$filters['year'] = $_GET['year'] ?? '';

$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = 6;

$total = countMovies($pdo, $filters);
$baseUrl = 'index.php?q=' . urlencode($filters['q']) . '&maloai=' . urlencode($filters['maloai']) . '&madd=' . urlencode($filters['madd']) . '&year=' . urlencode($filters['year']);
$pg = paginate($total, $perPage, $page, $baseUrl);
$movies = getMovies($pdo, $filters, $pg['offset'], $pg['limit']);

$genres = getAllGenres($pdo);
$directors = getAllDirectors($pdo);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Quản lý phim</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">
  <header class="header">
    <h1>Quản lý danh sách phim</h1>
    <div>
      <a class="btn primary" href="movie/movie_create.php">+ Thêm phim</a>
      <a class="btn secondary" href="genre/genre.php">Thể loại</a>
      <a class="btn secondary" href="director/director.php">Đạo diễn</a>
    </div>
  </header>

  <form class="form-inline" method="get" action="index.php" style="margin-bottom:12px">
    <input class="form-control" type="text" name="q" placeholder="Tìm theo tên/mô tả..." value="<?= e($filters['q']) ?>" />
    <select name="maloai" class="form-control">
        <option value="">--Chọn thể loại--</option>
        <?php foreach($genres as $g): ?>
            <option value="<?= e($g['maloai']) ?>" <?= $g['maloai'] == $filters['maloai'] ? 'selected' : '' ?>><?= e($g['tenloai']) ?></option>
        <?php endforeach; ?>
    </select>
    <select name="madd" class="form-control">
        <option value="">--Chọn đạo diễn--</option>
        <?php foreach($directors as $d): ?>
            <option value="<?= e($d['madd']) ?>" <?= $d['madd'] == $filters['madd'] ? 'selected' : '' ?>><?= e($d['tendd']) ?></option>
        <?php endforeach; ?>
    </select>

    <!-- Combo box cho Năm -->
    <select name="year" class="form-control">
        <option value="">--Chọn năm--</option>
        <?php
        $currentYear = date("Y"); // Lấy năm hiện tại
        for ($year = $currentYear; $year >= 2000; $year--) { 
        echo "<option value='$year'" . ($year == $filters['year'] ? ' selected' : '') . ">$year</option>";
}S
        ?>

    </select>

    <button class="btn primary">Tìm</button>
    <a class="btn danger" href="index.php">Xóa</a>
</form>


  <table class="table">
    <thead>
      <tr><th>#</th><th>Poster</th><th>Tên</th><th>Thể loại</th><th>Đạo diễn</th><th>Năm</th><th>Giá</th><th>Hành động</th></tr>
    </thead>
    <tbody>
      <?php if (empty($movies)): ?>
        <tr><td colspan="8">Không có phim.</td></tr>
      <?php else: 
            $counter = ($page - 1) * $perPage + 1;
            foreach($movies as $m): ?>
        <tr>
          <td><?= $counter++ ?></td>
          <td>
            <?php if ($m['poster']): ?>
              <img class="poster-thumb" src="uploads/<?= e($m['poster']) ?>" alt="">
            <?php else: ?>
              <div class="no-poster">No</div>
            <?php endif; ?>
          </td>
          <td><?= e($m['tenphim']) ?><br><small><?= e($m['mota']) ?></small></td>
          <td><?= e($m['tenloai']) ?></td>
          <td><?= e($m['tendd']) ?></td>
          <td><?= e($m['namsx']) ?></td>
          <td><?= $m['gia'] ? number_format($m['gia']) : '-' ?></td>
          <td>
            <a class="btn primary" href="movie/movie_edit.php?id=<?= e($m['maphim']) ?>">Sửa</a>
            <a class="btn danger" href="movie/movie_delete.php?id=<?= e($m['maphim']) ?>" onclick="return confirm('Xóa phim?')">Xóa</a>
          </td>
        </tr>
      <?php endforeach; endif; ?>
    </tbody>
  </table>

  <ul class="pagination">
    <?php foreach($pg['pages'] as $p): ?>
      <li><a class="<?= $p['active'] ? 'active' : '' ?>" href="<?= e($p['url']) ?>"><?= $p['num'] ?></a></li>
    <?php endforeach; ?>
  </ul>
</div>
</body>
</html>
