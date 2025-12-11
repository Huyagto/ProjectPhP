<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin.css">

<div class="page-title-flex">
    <div class="page-title">
        <i class="fa-solid fa-user-pen"></i>
        <span>Quản lý tác giả</span>
    </div>
    <a class="btn primary" href="<?= BASE_URL ?>/admin/authors/create">+ Thêm tác giả</a>
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
                <th width="70">ID</th>
                <th>Tên tác giả</th>
                <th width="160">Hành động</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($authors as $a): ?>
                <tr>
                    <td><?= $a['id'] ?></td>

                    <td><?= htmlspecialchars($a['name']) ?></td>

                    <td class="action-cell">
                        <a class="btn small secondary" 
                           href="<?= BASE_URL ?>/admin/authors/edit/<?= $a['id'] ?>">Sửa</a>

                        <a class="btn small danger"
                           onclick="return confirm('Xóa tác giả này?')"
                           href="<?= BASE_URL ?>/admin/authors/delete/<?= $a['id'] ?>">
                            Xóa
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
