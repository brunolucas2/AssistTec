<?php

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
        case "atualizar":
            // Chame aqui a função de atualização
            break;

        default:
            http_response_code(404);
            exit("Ação não encontrada!");
    }
} else {
    http_response_code(404);
    exit("Endpoint não encontrado");
}

include dirname(__DIR__, 2) . "/src/controllers/ClientesController.php";

function rota_cadastrarCliente(): void
{
    include dirname(__DIR__) . "/helper/validarDados.php";

    $campos = [
        "nome",
        "cpf",
        "email",
        "logradouro",
        "numero",
        "bairro",
        "cidade",
        "estado",
        "cep"
    ];

    if (!validador($campos, $_POST)) {
        $_SESSION["flash"] = [
            "tipo" => "erro",
            "texto" => "Preencha todos os campos obrigatórios."
        ];

        header("Location: atendente/clientes.php");
        exit;
    }

    try {
        cadastrarCliente($_POST);

        $_SESSION["flash"] = [
            "tipo" => "sucesso",
            "texto" => "Cliente cadastrado com sucesso."
        ];
    } catch (PDOException $e) {
        error_log($e->getMessage());

        $_SESSION["flash"] = [
            "tipo" => "erro",
            "texto" => "Não foi possível cadastrar o cliente."
        ];
    }

    header("Location: atendente/clientes.php");
    exit;
}