<?php

$authSQL = [
    "auth" => "
        SELECT senha, nivel FROM usuarios
        WHERE login = :email
    "
];

$clienteSQL = [
    "cadastrarCliente" => "
        INSERT INTO clientes (
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

    "atualizarCliente" => "
        UPDATE clientes
        SET
            nome = COALESCE(NULLIF(:nome, ''), nome),
            email = COALESCE(NULLIF(:email, ''), email),
            telefone = COALESCE(NULLIF(:telefone, ''), telefone),
            logradouro = COALESCE(NULLIF(:logradouro, ''), logradouro),
            numero = COALESCE(NULLIF(:numero, ''), numero),
            bairro = COALESCE(NULLIF(:bairro, ''), bairro),
            cidade = COALESCE(NULLIF(:cidade, ''), cidade),
            estado = COALESCE(NULLIF(:estado, ''), estado),
            cep = COALESCE(NULLIF(:cep, ''), cep)
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
        FROM clientes
    ",

    "buscarCliente" => "
        SELECT
            id_cliente,
            nome,
            cpf,
            email,
            telefone,
            logradouro,
            numero,
            bairro,
            cidade,
            estado,
            cep,
            data_de_cadastro,
            status
        FROM clientes
        WHERE cpf = :cpf
    ",

    "deletarCliente" => "
        DELETE FROM clientes
        WHERE cpf = :cpf
    "
];


$equipamentoSQL = [
    "cadastrarEquipamento" => "
        INSERT INTO equipamentos (
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
            :numero_de_serie,
            :patrimonio,
            :descricao,
            :sistema_operacional,
            :senha_de_acesso
        )
    ",

    "atualizarEquipamento" => "
        UPDATE equipamentos
        SET
            tipo = COALESCE(NULLIF(:tipo, ''), tipo),
            marca = COALESCE(NULLIF(:marca, ''), marca),
            numero_de_serie = COALESCE(NULLIF(:numero_de_serie, ''), numero_de_serie),
            patrimonio = COALESCE(NULLIF(:patrimonio, ''), patrimonio),
            descricao = COALESCE(NULLIF(:descricao, ''), descricao),
            sistema_operacional = COALESCE(NULLIF(:sistema_operacional, ''), sistema_operacional),
            senha_de_acesso = COALESCE(NULLIF(:senha_de_acesso, ''), senha_de_acesso)
        WHERE id_equipamento = :id_equipamento
    ",

    "buscarEquipamentos" => "
        SELECT
            e.id_equipamento,
            e.id_cliente,
            c.nome AS cliente,
            e.tipo,
            e.marca,
            e.numero_de_serie,
            e.patrimonio
        FROM equipamentos e
        INNER JOIN clientes c ON c.id_cliente = e.id_cliente
    ",

    "buscarEquipamento" => "
        SELECT
            e.id_equipamento,
            e.id_cliente,
            c.nome AS cliente,
            e.tipo,
            e.marca,
            e.numero_de_serie,
            e.patrimonio,
            e.descricao,
            e.sistema_operacional
        FROM equipamentos e
        INNER JOIN clientes c ON c.id_cliente = e.id_cliente
        WHERE e.id_equipamento = :id_equipamento
    ",

    "deletarEquipamento" => "
        DELETE FROM equipamentos
        WHERE id_equipamento = :id_equipamento
    "
];

$colaboradorSQL = [
    "cadastrarColaborador" => "
            INSERT INTO colaboradores
            (
                nome,
                cargo,
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
                :cargo,
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
    "atualizarColaborador" => "
    UPDATE colaboradores
    SET
        nome = COALESCE(NULLIF(:nome, ''), nome),
        cargo = COALESCE(NULLIF(:cargo, ''), cargo),
        cpf = COALESCE(NULLIF(:cpf, ''), cpf),
        email = COALESCE(NULLIF(:email, ''), email),
        telefone = COALESCE(NULLIF(:telefone, ''), telefone),
        logradouro = COALESCE(NULLIF(:logradouro, ''), logradouro),
        numero = COALESCE(NULLIF(:numero, ''), numero),
        bairro = COALESCE(NULLIF(:bairro, ''), bairro),
        cidade = COALESCE(NULLIF(:cidade, ''), cidade),
        estado = COALESCE(NULLIF(:estado, ''), estado),
        cep = COALESCE(NULLIF(:cep, ''), cep)
    WHERE id_colaborador = :id_colaborador
",

    "buscarColaboradores" => "
        SELECT
            id_colaborador,
            nome,
            cargo,
            cpf,
            email,
            telefone
        FROM colaboradores
",

    "buscarColaborador" => "
        SELECT
            id_colaborador,
            nome,
            cargo,
            cpf,
            email,
            telefone,
            telefone_secundario,
            logradouro,
            numero,
            bairro,
            cidade,
            estado,
            cep,
            data_de_cadastro
        FROM colaboradores
        WHERE id_colaborador = :id_colaborador
",

    "deletarColaborador" => "
        DELETE FROM colaboradores
        WHERE id_colaborador = :id_colaborador
    "
];

$ordemSQL = [
    "buscarOrdens" => "
        SELECT
            os.id_ordem,
            os.numero_da_os,
            c.nome AS nome_cliente,
            e.tipo AS tipo_equipamento,
            e.marca AS marca_equipamento,
            e.numero_de_serie,
            col.nome AS nome_tecnico,
            os.data_de_abertura,
            os.data_de_previsao,
            os.prioridade,
            os.status
        FROM ordens_de_servico os
        INNER JOIN clientes c
            ON c.id_cliente = os.id_cliente
        INNER JOIN equipamentos e
            ON e.id_equipamento = os.id_equipamento
        INNER JOIN colaboradores col
            ON col.id_colaborador = os.id_tecnico
        ORDER BY os.data_de_abertura DESC
    ",

    "buscarOrdem" => "
        SELECT
            os.id_ordem,
            os.id_cliente,
            os.id_equipamento,
            os.id_tecnico,
            os.numero_da_os,
            os.data_de_abertura,
            os.data_de_previsao,
            os.problema_relatado,
            os.diagnostico,
            os.servico,
            os.prioridade,
            os.valor_estimado,
            os.valor_final,
            os.forma_de_pagamento,
            os.status,
            os.observacoes,
            c.nome AS nome_cliente,
            e.tipo AS tipo_equipamento,
            e.marca AS marca_equipamento,
            e.numero_de_serie,
            e.patrimonio,
            col.nome AS nome_tecnico
        FROM ordens_de_servico os
        INNER JOIN clientes c
            ON c.id_cliente = os.id_cliente
        INNER JOIN equipamentos e
            ON e.id_equipamento = os.id_equipamento
        INNER JOIN colaboradores col
            ON col.id_colaborador = os.id_tecnico
        WHERE os.id_ordem = :id_ordem
    ",

    "cadastrarOrdem" => "
        INSERT INTO ordens_de_servico (
            id_cliente,
            id_equipamento,
            id_tecnico,
            numero_da_os,
            data_de_previsao,
            problema_relatado,
            prioridade,
            valor_estimado,
            observacoes
        ) VALUES (
            :id_cliente,
            :id_equipamento,
            :id_tecnico,
            :numero_da_os,
            :data_de_previsao,
            :problema_relatado,
            :prioridade,
            :valor_estimado,
            :observacoes
        )
    ",

    "atualizarOrdem" => "
        UPDATE ordens_de_servico
        SET
            data_de_previsao = :data_de_previsao,
            diagnostico = :diagnostico,
            servico = :servico,
            prioridade = :prioridade,
            valor_estimado = :valor_estimado,
            valor_final = :valor_final,
            forma_de_pagamento = :forma_de_pagamento,
            status = :status,
            observacoes = :observacoes
        WHERE id_ordem = :id_ordem
    ",

    "cancelarOrdem" => "
        UPDATE ordens_de_servico
        SET status = 'cancelada'
        WHERE id_ordem = :id_ordem
    "
];