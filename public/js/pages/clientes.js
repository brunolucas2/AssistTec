const formularioBusca = document.querySelector("#form-filtros-clientes");
const listaClientes = document.querySelector("#lista-clientes");
const statusClientes = document.querySelector("#clientes-status");
const modeloLinha = document.querySelector("#template-linha-cliente");
const modalCliente = document.querySelector("#modal-cliente");

let clientes = [];

async function carregarClientes() {
    try {
        const resposta = await fetch(formularioBusca.action);

        if (!resposta.ok) {
            throw new Error(`Erro HTTP: ${resposta.status}`);
        }

        clientes = await resposta.json();

        if (!Array.isArray(clientes)) {
            throw new Error("A resposta não contém uma lista de clientes.");
        }

        mostrarClientes(clientes);
    } catch (erro) {
        console.error(erro);
        statusClientes.textContent = "Não foi possível carregar os clientes.";
    }
}

function mostrarClientes(clientesExibidos) {
    listaClientes.innerHTML = "";

    clientesExibidos.forEach(cliente => {
        const linha = modeloLinha.content.cloneNode(true);
        const tr = linha.querySelector("tr");

        tr.dataset.cpf = cliente.cpf;
        tr.tabIndex = 0;
        tr.setAttribute("aria-label", `Ver dados de ${cliente.nome}`);

        const campos = {
            id_cliente: cliente.id_cliente,
            nome: cliente.nome,
            cpf: cliente.cpf,
            email: cliente.email,
            telefone: cliente.telefone,
            status: cliente.status,
            cidade: cliente.cidade
        };

        Object.entries(campos).forEach(([campo, valor]) => {
            const celula = linha.querySelector(`[data-campo="${campo}"]`);

            if (celula) {
                celula.textContent = valor ?? "";
            }
        });

        listaClientes.appendChild(linha);
    });

    statusClientes.textContent = clientesExibidos.length
        ? `${clientesExibidos.length} cliente(s) encontrado(s).`
        : "Nenhum cliente encontrado.";
}

async function abrirDetalhesCliente(cpf) {
    const campos = [
        "id_cliente",
        "nome",
        "cpf",
        "email",
        "telefone",
        "logradouro",
        "numero",
        "bairro",
        "cidade",
        "estado",
        "cep",
        "data_de_cadastro",
        "status"
    ];

    try {
        campos.forEach(campo => {
            const elemento = modalCliente.querySelector(`[data-detalhe="${campo}"]`);

            if (!elemento) {
                throw new Error(`Não encontrei data-detalhe="${campo}" no modal.`);
            }

            elemento.textContent = "Carregando...";
        });

        modalCliente.showModal();

        const url = new URL(formularioBusca.action);
        url.searchParams.set("rota", "cliente/buscarCliente");
        url.searchParams.set("cpf", cpf);

        const resposta = await fetch(url);
        const cliente = await resposta.json();

        if (!resposta.ok) {
            throw new Error(cliente.erro || "Não foi possível buscar o cliente.");
        }

        campos.forEach(campo => {
            const elemento = modalCliente.querySelector(`[data-detalhe="${campo}"]`);
            elemento.textContent = cliente?.[campo] ?? "Não informado";
        });
    } catch (erro) {
        console.error(erro);

        if (modalCliente.open) {
            modalCliente.close();
        }

        alert(erro.message);
    }
}

formularioBusca.addEventListener("submit", evento => {
    evento.preventDefault();

    const dados = new FormData(formularioBusca);
    const nome = (dados.get("nome") ?? "").trim().toLowerCase();
    const cpf = (dados.get("cpf") ?? "").trim();
    const cidade = (dados.get("cidade") ?? "").trim().toLowerCase();
    const status = dados.get("status") ?? "";

    const filtrados = clientes.filter(cliente =>
        (cliente.nome ?? "").toLowerCase().includes(nome) &&
        (cliente.cpf ?? "").includes(cpf) &&
        (cliente.cidade ?? "").toLowerCase().includes(cidade) &&
        (!status || cliente.status === status)
    );

    mostrarClientes(filtrados);
});

formularioBusca.addEventListener("reset", () => {
    setTimeout(() => mostrarClientes(clientes), 0);
});

listaClientes.addEventListener("click", async evento => {
    const botao = evento.target.closest("[data-acao]");

    if (botao) {
        const linha = botao.closest("tr");
        const cpf = linha.dataset.cpf;
        const cliente = clientes.find(item => item.cpf === cpf);

        if (!cliente) return;

        document.querySelectorAll(".client-template").forEach(template => {
            template.hidden = true;
        });

        if (botao.dataset.acao === "atualizar") {
            const formulario = document.querySelector("#form-atualizar-cliente");

            document.querySelector("#cpf-cliente-atualizar").textContent = cliente.cpf;
            formulario.elements.namedItem("cpf_atual").value = cliente.cpf;

            [
                "nome",
                "email",
                "telefone",
                "logradouro",
                "numero",
                "bairro",
                "cidade",
                "estado",
                "cep"
            ].forEach(campo => {
                const input = formulario.elements.namedItem(campo);

                if (input) {
                    input.value = cliente[campo] ?? "";
                }
            });

            document.querySelector("#template-atualizar").hidden = false;
        }

        if (botao.dataset.acao === "deletar") {
            document.querySelector('#form-deletar-cliente [name="cpf"]').value =
                cliente.cpf;
            document.querySelector("#nome-cliente-deletar").textContent =
                cliente.nome;
            document.querySelector("#template-deletar").hidden = false;
        }

        return;
    }

    const linha = evento.target.closest("tr[data-cpf]");

    if (linha) {
        await abrirDetalhesCliente(linha.dataset.cpf);
    }
});

listaClientes.addEventListener("keydown", evento => {
    const linha = evento.target.closest("tr[data-cpf]");

    if (!linha || evento.target !== linha) return;

    if (evento.key === "Enter" || evento.key === " ") {
        evento.preventDefault();
        abrirDetalhesCliente(linha.dataset.cpf);
    }
});

document.querySelector("#fechar-modal-cliente").addEventListener("click", () => {
    modalCliente.close();
});

modalCliente.addEventListener("click", evento => {
    if (evento.target === modalCliente) {
        modalCliente.close();
    }
});

document.querySelector("#form-deletar-cliente")
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
                    resultado.erro || "Não foi possível excluir o cliente."
                );
            }

            document.querySelector('[data-tab="lista"]').click();
            await carregarClientes();
        } catch (erro) {
            console.error(erro);
            alert(erro.message);
        }
    });

carregarClientes();