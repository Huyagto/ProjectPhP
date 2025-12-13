/* =========== home-user.js (smooth version) ============ */

/* Helper: extract youtube id */
function extractYouTubeId(input) {
    if (!input) return null;
    input = input.trim();

    // Case: raw YouTube id
    if (!input.includes("youtube") && !input.includes("youtu.be") && !input.includes("/")) {
        return input;
    }

    const re = /(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/)|\?v=)([A-Za-z0-9_-]{6,})/;
    const m = input.match(re);
    return (m && m[1]) ? m[1] : null;
}

/* Trailer popup open/close */
function openTrailer(key) {
    const popup = document.getElementById("trailerPopup");
    const frame = document.getElementById("trailerFrame");
    if (!popup || !frame) return;

    frame.src = `https://www.youtube.com/embed/${key}?autoplay=1&rel=0`;
    popup.style.display = "flex";
}

function closeTrailer() {
    const popup = document.getElementById("trailerPopup");
    const frame = document.getElementById("trailerFrame");
    if (!popup || !frame) return;

    popup.style.display = "none";
    frame.src = "";
}

/* Close button */
document.addEventListener("click", function(e) {
    if (e.target.classList.contains("close-btn")) {
        closeTrailer();
    }
});

/* Click play button */
document.addEventListener("click", function(e) {
    const btn = e.target.closest(".play-btn");
    if (!btn) return;

    const raw = btn.getAttribute("data-trailer");
    const key = extractYouTubeId(raw);

    if (!key) {
        console.warn("Invalid trailer:", raw);
        return;
    }

    openTrailer(key);
});

/* ==========================
   HERO SLIDER (Auto + Pause)
==========================*/

let slideIndex = 0;
const slides = document.querySelectorAll(".hero-slider .slide");

function goToSlide(nextIndex) {
    if (!slides.length) return;

    slides[slideIndex].classList.remove("active");
    slideIndex = nextIndex % slides.length;
    slides[slideIndex].classList.add("active");
}

function nextSlide() {
    goToSlide((slideIndex + 1) % slides.length);
}

// Autoplay
let sliderInterval = null;

function startAutoSlide() {
    if (sliderInterval) clearInterval(sliderInterval);
    sliderInterval = setInterval(nextSlide, 3000);
}

function stopAutoSlide() {
    if (sliderInterval) {
        clearInterval(sliderInterval);
        sliderInterval = null;
    }
}
if (slides.length) {
    slides.forEach((s, i) => {
        if (s.classList.contains("active")) slideIndex = i;
    });
    startAutoSlide();
}
const sliderEl = document.querySelector(".hero-slider");
if (sliderEl) {
    sliderEl.addEventListener("mouseenter", stopAutoSlide);
    sliderEl.addEventListener("mouseleave", startAutoSlide);
}
