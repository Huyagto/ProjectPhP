<link rel="stylesheet" href="assets/css/admin.css">

<div class="form-card">
    <h2><i class="fa-solid fa-pen"></i> Sửa thể loại</h2>

    <form action="<?= BASE_URL ?>/admin/categories/update/<?= $category['id'] ?>" method="POST">
        <label>Tên thể loại:</label>
        <input type="text" name="name" class="input-parent" 
               value="<?= htmlspecialchars($category['name']) ?>" required>

        <button class="btn-submit" type="submit">Cập nhật</button>
    </form>
</div>
