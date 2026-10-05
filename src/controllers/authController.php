<?php

include "./database/querys.php";
include "./database/db_connection.php";

function auth(array $dados)
{
    global $pdo, $SQL;

    $stmt = $pdo->prepare($SQL["auth"]);
    $stmt->execute([
        "email" => $dados["email"]
    ]);

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario === false) {
        return 404;
    }

    if (password_verify($dados["senha"], $usuario["senha"])) {
        return $usuario["nivel"];
    } else {
        return 401;
    }
}
