function showToast(msg, type = "success") {
    const box = document.getElementById("toastBox");
    if (!box) return;

    const toast = document.createElement("div");
    toast.className = "toast" + (type === "error" ? " error" : "");
    toast.textContent = msg;

    box.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = 0;
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
document.addEventListener("DOMContentLoaded", () => {

    const data = window.DASHBOARD_DATA;
    if (!data) return;
    const chartCanvas = document.getElementById("movieChart");
    if (chartCanvas && typeof Chart !== "undefined") {
        new Chart(chartCanvas, {
            type: "bar",
            data: {
                labels: data.years,
                datasets: [{
                    label: "Số lượng phim theo năm",
                    data: data.movieCounts,
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
    }
    const fetchBtn = document.getElementById("fetchBtn");
    if (fetchBtn) {
        fetchBtn.addEventListener("click", () => {
            fetchBtn.classList.add("loading");

            fetch(data.fetchUrl)
                .then(res => res.json())
                .then(res => {
                    fetchBtn.classList.remove("loading");
                    showToast("✔ " + res.message, "success");
                    setTimeout(() => location.reload(), 1200);
                })
                .catch(err => {
                    fetchBtn.classList.remove("loading");
                    showToast("❌ Lỗi fetch dữ liệu!", "error");
                    console.error(err);
                });
        });
    }
});
