<?php
require('../../../app/help.php');

$id = $_GET['id'];

$sqlPV = "SELECT * FROM op_rh_vacaciones_pago WHERE id = '".$id."' ";
$resultPV = mysqli_query($con, $sqlPV);
while($rowPV = mysqli_fetch_array($resultPV, MYSQLI_ASSOC)){
$NomMes = nombremes($rowPV['mes']);
$NomYear = $rowPV['year'];
}

function Personal($idPersonal,$con)
{
$sql = "SELECT id, nombre_completo, puesto, fecha_ingreso FROM op_rh_personal WHERE id = '".$idPersonal."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$Nombre = $row['nombre_completo'];
$Fecha = $row['fecha_ingreso']; 
$Puesto = Puesto($row['puesto'],$con);
}
$array = array('Nombre' => $Nombre, 'Fecha' => $Fecha, 'Puesto' => $Puesto);

return $array;
}

function Puesto($idPuesto,$con){
$sql = "SELECT puesto FROM op_rh_puestos WHERE id = '".$idPuesto."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$Puesto = $row['puesto'];
}
return $Puesto;
}

function PersonalFirma($idusuario,$con){
$sql = "SELECT nombre FROM tb_usuarios WHERE id = '".$idusuario."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$nombre = $row['nombre'];
}
return $nombre;
}
?>
<div class="modal-header">
<h5 class="modal-title">Detalle pago de vacaciones</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">

<div class="row">
<div class="col-12 mb-3">
<span class="badge rounded-pill tables-bg float-end" style="font-size: 13px"><?=$NomMes;?> <?=$NomYear;?></span>
</div>
</div>

<div class="table-responsive"> 
<table class="table table-sm table-bordered">
	<thead class="tables-bg">
		<tr>
			<th class="align-middle">Nombre</th>
			<th class="align-middle">Puesto</th>
			<th class="align-middle">Fecha ingreso</th>
			<th class="align-middle">Años laborales</th>
			<th class="align-middle">Días vacaciones</th>
		</tr>
	</thead>

	<tbody>
	<?php 
	$sql = "SELECT * FROM op_rh_vacaciones_pago_detalle WHERE id_vacaciones_pago = '".$id."' ";
	$result = mysqli_query($con, $sql);
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
	$Personal = Personal($row['id_personal'],$con);

	echo '<tr>
	<td class="align-middle">'.$Personal['Nombre'].'</td>
	<td class="align-middle">'.$Personal['Puesto'].'</td>
	<td class="align-middle">'.FormatoFecha($Personal['Fecha']).'</td>
	<td class="align-middle">'.$row['year'].' años</td>
	<td class="align-middle">'.$row['dias'].' días</td>
	</tr>';
	}

	?>
	</tbody>
</table>
</div>

<div class="mt-2 mb-1"><b>Firmas:</b></div>

<div class="row ">

<?php

$sql_firma = "SELECT * FROM op_rh_vacaciones_pago_firma WHERE id_pago = '".$id."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){

$explode = explode(' ', $row_firma['fecha']);

if($row_firma['tipo_firma'] == "A"){
$TipoFirma = "NOMBRE Y FIRMA DE AUTORIZACIÓN";
$Detalle = '<div class="border-bottom text-center p-2" style="font-size: 0.9em;"><small>El pedido de limpieza se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';


}

echo '<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">';
echo '<div class="border p-3">';
echo '<div class="mt-2 mb-2 text-center">'.PersonalFirma($row_firma['id_usuario'],$con).'</div>';
echo $Detalle;
echo '<h6 class="mt-2 text-secondary text-center">'.$TipoFirma.'</h6>';
echo '</div>';
echo '</div>';

}

?> 
</div>

</div>

