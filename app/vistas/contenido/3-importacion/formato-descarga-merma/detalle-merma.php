<?php
require 'app/vistas/contenido/header.php';
 
$sql_lista = "SELECT * FROM op_descarga_tuxpa WHERE id = '" . $GET_idReporte . "' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
$id = $row_lista['id'];
$folio = $row_lista['folio']; 

$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosEstacion($row_lista['id_estacion']);
$Estacion = $datosEstacion['nombre'];

$fechallegada = FormatoFecha($row_lista['fecha_llegada']);
$horallegada = date("g:i a", strtotime($row_lista['hora_llegada']));

$datosUsuario = $ClassHerramientasDptoOperativo->obtenerDatosUsuario($row_lista['id_usuario']);
$Personal = $datosUsuario['nombre'];

$producto = $row_lista['producto'];
$sellos = $row_lista['sellos'];

if($sellos == "NO"){
$checkSI = "";
$checkNO = "checked";
}else{
$checkSI = "checked";
$checkNO = "";
}
 
$detuvoventa = $row_lista['detuvo_venta'];

if($detuvoventa == "NO"){
$V_checkSI = "";
$V_checkNO = "checked";
}else{
$V_checkSI = "checked";
$V_checkNO = "";
}


$operador = $row_lista['operador'];
$transportista = $row_lista['transportista'];

$nofactura = $row_lista['no_factura'];
$inventarioinicial = $row_lista['inventario_inicial'];
$nice = $row_lista['nice'];
$inventariofinal = $row_lista['inventario_final'];
$metrocontador = $row_lista['metro_contador'];
$metrocontador20 = $row_lista['metro_contador20'];
$nofacturaremision = $row_lista['no_factura_remision'];
$litros = $row_lista['litros'];
$preciolitro = $row_lista['precio_litro'];
$unidad = $row_lista['unidad'];
$cuentalitros = $row_lista['cuenta_litros'];

$valortolerancia = $litros * .55 / 100;
$tolerancia = round($valortolerancia);
$merma = $litros - $cuentalitros;
$calculaNC = $merma - $tolerancia;
$NC = number_format($calculaNC * $preciolitro, 2);

$extensionFactura = pathinfo($nofactura, PATHINFO_EXTENSION);
$extensionInvInicial = pathinfo($inventarioinicial, PATHINFO_EXTENSION);
$extensionNice = pathinfo($nice, PATHINFO_EXTENSION);
$extensionInvFinal = pathinfo($inventariofinal, PATHINFO_EXTENSION);
$extensionmetrocontador = pathinfo($metrocontador, PATHINFO_EXTENSION);
$extensionmetrocontador20 = pathinfo($metrocontador20, PATHINFO_EXTENSION);


if($extensionFactura == "pdf") {
$facturaElement = '<iframe class="border-0 mt-0 mb-0" src="' . RUTA_ARCHIVOS . 'tuxpan/' . $nofactura . '" width="100%" height="400px"></iframe>';
}else{
$facturaElement = '<img src="' . RUTA_ARCHIVOS . 'tuxpan/' . $nofactura . '" width="100%">';
}

if($extensionInvInicial == "pdf") {
$invInicialElement = '<iframe class="border-0 mt-0 mb-0" src="' . RUTA_ARCHIVOS . 'tuxpan/' . $inventarioinicial . '" width="100%" height="400px"></iframe>';
}else{
$invInicialElement = '<img src="' . RUTA_ARCHIVOS . 'tuxpan/' . $inventarioinicial . '" width="100%">';
}

if($extensionNice == "pdf") {
$niceElement = '<iframe class="border-0 mt-0 mb-0" src="' . RUTA_ARCHIVOS . 'tuxpan/' . $nice . '" width="100%" height="400px"></iframe>';
} else {
$niceElement = '<img src="' . RUTA_ARCHIVOS . 'tuxpan/' . $nice . '" width="100%">';
}

if ($extensionInvFinal == "pdf") {
$invFinalElement = '<iframe class="border-0 mt-0 mb-0" src="' . htmlspecialchars(RUTA_ARCHIVOS . 'tuxpan/' . $inventariofinal, ENT_QUOTES, 'UTF-8') . '" width="100%" height="400px"></iframe>';
} else {
$invFinalElement = '<img src="' . htmlspecialchars(RUTA_ARCHIVOS . 'tuxpan/' . $inventariofinal, ENT_QUOTES, 'UTF-8') . '" width="100%">';
}

if ($extensionmetrocontador == "pdf") {
$metroElement = '<iframe class="border-0 mt-0 mb-0" src="' . RUTA_ARCHIVOS . 'tuxpan/' . $metrocontador . '" width="100%" height="400px"></iframe>';
} else {
$metroElement = '<img src="' . RUTA_ARCHIVOS . 'tuxpan/' . $metrocontador . '" width="100%">';
}

if ($extensionmetrocontador20 == "pdf") {
$metro20Element = '<iframe class="border-0 mt-0 mb-0" src="' . RUTA_ARCHIVOS . 'tuxpan/' . $metrocontador20 . '" width="100%" height="400px"></iframe>';
} else {
$metro20Element = '<img src="' . RUTA_ARCHIVOS . 'tuxpan/' . $metrocontador20 . '" width="100%">';
}

}


if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"){
$ocultarOp = "";

}else{
$ocultarOp = "d-none";
      
} 

?>

<script type="text/javascript">

$(document).ready(function ($) {
$(".LoaderPage").fadeOut("slow");

});


function EditarDM(idReporte) {
window.location.href = "../descarga-tuxpan-editar/" + idReporte;
}

function Eliminar(idReporte) {

var parametros = {
"idReporte": idReporte,
"accion":"elimina-formato-merma"
};


alertify.confirm('',
function () {

$.ajax({
data: parametros,
//url: '../public/admin/modelo/eliminar-descarta-tuxpan.php',
url: '../app/controlador/3-importacion/controladorMerma.php',
type: 'post',
beforeSend: function () {
                
},                 
complete: function () {
                    
},
success: function (response) {
if (response == 1) {
history.back();
} else {
alertify.error('Error al eliminar la descarga');
}

}
});

},
function () {
}).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar la información seleccionada?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();

}

window.addEventListener('pageshow', function(event) {
if (event.persisted) {
window.location.reload();}
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

<div class="col-12">
<div class="cardAG">
<div class="border-0 p-3">

<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Formato de descarga de merma</a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase">  Detalle de formato</li>
</ol>
</div>

<div class="row">
<div class="col-9"><h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Detalle de formato</h3></div>
<div class="col-3 <?=$ocultarOp?>">
<div class="text-end">
<div class="dropdown d-inline ms-2">
<button type="button" class="btn dropdown-toggle btn-primary" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"> <i class="fa-solid fa-screwdriver-wrench"></i> </button>
<ul class="dropdown-menu">

<li onclick="EditarDM(<?= $GET_idReporte; ?>)">
<a class="dropdown-item pointer"><i class="fa-solid fa-pencil"></i> Editar</a>
</li>

<li onclick="Eliminar(<?= $GET_idReporte; ?>)"> 
<a class="dropdown-item pointer"><i class="fa-solid fa-trash-can"></i> Eliminar</a>
</li>

</ul>

</div>
</div>
</div>

</div>
<hr>

<div class="row">

<div class="col-12 col-sm-1 mb-3">
<div class="text-secondary titulos mb-1"><small>Folio:</small></div>
<input type="text" class="form-control" disabled value="00<?= $folio; ?>">
</div>

<div class="col-12 col-sm-3 mb-3">
<div class="text-secondary titulos mb-1"><small>Estación de descarga:</small></div>
<select class="form-select" disabled>
<option><?= $Estacion; ?></option>
</select>
</div>

<div class="col-12 col-sm-3 mb-3">
<div class="text-secondary titulos mb-1"><small>Responsable de la estación:</small></div>
<select class="form-select" disabled>
<option><?= $Personal; ?></option>
</select>
</div>

<div class="col-12 col-sm-5 mb-3">
<div class="text-secondary titulos mb-1"><small>Fecha y hora de llegada de full:</small></div>
<input type="text" class="form-control" disabled value="<?= $fechallegada; ?>, <?= $horallegada; ?>">
</div>

<div class="col-12 col-sm-3 mb-3">
<div class="text-secondary titulos mb-1"><small>Productos recibido:</small></div>
<select class="form-select" disabled>
<option><?= $producto; ?></option>
</select>
</div>

<div class="col-12 col-sm-3 mb-3">
<div class="text-secondary titulos mb-1"><small>Numero Factura o Remisión:</small></div>
<input type="text" class="form-control" disabled value="<?=$nofacturaremision;?>">
</div>

<div class="col-12 col-sm-3 mb-3">
<div class="text-secondary titulos mb-1"><small>Litros:</small></div>
<input type="text" class="form-control" disabled value="<?=number_format($litros, 2)?>">
</div>

<div class="col-12 col-sm-3 mb-3">
<div class="text-secondary titulos mb-1"><small>Precio por litro:</small></div>
<input type="text" class="form-control" disabled value="<?=$preciolitro?>">
</div>

<div class="col-12 col-sm-3 mb-3">
<div class="text-secondary titulos mb-1"><small>Cuenta litro:</small></div>
<input type="text" class="form-control" disabled value="<?=$cuentalitros?>">
</div>

<div class="col-12 col-sm-3 mb-3">
<div class="text-secondary titulos mb-1"><small>Tolerancia:</small></div>
<input type="text" class="form-control" disabled value="<?=$tolerancia?>">
</div>

<div class="col-12 col-sm-3 mb-3">
<div class="text-secondary titulos mb-1"><small>Merma en Litros:</small></div>
<input type="text" class="form-control" disabled value="<?=$merma?>">
</div>

<div class="col-12 col-sm-3 mb-3">
<div class="text-secondary titulos mb-1"><small>N.C:</small></div>
<input type="text" class="form-control" disabled value="<?=$calculaNC?>">
</div>

<div class="col-12 col-sm-3 mb-3">
<div class="text-secondary titulos mb-1"><small>Importe N.C:</small></div>
<input type="text" class="form-control" disabled value="$<?=$NC?>">
</div>

<div class="col-12 col-sm-3 mb-3">
<div class="text-secondary titulos mb-1"><small>Unidad:</small></div>
<input type="text" class="form-control" disabled value="<?=$unidad?>">
</div>

<div class="col-12 col-sm-3 mb-3">
<div class="text-secondary titulos mb-1"><small>Nombre del operador de la unidad:</small></div>
<input type="text" class="form-control" disabled value="<?=$operador?>">
</div>

<div class="col-12 col-sm-3 mb-3">
<div class="text-secondary titulos mb-1"><small>Compañía de Transportista:</small></div>
<input type="text" class="form-control" disabled value="<?=$transportista?>">
</div>

<div class="col-12 col-sm-3 mb-3">
<div class="text-secondary mb-1">Sellos alterados:</div>

<div class="form-check">
    <input class="form-check-input" type="radio" style="width: 18px; height: 18px;margin-top: 4px;" <?=$checkSI?> disabled>
    <label class="form-check-label" style="margin-left: 10px;">SI</label>
</div>

<div class="form-check">
    <input class="form-check-input" type="radio" style="width: 18px; height: 18px;margin-top: 4px;" <?=$checkNO?> disabled>
    <label class="form-check-label"  style="margin-left: 10px;">NO</label>
</div>
</div>

<div class="col-12 col-sm-3 mb-3">
<div class="text-secondary mb-1">Se detuvo venta durante la descarga:</div>

<div class="form-check">
    <input class="form-check-input" type="radio" style="width: 18px; height: 18px;margin-top: 4px;" <?=$V_checkSI?> disabled>
    <label class="form-check-label" style="margin-left: 10px;">SI</label>
</div>

<div class="form-check">
    <input class="form-check-input" type="radio" style="width: 18px; height: 18px;margin-top: 4px;" <?=$V_checkNO?> disabled>
    <label class="form-check-label"  style="margin-left: 10px;">NO</label>
</div>
</div>

</div>

 
<div class="row">

<div class="col-12 col-sm-4 mb-3">
<div class="table-responsive">
<table id="tabla_bitacora" class="custom-table mt-2" style="font-size: 12.5px;" width="100%">
<thead class="title-table-bg">
<tr> <th class="align-middle text-center">Factura o Remisión:</th> </tr>
</thead>
<tbody>
<tr class="no-hover">
<th class="align-middle text-center bg-light"><?=$facturaElement?></th>
</tr>
</tbody>
</table>
</div>
</div>

<div class="col-12 col-sm-4 mb-3">
<div class="table-responsive">
<table id="tabla_bitacora" class="custom-table mt-2" style="font-size: 12.5px;" width="100%">
<thead class="title-table-bg">
<tr> <th class="align-middle text-center">Reporte de inventario Inicial con fecha y hora:</th> </tr>
</thead>
<tbody>
<tr class="no-hover">
<th class="align-middle text-center bg-light"><?=$invInicialElement?></th>
</tr>
</tbody>
</table>
</div>
</div>

<div class="col-12 col-sm-4 mb-3">
<div class="table-responsive">
<table id="tabla_bitacora" class="custom-table mt-2" style="font-size: 12.5px;" width="100%">
<thead class="title-table-bg">
<tr> <th class="align-middle text-center">Medida Nice:</th> </tr>
</thead>
<tbody>
<tr class="no-hover">
<th class="align-middle text-center bg-light"><?=$niceElement?></th>
</tr>
</tbody>
</table>
</div>
</div>

<div class="col-12 col-sm-4 mb-3">
<div class="table-responsive">
<table id="tabla_bitacora" class="custom-table mt-2" style="font-size: 12.5px;" width="100%">
<thead class="title-table-bg">
<tr> <th class="align-middle text-center">Reporte de inventario final con fecha y hora:</th> </tr>
</thead>
<tbody>
<tr class="no-hover">
<th class="align-middle text-center bg-light"><?=$invFinalElement?></th>
</tr>
</tbody>
</table>
</div>
</div>

<div class="col-12 col-sm-4 mb-3">
<div class="table-responsive">
<table id="tabla_bitacora" class="custom-table mt-2" style="font-size: 12.5px;" width="100%">
<thead class="title-table-bg">
<tr> <th class="align-middle text-center">Metro contador temperatura normal:</th> </tr>
</thead>
<tbody>
<tr class="no-hover">
<th class="align-middle text-center bg-light"><?=$metroElement?></th>
</tr>
</tbody>
</table>
</div>
</div>

<div class="col-12 col-sm-4 mb-3">
<div class="table-responsive">
<table id="tabla_bitacora" class="custom-table mt-2" style="font-size: 12.5px;" width="100%">
<thead class="title-table-bg">
<tr> <th class="align-middle text-center">Metro contador a 20 grados:</th> </tr>
</thead>
<tbody>
<tr class="no-hover">
<th class="align-middle text-center bg-light"><?=$metro20Element?></th>
</tr>
</tbody>
</table>
</div>
</div>

</div>

<hr>

<div class="row justify-content-md-center">
<?php
$sql_firma = "SELECT * FROM op_descarga_tuxpa_firma WHERE id_descarga = '" . $GET_idReporte . "' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
while ($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)) {

echo '<div class="col-12 col-sm-4 mb-3">
<div class="table-responsive">
<table id="tabla_bitacora" class="custom-table mt-2" style="font-size: 12.5px;" width="100%">
<thead class="title-table-bg">
<tr> <th class="align-middle text-center">Firma del '.$row_firma['tipo_firma'].' </th> </tr>
</thead>
<tbody>
<tr class="no-hover">
<th class="align-middle text-center bg-light"><img src="' . RUTA_IMG . 'firma-tuxpan/' . $row_firma['imagen_firma'] . '" width="100%"></th>
</tr>
</tbody>
</table>
</div>
</div>';


}
?>
</div>


</div>
</div>
</div>
</div>

<!---------- FUNCIONES - NAVBAR ---------->
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

</body>
</html>