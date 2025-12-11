<?php ob_start(); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<div class="hero">
    <div class="hero-content">
        <h1 class="hero-title">Xem phim chất lượng cao</h1>
        <p class="hero-desc">Xem phim miễn phí – cập nhật liên tục – trải nghiệm như Netflix.</p>

        <div class="btn-row">
            <button class="btn-play"><i class="fa-solid fa-play"></i> Xem ngay</button>
            <button class="btn-info"><i class="fa-solid fa-circle-info"></i> Chi tiết</button>
        </div>
    </div>
    <div class="fade-bottom"></div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layout/site.php';
?>
