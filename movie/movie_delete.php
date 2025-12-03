<?php
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../models.php';

$id = $_GET['id'];
$movie = getMovie($pdo, $id);

if ($movie && $movie['poster']) {
    $file = __DIR__ . '/../uploads/' . $movie['poster'];
    if (file_exists($file)) unlink($file);
}

deleteMovie($pdo, $id);

flash("Đã xóa phim");
header("Location: ../index.php");
exit;
