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
            id_cliente, 
            nome,
            cpf,
            email,
            telefone,
            status
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


$equipamentoSQL = [
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
            )
            VALUES (
                :id_cliente,
                :tipo,
                :marca,
                :numero_de_serie,
                :patrimonio,
                :descricao,
                :sistema_operacional,
                :senha_de_acesso
            );
    ",
    "atualizarEquipamento" => "
        UPDATE equipamentos
        SET
            tipo = COALESCE(:tipo, tipo),
            marca = COALESCE(:marca, marca),
            numero_de_serie = COALESCE(:numero_de_serie, numero_de_serie),
            patrimonio = COALESCE(:patrimonio, patrimonio),
            descricao = COALESCE(:descricao, descricao),
            sistema_operacional = COALESCE(:sistema_operacional, sistema_operacional),
            senha_de_acesso = COALESCE(:senha_de_acesso, senha_de_acesso)
        WHERE id_equipamento = :id_equipamento;
    ",
    "buscarEquipamentos" => "
        SELECT
            id_equipamento,
            id_cliente,
            tipo,
            marca,
            numero_de_serie,
            patrimonio,
            descricao,
            sistema_operacional,
            senha_de_acesso
        FROM equipamentos;
    ",
    "buscarEquipamenmto" => "
        SELECT
            id_equipamento,
            id_cliente,
            tipo,
            marca,
            numero_de_serie,
            patrimonio,
            descricao,
            sistema_operacional,
            senha_de_acesso
        FROM equipamentos
        WHERE id_equipamento = :id_equipamento;
    ",
    "deletarEquipamento" => "
        DELETE FROM equipamentos
        WHERE id = :numero_de_serie
    "
];