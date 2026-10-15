<?php

require_once dirname(__DIR__, 2) . "/vendor/autoload.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$env = parse_ini_file(dirname(__DIR__, 2) . "/.env");

$chave =  $env["JWT_SECRET"];

function gerarJWT(int $id, string $nivel): string
{
    global $chave;

    if (!$chave) {
        throw new RuntimeException("Chave JWT não configurada");
    }

    $payload = [
        "sub" => "user_" . (string) $id,
        "nivel" => $nivel,
        "iat" => time(),
        "exp" => time() + 7200
    ];

    return JWT::encode($payload, $chave, "HS256");
}

function validarJWT(string $token): object|false
{
    global $chave;

    if (!$chave) {
        throw new RuntimeException("Chave JWT não configurada");
    }

    try {
        return JWT::decode($token, new Key($chave, "HS256"));
    } catch (Exception $e) {
        return false;
    }
}
