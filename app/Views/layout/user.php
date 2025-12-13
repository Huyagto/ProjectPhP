<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? "MovieFlix") ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/user.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/movie-detail.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <?php require __DIR__ . "/header.php"; ?>
    <div class="nf-content">
        <?= $content ?>
    </div>
    <?php require __DIR__ . "/footer.php"; ?>
    <script src="<?= BASE_URL ?>/assets/js/layout.js"></script>
</body>
</html>
