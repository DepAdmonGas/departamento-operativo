<?php
require 'app/vistas/contenido/header.php';
?>
    <style media="screen">
        .sel-text {
            font-size: .9em;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function ($) {
            $(".LoaderPage").fadeOut("slow");
            SelEstacion(<?= $Session_IDEstacion; ?>)
        });
        function SelEstacion(idEstacion) {
            //sessionStorage.setItem('idestacion', idEstacion);
            //$('#ContenidoOrganigrama').load('public/recursos-humanos/vistas/contenido-recursos-humanos-estacion-horario-personal.php?idEstacion=' + idEstacion);
            $('#ContenidoOrganigrama').load('app/vistas/contenido/2-recursos-humanos/horario-personal/contenido.php?idEstacion=' + idEstacion);
        }
        function EditHorario(titulo, dia, idPersonal, idEstacion) {
            var horario = titulo.value;
            var parametros = {
                "horario": horario,
                "dia": dia,
                "idPersonal": idPersonal,
                "idEstacion": idEstacion,
                "accion":"editar-horario-personal"
            };
            $.ajax({
                data: parametros,
                //url: 'public/recursos-humanos/modelo/editar-personal-horiario.php',
                url: 'app/controlador/2-recursos-humanos/controladorHorario.php',
                type: 'POST',
                beforeSend: function () {
                    $(".LoaderPage").show();
                },
                complete: function () {
                },
                success: function (response) {
                    if (response == 1) {
                        $(".LoaderPage").hide();
                        SelEstacion(idEstacion)
                        alertify.success('El horario fue editado');
                    } else if (response == 0) {
                        $(".LoaderPage").hide();
                        alertify.error('El horario no fue editado');
                    }
                }
            });
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
                                        onclick="history.back()">

                                    <div class="row">
                                        <div class="col-12">

                                            <h5>Recursos humanos horario (Personal)</h5>

                                        </div>
                                    </div>

                                </div>
                            </div>

                            <hr>

                            <div id="ContenidoOrganigrama"></div>

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