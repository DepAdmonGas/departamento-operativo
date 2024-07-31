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
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

<div class="row">

<div class="col-12 mb-2"><h6>Fecha y hora:</h6><?=$Fecha.', '.$Hora;?></div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
<h6>Estación proveedora:</h6>
<?=$Estacion;?>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
 <h6>Refacción que sale:</h6>
 <?=$NomRefaccion;?>
 </div>


  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
 <h6>Estación receptora:</h6>
 <?=$EstacionReceptora;?>
 </div>

 <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
 <h6>Refacción que entra:</h6>
 <?=$NomRefaccionEntra;?>
 </div>


 <div class="col-12 mb-2"> 
<h6>Observación y/o motivo:</h6>
 <?=$observaciones;?>
 </div>

 </div>

 <hr>

 <div class="row">
 <?php

$sql_firma = "SELECT * FROM op_refacciones_transaccion_firma WHERE id_reporte = '".$GET_idReporte."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){

if($row_firma['tipo_firma'] == "A"){
$TipoFirma = "Realizo Responsable de almacen";
$Detalle = '<div class="border-0 p-2 text-center"><img src="'.RUTA_IMG_Firma.$row_firma['firma'].'" width="100%"></div>';


}else if($row_firma['tipo_firma'] == "B"){
$TipoFirma = "Vo.Bo Dep. de Mantenimiento";
$Detalle = '<div class="text-center p-2"><small>La solicitud de cheque se firmó por un medio electrónico.</small></div>';


}else if($row_firma['tipo_firma'] == "C"){
$TipoFirma = "Vo.Bo Gerente Operativo";
$Detalle = '<div class="text-center p-2"><small>La solicitud de cheque se firmó por un medio electrónico.</small></div>';
}

echo '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-2">
<div class="table-responsive">
<table class="custom-table" style="font-size: 12.5px;" width="100%">
<thead class="tables-bg">
<tr> <th class="align-middle text-center">'.$TipoFirma.'</th> </tr>
</thead>
<tbody>

<tr class="no-hover2">
<th class="align-middle text-center bg-light">'.$Detalle.'</th>
</tr>

<tr class="no-hover2">
<th class="align-middle text-center bg-light">'.Personal($row_firma['id_usuario'],$con).'</th>
</tr>

</tbody>
</table>
</div>';
}

?> 
</div>

</div>
