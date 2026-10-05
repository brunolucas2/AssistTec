<?php
// Ler as configurações do banco de dados do arquivo .env
$envPath = dirname(__DIR__, 2) . '/.env';
$env = parse_ini_file($envPath);

if ($env === false) {
    die("Não foi possível carregar o arquivo .env: " . $envPath);
}

// Salvar as configurações em variáveis
$host = $env['DB_HOST'];
$user = $env['DB_USER'];
$port = $env['DB_PORT'];
$database = $env['DB_NAME'];
$password = $env['DB_PASSWORD'];;
$charset = "utf8mb4";

// Url de conexão com o banco de dados

$connUrl = "mysql:host=$host;dbname=$database;charset=$charset";

// Criar objeto de conexão com o banco de dados

try {
    $pdo = new PDO(
        $connUrl,
        $user,
        $password
    );

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );
} catch (PDOException $e) {
    die("Erro ao conectar!" . $e->getMessage());
}
