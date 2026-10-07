const filtros = document.querySelector("#form-filtros-clientes");
const lista = document.querySelector("#lista-clientes");
const modelo = document.querySelector("#template-linha-cliente");
const mensagem = document.querySelector("#clientes-status");
let consulta;

function mostrar(secao) {
  document.querySelectorAll(".client-template").forEach(elemento => {
    elemento.hidden = elemento.id !== `template-${secao}`;
  });

  document.querySelectorAll(".client-tabs [data-tab]").forEach(botao => {
    botao.classList.toggle("active", botao.dataset.tab === secao);
  });
}

document.querySelectorAll("[data-tab]").forEach(botao => {
  botao.addEventListener("click", () => mostrar(botao.dataset.tab));
});

function selecionar(cliente, acao) {
  const form = document.querySelector(`#form-${acao}-cliente`);
  form.reset();

  if (acao === "atualizar") {
    for (const campo of form.querySelectorAll("input[name]")) {
      campo.value = cliente[campo.name === "cpf_atual" ? "cpf" : campo.name] ?? "";
    }
  } else {
    form.elements.namedItem("cpf").value = cliente.cpf;
    document.querySelector("#nome-cliente-deletar").textContent = cliente.nome;
  }

  mostrar(acao);
}

async function carregarClientes() {
  consulta?.abort();
  const atual = new AbortController();
  consulta = atual;
  mensagem.textContent = "Carregando clientes...";

  try {
    const parametros = new URLSearchParams(new FormData(filtros));
    const resposta = await fetch(`${filtros.action}?${parametros}`, {
      signal: atual.signal,
      headers: { Accept: "application/json" }
    });

    if (!resposta.ok) throw new Error(`Erro ao carregar: HTTP ${resposta.status}`);

    const clientes = await resposta.json();
    if (!Array.isArray(clientes)) throw new Error("A rota deve retornar um array JSON.");

    const linhas = document.createDocumentFragment();

    for (const cliente of clientes) {
      const linha = modelo.content.cloneNode(true);

      linha.querySelectorAll("[data-campo]").forEach(celula => {
        celula.textContent = cliente[celula.dataset.campo] ?? "";
      });

      linha.querySelectorAll("[data-acao]").forEach(botao => {
        botao.addEventListener("click", () => selecionar(cliente, botao.dataset.acao));
      });

      linhas.append(linha);
    }

    lista.replaceChildren(linhas);
    mensagem.textContent = clientes.length
      ? `${clientes.length} cliente(s) encontrado(s).`
      : "Nenhum cliente encontrado.";
  } catch (erro) {
    if (erro.name === "AbortError") return;
    lista.replaceChildren();
    mensagem.textContent = erro.message;
  }
}

filtros.addEventListener("submit", evento => {
  evento.preventDefault();
  carregarClientes();
});

filtros.addEventListener("reset", () => {
  setTimeout(carregarClientes, 0);
});

document.querySelector("#menuToggle").addEventListener("click", evento => {
  const aberto = document.querySelector("#sidebar").classList.toggle("open");
  evento.currentTarget.setAttribute("aria-expanded", String(aberto));
});

carregarClientes();