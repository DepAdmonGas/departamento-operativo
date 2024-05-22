<?php
require ('app/help.php');
?>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Departamento Operativo</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <link rel="shortcut icon" href="<?= RUTA_IMG_ICONOS ?>/icono-web.png">
    <link rel="apple-touch-icon" href="<?= RUTA_IMG_ICONOS ?>/icono-web.png">
    <link rel="stylesheet" href="<?= RUTA_CSS2 ?>alertify.css">
    <link rel="stylesheet" href="<?= RUTA_CSS2 ?>themes/default.rtl.css">
    <link href="<?= RUTA_CSS2; ?>bootstrap.min.css" rel="stylesheet" />
    <link href="<?= RUTA_CSS2; ?>navbar-general.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?= RUTA_JS2 ?>alertify.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

    <style media="screen">
        .sel-text {
            font-size: .9em;
        }
    </style>


    <script type="text/javascript">

        $(document).ready(function ($) {
            $(".LoaderPage").fadeOut("slow");
            ListaPersonal(<?= $GET_idReporte; ?>);
        });

        function Regresar() {
            window.history.back();
        }

        function ListaPersonal(idReporte) {
            //$('#ListaPersonal').load('../public/recursos-humanos/vistas/contenido-recursos-humanos-estacion-programar-horario-personal.php?idReporte=' + idReporte);
            $('#ListaPersonal').load('../app/vistas/contenido/2-recursos-humanos/programar-horario/contenido-nuevo-horario.php?idReporte=' + idReporte);
        }

        function EditHorario(titulo, dia, idPersonal, idReporte, idEstacion) {
            var horario = titulo.value;

            var parametros = {
                "horario": horario,
                "dia": dia,
                "idPersonal": idPersonal,
                "idReporte": idReporte,
                "idEstacion": idEstacion,
                "accion":"editar-horario"
            };

            $.ajax({
                data: parametros,
                url: '../app/controlador/2-recursos-humanos/controladorHorario.php',
                //url: '../public/recursos-humanos/modelo/editar-personal-programar-horiario.php',
                type: 'POST',

                beforeSend: function () {
                    $(".LoaderPage").show();
                },
                complete: function () {},
                success: function (response) {
                    if (response == 1) {

                        $(".LoaderPage").hide();
                        ListaPersonal(idReporte)
                        //alertify.success('El horario fue editado');
                    } else if (response == 0) {
                        $(".LoaderPage").hide();
                        alertify.error('El horario no fue editado');
                    }
                }
            });
        }
        function Guardar(idReporte) {
            var Fecha = $('#Fecha').val();
            if (Fecha != "") {
                var parametros = {
                    "Fecha": Fecha,
                    "idReporte": idReporte,
                    "accion":"guardar-horario"
                };
                $.ajax({
                    data: parametros,
                    url: '../app/controlador/2-recursos-humanos/controladorHorario.php',
                    //url: '../public/recursos-humanos/modelo/guardar-personal-programar-horiario.php',
                    type: 'POST',
                    beforeSend: function () {
                        $(".LoaderPage").show();
                    },complete: function () {},
                    success: function (response) {
                        if (response == 1) {
                            $(".LoaderPage").hide();
                            Regresar();
                        } else if (response == 0) {
                            $(".LoaderPage").hide();
                            alertify.error('El horario no fue editado');
                        }
                    }
                });
            } else {
                $("#Fecha").css('border', '2px solid #A52525');
            }
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
                                <div class="col-12">

                                    <img class="float-start pointer" src="<?= RUTA_IMG_ICONOS; ?>regresar.png"
                                        onclick="Regresar()">

                                    <div class="row">
                                        <div class="col-12">

                                            <h5>Recursos humanos programar horario</h5>

                                        </div>
                                    </div>

                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-4">
                                    <label class=" text-secondary"><b>Fecha:</b></label>
                                    <input type="date" class="form-control" id="Fecha">
                                </div>
                            </div>

                            <div id="ListaPersonal"></div>

                            <hr>
                            <div class="text-end">
                                <button type="button" class="btn btn-success"
                                    onclick="Guardar(<?= $GET_idReporte; ?>)">Guardar y programar</button>
                            </div>



                        </div>
                    </div>
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

</body>

</html>