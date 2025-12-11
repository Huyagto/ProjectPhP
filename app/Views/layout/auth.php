<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? "MovieFlix" ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/auth.css">
</head>
<body>
<a href="<?= BASE_URL ?>/home" class="home-btn">
    <i class="fa fa-house"></i> Trang chủ
</a>
<div class="auth-wrapper">
    <?= $content ?>
</div>
</body>
</html>
