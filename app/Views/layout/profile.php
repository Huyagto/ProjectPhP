<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? "MovieFlix – Profile") ?></title>

    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/user-profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

    <!-- HEADER RIÊNG CHO PROFILE -->
    <header class="profile-header">
        <a href="<?= BASE_URL ?>/user/home" class="logo">MOVIEFLIX</a>
    </header>

    <!-- CONTENT -->
    <div class="nf-content">
        <?= $content ?>
    </div>

    <!-- FOOTER -->
    <?php require __DIR__ . "/footer.php"; ?>

</body>
</html>
