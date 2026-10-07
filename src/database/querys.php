<?php

$authSQL = [
    "auth" => "
        SELECT senha, nivel FROM usuarios
        WHERE login = :email
    "
];

$clienteSQL = [
    "cadastrarCliente" => "
        INSERT INTO clientes 
        (
            nome,
            cpf,
            email,
            telefone,
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
            :telefone,
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
    ",
    "atualizarCliente" => "
        UPDATE clientes
        SET
            nome = COALESCE(:nome, nome),
            email = COALESCE(:email, email),
            telefone = COALESCE(:telefone, telefone),
            logradouro = COALESCE(:logradouro, logradouro),
            numero = COALESCE(:numero, numero),
            bairro = COALESCE(:bairro, bairro),
            cidade = COALESCE(:cidade, cidade),
            estado = COALESCE(:estado, estado),
            cep = COALESCE(:cep, cep)
        WHERE cpf = :cpf_atual
    ",
    "buscarClientes" => "
        SELECT 
            nome,
            cpf,
            email,
            telefone,
            logradouro,
            numero,
            bairro,
            cidade,
            estado,
            cep
        FROM clientes;
    ",
    "buscarCliente" => "
        SELECT 
            nome,
            cpf,
            email,
            telefone,
            logradouro,
            numero,
            bairro,
            cidade,
            estado,
            cep
        FROM clientes
        WHERE cpf = :cpf;
    ",
    "deletarCliente" => "
        DELETE FROM clientes
        where cpf = :cpf;
    "
];
