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
    <aside class="sidebar" id="sidebar">
        <a class="brand" href="index.php">
            <span class="brand-icon">AT</span>
            <span>Assis<span class="brand-blue">Tec</span></span>
        </a>

        <p class="menu-label">MENU</p>

        <nav class="menu">
            <a class="menu-link" href="index.php">Visão geral</a>
            <a class="menu-link active" href="clientes.php">Clientes</a>
            <a class="menu-link" href="equipamentos.php">Equipamentos</a>
            <a class="menu-link" href="ordens.php">Abrir ordem de serviço</a>
            <a class="menu-link" href="atendimentos.php">Atendimentos</a>
        </nav>

        <div class="sidebar-bottom">
            <span class="user-role">Atendente</span>
            <span class="user-email">
                <?= htmlspecialchars($_SESSION["usuario"]["email"], ENT_QUOTES, "UTF-8") ?>
            </span>
        </div>
    </aside>

    <main class="main-content">
        <header class="topbar">
            <button id="menuToggle" class="menu-toggle" type="button"
                aria-label="Abrir menu" aria-expanded="false">☰</button>

            <div>
                <p class="eyebrow">AssisTec / Atendente</p>
                <h1>Clientes</h1>
            </div>
        </header>

        <?php if (isset($mensagem)): ?>
            <p class="<?= $mensagem["tipo"] === "sucesso" ? "sucesso" : "erro" ?>">
                <?= htmlspecialchars($mensagem["mensagem"], ENT_QUOTES, "UTF-8") ?>
            </p>
        <?php endif; ?>

        <section class="client-panel">
            <nav class="client-tabs">
                <button type="button" class="client-tab active" data-tab="lista">
                    Clientes cadastrados
                </button>
                <button type="button" class="client-tab" data-tab="cadastro">
                    Cadastrar
                </button>
            </nav>

            <section class="client-template" id="template-lista">
                <form id="form-filtros-clientes"
                    action="../../src/routes/clientesRouter.php?rota=cliente/buscarClientes"
                    method="GET">

                    <input type="search" name="nome" placeholder="Buscar por nome">
                    <input type="search" name="cpf" placeholder="CPF" maxlength="11" inputmode="numeric">
                    <input type="search" name="email" placeholder="email">
                    <select name="status">
                        <option value="">Todos os status</option>
                        <option value="ativo">Ativo</option>
                        <option value="inativo">Inativo</option>
                    </select>

                    <button class="form-submit" type="submit">Buscar</button>
                    <button class="client-tab" type="reset">Limpar</button>
                </form>

                <p id="clientes-status" role="status">Carregando clientes...</p>

                <div class="table-container">
                    <table class="clients-table">
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
                    <td>
                        <button class="form-submit" type="button" data-acao="atualizar">Atualizar</button>
                        <button class="form-submit danger-button" type="button" data-acao="deletar">Deletar</button>
                    </td>
                </tr>
            </template>

            <section class="client-template" id="template-cadastro" hidden>
                <h3>Cadastrar cliente</h3>

                <form action="../../src/routes/clientesRouter.php?rota=cliente/cadastrar" method="POST">
                    <div class="form-grid">
                        <label class="form-field">Nome
                            <input name="nome" maxlength="100" required>
                        </label>
                        <label class="form-field">CPF
                            <input name="cpf" maxlength="11" pattern="[0-9]{11}" inputmode="numeric" required>
                        </label>
                        <label class="form-field">E-mail
                            <input type="email" name="email" maxlength="150" required>
                        </label>
                        <label class="form-field">Telefone
                            <input type="tel" name="telefone" maxlength="16" required>
                        </label>
                        <label class="form-field">Logradouro
                            <input name="logradouro" maxlength="100" required>
                        </label>
                        <label class="form-field">Número
                            <input name="numero" maxlength="10" required>
                        </label>
                        <label class="form-field">Bairro
                            <input name="bairro" maxlength="100" required>
                        </label>
                        <label class="form-field">Cidade
                            <input name="cidade" maxlength="100" required>
                        </label>
                        <label class="form-field">Estado
                            <input name="estado" maxlength="100" required>
                        </label>
                        <label class="form-field">CEP
                            <input name="cep" maxlength="8" pattern="[0-9]{8}" inputmode="numeric" required>
                        </label>
                    </div>

                    <button class="form-submit" type="submit">Cadastrar cliente</button>
                </form>
            </section>

            <section class="client-template" id="template-atualizar" hidden>
                <h3>Atualizar Cliente: <span id="cpf-cliente-atualizar"></span></h3>

                <form id="form-atualizar-cliente"
                    action="../../src/routes/clientesRouter.php?rota=cliente/atualizar"
                    method="POST">

                    <input type="hidden" name="cpf_atual">

                    <div class="form-grid">
                        <label class="form-field">Nome
                            <input name="nome" maxlength="100">
                        </label>
                        <label class="form-field">E-mail
                            <input type="email" name="email" maxlength="150">
                        </label>
                        <label class="form-field">Telefone
                            <input type="tel" name="telefone" maxlength="16">
                        </label>
                        <label class="form-field">Logradouro
                            <input name="logradouro" maxlength="100">
                        </label>
                        <label class="form-field">Número
                            <input name="numero" maxlength="10">
                        </label>
                        <label class="form-field">Bairro
                            <input name="bairro" maxlength="100">
                        </label>
                        <label class="form-field">Cidade
                            <input name="cidade" maxlength="100">
                        </label>
                        <label class="form-field">Estado
                            <input name="estado" maxlength="100">
                        </label>
                        <label class="form-field">CEP
                            <input name="cep" maxlength="8">
                        </label>
                    </div>

                    <div class="form-actions">
                        <button class="form-submit" type="submit">Salvar alterações</button>
                        <button class="client-tab" type="button" data-tab="lista">Cancelar</button>
                    </div>
                </form>
            </section>

            <section class="client-template" id="template-deletar" hidden>
                <h3>Excluir cliente</h3>
                <p>Confirme a exclusão de <strong id="nome-cliente-deletar"></strong>.</p>

                <form id="form-deletar-cliente"
                    action="../../src/routes/clientesRouter.php?rota=cliente/deletar"
                    method="POST">

                    <label class="form-field">CPF
                        <input name="cpf" readonly required>
                    </label>

                    <div class="form-actions">
                        <button class="form-submit danger-button" type="submit">
                            Confirmar exclusão
                        </button>
                        <button class="client-tab" type="button" data-tab="lista">Cancelar</button>
                    </div>
                </form>
            </section>
        </section>
    </main>
</body>

</html>