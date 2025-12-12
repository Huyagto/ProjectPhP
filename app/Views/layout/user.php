<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? "MovieFlix" ?></title>

    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        .nf-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background: black;
            color: white;
            position: sticky;
            top: 0;
            z-index: 999;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #e50914;
            text-decoration: none;
        }
        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .search-box {
            display: flex;
            align-items: center;
            background: #111;
            padding: 6px;
            border-radius: 6px;
        }
        .search-box input {
            background: transparent;
            border: none;
            outline: none;
            color: white;
            padding: 6px;
        }
        .search-box button {
            background: transparent;
            border: none;
            color: white;
            cursor: pointer;
        }
        .display-name {
            font-size: 16px;
            margin-right: 8px;
            color: #fff;
            font-weight: 500;
        }
        .avatar-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid #fff;
            cursor: pointer;
            object-fit: cover;
        }
        .user-menu {
            position: relative;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 50px;
            background: #111;
            border: 1px solid #333;
            border-radius: 6px;
            width: 170px;
            padding: 10px 0;
            z-index: 9999;
        }
        .dropdown-menu a {
            display: block;
            padding: 10px 15px;
            color: white;
            text-decoration: none;
            font-size: 15px;
        }
        .dropdown-menu a:hover {
            background: #222;
        }
    </style>

</head>

<body>

<header class="nf-header">

    <a href="<?= BASE_URL ?>/user/home" class="logo">MOVIEFLIX</a>

    <div class="header-right">

        <form action="<?= BASE_URL ?>/search" method="GET" class="search-box">
            <input type="text" name="q" placeholder="Tìm kiếm...">
            <button><i class="fa fa-search"></i></button>
        </form>
<?php if (!str_contains($_SERVER["REQUEST_URI"], "/user/profile")): ?>
       <div class="user-menu">

    <span class="display-name">
        <?= $currentUser["display_name"] ?? "" ?>
    </span>

  
<?php 
$avt = $currentUser["avatar"] ?? "";

// Chuẩn hóa đường dẫn
$avt = ltrim($avt, "/");
$avt = str_replace("public/", "", $avt);

// Nếu không có thư mục → ép vào /assets/img/
if (!str_contains($avt, "assets/img/")) {
    $avt = "assets/img/" . basename($avt);
}
?>

<img src="<?= BASE_URL . '/' . $avt ?>" 
     class="avatar-btn"
     onclick="toggleMenu()"
     onerror="this.src='<?= BASE_URL ?>/assets/img/default-avatar.png'">





    <div id="profileMenu" class="dropdown-menu">
        <a href="<?= BASE_URL ?>/user/profile">👤 Trang cá nhân</a>
        <a href="<?= BASE_URL ?>/logout">🚪 Đăng xuất</a>
    </div>

</div>
   <?php endif; ?>

    </div>
</header>

<div class="nf-content">
<script>function toggleMenu() {
    let menu = document.getElementById("profileMenu");
    menu.style.display = menu.style.display === "block" ? "none" : "block";
}

// Đóng menu khi click ra ngoài
document.addEventListener("click", function(e) {

    const menu = document.getElementById("profileMenu");
    const avatar = document.querySelector(".avatar-btn");

    // Nếu click vào avatar → CHỈ toggle, không đóng menu
    if (e.target === avatar) return;

    // Nếu click bên trong menu → không đóng
    if (menu.contains(e.target)) return;

    // Còn lại → đóng
    menu.style.display = "none";
});
</script>