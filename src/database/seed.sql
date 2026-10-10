-- Seed fictício para banco existente (sem apagar registros).
-- Senha das contas: Teste@123.
-- Os dados são identificados pelo email e pelo número de série reservado ASSISTEC-SN-XXXX.
USE web_system_assistencia_tecnica;

START TRANSACTION;

INSERT INTO clientes (nome, cpf, email, telefone, logradouro, numero, bairro, cidade, estado, cep)
SELECT 'Ana Martins', '00000000001', 'cliente01@example.com', '11990000001', 'Rua Exemplo 1', '11', 'Centro', 'São Paulo', 'SP', '01000001'
WHERE NOT EXISTS (SELECT 1 FROM clientes WHERE email = 'cliente01@example.com');

INSERT INTO clientes (nome, cpf, email, telefone, logradouro, numero, bairro, cidade, estado, cep)
SELECT 'Bruno Almeida', '00000000002', 'cliente02@example.com', '11990000002', 'Rua Exemplo 2', '12', 'Centro', 'São Paulo', 'SP', '01000002'
WHERE NOT EXISTS (SELECT 1 FROM clientes WHERE email = 'cliente02@example.com');

INSERT INTO clientes (nome, cpf, email, telefone, logradouro, numero, bairro, cidade, estado, cep)
SELECT 'Carla Ferreira', '00000000003', 'cliente03@example.com', '11990000003', 'Rua Exemplo 3', '13', 'Centro', 'São Paulo', 'SP', '01000003'
WHERE NOT EXISTS (SELECT 1 FROM clientes WHERE email = 'cliente03@example.com');

INSERT INTO clientes (nome, cpf, email, telefone, logradouro, numero, bairro, cidade, estado, cep)
SELECT 'Diego Oliveira', '00000000004', 'cliente04@example.com', '11990000004', 'Rua Exemplo 4', '14', 'Centro', 'São Paulo', 'SP', '01000004'
WHERE NOT EXISTS (SELECT 1 FROM clientes WHERE email = 'cliente04@example.com');

INSERT INTO clientes (nome, cpf, email, telefone, logradouro, numero, bairro, cidade, estado, cep)
SELECT 'Elisa Costa', '00000000005', 'cliente05@example.com', '11990000005', 'Rua Exemplo 5', '15', 'Centro', 'São Paulo', 'SP', '01000005'
WHERE NOT EXISTS (SELECT 1 FROM clientes WHERE email = 'cliente05@example.com');

INSERT INTO clientes (nome, cpf, email, telefone, logradouro, numero, bairro, cidade, estado, cep)
SELECT 'Felipe Ribeiro', '00000000006', 'cliente06@example.com', '11990000006', 'Rua Exemplo 6', '16', 'Centro', 'São Paulo', 'SP', '01000006'
WHERE NOT EXISTS (SELECT 1 FROM clientes WHERE email = 'cliente06@example.com');

INSERT INTO clientes (nome, cpf, email, telefone, logradouro, numero, bairro, cidade, estado, cep)
SELECT 'Gabriela Lima', '00000000007', 'cliente07@example.com', '11990000007', 'Rua Exemplo 7', '17', 'Centro', 'São Paulo', 'SP', '01000007'
WHERE NOT EXISTS (SELECT 1 FROM clientes WHERE email = 'cliente07@example.com');

INSERT INTO clientes (nome, cpf, email, telefone, logradouro, numero, bairro, cidade, estado, cep)
SELECT 'Henrique Sousa', '00000000008', 'cliente08@example.com', '11990000008', 'Rua Exemplo 8', '18', 'Centro', 'São Paulo', 'SP', '01000008'
WHERE NOT EXISTS (SELECT 1 FROM clientes WHERE email = 'cliente08@example.com');

INSERT INTO clientes (nome, cpf, email, telefone, logradouro, numero, bairro, cidade, estado, cep)
SELECT 'Isabela Rocha', '00000000009', 'cliente09@example.com', '11990000009', 'Rua Exemplo 9', '19', 'Centro', 'São Paulo', 'SP', '01000009'
WHERE NOT EXISTS (SELECT 1 FROM clientes WHERE email = 'cliente09@example.com');

INSERT INTO clientes (nome, cpf, email, telefone, logradouro, numero, bairro, cidade, estado, cep)
SELECT 'João Pereira', '00000000010', 'cliente10@example.com', '11990000010', 'Rua Exemplo 10', '20', 'Centro', 'São Paulo', 'SP', '01000010'
WHERE NOT EXISTS (SELECT 1 FROM clientes WHERE email = 'cliente10@example.com');

INSERT INTO clientes (nome, cpf, email, telefone, logradouro, numero, bairro, cidade, estado, cep)
SELECT 'Larissa Gomes', '00000000011', 'cliente11@example.com', '11990000011', 'Rua Exemplo 11', '21', 'Centro', 'São Paulo', 'SP', '01000011'
WHERE NOT EXISTS (SELECT 1 FROM clientes WHERE email = 'cliente11@example.com');

INSERT INTO clientes (nome, cpf, email, telefone, logradouro, numero, bairro, cidade, estado, cep)
SELECT 'Marcos Santos', '00000000012', 'cliente12@example.com', '11990000012', 'Rua Exemplo 12', '22', 'Centro', 'São Paulo', 'SP', '01000012'
WHERE NOT EXISTS (SELECT 1 FROM clientes WHERE email = 'cliente12@example.com');

INSERT INTO clientes (nome, cpf, email, telefone, logradouro, numero, bairro, cidade, estado, cep)
SELECT 'Nina Barros', '00000000013', 'cliente13@example.com', '11990000013', 'Rua Exemplo 13', '23', 'Centro', 'São Paulo', 'SP', '01000013'
WHERE NOT EXISTS (SELECT 1 FROM clientes WHERE email = 'cliente13@example.com');

INSERT INTO clientes (nome, cpf, email, telefone, logradouro, numero, bairro, cidade, estado, cep)
SELECT 'Otávio Nunes', '00000000014', 'cliente14@example.com', '11990000014', 'Rua Exemplo 14', '24', 'Centro', 'São Paulo', 'SP', '01000014'
WHERE NOT EXISTS (SELECT 1 FROM clientes WHERE email = 'cliente14@example.com');

INSERT INTO clientes (nome, cpf, email, telefone, logradouro, numero, bairro, cidade, estado, cep)
SELECT 'Paula Melo', '00000000015', 'cliente15@example.com', '11990000015', 'Rua Exemplo 15', '25', 'Centro', 'São Paulo', 'SP', '01000015'
WHERE NOT EXISTS (SELECT 1 FROM clientes WHERE email = 'cliente15@example.com');

INSERT INTO colaboradores (nome, cargo, cpf, email, telefone, logradouro, numero, bairro, cidade, estado, cep)
SELECT 'Amanda Azevedo', 'Administrador', '00000010001', 'colaborador01@example.com', '11980000001', 'Avenida Exemplo 1', '101', 'Centro', 'São Paulo', 'SP', '02000001'
WHERE NOT EXISTS (SELECT 1 FROM colaboradores WHERE email = 'colaborador01@example.com');

INSERT INTO colaboradores (nome, cargo, cpf, email, telefone, logradouro, numero, bairro, cidade, estado, cep)
SELECT 'Bernardo Farias', 'Administrador', '00000010002', 'colaborador02@example.com', '11980000002', 'Avenida Exemplo 2', '102', 'Centro', 'São Paulo', 'SP', '02000002'
WHERE NOT EXISTS (SELECT 1 FROM colaboradores WHERE email = 'colaborador02@example.com');

INSERT INTO colaboradores (nome, cargo, cpf, email, telefone, logradouro, numero, bairro, cidade, estado, cep)
SELECT 'Camila Teixeira', 'Atendente', '00000010003', 'colaborador03@example.com', '11980000003', 'Avenida Exemplo 3', '103', 'Centro', 'São Paulo', 'SP', '02000003'
WHERE NOT EXISTS (SELECT 1 FROM colaboradores WHERE email = 'colaborador03@example.com');

INSERT INTO colaboradores (nome, cargo, cpf, email, telefone, logradouro, numero, bairro, cidade, estado, cep)
SELECT 'Daniel Batista', 'Atendente', '00000010004', 'colaborador04@example.com', '11980000004', 'Avenida Exemplo 4', '104', 'Centro', 'São Paulo', 'SP', '02000004'
WHERE NOT EXISTS (SELECT 1 FROM colaboradores WHERE email = 'colaborador04@example.com');

INSERT INTO colaboradores (nome, cargo, cpf, email, telefone, logradouro, numero, bairro, cidade, estado, cep)
SELECT 'Eduarda Correia', 'Atendente', '00000010005', 'colaborador05@example.com', '11980000005', 'Avenida Exemplo 5', '105', 'Centro', 'São Paulo', 'SP', '02000005'
WHERE NOT EXISTS (SELECT 1 FROM colaboradores WHERE email = 'colaborador05@example.com');

INSERT INTO colaboradores (nome, cargo, cpf, email, telefone, logradouro, numero, bairro, cidade, estado, cep)
SELECT 'Fernando Dias', 'Atendente', '00000010006', 'colaborador06@example.com', '11980000006', 'Avenida Exemplo 6', '106', 'Centro', 'São Paulo', 'SP', '02000006'
WHERE NOT EXISTS (SELECT 1 FROM colaboradores WHERE email = 'colaborador06@example.com');

INSERT INTO colaboradores (nome, cargo, cpf, email, telefone, logradouro, numero, bairro, cidade, estado, cep)
SELECT 'Giovana Cardoso', 'Técnico', '00000010007', 'colaborador07@example.com', '11980000007', 'Avenida Exemplo 7', '107', 'Centro', 'São Paulo', 'SP', '02000007'
WHERE NOT EXISTS (SELECT 1 FROM colaboradores WHERE email = 'colaborador07@example.com');

INSERT INTO colaboradores (nome, cargo, cpf, email, telefone, logradouro, numero, bairro, cidade, estado, cep)
SELECT 'Heitor Mendes', 'Técnico', '00000010008', 'colaborador08@example.com', '11980000008', 'Avenida Exemplo 8', '108', 'Centro', 'São Paulo', 'SP', '02000008'
WHERE NOT EXISTS (SELECT 1 FROM colaboradores WHERE email = 'colaborador08@example.com');

INSERT INTO colaboradores (nome, cargo, cpf, email, telefone, logradouro, numero, bairro, cidade, estado, cep)
SELECT 'Íris Carvalho', 'Técnico', '00000010009', 'colaborador09@example.com', '11980000009', 'Avenida Exemplo 9', '109', 'Centro', 'São Paulo', 'SP', '02000009'
WHERE NOT EXISTS (SELECT 1 FROM colaboradores WHERE email = 'colaborador09@example.com');

INSERT INTO colaboradores (nome, cargo, cpf, email, telefone, logradouro, numero, bairro, cidade, estado, cep)
SELECT 'Júlia Freitas', 'Técnico', '00000010010', 'colaborador10@example.com', '11980000010', 'Avenida Exemplo 10', '110', 'Centro', 'São Paulo', 'SP', '02000010'
WHERE NOT EXISTS (SELECT 1 FROM colaboradores WHERE email = 'colaborador10@example.com');

INSERT INTO colaboradores (nome, cargo, cpf, email, telefone, logradouro, numero, bairro, cidade, estado, cep)
SELECT 'Kaique Moreira', 'Técnico', '00000010011', 'colaborador11@example.com', '11980000011', 'Avenida Exemplo 11', '111', 'Centro', 'São Paulo', 'SP', '02000011'
WHERE NOT EXISTS (SELECT 1 FROM colaboradores WHERE email = 'colaborador11@example.com');

INSERT INTO colaboradores (nome, cargo, cpf, email, telefone, logradouro, numero, bairro, cidade, estado, cep)
SELECT 'Luana Castro', 'Técnico', '00000010012', 'colaborador12@example.com', '11980000012', 'Avenida Exemplo 12', '112', 'Centro', 'São Paulo', 'SP', '02000012'
WHERE NOT EXISTS (SELECT 1 FROM colaboradores WHERE email = 'colaborador12@example.com');

INSERT INTO colaboradores (nome, cargo, cpf, email, telefone, logradouro, numero, bairro, cidade, estado, cep)
SELECT 'Miguel Duarte', 'Técnico', '00000010013', 'colaborador13@example.com', '11980000013', 'Avenida Exemplo 13', '113', 'Centro', 'São Paulo', 'SP', '02000013'
WHERE NOT EXISTS (SELECT 1 FROM colaboradores WHERE email = 'colaborador13@example.com');

INSERT INTO usuarios (id_colaborador, login, senha, nivel, status)
SELECT (SELECT id_colaborador FROM colaboradores WHERE email = 'colaborador01@example.com'), 'colaborador01@example.com', '$2y$12$1mUWTkIu3L6nivCdrzhUpuEH2My9hNMlz7NNGNriIkQyzZqq6vExm', 'administrador', 'ativo'
WHERE NOT EXISTS (SELECT 1 FROM usuarios WHERE login = 'colaborador01@example.com');

INSERT INTO usuarios (id_colaborador, login, senha, nivel, status)
SELECT (SELECT id_colaborador FROM colaboradores WHERE email = 'colaborador02@example.com'), 'colaborador02@example.com', '$2y$12$He/JkqO3wVVN6mAXyY9p0OpC3dtONpYJx0i9gRi0rdOJWQyCbkLCS', 'administrador', 'ativo'
WHERE NOT EXISTS (SELECT 1 FROM usuarios WHERE login = 'colaborador02@example.com');

INSERT INTO usuarios (id_colaborador, login, senha, nivel, status)
SELECT (SELECT id_colaborador FROM colaboradores WHERE email = 'colaborador03@example.com'), 'colaborador03@example.com', '$2y$12$fLCWDv4WhiVhbRXQdh7kEOx4mVXp7QSq./QrUSI2KQKCcT7N5hqVG', 'atendente', 'ativo'
WHERE NOT EXISTS (SELECT 1 FROM usuarios WHERE login = 'colaborador03@example.com');

INSERT INTO usuarios (id_colaborador, login, senha, nivel, status)
SELECT (SELECT id_colaborador FROM colaboradores WHERE email = 'colaborador04@example.com'), 'colaborador04@example.com', '$2y$12$CJwUCZ1pyKVOJ2Zm/yTFSevPNxHON/L95hFpkwkcJt5GK2Zmn.r4.', 'atendente', 'ativo'
WHERE NOT EXISTS (SELECT 1 FROM usuarios WHERE login = 'colaborador04@example.com');

INSERT INTO usuarios (id_colaborador, login, senha, nivel, status)
SELECT (SELECT id_colaborador FROM colaboradores WHERE email = 'colaborador05@example.com'), 'colaborador05@example.com', '$2y$12$lIv4wMVqWzH5T0jDGZ3jseZ27.gfawflByKoLg17/chStJkrORuZW', 'atendente', 'ativo'
WHERE NOT EXISTS (SELECT 1 FROM usuarios WHERE login = 'colaborador05@example.com');

INSERT INTO usuarios (id_colaborador, login, senha, nivel, status)
SELECT (SELECT id_colaborador FROM colaboradores WHERE email = 'colaborador06@example.com'), 'colaborador06@example.com', '$2y$12$78TQwKOkVloK32Nzwy7v.u9P5D.HS7oewVjqA/uLpYPFnv.zoEZMy', 'atendente', 'ativo'
WHERE NOT EXISTS (SELECT 1 FROM usuarios WHERE login = 'colaborador06@example.com');

INSERT INTO usuarios (id_colaborador, login, senha, nivel, status)
SELECT (SELECT id_colaborador FROM colaboradores WHERE email = 'colaborador07@example.com'), 'colaborador07@example.com', '$2y$12$EZEvnpHXE7h9wxsonaG9W.lpiKaorIoN6KcB6.Wp.Urn5q1G.l8jO', 'tecnico', 'ativo'
WHERE NOT EXISTS (SELECT 1 FROM usuarios WHERE login = 'colaborador07@example.com');

INSERT INTO usuarios (id_colaborador, login, senha, nivel, status)
SELECT (SELECT id_colaborador FROM colaboradores WHERE email = 'colaborador08@example.com'), 'colaborador08@example.com', '$2y$12$AeLZlB0TwEnFiw4S0uw.L.w/zh9MAAKl4nPkYfy5ZBfmXfJv4yH2.', 'tecnico', 'ativo'
WHERE NOT EXISTS (SELECT 1 FROM usuarios WHERE login = 'colaborador08@example.com');

INSERT INTO usuarios (id_colaborador, login, senha, nivel, status)
SELECT (SELECT id_colaborador FROM colaboradores WHERE email = 'colaborador09@example.com'), 'colaborador09@example.com', '$2y$12$hjOr4pyAXGbOJHzvJf4qGO/3mrIxU.FnF8SDU.foo7DZn0O/bHGj.', 'tecnico', 'ativo'
WHERE NOT EXISTS (SELECT 1 FROM usuarios WHERE login = 'colaborador09@example.com');

INSERT INTO usuarios (id_colaborador, login, senha, nivel, status)
SELECT (SELECT id_colaborador FROM colaboradores WHERE email = 'colaborador10@example.com'), 'colaborador10@example.com', '$2y$12$UIfHw9EXoWTGwztTIQaSd.A7DkCYxwO6SSoMSz.OWZpvbHOxQ8KAu', 'tecnico', 'ativo'
WHERE NOT EXISTS (SELECT 1 FROM usuarios WHERE login = 'colaborador10@example.com');

INSERT INTO usuarios (id_colaborador, login, senha, nivel, status)
SELECT (SELECT id_colaborador FROM colaboradores WHERE email = 'colaborador11@example.com'), 'colaborador11@example.com', '$2y$12$G6ICIvi.Ef8nHmL8nfq1CO23Ew2B2g5u27wXflxCVTuTLlPsXKXRq', 'tecnico', 'ativo'
WHERE NOT EXISTS (SELECT 1 FROM usuarios WHERE login = 'colaborador11@example.com');

INSERT INTO usuarios (id_colaborador, login, senha, nivel, status)
SELECT (SELECT id_colaborador FROM colaboradores WHERE email = 'colaborador12@example.com'), 'colaborador12@example.com', '$2y$12$WriKSxkLratl8QE6x31eluSEfP2HCiPUWYSS4cMZFThC1PZUQzJeC', 'tecnico', 'ativo'
WHERE NOT EXISTS (SELECT 1 FROM usuarios WHERE login = 'colaborador12@example.com');

INSERT INTO usuarios (id_colaborador, login, senha, nivel, status)
SELECT (SELECT id_colaborador FROM colaboradores WHERE email = 'colaborador13@example.com'), 'colaborador13@example.com', '$2y$12$hKtFkbKOpojEAZIjX02gA.oUyNnHkFYwxhvGuEUbZj.15ArLiQbbK', 'tecnico', 'ativo'
WHERE NOT EXISTS (SELECT 1 FROM usuarios WHERE login = 'colaborador13@example.com');

INSERT INTO equipamentos (id_cliente, tipo, marca, numero_de_serie, patrimonio, descricao, sistema_operacional, senha_de_acesso, status)
SELECT (SELECT id_cliente FROM clientes WHERE email = 'cliente01@example.com'), 'Notebook', 'Dell', 'ASSISTEC-SN-0001', 'Sem patrimônio', 'Inspiron 15 - Não liga', 'Windows 11', 'Não informada', 'ativo'
WHERE NOT EXISTS (SELECT 1 FROM equipamentos WHERE numero_de_serie = 'ASSISTEC-SN-0001');

INSERT INTO equipamentos (id_cliente, tipo, marca, numero_de_serie, patrimonio, descricao, sistema_operacional, senha_de_acesso, status)
SELECT (SELECT id_cliente FROM clientes WHERE email = 'cliente02@example.com'), 'Desktop', 'Lenovo', 'ASSISTEC-SN-0002', 'Sem patrimônio', 'ThinkCentre M70 - Reinicia sozinho', 'Windows 10', 'Não informada', 'ativo'
WHERE NOT EXISTS (SELECT 1 FROM equipamentos WHERE numero_de_serie = 'ASSISTEC-SN-0002');

INSERT INTO equipamentos (id_cliente, tipo, marca, numero_de_serie, patrimonio, descricao, sistema_operacional, senha_de_acesso, status)
SELECT (SELECT id_cliente FROM clientes WHERE email = 'cliente03@example.com'), 'Notebook', 'Acer', 'ASSISTEC-SN-0003', 'Sem patrimônio', 'Aspire 5 - Tela com falhas', 'Windows 11', 'Não informada', 'ativo'
WHERE NOT EXISTS (SELECT 1 FROM equipamentos WHERE numero_de_serie = 'ASSISTEC-SN-0003');

INSERT INTO equipamentos (id_cliente, tipo, marca, numero_de_serie, patrimonio, descricao, sistema_operacional, senha_de_acesso, status)
SELECT (SELECT id_cliente FROM clientes WHERE email = 'cliente04@example.com'), 'Impressora', 'HP', 'ASSISTEC-SN-0004', 'Sem patrimônio', 'LaserJet M404 - Atola papel', 'Firmware interno', 'Não informada', 'ativo'
WHERE NOT EXISTS (SELECT 1 FROM equipamentos WHERE numero_de_serie = 'ASSISTEC-SN-0004');

INSERT INTO equipamentos (id_cliente, tipo, marca, numero_de_serie, patrimonio, descricao, sistema_operacional, senha_de_acesso, status)
SELECT (SELECT id_cliente FROM clientes WHERE email = 'cliente05@example.com'), 'Notebook', 'Samsung', 'ASSISTEC-SN-0005', 'Sem patrimônio', 'Book2 - Bateria não carrega', 'Windows 11', 'Não informada', 'ativo'
WHERE NOT EXISTS (SELECT 1 FROM equipamentos WHERE numero_de_serie = 'ASSISTEC-SN-0005');

INSERT INTO equipamentos (id_cliente, tipo, marca, numero_de_serie, patrimonio, descricao, sistema_operacional, senha_de_acesso, status)
SELECT (SELECT id_cliente FROM clientes WHERE email = 'cliente06@example.com'), 'Desktop', 'Dell', 'ASSISTEC-SN-0006', 'Sem patrimônio', 'OptiPlex 3080 - Lentidão', 'Ubuntu 22.04', 'Não informada', 'ativo'
WHERE NOT EXISTS (SELECT 1 FROM equipamentos WHERE numero_de_serie = 'ASSISTEC-SN-0006');

INSERT INTO equipamentos (id_cliente, tipo, marca, numero_de_serie, patrimonio, descricao, sistema_operacional, senha_de_acesso, status)
SELECT (SELECT id_cliente FROM clientes WHERE email = 'cliente07@example.com'), 'Notebook', 'Lenovo', 'ASSISTEC-SN-0007', 'Sem patrimônio', 'IdeaPad 3 - Teclado falhando', 'Windows 11', 'Não informada', 'ativo'
WHERE NOT EXISTS (SELECT 1 FROM equipamentos WHERE numero_de_serie = 'ASSISTEC-SN-0007');

INSERT INTO equipamentos (id_cliente, tipo, marca, numero_de_serie, patrimonio, descricao, sistema_operacional, senha_de_acesso, status)
SELECT (SELECT id_cliente FROM clientes WHERE email = 'cliente08@example.com'), 'Tablet', 'Samsung', 'ASSISTEC-SN-0008', 'Sem patrimônio', 'Galaxy Tab A8 - Não carrega', 'Android', 'Não informada', 'ativo'
WHERE NOT EXISTS (SELECT 1 FROM equipamentos WHERE numero_de_serie = 'ASSISTEC-SN-0008');

INSERT INTO equipamentos (id_cliente, tipo, marca, numero_de_serie, patrimonio, descricao, sistema_operacional, senha_de_acesso, status)
SELECT (SELECT id_cliente FROM clientes WHERE email = 'cliente09@example.com'), 'Notebook', 'ASUS', 'ASSISTEC-SN-0009', 'Sem patrimônio', 'VivoBook 15 - Wi-Fi não conecta', 'Windows 11', 'Não informada', 'ativo'
WHERE NOT EXISTS (SELECT 1 FROM equipamentos WHERE numero_de_serie = 'ASSISTEC-SN-0009');

INSERT INTO equipamentos (id_cliente, tipo, marca, numero_de_serie, patrimonio, descricao, sistema_operacional, senha_de_acesso, status)
SELECT (SELECT id_cliente FROM clientes WHERE email = 'cliente10@example.com'), 'Desktop', 'Positivo', 'ASSISTEC-SN-0010', 'Sem patrimônio', 'Master D620 - Sem vídeo', 'Windows 10', 'Não informada', 'ativo'
WHERE NOT EXISTS (SELECT 1 FROM equipamentos WHERE numero_de_serie = 'ASSISTEC-SN-0010');

INSERT INTO equipamentos (id_cliente, tipo, marca, numero_de_serie, patrimonio, descricao, sistema_operacional, senha_de_acesso, status)
SELECT (SELECT id_cliente FROM clientes WHERE email = 'cliente11@example.com'), 'Notebook', 'HP', 'ASSISTEC-SN-0011', 'Sem patrimônio', 'Pavilion 14 - Superaquecimento', 'Windows 11', 'Não informada', 'ativo'
WHERE NOT EXISTS (SELECT 1 FROM equipamentos WHERE numero_de_serie = 'ASSISTEC-SN-0011');

INSERT INTO equipamentos (id_cliente, tipo, marca, numero_de_serie, patrimonio, descricao, sistema_operacional, senha_de_acesso, status)
SELECT (SELECT id_cliente FROM clientes WHERE email = 'cliente12@example.com'), 'Impressora', 'Epson', 'ASSISTEC-SN-0012', 'Sem patrimônio', 'EcoTank L3250 - Falha na impressão', 'Firmware interno', 'Não informada', 'ativo'
WHERE NOT EXISTS (SELECT 1 FROM equipamentos WHERE numero_de_serie = 'ASSISTEC-SN-0012');

INSERT INTO equipamentos (id_cliente, tipo, marca, numero_de_serie, patrimonio, descricao, sistema_operacional, senha_de_acesso, status)
SELECT (SELECT id_cliente FROM clientes WHERE email = 'cliente13@example.com'), 'Notebook', 'Dell', 'ASSISTEC-SN-0013', 'Sem patrimônio', 'Latitude 5420 - SSD não reconhecido', 'Windows 11', 'Não informada', 'ativo'
WHERE NOT EXISTS (SELECT 1 FROM equipamentos WHERE numero_de_serie = 'ASSISTEC-SN-0013');

INSERT INTO equipamentos (id_cliente, tipo, marca, numero_de_serie, patrimonio, descricao, sistema_operacional, senha_de_acesso, status)
SELECT (SELECT id_cliente FROM clientes WHERE email = 'cliente14@example.com'), 'Desktop', 'Lenovo', 'ASSISTEC-SN-0014', 'Sem patrimônio', 'ThinkCentre M720 - Ruído no cooler', 'Ubuntu 24.04', 'Não informada', 'ativo'
WHERE NOT EXISTS (SELECT 1 FROM equipamentos WHERE numero_de_serie = 'ASSISTEC-SN-0014');

INSERT INTO equipamentos (id_cliente, tipo, marca, numero_de_serie, patrimonio, descricao, sistema_operacional, senha_de_acesso, status)
SELECT (SELECT id_cliente FROM clientes WHERE email = 'cliente15@example.com'), 'Notebook', 'Acer', 'ASSISTEC-SN-0015', 'Sem patrimônio', 'Nitro 5 - Desliga em jogos', 'Windows 11', 'Não informada', 'ativo'
WHERE NOT EXISTS (SELECT 1 FROM equipamentos WHERE numero_de_serie = 'ASSISTEC-SN-0015');

INSERT INTO equipamentos (id_cliente, tipo, marca, numero_de_serie, patrimonio, descricao, sistema_operacional, senha_de_acesso, status)
SELECT (SELECT id_cliente FROM clientes WHERE email = 'cliente01@example.com'), 'Desktop', 'Dell', 'ASSISTEC-SN-0016', 'Sem patrimônio', 'OptiPlex 5090 - Portas USB falhando', 'Windows 11', 'Não informada', 'ativo'
WHERE NOT EXISTS (SELECT 1 FROM equipamentos WHERE numero_de_serie = 'ASSISTEC-SN-0016');

INSERT INTO equipamentos (id_cliente, tipo, marca, numero_de_serie, patrimonio, descricao, sistema_operacional, senha_de_acesso, status)
SELECT (SELECT id_cliente FROM clientes WHERE email = 'cliente03@example.com'), 'Notebook', 'Lenovo', 'ASSISTEC-SN-0017', 'Sem patrimônio', 'ThinkPad E14 - Tela sem imagem', 'Windows 11', 'Não informada', 'ativo'
WHERE NOT EXISTS (SELECT 1 FROM equipamentos WHERE numero_de_serie = 'ASSISTEC-SN-0017');

INSERT INTO equipamentos (id_cliente, tipo, marca, numero_de_serie, patrimonio, descricao, sistema_operacional, senha_de_acesso, status)
SELECT (SELECT id_cliente FROM clientes WHERE email = 'cliente05@example.com'), 'Impressora', 'Brother', 'ASSISTEC-SN-0018', 'Sem patrimônio', 'DCP-L2540DW - Não puxa papel', 'Firmware interno', 'Não informada', 'ativo'
WHERE NOT EXISTS (SELECT 1 FROM equipamentos WHERE numero_de_serie = 'ASSISTEC-SN-0018');

INSERT INTO equipamentos (id_cliente, tipo, marca, numero_de_serie, patrimonio, descricao, sistema_operacional, senha_de_acesso, status)
SELECT (SELECT id_cliente FROM clientes WHERE email = 'cliente08@example.com'), 'Notebook', 'Samsung', 'ASSISTEC-SN-0019', 'Sem patrimônio', 'Galaxy Book3 - Áudio falhando', 'Windows 11', 'Não informada', 'ativo'
WHERE NOT EXISTS (SELECT 1 FROM equipamentos WHERE numero_de_serie = 'ASSISTEC-SN-0019');

INSERT INTO equipamentos (id_cliente, tipo, marca, numero_de_serie, patrimonio, descricao, sistema_operacional, senha_de_acesso, status)
SELECT (SELECT id_cliente FROM clientes WHERE email = 'cliente12@example.com'), 'Desktop', 'HP', 'ASSISTEC-SN-0020', 'Sem patrimônio', 'ProDesk 400 - Fonte não liga', 'Windows 10', 'Não informada', 'ativo'
WHERE NOT EXISTS (SELECT 1 FROM equipamentos WHERE numero_de_serie = 'ASSISTEC-SN-0020');

INSERT INTO ordens_de_servico (id_cliente, id_equipamento, id_tecnico, numero_da_os, data_de_abertura, data_de_previsao, problema_relatado, diagnostico, servico, prioridade, valor_estimado, valor_final, forma_de_pagamento, status, observacoes)
SELECT (SELECT id_cliente FROM clientes WHERE email = 'cliente01@example.com'), (SELECT id_equipamento FROM equipamentos WHERE numero_de_serie = 'ASSISTEC-SN-0001' AND id_cliente = (SELECT id_cliente FROM clientes WHERE email = 'cliente01@example.com') LIMIT 1), (SELECT id_colaborador FROM colaboradores WHERE email = 'colaborador07@example.com'), 'OS-2026-0001', '2026-09-01 09:00:00', '2026-09-05 18:00:00', 'Notebook não liga', NULL, NULL, 'alta', 350, NULL, NULL, 'aberta', 'Aguardando diagnóstico'
WHERE NOT EXISTS (SELECT 1 FROM ordens_de_servico WHERE numero_da_os = 'OS-2026-0001');

INSERT INTO ordens_de_servico (id_cliente, id_equipamento, id_tecnico, numero_da_os, data_de_abertura, data_de_previsao, problema_relatado, diagnostico, servico, prioridade, valor_estimado, valor_final, forma_de_pagamento, status, observacoes)
SELECT (SELECT id_cliente FROM clientes WHERE email = 'cliente02@example.com'), (SELECT id_equipamento FROM equipamentos WHERE numero_de_serie = 'ASSISTEC-SN-0002' AND id_cliente = (SELECT id_cliente FROM clientes WHERE email = 'cliente02@example.com') LIMIT 1), (SELECT id_colaborador FROM colaboradores WHERE email = 'colaborador08@example.com'), 'OS-2026-0002', '2026-09-02 10:15:00', '2026-09-08 18:00:00', 'Desktop reinicia sozinho', 'Memória RAM com falha', NULL, 'media', 220, NULL, NULL, 'em_andamento', NULL
WHERE NOT EXISTS (SELECT 1 FROM ordens_de_servico WHERE numero_da_os = 'OS-2026-0002');

INSERT INTO ordens_de_servico (id_cliente, id_equipamento, id_tecnico, numero_da_os, data_de_abertura, data_de_previsao, problema_relatado, diagnostico, servico, prioridade, valor_estimado, valor_final, forma_de_pagamento, status, observacoes)
SELECT (SELECT id_cliente FROM clientes WHERE email = 'cliente03@example.com'), (SELECT id_equipamento FROM equipamentos WHERE numero_de_serie = 'ASSISTEC-SN-0003' AND id_cliente = (SELECT id_cliente FROM clientes WHERE email = 'cliente03@example.com') LIMIT 1), (SELECT id_colaborador FROM colaboradores WHERE email = 'colaborador09@example.com'), 'OS-2026-0003', '2026-09-03 11:30:00', '2026-09-09 18:00:00', 'Tela apresenta linhas', 'Cabo flat danificado', NULL, 'media', 280, NULL, NULL, 'aguardando_peca', 'Peça solicitada'
WHERE NOT EXISTS (SELECT 1 FROM ordens_de_servico WHERE numero_da_os = 'OS-2026-0003');

INSERT INTO ordens_de_servico (id_cliente, id_equipamento, id_tecnico, numero_da_os, data_de_abertura, data_de_previsao, problema_relatado, diagnostico, servico, prioridade, valor_estimado, valor_final, forma_de_pagamento, status, observacoes)
SELECT (SELECT id_cliente FROM clientes WHERE email = 'cliente04@example.com'), (SELECT id_equipamento FROM equipamentos WHERE numero_de_serie = 'ASSISTEC-SN-0004' AND id_cliente = (SELECT id_cliente FROM clientes WHERE email = 'cliente04@example.com') LIMIT 1), (SELECT id_colaborador FROM colaboradores WHERE email = 'colaborador10@example.com'), 'OS-2026-0004', '2026-09-04 14:00:00', '2026-09-07 18:00:00', 'Papel atola na impressora', 'Roletes desgastados', 'Troca dos roletes', 'baixa', 190, 190, 'Pix', 'concluida', 'Equipamento testado'
WHERE NOT EXISTS (SELECT 1 FROM ordens_de_servico WHERE numero_da_os = 'OS-2026-0004');

INSERT INTO ordens_de_servico (id_cliente, id_equipamento, id_tecnico, numero_da_os, data_de_abertura, data_de_previsao, problema_relatado, diagnostico, servico, prioridade, valor_estimado, valor_final, forma_de_pagamento, status, observacoes)
SELECT (SELECT id_cliente FROM clientes WHERE email = 'cliente05@example.com'), (SELECT id_equipamento FROM equipamentos WHERE numero_de_serie = 'ASSISTEC-SN-0005' AND id_cliente = (SELECT id_cliente FROM clientes WHERE email = 'cliente05@example.com') LIMIT 1), (SELECT id_colaborador FROM colaboradores WHERE email = 'colaborador11@example.com'), 'OS-2026-0005', '2026-09-05 08:40:00', '2026-09-10 18:00:00', 'Bateria não carrega', NULL, NULL, 'media', 300, NULL, NULL, 'aberta', NULL
WHERE NOT EXISTS (SELECT 1 FROM ordens_de_servico WHERE numero_da_os = 'OS-2026-0005');

INSERT INTO ordens_de_servico (id_cliente, id_equipamento, id_tecnico, numero_da_os, data_de_abertura, data_de_previsao, problema_relatado, diagnostico, servico, prioridade, valor_estimado, valor_final, forma_de_pagamento, status, observacoes)
SELECT (SELECT id_cliente FROM clientes WHERE email = 'cliente06@example.com'), (SELECT id_equipamento FROM equipamentos WHERE numero_de_serie = 'ASSISTEC-SN-0006' AND id_cliente = (SELECT id_cliente FROM clientes WHERE email = 'cliente06@example.com') LIMIT 1), (SELECT id_colaborador FROM colaboradores WHERE email = 'colaborador12@example.com'), 'OS-2026-0006', '2026-09-06 13:20:00', '2026-09-12 18:00:00', 'Computador muito lento', 'Acúmulo de arquivos e poeira', 'Limpeza e otimização', 'baixa', 160, 160, 'Cartão', 'concluida', NULL
WHERE NOT EXISTS (SELECT 1 FROM ordens_de_servico WHERE numero_da_os = 'OS-2026-0006');

INSERT INTO ordens_de_servico (id_cliente, id_equipamento, id_tecnico, numero_da_os, data_de_abertura, data_de_previsao, problema_relatado, diagnostico, servico, prioridade, valor_estimado, valor_final, forma_de_pagamento, status, observacoes)
SELECT (SELECT id_cliente FROM clientes WHERE email = 'cliente07@example.com'), (SELECT id_equipamento FROM equipamentos WHERE numero_de_serie = 'ASSISTEC-SN-0007' AND id_cliente = (SELECT id_cliente FROM clientes WHERE email = 'cliente07@example.com') LIMIT 1), (SELECT id_colaborador FROM colaboradores WHERE email = 'colaborador13@example.com'), 'OS-2026-0007', '2026-09-07 15:10:00', '2026-09-13 18:00:00', 'Teclas não funcionam', 'Teclado precisa de troca', NULL, 'media', 250, NULL, NULL, 'aguardando_peca', NULL
WHERE NOT EXISTS (SELECT 1 FROM ordens_de_servico WHERE numero_da_os = 'OS-2026-0007');

INSERT INTO ordens_de_servico (id_cliente, id_equipamento, id_tecnico, numero_da_os, data_de_abertura, data_de_previsao, problema_relatado, diagnostico, servico, prioridade, valor_estimado, valor_final, forma_de_pagamento, status, observacoes)
SELECT (SELECT id_cliente FROM clientes WHERE email = 'cliente08@example.com'), (SELECT id_equipamento FROM equipamentos WHERE numero_de_serie = 'ASSISTEC-SN-0008' AND id_cliente = (SELECT id_cliente FROM clientes WHERE email = 'cliente08@example.com') LIMIT 1), (SELECT id_colaborador FROM colaboradores WHERE email = 'colaborador07@example.com'), 'OS-2026-0008', '2026-09-08 09:25:00', '2026-09-11 18:00:00', 'Tablet não carrega', 'Conector USB danificado', NULL, 'alta', 230, NULL, NULL, 'em_andamento', NULL
WHERE NOT EXISTS (SELECT 1 FROM ordens_de_servico WHERE numero_da_os = 'OS-2026-0008');

INSERT INTO ordens_de_servico (id_cliente, id_equipamento, id_tecnico, numero_da_os, data_de_abertura, data_de_previsao, problema_relatado, diagnostico, servico, prioridade, valor_estimado, valor_final, forma_de_pagamento, status, observacoes)
SELECT (SELECT id_cliente FROM clientes WHERE email = 'cliente09@example.com'), (SELECT id_equipamento FROM equipamentos WHERE numero_de_serie = 'ASSISTEC-SN-0009' AND id_cliente = (SELECT id_cliente FROM clientes WHERE email = 'cliente09@example.com') LIMIT 1), (SELECT id_colaborador FROM colaboradores WHERE email = 'colaborador08@example.com'), 'OS-2026-0009', '2026-09-09 16:00:00', '2026-09-15 18:00:00', 'Wi-Fi desconecta frequentemente', NULL, NULL, 'baixa', 120, NULL, NULL, 'aberta', NULL
WHERE NOT EXISTS (SELECT 1 FROM ordens_de_servico WHERE numero_da_os = 'OS-2026-0009');

INSERT INTO ordens_de_servico (id_cliente, id_equipamento, id_tecnico, numero_da_os, data_de_abertura, data_de_previsao, problema_relatado, diagnostico, servico, prioridade, valor_estimado, valor_final, forma_de_pagamento, status, observacoes)
SELECT (SELECT id_cliente FROM clientes WHERE email = 'cliente10@example.com'), (SELECT id_equipamento FROM equipamentos WHERE numero_de_serie = 'ASSISTEC-SN-0010' AND id_cliente = (SELECT id_cliente FROM clientes WHERE email = 'cliente10@example.com') LIMIT 1), (SELECT id_colaborador FROM colaboradores WHERE email = 'colaborador09@example.com'), 'OS-2026-0010', '2026-09-10 10:50:00', '2026-09-14 18:00:00', 'Desktop sem imagem', 'Monitor com defeito', NULL, 'alta', 180, NULL, NULL, 'cancelada', 'Cliente desistiu do reparo'
WHERE NOT EXISTS (SELECT 1 FROM ordens_de_servico WHERE numero_da_os = 'OS-2026-0010');

COMMIT;
