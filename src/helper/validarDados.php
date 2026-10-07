<?php

function validador(array $campos, array $dados, string $destino): void
{
    foreach ($campos as $campo) {
        if (
            !isset($dados[$campo]) ||
            !is_string($dados[$campo]) ||
            trim($dados[$campo]) === ""
        ) {
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }

            $_SESSION["flash"] = [
                "tipo" => "erro",
                "texto" => "Preencha todos os campos obrigatórios."
            ];

            header("Location: " . $destino);
            exit;
        }
    }
}