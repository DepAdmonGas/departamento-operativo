<?php
require 'app/vistas/contenido/header.php';

?>

<!---------- LIBRERIAS DEL DATATABLE ---------->
<link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">

<script type="text/javascript">

$(document).ready(function ($) {
$(".LoaderPage").fadeOut("slow");
ListaPivoteo(<?=$Session_IDEstacion?>);

}); 
 
function ListaPivoteo(idEstacion) {
let targets;
targets = [4];

//$('#ListaPivoteo').load('public/corte-diario/vistas/lista-pivoteo.php?idEstacion=' + idEstacion);
$('#ListaPivoteo').load('app/vistas/contenido/3-importacion/pivoteo/lista-pivoteo.php?idEstacion=' + idEstacion, function() {
  $('#tabla_pivoteo_' + idEstacion).DataTable({
  "language": {
  "url": "<?=RUTA_JS2?>/es-ES.json"
  },
  "order": [[0, "desc"]],
  "lengthMenu": [25, 50, 75, 100],
  "columnDefs": [
  { "orderable": false, "targets": targets },
  { "searchable": false, "targets": targets }
  ]
  });
  });
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
}else{
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
}else{
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
<div class="col-12" id="ListaPivoteo"></div>
</div>
</div>
</div>


<!---------- MODAL COVID (RIGHT)---------->  
<div class="modal right fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-scrollable modal-xl">
<div class="modal-content" id="DivContenido"></div>
</div>
</div>
  

<!---------- FUNCIONES - NAVBAR ---------->
<script  src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

<!---------- LIBRERIAS DEL DATATABLE ---------->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.js"></script>

</body>
</html>