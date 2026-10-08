<?php

require_once dirname(__DIR__) . "/database/db_connection.php";
require_once dirname(__DIR__) . "/database/querys.php";

function cadastrarEquipamento(array $equipamento): void
{
    global $pdo, $equipamentoSQL;

    $stmt = $pdo->prepare($equipamentoSQL["cadastrarEquipamento"]);

    $stmt->execute([
        ":id_cliente" => $equipamento["id_cliente"],
        ":tipo" => $equipamento["tipo"],
        ":marca" => $equipamento["marca"],
        ":numero_de_serie" => $equipamento["numero_de_serie"],
        ":patrimonio" => $equipamento["patrimonio"],
        ":descricao" => $equipamento["descricao"],
        ":sistema_operacional" => $equipamento["sistema_operacional"],
        ":senha_de_acesso" => $equipamento["senha_de_acesso"]
    ]);
}

function atualizarEquipamento(array $equipamento): bool
{
    global $pdo, $equipamentoSQL;

    try {
        $stmt = $pdo->prepare($equipamentoSQL["atualizarEquipamento"]);

        return $stmt->execute([
            ":id_equipamento" => $equipamento["id_equipamento"],
            ":tipo" => $equipamento["tipo"] === "" ? null : $equipamento["tipo"],
            ":marca" => $equipamento["marca"] === "" ? null : $equipamento["marca"],
            ":numero_de_serie" => $equipamento["numero_de_serie"] === "" ? null : $equipamento["numero_de_serie"],
            ":patrimonio" => $equipamento["patrimonio"] === "" ? null : $equipamento["patrimonio"],
            ":descricao" => $equipamento["descricao"] === "" ? null : $equipamento["descricao"],
            ":sistema_operacional" => $equipamento["sistema_operacional"] === "" ? null : $equipamento["sistema_operacional"],
            ":senha_de_acesso" => $equipamento["senha_de_acesso"] === "" ? null : $equipamento["senha_de_acesso"]
        ]);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
}

function buscarEquipamentos(): array
{
    global $pdo, $equipamentoSQL;

    $query = $pdo->prepare($equipamentoSQL["buscarEquipamentos"]);

    $query->execute();

    $equipamentos = $query->fetchAll(PDO::FETCH_ASSOC);

    return $equipamentos;
}

function buscarEquipamento(int $equipamento_id): array|false
{
    global $pdo, $equipamentoSQL;

    $stmt = $pdo->prepare($equipamentoSQL["buscarEquipamento"]);

    $stmt->execute([
        ":id_equipamento" => $equipamento_id
    ]);

    $equipamento = $stmt->fetch(PDO::FETCH_ASSOC);

    return $equipamento;
}

function deletarEquipamento(int $id_equipamento): bool
{
    global $pdo, $equipamentoSQL;

    try {
        $stmt = $pdo->prepare($equipamentoSQL["deletarEquipamento"]);
        $stmt->execute([
            ":id_equipamento" => $id_equipamento
        ]);

        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        return false;
    }
}
