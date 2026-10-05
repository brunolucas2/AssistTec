<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$paginasPorNivel = [
    "administrador" => "administrador/index.php",
    "tecnico" => "tecnico/index.php",
    "atendente" => "atendente/index.php"
];

$usuario = $_SESSION["usuario"] ?? null;

if ($usuario !== null) {
    $email = is_array($usuario) ? ($usuario["email"] ?? null) : null;
    $nivel = is_array($usuario) ? ($usuario["nivel"] ?? null) : null;

    $sessaoValida =
        is_string($email) &&
        filter_var($email, FILTER_VALIDATE_EMAIL) &&
        is_string($nivel) &&
        isset($paginasPorNivel[$nivel]);

    if ($sessaoValida) {
        header("Location: " . $paginasPorNivel[$nivel]);
        exit;
    }

    unset($_SESSION["usuario"]);
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Entrar | AssisTec</title>
    <meta name="description" content="Acesse sua conta no sistema AssisTec.">
    <meta name="robots" content="noindex, nofollow">

    <meta name="theme-color" content="#08111f">
    <meta name="color-scheme" content="dark">

    <link rel="stylesheet" href="./css/login.css">
</head>

<body>
    <main class="login">
        <div class="brand">
            <span class="brand-icon">AT</span>
            <span class="brand-name">Assis<span>Tec</span></span>
        </div>

        <h1>Entrar</h1>
        <p>Acesse sua conta</p>

        <form action="./index.php?rota=auth" method="POST">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" placeholder="seu@email.com" autocomplete="email" required>

            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" placeholder="Digite sua senha"
                autocomplete="current-password" required>

            <button type="submit">Entrar</button>
        </form>
    </main>
</body>

</html>