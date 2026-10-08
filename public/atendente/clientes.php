<?php
$nivelDaPagina = "atendente";
require_once dirname(__DIR__) . "/utils/verificarNivel.php";

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$mensagem = $_SESSION["flash"] ?? null;
unset($_SESSION["flash"]);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes | AssisTec</title>
    <link rel="stylesheet" href="../css/atendente.css">
    <link rel="stylesheet" href="../css/clientes.css">
    <script src="../js/clientes.js" defer></script>
    <script src="../js/nav.js" defer></script>
</head>

<body>
    <aside class="menu-lateral" id="sidebar">
        <a class="marca" href="index.php">
            <span class="marca-icone">AT</span>
            <span>Assis<span class="marca-azul">Tec</span></span>
        </a>

        <p class="menu-titulo">MENU</p>

        <nav class="menu">
            <a class="link-menu" href="index.php">Visão geral</a>
            <a class="link-menu active" href="clientes.php">Clientes</a>
            <a class="link-menu" href="equipamentos.php">Equipamentos</a>
            <a class="link-menu" href="ordens.php">Abrir ordem de serviço</a>
            <a class="link-menu" href="atendimentos.php">Atendimentos</a>
        </nav>

        <div class="usuario-logado">
            <span class="usuario-cargo">Atendente</span>
            <span class="usuario-email">
                <?= htmlspecialchars($_SESSION["usuario"]["email"] ?? "", ENT_QUOTES, "UTF-8") ?>
            </span>
        </div>
    </aside>

    <main class="conteudo">
        <header class="cabecalho">
            <button class="abrir-menu" id="menuToggle" type="button"
                aria-label="Abrir menu" aria-expanded="false">☰</button>

            <div>
                <p class="subtitulo">AssisTec / Atendente</p>
                <h1>Clientes</h1>
            </div>
        </header>

        <?php if ($mensagem): ?>
            <p class="<?= ($mensagem["tipo"] ?? "") === "sucesso" ? "sucesso" : "erro" ?>">
                <?= htmlspecialchars($mensagem["mensagem"] ?? "", ENT_QUOTES, "UTF-8") ?>
            </p>
        <?php endif; ?>

        <section class="painel-clientes">
            <nav class="abas">
                <button type="button" class="client-tab botao-aba active" data-tab="lista">
                    Clientes cadastrados
                </button>
                <button type="button" class="client-tab botao-aba" data-tab="cadastro">
                    Cadastrar
                </button>
            </nav>

            <section class="client-template area-cliente" id="template-lista">
                <form id="form-filtros-clientes"
                    action="../../src/routes/clientesRouter.php?rota=cliente/buscarClientes"
                    method="GET">

                    <input type="search" name="nome" placeholder="Buscar por nome">
                    <input type="search" name="cpf" placeholder="CPF" maxlength="11" inputmode="numeric">
                    <input type="search" name="cidade" placeholder="Cidade">

                    <select name="status">
                        <option value="">Todos os status</option>
                        <option value="ativo">Ativo</option>
                        <option value="inativo">Inativo</option>
                    </select>

                    <button class="botao-form" type="submit">Buscar</button>
                    <button class="client-tab botao-aba" type="reset">Limpar</button>
                </form>

                <p id="clientes-status" role="status">Carregando clientes...</p>

                <div class="tabela-container">
                    <table class="tabela-clientes">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>E-mail</th>
                                <th>Telefone</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="lista-clientes"></tbody>
                    </table>
                </div>
            </section>

            <template id="template-linha-cliente">
                <tr>
                    <td data-campo="id_cliente"></td>
                    <td data-campo="nome"></td>
                    <td data-campo="cpf"></td>
                    <td data-campo="email"></td>
                    <td data-campo="telefone"></td>
                    <td data-campo="status"></td>
                    <td data-campo="cidade" hidden></td>
                    <td>
                        <button class="botao-form" type="button" data-acao="atualizar">
                            Atualizar
                        </button>
                        <button class="botao-form botao-perigo" type="button" data-acao="deletar">
                            Deletar
                        </button>
                    </td>
                </tr>
            </template>

            <section class="client-template area-cliente" id="template-cadastro" hidden>
                <h3>Cadastrar cliente</h3>

                <form action="../../src/routes/clientesRouter.php?rota=cliente/cadastrar" method="POST">
                    <div class="campos-form">
                        <label class="campo-form">Nome
                            <input name="nome" maxlength="100" required>
                        </label>
                        <label class="campo-form">CPF
                            <input name="cpf" maxlength="11" pattern="[0-9]{11}"
                                inputmode="numeric" required>
                        </label>
                        <label class="campo-form">E-mail
                            <input type="email" name="email" maxlength="150" required>
                        </label>
                        <label class="campo-form">Telefone
                            <input type="tel" name="telefone" maxlength="16" required>
                        </label>
                        <label class="campo-form">Logradouro
                            <input name="logradouro" maxlength="100" required>
                        </label>
                        <label class="campo-form">Número
                            <input name="numero" maxlength="10" required>
                        </label>
                        <label class="campo-form">Bairro
                            <input name="bairro" maxlength="100" required>
                        </label>
                        <label class="campo-form">Cidade
                            <input name="cidade" maxlength="100" required>
                        </label>
                        <label class="campo-form">Estado
                            <input name="estado" maxlength="100" required>
                        </label>
                        <label class="campo-form">CEP
                            <input name="cep" maxlength="8" pattern="[0-9]{8}"
                                inputmode="numeric" required>
                        </label>
                    </div>

                    <button class="botao-form" type="submit">Cadastrar cliente</button>
                </form>
            </section>

            <section class="client-template area-cliente" id="template-atualizar" hidden>
                <h3>Atualizar Cliente: <span id="cpf-cliente-atualizar"></span></h3>

                <form id="form-atualizar-cliente"
                    action="../../src/routes/clientesRouter.php?rota=cliente/atualizar"
                    method="POST">

                    <input type="hidden" name="cpf_atual">

                    <div class="campos-form">
                        <label class="campo-form">Nome
                            <input name="nome" maxlength="100">
                        </label>
                        <label class="campo-form">E-mail
                            <input type="email" name="email" maxlength="150">
                        </label>
                        <label class="campo-form">Telefone
                            <input type="tel" name="telefone" maxlength="16">
                        </label>
                        <label class="campo-form">Logradouro
                            <input name="logradouro" maxlength="100">
                        </label>
                        <label class="campo-form">Número
                            <input name="numero" maxlength="10">
                        </label>
                        <label class="campo-form">Bairro
                            <input name="bairro" maxlength="100">
                        </label>
                        <label class="campo-form">Cidade
                            <input name="cidade" maxlength="100">
                        </label>
                        <label class="campo-form">Estado
                            <input name="estado" maxlength="100">
                        </label>
                        <label class="campo-form">CEP
                            <input name="cep" maxlength="8">
                        </label>
                    </div>

                    <div class="acoes-form">
                        <button class="botao-form" type="submit">Salvar alterações</button>
                        <button class="client-tab botao-aba" type="button" data-tab="lista">
                            Cancelar
                        </button>
                    </div>
                </form>
            </section>

            <section class="client-template area-cliente" id="template-deletar" hidden>
                <h3>Excluir cliente</h3>
                <p>Confirme a exclusão de <strong id="nome-cliente-deletar"></strong>.</p>

                <form id="form-deletar-cliente"
                    action="../../src/routes/clientesRouter.php?rota=cliente/deletar"
                    method="POST">

                    <label class="campo-form campo-excluir">CPF
                        <input name="cpf" readonly required>
                    </label>

                    <div class="acoes-form">
                        <button class="botao-form botao-perigo" type="submit">
                            Confirmar exclusão
                        </button>
                        <button class="client-tab botao-aba" type="button" data-tab="lista">
                            Cancelar
                        </button>
                    </div>
                </form>
            </section>
        </section>
    </main>
</body>

</html>