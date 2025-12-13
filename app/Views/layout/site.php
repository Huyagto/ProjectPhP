<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? "MovieFlix") ?></title>

    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/site.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

<?php require __DIR__ . "/header_site.php"; ?>

<div class="site-content">
    <?= $content ?>
</div>
<?php require __DIR__ . "/footer_site.php"; ?>

</body>
</html>
