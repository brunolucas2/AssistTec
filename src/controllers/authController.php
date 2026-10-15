<?php

require_once dirname(__DIR__) . "/database/querys.php";
require_once dirname(__DIR__) . "/database/db_connection.php";

function auth(array $usuario): bool
{
    global $pdo, $authSQL;

    $stmt = $pdo->prepare($authSQL["autenticar"]);
    $stmt->execute([
        "email" => $usuario["email"]
    ]);

    $usuarioBanco = $stmt->fetch(PDO::FETCH_ASSOC);

    if (password_verify($usuario["senha"], $usuarioBanco["senha"])) {
        return true;
    }

    return false;
}

function buscarDados(string $email): array|bool
{
    global $pdo, $authSQL;

    $stmt = $pdo->prepare($authSQL["buscarDados"]);
    $stmt->execute([":login" => $email]);

    if ($stmt == false) {
        return $stmt;
    }

    $dados = $stmt->fetch(PDO::FETCH_ASSOC);

    return [
        "id" => (int) $dados["id_usuario"],
        "nivel" => $dados["nivel"]
    ];
}
