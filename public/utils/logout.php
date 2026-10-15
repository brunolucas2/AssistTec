<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    setcookie("access_token", "", [
        "expires" => time() - 3600,
        "path" => "/",
        "secure" => true,
        "httponly" => true,
        "samesite" => "Strict"
    ]);

    $_SESSION = [];

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();

        setcookie(session_name(), "", [
            "expires" => time() - 3600,
            "path" => $params["path"],
            "domain" => $params["domain"],
            "secure" => $params["secure"],
            "httponly" => $params["httponly"],
            "samesite" => $params["samesite"] ?? "Lax"
        ]);
    }

    session_destroy();

    header("Location: ../login.php");
    exit;
}