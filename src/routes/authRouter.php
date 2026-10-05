<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Método não permitido");
}

if (($_GET["rota"] ?? "") !== "auth") {
    http_response_code(404);
    exit("Rota não encontrada");
}

if (!isset($_POST["email"], $_POST["senha"])) {
    http_response_code(400);
    exit("Faltou e-mail ou senha no envio");
}

require_once dirname(__DIR__) . "/controllers/authController.php";

$verificarUsuario = auth([
    "email" => $_POST["email"],
    "senha" => $_POST["senha"]
]);

if ($verificarUsuario === 401) {
    http_response_code(401);
    exit("Usuário não encontrado");
}

if ($verificarUsuario === 403) {
    http_response_code(401);
    exit("E-mail ou senha incorretos");
}

$_SESSION["usuario"] = [
    "email" => $_POST["email"],
    "nivel" => $verificarUsuario
];

