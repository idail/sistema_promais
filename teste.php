<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Datagrid de Clínicas</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Lista de Clínicas</h2>
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addClinicModal">
            Adicionar Clínica
        </button>
        <table id="clinicasTable" class="display">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Nome Fantasia</th>
                    <th>Razão Social</th>
                    <th>CNPJ</th>
                    <th>Endereço</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dados serão preenchidos via JavaScript -->
            </tbody>
        </table>
    </div>

    <!-- Modal para Adicionar Clínica -->
    <div class="modal fade" id="addClinicModal" tabindex="-1" role="dialog" aria-labelledby="addClinicModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addClinicModalLabel">Adicionar Clínica</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulário para adicionar clínica -->
                    <form id="addClinicForm">
                        <div class="form-group">
                            <label for="codigo">Código</label>
                            <input type="text" class="form-control" id="codigo" required>
                        </div>
                        <div class="form-group">
                            <label for="nome_fantasia">Nome Fantasia</label>
                            <input type="text" class="form-control" id="nome_fantasia" required>
                        </div>
                        <!-- Adicione mais campos conforme necessário -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" id="saveClinic">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#clinicasTable').DataTable({
                "ajax": {
                    "url": "api/list/clinicas.php",
                    "dataSrc": "data.clinicas"
                },
                "columns": [
                    { "data": null, "defaultContent": '<input type="checkbox">', "orderable": false },
                    { "data": "id" },
                    { "data": "codigo" },
                    { "data": "nome_fantasia" },
                    { "data": "razao_social" },
                    { "data": "cnpj" },
                    { "data": "endereco" },
                    { "data": "status" },
                    { "data": null, "defaultContent": '<button class="btn btn-sm btn-primary edit-btn">Editar</button> <button class="btn btn-sm btn-danger delete-btn">Apagar</button>', "orderable": false }
                ]
            });

            $('#selectAll').on('click', function() {
                var rows = table.rows({ 'search': 'applied' }).nodes();
                $('input[type="checkbox"]', rows).prop('checked', this.checked);
            });

            $('#clinicasTable tbody').on('change', 'input[type="checkbox"]', function() {
                if (!this.checked) {
                    var el = $('#selectAll').get(0);
                    if (el && el.checked && ('indeterminate' in el)) {
                        el.indeterminate = true;
                    }
                }
            });

            $('#saveClinic').on('click', function() {
                // Lógica para salvar a nova clínica
                alert('Clínica salva com sucesso!');
                $('#addClinicModal').modal('hide');
            });

            $('#clinicasTable tbody').on('click', '.edit-btn', function() {
                var data = table.row($(this).parents('tr')).data();
                alert('Editar clínica: ' + data.nome_fantasia);
            });

            $('#clinicasTable tbody').on('click', '.delete-btn', function() {
                var data = table.row($(this).parents('tr')).data();
                if (confirm('Tem certeza que deseja apagar a clínica ' + data.nome_fantasia + '?')) {
                    // Lógica para apagar a clínica
                    alert('Clínica apagada com sucesso!');
                }
            });
        });
    </script>
</body>
</html>