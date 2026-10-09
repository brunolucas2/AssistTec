<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once dirname(__DIR__) . "/controllers/atendimentosController.php";
require_once dirname(__DIR__) . "/helper/validarDados.php";

$atendimentosPage = "../../public/atendente/atendimentos.php";
$rota = $_GET["rota"] ?? "";

$metodosPermitidos = [
    "buscarOrdens" => "GET",
    "buscarOrdem" => "GET",
    "cadastrarOrdem" => "POST",
    "atualizarOrdem" => "POST",
    "cancelarOrdem" => "POST"
];

if (!is_string($rota) || !isset($metodosPermitidos[$rota])) {
    http_response_code(404);
    exit("Rota não encontrada.");
}

if ($_SERVER["REQUEST_METHOD"] !== $metodosPermitidos[$rota]) {
    http_response_code(405);
    exit("Método não permitido.");
}

switch ($rota) {
    case "buscarOrdens":
        rota_buscarOrdens();
        break;

    case "buscarOrdem":
        rota_buscarOrdem();
        break;

    case "cadastrarOrdem":
        rota_cadastrarOrdem();
        break;

    case "atualizarOrdem":
        rota_atualizarOrdem();
        break;

    case "cancelarOrdem":
        rota_cancelarOrdem();
        break;
}

function rota_cadastrarOrdem(): void
{
    global $atendimentosPage;

    $campos = [
        "id_cliente",
        "id_equipamento",
        "id_tecnico",
        "numero_da_os",
        "problema_relatado"
    ];

    validador($campos, $_POST, $atendimentosPage);

    try {
        cadastrarOrdem($_POST);
        $_SESSION["flash"] = [
            "tipo" => "sucesso",
            "mensagem" => "Ordem de serviço cadastrada com sucesso."
        ];
    } catch (PDOException $e) {
        error_log($e->getMessage());
        $_SESSION["flash"] = [
            "tipo" => "erro",
            "mensagem" => "Não foi possível cadastrar a ordem de serviço."
        ];
    }

    header("Location: $atendimentosPage");
    exit;
}

function rota_buscarOrdens(): void
{
    header("Content-Type: application/json; charset=utf-8");

    try {
        echo json_encode(buscarOrdens(), JSON_UNESCAPED_UNICODE);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        http_response_code(500);
        echo json_encode(["erro" => "Não foi possível buscar as ordens de serviço."], JSON_UNESCAPED_UNICODE);
    }

    exit;
}

function rota_buscarOrdem(): void
{
    header("Content-Type: application/json; charset=utf-8");

    $id = filter_input(INPUT_GET, "id_ordem", FILTER_VALIDATE_INT);

    if ($id === false || $id === null || $id <= 0) {
        http_response_code(400);
        echo json_encode(["erro" => "ID da ordem inválido ou não informado."], JSON_UNESCAPED_UNICODE);
        exit;
    }

    try {
        $ordem = buscarOrdem($id);

        if ($ordem === false) {
            http_response_code(404);
            echo json_encode(["erro" => "Ordem de serviço não encontrada."], JSON_UNESCAPED_UNICODE);
            exit;
        }

        echo json_encode($ordem, JSON_UNESCAPED_UNICODE);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        http_response_code(500);
        echo json_encode(["erro" => "Não foi possível buscar a ordem de serviço."], JSON_UNESCAPED_UNICODE);
    }

    exit;
}

function rota_atualizarOrdem(): void
{
    global $atendimentosPage;

    validador(["id_ordem"], $_POST, $atendimentosPage);

    $id = filter_input(INPUT_POST, "id_ordem", FILTER_VALIDATE_INT);

    if ($id === false || $id === null || $id <= 0) {
        $_SESSION["flash"] = [
            "tipo" => "erro",
            "mensagem" => "ID da ordem inválido ou não informado."
        ];
        header("Location: $atendimentosPage");
        exit;
    }

    try {
        $atualizou = atualizarOrdem($_POST);
        $_SESSION["flash"] = [
            "tipo" => $atualizou ? "sucesso" : "erro",
            "mensagem" => $atualizou
                ? "Ordem de serviço atualizada com sucesso."
                : "Ordem de serviço não encontrada."
        ];
    } catch (PDOException $e) {
        error_log($e->getMessage());
        $_SESSION["flash"] = [
            "tipo" => "erro",
            "mensagem" => "Não foi possível atualizar a ordem de serviço."
        ];
    }

    header("Location: $atendimentosPage");
    exit;
}

function rota_cancelarOrdem(): void
{
    header("Content-Type: application/json; charset=utf-8");

    $id = filter_input(INPUT_POST, "id_ordem", FILTER_VALIDATE_INT);

    if ($id === false || $id === null || $id <= 0) {
        http_response_code(400);
        echo json_encode(["erro" => "ID da ordem inválido ou não informado."], JSON_UNESCAPED_UNICODE);
        exit;
    }

    try {
        if (!cancelarOrdem($id)) {
            http_response_code(409);
            echo json_encode(["erro" => "Ordem não encontrada ou já cancelada."], JSON_UNESCAPED_UNICODE);
            exit;
        }

        echo json_encode(["mensagem" => "Ordem de serviço cancelada com sucesso."], JSON_UNESCAPED_UNICODE);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        http_response_code(500);
        echo json_encode(["erro" => "Não foi possível cancelar a ordem de serviço."], JSON_UNESCAPED_UNICODE);
    }

    exit;
}
