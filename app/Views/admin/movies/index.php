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

<div class="search-row">
    <form method="GET" class="search-form">
        <input class="input" name="search" placeholder="Nhập từ khóa..." 
               value="<?= htmlspecialchars($keyword ?? '') ?>">
        <button class="btn secondary">Tìm</button>
    </form>
</div>

<div class="card table-card">
    <table class="table">
        <thead>
            <tr>
                <th width="60">ID</th>
                <th width="90">Poster</th>
                <th>Tiêu đề</th>
                <th width="180">Tác giả</th>
                <th>Thể loại</th>
                <th width="70">Năm</th>
                <th width="140">Hành động</th>
            </tr>
        </thead>
        <tbody>

        <?php foreach ($movies as $m): ?>
        <tr>
            <td><?= $m['id'] ?></td>

            <td>
                <?php 
                    $poster = $m['poster']
                        ? (str_starts_with($m['poster'], '/')
                            ? "https://image.tmdb.org/t/p/w200{$m['poster']}"
                            : BASE_URL . "/uploads/" . $m['poster'])
                        : BASE_URL . '/assets/img/no-image.png';
                ?>
                <img src="<?= $poster ?>" class="poster-img">
            </td>

            <td><?= htmlspecialchars($m['title']) ?></td>
            <td><?= htmlspecialchars($m['author_name'] ?? 'Không rõ') ?></td>
            <td><?= htmlspecialchars($m['categories'] ?? '') ?></td>
            <td><?= $m['year'] ?></td>

            <td class="action-cell">
                <a class="btn small secondary" 
                   href="<?= BASE_URL ?>/admin/movies/edit/<?= $m['id'] ?>">Sửa</a>

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
