# Regras de Negócio

Este documento reúne algumas regras que o sistema de assistência técnica deverá seguir. Como o projeto ainda está em desenvolvimento, elas podem ser ajustadas conforme o sistema for sendo construído.

## Clientes e equipamentos

- Um cliente pode ter vários equipamentos cadastrados.
- Cada equipamento deve estar vinculado a um cliente.

## Ordens de serviço

- Cada ordem de serviço deve estar vinculada a um cliente e a um equipamento.
- Cada ordem de serviço deve registrar o técnico responsável.
- Um técnico pode ser responsável por várias ordens de serviço.
- A ordem de serviço deve registrar informações do atendimento, como o problema relatado, o diagnóstico, o serviço, a prioridade e o status.
- As alterações das ordens de serviço devem ser registradas no log para manter um histórico.

## Colaboradores e usuários

- Os colaboradores que acessam o sistema devem ter uma conta de usuário.
- Cada colaborador pode ter no máximo uma conta de usuário.
- O login de cada usuário deve ser único.
- O acesso ao sistema deve ser definido pelo nível do usuário: `administrador`, `atendente` ou `tecnico`.
- Usuários com status inativo não devem acessar o sistema.
- Somente usuários de nível `administrador` poderão acessar a área administrativa.
- Os usuários só podem acessar as páginas permitidas para o seu nível.
- Usuários com nível `administrador` podem acessar qualquer página e realizar qualquer operação no sistema.
- Somente usuários com nível `administrador` podem modificar ou excluir contas de usuários com nível inferior.
- A sessão do usuário deve ser encerrada após cinco horas.
- Somente usuários com nível `atendente` ou `administrador` podem cadastrar, consultar, alterar ou excluir clientes e abrir ordens de serviço.
- Usuários com nível `tecnico` podem consultar as ordens atribuídas a eles e atualizar informações técnicas, como o diagnóstico, o serviço realizado e o andamento do atendimento.
- Somente usuários com nível `administrador` podem cadastrar, alterar ou desativar contas de usuário.
- Cada ordem de serviço deve estar vinculada a um cliente, a um equipamento e ao técnico responsável.
- O sistema deve manter o histórico das alterações feitas nas ordens de serviço.
- Usuários inativos não podem acessar o sistema.


## Níveis de acesso

- **Administrador:** pode acessar todas as áreas do sistema, gerenciar cadastros e administrar usuários.
- **Atendente:** pode cadastrar clientes e equipamentos, abrir ordens de serviço e consultar os atendimentos.
- **Técnico:** pode consultar as ordens atribuídas a ele e atualizar as informações técnicas e o andamento do serviço.