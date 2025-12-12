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
    $years[] = $row['year'];
    $counts[] = $row['total'];
}
?>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const years = <?= json_encode($years) ?>;
const movieCounts = <?= json_encode($counts) ?>;

const ctx = document.getElementById('movieChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: years,
        datasets: [{
            label: "Số lượng phim theo năm",
            data: movieCounts,
            backgroundColor: "rgba(255, 60, 60, 0.8)",
            borderRadius: 6,
        }]
    },
    options: {
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>

<script>
function showToast(msg, type = "success") {
    const wrap = document.getElementById("toastBox");
    const toast = document.createElement("div");

    toast.className = "toast" + (type === "error" ? " error" : "");
    toast.textContent = msg;

    wrap.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = 0;
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

document.getElementById("fetchBtn").onclick = function () {
    const btn = document.getElementById("fetchBtn");
    btn.classList.add("loading");

    fetch("<?= BASE_URL ?>/admin/movies/fetch")
        .then(res => res.json())
        .then(data => {
            btn.classList.remove("loading");
            showToast("✔ " + data.message, "success");
            setTimeout(() => location.reload(), 1200);
        })
        .catch(err => {
            btn.classList.remove("loading");
            showToast("❌ Lỗi fetch dữ liệu!", "error");
            console.error(err);
        });
};
</script>

