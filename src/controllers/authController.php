<?php

require_once dirname(__DIR__) . "/database/querys.php";
require_once dirname(__DIR__) . "/database/db_connection.php";

function auth(array $usuario)
{
    global $pdo, $authSQL;

    $stmt = $pdo->prepare($authSQL["auth"]);
    $stmt->execute([
        "email" => $usuario["email"]
    ]);

    $usuarioBanco = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuarioBanco === false) {
        return 404;
    }

    if (password_verify($usuario["senha"], $usuarioBanco["senha"])) {
        return $usuarioBanco["nivel"];
    }

    return 401;
}