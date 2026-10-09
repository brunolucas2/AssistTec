<?php

require_once dirname(__DIR__) . "/database/db_connection.php";
require_once dirname(__DIR__) . "/database/querys.php";

function cadastrarOrdem(array $ordem): void
{
    global $pdo, $ordemSQL;

    $stmt = $pdo->prepare($ordemSQL["cadastrarOrdem"]);
    $stmt->execute([
        ":id_cliente" => $ordem["id_cliente"],
        ":id_equipamento" => $ordem["id_equipamento"],
        ":id_tecnico" => $ordem["id_tecnico"],
        ":numero_da_os" => $ordem["numero_da_os"],
        ":data_de_previsao" => ($ordem["data_de_previsao"] ?? "") === "" ? null : $ordem["data_de_previsao"],
        ":problema_relatado" => $ordem["problema_relatado"],
        ":prioridade" => ($ordem["prioridade"] ?? "") === "" ? "media" : $ordem["prioridade"],
        ":valor_estimado" => ($ordem["valor_estimado"] ?? "") === "" ? null : $ordem["valor_estimado"],
        ":observacoes" => $ordem["observacoes"] ?? null
    ]);
}

function atualizarOrdem(array $ordem): bool
{
    global $pdo, $ordemSQL;

    $ordemAtual = buscarOrdem($ordem["id_ordem"]);

    if ($ordemAtual === false) {
        return false;
    }

    // Mantém os dados dos campos que não foram enviados.
    $ordem = array_replace($ordemAtual, $ordem);

    $stmt = $pdo->prepare($ordemSQL["atualizarOrdem"]);

    return $stmt->execute([
        ":id_ordem" => $ordem["id_ordem"],
        ":data_de_previsao" => $ordem["data_de_previsao"] === "" ? null : $ordem["data_de_previsao"],
        ":diagnostico" => $ordem["diagnostico"],
        ":servico" => $ordem["servico"],
        ":prioridade" => $ordem["prioridade"],
        ":valor_estimado" => $ordem["valor_estimado"] === "" ? null : $ordem["valor_estimado"],
        ":valor_final" => $ordem["valor_final"] === "" ? null : $ordem["valor_final"],
        ":forma_de_pagamento" => $ordem["forma_de_pagamento"],
        ":status" => $ordem["status"],
        ":observacoes" => $ordem["observacoes"]
    ]);
}

function buscarOrdens(): array
{
    global $pdo, $ordemSQL;

    $stmt = $pdo->prepare($ordemSQL["buscarOrdens"]);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function buscarOrdem(int $id_ordem): array|false
{
    global $pdo, $ordemSQL;

    $stmt = $pdo->prepare($ordemSQL["buscarOrdem"]);
    $stmt->execute([
        ":id_ordem" => $id_ordem
    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function cancelarOrdem(int $id_ordem): bool
{
    global $pdo, $ordemSQL;

    $stmt = $pdo->prepare($ordemSQL["cancelarOrdem"]);
    $stmt->execute([
        ":id_ordem" => $id_ordem
    ]);

    return $stmt->rowCount() > 0;
}
