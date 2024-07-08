<?php
require('../../../app/help.php');

$GET_idPrecio = $_GET['idPrecio'];

$sql_lista_f = "SELECT fecha FROM op_formato_precios WHERE id = '".$GET_idPrecio."' ";
$result_lista_f = mysqli_query($con, $sql_lista_f);
$numero_lista_f = mysqli_num_rows($result_lista_f);
while($row_lista_f = mysqli_fetch_array($result_lista_f, MYSQLI_ASSOC)){
$fecha = $row_lista_f['fecha']; 
}

if("2024-02-20" < $fecha){
$ocultarInfo = "d-none";
  
}else{
$ocultarInfo = "";
}
   

if($session_nompuesto == "Dirección de operaciones"){
$ocultarTH = ""; 
}else{
$ocultarTH = "d-none";
}

function Precio($idPrecio,$num,$producto,$con){

if($num == 1){
$select = " pemex AS valorprecio ";
$where = "AND producto = '".$producto."' ";

}else if($num == 2){
$select = " delivery_vopak AS valorprecio ";
$where = "AND producto = '".$producto."' ";
 
}else if($num == 3){
$select = " delivery_tuxpan AS valorprecio ";
$where = "AND producto = '".$producto."' ";

}else if($num == 4){
$select = " delivery_montera AS valorprecio ";
$where = "AND producto = '".$producto."' ";

}else if($num == 5){
$select = " pickup_vopak AS valorprecio ";
$where = "AND producto = '".$producto."' ";

}else if($num == 6){
$select = " pickup_tuxpan AS valorprecio ";
$where = "AND producto = '".$producto."' ";

}else if($num == 7){
$select = " pickup_montera AS valorprecio ";
$where = "AND producto = '".$producto."' ";

}else if($num == 9){
$select = " pickup_tizayuca AS valorprecio ";
$where = "AND producto = '".$producto."' ";

}else if($num == 10){
$select = " pickup_puebla AS valorprecio ";
$where = "AND producto = '".$producto."' ";

}
 

$sql2 = "SELECT $select FROM op_formato_precios_detalle_c WHERE id_precio = '".$idPrecio."' $where ";
$result2 = mysqli_query($con, $sql2);
$numero2 = mysqli_num_rows($result2);
$valorprecio = 0;

while($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)){

$valorprecio = $row2['valorprecio'];

}

return $valorprecio;
}


//---------- CONSULTAR PRECIO DE TERMINAL ----------
function PrecioPU($idPrecio,$terminal,$con){

if($terminal == "Tuxpan"){
$detalle = "Tuxpan";

}else if($terminal == "Vopack"){
$detalle = "Vopack";

}else if($terminal == "Tizayuca"){
$detalle = "Tizayuca";

}else if($terminal == "Puebla"){
$detalle = "Puebla";

}


$sql2 = "SELECT * FROM op_formato_precios_transporte WHERE id_formato = '".$idPrecio."' AND detalle = '".$detalle."' ";
$result2 = mysqli_query($con, $sql2);
$numero2 = mysqli_num_rows($result2);
$valorprecio = 0;

while($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
$valorprecio = $row2['precio'];
}

$precioIVA = number_format(($valorprecio * 0.16),4);
$precioRetencion = number_format(($valorprecio * 0.04),4);
$totalPickUp2 = number_format(($valorprecio + $precioIVA - $precioRetencion),4);

return $totalPickUp2;
}
   


function productoCheck($idPrecio,$num,$producto,$con){

if($num == 1){
$select = " p1 AS checkProducto ";
$where = "AND producto = '".$producto."' ";

}else if($num == 2){
$select = " p2 AS checkProducto ";
$where = "AND producto = '".$producto."' ";

}else if($num == 3){
$select = " p3 AS checkProducto ";
$where = "AND producto = '".$producto."' ";

}else if($num == 4){
$select = " p4 AS checkProducto ";
$where = "AND producto = '".$producto."' ";

}else if($num == 5){
$select = " p5 AS checkProducto ";
$where = "AND producto = '".$producto."' ";

}else if($num == 6){
$select = " p6 AS checkProducto ";
$where = "AND producto = '".$producto."' ";

}else if($num == 7){
$select = " p7 AS checkProducto ";
$where = "AND producto = '".$producto."' ";

}else if($num == 8){
$select = " p8 AS checkProducto ";
$where = "AND producto = '".$producto."' ";

}else if($num == 9){
$select = " p9 AS checkProducto ";
$where = "AND producto = '".$producto."' ";

}else if($num == 10){
$select = " p10 AS checkProducto ";
$where = "AND producto = '".$producto."' ";

}


$sql3 = "SELECT $select FROM op_formato_precios_detalle_c WHERE id_precio = '".$idPrecio."' $where ";
$result3 = mysqli_query($con, $sql3);
$numero3 = mysqli_num_rows($result3);
while($row3 = mysqli_fetch_array($result3, MYSQLI_ASSOC)){

$checkProducto = $row3['checkProducto'];

}

return $checkProducto;
}



 $tuxpanVal = PrecioPU($GET_idPrecio,"Tuxpan",$con);
 $vopakVal = PrecioPU($GET_idPrecio,"Vopack",$con);
 $tizayucaVal = PrecioPU($GET_idPrecio,"Tizayuca",$con);
 $pueblaVal = PrecioPU($GET_idPrecio,"Puebla",$con);


//---------- PRODUCTOS GSUPER ----------
$PrecioS1 = Precio($GET_idPrecio,1,'Super',$con);
$PrecioS2 = Precio($GET_idPrecio,2,'Super',$con);
$PrecioS3 = Precio($GET_idPrecio,3,'Super',$con);
$PrecioS4 = Precio($GET_idPrecio,4,'Super',$con);
$PrecioS5 = Precio($GET_idPrecio,5,'Super',$con) + $vopakVal;
$PrecioS6 = Precio($GET_idPrecio,6,'Super',$con) + $tuxpanVal;
$PrecioS7 = Precio($GET_idPrecio,7,'Super',$con) + $tuxpanVal;
$PrecioS8 = "0.00";
$PrecioS9 = Precio($GET_idPrecio,9,'Super',$con) + $tizayucaVal;
$PrecioS10 = Precio($GET_idPrecio,10,'Super',$con) + $pueblaVal;

$CheckS1 = productoCheck($GET_idPrecio,1,'Super',$con);
$CheckS2 = productoCheck($GET_idPrecio,2,'Super',$con);
$CheckS3 = productoCheck($GET_idPrecio,3,'Super',$con);
$CheckS4 = productoCheck($GET_idPrecio,4,'Super',$con);
$CheckS5 = productoCheck($GET_idPrecio,5,'Super',$con);
$CheckS6 = productoCheck($GET_idPrecio,6,'Super',$con);
$CheckS7 = productoCheck($GET_idPrecio,7,'Super',$con);
$CheckS8 = productoCheck($GET_idPrecio,8,'Super',$con);
$CheckS9 = productoCheck($GET_idPrecio,9,'Super',$con);
$CheckS10 = productoCheck($GET_idPrecio,10,'Super',$con);


//---------- PRODUCTOS GPREMIUM----------
$PrecioP1 = Precio($GET_idPrecio,1,'Premium',$con);
$PrecioP2 = Precio($GET_idPrecio,2,'Premium',$con);
$PrecioP3 = Precio($GET_idPrecio,3,'Premium',$con);
$PrecioP4 = Precio($GET_idPrecio,4,'Premium',$con);
$PrecioP5 = Precio($GET_idPrecio,5,'Premium',$con) + $vopakVal;
$PrecioP6 = Precio($GET_idPrecio,6,'Premium',$con) + $tuxpanVal;
$PrecioP7 = Precio($GET_idPrecio,7,'Premium',$con) + $tuxpanVal;
$PrecioP8 = "0.00";
$PrecioP9 = Precio($GET_idPrecio,9,'Premium',$con) + $tizayucaVal;
$PrecioP10 = Precio($GET_idPrecio,10,'Premium',$con) + $pueblaVal;


$CheckP1 = productoCheck($GET_idPrecio,1,'Premium',$con);
$CheckP2 = productoCheck($GET_idPrecio,2,'Premium',$con);
$CheckP3 = productoCheck($GET_idPrecio,3,'Premium',$con);
$CheckP4 = productoCheck($GET_idPrecio,4,'Premium',$con);
$CheckP5 = productoCheck($GET_idPrecio,5,'Premium',$con);
$CheckP6 = productoCheck($GET_idPrecio,6,'Premium',$con);
$CheckP7 = productoCheck($GET_idPrecio,7,'Premium',$con);
$CheckP8 = productoCheck($GET_idPrecio,8,'Premium',$con);
$CheckP9 = productoCheck($GET_idPrecio,9,'Premium',$con);
$CheckP10 = productoCheck($GET_idPrecio,10,'Premium',$con);


//---------- PRODUCTOS GSUPER----------
$PrecioD1 = Precio($GET_idPrecio,1,'Diesel',$con);
$PrecioD2 = Precio($GET_idPrecio,2,'Diesel',$con);
$PrecioD3 = Precio($GET_idPrecio,3,'Diesel',$con);
$PrecioD4 = Precio($GET_idPrecio,4,'Diesel',$con);
$PrecioD5 = Precio($GET_idPrecio,5,'Diesel',$con) + $vopakVal;;
$PrecioD6 = Precio($GET_idPrecio,6,'Diesel',$con) + $tuxpanVal;;
$PrecioD7 = Precio($GET_idPrecio,7,'Diesel',$con) + $tuxpanVal;;
$PrecioD8 = "0.00";
$PrecioD9 = Precio($GET_idPrecio,9,'Diesel',$con) + $tizayucaVal;
$PrecioD10 = Precio($GET_idPrecio,10,'Diesel',$con) + $pueblaVal;


$CheckD1 = productoCheck($GET_idPrecio,1,'Diesel',$con);
$CheckD2 = productoCheck($GET_idPrecio,2,'Diesel',$con);
$CheckD3 = productoCheck($GET_idPrecio,3,'Diesel',$con);
$CheckD4 = productoCheck($GET_idPrecio,4,'Diesel',$con);
$CheckD5 = productoCheck($GET_idPrecio,5,'Diesel',$con);
$CheckD6 = productoCheck($GET_idPrecio,6,'Diesel',$con);
$CheckD7 = productoCheck($GET_idPrecio,7,'Diesel',$con);
$CheckD8 = productoCheck($GET_idPrecio,8,'Diesel',$con);
$CheckD9 = productoCheck($GET_idPrecio,9,'Diesel',$con);
$CheckD10 = productoCheck($GET_idPrecio,10,'Diesel',$con);


//----------
$DiferenciaS1 = "0.00";
$DiferenciaS2 = $PrecioS2 - $PrecioS1;
$DiferenciaS3 = $PrecioS3 - $PrecioS1;
$DiferenciaS4 = $PrecioS4 - $PrecioS1;
$DiferenciaS5 = $PrecioS5  - $PrecioS1;
$DiferenciaS6 = $PrecioS6 - $PrecioS1;
$DiferenciaS7 = $PrecioS7 - $PrecioS1;
$DiferenciaS8 = "0.00";
$DiferenciaS9 = $PrecioS9 - $PrecioS1;
$DiferenciaS10 = $PrecioS10 - $PrecioS1;


$DiferenciaP1 = "0.00";
$DiferenciaP2 = $PrecioP2 - $PrecioP1;
$DiferenciaP3 = $PrecioP3 - $PrecioP1;
$DiferenciaP4 = $PrecioP4 - $PrecioP1;
$DiferenciaP5 = $PrecioP5 - $PrecioP1;
$DiferenciaP6 = $PrecioP6 - $PrecioP1;
$DiferenciaP7 = $PrecioP7 - $PrecioP1;
$DiferenciaP8 = "0.00";
$DiferenciaP9 = $PrecioP9 - $PrecioP1;
$DiferenciaP10 = $PrecioP10 - $PrecioP1;


$DiferenciaD1 = "0.00";
$DiferenciaD2 = $PrecioD2 - $PrecioD1;
$DiferenciaD3 = $PrecioD3 - $PrecioD1;
$DiferenciaD4 = $PrecioD4 - $PrecioD1;
$DiferenciaD5 = $PrecioD5 - $PrecioD1;
$DiferenciaD6 = $PrecioD6 - $PrecioD1;
$DiferenciaD7 = $PrecioD7 - $PrecioD1;
$DiferenciaD8 = "0.00";
$DiferenciaD9 = $PrecioD9 - $PrecioD1;
$DiferenciaD10 = $PrecioD10 - $PrecioD1;

$tdS2 = "";
$tdS5 = "";

$tdP2 = "";
$tdP5 = "";

$tdD2  = "";
$tdD5  = "";

//---------- PRECIOS SUPER (COLOR) ----------
if($CheckS1 == 1){
$tdS1 = "background-color: #fcfcda;";
}

if($CheckS2 == 1){
$tdS2 = "background-color: #fcfcda;";
}

if($CheckS3 == 1){
$tdS3 = "background-color: #fcfcda;";
}

if($CheckS4 == 1){
$tdS4 = "background-color: #fcfcda;";
}

if($CheckS5 == 1){
$tdS5 = "background-color: #fcfcda;";
}

if($CheckS6 == 1){
$tdS6 = "background-color: #fcfcda;";
}

if($CheckS7 == 1){
$tdS7 = "background-color: #fcfcda;";
}

if($CheckS8 == 1){
$tdS8 = "background-color: #fcfcda;";
$tdS8C = "";
}else{
$tdS8 = "";
$tdS8C = "bg-light";
}

if($CheckS9 == 1){
$tdS9 = "background-color: #fcfcda;";
}

if($CheckS10 == 1){
$tdS10 = "background-color: #fcfcda;";
}


//---------- PRECIOS PREMIUM ----------
if($CheckP1 == 1){
$tdP1 = "background-color: #fcfcda;";
}

if($CheckP2 == 1){
$tdP2 = "background-color: #fcfcda;";
}

if($CheckP3 == 1){
$tdP3 = "background-color: #fcfcda;";
}

if($CheckP4 == 1){
$tdP4 = "background-color: #fcfcda;";
}

if($CheckP5 == 1){
$tdP5 = "background-color: #fcfcda;";
}

if($CheckP6 == 1){
$tdP6 = "background-color: #fcfcda;";
}

if($CheckP7 == 1){
$tdP7 = "background-color: #fcfcda;";
}

if($CheckP8 == 1){
$tdP8 = "background-color: #fcfcda;";
$tdP8C = "";
}else{
$tdP8 = "";
$tdP8C = "bg-light";
}

if($CheckP9 == 1){
$tdP9 = "background-color: #fcfcda;";
}

if($CheckP10 == 1){
$tdP10 = "background-color: #fcfcda;";
}


//---------- PRECIOS DIESEL ----------
if($CheckD1 == 1){
$tdD1 = "background-color: #fcfcda;";
}

if($CheckD2 == 1){
$tdD2 = "background-color: #fcfcda;";
}

if($CheckD3 == 1){
$tdD3 = "background-color: #fcfcda;";
}

if($CheckD4 == 1){
$tdD4 = "background-color: #fcfcda;";
}

if($CheckD5 == 1){
$tdD5 = "background-color: #fcfcda;";
}

if($CheckD6 == 1){
$tdD6 = "background-color: #fcfcda;";
}

if($CheckD7 == 1){
$tdD7 = "background-color: #fcfcda;";
}

if($CheckD8 == 1){
$tdD8 = "background-color: #fcfcda;";
$tdD8C = "";
}else{
$tdD8 = "";
$tdD8C = "bg-light";
}

if($CheckD9 == 1){
$tdD9 = "background-color: #fcfcda;";
}

if($CheckD10 == 1){
$tdD10 = "background-color: #fcfcda;";
}







if("2024-02-20" < $fecha){
  $Min1 = min(array($PrecioS1, $PrecioS3, $PrecioS4, $PrecioS6, $PrecioS7, $PrecioS9, $PrecioS10));
  $Min2 = min(array($PrecioP1, $PrecioP3, $PrecioP4, $PrecioP6, $PrecioP7, $PrecioP9, $PrecioP10));
  $Min3 = min(array($PrecioD1, $PrecioD3, $PrecioD4, $PrecioD6, $PrecioD7, $PrecioD9, $PrecioD10));

  $vopakS2 = "";
  $vopakS5 = "";
  $vopakP2 = "";
  $vopakP5 = "";
  $vopakd2 = "";
  $vopakd5 = "";
  $no1 = "1";
  $no2 = "";
  $no3 = "2";
  $no4 = "3";
  $no5 = "";
  $no6 = "4";
  $no7 = "5";
  $no8 = "6";
  $no9 = "7";
  $no10 = "8";

}else{
  
  $Min1 = min(array($PrecioS1, $PrecioS2, $PrecioS3, $PrecioS4, $PrecioS5, $PrecioS6, $PrecioS7, $PrecioS9, $PrecioS10));
  $Min2 = min(array($PrecioP1, $PrecioP2, $PrecioP3, $PrecioP4, $PrecioP5, $PrecioP6, $PrecioP7, $PrecioP9, $PrecioP10));
  $Min3 = min(array($PrecioD1, $PrecioD2, $PrecioD3, $PrecioD4, $PrecioD5, $PrecioD6, $PrecioD7, $PrecioD9, $PrecioD10));

  $vopakS2 = $tdS2;
  $vopakS5 = $tdS5;
  $vopakP2 = $tdP2;
  $vopakP5 = $tdP5;
  $vopakD2 = $tdD2;
  $vopakD5 = $tdD5;
  $no1 = "1";
  $no2 = "2";
  $no3 = "3";
  $no4 = "4";
  $no5 = "5";
  $no6 = "6";
  $no7 = "7";
  $no8 = "8";
  $no9 = "9";
  $no10 = "10";
}

$disableS1 = "";
$disableS2 = "";
$disableS3 = "";
$disableS4 = "";
$disableS5 = "";
$disableS6 = "";
$disableS7 = "";
$disableS8 = "";
$disableS9 = "";
$disableS10 = "";

$disableP1 = "";
$disableP2 = "";
$disableP3 = "";
$disableP4 = "";
$disableP5 = "";
$disableP6 = "";
$disableP7 = "";
$disableP8 = "";
$disableP9 = "";
$disableP10 = "";

$disableD1 = "";
$disableD2 = "";
$disableD3 = "";
$disableD4 = "";
$disableD5 = "";
$disableD6 = "";
$disableD7 = "";
$disableD8 = "";
$disableD9 = "";
$disableD10 = "";

//---------- PRECIOS SUPER ----------
if($Min1 == $PrecioS1){
$tdS1 = "background-color: #74bc1f; color:white;";
$disableS1 = "d-none";
}

if($Min1 == $PrecioS2){
$tdS2 = "background-color: #74bc1f; color:white;";
$disableS2 = "d-none";
}

if($Min1 == $PrecioS3){
$tdS3 = "background-color: #74bc1f; color:white;";
$disableS3 = "d-none";
}

if($Min1 == $PrecioS4){
$tdS4 = "background-color: #74bc1f; color:white;";
$disableS4 = "d-none";
}

if($Min1 == $PrecioS5){
$tdS5 = "background-color: #74bc1f; color:white;";
$disableS5 = "d-none";
}

if($Min1 == $PrecioS6){
$tdS6 = "background-color: #74bc1f; color:white;";
$disableS6 = "d-none";
}

if($Min1 == $PrecioS7){
$tdS7 = "background-color: #74bc1f; color:white;";
$disableS7 = "d-none";
}

if($Min1 == $PrecioS9){
$tdS9 = "background-color: #74bc1f; color:white;";
$disableS9 = "d-none";
}

if($Min1 == $PrecioS10){
$tdS10 = "background-color: #74bc1f; color:white;";
$disableS10 = "d-none";
}

//---------- PRECIOS PREMIUM ----------
if($Min2 == $PrecioP1){
$tdP1 = "background-color: #e01883; color:white;";
$disableP1 = "d-none";
}

if($Min2 == $PrecioP2){
$tdP2 = "background-color: #e01883; color:white;";
$disableP2 = "d-none";
}

if($Min2 == $PrecioP3){
$tdP3 = "background-color: #e01883; color:white;";
$disableP3 = "d-none";
}

if($Min2 == $PrecioP4){
$tdP4 = "background-color: #e01883; color:white;";
$disableP4 = "d-none";
}

if($Min2 == $PrecioP5){
$tdP5 = "background-color: #e01883; color:white;";
$disableP5 = "d-none";
}

if($Min2 == $PrecioP6){
$tdP6 = "background-color: #e01883; color:white;";
$disableP6 = "d-none";
}

if($Min2 == $PrecioP7){
$tdP7 = "background-color: #e01883; color:white;";
$disableP7 = "d-none";
}

if($Min2 == $PrecioP9){
$tdP9 = "background-color: #e01883; color:white;";
$disableP9 = "d-none";
}

if($Min2 == $PrecioP10){
$tdP10 = "background-color: #e01883; color:white;";
$disableP10 = "d-none";
}

//---------- PRECIOS DIESEL ----------
if($Min3 == $PrecioD1){
$tdD1 = "background-color: #5c108c; color:white;";
$disableD1 = "d-none"; 
}

if($Min3 == $PrecioD2){
$tdD2 = "background-color: #5c108c; color:white;"; 
$disableD2 = "d-none"; 
}

if($Min3 == $PrecioD3){
$tdD3 = "background-color: #5c108c; color:white;"; 
$disableD3 = "d-none"; 
}

if($Min3 == $PrecioD4){
$tdD4 = "background-color: #5c108c; color:white;";
$disableD4 = "d-none";  
}

if($Min3 == $PrecioD5){
$tdD5 = "background-color: #5c108c; color:white;"; 
$disableD5 = "d-none"; 
}

if($Min3 == $PrecioD6){
$tdD6 = "background-color: #5c108c; color:white;";
$disableD6 = "d-none";  
}

if($Min3 == $PrecioD7){
$tdD7 = "background-color: #5c108c; color:white;";
$disableD7 = "d-none";  
}

if($Min3 == $PrecioD9){
$tdD9 = "background-color: #5c108c; color:white;"; 
$disableD9 = "d-none"; 
}

if($Min3 == $PrecioD10){
$tdD10 = "background-color: #5c108c; color:white;"; 
$disableD10 = "d-none"; 
}


?>


<div class="table-responsive">
<table class="custom-table" style="font-size: 12.5px;" width="100%">

<thead class="title-table-bg">

<tr class="tables-bg" >
<th class="align-middle text-center" colspan="9">REPORTE DE PRECIOS</th> 
</tr>

<tr>
<td class="align-middle text-center fw-bold" width="30px">#</td> 
<th class="align-middle text-center">Modalidad</th> 
<th class="align-middle text-center">Terminal</th>  
<th class="align-middle text-center">Producto</th>  
<th class="align-middle text-center" width="100px">Precio</th>  
<th class="align-middle text-center"width="100px" >Diferencia vs Pemex</th> 
<th class="align-middle text-center">Comercializa</th>  
<th class="align-middle text-center">Distribuye</th>
<td class="align-middle text-center <?=$ocultarTH?>" width="15px"><img src="<?=RUTA_IMG_ICONOS?>precio-bajo.png"></td>
</tr>

</thead>

<tbody class="bg-white">

<!---------- PRECIOS SUPER ---------->
<tr class="text-center align-middle" id="Super1" style="<?=$tdS1;?>">
  <th style="background-color: #74bc1f;" class="text-white"><?=$no1?></th>
  <td>Network Pemex</td>
  <td>Azcapozalco</td>
  <td class="super text-center font-weight-bold">Super</td>
  <td class="text-center ">$ <?=number_format($PrecioS1,2);?></td>
  <td class="text-center fw-bold">$ <?=$DiferenciaS1;?></td>
  <td>Network</td>
  <td>Pemex</td>
  <th class="align-middle text-center p-2 <?=$ocultarTH?>" width="15px">
    <img class="pointer <?=$disableS1?>" src="<?=RUTA_IMG_ICONOS?>precio-bajo.png" onclick="SelPrecioBajo(<?=$GET_idPrecio?>,<?=$CheckS1?>,1,'Super')">
  </th>
</tr>



<tr class="text-center align-middle <?=$ocultarInfo?>" id="Super2" style="<?=$vopakS2;?>">
  <th style="background-color: #74bc1f;" class="text-white"><?=$no2?></th>
  <td>Delivery G500</td>
  <td>Vopack</td>
  <td class="super text-center font-weight-bold">Super</td>
  <td class="text-center ">$ <?=number_format($PrecioS2,2);?></td>
  <td class="text-center fw-bold">$ <?=number_format($DiferenciaS2,2);?></td>
  <td>Network</td>
  <td>Network</td>
    <th class="align-middle text-center p-2 <?=$ocultarTH?>" width="15px">
    <img class="pointer <?=$disableS2?>" src="<?=RUTA_IMG_ICONOS?>precio-bajo.png" onclick="SelPrecioBajo(<?=$GET_idPrecio?>,<?=$CheckS2?>,2,'Super')">
  </th>
</tr>

<tr class="text-center align-middle" id="Super3" style="<?=$tdS3;?>">
  <th style="background-color: #74bc1f;" class="text-white"><?=$no3?></th>
  <td>Delivery G500</td>
  <td>Tuxpan</td>
  <td class="super text-center font-weight-bold">Super</td>
  <td class="text-center ">$ <?=number_format($PrecioS3,2);?></td>
  <td class="text-center fw-bold">$ <?=number_format($DiferenciaS3,2);?></td>
  <td>Network</td>
  <td>Network</td>
  <th class="align-middle text-center p-2 <?=$ocultarTH?>" width="15px">
    <img class="pointer <?=$disableS3?>" src="<?=RUTA_IMG_ICONOS?>precio-bajo.png" onclick="SelPrecioBajo(<?=$GET_idPrecio?>,<?=$CheckS3?>,3,'Super')">
  </th>
</tr>

<tr class="text-center align-middle" id="Super4" style="<?=$tdS4;?>">
  <th style="background-color: #74bc1f;" class="text-white"><?=$no4?></th>
  <td>Delivery G500</td>
  <td>Monterra</td>
  <td class="super text-center font-weight-bold">Super</td>
  <td class="text-center ">$ <?=number_format($PrecioS4,2);?></td>
  <td class="text-center fw-bold">$ <?=number_format($DiferenciaS4,2);?></td>
  <td>Network</td>
  <td>Network</td>
    <th class="align-middle text-center p-2 <?=$ocultarTH?>" width="15px">
    <img class="pointer <?=$disableS4?>" src="<?=RUTA_IMG_ICONOS?>precio-bajo.png" onclick="SelPrecioBajo(<?=$GET_idPrecio?>,<?=$CheckS4?>,4,'Super')">
  </th>
</tr>

<tr class="text-center align-middle <?=$ocultarInfo?>" id="Super5" style="<?=$vopakS5;?>">
  <th style="background-color: #74bc1f;" class="text-white"><?=$no5?></th>
  <td>Pick up</td>
  <td>Vopack</td>
  <td class="super text-center font-weight-bold">Super</td>
  <td class="text-center ">$ <?=number_format($PrecioS5,2);?></td>
  <td class="text-center fw-bold">$ <?=number_format($DiferenciaS5,2);?></td>
  <td>Network</td>
  <td>Vientos del norte</td>
    <th class="align-middle text-center p-2 <?=$ocultarTH?>" width="15px">
    <img class="pointer <?=$disableS5?>" src="<?=RUTA_IMG_ICONOS?>precio-bajo.png" onclick="SelPrecioBajo(<?=$GET_idPrecio?>,<?=$CheckS5?>,5,'Super')">
  </th>
</tr>


<tr class="text-center align-middle" id="Super6" style="<?=$tdS6;?>">
  <th style="background-color: #74bc1f;" class="text-white"><?=$no6?></th>
  <td>Pick up</td>
  <td>Tuxpan</td>
  <td class="super text-center font-weight-bold">Super</td>
  <td class="text-center ">$ <?=number_format($PrecioS6,2);?></td>
  <td class="text-center fw-bold">$ <?=number_format($DiferenciaS6,2);?></td>
  <td>Network</td>
  <td>Vientos del norte</td>
    <th class="align-middle text-center p-2 <?=$ocultarTH?>" width="15px">
    <img class="pointer <?=$disableS6?>" src="<?=RUTA_IMG_ICONOS?>precio-bajo.png" onclick="SelPrecioBajo(<?=$GET_idPrecio?>,<?=$CheckS6?>,6,'Super')">
  </th>
</tr>


<tr class="text-center align-middle" id="Super7" style="<?=$tdS7;?>">
  <th style="background-color: #74bc1f;" class="text-white"><?=$no7?></th>
  <td>Pick up</td>
  <td>Monterra</td>
  <td class="super text-center font-weight-bold">Super</td>
  <td class="text-center ">$ <?=number_format($PrecioS7,2);?></td>
  <td class="text-center fw-bold">$ <?=number_format($DiferenciaS7,2);?></td>
  <td>Network</td>
  <td>Vientos del norte</td>
    <th class="align-middle text-center p-2 <?=$ocultarTH?>" width="15px">
    <img class="pointer <?=$disableS7?>" src="<?=RUTA_IMG_ICONOS?>precio-bajo.png" onclick="SelPrecioBajo(<?=$GET_idPrecio?>,<?=$CheckS7?>,7,'Super')">
  </th>
</tr>


<tr class="text-center align-middle <?=$tdS8C?>" id="Super8" style="<?=$tdS8;?>">
  <th style="background-color: #74bc1f;" class="text-white"><?=$no8?></th>
  <td>Pick up/Simsa</td>
  <td>Monterra</td>
  <td class="super text-center font-weight-bold">Super</td>
  <td class="text-center">$ <?=$PrecioS8;?></td>
  <td class="text-center fw-bold">$ <?=$DiferenciaS8;?></td>
  <td>Network</td>
  <td>Vientos del norte</td>
    <th class="align-middle text-center p-2 <?=$ocultarTH?>" width="15px">
    <img class="pointer" src="<?=RUTA_IMG_ICONOS?>precio-bajo.png" onclick="SelPrecioBajo(<?=$GET_idPrecio?>,<?=$CheckS8?>,8,'Super')">
  </th>
</tr>


<tr class="text-center align-middle" id="Super9" style="<?=$tdS9;?>">
  <th style="background-color: #74bc1f;" class="text-white"><?=$no9?></th>
  <td>Pick up/Valero</td>
  <td>Tizayuca</td>
  <td class="super text-center font-weight-bold">Super</td>
  <td class="text-center ">$ <?=number_format($PrecioS9,2);?></td>
  <td class="text-center fw-bold">$ <?=number_format($DiferenciaS9,2);?></td>
  <td>Network</td>
  <td>Vientos del norte</td>
      <th class="align-middle text-center p-2 <?=$ocultarTH?>" width="15px">
    <img class="pointer <?=$disableS9?>" src="<?=RUTA_IMG_ICONOS?>precio-bajo.png" onclick="SelPrecioBajo(<?=$GET_idPrecio?>,<?=$CheckS9?>,9,'Super')">
  </th>
</tr>

<tr class="text-center align-middle" id="Super10" style="<?=$tdS10;?>">
  <th style="background-color: #74bc1f;" class="text-white"><?=$no10?></th>
  <td>Pick up/Valero</td>
  <td>Puebla</td>
  <td class="super text-center font-weight-bold">Super</td>
  <td class="text-center ">$ <?=number_format($PrecioS10,2);?></td>
  <td class="text-center fw-bold">$ <?=number_format($DiferenciaS10,2);?></td>
  <td>Network</td>
  <td>Vientos del norte</td>
    <th class="align-middle text-center p-2 <?=$ocultarTH?>" width="15px">
    <img class="pointer <?=$disableS10?>" src="<?=RUTA_IMG_ICONOS?>precio-bajo.png" onclick="SelPrecioBajo(<?=$GET_idPrecio?>,<?=$CheckS10?>,10,'Super')">
  </th>
</tr>


<!---------- PRECIOS PREMIUM ---------->

<tr class="text-center align-middle" style="<?=$tdP1;?>">
  <th style="background-color: #e01883;" class="text-white"><?=$no1?></th>
  <td>Network Pemex</td>
  <td>Azcapozalco</td>
  <td class="super text-center font-weight-bold">Premium</td>
  <td class="text-center ">$ <?=number_format($PrecioP1,2);?></td>
  <td class="text-center fw-bold">$ <?=$DiferenciaP1;?></td>
  <td>Network</td>
  <td>Pemex</td>
      <th class="align-middle text-center p-2 <?=$ocultarTH?>" width="15px">
    <img class="pointer <?=$disableP1?>" src="<?=RUTA_IMG_ICONOS?>precio-bajo.png" onclick="SelPrecioBajo(<?=$GET_idPrecio?>,<?=$CheckP1?>,1,'Premium')">
  </th>
</tr>

<tr class="text-center align-middle <?=$ocultarInfo?>" style="<?=$vopakP2;?>">
  <th style="background-color: #e01883;" class="text-white"><?=$no2?></th>
  <td>Delivery G500</td>
  <td>Vopack</td>
  <td class="super text-center font-weight-bold">Premium</td>
  <td class="text-center ">$ <?=number_format($PrecioP2,2);?></td>
  <td class="text-center fw-bold">$ <?=number_format($DiferenciaP2,2);?></td>
  <td>Network</td>
  <td>Network</td>
  <th class="align-middle text-center p-2 <?=$ocultarTH?>" width="15px">
    <img class="pointer <?=$disableP2?>" src="<?=RUTA_IMG_ICONOS?>precio-bajo.png" onclick="SelPrecioBajo(<?=$GET_idPrecio?>,<?=$CheckP2?>,2,'Premium')">
  </th>
</tr>

<tr class="text-center align-middle" style="<?=$tdP3;?>">
  <th style="background-color: #e01883;" class="text-white"><?=$no3?></th>
  <td>Delivery G500</td>
  <td>Tuxpan</td>
  <td class="super text-center font-weight-bold">Premium</td>
  <td class="text-center ">$ <?=number_format($PrecioP3,2);?></td>
  <td class="text-center fw-bold">$ <?=number_format($DiferenciaP3,2);?></td>
  <td>Network</td>
  <td>Network</td>
  <th class="align-middle text-center p-2 <?=$ocultarTH?>" width="15px">
    <img class="pointer <?=$disableP3?>" src="<?=RUTA_IMG_ICONOS?>precio-bajo.png" onclick="SelPrecioBajo(<?=$GET_idPrecio?>,<?=$CheckP3?>,3,'Premium')">
  </th>
</tr>

<tr class="text-center align-middle" style="<?=$tdP4;?>">
  <th style="background-color: #e01883;" class="text-white"><?=$no4?></th>
  <td>Delivery G500</td>
  <td>Monterra</td>
  <td class="super text-center font-weight-bold">Premium</td>
  <td class="text-center ">$ <?=number_format($PrecioP4,2);?></td>
  <td class="text-center fw-bold">$ <?=number_format($DiferenciaP4,2);?></td>
  <td>Network</td>
  <td>Network</td>
  <th class="align-middle text-center p-2 <?=$ocultarTH?>" width="15px">
    <img class="pointer <?=$disableP4?>" src="<?=RUTA_IMG_ICONOS?>precio-bajo.png" onclick="SelPrecioBajo(<?=$GET_idPrecio?>,<?=$CheckP4?>,4,'Premium')">
  </th>
</tr>

<tr class="text-center align-middle <?=$ocultarInfo?>" style="<?=$vopakP5;?>">
  <th style="background-color: #e01883;" class="text-white"><?=$no5?></th>
  <td>Pick up</td>
  <td>Vopack</td>
  <td class="super text-center font-weight-bold">Premium</td>
  <td class="text-center ">$ <?=number_format($PrecioP5,2);?></td>
  <td class="text-center fw-bold">$ <?=number_format($DiferenciaP5,2);?></td>
  <td>Network</td>
  <td>Vientos del norte</td>
  <th class="align-middle text-center p-2 <?=$ocultarTH?>" width="15px">
    <img class="pointer <?=$disableP5?>" src="<?=RUTA_IMG_ICONOS?>precio-bajo.png" onclick="SelPrecioBajo(<?=$GET_idPrecio?>,<?=$CheckP5?>,5,'Premium')">
  </th>
</tr>


<tr class="text-center align-middle" style="<?=$tdP6;?>">
  <th style="background-color: #e01883;" class="text-white"><?=$no6?></th>
  <td>Pick up</td>
  <td>Tuxpan</td>
  <td class="super text-center font-weight-bold">Premium</td>
  <td class="text-center ">$ <?=number_format($PrecioP6,2);?></td>
  <td class="text-center fw-bold">$ <?=number_format($DiferenciaP6,2);?></td>
  <td>Network</td>
  <td>Vientos del norte</td>
  <th class="align-middle text-center p-2 <?=$ocultarTH?>" width="15px">
    <img class="pointer <?=$disableP6?>" src="<?=RUTA_IMG_ICONOS?>precio-bajo.png" onclick="SelPrecioBajo(<?=$GET_idPrecio?>,<?=$CheckP6?>,6,'Premium')">
  </th>
</tr>


<tr class="text-center align-middle" style="<?=$tdP7;?>">
  <th style="background-color: #e01883;" class="text-white"><?=$no7?></th>
  <td>Pick up</td>
  <td>Monterra</td>
  <td class="super text-center font-weight-bold">Premium</td>
  <td class="text-center ">$ <?=number_format($PrecioP7,2);?></td>
  <td class="text-center fw-bold">$ <?=number_format($DiferenciaP7,2);?></td>
  <td>Network</td>
  <td>Vientos del norte</td>
  <th class="align-middle text-center p-2 <?=$ocultarTH?>" width="15px">
    <img class="pointer <?=$disableP7?>" src="<?=RUTA_IMG_ICONOS?>precio-bajo.png" onclick="SelPrecioBajo(<?=$GET_idPrecio?>,<?=$CheckP7?>,7,'Premium')">
  </th>
</tr>


<tr class="text-center align-middle <?=$tdP8C?>" id="Super8" style="<?=$tdP8;?>">
  <th style="background-color: #e01883;" class="text-white"><?=$no8?></th>
  <td>Pick up/Simsa</td>
  <td>Monterra</td>
  <td class="super text-center font-weight-bold">Premium</td>
  <td class="text-center">$ <?=$PrecioP8;?></td>
  <td class="text-center fw-bold">$ <?=$DiferenciaP8;?></td>
  <td>Network</td>
  <td>Vientos del norte</td>
  <th class="align-middle text-center p-2 <?=$ocultarTH?>" width="15px">
    <img class="pointer" src="<?=RUTA_IMG_ICONOS?>precio-bajo.png" onclick="SelPrecioBajo(<?=$GET_idPrecio?>,<?=$CheckP8?>,8,'Premium')">
  </th>
</tr>


<tr class="text-center align-middle" style="<?=$tdP9;?>">
  <th style="background-color: #e01883;" class="text-white"><?=$no9?></th>
  <td>Pick up/Valero</td>
  <td>Tizayuca</td>
  <td class="super text-center font-weight-bold">Premium</td>
  <td class="text-center ">$ <?=number_format($PrecioP9,2);?></td>
  <td class="text-center fw-bold">$ <?=number_format($DiferenciaP9,2);?></td>
  <td>Network</td>
  <td>Vientos del norte</td>
  <th class="align-middle text-center p-2 <?=$ocultarTH?>" width="15px">
    <img class="pointer <?=$disableP9?>" src="<?=RUTA_IMG_ICONOS?>precio-bajo.png" onclick="SelPrecioBajo(<?=$GET_idPrecio?>,<?=$CheckP9?>,9,'Premium')">
  </th>
</tr>

<tr class="text-center align-middle" style="<?=$tdP10;?>">
  <th style="background-color: #e01883;" class="text-white"><?=$no10?></th>
  <td>Pick up/Valero</td>
  <td>Puebla</td>
  <td class="super text-center font-weight-bold">Premium</td>
  <td class="text-center ">$ <?=number_format($PrecioP10,2);?></td>
  <td class="text-center fw-bold">$ <?=number_format($DiferenciaP10,2);?></td>
  <td>Network</td>
  <td>Vientos del norte</td>
  <th class="align-middle text-center p-2 <?=$ocultarTH?>" width="15px">
    <img class="pointer <?=$disableP10?>" src="<?=RUTA_IMG_ICONOS?>precio-bajo.png" onclick="SelPrecioBajo(<?=$GET_idPrecio?>,<?=$CheckP10?>,10,'Premium')">
  </th>
</tr> 

<!---------- PRECIOS DIESEL ---------->

<tr class="text-center align-middle" style="<?=$tdD1;?>">
  <th style="background-color: #5c108c;" class="text-white"><?=$no1?></th>
  <td>Network Pemex</td>
  <td>Azcapozalco</td>
  <td class="super text-center font-weight-bold">Diesel</td>
  <td class="text-center ">$ <?=number_format($PrecioD1,2);?></td>
  <td class="text-center fw-bold">$ <?=$DiferenciaD1;?></td>
  <td>Network</td>
  <td>Pemex</td>
  <th class="align-middle text-center p-2 <?=$ocultarTH?>" width="15px">
    <img class="pointer <?=$disableD1?>" src="<?=RUTA_IMG_ICONOS?>precio-bajo.png" onclick="SelPrecioBajo(<?=$GET_idPrecio?>,<?=$CheckD1?>,1,'Diesel')">
  </th>
</tr>

<tr class="text-center align-middle <?=$ocultarInfo?>" style="<?=$vopakD2;?>">
  <th style="background-color: #5c108c;" class="text-white"><?=$no2?></th>
  <td>Delivery G500</td>
  <td>Vopack</td>
  <td class="super text-center font-weight-bold">Diesel</td>
  <td class="text-center ">$ <?=number_format($PrecioD2,2);?></td>
  <td class="text-center fw-bold">$ <?=number_format($DiferenciaD2,2);?></td>
  <td>Network</td>
  <td>Network</td>
  <th class="align-middle text-center p-2 <?=$ocultarTH?>" width="15px">
    <img class="pointer <?=$disableD2?>" src="<?=RUTA_IMG_ICONOS?>precio-bajo.png" onclick="SelPrecioBajo(<?=$GET_idPrecio?>,<?=$CheckD2?>,2,'Diesel')">
  </th>
</tr>

<tr class="text-center align-middle" style="<?=$tdD3;?>">
  <th style="background-color: #5c108c;" class="text-white"><?=$no3?></th>
  <td>Delivery G500</td>
  <td>Tuxpan</td>
  <td class="super text-center font-weight-bold">Diesel</td>
  <td class="text-center ">$ <?=number_format($PrecioD3,2);?></td>
  <td class="text-center fw-bold">$ <?=number_format($DiferenciaD3,2);?></td>
  <td>Network</td>
  <td>Network</td>
  <th class="align-middle text-center p-2 <?=$ocultarTH?>" width="15px">
    <img class="pointer <?=$disableD3?>" src="<?=RUTA_IMG_ICONOS?>precio-bajo.png" onclick="SelPrecioBajo(<?=$GET_idPrecio?>,<?=$CheckD3?>,3,'Diesel')">
  </th>
</tr>
 
<tr class="text-center align-middle" style="<?=$tdD4;?>">
  <th style="background-color: #5c108c;" class="text-white"><?=$no4?></th>
  <td>Delivery G500</td>
  <td>Monterra</td>
  <td class="super text-center font-weight-bold">Diesel</td>
  <td class="text-center ">$ <?=number_format($PrecioD4,2);?></td>
  <td class="text-center fw-bold">$ <?=number_format($DiferenciaD4,2);?></td>
  <td>Network</td>
  <td>Network</td>
  <th class="align-middle text-center p-2 <?=$ocultarTH?>" width="15px">
    <img class="pointer <?=$disableD4?>" src="<?=RUTA_IMG_ICONOS?>precio-bajo.png" onclick="SelPrecioBajo(<?=$GET_idPrecio?>,<?=$CheckD4?>,4,'Diesel')">
  </th>
</tr>

<tr class="text-center align-middle <?=$ocultarInfo?>" style="<?=$vopakD5;?>">
  <th style="background-color: #5c108c;" class="text-white"><?=$no5?></th>
  <td>Pick up</td>
  <td>Vopack</td>
  <td class="super text-center font-weight-bold">Diesel</td>
  <td class="text-center ">$ <?=number_format($PrecioD5,2);?></td>
  <td class="text-center fw-bold">$ <?=number_format($DiferenciaD5,2);?></td>
  <td>Network</td>
  <td>Vientos del norte</td>
  <th class="align-middle text-center p-2 <?=$ocultarTH?>" width="15px">
    <img class="pointer <?=$disableD5?>" src="<?=RUTA_IMG_ICONOS?>precio-bajo.png" onclick="SelPrecioBajo(<?=$GET_idPrecio?>,<?=$CheckD5?>,5,'Diesel')">
  </th>
</tr>


<tr class="text-center align-middle" style="<?=$tdD6;?>">
  <th style="background-color: #5c108c;" class="text-white"><?=$no6?></th>
  <td>Pick up</td>
  <td>Tuxpan</td>
  <td class="super text-center font-weight-bold">Diesel</td>
  <td class="text-center ">$ <?=number_format($PrecioD6,2);?></td>
  <td class="text-center fw-bold">$ <?=number_format($DiferenciaD6,2);?></td>
  <td>Network</td>
  <td>Vientos del norte</td>
  <th class="align-middle text-center p-2 <?=$ocultarTH?>" width="15px">
    <img class="pointer <?=$disableD6?>" src="<?=RUTA_IMG_ICONOS?>precio-bajo.png" onclick="SelPrecioBajo(<?=$GET_idPrecio?>,<?=$CheckD6?>,6,'Diesel')">
  </th>
</tr>


<tr class="text-center align-middle" style="<?=$tdD7;?>">
  <th style="background-color: #5c108c;" class="text-white"><?=$no7?></th>
  <td>Pick up</td>
  <td>Monterra</td>
  <td class="super text-center font-weight-bold">Diesel</td>
  <td class="text-center ">$ <?=number_format($PrecioD7,2);?></td>
  <td class="text-center fw-bold">$ <?=number_format($DiferenciaD7,2);?></td>
  <td>Network</td>
  <td>Vientos del norte</td>
  <th class="align-middle text-center p-2 <?=$ocultarTH?>" width="15px">
    <img class="pointer <?=$disableD7?>" src="<?=RUTA_IMG_ICONOS?>precio-bajo.png" onclick="SelPrecioBajo(<?=$GET_idPrecio?>,<?=$CheckD7?>,7,'Diesel')">
  </th>
</tr>


<tr class="text-center align-middle <?=$tdD8C?>" id="Super8" style="<?=$tdD8;?>">
  <th style="background-color: #5c108c;" class="text-white"><?=$no8?></th>
  <td>Pick up/Simsa</td>
  <td>Monterra</td>
  <td class="super text-center font-weight-bold">Diesel</td>
  <td class="text-center">$ <?=$PrecioD8;?></td>
  <td class="text-center fw-bold">$ <?=$DiferenciaD8;?></td>
  <td>Network</td>
  <td>Vientos del norte</td>
  <th class="align-middle text-center p-2 <?=$ocultarTH?>" width="15px">
    <img class="pointer " src="<?=RUTA_IMG_ICONOS?>precio-bajo.png" onclick="SelPrecioBajo(<?=$GET_idPrecio?>,<?=$CheckD8?>,8,'Diesel')">
  </th>
</tr>


<tr class="text-center align-middle" style="<?=$tdD9;?>">
  <th style="background-color: #5c108c;" class="text-white"><?=$no9?></th>
  <td>Pick up/Valero</td>
  <td>Tizayuca</td>
  <td class="super text-center font-weight-bold">Diesel</td>
  <td class="text-center ">$ <?=number_format($PrecioD9,2);?></td>
  <td class="text-center fw-bold">$ <?=number_format($DiferenciaD9,2);?></td>
  <td>Network</td>
  <td>Vientos del norte</td>
  <th class="align-middle text-center p-2 <?=$ocultarTH?>" width="15px">
    <img class="pointer <?=$disableD9?>" src="<?=RUTA_IMG_ICONOS?>precio-bajo.png" onclick="SelPrecioBajo(<?=$GET_idPrecio?>,<?=$CheckD9?>,9,'Diesel')">
  </th>
</tr>

<tr class="text-center align-middle" style="<?=$tdD10;?>">
  <th style="background-color: #5c108c;" class="text-white"><?=$no10?></th>
  <td>Pick up/Valero</td>
  <td>Puebla</td>
  <td class="super text-center font-weight-bold">Diesel</td>
  <td class="text-center ">$ <?=number_format($PrecioD10,2);?></td>
  <td class="text-center fw-bold">$ <?=number_format($DiferenciaD10,2);?></td>
  <td>Network</td>
  <td>Vientos del norte</td>
  <th class="align-middle text-center p-2 <?=$ocultarTH?>" width="15px">
    <img class="pointer <?=$disableD10?>" src="<?=RUTA_IMG_ICONOS?>precio-bajo.png" onclick="SelPrecioBajo(<?=$GET_idPrecio?>,<?=$CheckD10?>,10,'Diesel')">
  </th>
</tr>


</tbody>   
</table>

</div>
</div>