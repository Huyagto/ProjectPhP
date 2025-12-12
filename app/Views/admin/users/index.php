<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin.css">
<div class="page-title-flex">
    <div class="page-title">
        <i class="fa-solid fa-users"></i>
        <span>Quản lý người dùng</span>
    </div>
    <a class="btn primary" href="<?= BASE_URL ?>/admin/users/create">
        + Thêm user
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
                <th>Username</th>
                <th>Email</th>
                 <th>Display Name</th>
                  <th>Avatar</th>
                <th width="100">Role</th>
                <th width="140">Hành động</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($users as $u): ?>
            <tr>
                <td><?= $u["id"] ?></td>
    <td><?= htmlspecialchars($u["username"]) ?></td>
    <td><?= htmlspecialchars($u["email"]) ?></td>

    <td><?= htmlspecialchars($u["display_name"] ?? "-") ?></td>

    <td>
        <img src="<?= BASE_URL ?>/assets/img/<?= $u["avatar"] ?: 'default-avatar.png' ?>"
             style="width:40px;height:40px;border-radius:50%;border:2px solid #e50914;">
    </td>

    <td><?= $u["role"] ?></td>

                <td class="action-cell">
                    <a class="btn small secondary"
                       href="<?= BASE_URL ?>/admin/users/edit/<?= $u['id'] ?>">Sửa</a>

                    <a class="btn small danger"
                       onclick="return confirm('Xóa người dùng này?')"
                       href="<?= BASE_URL ?>/admin/users/delete/<?= $u['id'] ?>">
                        Xóa
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

