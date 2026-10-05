<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$mensagem = $_SESSION["flash"] ?? null;
unset($_SESSION["flash"]);
?>

<?php if ($mensagem !== null): ?>
    <p class="<?= $mensagem["tipo"] === "sucesso" ? "sucesso" : "erro" ?>">
        <?= htmlspecialchars($mensagem["texto"], ENT_QUOTES, "UTF-8") ?>
    </p>
<?php endif; ?>