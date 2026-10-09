# AssistTec — Sistema de Gestão para Assistência Técnica.
`Em Desenvolvimento`

---

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Apache](https://img.shields.io/badge/Apache-D22128?style=for-the-badge&logo=apache&logoColor=white)
![AWS](https://img.shields.io/badge/AWS_EC2-FF9900?style=for-the-badge&logo=amazonaws&logoColor=white)
![Ubuntu](https://img.shields.io/badge/Ubuntu-E95420?style=for-the-badge&logo=ubuntu&logoColor=white)
![Let's Encrypt](https://img.shields.io/badge/HTTPS-Let's_Encrypt-003A70?style=for-the-badge&logo=letsencrypt&logoColor=white)
![Git](https://img.shields.io/badge/Git-F05032?style=for-the-badge&logo=git&logoColor=white)
![GitHub](https://img.shields.io/badge/GitHub-181717?style=for-the-badge&logo=github&logoColor=white)

---

Projeto de um sistema web com operações de cadastro, consulta, edição e exclusão de dados (CRUD).

## Site na nuvem

O sistema está hospedado em uma instância **AWS EC2** (Ubuntu + Apache + PHP + MySQL), com HTTPS.

🌐 **Acesse:** https://assis-tec.duckdns.org

### Acesso de demonstração

| Campo | Valor |
|---|---|
| E-mail | `admin@assistec.com` |
| Senha | `123456` |

> Conta de teste com nível **admin**. Os dados do ambiente são fictícios e podem ser apagados a qualquer momento.

### Status atual

Os módulos de **clientes**, **equipamentos** e **ordens de serviço** já permitem cadastrar, consultar, atualizar e excluir registros. As demais áreas (painel do administrador e do técnico) ainda estão em desenvolvimento.


## Descrição do Problema

Está sendo desenvolvido um sistema web para uma empresa de assistência técnica de informática que ainda organiza boa parte do trabalho manualmente. Com as informações espalhadas e sem um controle centralizado, fica mais difícil acompanhar os clientes, os equipamentos recebidos e os serviços de manutenção em andamento.

Isso pode causar problemas no dia a dia: dados importantes podem ser esquecidos ou anotados errado, equipamentos podem se misturar, e a equipe pode perder tempo procurando informações ou tentando descobrir em que etapa está cada serviço. Também fica mais difícil consultar o histórico de atendimentos, avisar o cliente sobre o andamento do conserto e evitar atrasos ou retrabalho.

Além disso, sem um controle de acesso, pessoas que não deveriam consultar ou alterar certas informações podem acabar tendo acesso a elas. Isso pode comprometer a privacidade dos clientes e dificultar a identificação de quem fez cada alteração.

Essas falhas acabam prejudicando tanto a equipe quanto os clientes, que podem precisar esperar mais ou entrar em contato várias vezes para saber o que aconteceu com o equipamento. O sistema está sendo criado para reunir essas informações em um só lugar e facilitar o controle dos clientes, dos equipamentos e dos serviços de manutenção, além de organizar quem pode acessar os dados.

## Solução

### Descrição da Solução

Analisando o problema, percebi três pontos principais: falta de organização, falta de controle de acesso e dificuldade para acompanhar os serviços de manutenção.

Por isso, estou desenvolvendo um sistema web para centralizar as informações dos clientes, dos equipamentos e dos atendimentos. Com os dados organizados em um só lugar, fica mais fácil consultar o histórico, acompanhar cada serviço e reduzir erros e retrabalho.

O sistema também contará com controle de acesso, para limitar as informações de acordo com cada usuário e ajudar a proteger os dados dos clientes.

### Modelagem do Sistema

A modelagem foi feita com base nas principais atividades da assistência técnica. O sistema terá cadastros de clientes, equipamentos e colaboradores, além do controle dos serviços de manutenção por meio de ordens de serviço.

As principais entidades previstas são:

- **Clientes**: armazenam os dados de contato dos clientes.
- **Equipamentos**: registram os aparelhos pertencentes aos clientes e recebidos para manutenção.
- **Colaboradores**: representam as pessoas que trabalham na empresa, como técnicos, atendentes e proprietários.
- **Usuários**: representam as contas usadas pelos colaboradores para acessar o sistema. Cada usuário terá um nível de acesso: administrador, atendente ou técnico.
- **Ordens de serviço**: registram o atendimento de um equipamento, incluindo o problema relatado, o diagnóstico, o serviço realizado, a prioridade, os valores e o status.
- **Log de ordens de serviço**: guarda registros históricos das informações das ordens.

Um cliente pode ter vários equipamentos e solicitar várias ordens de serviço. Cada ordem fica vinculada a um cliente e a um equipamento, e registra o técnico responsável. Um colaborador pode ter uma conta de usuário no sistema.

O administrador pode acessar todas as áreas e gerenciar os cadastros e usuários. O atendente pode cuidar dos cadastros e abrir ordens de serviço. O técnico pode consultar as ordens atribuídas a ele e atualizar as informações técnicas e o andamento do serviço.