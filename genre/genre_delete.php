<?php
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../models.php';

$id = $_GET['id'];

deleteGenre($pdo, $id);

flash("Xóa thể loại thành công!");
header("Location: genre.php");
exit;
