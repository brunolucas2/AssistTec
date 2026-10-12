<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") { {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $_SESSION = [];
        session_destroy();

        header("Location: ../login.php");
        exit;
    }
}