<?php

require_once dirname(__DIR__) . "/database/db_connection.php";
require_once dirname(__DIR__) . "/database/querys.php";

function cadastrarColaborador(array $colaborador): void
{
    global $pdo, $colaboradorSQL;

    $stmt = $pdo->prepare($colaboradorSQL["cadastrarColaborador"]);
    $stmt->execute([
        ":nome" => $colaborador["nome"],
        ":cargo" => $colaborador["cargo"],
        ":cpf" => $colaborador["cpf"],
        ":email" => $colaborador["email"],
        ":telefone" => $colaborador["telefone"],
        ":logradouro" => $colaborador["logradouro"],
        ":numero" => $colaborador["numero"],
        ":bairro" => $colaborador["bairro"],
        ":cidade" => $colaborador["cidade"],
        ":estado" => $colaborador["estado"],
        ":cep" => $colaborador["cep"]
    ]);
}

function atualizarColaborador(array $colaborador): bool
{
    global $pdo, $colaboradorSQL;

    $stmt = $pdo->prepare($colaboradorSQL["atualizarColaborador"]);

    return $stmt->execute([
        ":id_colaborador" => $colaborador["id_colaborador"],
        ":nome" => $colaborador["nome"] ?? "",
        ":cargo" => $colaborador["cargo"] ?? "",
        ":cpf" => $colaborador["cpf"] ?? "",
        ":email" => $colaborador["email"] ?? "",
        ":telefone" => $colaborador["telefone"] ?? "",
        ":logradouro" => $colaborador["logradouro"] ?? "",
        ":numero" => $colaborador["numero"] ?? "",
        ":bairro" => $colaborador["bairro"] ?? "",
        ":cidade" => $colaborador["cidade"] ?? "",
        ":estado" => $colaborador["estado"] ?? "",
        ":cep" => $colaborador["cep"] ?? ""
    ]);
}

function buscarColaboradores(): array
{
    global $pdo, $colaboradorSQL;

    $stmt = $pdo->prepare($colaboradorSQL["buscarColaboradores"]);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function buscarColaborador(int $id_colaborador): array|false
{
    global $pdo, $colaboradorSQL;

    $stmt = $pdo->prepare($colaboradorSQL["buscarColaborador"]);
    $stmt->execute([
        ":id_colaborador" => $id_colaborador
    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function deletarColaborador(int $id_colaborador): bool
{
    global $pdo, $colaboradorSQL;

    $stmt = $pdo->prepare($colaboradorSQL["deletarColaborador"]);
    $stmt->execute([
        ":id_colaborador" => $id_colaborador
    ]);

    return $stmt->rowCount() > 0;
}