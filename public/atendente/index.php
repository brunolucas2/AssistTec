<?php

$nivelDapagina = "atendente";

require_once dirname(__DIR__) . "/utils/verificarNivel.php";



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

    <title>Painel do Atendente | AssisTec</title>
    <link rel="stylesheet" href="../css/atendente.css">
    <script src="../js/atendente.js" defer></script>
</head>

<body>
    <aside class="menu-lateral" id="sidebar">
        <a class="marca" href="index.php">
            <span class="marca-icone">AT</span>
            <span>Assis<span class="marca-azul">Tec</span></span>
        </a>

        <p class="menu-titulo">MENU</p>

        <nav class="menu">
            <a class="link-menu active" href="index.php">Visão geral</a>
            <a class="link-menu" href="clientes.php">Clientes</a>
            <a class="link-menu" href="equipamentos.php">Equipamentos</a>
            <a class="link-menu" href="ordens.php">Abrir ordem de serviço</a>
            <a class="link-menu" href="atendimentos.php">Atendimentos</a>
        </nav>

        <div class="usuario-logado">
            <span class="usuario-cargo">Atendente</span>
            <span class="usuario-email"><?= $email ?></span>
        </div>
    </aside>

    <main class="conteudo">
        <header class="cabecalho">
            <button class="abrir-menu" id="menuToggle" type="button"
                aria-label="Abrir menu" aria-expanded="false">☰</button>

            <div>
                <p class="subtitulo">AssisTec / Atendente</p>
                <h1>Visão geral</h1>
            </div>
        </header>

        <section class="boas-vindas">
            <div>
                <h2>Bem-vindo ao painel</h2>
                <p>Gerencie clientes, equipamentos e ordens de serviço.</p>
            </div>
            <a class="botao-principal" href="ordens.php">+ Abrir ordem de serviço</a>
        </section>

        <section class="atalhos" aria-label="Ações do atendente">
            <a class="atalho" href="clientes.php">
                <span class="card-tipo">CADASTRO</span>
                <h2>Clientes</h2>
                <p>Cadastre e consulte clientes.</p>
                <span class="seta">→</span>
            </a>

            <a class="atalho" href="equipamentos.php">
                <span class="card-tipo">CADASTRO</span>
                <h2>Equipamentos</h2>
                <p>Registre equipamentos dos clientes.</p>
                <span class="seta">→</span>
            </a>

            <a class="atalho" href="ordens.php">
                <span class="card-tipo">ATENDIMENTO</span>
                <h2>Ordens de serviço</h2>
                <p>Abra uma nova ordem de serviço.</p>
                <span class="seta">→</span>
            </a>

            <a class="atalho" href="atendimentos.php">
                <span class="card-tipo">CONSULTA</span>
                <h2>Atendimentos</h2>
                <p>Consulte os atendimentos registrados.</p>
                <span class="seta">→</span>
            </a>
        </section>

        <section class="recentes">
            <div>
                <h2>Atendimentos recentes</h2>
                <p>Os atendimentos registrados aparecerão aqui.</p>
            </div>
            <a class="link-texto" href="atendimentos.php">Ver todos →</a>
        </section>
    </main>
</body>

</html>