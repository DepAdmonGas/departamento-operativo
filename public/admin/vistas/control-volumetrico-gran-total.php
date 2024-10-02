<?php
require('../../../app/help.php');

$IdReporte = $_GET['IdReporte'];
$idEstacion = $_GET['idEstacion'];

$sql_lista = "SELECT * FROM op_control_volumetrico_prefijos WHERE id_mes = '".$IdReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
$suma = 0;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$serie = $row_lista['serie'];

if($serie != "RL" AND $serie != "S" AND $serie != "K" AND $serie != "CP"){
$total = $row_lista['total'];    
}else{
$total = 0;  
}
$suma = $suma + $total;
}

$sql_lista = "SELECT * FROM op_control_volumetrico_resumen WHERE id_mes = '".$IdReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
$GTdato3 = 0;
$GTdato4 = 0;
$GTdato5 = 0;
$GTdato6 = 0;
$GTdato7 = 0;
$GTdato8 = 0;
$GTdato9 = 0;
$GTdato10 = 0;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$producto = $row_lista['producto'];
$dato1 = $row_lista['dato1'];

if ($row_lista['dato2'] == 0) {
$dato2 = "";
$Diferencia1 = "";
}else{
$dato2 = $row_lista['dato2'];
$Diferencia1 = $dato1 - $dato2;
}

$dato3 = $row_lista['dato3'];
$dato4 = $row_lista['dato4'];
$dato5 = $row_lista['dato5'];
$dato6 = $row_lista['dato6'];
$dato7 = $row_lista['dato7'];
$dato8 = $row_lista['dato8'];
$dato9 = $row_lista['dato9'];
$dato10 = $row_lista['dato10'];
$comentario = $row_lista['comentario'];

if ($producto == "G SUPER") {
$bgproducto = "bg-super";
}else if ($producto == "G PREMIUM") {
$bgproducto = "bg-premium";
}else if ($producto == "G DIESEL") {
$bgproducto = "bg-diesel";
}


$Diferencia2 = $dato3 - $dato4;
$Diferencia3 = $dato5 - $dato6;
$Diferencia4 = $dato7 - $dato8;
$Diferencia5 = $dato9 - $dato10;

if( is_numeric($Diferencia1) AND ($Diferencia1 >= 0) ){
$color1 = "text-black";
}else{
$color1 = "text-danger";
}

if( is_numeric($Diferencia2) AND ($Diferencia2 >=0) ){
$color2 = "text-black";
}else{
$color2 = "text-danger";
}

if( is_numeric($Diferencia3) AND ($Diferencia3 >=0) ){
$color3 = "text-black";
}else{
$color3 = "text-danger";
}

if( is_numeric($Diferencia4) AND ($Diferencia4 >=0) ){
$color4 = "text-black";
}else{
$color4 = "text-danger";
}

if( is_numeric($Diferencia5) AND ($Diferencia5 >=0) ){
$color5 = "text-black";
}else{
$color5 = "text-danger";
}

$GTdato3 = $GTdato3 + $dato3;
$GTdato4 = $GTdato4 + $dato4;
$GTdato5 = $GTdato5 + $dato5;
$GTdato6 = $GTdato6 + $dato6;
$GTdato7 = $GTdato7 + $dato7;
$GTdato8 = $GTdato8 + $dato8;
$GTdato9 = $GTdato9 + $dato9;
$GTdato10 = $GTdato10 + $dato10;
} 

    function totalaceites($IdReporte,$noaceite, $con){

    $sql_listaaceite = "SELECT * FROM op_corte_dia WHERE id_mes = '".$IdReporte."' ";
    $result_listaaceite = mysqli_query($con, $sql_listaaceite);
    while($row_listaaceite = mysqli_fetch_array($result_listaaceite, MYSQLI_ASSOC)){
      $id = $row_listaaceite['id'];

       $sql_listatotal = "SELECT * FROM op_aceites_lubricantes WHERE idreporte_dia = '".$id."' AND id_aceite = '".$noaceite."' LIMIT 1 ";
    $result_listatotal = mysqli_query($con, $sql_listatotal);
    while($row_listatotal = mysqli_fetch_array($result_listatotal, MYSQLI_ASSOC)){
      $cantidad = $cantidad + $row_listatotal['cantidad'];


    }

    }

    return $cantidad;

    }

function Aceites($IdReporte,$con){

    $sql_listaaceites = "SELECT * FROM op_aceites_lubricantes_reporte WHERE id_mes = '".$IdReporte."' ";
    $result_listaaceites = mysqli_query($con, $sql_listaaceites);
    while($row_listaaceites = mysqli_fetch_array($result_listaaceites, MYSQLI_ASSOC)){
    $noaceite = $row_listaaceites['id_aceite'];
    $preciou = $row_listaaceites['precio'];
    $totalaceites = totalaceites($IdReporte, $noaceite, $con);

    $Total = $preciou * $totalaceites;
    $TotAceites = $TotAceites + $totalaceites;
    $Grantotal = $Grantotal + $Total;
    }	

    $array = array('TotAceites' => $TotAceites, 'Grantotal' => $Grantotal);

    return $array;
}


//---------- SUBTOTAL GASOLINA ----------
$sql_lista = "SELECT * FROM op_control_volumetrico_prefijos WHERE id_mes = '".$IdReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
$SumGasolina = 0;
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
 
$SumGasolina = $SumGasolina + $gasolina;
}

 
//$Aceites = Aceites($IdReporte,$con);
//$ResumenAceite = $Aceites['Grantotal'];
//$GRANTOTAL = $GTdato10 + $ResumenAceite;

$Resultado = $GTdato9 - $SumGasolina ;



echo '<div class="border p-2"><div class="text-center"><h5>TOTAL : $ '.number_format($Resultado,2).'</h5></div></div>';   