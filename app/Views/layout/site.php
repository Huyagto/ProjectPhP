<!DOCTYPE html>
<html lang="vi">
<head>
    <base href="<?= rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') ?>/">
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? "MovieFlix") ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/site.css">
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
