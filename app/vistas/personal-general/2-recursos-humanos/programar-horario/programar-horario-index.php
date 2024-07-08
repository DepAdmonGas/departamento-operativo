<?php
require 'app/vistas/contenido/header.php';

?>

<html lang="es">
<!---------- LIBRERIAS DEL DATATABLE ---------->
<link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">
<script type="text/javascript">

$(document).ready(function ($) {
$(".LoaderPage").fadeOut("slow");
ListaProgramacion(<?=$Session_IDEstacion?>);
});

function ListaProgramacion(idEstacion) {
let targets;
targets = [2,3];

$('#Contenido').load('app/vistas/contenido/2-recursos-humanos/programar-horario/contenido-programar-horario.php?idEstacion=' + idEstacion, function () {
$('#tabla_horario').DataTable({
"language": {
"url": "<?= RUTA_JS2 ?>/es-ES.json"
},
"order": [[0, "desc"]],
"lengthMenu": [15,30,50,100],
"columnDefs": [
{ "orderable": false, "targets": targets },
{ "searchable": false, "targets": targets }
]
});
});
}
 
function Agregar(idEstacion) {
    
var parametros = {
"idEstacion": idEstacion,
 "accion": "agregar-horario"
}

$.ajax({
data: parametros,
url: 'app/controlador/2-recursos-humanos/controladorHorario.php',
 //url: 'public/recursos-humanos/modelo/agregar-programar-horario-personal.php',
type: 'post',
beforeSend: function () {

},
complete: function () { 

},
success: function (response) {
if (response != 0) {
window.location.href = "recursos-humanos-estacion-programar-horario-nuevo/" + response;
}
}
});
}

function Eliminar(idReporte,idEstacion) {

var parametros = {
"idReporte": idReporte,
"accion": "elimnar-horario"
};

alertify.confirm('',
function () {
$.ajax({
data: parametros,
//url: 'public/recursos-humanos/modelo/eliminar-horario-programado.php',
url: 'app/controlador/2-recursos-humanos/controladorHorario.php',
type: 'post',
beforeSend: function () { 

},
complete: function () { 

},
success: function (response) {
if (response == 1) {
ListaProgramacion(idEstacion);
alertify.success('Registro eliminado exitosamente');
}else{
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

window.addEventListener('pageshow', function(event) {
if (event.persisted) {
// Si la página está en la caché del navegador, recargarla
window.location.reload();
}
});


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
<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> Recursos Humanos</a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase">Programar Horario</li>
</ol>
</div>

<div class="row">
<div class="col-9">
<h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Programar Horario</h3>
</div>

<div class="col-3">
<button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="Agregar(<?=$Session_IDEstacion;?>)">
<span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
</div>
</div>

<hr>
</div>

<div class="col-12" id="Contenido"></div>
</div>

</div>
</div>


<!---------- FUNCIONES - NAVBAR ---------->
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>
<!---------- LIBRERIAS DEL DATATABLE ---------->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.js"></script>

</body>
</html>