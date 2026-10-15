<?php
require_once dirname(__DIR__, 2) . "/session_helper.php";

$nivelDaPagina = "administrador";
require_once dirname(__DIR__) . "/utils/verificarNivel.php";

verificarNivel($nivelDaPagina);

$mensagem = $_SESSION["flash"] ?? null;
unset($_SESSION["flash"]);

$nivel = htmlspecialchars(
    $_SESSION["usuario"]["nivel"] ?? "administrador",
    ENT_QUOTES,
    "UTF-8"
);

$email = htmlspecialchars(
    $_SESSION["usuario"]["email"] ?? "",
    ENT_QUOTES,
    "UTF-8"
);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colaboradores | AssisTec</title>

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin/home.css">
    <link rel="stylesheet" href="../css/admin/colaboradores.css">

    <script src="../js/utils/nav.js" defer></script>
</head>

<body class="pagina-admin">
    <aside class="menu-lateral" id="sidebar">
        <!-- 1. Marca -->
        <a class="marca" href="index.php">
            <span class="marca-icone">AT</span>
            <span>Assis<span class="marca-azul">Tec</span></span>
        </a>

        <!-- 2. Usuário -->
        <div class="usuario-logado">
            <span class="usuario-cargo"><?= ucfirst($nivel) ?></span>
            <span class="usuario-email"><?= $email ?></span>
        </div>

        <!-- 3. Menu -->
        <div class="area-menu">
            <p class="menu-titulo">ADMINISTRAÇÃO</p>
            <nav class="menu" aria-label="Administração">
                <a class="link-menu" href="index.php">Visão geral</a>
                <a class="link-menu active" href="colaboradores.php" aria-current="page">Colaboradores</a>
            </nav>

            <p class="menu-titulo">ACESSAR PAINÉIS</p>
            <nav class="admin-paineis-menu" aria-label="Áreas do sistema">
                <a class="admin-link-painel" href="../atendente/">
                    <span class="admin-icone" aria-hidden="true">AT</span>
                    <span>Atendente<small>Cadastros e atendimento</small></span>
                    <span class="admin-seta" aria-hidden="true">↗</span>
                </a>
                <a class="admin-link-painel" href="../tecnico/">
                    <span class="admin-icone" aria-hidden="true">TC</span>
                    <span>Técnico<small>Ordens e manutenção</small></span>
                    <span class="admin-seta" aria-hidden="true">↗</span>
                </a>
            </nav>
        </div>

        <!-- 4. Ações -->
        <div class="acoes-menu">
            
            <br>
            <form action="../utils/logout.php" method="POST">
                <button type="submit" name="sair" class="botao-sair">Sair da conta</button>
            </form>
        </div>
    </aside>

    <main class="conteudo">
        <header class="cabecalho">
            <button class="abrir-menu" id="menuToggle" type="button"
                aria-label="Abrir menu" aria-expanded="false">☰</button>

            <div>
                <p class="subtitulo">AssisTec / Administrador</p>
                <h1>Colaboradores</h1>
            </div>
        </header>

        

        <section class="painel-colaboradores">
            <nav class="abas">
                <button type="button" class="client-tab botao-aba active" data-tab="lista">
                    Colaboradores cadastrados
                </button>
                <button type="button" class="client-tab botao-aba" data-tab="cadastro">
                    Cadastrar
                </button>
            </nav>

            <section class="client-template area-colaborador" id="template-lista">
                <!-- Conectar os formulários ao router e as abas ao JS na integração. -->
                <form id="form-filtros-colaboradores"
                    action="#"
                    method="GET">

                    <input type="search" name="nome" placeholder="Buscar por nome">
                    <input type="search" name="cpf" placeholder="CPF" maxlength="11"
                        inputmode="numeric">
                    <input type="search" name="cidade" placeholder="Cidade">

                    <input type="search" name="cargo" placeholder="Cargo">

                    <button class="botao-form" type="submit">Buscar</button>
                    <button class="client-tab botao-aba" type="reset">Limpar</button>
                </form>

                <p id="colaboradores-status" role="status">Os colaboradores serão exibidos aqui.</p>

                <div class="tabela-container">
                    <table class="tabela-colaboradores">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>E-mail</th>
                                <th>Telefone</th>
                                <th>Cargo</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="lista-colaboradores"></tbody>
                    </table>
                </div>
            </section>

            <template id="template-linha-colaborador">
                <tr>
                    <td data-campo="id_colaborador"></td>
                    <td data-campo="nome"></td>
                    <td data-campo="cpf"></td>
                    <td data-campo="email"></td>
                    <td data-campo="telefone"></td>
                    <td data-campo="cargo"></td>
                    
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

            <section class="client-template area-colaborador" id="template-cadastro" hidden>
                <h3>Cadastrar colaborador</h3>

                <form action="#"
                    method="POST">
                    <div class="campos-form">
                        <label class="campo-form">Nome
                            <input name="nome" maxlength="100" required>
                        </label>
                        <label class="campo-form">Cargo
                            <input name="cargo" maxlength="100" required>
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
                        <label class="campo-form">CEP
                            <input id="cep" name="cep" maxlength="8" pattern="[0-9]{8}"
                                inputmode="numeric" required>
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
                            <input id="cidade" name="cidade" maxlength="100" required>
                        </label>
                        <label class="campo-form">Estado
                            <input name="estado" maxlength="100" required>
                        </label>
                    </div>

                    <button class="botao-form" type="submit">Cadastrar colaborador</button>
                </form>
            </section>

            <section class="client-template area-colaborador" id="template-atualizar" hidden>
                <h3>Atualizar Colaborador: <span id="id-colaborador-atualizar"></span></h3>

                <form id="form-atualizar-colaborador"
                    action="#"
                    method="POST">

                    <input type="hidden" name="id_colaborador">

                    <div class="campos-form">
                        <label class="campo-form">Cargo
                            <input name="cargo" maxlength="100">
                        </label>
                        <label class="campo-form">CPF
                            <input name="cpf" maxlength="11" pattern="[0-9]{11}" inputmode="numeric">
                        </label>
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

            <section class="client-template area-colaborador" id="template-deletar" hidden>
                <h3>Excluir colaborador</h3>
                <p>Confirme a exclusão de <strong id="nome-colaborador-deletar"></strong>.</p>

                <form id="form-deletar-colaborador"
                    action="#"
                    method="POST">

                    <label class="campo-form campo-excluir">ID do colaborador
                        <input name="id_colaborador" readonly required>
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

    <dialog class="modal-colaborador" id="modal-colaborador"
        aria-labelledby="titulo-modal-colaborador">
        <div class="modal-cabecalho">
            <h2 id="titulo-modal-colaborador">Dados do colaborador</h2>
            <button class="fechar-modal" id="fechar-modal-colaborador" type="button"
                aria-label="Fechar">×</button>
        </div>

        <dl class="dados-colaborador">
            <div>
                <dt>ID</dt>
                <dd data-detalhe="id_colaborador"></dd>
            </div>
            <div>
                <dt>Nome</dt>
                <dd data-detalhe="nome"></dd>
            </div>
            <div>
                <dt>CPF</dt>
                <dd data-detalhe="cpf"></dd>
            </div>
            <div>
                <dt>E-mail</dt>
                <dd data-detalhe="email"></dd>
            </div>
            <div>
                <dt>Telefone</dt>
                <dd data-detalhe="telefone"></dd>
            </div>
            <div>
                <dt>Logradouro</dt>
                <dd data-detalhe="logradouro"></dd>
            </div>
            <div>
                <dt>Número</dt>
                <dd data-detalhe="numero"></dd>
            </div>
            <div>
                <dt>Bairro</dt>
                <dd data-detalhe="bairro"></dd>
            </div>
            <div>
                <dt>Cidade</dt>
                <dd data-detalhe="cidade"></dd>
            </div>
            <div>
                <dt>Estado</dt>
                <dd data-detalhe="estado"></dd>
            </div>
            <div>
                <dt>CEP</dt>
                <dd data-detalhe="cep"></dd>
            </div>
            <div>
                <dt>Data de cadastro</dt>
                <dd data-detalhe="data_de_cadastro"></dd>
            </div>
            <div>
                <dt>Cargo</dt>
                <dd data-detalhe="cargo"></dd>
            </div>
        </dl>
    </dialog>
</body>

</html>