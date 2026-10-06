<?php

$nivelDapagina = "atendente";

require_once dirname(__DIR__) . "/utils/verificarNivel.php";



$email = htmlspecialchars(
    $_SESSION["usuario"]["email"],
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
    <aside class="sidebar" id="sidebar">
        <a class="brand" href="index.php">
            <span class="brand-icon">AT</span>
            <span>Assis<span class="brand-blue">Tec</span></span>
        </a>

        <p class="menu-label">MENU</p>

        <nav class="menu">
            <a class="menu-link active" href="index.php">Visão geral</a>
            <a class="menu-link" href="clientes.php">Clientes</a>
            <a class="menu-link" href="equipamentos.php">Equipamentos</a>
            <a class="menu-link" href="ordens.php">Abrir ordem de serviço</a>
            <a class="menu-link" href="atendimentos.php">Atendimentos</a>
        </nav>

        <div class="sidebar-bottom">
            <span class="user-role">Atendente</span>
            <span class="user-email"><?= $email ?></span>
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
                <h1>Visão geral</h1>
            </div>
        </header>

        <section class="welcome">
            <div>
                <h2>Bem-vindo ao painel</h2>
                <p>Gerencie clientes, equipamentos e ordens de serviço.</p>
            </div>
            <a class="primary-button" href="ordens.php">+ Abrir ordem de serviço</a>
        </section>

        <section class="cards" aria-label="Ações do atendente">
            <a class="action-card" href="clientes.php">
                <span class="card-label">CADASTRO</span>
                <h2>Clientes</h2>
                <p>Cadastre e consulte clientes.</p>
                <span class="card-arrow">→</span>
            </a>

            <a class="action-card" href="equipamentos.php">
                <span class="card-label">CADASTRO</span>
                <h2>Equipamentos</h2>
                <p>Registre equipamentos dos clientes.</p>
                <span class="card-arrow">→</span>
            </a>

            <a class="action-card" href="ordens.php">
                <span class="card-label">ATENDIMENTO</span>
                <h2>Ordens de serviço</h2>
                <p>Abra uma nova ordem de serviço.</p>
                <span class="card-arrow">→</span>
            </a>

            <a class="action-card" href="atendimentos.php">
                <span class="card-label">CONSULTA</span>
                <h2>Atendimentos</h2>
                <p>Consulte os atendimentos registrados.</p>
                <span class="card-arrow">→</span>
            </a>
        </section>

        <section class="recent-section">
            <div>
                <h2>Atendimentos recentes</h2>
                <p>Os atendimentos registrados aparecerão aqui.</p>
            </div>

            <a class="text-link" href="atendimentos.php">Ver todos →</a>
        </section>
    </main>
</body>
</html>