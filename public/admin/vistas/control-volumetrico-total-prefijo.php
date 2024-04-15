<?php
require('../../../app/help.php');

$IdReporte = $_GET['IdReporte'];
$idEstacion = $_GET['idEstacion'];

$sql_lista = "SELECT * FROM op_control_volumetrico_prefijos WHERE id_mes = '".$IdReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
$SumGasolina = 0;
$SumRentas = 0;
$SumSodexo = 0;
$SumGTotal = 0;

$SumAutolavado = 0;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$serie = $row_lista['serie'];

if($serie != "K" AND $serie != "CP"){
$total = $row_lista['total'];	
}else{
$total = 0;	
}

if($serie != "RL" AND $serie != "S" AND $serie != "K" AND $serie != "CP" AND $serie != "CA"){
$gasolina = $row_lista['total'];	
}else{
$gasolina = 0;	
}
 
if($serie == "RL"){
$rentas = $row_lista['total'];	
}else{
$rentas = 0;	
}

if($serie == "S"){
$sodexo = $row_lista['total'];	
}else{
$sodexo = 0;	
}

if($serie == "AL"){
$autolavado = $row_lista['total'];	
}else{
$autolavado = 0;	
}


$SumGasolina = $SumGasolina + $gasolina;
$SumRentas = $SumRentas + $rentas;
$SumSodexo = $SumSodexo + $sodexo;
$SumGTotal = $SumGTotal + $total;

$SumAutolavado = $SumAutolavado + $autolavado;
}

echo '
<div class="border p-3 mb-3">
<div class="text-end">
Subtotal Gasolina: $ '.number_format($SumGasolina,2).'</br>
Subtotal Rentas: $ '.number_format($SumRentas,2).'</br>';

if($idEstacion == 2){
echo 'Subtotal Autolavado: $ '.number_format($SumAutolavado,2).'</br>';	
}


echo 'Subtotal Sodexo: $ '.number_format($SumSodexo,2).'</br>
<hr>
<b>Gran Total: $ '.number_format($SumGTotal,2).'</b>
</div>
</div> ';