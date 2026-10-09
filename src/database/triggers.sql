DELIMITER //

CREATE TRIGGER registrar_ordens_concluidas
AFTER UPDATE ON ordens_de_servico
FOR EACH ROW
BEGIN
    IF NEW.status = 'concluida'
        AND NOT (OLD.status <=> 'concluida') THEN

        INSERT INTO log_ordens_de_servico (
            id_ordem,
            id_cliente,
            id_equipamento,
            id_tecnico,
            numero_da_os,
            data_de_abertura,
            data_de_previsao,
            problema_relatado,
            diagnostico,
            servico,
            prioridade,
            valor_estimado,
            valor_final,
            forma_de_pagamento,
            status,
            observacoes
        )
        VALUES (
            NEW.id_ordem,
            NEW.id_cliente,
            NEW.id_equipamento,
            NEW.id_tecnico,
            NEW.numero_da_os,
            NEW.data_de_abertura,
            NEW.data_de_previsao,
            NEW.problema_relatado,
            NEW.diagnostico,
            NEW.servico,
            NEW.prioridade,
            NEW.valor_estimado,
            NEW.valor_final,
            NEW.forma_de_pagamento,
            NEW.status,
            NEW.observacoes
        );
    END IF;
END//

DELIMITER ;