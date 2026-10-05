<?php

$SQL = [
    "auth" => "
    SELECT senha, nivel FROM usuarios
    where login = :email
    "
];