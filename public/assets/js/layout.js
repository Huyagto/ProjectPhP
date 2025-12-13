document.addEventListener("click", function (e) {
    const avatar = e.target.closest(".avatar-btn");
    const menus = document.querySelectorAll(".dropdown-menu");
    if (avatar) {
        const menuId = avatar.getAttribute("data-menu");
        const currentMenu = document.getElementById(menuId);
        menus.forEach(m => {
            if (m !== currentMenu) m.style.display = "none";
        });
        currentMenu.style.display =
            currentMenu.style.display === "block" ? "none" : "block";

        return;
    }
    if (e.target.closest(".dropdown-menu")) return;
    menus.forEach(m => (m.style.display = "none"));
});
const scrollTopBtn = document.getElementById("scrollTopBtn");
if (scrollTopBtn) {
    scrollTopBtn.addEventListener("click", () => {
        window.scrollTo({ top: 0, behavior: "smooth" });
    });
}
