<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin.css">

<div class="form-card">

    <div class="form-title">
        <i class="fa-solid fa-circle-plus"></i>
        <span>Thêm phim mới</span>
    </div>

    <form method="POST" enctype="multipart/form-data">

        <!-- Title -->
        <label>Tiêu đề</label>
        <input type="text" name="title" class="input-parent" required>

        <!-- Description -->
        <label>Mô tả</label>
        <textarea name="description" class="textarea"></textarea>

        <!-- Year -->
        <label>Năm sản xuất</label>
        <input type="number" name="year" class="input-parent">

        <!-- Release Date -->
        <label>Ngày phát hành</label>
        <input type="date" name="release_date" class="input-parent">

        <!-- Rating -->
        <label>Điểm rating</label>
        <input type="number" step="0.1" name="rating" class="input-parent">

        <!-- Duration -->
        <label>Thời lượng (phút)</label>
        <input type="number" name="duration" class="input-parent">

        <!-- Trailer -->
        <label>Trailer (YouTube ID)</label>
        <input type="text" name="trailer" class="input-parent">

        <!-- Author -->
        <label>Tác giả</label>
        <select name="author_id" class="select">
            <?php foreach ($authors as $a): ?>
                <option value="<?= $a['id'] ?>">
                    <?= htmlspecialchars($a['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Categories -->
        <label>Thể loại</label>
        <div class="list">
            <?php foreach ($categories as $c): ?>
                <label>
                    <input type="checkbox"
                           name="categories[]"
                           value="<?= $c['id'] ?>">
                    <?= htmlspecialchars($c['name']) ?>
                </label>
            <?php endforeach; ?>
        </div>

        <!-- Poster -->
        <label>Poster</label>
        <input type="file" name="poster" class="input-parent" accept="image/*">

        <!-- Backdrop -->
        <label>Backdrop</label>
        <input type="file" name="backdrop" class="input-parent" accept="image/*">

        <button type="submit" class="btn-submit">
            Thêm phim
        </button>

    </form>

</div>
