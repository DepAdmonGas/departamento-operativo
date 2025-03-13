<?php
require 'app/vistas/contenido/header.php';
?>
<!---------- LIBRERIAS DEL DATATABLE ---------->
<link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">

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
let targets;
      targets = [];
      $(referencia).load('app/vistas/contenido/2-recursos-humanos/horario-personal/contenido.php?idEstacion=' + idEstacion, function () {
        $('#tabla-principal').DataTable({
          "stateSave": true,
          "language": {
            "url": '<?= RUTA_JS2 ?>' + "/es-ES.json"
          },
          "order": [[0, "desc"]],
          "lengthMenu": [15, 30, 50, 100],
          "columnDefs": [
            { "orderable": false, "targets": targets },
            { "searchable": false, "targets": targets }
          ]
        });
      });
 //$('#ContenidoOrganigrama').load('public/recursos-humanos/vistas/contenido-recursos-humanos-estacion-horario-personal.php?idEstacion=' + idEstacion);
//$(referencia).load('app/vistas/contenido/2-recursos-humanos/horario-personal/contenido.php?idEstacion=' + idEstacion);
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
<!---------- LIBRERIAS DEL DATATABLE ---------->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.js"></script>

</body>
</html>  