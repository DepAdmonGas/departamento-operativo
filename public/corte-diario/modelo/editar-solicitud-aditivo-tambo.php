<?php
require('../../../app/help.php');

$valor = $_POST['valor'];
$idReporte = $_POST['idReporte'];
$posicion = $_POST['posicion'];
$id = $_POST['id'];

$sql_lista = "SELECT * FROM op_solicitud_aditivo WHERE id = '".$idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$idAditivo = $row_lista['id'];
}

function Resultado($idTambo,$idReporte,$con){

$sql_lista = "SELECT * FROM op_solicitud_aditivo WHERE id = '".$idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$tipocambio = $row_lista['tipo_cambio'];
}

$sql_aditivo = "SELECT * FROM op_solicitud_aditivo_tambo WHERE id_reporte = '".$idReporte."' ";
$result_aditivo = mysqli_query($con, $sql_aditivo);
$numero_aditivo = mysqli_num_rows($result_aditivo);
while($row_aditivo = mysqli_fetch_array($result_aditivo, MYSQLI_ASSOC)){
$GTKilos = $row_aditivo['cantidad'] * $row_aditivo['kilogramo'];
$GTDolares = $GTKilos * $row_aditivo['precio_kilogramo'];
$SubtotalDolares = $SubtotalDolares + $GTDolares;
}	

$sql_tambo = "SELECT * FROM op_solicitud_aditivo_tambo WHERE id = '".$idTambo."' ";
$result_tambo = mysqli_query($con, $sql_tambo);
$numero_tambo = mysqli_num_rows($result_tambo);
while($row_tambo = mysqli_fetch_array($result_tambo, MYSQLI_ASSOC)){
$totalkilogramos = $row_tambo['cantidad'] * $row_tambo['kilogramo'];
$totaldolares = $totalkilogramos * $row_tambo['precio_kilogramo'];
}

  $IVA = $SubtotalDolares * 0.16;
  $TotalPagar = $SubtotalDolares + $IVA;
  $Pesos = $tipocambio * $TotalPagar; 

		$retur = array(
		"estado" => 1,
		 "totalkilogramos" => $totalkilogramos,
		 "totaldolares" => number_format($totaldolares,2),
		 "SubtotalDolares" => number_format($SubtotalDolares,2),
		 "IVA" => number_format($IVA,2),
		 "TotalPagar" => number_format($TotalPagar,2),
		 "Pesos" => number_format($Pesos,2),
		);

return $retur;
 }

if($posicion == 1){
$sql = "UPDATE op_solicitud_aditivo_tambo SET cantidad = '".$valor."' WHERE id = '".$id."' ";
if (mysqli_query($con, $sql)) {
$return = 1;
} else {
$return = 0;
}
}else if($posicion == 2){
$sql = "UPDATE op_solicitud_aditivo_tambo SET precio_kilogramo = '".$valor."' WHERE id = '".$id."' ";
if (mysqli_query($con, $sql)) {
$return = 1;
} else {
$return = 0;
}
}else if($posicion == 8){
$sql = "UPDATE op_solicitud_aditivo SET tipo_cambio = '".$valor."' WHERE id = '".$idReporte."' ";
if (mysqli_query($con, $sql)) {
$return = 1;
} else {
$return = 0;
}
}

if($return == 1){

if($posicion == 8){
$idTambo = $idAditivo;	
}else{
$idTambo = $id;	
}

$array = Resultado($idTambo,$idReporte,$con);
echo json_encode($array);
}else{
$array = 0;	
echo $retur = array(
		"estado" => 0,
		 "totalkilogramos" => 0,
		 "totaldolares" => 0,
		 "SubtotalDolares" => 0,
		 "IVA" => 0,
		 "TotalPagar" => 0,
		 "Pesos" => 0,
		);
}



//------------------
mysqli_close($con);
//------------------
?>