<?php
if (
    !isset($_SESSION["usuario"]["email"]) ||
    !isset($_SESSION["usuario"]["nivel"])
) {
    header("Location: ../login.php");
    exit;
} 
$nivel = $_SESSION["usuario"]["nivel"];

function verificarNivel(string $nivel)
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (
        !isset($_SESSION["usuario"]["email"]) ||
        !isset($_SESSION["usuario"]["nivel"])
    ) {
        header("Location: ../login.php");
        exit;
    }

    $nivelVerify = $nivel ?? null;

    if ($_SESSION["usuario"]["nivel"] !== $nivelVerify && $_SESSION["usuario"]["nivel"] !== "administrador") {
        http_response_code(403);
        header("Location: ../index.php");
        exit();
    }
}