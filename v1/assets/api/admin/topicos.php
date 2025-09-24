<?php
if (!isset($_GET['id'])) {
    die("Curso não especificado.");
}
$curso_id = intval($_GET['id']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Tópicos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: linear-gradient(to right, #f5f7fa, #c3cfe2); font-family: 'Segoe UI', sans-serif; padding-top: 56px;">

<header>
    <?php include 'menu_admin.php'; ?>
</header>

<div class="container-fluid">
    <div class="row">
        <?php include 'sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 offset-lg-2 px-md-4" style="padding: 30px;">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-4 border-bottom">
                <h1 class="h2" style="font-weight: bold;">Tópicos do Curso <?= $curso_id ?></h1>
                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#topicoModal">
                    Criar novo tópico
                </button>
            </div>

            <a href="cursos.php" class="btn btn-secondary mb-3">Voltar</a>
            <div id="mensagem"></div>

            <table id="tabelaTopicos" class="table table-striped" style="background-color: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.05); overflow: hidden;">
                <thead style="background-color: #f0f0f0;">
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Ordem</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </main>
    </div>
</div>

<!-- Modal Criar/Editar Tópico -->
<div class="modal fade" id="topicoModal" tabindex="-1" aria-labelledby="topicoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            <div class="modal-header" style="background-color: #343a40; color: #fff; border-bottom: none;">
                <h5 class="modal-title" id="topicoModalLabel" style="font-weight: bold;">Criar novo tópico</h5>
                <button type="button" class="btn-close" style="color: #fff;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTopicos">
                    <input type="hidden" id="topico-id">
                    <input type="hidden" id="curso_id_modal" value="<?= $curso_id ?>">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" required>
                    </div>
                    <div class="mb-3">
                        <label for="ordem" class="form-label">Ordem</label>
                        <input type="number" class="form-control" id="ordem" required>
                    </div>
                    <button type="submit" class="btn" style="background-color: #343a40; color: #fff; border-radius: 5px;">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    const baseURL = "/2IDS/projeto-unicorp/";

    function carregarTopicos() {
        $.get(baseURL + "api/admin/topicos_listar.php", { curso_id: $('#curso_id_modal').val() }, function(lista){
            const tbody = $('#tabelaTopicos tbody');
            tbody.empty();
            lista.forEach(t => {
                tbody.append(`
                    <tr>
                        <td>${t.id}</td>
                        <td>${t.titulo}</td>
                        <td>${t.ordem}</td>
                        <td>
                            <button class="btn btn-sm btn-primary btn-editar" data-id="${t.id}" data-titulo="${t.titulo}" data-ordem="${t.ordem}">Editar</button>
                            <button class="btn btn-sm btn-danger" onclick="excluirTopico('${t.id}')">Excluir</button>
                            <a href="conteudo.php?topico_id=${t.id}" class="btn btn-sm btn-secondary">Conteúdo</a>
                        </td>
                    </tr>
                `);
            });
        }, 'json');
    }

    $(document).on("click", ".btn-editar", function () {
        $('#topicoModalLabel').text("Editar tópico");
        $('#topico-id').val($(this).data("id"));
        $('#titulo').val($(this).data("titulo"));
        $('#ordem').val($(this).data("ordem"));
        $('#topicoModal').modal("show");
    });

    $('#formTopicos').on('submit', function(e){
        e.preventDefault();
        const id = $('#topico-id').val();
        const url = id ? "topicos_editar.php" : "topicos_adicionar.php";

        $.post(baseURL + "api/admin/" + url, {
            id,
            curso_id: $('#curso_id_modal').val(),
            titulo: $('#titulo').val(),
            ordem: $('#ordem').val()
        }, function(res) {
            $('#mensagem').html(`<div class="alert alert-${res.status == 'sucesso' ? 'success' : 'danger'}">${res.mensagem}</div>`);
            $('#topicoModal').modal("hide");
            $('#formTopicos')[0].reset();
            $('#topicoModalLabel').text("Criar novo tópico");
            $('#topico-id').val('');
            carregarTopicos();
        }, 'json');
    });

    function excluirTopico(id) {
        if(confirm("Deseja excluir este tópico?")) {
            $.post(baseURL + "api/admin/topicos_excluir.php", {id}, function(res) {
                $('#mensagem').html(`<div class="alert alert-${res.status == 'sucesso' ? 'success' : 'danger'}">${res.mensagem}</div>`);
                carregarTopicos();
            }, 'json');
        }
    }

    $(document).ready(() => carregarTopicos());
</script>

</body>
</html>
