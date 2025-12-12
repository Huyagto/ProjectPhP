<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin.css">

<div class="form-card">

    <div class="form-title">
        <i class="fa-solid fa-pen-to-square"></i>
        <span>Chỉnh sửa phim</span>
    </div>

    <form action="<?= BASE_URL ?>/admin/movies/update/<?= $movie['id'] ?>" 
          method="POST" enctype="multipart/form-data">

        <!-- Title -->
        <label>Tiêu đề</label>
        <input type="text" name="title" class="input-parent" 
               value="<?= htmlspecialchars($movie['title']) ?>" required>

        <!-- Description -->
        <label>Mô tả</label>
        <textarea name="description" class="textarea"><?= htmlspecialchars($movie['description']) ?></textarea>

        <!-- Year -->
        <label>Năm sản xuất</label>
        <input type="number" name="year" class="input-parent" value="<?= $movie['year'] ?>">

        <!-- Release Date -->
        <label>Ngày phát hành</label>
        <input type="date" name="release_date" class="input-parent" value="<?= $movie['release_date'] ?>">

        <!-- Rating -->
        <label>Điểm Rating</label>
        <input type="number" step="0.1" name="rating" class="input-parent" value="<?= $movie['rating'] ?>">

        <!-- Duration -->
        <label>Thời lượng (phút)</label>
        <input type="number" name="duration" class="input-parent" value="<?= $movie['duration'] ?>">

        <!-- TMDB ID -->
        <label>TMDB ID</label>
        <input type="number" name="tmdb_id" class="input-parent" value="<?= $movie['tmdb_id'] ?>">

        <!-- Trailer -->
        <label>Trailer (YouTube ID)</label>
        <input type="text" name="trailer" class="input-parent" value="<?= $movie['trailer'] ?>">

        <!-- Author -->
        <label>Tác giả</label>
        <select name="author_id" class="select">
            <?php foreach ($authors as $a): ?>
            <option value="<?= $a['id'] ?>" 
                <?= $a['id']==$movie['author_id'] ? 'selected' : '' ?>>
                <?= $a['name'] ?>
            </option>
            <?php endforeach; ?>
        </select>

        <!-- Categories -->
        <label>Thể loại</label>

        <?php 
            // FIX: lấy danh sách ID đã được chọn
            $selectedIds = $selected;
        ?>

        <div class="list">
            <?php foreach ($categories as $c): ?>
            <label>
                <input type="checkbox" name="categories[]" 
                       value="<?= $c['id'] ?>"
                       <?= in_array($c['id'], $selectedIds) ? "checked" : "" ?>>
                <?= $c['name'] ?>
            </label>
            <?php endforeach; ?>
        </div>

        <!-- Poster preview -->
        <label>Poster hiện tại</label>
        <?php
        $poster = $movie['poster']
            ? (str_starts_with($movie['poster'], '/')
                ? "https://image.tmdb.org/t/p/w300{$movie['poster']}"
                : BASE_URL . "/uploads/" . $movie['poster'])
            : BASE_URL . "/assets/img/no-image.png";
        ?>
        <img src="<?= $poster ?>" class="poster-preview">

        <!-- Upload new Poster -->
        <label>Thay poster mới</label>
        <input type="file" name="poster" class="input-parent">

        <!-- Backdrop -->
        <label>Backdrop hiện tại</label>
        <?php
        $backdrop = $movie['backdrop']
            ? (str_starts_with($movie['backdrop'], '/')
                ? "https://image.tmdb.org/t/p/w500{$movie['backdrop']}"
                : BASE_URL . "/uploads/" . $movie['backdrop'])
            : BASE_URL . "/assets/img/no-image.png";
        ?>
        <img src="<?= $backdrop ?>" class="poster-preview">

        <label>Thay backdrop mới</label>
        <input type="file" name="backdrop" class="input-parent">

        <button class="btn-submit" type="submit">Cập nhật phim</button>

    </form>

</div>
