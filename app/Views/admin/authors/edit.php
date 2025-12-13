<link rel="stylesheet" href="assets/css/admin.css">
<div class="page-title">
    <i class="fa-solid fa-user-edit"></i>
    <span>Sửa tác giả</span>
</div>

<div class="form-card">
    <form action="<?= BASE_URL ?>/admin/authors/update/<?= $author['id'] ?>" method="POST">

        <label>Tên tác giả</label>
        <input class="input-parent" type="text" name="name" 
               value="<?= htmlspecialchars($author['name']) ?>" required>

        <button class="btn-submit" type="submit">Cập nhật</button>
    </form>
</div>
