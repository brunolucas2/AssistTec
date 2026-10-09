const filtrosEquipamentos = document.querySelector("#filtros-equipamentos");
const listaEquipamentos = document.querySelector("#lista-equipamentos");
const statusEquipamentos = document.querySelector("#equipamentos-status");
const modeloEquipamento = document.querySelector("#linha-equipamento");

let equipamentos = [];

async function carregarEquipamentos() {
    try {
        const resposta = await fetch(filtrosEquipamentos.action);

        if (!resposta.ok) {
            throw new Error(`Erro HTTP: ${resposta.status}`);
        }

        equipamentos = await resposta.json();

        if (!Array.isArray(equipamentos)) {
            throw new Error("A resposta não contém uma lista de equipamentos.");
        }

        mostrarEquipamentos(equipamentos);
    } catch (erro) {
        console.error(erro);
        statusEquipamentos.textContent = "Não foi possível carregar os equipamentos.";
    }
}

function mostrarEquipamentos(lista) {
    listaEquipamentos.innerHTML = "";

    lista.forEach(equipamento => {
        const linha = modeloEquipamento.content.cloneNode(true);

        linha.querySelector('[data-campo="id_equipamento"]').textContent =
            equipamento.id_equipamento ?? "";
        linha.querySelector('[data-campo="id_cliente"]').textContent =
            equipamento.id_cliente ?? "";
        linha.querySelector('[data-campo="tipo"]').textContent =
            equipamento.tipo ?? "";
        linha.querySelector('[data-campo="marca"]').textContent =
            equipamento.marca ?? "";
        linha.querySelector('[data-campo="numero_de_serie"]').textContent =
            equipamento.numero_de_serie ?? "";
        linha.querySelector('[data-campo="patrimonio"]').textContent =
            equipamento.patrimonio ?? "";

        listaEquipamentos.appendChild(linha);
    });

    statusEquipamentos.textContent = lista.length
        ? `${lista.length} equipamento(s) encontrado(s).`
        : "Nenhum equipamento encontrado.";
}

filtrosEquipamentos.addEventListener("submit", evento => {
    evento.preventDefault();

    const dados = new FormData(filtrosEquipamentos);
    const idCliente = (dados.get("id_cliente") ?? "").trim();
    const tipo = (dados.get("tipo") ?? "").trim().toLowerCase();
    const marca = (dados.get("marca") ?? "").trim().toLowerCase();
    const serie = (dados.get("numero_de_serie") ?? "").trim().toLowerCase();
    const patrimonio = (dados.get("patrimonio") ?? "").trim().toLowerCase();

    const filtrados = equipamentos.filter(equipamento =>
        String(equipamento.id_cliente ?? "").includes(idCliente) &&
        String(equipamento.tipo ?? "").toLowerCase().includes(tipo) &&
        String(equipamento.marca ?? "").toLowerCase().includes(marca) &&
        String(equipamento.numero_de_serie ?? "").toLowerCase().includes(serie) &&
        String(equipamento.patrimonio ?? "").toLowerCase().includes(patrimonio)
    );

    mostrarEquipamentos(filtrados);
});

filtrosEquipamentos.addEventListener("reset", () => {
    setTimeout(() => mostrarEquipamentos(equipamentos), 0);
});

listaEquipamentos.addEventListener("click", evento => {
    const botao = evento.target.closest("[data-acao]");
    if (!botao) return;

    const linha = botao.closest("tr");
    const id = linha.querySelector('[data-campo="id_equipamento"]').textContent;
    const equipamento = equipamentos.find(item =>
        String(item.id_equipamento) === id
    );

    if (!equipamento) return;

    document.querySelectorAll(".client-template").forEach(template => {
        template.hidden = true;
    });

    if (botao.dataset.acao === "atualizar") {
        const formulario = document.querySelector("#form-atualizar-equipamento");

        document.querySelector("#id-equipamento-atualizar").textContent = id;
        formulario.elements.namedItem("id_equipamento").value = id;

        [
            "tipo",
            "marca",
            "numero_de_serie",
            "patrimonio",
            "descricao",
            "sistema_operacional"
        ].forEach(campo => {
            const input = formulario.elements.namedItem(campo);
            if (input) input.value = equipamento[campo] ?? "";
        });

        // Deixe a senha vazia; só será alterada se uma nova for digitada.
        formulario.elements.namedItem("senha_de_acesso").value = "";

        document.querySelector("#template-atualizar").hidden = false;
    }

    if (botao.dataset.acao === "deletar") {
        document.querySelector(
            '#form-deletar-equipamento [name="id_equipamento"]'
        ).value = id;

        document.querySelector("#serie-equipamento-deletar").textContent =
            equipamento.numero_de_serie ?? id;

        document.querySelector("#template-deletar").hidden = false;
    }
});

document.querySelector("#form-deletar-equipamento")
    .addEventListener("submit", async evento => {
        evento.preventDefault();

        const formulario = evento.currentTarget;

        try {
            const resposta = await fetch(formulario.action, {
                method: "POST",
                body: new FormData(formulario)
            });

            const resultado = await resposta.json();

            if (!resposta.ok) {
                throw new Error(resultado.erro ?? "Não foi possível excluir o equipamento.");
            }

            document.querySelector('[data-tab="lista"]').click();
            await carregarEquipamentos();
        } catch (erro) {
            console.error(erro);
            statusEquipamentos.textContent = erro.message;
        }
    });

carregarEquipamentos();