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

    try {
        $stmt->execute([
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
    return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        return false;
    }
}

function buscarClientes(): array
{
    global $pdo, $clienteSQL;

    $query = $pdo->prepare($clienteSQL["buscarClientes"]);

    $query->execute();

    $clientes = $query->fetchAll(PDO::FETCH_ASSOC);

    return $clientes;
}

function buscarCliente(string $cpfCliente): array
{
    global $pdo, $clienteSQL;

    $stmt = $pdo->prepare($clienteSQL["buscarCliente"]);

    $stmt->execute([
        ":cpf" => $cpfCliente
    ]);

    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    return $cliente;
}

function deletarCliente(string $cpfCliente): bool
{
    global $pdo, $clienteSQL;

    try {
        $stmt = $pdo->prepare($clienteSQL["deletarCliente"]);
        $stmt->execute([
            ":cpf" => $cpfCliente
        ]);

        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        return false;
    }
}