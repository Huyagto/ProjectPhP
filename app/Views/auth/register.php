
<h2 class="auth-title">Đăng ký</h2>

<?php if (!empty($error)): ?>
    <div class="error"><?= $error ?></div>
<?php endif; ?>

<form method="POST">

    <div class="input-group">
        <i class="fa fa-user"></i>
        <input type="text" name="username" placeholder="Tên đăng nhập" required>
    </div>

    <div class="input-group">
        <i class="fa fa-id-card"></i>
        <input type="text" name="display_name" placeholder="Tên hiển thị" required>
    </div>

    <div class="input-group">
        <i class="fa fa-envelope"></i>
        <input type="email" name="email" placeholder="Email" required>
    </div>

    <div class="input-group">
        <i class="fa fa-lock"></i>
        <input type="password" name="password" placeholder="Mật khẩu" required>
    </div>

    <button class="btn">Đăng ký</button>
</form>

<div class="bottom-text">
    Đã có tài khoản?  
    <a href="<?= BASE_URL ?>/login">Đăng nhập</a>
</div>
