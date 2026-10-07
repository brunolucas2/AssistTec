document.querySelectorAll(".client-tab[data-tab]").forEach(botao => {
    botao.addEventListener("click", () => {
        document.querySelectorAll(".client-template").forEach(template => {
            template.hidden = true;
        });

        document.querySelectorAll(".client-tab").forEach(item => {
            item.classList.remove("active");
        });

        document.querySelector(`#template-${botao.dataset.tab}`).hidden = false;
        botao.classList.add("active");
    });
});