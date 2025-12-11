<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? "MovieFlix" ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/site.css">
</head>
<body>
<?php require __DIR__ . "/header.php"; ?>
<div style="margin-top:80px;">
    <?= $content ?>
</div>
<?php require __DIR__ . "/footer.php"; ?>

</body>
</html>
