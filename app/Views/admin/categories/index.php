<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin.css">
<div class="page-title-flex">
    <div class="page-title">
        <i class="fa-solid fa-tags"></i>
        <span>Quản lý thể loại</span>
    </div>
    <a class="btn primary" href="<?= BASE_URL ?>/admin/categories/create">
        + Thêm thể loại
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
                <th>Tên</th>
                <th width="140">Hành động</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($categories as $c): ?>
            <tr>
                <td><?= $c['id'] ?></td>
                <td><?= htmlspecialchars($c['name']) ?></td>
                <td>
                    <div class="action-cell">
                        <a class="btn small secondary"
                           href="<?= BASE_URL ?>/admin/categories/edit/<?= $c['id'] ?>">Sửa</a>

                        <a class="btn small danger"
                           onclick="return confirm('Xóa thể loại này?')"
                           href="<?= BASE_URL ?>/admin/categories/delete/<?= $c['id'] ?>">
                            Xóa
                        </a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
