<?php
require_once dirname(__DIR__, 2) . "/src/controllers/ClientesController.php";
require_once dirname(__DIR__) . "/helper/validarDados.php";

$clientesPage = "../../public/atendente/clientes.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Método não permitido");
}

$rota = $_GET["rota"] ?? "";
$partes = explode("/", $rota, 2);

$endpoint = $partes[0] ?? "";
$acao = $partes[1] ?? "";

if ($endpoint === "cliente") {
    switch ($acao) {
        case "buscarClientes":
            rota_buscarClientes();
            break;
        case "buscarCliente":
            rota_buscarCliente();
            break;
        case "cadastrar":
            rota_cadastrarCliente();
            break;
        case "atualizar":
            rota_atualizarCliente();
            break;
        case "deletar":
            rota_deletarCliente();
            break;
        default:
            http_response_code(404);
            exit("Ação não encontrada!");
    }
} else {
    http_response_code(404);
    exit("Endpoint não encontrado");
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

        http_response_code(500);
        exit("Erro ao cadastrar: " . $e->getMessage());
    }

    header("Location: $clientesPage");
    exit;
}

function rota_atualizarCliente(): void
{
    global $clientesPage;

    $campos = [
        "cpf"
    ];

    validador($campos, $_POST, $clientesPage);

    try {
        atualizarCliente($_POST);

        $_SESSION["flash"] = [
            "tipo" => "sucesso",
            "mensagem" => "Cliente atualizado com sucesso"
        ];
    } catch (PDOException $e) {
        $_SESSION["flash"] = [
            "tipo" => "erro",
            "mensagem" => "Não foi possível atualizar o cliente."
        ];

        http_response_code(500);
        exit("Erro ao cadastrar: " . $e->getMessage());
    }

    header("Location: $clientesPage");
    exit;
}

function rota_buscarClientes(): void
{
    header('Content-Type: application/json; charset=utf-8');

    try {
        $clientes = buscarClientes();

        echo json_encode($clientes, JSON_UNESCAPED_UNICODE);
        exit;
    } catch (PDOException $e) {
        http_response_code(500);

        echo json_encode([
            'erro' => 'Não foi possível buscar os clientes!'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
}

function rota_buscarCliente(): void
{
    header('Content-Type: application/json; charset=utf-8');

    $cpf = $_POST['cpf'] ?? '';

    if ($cpf === '') {
        http_response_code(400);
        echo json_encode(['erro' => 'CPF não informado.']);
        return;
    }

    try {
        $cliente = buscarCliente($_POST["cpf"]);

        echo json_encode($cliente, JSON_UNESCAPED_UNICODE);
        exit;
    } catch (PDOException $e) {
        http_response_code(500);

        echo json_encode([
            'erro' => 'Não foi possível buscar os clientes!'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
}


function rota_deletarCliente(): void
{
    header('Content-Type: application/json; charset=utf-8');

    $cpf = $_POST['cpf'] ?? '';

    if ($cpf === '') {
        http_response_code(400);
        echo json_encode(['erro' => 'CPF não informado.']);
        return;
    }

    try {
        if (deletarCliente($cpf)) {
            echo json_encode(['mensagem' => 'Cliente excluído com sucesso.']);
            return;
        }

        http_response_code(404);
        echo json_encode(['erro' => 'Cliente não encontrado.']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['erro' => 'Não foi possível excluir o cliente.']);
    }
}