<?php
ob_start(); // layout chính

// Hàm tính vòng tròn
function circleOffset($value)
{
    $max = 40;
    if ($value > $max) $value = $max;
    $percent = $value / $max;
    return 188 - (188 * $percent);
}
?>
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin-main.css">
<div class="dashboard-wrapper">

    <h1 class="dashboard-title">
        <i class="fa-solid fa-chart-simple"></i> Thống kê hệ thống
    </h1>

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

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('movieChart');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["2019", "2020", "2021", "2022", "2023", "2024"],
        datasets: [{
            label: "Số lượng phim",
            data: [3, 5, 8, 12, 15, <?= $totalMovies ?>],
            backgroundColor: "rgba(255, 50, 50, 0.7)"
        }]
    },
    options: {
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
