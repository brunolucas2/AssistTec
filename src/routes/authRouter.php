<?php
require_once dirname(__DIR__, 2) . "/session_helper.php";
require_once dirname(__DIR__) . "/controllers/AuthController.php";
require_once dirname(__DIR__) . "/utils/jwt.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Método não permitido.");
}

if (!isset($_POST["email"], $_POST["senha"])) {
    http_response_code(400);
    exit("Faltou e-mail ou senha no envio");
}

$email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);

if ($email === false || $email === null) {
    http_response_code(400);
    exit("E-mail inválido ou não informado.");
}

try {
    if (!auth([
        "email" => $email,
        "senha" => $_POST["senha"]
    ])) {
        http_response_code(401);
        exit("Email ou senha inválidos");
    }

    $dados = buscarDados($email);

    if ($dados === false) {
        http_response_code(500);
        exit("Erro ao buscar dados do usuário");
    }

    try {
        $jwt = gerarJWT($dados["id"], $dados["nivel"]);
    } catch (RuntimeException $e) {
        error_log($e->getMessage());
        http_response_code(500);
        exit("Erro ao gerar autorização");
    }
} catch (PDOException $e) {
    error_log($e->getMessage());
    exit("Erro no servidor");
}

session_regenerate_id(true);

# Salvar o JWT em um cookie HttpOnly para autorização de acesso.
setcookie("access_token", $jwt, [
    "expires" => time() + 7200,
    "path" => "/",
    "secure" => true,
    "httponly" => true,
    "samesite" => "Strict"
]);

# Criar sessão do usuário para autenticação e controle de acesso às páginas.
$_SESSION["usuario"] = [
    "email" => $email,
    "nivel" => $dados["nivel"]
];

header("Location: ../../index.php");