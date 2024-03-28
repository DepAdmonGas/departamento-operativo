<?php
require('../../../app/help.php');

$GET_idReporte = $_GET['idReporte'];

$sql_lista = "SELECT * FROM op_refacciones_transaccion WHERE id = '".$GET_idReporte."' ORDER BY id DESC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$status = $row_lista['estado'];
$NomRefaccion = Refaccion($row_lista['id_refaccion'],$con);
$Estacion = Estacion($row_lista['id_estacion'],$con);
$EstacionReceptora = Estacion($row_lista['id_estacion_receptora'],$con);
$NomRefaccionEntra = Refaccion($row_lista['id_refaccion_receptora'],$con);

$explode = explode(" ", $row_lista['fecha']);
$Fecha = FormatoFecha($explode[0]);
$Hora = date('g:i a', strtotime($explode[1]));

$observaciones = $row_lista['observaciones'];
}

function Refaccion($idRefaccion,$con){
$sql = "SELECT nombre FROM op_refacciones WHERE id = '".$idRefaccion."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$nombre = $row['nombre'];
}
return $nombre;
}

function Estacion($idEstacion,$con){
$sql = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$estacion = $row['localidad'];
}

return $estacion;
}

function Personal($idusuario,$con){
$sql = "SELECT nombre FROM tb_usuarios WHERE id = '".$idusuario."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$nombre = $row['nombre'];
}
return $nombre;
} 

function FirmaSC($idReporte,$tipoFirma,$con){
$sql_lista = "SELECT * FROM op_refacciones_transaccion_firma WHERE id_reporte = '".$idReporte."' AND tipo_firma = '".$tipoFirma."' ";
$result_lista = mysqli_query($con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);
}


?>
<div class="modal-header">
<h5 class="modal-title">Detalle de la Transacción</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

<div class="border p-3 mb-2">
<h6>Fecha y hora:</h6>
<hr>
 <?=$Fecha.', '.$Hora;?>
</div>

<div class="row">

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">

 <div class="border p-3 mb-2">
 <h6>Estación proveedora:</h6>
 <?=$Estacion;?>
 </div>

 <div class="border p-3 mb-2">
 <h6>Refacción que sale:</h6>
 <?=$NomRefaccion;?>
 </div>

  </div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">

 <div class="border p-3 mb-2">
 <h6>Estación receptora:</h6>
 <?=$EstacionReceptora;?>
 </div>

 <div class="border p-3 mb-2">
 <h6>Refacción que entra:</h6>
 <?=$NomRefaccionEntra;?>
 </div>


  </div>
</div>

 <div class="border p-3 mb-2">
 <h6>Observación y/o motivo:</h6>
 <?=$observaciones;?>
 </div>

 <hr>

 <div class="row">
 <?php

$sql_firma = "SELECT * FROM op_refacciones_transaccion_firma WHERE id_reporte = '".$GET_idReporte."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){

$explode = explode(' ', $row_firma['fecha']);

if($row_firma['tipo_firma'] == "A"){
$TipoFirma = "Realizo Responsable de almacen";
$Detalle = '<div class="border p-1 text-center"><img src="'.RUTA_IMG_Firma.$row_firma['firma'].'" width="70%"></div>';


}else if($row_firma['tipo_firma'] == "B"){
$TipoFirma = "Vo.Bo Dep. de Mantenimiento";
$Detalle = '<div class="border-bottom text-center p-2"><small>La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';


}else if($row_firma['tipo_firma'] == "C"){
$TipoFirma = "Vo.Bo Gerente Operativo";
$Detalle = '<div class="border-bottom text-center p-2"><small>La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
}

echo '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">';
echo '<div class="border p-3">';
echo '<h6 class="mt-2 text-secondary text-center">'.$TipoFirma.'</h6>';
echo $Detalle;
echo '<div class="text-center mt-2">'.Personal($row_firma['id_usuario'],$con).' </div>';
echo '</div>';
echo '</div>';
}

?> 
</div>

</div>
