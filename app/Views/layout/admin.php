<!DOCTYPE html>
<html lang="vi">
<head>
    <base href="<?= rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') ?>/">
    <meta charset="UTF-8">
    <title><?= $title ?? "MovieFlix Admin" ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admin-main.css">
</head>

<body>
    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>MovieFlix</h2>

        <a href="<?= BASE_URL ?>/admin" class="<?= ($active ?? '')=='dashboard'?'active':'' ?>">
            <i class="fa-solid fa-chart-line"></i> Dashboard
        </a>

        <a href="<?= BASE_URL ?>/admin/movies" class="<?= ($active ?? '')=='movies'?'active':'' ?>">
            <i class="fa-solid fa-film"></i> Movies
        </a>

        <a href="<?= BASE_URL ?>/admin/categories" class="<?= ($active ?? '')=='categories'?'active':'' ?>">
            <i class="fa-solid fa-tags"></i> Categories
        </a>

        <a href="<?= BASE_URL ?>/admin/authors" class="<?= ($active ?? '')=='authors'?'active':'' ?>">
            <i class="fa-solid fa-pen-nib"></i> Authors
        </a>

        <a href="<?= BASE_URL ?>/admin/users" class="<?= ($active ?? '')=='users'?'active':'' ?>">
            <i class="fa-solid fa-users"></i> Users
        </a>

        <a href="<?= BASE_URL ?>/admin" class="<?= ($active ?? '')=='dashboard'?'active':'' ?>">
            <i class="fa-solid fa-arrow-left"></i> Về trang chủ
        </a>
    </div>
    <!-- MAIN -->
    <div class="main">

        <div class="admin-header">
            <div class="user-box">
                <i class="fa-solid fa-user"></i>
                <?= $_SESSION['user']['username'] ?? 'Admin' ?>
            </div>
            <a class="logout" href="<?= BASE_URL ?>/logout">
                <i class="fa-solid fa-right-from-bracket"></i>
                Đăng xuất
            </a>
        </div>
        <div class="content-box">
            <?= $content ?>
        </div>
    </div>

</body>

</html>