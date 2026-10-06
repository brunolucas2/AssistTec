const abas = document.querySelectorAll(".client-tab");
const formularios = document.querySelectorAll(".client-template");

abas.forEach((aba) => {
    aba.addEventListener("click", () => {
        const selecionada = aba.dataset.tab;

        abas.forEach((item) => {
            const ativa = item === aba;
            item.classList.toggle("active", ativa);
            item.setAttribute("aria-selected", ativa);
        });

        formularios.forEach((formulario) => {
            formulario.hidden = formulario.id !== `template-${selecionada}`;
        });
    });
});

document.querySelectorAll("[data-confirm]").forEach((formulario) => {
    formulario.addEventListener("submit", (evento) => {
        if (!confirm(formulario.dataset.confirm)) {
            evento.preventDefault();
        }
    });
});

const sidebar = document.querySelector("#sidebar");
const menuToggle = document.querySelector("#menuToggle");

if (sidebar && menuToggle) {
    menuToggle.addEventListener("click", () => {
        const aberto = sidebar.classList.toggle("open");
        menuToggle.setAttribute("aria-expanded", aberto);
    });
}