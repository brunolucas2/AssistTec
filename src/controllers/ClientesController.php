<?php
require_once dirname(__DIR__) . "/database/querys.php";
require_once dirname(__DIR__) . "/database/db_connection.php";

function cadastrarCliente(array $cliente)
{
    global $pdo, $clienteSQL;

    $stmt = $pdo->prepare($clienteSQL["cadastrarCliente"]);

    $stmt->execute([
        ":nome" => $cliente["nome"],
        ":cpf" => $cliente["cpf"],
        ":email" => $cliente["email"],
        ":telefone" => $cliente["telefone"],
        ":logradouro" => $cliente["logradouro"],
        ":numero" => $cliente["numero"],
        ":bairro" => $cliente["bairro"],
        ":cidade" => $cliente["cidade"],
        ":estado" => $cliente["estado"],
        ":cep" => $cliente["cep"]
    ]);

    return $pdo->lastInsertId();
}

function atualizarCliente(array $cliente): bool
{
    global $pdo, $clienteSQL;

    $stmt = $pdo->prepare($clienteSQL["atualizarCliente"]);

    return $stmt->execute([
        ":nome" => $cliente["nome"] ?? "",
        ":cpf_atual" => $cliente["cpf_atual"],
        ":email" => $cliente["email"] ?? "",
        ":telefone" => $cliente["telefone"] ?? "",
        ":logradouro" => $cliente["logradouro"] ?? "",
        ":numero" => $cliente["numero"] ?? "",
        ":bairro" => $cliente["bairro"] ?? "",
        ":cidade" => $cliente["cidade"] ?? "",
        ":estado" => $cliente["estado"] ?? "",
        ":cep" => $cliente["cep"] ?? ""
    ]);
}