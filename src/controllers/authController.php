<?php

include "./database/querys.php";
include "./database/db_connection.php";

function auth(array $usuario)
{
    global $pdo, $authSQL;

    $stmt = $pdo->prepare($authSQL["auth"]);
    $stmt->execute([
        "email" => $usuario["email"]
    ]);

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario === false) {
        return 404;
    }

    if (password_verify($usuario["senha"], $usuario["senha"])) {
        return $usuario["nivel"];
    } else {
        return 401;
    }
}
