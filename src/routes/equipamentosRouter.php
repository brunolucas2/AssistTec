<?php

require_once dirname(__DIR__) . "/controllers/equipamentosController.php";
require_once dirname(__DIR__) . "/helper/validarDados.php";

$equipamentosPage = "../../public/atendente/equipamentos.php";

$rota = $_GET["rota"] ?? "";

$metodosPermitidos = [
    "buscarEquipamentos"   => "GET",
    "buscarEquipamento"    => "GET",
    "cadastrarEquipamento" => "POST",
    "atualizarEquipamento" => "POST",
    "deletarEquipamento"   => "POST"
];

if (!isset($metodosPermitidos[$rota])) {
    http_response_code(404);
    exit("Rota não encontrada.");
}

if ($_SERVER["REQUEST_METHOD"] !== $metodosPermitidos[$rota]) {
    http_response_code(405);
    exit("Método não permitido.");
}

switch ($rota) {
    case "cadastrarEquipamento":
        rota_cadastrarEquipamento();
        break;

    case "buscarEquipamentos":
        rota_buscarEquipamentos();
        break;

    case "buscarEquipamento":
        rota_buscarEquipamento();
        break;

    case "atualizarEquipamento":
        rota_atualizarEquipamento();
        break;

    case "deletarEquipamento":
        rota_deletarEquipamento();
        break;

    default:
        http_response_code(404);
        exit("Ação não encontrada!");
}

function rota_cadastrarEquipamento(): void
{
    global $equipamentosPage;

    $campos = [
        "id_cliente",
        "tipo",
        "marca",
        "numero_de_serie",
        "patrimonio",
        "descricao",
        "sistema_operacional",
        "senha_de_acesso"
    ];

    validador($campos, $_POST, $equipamentosPage);

    try {
        cadastrarEquipamento($_POST);

        $_SESSION["flash"] = [
            "tipo" => "sucesso",
            "mensagem" => "Equipamento cadastrado com sucesso."
        ];
    } catch (PDOException $e) {
        error_log($e->getMessage());

        $_SESSION["flash"] = [
            "tipo" => "erro",
            "mensagem" => "Não foi possível cadastrar o equipamento."
        ];

        http_response_code(500);
        exit("Erro ao cadastrar o equipamento.");
    }

    header("Location: $equipamentosPage");
    exit;
}

function rota_buscarEquipamentos(): void
{
    header("Content-Type: application/json; charset=utf-8");

    try {
        echo json_encode(buscarEquipamentos(), JSON_UNESCAPED_UNICODE);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        http_response_code(500);

        echo json_encode(
            ["erro" => "Não foi possível buscar os equipamentos."],
            JSON_UNESCAPED_UNICODE
        );
    }

    exit;
}

function rota_buscarEquipamento(): void
{
    header("Content-Type: application/json; charset=utf-8");

    $id = filter_input(INPUT_GET, "id_equipamento", FILTER_VALIDATE_INT);

    if ($id === false || $id === null || $id <= 0) {
        http_response_code(400);
        echo json_encode(["erro" => "ID do equipamento inválido ou não informado."]);
        exit;
    }

    try {
        $equipamento = buscarEquipamento($id);

        if ($equipamento === false) {
            http_response_code(404);
            echo json_encode(["erro" => "Equipamento não encontrado."]);
            exit;
        }

        echo json_encode($equipamento, JSON_UNESCAPED_UNICODE);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        http_response_code(500);
        echo json_encode(["erro" => "Não foi possível buscar o equipamento."]);
    }

    exit;
}

function rota_atualizarEquipamento(): void
{
    global $equipamentosPage;

    $campos = ["id_equipamento"];
    validador($campos, $_POST, $equipamentosPage);

    try {
        atualizarEquipamento($_POST);

        $_SESSION["flash"] = [
            "tipo" => "sucesso",
            "mensagem" => "Equipamento atualizado com sucesso."
        ];
    } catch (PDOException $e) {
        error_log($e->getMessage());

        $_SESSION["flash"] = [
            "tipo" => "erro",
            "mensagem" => "Não foi possível atualizar o equipamento."
        ];

        http_response_code(500);
        exit("Erro ao atualizar o equipamento.");
    }

    header("Location: $equipamentosPage");
    exit;
}

function rota_deletarEquipamento(): void
{
    header("Content-Type: application/json; charset=utf-8");

    $id = filter_input(INPUT_POST, "id_equipamento", FILTER_VALIDATE_INT);

    if ($id === false || $id === null || $id <= 0) {
        http_response_code(400);
        echo json_encode(["erro" => "ID do equipamento inválido ou não informado."]);
        exit;
    }

    try {
        $deletado = deletarEquipamento($id);

        if (!$deletado) {
            http_response_code(404);
            echo json_encode(["erro" => "Equipamento não encontrado."]);
            exit;
        }

        echo json_encode(["mensagem" => "Equipamento excluído com sucesso."]);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        http_response_code(500);
        echo json_encode(["erro" => "Não foi possível excluir o equipamento."]);
    }

    exit;
}
