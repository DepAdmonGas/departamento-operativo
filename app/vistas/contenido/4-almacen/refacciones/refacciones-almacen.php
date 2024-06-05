<?php
require 'app/vistas/contenido/header.php';
?>
<!---------- LIBRERIAS DEL DATATABLE ---------->
<link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">
<script type="text/javascript">

    $(document).ready(function ($) {
        $(".LoaderPage").fadeOut("slow");

        ListaRefacciones();

    });
    
    function ListaRefacciones() {
        let targets;
        targets = [6,7];

        $('#ListaRefacciones').load('public/corte-diario/vistas/lista-refacciones.php', function () {
            $('#tabla_refacciones').DataTable({
                "language": {
                    "url": "<?= RUTA_JS2 ?>/es-ES.json"
                },
                "order": [[0, "asc"]],
                "lengthMenu": [15,30,50,100],
                "columnDefs": [
                    { "orderable": false, "targets": targets },
                    { "searchable": false, "targets": targets }
                ]
            });
        });

    }

    function ModalDetalle(id) {
        $('#Modal').modal('show');
        $('#ContenidoModal').load('public/corte-diario/vistas/modal-detalle-refaccion.php?idRefaccion=' + id);
    }

    function ModalMas(id) {
        $('#Modal').modal('show');
        $('#ContenidoModal').load('public/corte-diario/vistas/modal-unidades-refaccion.php?idRefaccion=' + id);
    }

    function AgregarPiezas(id) {

        var Unidades = $('#Unidades').val();

        var parametros = {
            "id": id,
            "Unidades": Unidades
        };

        $.ajax({
            data: parametros,
            url: 'public/corte-diario/modelo/agregar-unidad-refaccion.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {


                if (response == 1) {
                    ModalMas(id);
                    ListaRefacciones();
                    alertify.success('Refaccion agregada exitosamente');
                }

            }
        });

    }

    function EliminarUnidad(id, idRefaccion) {

        var parametros = {
            "id": id,
            "idRefaccion": idRefaccion
        };


        alertify.confirm('',
            function () {

                $.ajax({
                    data: parametros,
                    url: 'public/corte-diario/modelo/eliminar-unidad-refaccion.php',
                    type: 'post',
                    beforeSend: function () {
                    },
                    complete: function () {

                    },
                    success: function (response) {


                        if (response == 1) {
                            ModalMas(idRefaccion);
                            ListaRefacciones();
                            alertify.success('Registro eliminado exitosamente');
                        }

                    }
                });

            },
            function () {

            }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar la información seleccionada?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();


    }
</script>
</head>

<body>
    <div class="LoaderPage"></div>


    <!---------- DIV - CONTENIDO ---------->
    <div id="content">
        <!---------- NAV BAR - PRINCIPAL (TOP) ---------->
        <?php include_once "public/navbar/navbar-perfil.php"; ?>
        <!---------- CONTENIDO PAGINA WEB---------->
        <div class="contendAG">
            <div class="row">

                <div class="col-12 mb-3">

                    <div class="row">
                        <div class="col-12">

                            <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
                                <ol class="breadcrumb breadcrumb-caret">
                                    <li class="breadcrumb-item"><a onclick="history.back()"
                                            class="text-uppercase text-primary pointer"><i
                                                class="fa-solid fa-chevron-left"></i>
                                            Refacciones</a></li>
                                    <li aria-current="page" class="breadcrumb-item active text-uppercase">
                                        Almacen Refacciones
                                    </li>
                                </ol>
                            </div>

                            <div class="row">
                                <div class="col-10">
                                    <h3 class="text-secondary"
                                        style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
                                        Almacen Refacciones</h3>
                                        <br>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <div id="ListaRefacciones"></div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal" id="Modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="margin-top: 83px;">
                <div id="ContenidoModal"></div>
            </div>
        </div>
    </div>

    <!---------- FUNCIONES - NAVBAR ---------->
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

    <!---------- LIBRERIAS DEL DATATABLE ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.js"></script>
</body>

</html>