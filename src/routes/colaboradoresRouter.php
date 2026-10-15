<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once dirname(__DIR__) . "/controllers/ColaboradoresController.php";
require_once dirname(__DIR__) . "/helper/validarDados.php";

$colaboradoresPage = "../../public/admin/colaboradores.php";
$rota = $_GET["rota"] ?? "";

$metodosPermitidos = [
    "buscarColaboradores" => "GET",
    "buscarColaborador" => "GET",
    "cadastrarColaborador" => "POST",
    "atualizarColaborador" => "POST",
    "deletarColaborador" => "POST"
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
    case "buscarColaboradores":
        rota_buscarColaboradores();
        break;

    case "buscarColaborador":
        rota_buscarColaborador();
        break;

    case "cadastrarColaborador":
        rota_cadastrarColaborador();
        break;

    case "atualizarColaborador":
        rota_atualizarColaborador();
        break;

    case "deletarColaborador":
        rota_deletarColaborador();
        break;
}

function rota_buscarColaboradores(): void
{
    header("Content-Type: application/json; charset=utf-8");

    try {
        echo json_encode(buscarColaboradores(), JSON_UNESCAPED_UNICODE);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        http_response_code(500);
        echo json_encode(["erro" => "Não foi possível buscar os colaboradores"]);
    }

    exit;
}

function rota_buscarColaborador(): void
{
    header("Content-Type: application/json; charset=utf-8");

    $id = filter_input(INPUT_GET, "id_ordem", FILTER_VALIDATE_INT);

    if ($id == false || $id === null || $id <= 0) {
        http_response_code(400);
        echo json_encode(["erro" => "ID do colaborador inválido ou não informado"]);
        exit;
    }

    try {
        $colaborador = buscarColaborador($id);

        if ($colaborador === false) {
            http_response_code(404);
            echo json_encode(["erro" => "Colaborador não encontrado."], JSON_UNESCAPED_UNICODE);
            exit;
        }

        echo json_encode($colaborador, JSON_UNESCAPED_UNICODE);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        http_response_code(500);
        echo json_encode(["erro" => "Não foi possível buscar o colaborador"]);
    }

    exit;
}

function rota_cadastrarColaborador(): void
{
    global $colaboradoresPage;

    $campos = [
        "nome",
        "cargo",
        "cpf",
        "email",
        "telefone",
        "logradouro",
        "numero",
        "bairro",
        "cidade",
        "estado",
        "cep"
    ];

    validador($campos, $_POST, $colaboradoresPage);

    try {
        cadastrarColaborador($_POST);
        $_SESSION["flash"] = [
            "tipo" => "sucesso",
            "mensagem" => "Colaborador cadastrado com sucesso."
        ];
    } catch (PDOException $e) {
        error_log($e->getMessage());
        $_SESSION["flash"] = [
            "tipo" => "erro",
            "mensagem" => "Não foi possível cadastrar o colaborador."
        ];
    }
}

function rota_atualizarColaborador(): void
{
    global $colaboradoresPage;

    validador(["id_colaborador"], $_POST, $colaboradoresPage);

    $id = filter_input(INPUT_POST, "id_colaborador", FILTER_VALIDATE_INT);

    if ($id === false || $id === null || $id <= 0) {
        $_SESSION["flash"] = [
            "tipo" => "erro",
            "mensagem" => "ID do colaborador inválido ou não informado."
        ];
        header("Location: $colaboradoresPage");
        exit;
    }

    try {
        $atualizou = atualizarColaborador($_POST);
        $_SESSION["flash"] = [
            "tipo" => $atualizou ? "sucesso" : "erro",
            "mensagem" => $atualizou
                ? "Colaborador atualizad com sucesso."
                : "Colaborador não encontrada."
        ];
    } catch (PDOException $e) {
        error_log($e->getMessage());
        $_SESSION["flash"] = [
            "tipo" => "erro",
            "mensagem" => "Não foi possível atualizar o Colaborador."
        ];
    }
}

function rota_deletarColaborador(): void
{
    header("Content-Type: application/json; charset=utf-8");

    $id = filter_input(INPUT_POST, "id_colaborador", FILTER_VALIDATE_INT);

    if ($id === false || $id === null || $id <= 0) {
        http_response_code(400);
        echo json_encode(["erro" => "ID do equipamento inválido ou não informado."], JSON_UNESCAPED_UNICODE);
        exit;
    }

    try {
        if (!deletarColaborador($id)) {
            http_response_code(404);
            echo json_encode(["erro" => "Colaborador não encontrado."], JSON_UNESCAPED_UNICODE);
            exit;
        }

        echo json_encode(["mensagem" => "Colaborador excluído com sucesso."], JSON_UNESCAPED_UNICODE);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        http_response_code(500);
        echo json_encode(["erro" => "Não foi possível excluir o colaborador."], JSON_UNESCAPED_UNICODE);
    }

    exit;
}
