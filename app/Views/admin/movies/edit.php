<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin.css">

<div class="form-card">

    <div class="form-title">
        <i class="fa-solid fa-pen-to-square"></i>
        <span>Chỉnh sửa phim</span>
    </div>

    <form method="POST" enctype="multipart/form-data">

        <label>Tiêu đề</label>
        <input type="text" name="title" class="input-parent" value="<?= htmlspecialchars($movie['title']) ?>" required>

        <label>Mô tả</label>
        <textarea name="description" class="textarea"><?= htmlspecialchars($movie['description']) ?></textarea>

        <label>Năm sản xuất</label>
        <input type="number" name="year" class="input-parent" value="<?= $movie['year'] ?>">

        <label>Tác giả</label>
        <select name="author_id" class="select">
            <?php foreach ($authors as $a): ?>
            <option value="<?= $a['id'] ?>" <?= $a['id']==$movie['author_id']?'selected':'' ?>>
                <?= $a['name'] ?>
            </option>
            <?php endforeach; ?>
        </select>

        <label>Thể loại</label>

        <?php 
    $selectedIds = array_column($selected, 'id');
?>

        <div class="list">
            <?php foreach ($categories as $c): ?>
            <label>
                <input type="checkbox" name="categories[]" value="<?= $c['id'] ?>"
                    <?= in_array($c['id'], $selectedIds) ? "checked" : "" ?>>
                <?= $c['name'] ?>
            </label>
            <?php endforeach; ?>
        </div>
        <label>Poster hiện tại</label>

        <?php
$poster = $movie['poster']
    ? (str_starts_with($movie['poster'], '/')
        ? "https://image.tmdb.org/t/p/w300{$movie['poster']}"
        : BASE_URL . "/uploads/" . $movie['poster'])
    : BASE_URL . "/assets/img/no-image.png";
?>

        <img src="<?= $poster ?>" class="poster-preview">


        <label>Thay poster mới</label>
        <input type="file" name="poster" class="input-parent">

        <button class="btn-submit" type="submit">Cập nhật phim</button>

    </form>

</div>