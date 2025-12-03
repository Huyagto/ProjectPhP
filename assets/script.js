// assets/script.js
function previewPoster(input, previewId) {
    const file = input.files[0];
    const img = document.getElementById(previewId);
    if (!file) { img.src = ''; return; }
    const reader = new FileReader();
    reader.onload = function(e){ img.src = e.target.result; }
    reader.readAsDataURL(file);
  }
  