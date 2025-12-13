
function showTrailer() {
    const popup = document.getElementById("trailerPopup");
    const frame = document.getElementById("trailerFrame");

    popup.style.display = "flex";
    frame.src = youtubeTrailerUrl;
}

function closeTrailer() {
    const popup = document.getElementById("trailerPopup");
    const frame = document.getElementById("trailerFrame");

    popup.style.display = "none";
    frame.src = "";
}
function showToast(message) {
    const toast = document.getElementById("toast");
    toast.innerText = message;
    toast.classList.add("show");
    setTimeout(() => toast.classList.remove("show"), 2500);
}
function toggleWatchlist(movieId) {
    fetch(baseUrl + "/watchlist/toggle", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "movie_id=" + movieId
    })
    .then(res => res.text())
    .then(result => {

        result = result.trim();  

        console.log("Server trả về:", result);

        const btn = document.getElementById("watchlist-btn");

        if (result === "added") {
            btn.innerHTML = "<i class='fa-solid fa-check'></i> Đã thêm";
            btn.style.background = "#2ecc71";
            btn.style.color = "white";
            showToast("Đã thêm vào danh sách!");
        }
        else if (result === "removed") {
            btn.innerHTML = "<i class='fa-solid fa-plus'></i> Thêm vào danh sách";
            btn.style.background = "rgba(255,255,255,0.2)";
            btn.style.color = "white";
            showToast("Đã xoá khỏi danh sách!");
        }
        else if (result === "not_logged_in") {
            showToast("❌ Bạn cần đăng nhập trước!");
        }
        else {
            showToast("❌ Lỗi server: " + result);
        }
    });
}
