
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin.css">
<div class="form-card">
    <h2 class="form-title"><i class="fa-solid fa-user-pen"></i> Sửa user</h2>

    <form method="POST" class="admin-form">

        <label>Username:</label>
        <input type="text" name="username" class="input-parent"
               value="<?= htmlspecialchars($user['username']) ?>" required>

        <label>Email:</label>
        <input type="email" name="email" class="input-parent"
               value="<?= htmlspecialchars($user['email']) ?>" required>

        <label>Role:</label>
        <select name="role" class="input-parent">
            <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
            <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
        </select>

        <button type="submit" class="btn-submit">Cập nhật</button>

    </form>
</div>
<?php