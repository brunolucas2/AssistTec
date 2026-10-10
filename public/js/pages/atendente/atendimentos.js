const filtrosAtendimentos = document.querySelector("#filtros-atendimentos");
const listaAtendimentos = document.querySelector("#lista-atendimentos");
const statusAtendimentos = document.querySelector("#atendimentos-status");
const modeloAtendimento = document.querySelector("#linha-atendimento");
const modalAtendimento = document.querySelector("#modal-atendimento");
const formAtualizarAtendimento = document.querySelector("#form-atualizar-atendimento");
const formDeletarAtendimento = document.querySelector("#form-deletar-atendimento");

let atendimentos = [];

const camposDaLista = [
    "id_ordem", "numero_da_os", "nome_cliente", "tipo_equipamento",
    "marca_equipamento", "nome_tecnico", "data_de_abertura", "prioridade", "status"
];

const camposDeDetalhes = [
    "id_ordem", "id_cliente", "id_equipamento", "id_tecnico", "numero_da_os",
    "data_de_abertura", "data_de_previsao", "problema_relatado", "diagnostico",
    "servico", "prioridade", "valor_estimado", "valor_final", "forma_de_pagamento",
    "status", "observacoes", "nome_cliente", "tipo_equipamento", "marca_equipamento",
    "numero_de_serie", "patrimonio", "nome_tecnico"
];

const camposParaAtualizar = [
    "diagnostico", "servico", "prioridade", "valor_estimado", "valor_final",
    "forma_de_pagamento", "status", "observacoes"
];

function abrirPainelAtendimentos(nome) {
    document.querySelectorAll(".atendimentos-painel").forEach(painel => {
        painel.hidden = painel.id !== `template-${nome}`;
    });

    document.querySelectorAll(".atendimentos-abas [data-tab]").forEach(aba => {
        aba.classList.toggle("active", aba.dataset.tab === nome);
    });
}

async function carregarAtendimentos() {
    try {
        const resposta = await fetch(filtrosAtendimentos.action);
        if (!resposta.ok) {
            throw new Error(`Erro HTTP: ${resposta.status}`);
        }

        const resultado = await resposta.json();
        if (!Array.isArray(resultado)) {
            throw new Error("A resposta não contém uma lista de ordens de serviço.");
        }

        atendimentos = resultado;
        mostrarAtendimentos(atendimentos);
    } catch (erro) {
        console.error(erro);
        atendimentos = [];
        listaAtendimentos.replaceChildren();
        statusAtendimentos.textContent = "Não foi possível carregar as ordens de serviço.";
    }
}

function mostrarAtendimentos(lista) {
    listaAtendimentos.replaceChildren();

    lista.forEach(atendimento => {
        const linha = modeloAtendimento.content.cloneNode(true);
        const tr = linha.querySelector("tr");
        tr.dataset.id = atendimento.id_ordem;
        tr.tabIndex = 0;
        tr.setAttribute("aria-label", `Ver detalhes da ordem ${atendimento.numero_da_os ?? atendimento.id_ordem}`);

        camposDaLista.forEach(campo => {
            const celula = linha.querySelector(`[data-campo="${campo}"]`);
            if (!celula) {
                throw new Error(`Não encontrei data-campo="${campo}" no template.`);
            }
            celula.textContent = atendimento[campo] ?? "";
        });

        listaAtendimentos.appendChild(linha);
    });

    statusAtendimentos.textContent = lista.length
        ? `${lista.length} ordem(ns) de serviço encontrada(s).`
        : "Nenhuma ordem de serviço encontrada.";
}

async function buscarAtendimento(id) {
    const url = new URL(filtrosAtendimentos.action);
    url.searchParams.set("rota", "buscarOrdem");
    url.searchParams.set("id_ordem", id);

    const resposta = await fetch(url);
    const atendimento = await resposta.json();

    if (!resposta.ok) {
        throw new Error(atendimento.erro || "Não foi possível buscar a ordem de serviço.");
    }
    return atendimento;
}

async function mostrarDetalhesAtendimento(id) {
    camposDeDetalhes.forEach(campo => {
        modalAtendimento.querySelector(`[data-detalhe="${campo}"]`).textContent = "Carregando...";
    });

    modalAtendimento.showModal();
    try {
        const atendimento = await buscarAtendimento(id);
        camposDeDetalhes.forEach(campo => {
            modalAtendimento.querySelector(`[data-detalhe="${campo}"]`).textContent =
                atendimento[campo] ?? "Não informado";
        });
    } catch (erro) {
        console.error(erro);
        modalAtendimento.close();
        alert(erro.message);
    }
}

function dataParaInput(data) {
    return data ? String(data).replace(" ", "T").slice(0, 19) : "";
}

function prepararDataDePrevisao(formulario) {
    const visivel = formulario.querySelector("[data-data-previsao]");
    const oculto = formulario.elements.namedItem("data_de_previsao");
    const data = visivel.value.replace("T", " ");
    oculto.value = data && data.length === 16 ? `${data}:00` : data;
}

filtrosAtendimentos.addEventListener("submit", evento => {
    evento.preventDefault();
    const dados = new FormData(filtrosAtendimentos);
    const campos = ["id_ordem", "numero_da_os", "nome_cliente", "numero_de_serie", "nome_tecnico"];
    const filtros = Object.fromEntries(campos.map(campo => [
        campo, String(dados.get(campo) ?? "").trim().toLowerCase()
    ]));
    const prioridade = String(dados.get("prioridade") ?? "");
    const status = String(dados.get("status") ?? "");

    const filtrados = atendimentos.filter(atendimento =>
        campos.every(campo => String(atendimento[campo] ?? "").toLowerCase().includes(filtros[campo])) &&
        String(atendimento.prioridade ?? "").includes(prioridade) &&
        String(atendimento.status ?? "").includes(status)
    );

    mostrarAtendimentos(filtrados);
});

filtrosAtendimentos.addEventListener("reset", () => {
    setTimeout(() => mostrarAtendimentos(atendimentos), 0);
});

// Os formulários de cadastro e atualização seguem o POST tradicional do PHP,
// com redirecionamento e mensagem flash; apenas ajustamos o DATETIME para o MySQL.
document.querySelector("#form-cadastrar-atendimento").addEventListener("submit", evento => {
    prepararDataDePrevisao(evento.currentTarget);
});

formAtualizarAtendimento.addEventListener("submit", evento => {
    prepararDataDePrevisao(evento.currentTarget);
});

// A troca de painéis é local; o equipamentos.js não contém esse handler.
document.querySelector(".atendimentos-painel-principal").addEventListener("click", evento => {
    const aba = evento.target.closest("[data-tab]");
    if (aba) {
        abrirPainelAtendimentos(aba.dataset.tab);
    }
});

listaAtendimentos.addEventListener("click", async evento => {
    const botao = evento.target.closest("[data-acao]");

    if (botao) {
        const linha = botao.closest("tr[data-id]");
        if (!linha) return;
        const id = linha.dataset.id;
        const atendimento = atendimentos.find(item => String(item.id_ordem) === id);
        if (!atendimento) return;

        if (botao.dataset.acao === "atualizar") {
            try {
                const detalhes = await buscarAtendimento(id);
                formAtualizarAtendimento.elements.namedItem("id_ordem").value = id;
                document.querySelector("#id-atendimento-atualizar").textContent = id;
                camposParaAtualizar.forEach(campo => {
                    formAtualizarAtendimento.elements.namedItem(campo).value = detalhes[campo] ?? "";
                });
                formAtualizarAtendimento.querySelector('[data-data-previsao="atualizar"]').value =
                    dataParaInput(detalhes.data_de_previsao);
                abrirPainelAtendimentos("atualizar");
            } catch (erro) {
                console.error(erro);
                alert(erro.message);
            }
        }

        if (botao.dataset.acao === "deletar") {
            formDeletarAtendimento.elements.namedItem("id_ordem").value = id;
            document.querySelector("#numero-atendimento-deletar").textContent =
                atendimento.numero_da_os ?? id;
            abrirPainelAtendimentos("deletar");
        }
        return;
    }

    const linha = evento.target.closest("tr[data-id]");
    if (linha) {
        await mostrarDetalhesAtendimento(linha.dataset.id);
    }
});

listaAtendimentos.addEventListener("keydown", evento => {
    const linha = evento.target.closest("tr[data-id]");
    if (!linha || evento.target !== linha) return;

    if (evento.key === "Enter" || evento.key === " ") {
        evento.preventDefault();
        mostrarDetalhesAtendimento(linha.dataset.id);
    }
});

document.querySelector("#fechar-modal-atendimento").addEventListener("click", () => {
    modalAtendimento.close();
});

modalAtendimento.addEventListener("click", evento => {
    if (evento.target === modalAtendimento) {
        modalAtendimento.close();
    }
});

formDeletarAtendimento.addEventListener("submit", async evento => {
    evento.preventDefault();
    const formulario = evento.currentTarget;

    try {
        const resposta = await fetch(formulario.action, {
            method: "POST",
            body: new FormData(formulario)
        });
        const resultado = await resposta.json();
        if (!resposta.ok) {
            throw new Error(resultado.erro || "Não foi possível cancelar a ordem de serviço.");
        }

        abrirPainelAtendimentos("lista");
        await carregarAtendimentos();
    } catch (erro) {
        console.error(erro);
        alert(erro.message);
    }
});

carregarAtendimentos();