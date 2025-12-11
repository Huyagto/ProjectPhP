let index = 0;
const slides = document.querySelectorAll('.slide');

setInterval(() => {
    slides[index].classList.remove("active");
    index = (index + 1) % slides.length;
    slides[index].classList.add("active");
}, 4500);
function showTrailer() {
    const popup = document.getElementById("trailerPopup");
    const frame = document.getElementById("trailerFrame");
    popup.style.display = "flex";
    frame.src = "https://www.youtube.com/embed/<?= $youtubeKey ?>?autoplay=1";
}

function closeTrailer() {
    const popup = document.getElementById("trailerPopup");
    const frame = document.getElementById("trailerFrame");
    popup.style.display = "none";
    frame.src = ""; // stop video
}

document.querySelector(".nf-btn.play").addEventListener("click", showTrailer);