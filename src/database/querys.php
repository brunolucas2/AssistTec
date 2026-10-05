<?php

$authSQL = [
    "auth" => "
        SELECT senha, nivel FROM usuarios
        WHERE login = :email
    "
];

$atendenteSQL = [
    "cadastrarCliente" => "
        INSERT INTO clientes 
        (
            nome,
            cpf,
            email,
            logradouro,
            numero,
            bairro,
            cidade,
            estado,
            cep
        ) VALUES (
            :nome,
            :cpf,
            :email,
            :logradouro,
            :numero,
            :bairro,
            :cidade,
            :estado,
            :cep
        )
    ",
    "cadastrarEquipamento" => "
        INSERT INTO equipamentos
        (
            id_cliente,
            tipo,
            marca,
            numero_de_serie,
            patrimonio,
            descricao,
            sistema_operacional,
            senha_de_acesso
        ) VALUES (
            :id_cliente,
            :tipo,
            :marca,
            :patrimonio,
            :sistema_operacional,
            :senha_de_acesso
        )
    "
];
