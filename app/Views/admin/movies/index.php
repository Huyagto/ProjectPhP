<?php
use Helpers\ImageHelper;
?>

<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin.css">

<div class="page-title-flex">
    <div class="page-title">
        <i class="fa-solid fa-film"></i>
        <span>Quản lý phim</span>
    </div>

    <a class="btn primary" href="<?= BASE_URL ?>/admin/movies/create">
        + Thêm phim
    </a>
</div>

<!-- =========================
     FILTER
========================== -->
<div class="filter-row">
    <form method="GET" class="filter-form">

        <input class="input" name="search"
               placeholder="Tìm theo tên..."
               value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">

        <select name="category" class="input">
            <option value="">-- Thể loại --</option>
            <?php foreach ($categories as $c): ?>
                <option value="<?= $c['id'] ?>"
                    <?= (($_GET['category'] ?? '') == $c['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="author" class="input">
            <option value="">-- Tác giả --</option>
            <?php foreach ($authors as $a): ?>
                <option value="<?= $a['id'] ?>"
                    <?= (($_GET['author'] ?? '') == $a['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($a['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="number"
               class="input"
               placeholder="Năm"
               name="year"
               value="<?= htmlspecialchars($_GET['year'] ?? '') ?>">

        <button class="btn secondary">Lọc</button>
    </form>
</div>

<!-- =========================
     TABLE
========================== -->
<div class="card table-card">
    <table class="table">
        <thead>
            <tr>
                <th width="60">ID</th>
                <th width="90">Poster</th>
                <th width="120">Backdrop</th>
                <th>Tiêu đề</th>
                <th width="180">Tác giả</th>
                <th>Thể loại</th>
                <th width="70">Năm</th>
                <th width="90">Rating</th>
                <th width="90">Thời lượng</th>
                <th width="120">Ngày phát hành</th>
                <th width="140">Hành động</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($movies as $m): ?>
            <tr>
                <td><?= $m['id'] ?></td>

                <!-- Poster -->
                <td>
                    <img src="<?= ImageHelper::movie($m['poster'], ImageHelper::SMALL) ?>"
                         class="poster-img"
                         alt="<?= htmlspecialchars($m['title']) ?>">
                </td>

                <!-- Backdrop -->
                <td>
                    <img src="<?= ImageHelper::movie($m['backdrop'], 'w300') ?>"
                         class="poster-img"
                         alt="<?= htmlspecialchars($m['title']) ?>">
                </td>

                <td><?= htmlspecialchars($m['title']) ?></td>
                <td><?= htmlspecialchars($m['author_name'] ?? 'Không rõ') ?></td>
                <td><?= htmlspecialchars($m['categories'] ?? '') ?></td>
                <td><?= htmlspecialchars($m['year']) ?></td>
                <td><?= htmlspecialchars($m['rating']) ?></td>
                <td><?= htmlspecialchars($m['duration']) ?> phút</td>
                <td><?= htmlspecialchars($m['release_date']) ?></td>

                <td class="action-cell">
                    <a class="btn small secondary"
                       href="<?= BASE_URL ?>/admin/movies/edit/<?= $m['id'] ?>">
                        Sửa
                    </a>

                    <a class="btn small danger"
                       onclick="return confirm('Xóa phim này?')"
                       href="<?= BASE_URL ?>/admin/movies/delete/<?= $m['id'] ?>">
                        Xóa
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
