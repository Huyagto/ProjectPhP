<?php require __DIR__."/../layout/user.php"; ?>

<a href="<?= BASE_URL ?>/user/home" class="back-home">⬅ Trang chủ</a>

<div class="profile-page">

    <h2>Trang cá nhân</h2>

    <div class="profile-box">

        <!-- Avatar lớn (click để mở popup) -->
        <img onclick="openPopup()" class="avatar"
            src="<?= BASE_URL ?>/assets/img/<?= $user['avatar'] ?: 'default-avatar.png' ?>"
            alt="Avatar">

        <div class="info">
            
            <!-- Form cập nhật thông tin -->
            <form action="<?= BASE_URL ?>/user/profile/update" method="POST" class="edit-form">
                <label>Tên hiển thị:</label>
                <input type="text" name="display_name" value="<?= $user['display_name'] ?>" required>

                <label>Email:</label>
                <input type="email" name="email" value="<?= $user['email'] ?>" required>

                <button class="save-btn">Lưu thay đổi</button>
            </form>

            <p class="note">Nhấn vào avatar để thay đổi ảnh đại diện.</p>

        </div>

    </div>

    <hr>

    <h3>Danh sách phim của bạn</h3>
    <div class="movie-grid">
       <?php foreach($movies as $m): ?>
    <div class="movie-card">
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



<!-- 🔥 POPUP chọn avatar -->
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



<!-- JS mở / đóng popup -->
<script>
function openPopup() {
    document.getElementById("avatarPopup").classList.remove("hidden");
}
function closePopup() {
    document.getElementById("avatarPopup").classList.add("hidden");
}
</script>



<!-- CSS -->
<style>

.back-home {
    display:inline-block;
    margin:20px 0 10px 40px;
    color:#e50914;
    font-size:18px;
    text-decoration:none;
}
.back-home:hover { text-decoration:underline; }

.profile-page {
    color:white;
    padding:40px;
}

.profile-box {
    display:flex;
    align-items:center;
    gap:40px;
    margin-bottom:30px;
}

.profile-box .avatar {
    width:160px;
    height:160px;
    object-fit:cover;
    border-radius:50%;
    border:4px solid #e50914;
    cursor:pointer;
    transition:0.2s;
}
.profile-box .avatar:hover {
    transform: scale(1.05);
}

.note {
    margin-top: 10px;
    font-size: 14px;
    opacity: 0.7;
}
.remove-btn {
    margin-top: 8px;
    background: #e50914;
    color: white;
    border: none;
    padding: 6px 10px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    width: 100%;
}
.remove-btn:hover {
    opacity: 0.8;
}

.edit-form {
    display:flex;
    flex-direction:column;
    gap:12px;
    width:300px;
}
.edit-form input {
    padding:10px;
    border-radius:6px;
    border:1px solid #444;
    background:#222;
    color:white;
}

.save-btn {
    margin-top:10px;
    padding:10px;
    background:#e50914;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
}
.save-btn:hover { opacity:0.8; }



/* POPUP chọn avatar */
.popup {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.75);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}
.hidden { display: none; }

.popup-content {
    background: #111;
    padding: 25px;
    border-radius: 12px;
    width: 420px;
    text-align: center;
    color: white;
    border: 2px solid #e50914;
}

.avatar-list-popup {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
    margin: 20px 0;
}

.avatar-choice {
    background:none;
    border:2px solid transparent;
    padding:0;
    border-radius:50%;
    cursor:pointer;
    transition:0.2s;
}

.avatar-choice img {
    width:75px;
    height:75px;
    border-radius:50%;
}

.avatar-choice:hover {
    border-color:#e50914;
    transform:scale(1.12);
}

.close-popup {
    padding:10px 20px;
    background:#e50914;
    border:none;
    color:white;
    border-radius:6px;
    cursor:pointer;
}
.close-popup:hover { opacity:0.8; }


.movie-grid {
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(150px,1fr));
    gap:15px;
    margin-top:25px;
}
.movie-card img {
    width:100%;
    border-radius:8px;
}

</style>
