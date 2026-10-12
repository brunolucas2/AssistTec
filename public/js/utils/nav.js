const sidebar = document.querySelector("#sidebar");
const menuToggle = document.querySelector("#menuToggle");

if (sidebar) {
    const links = sidebar.querySelectorAll(".menu .link-menu");
    const paginaAtual = window.location.pathname.split("/").pop();

    links.forEach(link => {
        const paginaDoLink = new URL(link.href).pathname.split("/").pop();

        link.classList.toggle("active", paginaDoLink === paginaAtual);
    });
}

if (sidebar && menuToggle) {
    menuToggle.addEventListener("click", () => {
        const aberto = sidebar.classList.toggle("open");

        menuToggle.setAttribute("aria-expanded", String(aberto));
        menuToggle.setAttribute("aria-label", aberto ? "Fechar menu" : "Abrir menu");
    });
}

document.querySelectorAll(".abas button[data-tab]").forEach(botao => {
    botao.addEventListener("click", () => {
        const destino = document.querySelector(`#template-${botao.dataset.tab}`);
        if (!destino) return;

        document.querySelectorAll(".client-template").forEach(template => {
            template.hidden = true;
        });

        document.querySelectorAll(".abas button[data-tab]").forEach(item => {
            item.classList.remove("active");
        });

        destino.hidden = false;
        botao.classList.add("active");
    });
});