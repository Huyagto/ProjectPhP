<?php
ob_start();
function circleOffset($value)
{
    $max = 40;
    if ($value > $max) $value = $max;
    $percent = $value / $max;
    return 188 - (188 * $percent);
}
?>
<link rel="stylesheet" href="assets/css/admin-main.css">
<div class="dashboard-wrapper">

    <h1 class="dashboard-title">
        <i class="fa-solid fa-chart-simple"></i> Thống kê hệ thống
    </h1>
<button id="fetchBtn" class="fetch-btn">
    <i class="fa-solid fa-cloud-arrow-down"></i> Fetch dữ liệu mới từ TMDB
</button>

<div id="toastBox"></div>



    <!-- GRID -->
    <div class="stats-grid">

        <!-- USERS -->
        <div class="stat-card">
            <div>
                <div class="stat-icon">👤</div>
                <div class="stat-label">Người dùng</div>
                <div class="stat-value"><?= $totalUsers ?></div>
            </div>

            <div class="circle-box">
                <svg width="85" height="85">
                    <circle cx="42" cy="42" r="30" class="circle-bg"></circle>
                    <circle cx="42" cy="42" r="30"
                        class="circle-progress"
                        stroke-dasharray="188"
                        stroke-dashoffset="<?= circleOffset($totalUsers) ?>"></circle>
                </svg>
                <div class="circle-number"><?= $totalUsers ?></div>
            </div>
        </div>

        <!-- MOVIES -->
        <div class="stat-card">
            <div>
                <div class="stat-icon">🎬</div>
                <div class="stat-label">Phim</div>
                <div class="stat-value"><?= $totalMovies ?></div>
            </div>

            <div class="circle-box">
                <svg width="85" height="85">
                    <circle cx="42" cy="42" r="30" class="circle-bg"></circle>
                    <circle cx="42" cy="42" r="30"
                        class="circle-progress"
                        stroke-dasharray="188"
                        stroke-dashoffset="<?= circleOffset($totalMovies) ?>"></circle>
                </svg>
                <div class="circle-number"><?= $totalMovies ?></div>
            </div>
        </div>

        <!-- CATEGORIES -->
        <div class="stat-card">
            <div>
                <div class="stat-icon">🏷️</div>
                <div class="stat-label">Thể loại</div>
                <div class="stat-value"><?= $totalCats ?></div>
            </div>

            <div class="circle-box">
                <svg width="85" height="85">
                    <circle cx="42" cy="42" r="30" class="circle-bg"></circle>
                    <circle cx="42" cy="42" r="30"
                        class="circle-progress"
                        stroke-dasharray="188"
                        stroke-dashoffset="<?= circleOffset($totalCats) ?>"></circle>
                </svg>
                <div class="circle-number"><?= $totalCats ?></div>
            </div>
        </div>

        <!-- AUTHORS -->
        <div class="stat-card">
            <div>
                <div class="stat-icon">✍️</div>
                <div class="stat-label">Tác giả</div>
                <div class="stat-value"><?= $totalAuthors ?></div>
            </div>

            <div class="circle-box">
                <svg width="85" height="85">
                    <circle cx="42" cy="42" r="30" class="circle-bg"></circle>
                    <circle cx="42" cy="42" r="30"
                        class="circle-progress"
                        stroke-dasharray="188"
                        stroke-dashoffset="<?= circleOffset($totalAuthors) ?>"></circle>
                </svg>
                <div class="circle-number"><?= $totalAuthors ?></div>
            </div>
        </div>

    </div>

    <!-- BIỂU ĐỒ -->
    <div class="chart-box">
        <div class="chart-title">📊 Lượng phim theo năm</div>
        <canvas id="movieChart" height="120"></canvas>
    </div>

</div>
<?php
$years = [];
$counts = [];

foreach ($movieStats as $row) {
    $years[]  = $row['year'];
    $counts[] = $row['total'];
}
?>

<script>
    window.DASHBOARD_DATA = {
        years: <?= json_encode($years) ?>,
        movieCounts: <?= json_encode($counts) ?>,
        fetchUrl: "<?= BASE_URL ?>/admin/movies/fetch"
    };
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="<?= BASE_URL ?>/assets/js/admin.js"></script>


