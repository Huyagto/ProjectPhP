<div class="header">
    <a href="<?= BASE_URL ?>/home" class="header-logo">MovieFlix</a>

    <div>
        <?php if (!empty($_SESSION['user'])): ?>
            <span class="header-user">👤 <?= $_SESSION['user']['username'] ?></span>

            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                <a href="<?= BASE_URL ?>/admin" class="nav-btn nav-admin">Admin</a>
            <?php endif; ?>

            <a href="<?= BASE_URL ?>/logout" class="nav-btn nav-logout">Đăng xuất</a>

        <?php else: ?>
            <a href="<?= BASE_URL ?>/login" class="nav-btn nav-login">Đăng nhập</a>
            <a href="<?= BASE_URL ?>/register" class="nav-btn nav-register">Đăng ký</a>
        <?php endif; ?>
    </div>
</div>
