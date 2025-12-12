
<h2 class="auth-title">Đăng nhập</h2>

<?php if (!empty($error)): ?>
    <div class="error"><?= $error ?></div>
<?php endif; ?>

<form method="POST">

    <div class="input-group">
        <i class="fa fa-user"></i>
        <input type="text" name="email" placeholder="Tên đăng nhập hoặc Email" required>
    </div>

    <div class="input-group">
        <i class="fa fa-lock"></i>
        <input type="password" name="password" placeholder="Mật khẩu" required>
    </div>

    <button class="btn">Đăng nhập</button>
</form>

<div class="bottom-text">
    Bạn chưa có tài khoản?
    <a href="<?= BASE_URL ?>/register">Đăng ký ngay</a>
</div>
