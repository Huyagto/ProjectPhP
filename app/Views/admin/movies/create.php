<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin.css">

<div class="form-card">
    <div class="form-title">
        <i class="fa-solid fa-circle-plus"></i>
        <span>Thêm phim mới</span>
    </div>

    <form method="POST" enctype="multipart/form-data">

        <label>Tiêu đề</label>
        <input type="text" name="title" required class="input-parent">

        <label>Mô tả</label>
        <textarea name="description" class="textarea"></textarea>

        <label>Năm sản xuất</label>
        <input type="number" name="year" class="input-parent">

        <label>Ngày phát hành</label>
        <input type="date" name="release_date" class="input-parent">

        <label>Điểm rating</label>
        <input type="number" name="rating" step="0.1" class="input-parent">

        <label>Thời lượng (phút)</label>
        <input type="number" name="duration" class="input-parent">

        <label>Trailer (YouTube ID)</label>
        <input type="text" name="trailer" class="input-parent">

        <label>Tác giả</label>
        <select name="author_id" class="select">
            <?php foreach ($authors as $a): ?>
                <option value="<?= $a['id'] ?>"><?= $a['name'] ?></option>
            <?php endforeach; ?>
        </select>

        <label>Thể loại</label>
        <div class="list">
            <?php foreach ($categories as $c): ?>
                <label>
                    <input type="checkbox" name="categories[]" value="<?= $c['id'] ?>">
                    <?= $c['name'] ?>
                </label>
            <?php endforeach; ?>
        </div>

        <label>Poster</label>
        <input type="file" name="poster" class="input-parent">

        <label>Backdrop</label>
        <input type="file" name="backdrop" class="input-parent">

        <button type="submit" class="btn-submit">Thêm phim</button>

    </form>
</div>
