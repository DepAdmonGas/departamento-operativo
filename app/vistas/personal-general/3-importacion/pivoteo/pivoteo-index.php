<?php
require 'app/vistas/contenido/header.php';
?>
<script type="text/javascript">

    $(document).ready(function ($) {
        $(".LoaderPage").fadeOut("slow");

        ListaPivoteo(<?= $Session_IDEstacion; ?>);

    });

    function ListaPivoteo(idEstacion) {
        //$('#ListaPivoteo').load('public/corte-diario/vistas/lista-pivoteo.php?idEstacion=' + idEstacion);
        $('#ListaPivoteo').load('app/vistas/contenido/3-importacion/pivoteo/lista-pivoteo.php?idEstacion=' + idEstacion);
    }

    function Nuevo(idEstacion) {

        var parametros = {
            "idEstacion": idEstacion,
            "accion":"nuevo-pivoteo"
        };
        $.ajax({
            data: parametros,
            //url: 'public/corte-diario/modelo/agregar-pivoteo.php',
            url: 'app/controlador/3-importacion/controladorPivoteo.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {
                if (response != 0) {
                    window.location.href = "pivoteo-editar/" + response;
                } else {
                    alertify.error('Error al crear');
                }

            }
        });

    }

    function Eliminar(idEstacion, id) {

        var parametros = {
            "id": id,
            "accion":"eliminar-pivoteo"
        };

        alertify.confirm('',
            function () {

                $.ajax({
                    data: parametros,
                    //url: 'public/corte-diario/modelo/eliminar-pivoteo.php',
                    url: 'app/controlador/3-importacion/controladorPivoteo.php',
                    type: 'post',
                    beforeSend: function () {
                    },
                    complete: function () {

                    },
                    success: function (response) {

                        if (response == 1) {
                            ListaPivoteo(idEstacion)
                        } else {
                            alertify.error('Error al eliminar el pedido');
                        }

                    }
                });

            },
            function () {

            }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar la información seleccionada?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();
    }

    function Editar(idEstacion, id) {
        window.location.href = "pivoteo-editar/" + id;
    }

    function VerPivoteo(id) {
        $('#Modal').modal('show');
        //$('#DivContenido').load('public/corte-diario/vistas/modal-detalle-pivoteo.php?idReporte=' + id);
        $('#DivContenido').load('app/vistas/contenido/3-importacion/pivoteo/detalle-pivoteo.php?idReporte=' + id);
    }

    function PivoteoPDF(id) {
        window.location.href = "pivoteo-pdf/" + id;
    }
</script>
<!--Se ocupa cuando se registra un nuevo permiso y se actualice los datos de la vista-->
<script>
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                // Si la página está en la caché del navegador, recargarla
                window.location.reload();
            }
        });
</script>

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
                    <div class="cardAG">
                        <div class="border-0 p-3">


                            <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
                                <ol class="breadcrumb breadcrumb-caret">
                                    <li class="breadcrumb-item"><a onclick="history.back()"
                                            class="text-uppercase text-primary pointer"><i
                                                class="fa-solid fa-house"></i>
                                            Pivoteo</a></li>
                                    <li aria-current="page" class="breadcrumb-item active text-uppercase">Lista pivoteo
                                    </li>
                                </ol>
                            </div>

                            <div class="row">
                                <div class="col-9">
                                    <h3 class="text-secondary"
                                        style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
                                        Lista pivoteo</h3>
                                </div>
                                <div class="col-3">
                                    <button type="button" class="btn btn-labeled2 btn-primary float-end"
                                        onclick="Nuevo(<?= $Session_IDEstacion; ?>)">
                                        <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
                                </div>

                                <div class="col-12">
                                    <hr>
                                </div>
                                <div class="col-12" id="ListaPivoteo"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal right fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content" id="DivContenido"></div>
        </div>
    </div>

    <!---------- FUNCIONES - NAVBAR ---------->
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

</body>

</html>