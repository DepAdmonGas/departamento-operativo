<?php
require 'app/vistas/contenido/header.php';
?>

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
<?php include_once "public/navbar/navbar-perfil.php";?>
<!---------- CONTENIDO PAGINA WEB---------->
<div class="contendAG">
<div class="row">
<div class="col-12" id="ContenidoOrganigrama"></div>
<div class="col-12" id="ContenidoOrganigrama2"></div>
</div>
</div>
</div>


<!---------- FUNCIONES - NAVBAR ---------->
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

</body>
</html>  