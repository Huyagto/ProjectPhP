
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin.css">
<div class="form-card">
    <h2 class="form-title"><i class="fa-solid fa-user-plus"></i> Thêm user</h2>

    <form method="POST" class="admin-form">

        <label>Username:</label>
        <input type="text" name="username" class="input-parent" required>

        <label>Email:</label>
        <input type="email" name="email" class="input-parent" required>

        <label>Password:</label>
        <input type="password" name="password" class="input-parent" required>

        <label>Role:</label>
        <select name="role" class="input-parent">
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>

        <button type="submit" class="btn-submit">Thêm user</button>

    </form>
</div>

