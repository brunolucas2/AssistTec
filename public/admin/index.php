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
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#08111f">
    <meta name="color-scheme" content="dark">
    <title>Colaboradores | AssisTec</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin/home.css">
    <script src="../js/utils/nav.js" defer></script>
</head>
<body class="pagina-admin">
    <aside class="menu-lateral" id="sidebar">
        <a class="marca" href="index.php">
            <span class="marca-icone">AT</span>
            <span>Assis<span class="marca-azul">Tec</span></span>
        </a>

        <div class="usuario-logado">
            <span class="usuario-cargo"><?= ucfirst($nivel) ?></span>
            <span class="usuario-email"><?= $email ?></span>
        </div>

        <div class="area-menu">
            <p class="menu-titulo">ADMINISTRAÇÃO</p>
            <nav class="menu" aria-label="Administração">
                <a class="link-menu active" href="index.php" aria-current="page">Visão geral</a>
                <a class="link-menu" href="colaboradores.php">Colaboradores</a>
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

        <div class="acoes-menu">
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
                <h1>Visão geral</h1>
            </div>
        </header>

        <section class="admin-gestao" aria-labelledby="titulo-colaboradores">
            <div>
                <p class="subtitulo">GESTÃO DA EQUIPE</p>
                <h2 id="titulo-colaboradores">Colaboradores</h2>
                <p>Consulte, cadastre e atualize os colaboradores da assistência.</p>
            </div>
            <a class="admin-botao" href="colaboradores.php">Gerenciar colaboradores</a>
        </section>

        <section class="admin-areas" aria-labelledby="titulo-paineis">
            <div class="admin-titulo-secao">
                <h2 id="titulo-paineis">Painéis do sistema</h2>
                <p>Acesse a área que deseja utilizar.</p>
            </div>
            <div class="admin-grade">
                <a class="admin-card" href="../atendente/">
                    <span class="admin-icone" aria-hidden="true">AT</span>
                    <h3>Atendente</h3>
                    <p>Gerencie clientes, equipamentos e ordens de serviço.</p>
                    <span class="admin-card-link">Acessar painel <span aria-hidden="true">→</span></span>
                </a>
                <a class="admin-card" href="../tecnico/">
                    <span class="admin-icone" aria-hidden="true">TC</span>
                    <h3>Técnico</h3>
                    <p>Acompanhe as ordens e os serviços de manutenção.</p>
                    <span class="admin-card-link">Acessar painel <span aria-hidden="true">→</span></span>
                </a>
            </div>
        </section>
    </main>
</body>
</html>