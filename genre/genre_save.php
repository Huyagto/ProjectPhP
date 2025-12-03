<?php
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../models.php';

$maloai = trim($_POST['maloai']);
$tenloai = trim($_POST['tenloai']);

createGenre($pdo, $maloai, $tenloai);

flash("Thêm thể loại thành công!");
header("Location: genre.php");
exit;
