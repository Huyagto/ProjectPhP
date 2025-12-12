<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? "MovieFlix") ?></title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- CSS dành riêng cho Login / Register -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/auth.css">
</head>

<body>

<!-- NÚT QUAY VỀ TRANG CHỦ -->
<a href="<?= BASE_URL ?>/home" class="home-btn">
    <i class="fa fa-house"></i> Trang chủ
</a>

<!-- FORM LOGIN / REGISTER -->
<div class="auth-wrapper">
    <?= $content ?>
</div>

</body>
</html>
