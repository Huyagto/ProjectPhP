<div class="profile-container">

    <h2 class="profile-header-title">Trang cá nhân</h2>

    <div class="profile-info-box">

        <!-- Avatar lớn -->
        <img onclick="openPopup()"
             class="profile-avatar"
             src="<?= BASE_URL ?>/assets/img/<?= $user['avatar'] ?: 'default-avatar.png' ?>"
             alt="Avatar">

        <!-- Form cập nhật thông tin -->
        <form action="<?= BASE_URL ?>/user/profile/update" 
              method="POST" 
              class="profile-form">

            <label>Tên hiển thị:</label>
            <input type="text" name="display_name" value="<?= $user['display_name'] ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?= $user['email'] ?>" required>

            <button class="profile-save-btn">Lưu thay đổi</button>
        </form>

    </div>

    <hr>

    <h3 class="profile-section-title">Danh sách phim của bạn</h3>

    <div class="profile-movie-grid">
        <?php foreach ($movies as $m): ?>
            <div class="profile-movie-card">
                <img src="https://image.tmdb.org/t/p/w300<?= $m['poster'] ?>">
                <p><?= $m["title"] ?></p>

                <form action="<?= BASE_URL ?>/watchlist/delete" method="POST">
                    <input type="hidden" name="movie_id" value="<?= $m['id'] ?>">
                    <button class="remove-btn">Xóa khỏi danh sách</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>

</div>


<!-- POPUP Avatar -->
<div id="avatarPopup" class="popup hidden">
    <div class="popup-content">

        <h3>Chọn avatar của bạn</h3>

        <div class="avatar-list-popup">
            <?php foreach ($avatars as $av): ?>
                <form action="<?= BASE_URL ?>/user/profile/avatar" method="POST">
                    <input type="hidden" name="avatar" value="<?= $av ?>">
                    <button class="avatar-choice">
                        <img src="<?= BASE_URL ?>/assets/img/<?= $av ?>">
                    </button>
                </form>
            <?php endforeach; ?>
        </div>

        <button class="close-popup" onclick="closePopup()">Đóng</button>

    </div>
</div>

<script src="<?= BASE_URL ?>/assets/js/user-profile.js"></script>
