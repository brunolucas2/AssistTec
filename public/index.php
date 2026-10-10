<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$paginasPorNivel = [
    "administrador" => "atendente/index.php",
    "tecnico" => "tecnico/index.php",
    "atendente" => "atendente/index.php"
];

$usuario = $_SESSION["usuario"] ?? null;

if ($usuario === null) {
    header("Location: login.php");
    exit;
}

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

header("Location: login.php");
exit;