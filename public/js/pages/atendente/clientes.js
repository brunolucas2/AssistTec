const formularioBusca = document.querySelector("#form-filtros-clientes");
const listaClientes = document.querySelector("#lista-clientes");
const statusClientes = document.querySelector("#clientes-status");
const modeloLinha = document.querySelector("#template-linha-cliente");

let clientes = [];

async function carregarClientes() {
    try {
        const resposta = await fetch(formularioBusca.action, {
            method: "GET"
        });

        if (!resposta.ok) {
            throw new Error("Falha ao buscar clientes.");
        }

        clientes = await resposta.json();
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

        linha.querySelector('[data-campo="id_cliente"]').textContent = cliente.id_cliente;
        linha.querySelector('[data-campo="nome"]').textContent = cliente.nome;
        linha.querySelector('[data-campo="cpf"]').textContent = cliente.cpf;
        linha.querySelector('[data-campo="email"]').textContent = cliente.email;
        linha.querySelector('[data-campo="telefone"]').textContent = cliente.telefone;
        linha.querySelector('[data-campo="status"]').textContent = cliente.status;

        listaClientes.appendChild(linha);
    });

    statusClientes.textContent = clientesExibidos.length
        ? `${clientesExibidos.length} cliente(s) encontrado(s).`
        : "Nenhum cliente encontrado.";
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

listaClientes.addEventListener("click", evento => {
    const botao = evento.target.closest("[data-acao]");
    if (!botao) return;

    const linha = botao.closest("tr");
    const cpf = linha.querySelector('[data-campo="cpf"]').textContent;
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
            if (input) input.value = cliente[campo] ?? "";
        });

        document.querySelector("#template-atualizar").hidden = false;
    }

    if (botao.dataset.acao === "deletar") {
        document.querySelector('#form-deletar-cliente [name="cpf"]').value = cliente.cpf;
        document.querySelector("#nome-cliente-deletar").textContent = cliente.nome;
        document.querySelector("#template-deletar").hidden = false;
    }
});

carregarClientes();