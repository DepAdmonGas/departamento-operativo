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
        if (<?= $Session_IDEstacion ?> == 2){
      SelEstacion(9)
    }
    });
    function SelEstacion(idEstacion) {
        if (idEstacion == 9) {
        referencia = '#ContenidoOrganigrama2';
    } else {
      referencia = '#ContenidoOrganigrama';
    }
        //$('#ContenidoOrganigrama').load('public/recursos-humanos/vistas/contenido-recursos-humanos-estacion-horario-personal.php?idEstacion=' + idEstacion);
        $(referencia).load('app/vistas/contenido/2-recursos-humanos/horario-personal/contenido.php?idEstacion=' + idEstacion);
    }
    function EditHorario(titulo, dia, idPersonal, idEstacion) {
        var horario = titulo.value;
        var parametros = {
            "horario": horario,
            "dia": dia,
            "idPersonal": idPersonal,
            "idEstacion": idEstacion,
            "accion": "editar-horario-personal"
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
                <div class="col-12">
                    <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
                        <ol class="breadcrumb breadcrumb-caret">
                            <li class="breadcrumb-item"><a onclick="history.back()"
                                    class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i>
                                    Recursos Humanos</a></li>
                            <li aria-current="page" class="breadcrumb-item active text-uppercase">Horario Personal</li>
                        </ol>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Horario
                                Personal</h3>
                        </div>
                    </div>

                    <hr>
                </div>
                <div class="col-12" id="ContenidoOrganigrama"></div>
                <div class="col-12" id="ContenidoOrganigrama2"></div>
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

</body>

</html>