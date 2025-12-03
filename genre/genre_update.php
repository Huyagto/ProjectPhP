<?php
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../models.php';

$maloai = $_POST['maloai'];
$tenloai = trim($_POST['tenloai']);

updateGenre($pdo, $maloai, $tenloai);

flash("Cập nhật thể loại thành công!");
header("Location: genre.php");
exit;
