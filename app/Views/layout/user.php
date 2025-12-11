<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? "MovieFlix" ?></title>

    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/user.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>

<header class="nf-header">

    <a href="<?= BASE_URL ?>/user/home" class="logo">MOVIEFLIX</a>

    <div class="right">
        <form action="<?= BASE_URL ?>/search" method="GET" class="nf-search">
            <input type="text" name="q" placeholder="Tìm kiếm...">
            <i class="fa-solid fa-magnifying-glass"></i>
        </form>

        <div class="nf-user">
            <i class="fa-solid fa-user"></i>
            <a href="<?= BASE_URL ?>/logout">Đăng xuất</a>
        </div>
    </div>

</header>

<div class="nf-content">
