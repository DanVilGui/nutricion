<?php


$title = "Nutrilife";
include 'Vista/header.php';
include 'Vista/menu.php';
?>
    <!-- Begin page content -->
    <main role="main" class="container">
        <div class="row mt-2">
            <button id="btnAgregarPost" type="button" class="btn btn-primary">AGREGAR POST</button>
        </div>
        <table id="tablaListarPost" class="table table-bordered">
            <thead>
            <th>#</th>
            <th>Titulo</th>
            <th>Imagen</th>
            <th></th>
            </thead>
            <tbody>

            </tbody>
        </table>

        <div class="modal fade" id="modalAgregarPost" tabindex="-2" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">AGREGAR POST</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST"  enctype="multipart/form-data" id="formAgregarPost" action="Vista/ajax/operacionPost.php" >
                            <input type="hidden"  id="post_imagen_requerida" name="imagen_requerida" value="1" />

                            <input type="hidden"  id="post_idpost" name="idpost" value="-1" />
                            <div class="form-group row">
                                <label for="post_titulo" class="col-sm-2 col-form-label mayusculas">Titulo</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="post_titulo"  name="titulo" placeholder="INGRESE EL POST" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <textarea id="post_texto" name="texto" class="form-control" required rows="13" ></textarea>
                                </div>
                            </div>
                            <div class="form-group row text-center">
                                <div class="custom-file offset-sm-3 col-sm-6">
                                    <input type="file" accept="image/*" class="custom-file-input" id="post_imagen" name="imagen" required>
                                    <label class="custom-file-label" for="customFile">Seleccionar Imagen</label>
                                </div>
                            </div>


                            <div class=" text-center " style="margin-top: 0.75em">
                                <button type="submit" class="btn btn-success btnSubmitModal">AGREGAR</button>
                                <button type="button" class="btn btn-dark " data-dismiss="modal">CANCELAR</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </main>

<script>


    var tablaPost =  $('#tablaListarPost').DataTable({
        "lengthChange": false,
        "pageLength": 30,
        "bLengthChange": false,
        "retrieve": false,
        "autoWidth":false,
        "order": [],
        "language": languageDataTable(),
        "fnDrawCallback": drawCallbackDataTable(),
        "columnDefs": [
            {"width": "9%", "targets": [0]},
            {"width": "15%", "targets": [2]},
            {"width": "25%", "targets": [3]},
        ],
        "ajax": {
            "data":  function ( d ) {
                d.titulo = '';
            },
            "url": "Vista/ajax/listarPost.php",
            "type": "POST"
        },

        "columns": [
            {"data": "idpost"},
            {"data": "titulo"},
            {"data": null, 'render': function (data, type, row, meta) { return btnTableImage(data.imagen) }},

            {"data": null, 'render': function (data, type, row, meta) { return btnTableEditar() + " "+btnTableBorrar() }},
        ],
        'createdRow': function( row, data, dataIndex ) {
            $(row).attr('custom-id', data.idpost);
        },
        "initComplete": function(settings, json) {

        },
    });

    $('#btnAgregarPost').click(function () {
        $('#formAgregarPost').trigger("reset");
        $('#post_imagen_requerida').val(1);
        $('#post_idpost').val(-1);
        $('#post_imagen').prop("required", true);
        $('#modalAgregarPost').modal('show');
    });

    $('#formAgregarPost').on('submit', function(e) {
        e.preventDefault(); // prevent native submit
        $(this).ajaxSubmit({
            dataType:  'json',
            success: function(data){
                tablaPost.ajax.reload();
                mostrarRespuesta(data);
                $('#modalAgregarPost').modal('hide');
            }
        })
    });

    $('#tablaListarPost tbody')
        .on("click", ".btnEditar", function () {
            var id = $(this).parent().parent().attr('custom-id');
            $.ajax({
                type: "POST",
                url: "Vista/ajax/buscarPost.php",
                data: "id="+id,
                dataType: "json",
                success: function (data) {
                    $('#formAgregarPost').trigger("reset");
                    $('#post_imagen_requerida').val(0);
                    $('#post_imagen').prop("required", false);
                    $('#post_idpost').val(id);
                    $('#post_titulo').val(data.titulo);
                    $('#post_texto').val(data.texto);
                    $('#modalAgregarPost').modal('show');
                }
            });
        })
        .on("click", ".btnEliminar", function () {
            row = $(this).parent().parent();
            id= $(row).attr('custom-id');

            mostrarConfirmDialog().then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: "Vista/ajax/eliminarPost.php",
                        data: "id="+id,
                        dataType: "json",
                        success: function (data) {
                            mostrarRespuesta(data);
                            tablaPost.ajax.reload();
                        }
                    });
                }
            });
        })

</script>

<?php include 'Vista/footer.php'; ?>



