<?php
require 'app/vistas/contenido/header.php';

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" ></script>
  <link rel="stylesheet" href="<?php echo RUTA_CSS ?>selectize.css">

<script type="text/javascript">

$(document).ready(function ($) {
$(".LoaderPage").fadeOut("slow");
ListaPivoteo(<?=$GET_idReporte?>);
});


function ListaPivoteo(idReporte) {
//$('#ListaPivoteo').load('../public/corte-diario/vistas/lista-pivoteo-detalle.php?idReporte=' + idReporte);
$('#ListaPivoteo').load('../app/vistas/contenido/3-importacion/pivoteo/lista-pivoteo-detalle.php?idReporte=' + idReporte);
}

function NuevoPivoteo(idReporte){
$('#Modal').modal('show');   
$('#DivContenido').load('../app/vistas/contenido/3-importacion/pivoteo/modal-formulario-pivoteo.php?idReporte=' + idReporte);  
} 

 
function Guardar(idReporte,idEstacion) {

let Producto = $('#Producto').val();
let Litros = $('#Litros').val();
let Tanque = $('#Tanque').val();
let TAD = $('#TAD').val();
let Unidad = $('#Unidad').val();
let Chofer = $('#Chofer').val();

if (Producto != "") {
$('#Producto').css('border', '');
if (Litros != "") {
$('#Litros').css('border', '');
if (Tanque != "") {
$('#Tanque').css('border', '');
if (TAD != "") {
$('#TAD').css('border', '');
if (Unidad != "") {
$('#Unidad').css('border', '');
if (Chofer != "") {
$('#Chofer').css('border', '');

var parametros = {
"idEstacion" :idEstacion,
"idReporte": idReporte,
"Producto": Producto,
"Litros": Litros,
"Tanque": Tanque,
"TAD": TAD,
"Unidad": Unidad,
"Chofer": Chofer,
"accion":"pivoteo-detalle"
};

$.ajax({
data: parametros,
//url: '../public/corte-diario/modelo/agregar-pivoteo-detalle.php',
url: '../app/controlador/3-importacion/controladorPivoteo.php',
type: 'post',
beforeSend: function () {

},
complete: function () {

},
success: function (response) {
if (response == 1) {
$('#Modal').modal('hide');   
ListaPivoteo(idReporte)
alertify.success('Pedido agregado exitosamente');

}else{
alertify.error('Error al agregar');
}

}
});

}else{
$('#Chofer').css('border', '2px solid #A52525');
}
}else{
$('#Unidad').css('border', '2px solid #A52525');
}
}else{
$('#TAD').css('border', '2px solid #A52525');
}
}else{
$('#Tanque').css('border', '2px solid #A52525');
}
}else{
$('#Litros').css('border', '2px solid #A52525');
}
}else{
$('#Producto').css('border', '2px solid #A52525');
}

}

function Finalizar(idReporte) {
var parametros = {
"idReporte": idReporte,
"accion":"finalizar-detalle"
};

$.ajax({
data: parametros,
//url: '../public/corte-diario/modelo/finalizar-pivoteo-detalle.php',
url: '../app/controlador/3-importacion/controladorPivoteo.php',
type: 'post',
beforeSend: function () {

},
complete: function () {

},
success: function (response) {
if (response == 1) {
history.back();
} else {
alertify.error('Error al finalizar el pedido');
}
}
});

}

function Eliminar(idReporte, id) {
var parametros = {
"id": id,
"accion" : "eliminar-factura"
};
        
alertify.confirm('',
function () {
$.ajax({
data: parametros,
//url: '../public/corte-diario/modelo/eliminar-pivoteo-detalle.php',
url: '../app/controlador/3-importacion/controladorPivoteo.php',
type: 'post',
beforeSend: function () {

},
complete: function () {

},
success: function (response) {
if (response == 1) {
ListaPivoteo(idReporte)
alertify.success('Pedido eliminado exitosamente');
} else {
alertify.error('Error al eliminar el pedido');
}
}
});
},
function () {
}).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar la información seleccionada?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();
}

//--------------------------------------------------
function ValidaLitros(e) {
let Litros = e.value;

if (Litros > 23000) {
$('#Tanque').val('Tanque 2');
} else {
$('#Tanque').val('Tanque 1');
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

<div class="col-12">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i></i> Pivoteo</a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase">Formulario Pivoteo</li>
</ol>
</div>

<div class="row">
<div class="col-xl-9 col-lg-9 col-md-6 col-sm-12"><h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Formulario Pivoteo</h3></div>
<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12"><button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="NuevoPivoteo(<?=$GET_idReporte?>)">
<span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
</div>

</div>
<hr>
</div>


<div class="col-12"> <div id="ListaPivoteo"></div> </div>
</div>

</div>

<!---------- MODAL ----------> 
<div class="modal fade" id="Modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content" id="DivContenido">
</div>
</div>
</div>

<!---------- FUNCIONES - NAVBAR ---------->
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

</body>
</html>


