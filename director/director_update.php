<?php
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../models.php';

$madd = $_POST['madd'];
$tendd = trim($_POST['tendd']);

updateDirector($pdo, $madd, $tendd);

flash("Cập nhật đạo diễn thành công!");
header("Location: director.php");
exit;
