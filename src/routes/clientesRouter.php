<?php

require_once dirname(__DIR__, 2) . "/src/controllers/ClientesController.php";
require_once dirname(__DIR__) . "/helper/validarDados.php";

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$clientesPage = "../../public/atendente/clientes.php";
$rota = $_GET["rota"] ?? "";

$metodosPermitidos = [
    "cliente/buscarClientes" => "GET",
    "cliente/buscarCliente" => "GET",
    "cliente/cadastrar" => "POST",
    "cliente/atualizar" => "POST",
    "cliente/deletar" => "POST"
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
    case "cliente/buscarClientes":
        rota_buscarClientes();
        break;

    case "cliente/buscarCliente":
        rota_buscarCliente();
        break;

    case "cliente/cadastrar":
        rota_cadastrarCliente();
        break;

    case "cliente/atualizar":
        rota_atualizarCliente();
        break;

    case "cliente/deletar":
        rota_deletarCliente();
        break;
}

function rota_cadastrarCliente(): void
{
    global $clientesPage;

    $campos = [
        "nome",
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

    validador($campos, $_POST, $clientesPage);

    try {
        cadastrarCliente($_POST);
        $_SESSION["flash"] = [
            "tipo" => "sucesso",
            "mensagem" => "Cliente cadastrado com sucesso."
        ];
    } catch (PDOException $e) {
        error_log($e->getMessage());
        $_SESSION["flash"] = [
            "tipo" => "erro",
            "mensagem" => "Não foi possível cadastrar o cliente."
        ];
    }

    header("Location: $clientesPage");
    exit;
}

function rota_atualizarCliente(): void
{
    global $clientesPage;

    validador(["cpf_atual"], $_POST, $clientesPage);

    try {
        atualizarCliente($_POST);
        $_SESSION["flash"] = [
            "tipo" => "sucesso",
            "mensagem" => "Cliente atualizado com sucesso."
        ];
    } catch (PDOException $e) {
        error_log($e->getMessage());
        $_SESSION["flash"] = [
            "tipo" => "erro",
            "mensagem" => "Não foi possível atualizar o cliente."
        ];
    }

    header("Location: $clientesPage");
    exit;
}

function rota_buscarClientes(): void
{
    header("Content-Type: application/json; charset=utf-8");

    try {
        echo json_encode(buscarClientes(), JSON_UNESCAPED_UNICODE);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        http_response_code(500);
        echo json_encode(["erro" => "Não foi possível buscar os clientes."], JSON_UNESCAPED_UNICODE);
    }

    exit;
}

function rota_buscarCliente(): void
{
    header("Content-Type: application/json; charset=utf-8");

    $cpf = $_GET["cpf"] ?? "";

    if ($cpf === "") {
        http_response_code(400);
        echo json_encode(["erro" => "CPF não informado."], JSON_UNESCAPED_UNICODE);
        exit;
    }

    try {
        $cliente = buscarCliente($cpf);

        if ($cliente === false) {
            http_response_code(404);
            echo json_encode(["erro" => "Cliente não encontrado."], JSON_UNESCAPED_UNICODE);
            exit;
        }

        echo json_encode($cliente, JSON_UNESCAPED_UNICODE);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        http_response_code(500);
        echo json_encode(["erro" => "Não foi possível buscar o cliente."], JSON_UNESCAPED_UNICODE);
    }

    exit;
}

function rota_deletarCliente(): void
{
    header("Content-Type: application/json; charset=utf-8");

    $cpf = $_POST["cpf"] ?? "";

    if ($cpf === "") {
        http_response_code(400);
        echo json_encode(["erro" => "CPF não informado."], JSON_UNESCAPED_UNICODE);
        exit;
    }

    try {
        if (!deletarCliente($cpf)) {
            http_response_code(404);
            echo json_encode(["erro" => "Cliente não encontrado."], JSON_UNESCAPED_UNICODE);
            exit;
        }

        echo json_encode(["mensagem" => "Cliente excluído com sucesso."], JSON_UNESCAPED_UNICODE);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        http_response_code(500);
        echo json_encode(["erro" => "Não foi possível excluir o cliente."], JSON_UNESCAPED_UNICODE);
    }

    exit;
}
