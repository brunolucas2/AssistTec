<?php
$nivelDaPagina = "atendente";

require_once dirname(__DIR__) . "/utils/verificarNivel.php";
?>

<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$mensagem = $_SESSION["flash"] ?? null;
unset($_SESSION["flash"]);
?>

<?php if ($mensagem !== null): ?>
    <p class="<?= $mensagem["tipo"] === "sucesso" ? "sucesso" : "erro" ?>">
        <?= htmlspecialchars($mensagem["texto"], ENT_QUOTES, "UTF-8") ?>
    </p>
<?php endif; ?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#08111f">
    <meta name="color-scheme" content="dark">

    <title>Clientes | AssisTec</title>
    <link rel="stylesheet" href="../css/atendente.css">
    <link rel="stylesheet" href="../css/clientes.css">
    <script src="../js/clientes.js" defer></script>
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
            <button
                class="menu-toggle"
                id="menuToggle"
                type="button"
                aria-label="Abrir menu"
                aria-expanded="false"
            >
                ☰
            </button>

            <div>
                <p class="eyebrow">AssisTec / Atendente</p>
                <h1>Clientes</h1>
            </div>
        </header>

        <section class="client-panel">
            <div class="client-heading">
                <div>
                    <h2>Gerenciar clientes</h2>
                    <p>Cadastre clientes ou atualize as informações existentes.</p>
                </div>
            </div>

            <nav class="client-tabs" aria-label="Ações de clientes">
                <button
                    class="client-tab active"
                    type="button"
                    data-tab="cadastro"
                    aria-selected="true"
                >
                    Cadastrar
                </button>

                <button
                    class="client-tab"
                    type="button"
                    data-tab="atualizar"
                    aria-selected="false"
                >
                    Atualizar
                </button>

                <button
                    class="client-tab"
                    type="button"
                    data-tab="deletar"
                    aria-selected="false"
                >
                    Deletar
                </button>
            </nav>

            <section class="client-template" id="template-cadastro">
                <h3>Cadastrar cliente</h3>

                <form action="../../src/routes/clientesRouter.php?rota=cliente/cadastrar" method="POST">
                    <div class="form-grid">
                        <div class="form-field">
                            <label for="nome">Nome completo</label>
                            <input type="text" id="nome" name="nome" maxlength="100" required>
                        </div>

                        <div class="form-field">
                            <label for="cpf">CPF</label>
                            <input type="text" id="cpf" name="cpf" maxlength="11" required>
                        </div>

                        <div class="form-field">
                            <label for="email">E-mail</label>
                            <input type="email" id="email" name="email" maxlength="150" required>
                        </div>

                        <div class="form-field">
                            <label for="telefone">Telefone</label>
                            <input type="tel" id="telefone" name="telefone" maxlength="16" required>
                        </div>

                        <div class="form-field">
                            <label for="logradouro">Logradouro</label>
                            <input type="text" id="logradouro" name="logradouro" maxlength="100" required>
                        </div>

                        <div class="form-field">
                            <label for="numero">Número</label>
                            <input type="text" id="numero" name="numero" maxlength="10" required>
                        </div>

                        <div class="form-field">
                            <label for="bairro">Bairro</label>
                            <input type="text" id="bairro" name="bairro" maxlength="100" required>
                        </div>

                        <div class="form-field">
                            <label for="cidade">Cidade</label>
                            <input type="text" id="cidade" name="cidade" maxlength="100" required>
                        </div>

                        <div class="form-field">
                            <label for="estado">Estado</label>
                            <input type="text" id="estado" name="estado" maxlength="100" required>
                        </div>

                        <div class="form-field">
                            <label for="cep">CEP</label>
                            <input type="text" id="cep" name="cep" maxlength="8" required>
                        </div>
                    </div>

                    <button class="form-submit" type="submit">Cadastrar cliente</button>
                </form>
            </section>

            <section class="client-template" id="template-atualizar" hidden>
                <h3>Atualizar cliente</h3>
                <p class="form-hint">
                    Informe o CPF atual para localizar o cliente. Preencha os campos que deseja alterar.
                </p>

                <form action="../index.php?rota=cliente/atualizar" method="POST">
                    <div class="form-grid">
                        <div class="form-field">
                            <label for="cpf_atual">CPF atual do cliente</label>
                            <input type="text" id="cpf_atual" name="cpf_atual" maxlength="11" required>
                        </div>

                        <div class="form-field">
                            <label for="nome_atualizar">Novo nome</label>
                            <input type="text" id="nome_atualizar" name="nome" maxlength="100">
                        </div>

                        <div class="form-field">
                            <label for="email_atualizar">Novo e-mail</label>
                            <input type="email" id="email_atualizar" name="email" maxlength="150">
                        </div>

                        <div class="form-field">
                            <label for="telefone_atualizar">Novo telefone</label>
                            <input type="tel" id="telefone_atualizar" name="telefone" maxlength="16">
                        </div>

                        <div class="form-field">
                            <label for="logradouro_atualizar">Novo logradouro</label>
                            <input type="text" id="logradouro_atualizar" name="logradouro" maxlength="100">
                        </div>

                        <div class="form-field">
                            <label for="numero_atualizar">Novo número</label>
                            <input type="text" id="numero_atualizar" name="numero" maxlength="10">
                        </div>

                        <div class="form-field">
                            <label for="bairro_atualizar">Novo bairro</label>
                            <input type="text" id="bairro_atualizar" name="bairro" maxlength="100">
                        </div>

                        <div class="form-field">
                            <label for="cidade_atualizar">Nova cidade</label>
                            <input type="text" id="cidade_atualizar" name="cidade" maxlength="100">
                        </div>

                        <div class="form-field">
                            <label for="estado_atualizar">Novo estado</label>
                            <input type="text" id="estado_atualizar" name="estado" maxlength="100">
                        </div>

                        <div class="form-field">
                            <label for="cep_atualizar">Novo CEP</label>
                            <input type="text" id="cep_atualizar" name="cep" maxlength="8">
                        </div>
                    </div>

                    <button class="form-submit" type="submit">Salvar alterações</button>
                </form>
            </section>

            <section class="client-template" id="template-deletar" hidden>
                <h3>Deletar cliente</h3>
                <p class="form-hint">
                    Essa ação não poderá ser desfeita.
                </p>

                <form
                    action="../index.php?rota=cliente/deletar"
                    method="POST"
                    data-confirm="Tem certeza que deseja deletar esse cliente?"
                >
                    <div class="form-field delete-field">
                        <label for="cpf_deletar">CPF do cliente</label>
                        <input
                            type="text"
                            id="cpf_deletar"
                            name="cpf"
                            maxlength="11"
                            required
                        >
                    </div>

                    <button class="form-submit danger-button" type="submit">
                        Deletar cliente
                    </button>
                </form>
            </section>
        </section>
    </main>
</body>
</html>


<?php

$rota = $_GET["rota"] ?? "";

if ($rota === "auth" && $_SERVER["REQUEST_METHOD"] === "POST") {
    require_once dirname(__DIR__) . "/src/routes/auth-router.php";
    exit;
}

http_response_code(404);
exit("Rota não encontrada");