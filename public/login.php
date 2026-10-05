<?php

$rota = $_GET["rota"] ?? "";

if ($rota === "auth" && $_SERVER["REQUEST_METHOD"] === "POST") {
    require_once dirname(__DIR__) . "/src/routes/auth-router.php";
    exit;
}

http_response_code(404);
exit("Rota não encontrada");