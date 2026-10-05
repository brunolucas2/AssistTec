<?php
include "./database/querys.php";
include "./database/db_connection.php";

function cadastrarCliente(array $cliente)
{
    global $pdo, $clienteSQL;

    $stmt = $pdo->prepare($clienteSQL);

    $stmt->execute([
        ":nome" => $cliente["nome"],
        ":cpf" => $cliente["cpf"],
        ":email" => $cliente["email"],
        ":logradouro" => $cliente["logradouro"],
        ":numero" => $cliente["numero"],
        ":bairro" => $cliente["bairro"],
        ":cidade" => $cliente["cidade"],
        ":estado" => $cliente["estado"],
        ":cep" => $cliente["cep"]
    ]);

    return $pdo->lastInsertId();
}
