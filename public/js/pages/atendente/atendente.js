const sidebar = document.querySelector("#sidebar");
const menuToggle = document.querySelector("#menuToggle");

menuToggle.addEventListener("click", () => {
    const aberto = sidebar.classList.toggle("open");
    menuToggle.setAttribute("aria-expanded", aberto);
});

document.querySelectorAll(".menu-link").forEach((link) => {
    link.addEventListener("click", () => {
        sidebar.classList.remove("open");
        menuToggle.setAttribute("aria-expanded", "false");
    });
});