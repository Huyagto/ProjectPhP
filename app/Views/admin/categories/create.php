<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin.css">

<div class="form-card">
    <h2><i class="fa-solid fa-plus"></i> Thêm thể loại</h2>

    <form action="<?= BASE_URL ?>/admin/categories/store" method="POST">
        <label>Tên thể loại:</label>
        <input type="text" name="name" class="input-parent" required>

        <button class="btn-submit" type="submit">Thêm</button>
    </form>
</div>
