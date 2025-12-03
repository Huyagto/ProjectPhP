<?php
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../models.php';

$id = $_GET['id'];

deleteDirector($pdo, $id);

flash("Xóa đạo diễn thành công!");
header("Location: director.php");
exit;
