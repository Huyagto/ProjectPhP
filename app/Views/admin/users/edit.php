<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin.css">

<div class="form-card">

    <div class="form-title">
        <i class="fa-solid fa-user-pen"></i>
        <span>Chỉnh sửa người dùng</span>
    </div>

    <!-- SỬA QUAN TRỌNG: thêm action -->
    <form action="<?= BASE_URL ?>/admin/users/update/<?= $user['id'] ?>" 
          method="POST" enctype="multipart/form-data">

        <label>Username</label>
        <input type="text" name="username" class="input-parent"
               value="<?= htmlspecialchars($user['username']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" class="input-parent"
               value="<?= htmlspecialchars($user['email']) ?>" required>

        <label>Password mới</label>
        <input type="password" name="password" class="input-parent" placeholder="Để trống nếu không đổi">

        <label>Role</label>
        <select name="role" class="select">
            <option value="0" <?= $user['role'] == 0 ? 'selected' : '' ?>>User</option>
            <option value="1" <?= $user['role'] == 1 ? 'selected' : '' ?>>Admin</option>
        </select>

        <button class="btn-submit" type="submit">Cập nhật</button>
    </form>

</div>
