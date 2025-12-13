<?php 
$currentUser = $currentUser ?? null;
?>

<header class="nf-header">

    <a href="<?= BASE_URL ?>/user/home" class="logo">MOVIEFLIX</a>

    <div class="header-right">

        <form action="<?= BASE_URL ?>/search" method="GET" class="search-box">
            <input type="text" name="q" placeholder="Tìm kiếm...">
            <button><i class="fa fa-search"></i></button>
        </form>

        <?php if ($currentUser): ?>

        <div class="user-menu">

            <span class="display-name">
                <?= htmlspecialchars($currentUser["display_name"]) ?>
            </span>

            <?php 
                $avatar = $currentUser["avatar"] ?? "";
                if ($avatar && file_exists($_SERVER["DOCUMENT_ROOT"] . "/ProjectPhP/public/assets/img/" . $avatar)) {
                    $avatarUrl = BASE_URL . "/assets/img/" . $avatar;
                } 
                else if ($avatar && str_contains($avatar, "assets/img")) {
                    $avatarUrl = BASE_URL . "/" . ltrim($avatar, "/");
                } 
                else {
                    $avatarUrl = BASE_URL . "/assets/img/default-avatar.png";
                }
            ?>

            <img src="<?= $avatarUrl ?>"
                 class="avatar-btn"
                 data-menu="profileMenu"
                 onerror="this.src='<?= BASE_URL ?>/assets/img/default-avatar.png'">

            <div id="profileMenu" class="dropdown-menu">
                <a href="<?= BASE_URL ?>/user/profile">👤 Trang cá nhân</a>
                <a href="<?= BASE_URL ?>/logout">🚪 Đăng xuất</a>
            </div>

        </div>

        <?php endif; ?>

    </div>
</header>
