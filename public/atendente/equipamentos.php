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
    <title>Equipamentos | AssisTec</title>
    <link rel="stylesheet" href="../css/atendente.css">
    <link rel="stylesheet" href="../css/equipamentos.css">
    <script src="../js/equipamentos.js" defer></script>
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
            <a class="link-menu" href="clientes.php">Clientes</a>
            <a class="link-menu active" href="equipamentos.php">Equipamentos</a>
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
                <h1>Equipamentos</h1>
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
                    Equipamentos cadastrados
                </button>
                <button type="button" class="client-tab botao-aba" data-tab="cadastro">
                    Cadastrar
                </button>
            </nav>

            <section class="client-template area-cliente" id="template-lista">
                <form id="filtros-equipamentos"
                    action="../../src/routes/equipamentosRouter.php?rota=buscarEquipamentos"
                    method="GET">

                    <input type="search" name="id_cliente" placeholder="ID do cliente" inputmode="numeric">
                    <input type="search" name="tipo" placeholder="Tipo">
                    <input type="search" name="marca" placeholder="Marca">
                    <input type="search" name="numero_de_serie" placeholder="Nº de série">
                    <input type="search" name="patrimonio" placeholder="Patrimônio">

                    <button class="botao-form" type="submit">Buscar</button>
                    <button class="client-tab botao-aba" type="reset">Limpar</button>
                </form>

                <p id="equipamentos-status" role="status">Carregando equipamentos...</p>

                <div class="tabela-container">
                    <table class="tabela-clientes">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Tipo</th>
                                <th>Marca</th>
                                <th>Nº de série</th>
                                <th>Patrimônio</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="lista-equipamentos"></tbody>
                    </table>
                </div>
            </section>

            <template id="linha-equipamento">
                <tr>
                    <td data-campo="id_equipamento"></td>
                    <td data-campo="id_cliente"></td>
                    <td data-campo="tipo"></td>
                    <td data-campo="marca"></td>
                    <td data-campo="numero_de_serie"></td>
                    <td data-campo="patrimonio"></td>
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
                <h3>Cadastrar equipamento</h3>

                <form action="../../src/routes/equipamentosRouter.php?rota=cadastrarEquipamento"
                    method="POST">

                    <div class="campos-form">
                        <label class="campo-form">ID do cliente
                            <input type="number" name="id_cliente" min="1" required>
                        </label>
                        <label class="campo-form">Tipo
                            <input name="tipo" maxlength="100" required>
                        </label>
                        <label class="campo-form">Marca
                            <input name="marca" maxlength="100" required>
                        </label>
                        <label class="campo-form">Número de série
                            <input name="numero_de_serie" maxlength="100" required>
                        </label>
                        <label class="campo-form">Patrimônio
                            <input name="patrimonio" maxlength="100" required>
                        </label>
                        <label class="campo-form">Descrição
                            <input name="descricao" maxlength="100" required>
                        </label>
                        <label class="campo-form">Sistema operacional
                            <input name="sistema_operacional" maxlength="100" required>
                        </label>
                        <label class="campo-form">Senha de acesso
                            <input type="password" name="senha_de_acesso" maxlength="100"
                                autocomplete="new-password" required>
                        </label>
                    </div>

                    <button class="botao-form" type="submit">Cadastrar equipamento</button>
                </form>
            </section>

            <section class="client-template area-cliente" id="template-atualizar" hidden>
                <h3>Atualizar equipamento: <span id="id-equipamento-atualizar"></span></h3>

                <form id="form-atualizar-equipamento"
                    action="../../src/routes/equipamentosRouter.php?rota=atualizarEquipamento"
                    method="POST">

                    <input type="hidden" name="id_equipamento">

                    <div class="campos-form">
                        <label class="campo-form">Tipo
                            <input name="tipo" maxlength="100">
                        </label>
                        <label class="campo-form">Marca
                            <input name="marca" maxlength="100">
                        </label>
                        <label class="campo-form">Número de série
                            <input name="numero_de_serie" maxlength="100">
                        </label>
                        <label class="campo-form">Patrimônio
                            <input name="patrimonio" maxlength="100">
                        </label>
                        <label class="campo-form">Descrição
                            <input name="descricao" maxlength="100">
                        </label>
                        <label class="campo-form">Sistema operacional
                            <input name="sistema_operacional" maxlength="100">
                        </label>
                        <label class="campo-form">Nova senha de acesso
                            <input type="password" name="senha_de_acesso" maxlength="100"
                                autocomplete="new-password">
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
                <h3>Excluir equipamento</h3>
                <p>Confirme a exclusão do equipamento <strong id="serie-equipamento-deletar"></strong>.</p>

                <form id="form-deletar-equipamento"
                    action="../../src/routes/equipamentosRouter.php?rota=deletarEquipamento"
                    method="POST">

                    <input type="hidden" name="id_equipamento">

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