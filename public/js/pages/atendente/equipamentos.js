const filtrosEquipamentos = document.querySelector("#filtros-equipamentos");
const listaEquipamentos = document.querySelector("#lista-equipamentos");
const statusEquipamentos = document.querySelector("#equipamentos-status");
const modeloEquipamento = document.querySelector("#linha-equipamento");
const modalEquipamento = document.querySelector("#modal-equipamento");

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
        const tr = linha.querySelector("tr");

        tr.dataset.id = equipamento.id_equipamento;
        tr.tabIndex = 0;

        const campos = {
            id_equipamento: equipamento.id_equipamento,
            cliente: equipamento.cliente,
            tipo: equipamento.tipo,
            marca: equipamento.marca,
            numero_de_serie: equipamento.numero_de_serie,
            patrimonio: equipamento.patrimonio
        };

        Object.entries(campos).forEach(([campo, valor]) => {
            const celula = linha.querySelector(`[data-campo="${campo}"]`);

            if (!celula) {
                throw new Error(`Não encontrei data-campo="${campo}" no template.`);
            }

            celula.textContent = valor ?? "";
        });

        listaEquipamentos.appendChild(linha);
    });

    statusEquipamentos.textContent = lista.length
        ? `${lista.length} equipamento(s) encontrado(s).`
        : "Nenhum equipamento encontrado.";
}

async function buscarEquipamento(id) {
    const url = new URL(filtrosEquipamentos.action);
    url.searchParams.set("rota", "buscarEquipamento");
    url.searchParams.set("id_equipamento", id);

    const resposta = await fetch(url);
    const equipamento = await resposta.json();

    if (!resposta.ok) {
        throw new Error(equipamento.erro || "Não foi possível buscar o equipamento.");
    }

    return equipamento;
}

async function mostrarDetalhesEquipamento(id) {
    const campos = [
        "id_equipamento",
        "id_cliente",
        "cliente",
        "tipo",
        "marca",
        "numero_de_serie",
        "patrimonio",
        "descricao",
        "sistema_operacional",
        "data_de_cadastro",
        "status"
    ];

    campos.forEach(campo => {
        modalEquipamento.querySelector(`[data-detalhe="${campo}"]`).textContent =
            "Carregando...";
    });

    modalEquipamento.showModal();

    try {
        const equipamento = await buscarEquipamento(id);

        campos.forEach(campo => {
            modalEquipamento.querySelector(`[data-detalhe="${campo}"]`).textContent =
                equipamento[campo] ?? "Não informado";
        });
    } catch (erro) {
        console.error(erro);
        modalEquipamento.close();
        alert(erro.message);
    }
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

listaEquipamentos.addEventListener("click", async evento => {
    const botao = evento.target.closest("[data-acao]");

    if (botao) {
        const linha = botao.closest("tr");
        const id = linha.dataset.id;
        const equipamento = equipamentos.find(item =>
            String(item.id_equipamento) === id
        );

        if (!equipamento) return;

        if (botao.dataset.acao === "atualizar") {
            try {
                const detalhes = await buscarEquipamento(id);

                document.querySelectorAll(".client-template").forEach(template => {
                    template.hidden = true;
                });

                const formulario =
                    document.querySelector("#form-atualizar-equipamento");

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
                    formulario.elements.namedItem(campo).value =
                        detalhes[campo] ?? "";
                });

                formulario.elements.namedItem("senha_de_acesso").value = "";
                document.querySelector("#template-atualizar").hidden = false;
            } catch (erro) {
                console.error(erro);
                alert(erro.message);
            }
        }

        if (botao.dataset.acao === "deletar") {
            document.querySelectorAll(".client-template").forEach(template => {
                template.hidden = true;
            });

            document.querySelector(
                '#form-deletar-equipamento [name="id_equipamento"]'
            ).value = id;

            document.querySelector("#serie-equipamento-deletar").textContent =
                equipamento.numero_de_serie ?? id;

            document.querySelector("#template-deletar").hidden = false;
        }

        return;
    }

    const linha = evento.target.closest("tr[data-id]");

    if (linha) {
        await mostrarDetalhesEquipamento(linha.dataset.id);
    }
});

listaEquipamentos.addEventListener("keydown", evento => {
    const linha = evento.target.closest("tr[data-id]");

    if (!linha || evento.target !== linha) return;

    if (evento.key === "Enter" || evento.key === " ") {
        evento.preventDefault();
        mostrarDetalhesEquipamento(linha.dataset.id);
    }
});

document.querySelector("#fechar-modal-equipamento")
    .addEventListener("click", () => {
        modalEquipamento.close();
    });

modalEquipamento.addEventListener("click", evento => {
    if (evento.target === modalEquipamento) {
        modalEquipamento.close();
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
                throw new Error(
                    resultado.erro || "Não foi possível excluir o equipamento."
                );
            }

            document.querySelector('[data-tab="lista"]').click();
            await carregarEquipamentos();
        } catch (erro) {
            console.error(erro);
            alert(erro.message);
        }
    });

carregarEquipamentos();