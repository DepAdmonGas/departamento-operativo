<?php
require 'app/vistas/contenido/header.php';
?>
<!---------- LIBRERIAS DEL DATATABLE ---------->
<link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">
<script type="text/javascript">

$(document).ready(function ($) {
$(".LoaderPage").fadeOut("slow");
ListaMedicion(<?=$Session_IDEstacion?>);
});

function ListaMedicion(idEstacion) {
let targets;
targets = [7];
  
$('#DivContenido').load('app/vistas/contenido/3-importacion/mediciones/lista-mediciones.php?idEstacion=' + idEstacion, function () {
$('#tabla_mediciones').DataTable({
  "stateSave": true,
"language": {
"url": "<?= RUTA_JS2 ?>/es-ES.json"
},
"order": [[0, "desc"]],
"lengthMenu": [25,50,75,100],
"columnDefs": [
{ "orderable": false, "targets": targets },
{ "searchable": false, "targets": targets }
]
});
});
}

function Modal(idEstacion) {
$('#Modal').modal('show');
$('#DivModalMediciones').load('app/vistas/contenido/3-importacion/mediciones/modal-mediciones.php?idEstacion=' + idEstacion);
}

function Guardar(idEstacion) {

var Fecha = $('#Fecha').val();
var Factura = $('#Factura').val();
var Neto = $('#Neto').val();
var Bruto = $('#Bruto').val();
var CuentaLitros = $('#CuentaLitros').val();
var Proveedor = $('#Proveedor').val();
 
if (Fecha != "") {
$('#Fecha').css('border', '');
if (Factura != "") {
$('#Factura').css('border', '');
if (Neto != "") {
$('#Neto').css('border', '');
if (Bruto != "") {
$('#Bruto').css('border', '');
if (CuentaLitros != "") {
$('#CuentaLitros').css('border', '');
if (Proveedor != "") {
$('#Proveedor').css('border', '');

var parametros = {
"idEstacion": idEstacion,
"Fecha": Fecha,
"Factura": Factura,
"Neto": Neto,
"Bruto": Bruto,
"CuentaLitros": CuentaLitros,
"Proveedor": Proveedor,
"accion": "guardar-medicion"
};

$.ajax({
data: parametros,
//url: 'public/corte-diario/modelo/agregar-mediciones.php',
url: 'app/controlador/3-importacion/controladorMedicion.php',
type: 'post',
beforeSend: function () {
$(".LoaderPage").show();
},
complete: function () {

},
success: function (response) {
if (response == 1) {

$(".LoaderPage").hide();
$('#Modal').modal('hide');
$('#Factura').val('');
$('#Neto').val('');
$('#Bruto').val('');
$('#CuentaLitros').val('');
$('#Proveedor').val('');
alertify.success('Registro agregado exitosamente.')
ListaMedicion(idEstacion);

}else if(response == 0) {
alertify.error('Error al agregar')
$(".LoaderPage").hide();

}else if (response == 2){
alertify.error('Error al agregar')
$('#Fecha').css('border', '2px solid #A52525');
$(".LoaderPage").hide();
}

}
});

} else {
$('#Proveedor').css('border', '2px solid #A52525');
}
} else {
$('#CuentaLitros').css('border', '2px solid #A52525');
}
} else {
$('#Bruto').css('border', '2px solid #A52525');
}
} else {
$('#Neto').css('border', '2px solid #A52525');
}
} else {
$('#Factura').css('border', '2px solid #A52525');
}
} else {
$('#Fecha').css('border', '2px solid #A52525');
}
}

function Eliminar(id, idEstacion) {
var parametros = {
"id": id,
"accion": "eliminar-medicion"
};

alertify.confirm('',
function () {
$.ajax({
data: parametros,
//url: 'public/corte-diario/modelo/eliminar-mediciones.php',
url: 'app/controlador/3-importacion/controladorMedicion.php',
type: 'post',
beforeSend: function () {
$(".LoaderPage").show();
},
complete: function () {

},
success: function (response) {
if (response == 1) {
$(".LoaderPage").hide();
ListaMedicion(idEstacion);
alertify.success('Registro eliminado exitosamente.')
} else if (response == 0) {
alertify.error('Error al agregar')
$(".LoaderPage").hide();
}
}
});
},
function () {
}).setHeader('Eliminar medición').set({ transition: 'zoom', message: '¿Desea eliminar el la medición seleccionada?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();
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
    
<div class="col-12" id="DivContenido"></div>

</div>
</div>
</div>


  <!---------- MODAL ----------> 
  <div class="modal fade" id="Modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content" id="DivModalMediciones">
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