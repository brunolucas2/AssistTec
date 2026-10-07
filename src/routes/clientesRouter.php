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

function rota_deletarCliente(): void {}
