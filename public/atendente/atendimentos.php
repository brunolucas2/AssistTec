<?php
session_start();

$nivelDaPagina = "atendente";
require_once dirname(__DIR__) . "/utils/verificarNivel.php";

verificarNivel($nivelDaPagina);

$mensagem = $_SESSION["flash"] ?? null;
unset($_SESSION["flash"]);
?>