<?php
session_start();

$nivelDaPagina = "atendente";
require_once dirname(__DIR__) . "/utils/verificarNivel.php";

verificarNivel($nivelDaPagina);

$mensagem = $_SESSION["flash"] ?? null;
unset($_SESSION["flash"]);

$nivel = htmlspecialchars(
    $_SESSION["usuario"]["nivel"] ?? "atendente",
    ENT_QUOTES,
    "UTF-8"
);

$email = htmlspecialchars(
    $_SESSION["usuario"]["email"] ?? "",
    ENT_QUOTES,
    "UTF-8"
);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atendimentos | AssisTec</title>

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/atendente/atendimentos.css">

    <script src="../js/pages/atendente/atendimentos.js" defer></script>
    <script src="../js/utils/nav.js" defer></script>
</head>

<body>
    <aside class="menu-lateral" id="sidebar">
        <a class="marca" href="index.php">
            <span class="marca-icone">AT</span>
            <span>Assis<span class="marca-azul">Tec</span></span>
        </a>

        <p class="menu-titulo">MENU</p>
        <nav class="menu">
            <a class="link-menu" href="index.php">Visão geral</a>
            <a class="link-menu" href="clientes.php">Clientes</a>
            <a class="link-menu" href="equipamentos.php">Equipamentos</a>
            <a class="link-menu active" href="atendimentos.php">Atendimentos</a>
        </nav>

        <div class="usuario-logado">
            <span class="usuario-cargo"><?= ucfirst($nivel) ?></span>
            <span class="usuario-email"><?= $email ?></span>
        </div>
    </aside>

    <main class="conteudo">
        <header class="cabecalho">
            <button class="abrir-menu" id="menuToggle" type="button"
                aria-label="Abrir menu" aria-expanded="false">☰</button>
            <div>
                <p class="subtitulo">AssisTec / Atendente</p>
                <h1>Atendimentos</h1>
            </div>
        </header>

        <?php if ($mensagem): ?>
            <p class="<?= ($mensagem["tipo"] ?? "") === "sucesso" ? "sucesso" : "erro" ?>" role="status">
                <?= htmlspecialchars($mensagem["mensagem"] ?? "", ENT_QUOTES, "UTF-8") ?>
            </p>
        <?php endif; ?>

        <section class="atendimentos-painel-principal">
            <nav class="atendimentos-abas" aria-label="Seções de atendimentos">
                <button type="button" class="atendimentos-aba active" data-tab="lista">
                    Ordens de serviço
                </button>
                <button type="button" class="atendimentos-aba" data-tab="cadastro">
                    Cadastrar
                </button>
            </nav>

            <section class="atendimentos-painel" id="template-lista">
                <form id="filtros-atendimentos"
                    action="../../src/routes/atendimentosRouter.php?rota=buscarOrdens"
                    method="GET">
                    <input type="search" name="id_ordem" placeholder="ID da ordem" inputmode="numeric" aria-label="Filtrar por ID da ordem">
                    <input type="search" name="numero_da_os" placeholder="Nº da OS" aria-label="Filtrar por número da OS">
                    <input type="search" name="nome_cliente" placeholder="Cliente" aria-label="Filtrar por cliente">
                    <input type="search" name="numero_de_serie" placeholder="Nº de série" aria-label="Filtrar por número de série">
                    <input type="search" name="nome_tecnico" placeholder="Técnico" aria-label="Filtrar por técnico">
                    <select name="prioridade" aria-label="Filtrar por prioridade">
                        <option value="">Todas as prioridades</option>
                        <option value="baixa">Baixa</option>
                        <option value="media">Média</option>
                        <option value="alta">Alta</option>
                        <option value="urgente">Urgente</option>
                    </select>
                    <select name="status" aria-label="Filtrar por status">
                        <option value="">Todos os status</option>
                        <option value="aberta">Aberta</option>
                        <option value="em_andamento">Em andamento</option>
                        <option value="aguardando_peca">Aguardando peça</option>
                        <option value="concluida">Concluída</option>
                        <option value="cancelada">Cancelada</option>
                    </select>
                    <button class="atendimentos-botao" type="submit">Buscar</button>
                    <button class="atendimentos-aba" type="reset">Limpar</button>
                </form>

                <p id="atendimentos-status" role="status">Carregando ordens de serviço...</p>

                <div class="atendimentos-tabela-container">
                    <table class="atendimentos-tabela">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nº da OS</th>
                                <th>Cliente</th>
                                <th>Equipamento</th>
                                <th>Marca</th>
                                <th>Técnico</th>
                                <th>Abertura</th>
                                <th>Prioridade</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="lista-atendimentos"></tbody>
                    </table>
                </div>
            </section>

            <template id="linha-atendimento">
                <tr>
                    <td data-campo="id_ordem"></td>
                    <td data-campo="numero_da_os"></td>
                    <td data-campo="nome_cliente"></td>
                    <td data-campo="tipo_equipamento"></td>
                    <td data-campo="marca_equipamento"></td>
                    <td data-campo="nome_tecnico"></td>
                    <td data-campo="data_de_abertura"></td>
                    <td data-campo="prioridade"></td>
                    <td data-campo="status"></td>
                    <td class="atendimentos-acoes-tabela">
                        <button class="atendimentos-botao" type="button" data-acao="atualizar">Atualizar</button>
                        <button class="atendimentos-botao atendimentos-botao-perigo" type="button" data-acao="deletar">Cancelar OS</button>
                    </td>
                </tr>
            </template>

            <section class="atendimentos-painel" id="template-cadastro" hidden>
                <h3>Cadastrar ordem de serviço</h3>
                <form id="form-cadastrar-atendimento"
                    action="../../src/routes/atendimentosRouter.php?rota=cadastrarOrdem" method="POST">
                    <div class="atendimentos-campos-form">
                        <label class="atendimentos-campo">ID do cliente
                            <input type="number" name="id_cliente" min="1" step="1" required>
                        </label>
                        <label class="atendimentos-campo">ID do equipamento
                            <input type="number" name="id_equipamento" min="1" step="1" required>
                        </label>
                        <label class="atendimentos-campo">ID do técnico
                            <input type="number" name="id_tecnico" min="1" step="1" required>
                        </label>
                        <label class="atendimentos-campo">Número da OS
                            <input name="numero_da_os" maxlength="20" required>
                        </label>
                        <label class="atendimentos-campo">Data de previsão
                            <input type="datetime-local" step="1" data-data-previsao="cadastro">
                            <input type="hidden" name="data_de_previsao">
                        </label>
                        <label class="atendimentos-campo">Prioridade
                            <select name="prioridade">
                                <option value="media" selected>Média</option>
                                <option value="baixa">Baixa</option>
                                <option value="alta">Alta</option>
                                <option value="urgente">Urgente</option>
                            </select>
                        </label>
                        <label class="atendimentos-campo">Valor estimado
                            <input type="number" name="valor_estimado" min="0" step="0.01">
                        </label>
                        <label class="atendimentos-campo atendimentos-campo-largo">Problema relatado
                            <textarea name="problema_relatado" rows="4" required></textarea>
                        </label>
                        <label class="atendimentos-campo atendimentos-campo-largo">Observações
                            <textarea name="observacoes" rows="3"></textarea>
                        </label>
                    </div>
                    <button class="atendimentos-botao" type="submit">Cadastrar ordem</button>
                </form>
            </section>

            <section class="atendimentos-painel" id="template-atualizar" hidden>
                <h3>Atualizar ordem: <span id="id-atendimento-atualizar"></span></h3>
                <form id="form-atualizar-atendimento"
                    action="../../src/routes/atendimentosRouter.php?rota=atualizarOrdem" method="POST">
                    <input type="hidden" name="id_ordem">
                    <div class="atendimentos-campos-form">
                        <label class="atendimentos-campo">Data de previsão
                            <input type="datetime-local" step="1" data-data-previsao="atualizar">
                            <input type="hidden" name="data_de_previsao">
                        </label>
                        <label class="atendimentos-campo">Prioridade
                            <select name="prioridade">
                                <option value="baixa">Baixa</option>
                                <option value="media">Média</option>
                                <option value="alta">Alta</option>
                                <option value="urgente">Urgente</option>
                            </select>
                        </label>
                        <label class="atendimentos-campo">Status
                            <select name="status">
                                <option value="aberta">Aberta</option>
                                <option value="em_andamento">Em andamento</option>
                                <option value="aguardando_peca">Aguardando peça</option>
                                <option value="concluida">Concluída</option>
                                <option value="cancelada">Cancelada</option>
                            </select>
                        </label>
                        <label class="atendimentos-campo">Valor estimado
                            <input type="number" name="valor_estimado" min="0" step="0.01">
                        </label>
                        <label class="atendimentos-campo">Valor final
                            <input type="number" name="valor_final" min="0" step="0.01">
                        </label>
                        <label class="atendimentos-campo">Forma de pagamento
                            <input name="forma_de_pagamento" maxlength="50">
                        </label>
                        <label class="atendimentos-campo atendimentos-campo-largo">Diagnóstico
                            <textarea name="diagnostico" rows="4"></textarea>
                        </label>
                        <label class="atendimentos-campo atendimentos-campo-largo">Serviço realizado
                            <textarea name="servico" rows="4"></textarea>
                        </label>
                        <label class="atendimentos-campo atendimentos-campo-largo">Observações
                            <textarea name="observacoes" rows="3"></textarea>
                        </label>
                    </div>
                    <div class="atendimentos-acoes-form">
                        <button class="atendimentos-botao" type="submit">Salvar alterações</button>
                        <button class="atendimentos-aba" type="button" data-tab="lista">Voltar à lista</button>
                    </div>
                </form>
            </section>

            <section class="atendimentos-painel" id="template-deletar" hidden>
                <h3>Cancelar ordem de serviço</h3>
                <p>Confirmar cancelamento da ordem <strong id="numero-atendimento-deletar"></strong>?</p>
                <p>O registro permanecerá no banco com status <strong>cancelada</strong>.</p>
                <form id="form-deletar-atendimento"
                    action="../../src/routes/atendimentosRouter.php?rota=cancelarOrdem" method="POST">
                    <input type="hidden" name="id_ordem">
                    <div class="atendimentos-acoes-form">
                        <button class="atendimentos-botao atendimentos-botao-perigo" type="submit">Confirmar cancelamento</button>
                        <button class="atendimentos-aba" type="button" data-tab="lista">Voltar à lista</button>
                    </div>
                </form>
            </section>
        </section>
    </main>

    <dialog class="atendimentos-modal" id="modal-atendimento" aria-labelledby="titulo-modal-atendimento">
        <div class="atendimentos-modal-cabecalho">
            <h2 id="titulo-modal-atendimento">Dados da ordem de serviço</h2>
            <button class="atendimentos-fechar-modal" id="fechar-modal-atendimento" type="button" aria-label="Fechar">×</button>
        </div>
        <dl class="atendimentos-dados">
            <div><dt>ID da ordem</dt><dd data-detalhe="id_ordem"></dd></div>
            <div><dt>Número da OS</dt><dd data-detalhe="numero_da_os"></dd></div>
            <div><dt>ID do cliente</dt><dd data-detalhe="id_cliente"></dd></div>
            <div><dt>Cliente</dt><dd data-detalhe="nome_cliente"></dd></div>
            <div><dt>ID do equipamento</dt><dd data-detalhe="id_equipamento"></dd></div>
            <div><dt>Tipo do equipamento</dt><dd data-detalhe="tipo_equipamento"></dd></div>
            <div><dt>Marca</dt><dd data-detalhe="marca_equipamento"></dd></div>
            <div><dt>Número de série</dt><dd data-detalhe="numero_de_serie"></dd></div>
            <div><dt>Patrimônio</dt><dd data-detalhe="patrimonio"></dd></div>
            <div><dt>ID do técnico</dt><dd data-detalhe="id_tecnico"></dd></div>
            <div><dt>Técnico</dt><dd data-detalhe="nome_tecnico"></dd></div>
            <div><dt>Data de abertura</dt><dd data-detalhe="data_de_abertura"></dd></div>
            <div><dt>Data de previsão</dt><dd data-detalhe="data_de_previsao"></dd></div>
            <div><dt>Problema relatado</dt><dd data-detalhe="problema_relatado"></dd></div>
            <div><dt>Diagnóstico</dt><dd data-detalhe="diagnostico"></dd></div>
            <div><dt>Serviço</dt><dd data-detalhe="servico"></dd></div>
            <div><dt>Prioridade</dt><dd data-detalhe="prioridade"></dd></div>
            <div><dt>Valor estimado</dt><dd data-detalhe="valor_estimado"></dd></div>
            <div><dt>Valor final</dt><dd data-detalhe="valor_final"></dd></div>
            <div><dt>Forma de pagamento</dt><dd data-detalhe="forma_de_pagamento"></dd></div>
            <div><dt>Status</dt><dd data-detalhe="status"></dd></div>
            <div><dt>Observações</dt><dd data-detalhe="observacoes"></dd></div>
        </dl>
    </dialog>
</body>

</html>
