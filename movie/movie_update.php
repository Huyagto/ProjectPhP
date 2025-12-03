<?php
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../models.php';

$id = $_POST['id'];
$ten = trim($_POST['tenphim']);
$mota = trim($_POST['mota']);
$namsx = $_POST['namsx'] ?: null;
$thoiluong = $_POST['thoiluong'] ?: null;
$gia = $_POST['gia'] ?: null;
$maloai = $_POST['maloai'] ?: null;
$madd = $_POST['madd'] ?: null;

$oldPoster = $_POST['poster_old'];
$newPoster = $oldPoster;

if (!empty($_FILES['poster']['name'])) {
    $f = $_FILES['poster'];
    $ext = pathinfo($f['name'], PATHINFO_EXTENSION);
    $newPoster = uniqid('p_') . '.' . $ext;
    move_uploaded_file($f['tmp_name'], __DIR__ . '/../uploads/' . $newPoster);

    if ($oldPoster && file_exists(__DIR__ . '/../uploads/' . $oldPoster)) {
        unlink(__DIR__ . '/../uploads/' . $oldPoster);
    }
}

updateMovie($pdo, $id, [
    'tenphim'=>$ten,
    'mota'=>$mota,
    'namsx'=>$namsx,
    'thoiluong'=>$thoiluong,
    'gia'=>$gia,
    'poster'=>$newPoster,
    'madd'=>$madd,
    'maloai'=>$maloai
]);

flash("Cập nhật thành công!");
header("Location: ../index.php");
exit;
