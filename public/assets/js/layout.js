/* ============================
   PROFILE DROPDOWN (FINAL VERSION)
============================ */

// Toggle dropdown bằng event delegation
document.addEventListener("click", function (e) {

    const avatar = e.target.closest(".avatar-btn");
    const menus = document.querySelectorAll(".dropdown-menu");

    // Nếu click vào avatar → toggle menu tương ứng
    if (avatar) {
        const menuId = avatar.getAttribute("data-menu");
        const currentMenu = document.getElementById(menuId);

        // Đóng tất cả trừ menu hiện tại
        menus.forEach(m => {
            if (m !== currentMenu) m.style.display = "none";
        });

        currentMenu.style.display =
            currentMenu.style.display === "block" ? "none" : "block";

        return; // Dừng để không đóng menu ngay sau khi mở
    }

    // Nếu click bên trong dropdown → không đóng
    if (e.target.closest(".dropdown-menu")) return;

    // Click ra ngoài → đóng tất cả
    menus.forEach(m => (m.style.display = "none"));
});


/* ============================
   SCROLL TO TOP (OPTIONAL)
============================ */

const scrollTopBtn = document.getElementById("scrollTopBtn");
if (scrollTopBtn) {
    scrollTopBtn.addEventListener("click", () => {
        window.scrollTo({ top: 0, behavior: "smooth" });
    });
}
