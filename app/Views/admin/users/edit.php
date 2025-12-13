<link rel="stylesheet" href="assets/css/admin.css">

<div class="form-card">

    <div class="form-title">
        <i class="fa-solid fa-user-pen"></i>
        <span>Chỉnh sửa người dùng</span>
    </div>
    <form action="<?= BASE_URL ?>/admin/users/update/<?= $user['id'] ?>" 
          method="POST" enctype="multipart/form-data">

        <label>Username</label>
        <input type="text" name="username" class="input-parent"
               value="<?= htmlspecialchars($user['username']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" class="input-parent"
               value="<?= htmlspecialchars($user['email']) ?>" required>
        <label>Display Name</label>
<input type="text" name="display_name" class="input-parent" value="<?= $user['display_name'] ?>">

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
<script>
document.getElementById("avatarSelect").addEventListener("change", function () {
    const avatar = this.value;

    document.getElementById("avatarPreview").src =
        "<?= BASE_URL ?>/img/" + avatar;
});
</script>

