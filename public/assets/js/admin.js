function showToast(msg, type = "success") {
    const box = document.getElementById("toastBox");
    const toast = document.createElement("div");

    toast.className = "toast " + (type === "error" ? "error" : "");
    toast.innerText = msg;

    box.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = 0;
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

document.getElementById("fetchBtn").onclick = () => {
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