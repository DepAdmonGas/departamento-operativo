<?php
require 'app/vistas/contenido/header.php';
?>
<script type="text/javascript">

    $(document).ready(function ($) {
        $(".LoaderPage").fadeOut("slow");

        ListaRefacciones();

    });

    function ListaRefacciones() {
        //$('#ListaRefacciones').load('public/corte-diario/vistas/lista-reporte-refacciones.php');
        $('#ListaRefacciones').load('app/vistas/contenido/4-almacen/refacciones/lista-reporte.php');
    }

    function Agregar() {

        $.ajax({
            url: 'public/corte-diario/modelo/crear-reporte-refacciones.php',
            type: 'post',
            beforeSend: function () { },
            complete: function () { },
            success: function (response) {

                if (response == 0) {
                    alertify.error('Error al crear el reporte');
                } else {
                    ListaRefacciones()

                    $('#Modal').modal('show');
                    $('#ContenidoModal').load('public/corte-diario/vistas/modal-reporte-refacciones.php?idReporte=' + response);

                }

            }
        });
    }

    function Almacen() {
        window.location.href = "refacciones-almacen";
    }
    function GuardarReporte(idReporte) {

        var Fecha = $('#Fecha').val();
        var Hora = $('#Hora').val();
        var Dispensario = $('#Dispensario').val();
        var Motivo = $('#Motivo').val();

        if (Fecha != "") {
            $('#Fecha').css('border', '');
            if (Hora != "") {
                $('#Hora').css('border', '');

                var parametros = {
                    "idReporte": idReporte,
                    "Fecha": Fecha,
                    "Hora": Hora,
                    "Dispensario": Dispensario,
                    "Motivo": Motivo
                };

                $.ajax({
                    data: parametros,
                    url: 'public/corte-diario/modelo/finalizar-refaccion-reporte.php',
                    type: 'post',
                    beforeSend: function () {
                    },
                    complete: function () {

                    },
                    success: function (response) {

                        if (response == 1) {
                            $('#ContenidoModal').load('public/corte-diario/vistas/modal-reporte-refacciones.php?idReporte=' + idReporte);
                            ListaRefacciones()
                        } else if (response == 0) {
                            alertify.error('Error al crear el reporte');
                        } else if (response == 2) {
                            alertify.warning('No cuenta con suficientes unidades');
                        }

                    }
                });

            } else {
                $('#Hora').css('border', '2px solid #A52525');
            }
        } else {
            $('#Fecha').css('border', '2px solid #A52525');
        }

    }

    function AgregarRR(idReporte) {

        var Refaccion = $('#Refaccion').val();
        var Unidad = $('#Unidad').val();

        if (Refaccion != "") {
            $('#Refaccion').css('border', '');
            if (Unidad != "") {
                $('#Unidad').css('border', '');

                var parametros = {
                    "idReporte": idReporte,
                    "Refaccion": Refaccion,
                    "Unidad": Unidad
                };

                $.ajax({
                    data: parametros,
                    url: 'public/corte-diario/modelo/agregar-refaccion-reporte.php',
                    type: 'post',
                    beforeSend: function () {
                    },
                    complete: function () {

                    },
                    success: function (response) {

                        if (response == 1) {
                            $('#ContenidoModal').load('public/corte-diario/vistas/modal-reporte-refacciones.php?idReporte=' + idReporte);
                            alertify.success('Refaccion agregada exitosamente.');
                        } else if (response == 0) {
                            alertify.error('Error al agregar la refaccion');
                        } else if (response == 2) {
                            alertify.warning('No cuenta con suficientes unidades');
                        }

                    }
                });

            } else {
                $('#Hora').css('border', '2px solid #A52525');
            }
        } else {
            $('#Refaccion').css('border', '2px solid #A52525');
        }

    }

    function EliminarRefaccionReporte(idReporte, id, idRefaccion) {

        var parametros = {
            "id": id,
            "idRefaccion": idRefaccion
        };

        alertify.confirm('',
            function () {

                $.ajax({
                    data: parametros,
                    url: 'public/corte-diario/modelo/eliminar-refaccion-reporte.php',
                    type: 'post',
                    beforeSend: function () {
                    },
                    complete: function () {

                    },
                    success: function (response) {


                        if (response == 1) {
                            alertify.success('Refaccion eliminada exitosamente.');
                            $('#ContenidoModal').load('public/corte-diario/vistas/modal-reporte-refacciones.php?idReporte=' + idReporte);
                        }

                    }
                });

            },
            function () {

            }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar la información seleccionada?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();

    }

    function EditarReporte(idReporte) {

        $('#Modal').modal('show');
        $('#ContenidoModal').load('public/corte-diario/vistas/modal-reporte-refacciones.php?idReporte=' + idReporte);

    }

    function EliminarReporte(id, idRefaccion) {

        var parametros = {
            "id": id,
            "idRefaccion": idRefaccion
        };


        alertify.confirm('',
            function () {

                $.ajax({
                    data: parametros,
                    url: 'public/corte-diario/modelo/eliminar-reporte-refaccion.php',
                    type: 'post',
                    beforeSend: function () {
                    },
                    complete: function () {

                    },
                    success: function (response) {


                        if (response == 1) {
                            ListaRefacciones();
                            alertify.success('Reporte eliminado exitosamente.');

                        }

                    }
                });

            },
            function () {

            }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar la información seleccionada?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();

    }

    function ModalDetalleReporte(id) {
        $('#Modal').modal('show');
        $('#ContenidoModal').load('public/corte-diario/vistas/modal-detalle-reporte-refaccion.php?idReporte=' + id);
    }

    function Transaccion() {
        window.location.href = "refacciones-transaccion";
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
                        <div class="col-7">

                            <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
                                <ol class="breadcrumb breadcrumb-caret">
                                    <li class="breadcrumb-item"><a onclick="history.back()"
                                            class="text-uppercase text-primary pointer"><i
                                                class="fa-solid fa-chevron-left"></i>
                                            Almacen</a></li>
                                    <li aria-current="page" class="breadcrumb-item active text-uppercase">
                                        Refacciones
                                    </li>
                                </ol>
                            </div>

                            <div class="row">
                                <div class="col-10">
                                    <h3 class="text-secondary"
                                        style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
                                        Refacciones</h3>

                                </div>
                            </div>


                        </div>



                        <div class="col-5">
                            <div class="text-end">
                                <div class="dropdown d-inline ms-2">
                                    <button type="button" class="btn dropdown-toggle btn-primary" type="button"
                                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-screwdriver-wrench"></i></span>
                                    </button>

                                    <ul class="dropdown-menu">

                                        <li onclick="Agregar()"><a class="dropdown-item pointer"> <i
                                                    class="fa-solid fa-plus"></i> Agregar</a></li>
                                        <li onclick="Almacen()"><a class="dropdown-item pointer"> <i
                                                    class="fa-solid fa-cart-plus"></i> Almacen</a></li>
                                        <li onclick="Transaccion()"><a class="dropdown-item pointer"> <i
                                                    class="fa-solid fa-address-card"></i> Transaccion</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="ListaRefacciones"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="Modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="DivModalBitacora">
                <div id="ContenidoModal"></div>
            </div>
        </div>
    </div>

    <!---------- FUNCIONES - NAVBAR ---------->
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

    <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

</body>

</html>