<link rel="stylesheet" href="assets/css/admin.css">
<div class="page-title">
    <i class="fa-solid fa-pen-nib"></i>
    <span>Thêm tác giả</span>
</div>

<div class="form-card">
    <form action="<?= BASE_URL ?>/admin/authors/store" method="POST">


        <label>Tên tác giả</label>
        <input class="input-parent" type="text" name="name" required>

        <button class="btn-submit" type="submit">Thêm</button>
    </form>
</div>
