<?php

require_once dirname(__DIR__) . "/database/querys.php";
require_once dirname(__DIR__) . "/database/db_connection.php";

function cadastrarCliente(array $cliente): void
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

function buscarClientes(): array
{
    global $pdo, $clienteSQL;

    $stmt = $pdo->prepare($clienteSQL["buscarClientes"]);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function buscarCliente(string $cpfCliente): array|false
{
    global $pdo, $clienteSQL;

    $stmt = $pdo->prepare($clienteSQL["buscarCliente"]);
    $stmt->execute([
        ":cpf" => $cpfCliente
    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function deletarCliente(string $cpfCliente): bool
{
    global $pdo, $clienteSQL;

    $stmt = $pdo->prepare($clienteSQL["deletarCliente"]);
    $stmt->execute([
        ":cpf" => $cpfCliente
    ]);

    return $stmt->rowCount() > 0;
}