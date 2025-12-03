<?php
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../models.php';

$tendd = trim($_POST['tendd']);

createDirector($pdo, $tendd);

flash("Thêm đạo diễn thành công!");
header("Location: director.php");
exit;
