<?php
require 'app/vistas/contenido/header.php';
?>
<html lang="es">
    <style media="screen">
        .sel-text {
            font-size: .9em;
        }
    </style>

    <script type="text/javascript">

        $(document).ready(function ($) {
            $(".LoaderPage").fadeOut("slow");
            ListaProgramacion();
        });
        function ListaProgramacion() {
            //$('#Contenido').load('public/recursos-humanos/vistas/contenido-recursos-humanos-estacion-programar-horario.php');
            $('#Contenido').load('app/vistas/contenido/2-recursos-humanos/programar-horario/contenido-programar-horario.php');
        }

        function Agregar(idEstacion) {
            var parametros = {
                "idEstacion":idEstacion,
                "accion":"agregar-horario"
            }
            $.ajax({
                data:parametros,
                url: 'app/controlador/2-recursos-humanos/controladorHorario.php',
                //url: 'public/recursos-humanos/modelo/agregar-programar-horario-personal.php',
                type: 'post',
                beforeSend: function () {},
                complete: function () {},
                success: function (response) {
                    if (response != 0) {
                        window.location.href = "recursos-humanos-estacion-programar-horario-nuevo/" + response;
                    }
                }
            });
        }

        function Eliminar(idReporte) {

            var parametros = {
                "idReporte": idReporte,
                "accion":"elimnar-horario"
            };

            alertify.confirm('',
                function () {

                    $.ajax({
                        data: parametros,
                        //url: 'public/recursos-humanos/modelo/eliminar-horario-programado.php',
                        url: 'app/controlador/2-recursos-humanos/controladorHorario.php',
                        type: 'post',
                        beforeSend: function () {},complete: function () {},
                        success: function (response) {
                            if (response == 1) {
                                ListaProgramacion();
                                alertify.success('Fecha eliminada exitosamente');
                            } else {
                                alertify.error('Error al eliminar');
                            }
                        }
                    });

                },
                function () {
                }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar la información seleccionada?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();
        }
        function Detalle(id) {
            window.location.href = "recursos-humanos-estacion-programar-horario-detalle/" + id;
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
                    <div class="cardAG">
                        <div class="border-0 p-3">

                            <div class="row">
                                <div class="col-11">

                                    <img class="float-start pointer" src="<?= RUTA_IMG_ICONOS; ?>regresar.png"
                                        onclick="history.back()">

                                    <div class="row">
                                        <div class="col-12">

                                            <h5>Recursos humanos programar horario</h5>

                                        </div>
                                    </div>

                                </div>

                                <div class="col-1">
                                    <img class="float-end pointer" src="<?= RUTA_IMG_ICONOS; ?>agregar.png"
                                        onclick="Agregar(<?=$Session_IDEstacion?>)">
                                </div>

                            </div>

                            <hr>

                            <div id="Contenido"></div>

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>


    <!---------- FUNCIONES - NAVBAR ---------->
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

</body>

</html>