function toggleLab() {
    const panel = document.getElementById("labPanel");
    panel.style.display = (panel.style.display === "block") ? "none" : "block";
}

function toggleBuoi(i) {
    const el = document.getElementById("buoi" + i);
    el.style.display = (el.style.display === "block") ? "none" : "block";
}
