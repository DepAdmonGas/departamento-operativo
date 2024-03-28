<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$year = $_GET['year'];

$sql_listaestacion = "SELECT id, nombre, producto_tres FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
$GDiesel = $row_listaestacion['producto_tres'];
}

function IdReporte($Session_IDEstacion,$GET_year,$con){
$sql_year = "SELECT id, id_estacion, year FROM op_corte_year WHERE id_estacion = '".$Session_IDEstacion."' AND year = '".$GET_year."' ";
$result_year = mysqli_query($con, $sql_year);
while($row_year = mysqli_fetch_array($result_year, MYSQLI_ASSOC)){
$idyear = $row_year['id'];
}
return $idyear;
}

$idReporte = IdReporte($idEstacion,$year,$con);

ValidaIF($idReporte,'G SUPER',1,$con);
ValidaIF($idReporte,'G PREMIUM',1,$con);

if($GDiesel != ""){
ValidaIF($idReporte,'G DIESEL',1,$con);
}

ValidaIF($idReporte,'Aceites y Lubricantes',1,$con);
if($Session_IDEstacion == 2){
ValidaIF($idReporte,'Autolavado',1,$con);
}
ValidaIF($idReporte,'Rentas',1,$con);
ValidaIF($idReporte,'IEPS',1,$con);

ValidaIF($idReporte,'Público en General',2,$con);
ValidaIF($idReporte,'Clientes crédito',2,$con);
ValidaIF($idReporte,'Monederos electronicos',2,$con);
ValidaIF($idReporte,'Facturas aceites y lubricantes',2,$con);
//ValidaIF($idReporte,'Rentas',2,$con);
ValidaIF($idReporte,'Clientes débito',2,$con);
ValidaIF($idReporte,'Ventas mostrador',2,$con);
ValidaIF($idReporte,'TPV',2,$con);
ValidaIF($idReporte,'Página WEB',2,$con);
ValidaIF($idReporte,'Clientes débito',2,$con);
//ValidaIF($idReporte,'Clientes anticipo',2,$con);

function ValidaIF($IdReporte,$detalle,$posicion,$con){

$sql = "SELECT * FROM op_ingresos_facturacion_contabilidad WHERE id_year = '".$IdReporte."' AND detalle = '".$detalle."' AND posicion = '".$posicion."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if ($numero == 0) {

$sql_insert = "INSERT INTO op_ingresos_facturacion_contabilidad  (
    id_year,
    detalle,
    posicion,
    enero,
    febrero,
    marzo,
    abril,
    mayo,
    junio,
    julio,
    agosto,
    septiembre,
    octubre,
    noviembre,
    diciembre
    )
    VALUES 
    (
    '".$IdReporte."',
    '".$detalle."',
    '".$posicion."',
    0,0,0,0,0,0,0,0,0,0,0,0  
    )";

 mysqli_query($con, $sql_insert);

}
}

//---------------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------------

function IdReporteMes($IdYear,$GET_mes,$con){
	$sql_mes = "SELECT id, id_year, mes FROM op_corte_mes WHERE id_year = '".$IdYear."' AND mes = '".$GET_mes."' ";
	 $result_mes = mysqli_query($con, $sql_mes);
	 while($row_mes = mysqli_fetch_array($result_mes, MYSQLI_ASSOC)){
	 $idmes = $row_mes['id'];
	 }
   return $idmes;
	 }
   
   UpdateIngresoFacturacion($idReporte,1,$con);
   UpdateIngresoFacturacion($idReporte,2,$con);
   UpdateIngresoFacturacion($idReporte,3,$con);
   UpdateIngresoFacturacion($idReporte,4,$con);
   UpdateIngresoFacturacion($idReporte,5,$con);
   UpdateIngresoFacturacion($idReporte,6,$con);
   UpdateIngresoFacturacion($idReporte,7,$con);
   UpdateIngresoFacturacion($idReporte,8,$con);
   UpdateIngresoFacturacion($idReporte,9,$con);
   UpdateIngresoFacturacion($idReporte,10,$con);
   UpdateIngresoFacturacion($idReporte,11,$con);
   UpdateIngresoFacturacion($idReporte,12,$con);
   
   function UpdateIngresoFacturacion($IdReporte,$mes,$con){
   
   $IdReporteMes = IdReporteMes($IdReporte,$mes,$con);
   
   $sql = "SELECT descripcion, total FROM op_control_volumetrico_prefijos WHERE id_mes = '".$IdReporteMes."' ";
   $result = mysqli_query($con, $sql);
   while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
   
   $descripcion = $row['descripcion'];
   $total = $row['total'];
   
if($descripcion == "PUBLICO EN GENERAL"){
$descripcion = "Público en General";
}
else if($descripcion == "CLIENTES DE CREDITO" || $descripcion == "Facturas de Crédito"){
$descripcion = "Clientes crédito";
}
else if($descripcion == "MONEDEROS"){
$descripcion = "Monederos electronicos";
}
else if($descripcion == "FACTURA DE ACEITES"){
$descripcion = "Facturas aceites y lubricantes";
}
else if($descripcion == "RENTAS"){
$descripcion = "Rentas";
}
else if($descripcion == "CLIENTES DE DEBITO"){
$descripcion = "Clientes débito";
}
else if($descripcion == "VENTA MOSTRADOR"){
$descripcion = "Ventas mostrador";
}
else if($descripcion == "TPV"){
$descripcion = "TPV";
}
else if($descripcion == "WEB"){
$descripcion = "Página WEB";
}
else if($descripcion == "CLIENTES ANTICIPO"){
$descripcion = "Clientes anticipo";
}


  $Mes = strtolower(nombremes($mes));

  $sql_edit3 = "UPDATE op_ingresos_facturacion_contabilidad SET 
    $Mes = '".$total."'
    WHERE id_year ='".$IdReporte."' AND detalle = '".$descripcion."' ";
   
   if(mysqli_query($con, $sql_edit3)){}
   
   }
   
   }

  //-------------------------------------------------------------------------------------------------
UpdateProductoIF($idReporte,1,$con);
UpdateProductoIF($idReporte,2,$con);
UpdateProductoIF($idReporte,3,$con);
UpdateProductoIF($idReporte,4,$con);
UpdateProductoIF($idReporte,5,$con);
UpdateProductoIF($idReporte,6,$con);
UpdateProductoIF($idReporte,7,$con);
UpdateProductoIF($idReporte,8,$con);
UpdateProductoIF($idReporte,9,$con);
UpdateProductoIF($idReporte,10,$con);
UpdateProductoIF($idReporte,11,$con);
UpdateProductoIF($idReporte,12,$con);

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

function UpdateProductoIF($IdReporte,$mes,$con){

$IdReporteMes = IdReporteMes($IdReporte,$mes,$con);
$Mes = strtolower(nombremes($mes));

$sql_lista = "SELECT * FROM op_control_volumetrico_resumen WHERE id_mes = '".$IdReporteMes."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
  $id = $row_lista['id'];
  $producto = $row_lista['producto'];
  $dato10 = $row_lista['dato10'];

  $sql_edit1 = "UPDATE op_ingresos_facturacion_contabilidad SET 
    $Mes = '".$dato10."'
    WHERE id_year ='".$IdReporte."' AND detalle = '".$producto."' ";

if(mysqli_query($con, $sql_edit1)){}

}

    $sql_listaaceites = "SELECT * FROM op_aceites_lubricantes_reporte WHERE id_mes = '".$IdReporteMes."' ";
    $result_listaaceites = mysqli_query($con, $sql_listaaceites);
    while($row_listaaceites = mysqli_fetch_array($result_listaaceites, MYSQLI_ASSOC)){
    $noaceite = $row_listaaceites['id_aceite'];
    $preciou = $row_listaaceites['precio'];
    $totalaceites = totalaceites($IdReporteMes, $noaceite, $con);

    $Total = $preciou * $totalaceites;
    $TotAceites = $TotAceites + $totalaceites;
    $Grantotal = $Grantotal + $Total;
    }

    $sql_edit2 = "UPDATE op_ingresos_facturacion_contabilidad SET 
    $Mes = '".$Grantotal."'
    WHERE id_year ='".$IdReporte."' AND detalle = 'Aceites y Lubricantes' ";

  if(mysqli_query($con, $sql_edit2)){}

}

//--------------------------------------------------------------------------------

$sqlP1 = "SELECT * FROM op_ingresos_facturacion_contabilidad WHERE id_year = '".$idReporte."' AND posicion = 1";
$resultP1 = mysqli_query($con, $sqlP1);
$numeroP1 = mysqli_num_rows($resultP1);

$sqlP2 = "SELECT * FROM op_ingresos_facturacion_contabilidad WHERE id_year = '".$idReporte."' AND posicion = 2";
$resultP2 = mysqli_query($con, $sqlP2);
$numeroP2 = mysqli_num_rows($resultP2);
?>

<div class="cardAG p-3">
<h5><?=$estacion;?></h5>
<hr>


<div class="border p-3 mb-3">

   <div class="row">

   <div class="col-10">
   <b>Comparativo de Facturación</b>
   </div>
            
   <div class="col-2">
  <img src="<?=RUTA_IMG_ICONOS;?>control-despacho.png" width="24px" class="ml-2 float-end pointer" onclick="Entregables(<?=$idReporte;?>)">
   </div>

   </div>

<hr>

<div class="table-responsive">
<table class="table table-sm table-bordered mb-0" style="font-size: .8em;">
<thead class="tables-bg">
	<tr>
	<th class="align-middle text-center">Cortes diarios</th>
	<th class="align-middle text-end" width="110px">Enero</th>
	<th class="align-middle text-end" width="110px">Febrero</th>
	<th class="align-middle text-end" width="110px">Marzo</th>
	<th class="align-middle text-end" width="110px">Abril</th>
	<th class="align-middle text-end" width="110px">Mayo</th>
	<th class="align-middle text-end" width="110px">Junio</th>
	<th class="align-middle text-end" width="110px">Julio</th>
	<th class="align-middle text-end" width="110px">Agosto</th>
	<th class="align-middle text-end" width="110px">Septiembre</th>
	<th class="align-middle text-end" width="110px">Octubre</th>
	<th class="align-middle text-end" width="110px">Noviembre</th>
	<th class="align-middle text-end" width="110px">Diciembre</th>
	<th class="align-middle text-end">Total Ejercicio</th>
	</tr>
</thead>
<tbody>
<?php
while($rowP1 = mysqli_fetch_array($resultP1, MYSQLI_ASSOC)){
$id = $rowP1['id'];

if($rowP1['enero'] == 0){
$enero1 = "";	
}else{
$enero1 = $rowP1['enero'];
}

if($rowP1['febrero'] == 0){
$febrero1 = "";	
}else{
$febrero1 = $rowP1['febrero'];
}

if($rowP1['marzo'] == 0){
$marzo1 = "";	
}else{
$marzo1 = $rowP1['marzo'];
}

if($rowP1['abril'] == 0){
$abril1 = "";	
}else{
$abril1 = $rowP1['abril'];
}

if($rowP1['mayo'] == 0){
$mayo1 = "";	
}else{
$mayo1 = $rowP1['mayo'];
}

if($rowP1['junio'] == 0){
$junio1 = "";	
}else{
$junio1 = $rowP1['junio'];
}

if($rowP1['julio'] == 0){
$julio1 = "";	
}else{
$julio1 = $rowP1['julio'];
}

if($rowP1['agosto'] == 0){
$agosto1 = "";	
}else{
$agosto1 = $rowP1['agosto'];
}

if($rowP1['septiembre'] == 0){
$septiembre1 = "";	
}else{
$septiembre1 = $rowP1['septiembre'];
}

if($rowP1['octubre'] == 0){
$octubre1 = "";	
}else{
$octubre1 = $rowP1['octubre'];
}

if($rowP1['noviembre'] == 0){
$noviembre1 = "";	
}else{
$noviembre1 = $rowP1['noviembre'];
}

if($rowP1['diciembre'] == 0){
$diciembre1 = "";	
}else{
$diciembre1 = $rowP1['diciembre'];
}

if($rowP1['detalle'] == 'Rentas'){

}else{

if($rowP1['detalle'] == 'Autolavado'){

}else{

$totalEj1 = $rowP1['enero'] + $rowP1['febrero'] + $rowP1['marzo'] + $rowP1['abril'] + $rowP1['mayo'] + $rowP1['junio'] + $rowP1['julio'] + $rowP1['agosto'] + $rowP1['septiembre'] + $rowP1['octubre'] + $rowP1['noviembre'] + $rowP1['diciembre'];

$TCE1 = $TCE1 + $rowP1['enero'];
$TCF1 = $TCF1 + $rowP1['febrero'];
$TCM1 = $TCM1 + $rowP1['marzo'];
$TCA1 = $TCA1 + $rowP1['abril'];
$TCMY1 = $TCMY1 + $rowP1['mayo'];
$TCJN1 = $TCJN1 + $rowP1['junio'];
$TCJL1 = $TCJL1 + $rowP1['julio'];
$TCAS1 = $TCAS1 + $rowP1['agosto'];
$TCS1 = $TCS1 + $rowP1['septiembre'];
$TCO1 = $TCO1 + $rowP1['octubre'];
$TCN1 = $TCN1 + $rowP1['noviembre'];
$TCD1 = $TCD1 + $rowP1['diciembre'];

$TCTEJ1 = $TCTEJ1 + $totalEj1;

}
}

?>
<tr>
<td><?=$rowP1['detalle'];?></td>
<td class="align-middle text-end">$ <?=number_format($enero1,2);?></td>
<td class="align-middle text-end">$ <?=number_format($febrero1,2);?></td>
<td class="align-middle text-end">$ <?=number_format($marzo1,2);?></td>
<td class="align-middle text-end">$ <?=number_format($abril1,2);?></td>
<td class="align-middle text-end">$ <?=number_format($mayo1,2);?></td>
<td class="align-middle text-end">$ <?=number_format($junio1,2);?></td>
<td class="align-middle text-end">$ <?=number_format($julio1,2);?></td>
<td class="align-middle text-end">$ <?=number_format($agosto1,2);?></td>
<td class="align-middle text-end">$ <?=number_format($septiembre1,2);?></td>
<td class="align-middle text-end">$ <?=number_format($octubre1,2);?></td>
<td class="align-middle text-end">$ <?=number_format($noviembre1,2);?></td>
<td class="align-middle text-end">$ <?=number_format($diciembre1,2);?></td>
<td class="align-middle text-end">$ <?=number_format($totalEj1,2);?></td>
</tr>
<?php
}
?>
<tr>
<td class="align-middle font-weight-bold"><b>Total cortes diarios</b></td>
<td class="align-middle text-end font-weight-bold" >$ <?=number_format($TCE1,2);?></td>
<td class="align-middle text-end font-weight-bold" >$ <?=number_format($TCF1,2);?></td>
<td class="align-middle text-end font-weight-bold" >$ <?=number_format($TCM1,2);?></td>
<td class="align-middle text-end font-weight-bold" >$ <?=number_format($TCA1,2);?></td>
<td class="align-middle text-end font-weight-bold" >$ <?=number_format($TCMY1,2);?></td>
<td class="align-middle text-end font-weight-bold" >$ <?=number_format($TCJN1,2);?></td>
<td class="align-middle text-end font-weight-bold" >$ <?=number_format($TCJL1,2);?></td>
<td class="align-middle text-end font-weight-bold" >$ <?=number_format($TCAS1,2);?></td>
<td class="align-middle text-end font-weight-bold" >$ <?=number_format($TCS1,2);?></td>
<td class="align-middle text-end font-weight-bold" >$ <?=number_format($TCO1,2);?></td>
<td class="align-middle text-end font-weight-bold" >$ <?=number_format($TCN1,2);?></td>
<td class="align-middle text-end font-weight-bold" >$ <?=number_format($TCD1,2);?></td>
<td class="align-middle text-end font-weight-bold" >$ <?=number_format($TCTEJ1,2);?></td>
</tr>
</tbody>
</table>
</div>

</div>





<div class="border p-3 mb-3">

   <div class="row">
   <div class="col-12">
   <b>Facturación</b>
   </div>
            
   </div>

<hr>

<div class="table-responsive">
<table class="table table-sm table-bordered mb-0" style="font-size: .8em;">
<thead class="tables-bg">
	<tr>
	<th class="align-middle text-center">Facturación</th>
	<th class="align-middle text-end" width="110px">Enero</th>
	<th class="align-middle text-end" width="110px">Febrero</th>
	<th class="align-middle text-end" width="110px">Marzo</th>
	<th class="align-middle text-end" width="110px">Abril</th>
	<th class="align-middle text-end" width="110px">Mayo</th>
	<th class="align-middle text-end" width="110px">Junio</th>
	<th class="align-middle text-end" width="110px">Julio</th>
	<th class="align-middle text-end" width="110px">Agosto</th>
	<th class="align-middle text-end" width="110px">Septiembre</th>
	<th class="align-middle text-end" width="110px">Octubre</th>
	<th class="align-middle text-end" width="110px">Noviembre</th>
	<th class="align-middle text-end" width="110px">Diciembre</th>
	<th class="align-middle text-end">Total Ejercicio</th>
	</tr>
</thead>
<tbody>
<?php
while($rowP2 = mysqli_fetch_array($resultP2, MYSQLI_ASSOC)){
$id = $rowP2['id'];

if($rowP2['enero'] == 0){
$enero2 = "";	
}else{
$enero2 = $rowP2['enero'];
}

if($rowP2['febrero'] == 0){
$febrero2 = "";	
}else{
$febrero2 = $rowP2['febrero'];
}

if($rowP2['marzo'] == 0){
$marzo2 = "";	
}else{
$marzo2 = $rowP2['marzo'];
}

if($rowP2['abril'] == 0){
$abril2 = "";	
}else{
$abril2 = $rowP2['abril'];
}

if($rowP2['mayo'] == 0){
$mayo2 = "";	
}else{
$mayo2 = $rowP2['mayo'];
}

if($rowP2['junio'] == 0){
$junio2 = "";	
}else{
$junio2 = $rowP2['junio'];
}

if($rowP2['julio'] == 0){
$julio2 = "";	
}else{
$julio2 = $rowP2['julio'];
}

if($rowP2['agosto'] == 0){
$agosto2 = "";	
}else{
$agosto2 = $rowP2['agosto'];
}

if($rowP2['septiembre'] == 0){
$septiembre2 = "";	
}else{
$septiembre2 = $rowP2['septiembre'];
}

if($rowP2['octubre'] == 0){
$octubre2 = "";	
}else{
$octubre2 = $rowP2['octubre'];
}

if($rowP2['noviembre'] == 0){
$noviembre2 = "";	
}else{
$noviembre2 = $rowP2['noviembre'];
}

if($rowP2['diciembre'] == 0){
$diciembre2 = "";	
}else{
$diciembre2 = $rowP2['diciembre'];
}

if($rowP2['detalle'] != 'Rentas'){

$TCE2 = $TCE2 + $rowP2['enero'];
$TCF2 = $TCF2 + $rowP2['febrero'];
$TCM2 = $TCM2 + $rowP2['marzo'];
$TCA2 = $TCA2 + $rowP2['abril'];
$TCMY2 = $TCMY2 + $rowP2['mayo'];
$TCJN2 = $TCJN2 + $rowP2['junio'];
$TCJL2 = $TCJL2 + $rowP2['julio'];
$TCAS2 = $TCAS2 + $rowP2['agosto'];
$TCS2 = $TCS2 + $rowP2['septiembre'];
$TCO2 = $TCO2 + $rowP2['octubre'];
$TCN2 = $TCN2 + $rowP2['noviembre'];
$TCD2 = $TCD2 + $rowP2['diciembre'];

$totalEj2 = $TCE2 + $TCF2 + $TCM2 + $TCA2 + $TCMY2 + $TCJN2 + $TCJL2 + $TCAS2 + $TCS2 + $TCO2 + $TCN2 + $TCD2;
$TCTEJ2 = $TCTEJ2 + $totalEj2;

}

?>
<tr>
<td><?=$rowP2['detalle'];?></td>
<td class="align-middle text-end">$ <?=number_format($enero2,2);?></td>
<td class="align-middle text-end">$ <?=number_format($febrero2,2);?></td>
<td class="align-middle text-end">$ <?=number_format($marzo2,2);?></td>
<td class="align-middle text-end">$ <?=number_format($abril2,2);?></td>
<td class="align-middle text-end">$ <?=number_format($mayo2,2);?></td>
<td class="align-middle text-end">$ <?=number_format($junio2,2);?></td>
<td class="align-middle text-end">$ <?=number_format($julio2,2);?></td>
<td class="align-middle text-end">$ <?=number_format($agosto2,2);?></td>
<td class="align-middle text-end">$ <?=number_format($septiembre2,2);?></td>
<td class="align-middle text-end">$ <?=number_format($octubre2,2);?></td>
<td class="align-middle text-end">$ <?=number_format($noviembre2,2);?></td>
<td class="align-middle text-end">$ <?=number_format($diciembre2,2);?></td>
<td class="align-middle text-end" >$ <?=number_format($totalEj2,2);?></td>
</tr>
<?php
}

?>
<tr>
<td class="align-middle font-weight-bold">Total XML Timbrados</td>
<td class="align-middle text-end font-weight-bold">$ <?=number_format($TCE2,2);?></td>
<td class="align-middle text-end font-weight-bold">$ <?=number_format($TCF2,2);?></td>
<td class="align-middle text-end font-weight-bold">$ <?=number_format($TCM2,2);?></td>
<td class="align-middle text-end font-weight-bold">$ <?=number_format($TCA2,2);?></td>
<td class="align-middle text-end font-weight-bold">$ <?=number_format($TCMY2,2);?></td>
<td class="align-middle text-end font-weight-bold">$ <?=number_format($TCJN2,2);?></td>
<td class="align-middle text-end font-weight-bold">$ <?=number_format($TCJL2,2);?></td>
<td class="align-middle text-end font-weight-bold">$ <?=number_format($TCAS2,2);?></td>
<td class="align-middle text-end font-weight-bold">$ <?=number_format($TCS2,2);?></td>
<td class="align-middle text-end font-weight-bold">$ <?=number_format($TCO2,2);?></td>
<td class="align-middle text-end font-weight-bold">$ <?=number_format($TCN2,2);?></td>
<td class="align-middle text-end font-weight-bold">$ <?=number_format($TCD2,2);?></td>
<td class="align-middle text-end font-weight-bold">$ <?=number_format($TCTEJ2,2);?></td>
</tr>
<?php

$TD1 = $TCE2 - $TCE1;
$TD2 = $TCF2 - $TCF1;
$TD3 = $TCM2 - $TCM1;
$TD4 = $TCA2 - $TCA1;
$TD5 = $TCMY2 - $TCMY1;
$TD6 = $TCJN2 - $TCJN1;
$TD7 = $TCJL2 - $TCJL1;
$TD8 = $TCAS2 - $TCAS1;
$TD9 = $TCS2 - $TCS1;
$TD10 = $TCO2 - $TCO1;
$TD11 = $TCN2 - $TCN1;
$TD12 = $TCD2 - $TCD1;
$TDTE = $TCTEJ2 - $TCTEJ1;
?>
<tr>
<td class="align-middle font-weight-bold"><b>Total Diferencias</b></td>
<td class="align-middle text-end font-weight-bold" id="TD1">$ <?=number_format($TD1,2);?></td>
<td class="align-middle text-end font-weight-bold" id="TD2">$ <?=number_format($TD2,2);?></td>
<td class="align-middle text-end font-weight-bold" id="TD3">$ <?=number_format($TD3,2);?></td>
<td class="align-middle text-end font-weight-bold" id="TD4">$ <?=number_format($TD4,2);?></td>
<td class="align-middle text-end font-weight-bold" id="TD5">$ <?=number_format($TD5,2);?></td>
<td class="align-middle text-end font-weight-bold" id="TD6">$ <?=number_format($TD6,2);?></td>
<td class="align-middle text-end font-weight-bold" id="TD7">$ <?=number_format($TD7,2);?></td>
<td class="align-middle text-end font-weight-bold" id="TD8">$ <?=number_format($TD8,2);?></td>
<td class="align-middle text-end font-weight-bold" id="TD9">$ <?=number_format($TD9,2);?></td>
<td class="align-middle text-end font-weight-bold" id="TD10">$ <?=number_format($TD10,2);?></td>
<td class="align-middle text-end font-weight-bold" id="TD11">$ <?=number_format($TD11,2);?></td>
<td class="align-middle text-end font-weight-bold" id="TD12">$ <?=number_format($TD12,2);?></td>
<td class="align-middle text-end font-weight-bold" id="TDTE">$ <?=number_format($TDTE,2);?></td>
</tr>

</tbody>
</table>		
</div>	
</div>						
</div>