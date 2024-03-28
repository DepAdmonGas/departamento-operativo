<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

?>
<html lang="es">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Dirección de operaciones</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <link rel="shortcut icon" href="<?php echo RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="apple-touch-icon" href="<?php echo RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="stylesheet" href="<?php echo RUTA_CSS ?>alertify.css">
  <link rel="stylesheet" href="<?php echo RUTA_CSS ?>themes/default.rtl.css">
  <link href="<?php echo RUTA_CSS ?>bootstrap.css" rel="stylesheet" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?php echo RUTA_JS ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  <style media="screen">
  .LoaderPage {
  position: fixed;
  left: 0px;
  top: 0px;
  width: 100%;
  height: 100%;
  z-index: 9999;
  background: url('../imgs/iconos/load-img.gif') 50% 50% no-repeat rgb(249,249,249);
  }
  .super{
    background-color: #74bc1f;
    color: white;
  }
    .premium{
    background-color: #e01883; 
    color: white;
  }
  .diesel{
    background-color: #5c108c;
    color: white;    
  }
  </style>
  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  $('[data-toggle="tooltip"]').tooltip();

  });

  function Regresar(){
   window.history.back();
  }


  </script>
  </head>
  <body>
<div class="LoaderPage"></div>

<div class="p-4">
   <div class="card">
  <div class="card-body">
    <div class="border-bottom pb-3">
    <div class="float-left">
    <h5 class="card-title"><img class="pr-2" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()"> Detalle formato de precios</h5>
    </div>

    <br>

    </div>

<?php 
$sqlFormato = "SELECT * FROM op_formato_precios WHERE id = '".$GET_idPrecio."' ";
$resultFormato = mysqli_query($con, $sqlFormato);
$numeroFormato = mysqli_num_rows($resultFormato);
while($rowFormato = mysqli_fetch_array($resultFormato, MYSQLI_ASSOC)){
$fecha = $rowFormato['fecha'];
}

echo '<h6 class="mt-3">'.FormatoFecha($fecha).'</h6>';
 ?>

<div class="row">
  <div class="col-10">
 <table class="table table-sm table-bordered mt-2" style="font-size: .85em;">
  <thead>
    <tr>
      <th class="text-center align-middle p-2">Producto</th>
      <th class="text-center align-middle p-2">Pemex</th>
      <th class="text-center align-middle p-2">Delivery G500 Network-Vopack</th>
      <th class="text-center align-middle p-2 table-info">Diferencia vs pemex</th>
      <th class="text-center align-middle p-2">Delivery G500 Network-Tuxpan</th>
      <th class="text-center align-middle p-2 table-info">Diferencia vs pemex</th>
      <th class="text-center align-middle p-2">Pick up  G500 Network-Vopack</th>
      <th class="text-center align-middle p-2 table-info">Diferencia vs pemex</th>
      <th class="text-center align-middle p-2">Pick up G500 Network-Tuxpan</th>
      <th class="text-center align-middle p-2 table-info">Diferencia vs pemex</th>
      <th class="text-center align-middle p-2">Tuxpan G500 CORP</th>
      <th class="text-center align-middle p-2 table-info">Diferencia vs Pemex</th>
      <th class="text-center align-middle p-2">Tizayuca</th>
      <th class="text-center align-middle p-2 table-info">Tizayuca vs/pemex</th>
      <th class="text-center align-middle p-2">$ Pick up sin flete</th>
    </tr>
  </thead>
  <tbody>

    <?php 
$sql_lista = "SELECT * FROM op_formato_precios_detalle WHERE id_precio = '".$GET_idPrecio."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$id = $row_lista['id'];
$pemex = $row_lista['pemex']; 
$delivery = $row_lista['delivery'];
$pickupvopack = $row_lista['pickup_vopack'];
$pickuptuxpan = $row_lista['pickup_tuxpan']; 
$tizayuca = $row_lista['tizayuca']; 
$pickupsinflete = $row_lista['pickup_sinflete']; 
$tuxpang500 = $row_lista['tuxpan_g500']; 
$deliveryvopack = $row_lista['delivery_vopack'];
$deliverytuxpan = $row_lista['delivery_tuxpan']; 

$Dif1 = $deliveryvopack - $pemex;
$Dif2 = $deliverytuxpan - $pemex;
$Dif3 = $pickupvopack - $pemex;
$Dif4 = $pickuptuxpan - $pemex;
$Dif5 = $tuxpang500 - $pemex;
$Dif6 = $tizayuca - $pemex;

if($row_lista['producto'] == "Super"){
$ColorProducto = "super";
}else if($row_lista['producto'] == "Premium"){
$ColorProducto = "premium";
}else if($row_lista['producto'] == "Diesel"){
$ColorProducto = "diesel"; 
}

echo '<tr>
<td class="align-middle '.$ColorProducto.' p-2"><b>'.$row_lista['producto'].'</b></td>
<td class="text-center table-dark text-white">$ '.number_format($pemex,2).'</td>
<td class="text-center">$ '.number_format($deliveryvopack,2).'</td>
<td class="text-center table-info font-weight-bold">$ '.number_format($Dif1,2).'</td>
<td class="text-center">$ '.number_format($deliverytuxpan,2).'</td>
<td class="text-center table-info font-weight-bold">$ '.number_format($Dif2,2).'</td>
<td class="text-center">$ '.number_format($pickupvopack,2).'</td>
<td class="text-center table-info font-weight-bold">$ '.number_format($Dif3,2).'</td>
<td class="text-center">$ '.number_format($pickuptuxpan,2).'</td>
<td class="text-center table-info font-weight-bold">$ '.number_format($Dif4,2).'</td>
<td class="text-center">$ '.number_format($tuxpang500,2).'</td>
<td class="text-center table-info font-weight-bold">$ '.number_format($Dif5,2).'</td>
<td class="text-center">$ '.number_format($tizayuca,2).'</td>
<td class="text-center table-info font-weight-bold">$ '.number_format($Dif6,2).'</td>
<td class="text-center">$ '.number_format($pickupsinflete,2).'</td>
</tr>'; 
}
?>
   </tbody>
  
</table>
</div>
<div class="col-2">

    <table class="table table-sm table-bordered mt-2" style="font-size: .85em;">
  <thead>
    <tr>
      <th class="align-middle text-center p-2 table-primary" colspan="2">Precio Transporte</th>
    </tr>
  </thead>
  <tbody>

<?php 
$sql = "SELECT * FROM op_formato_precios_transporte WHERE id_formato = '".$GET_idPrecio."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

echo '<tr>
<td class=""><b>'.$row['detalle'].'</b></td>

<td class="text-center">$ '.number_format($row['precio'],2).'</td>
</tr>';

}
?>    
  </tbody>
   
</table>
</div>
</div>

<hr>

<h5>Reporte precios </h5>
 
<?php 
function Precio($idPrecio,$num,$producto,$con){

if($num == 1){
$select = " pemex AS valorprecio ";
$where = "AND producto = '".$producto."' ";
}else if($num == 2){
$select = " delivery_vopack AS valorprecio ";
$where = "AND producto = '".$producto."' ";
}else if($num == 3){
$select = " delivery_tuxpan AS valorprecio ";
$where = "AND producto = '".$producto."' ";
}else if($num == 4){
$select = " pickup_vopack AS valorprecio ";
$where = "AND producto = '".$producto."' ";
}else if($num == 5){
$select = " pickup_tuxpan AS valorprecio ";
$where = "AND producto = '".$producto."' ";
}else if($num == 6){
$select = " tuxpan_g500 AS valorprecio ";
$where = "AND producto = '".$producto."' ";
}else if($num == 7){
$select = " tizayuca AS valorprecio ";
$where = "AND producto = '".$producto."' ";
}

$sql2 = "SELECT $select FROM op_formato_precios_detalle WHERE id_precio = '".$idPrecio."' $where ";
$result2 = mysqli_query($con, $sql2);
$numero2 = mysqli_num_rows($result2);
while($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)){

$valorprecio = $row2['valorprecio'];

}

return $valorprecio;
}


$Precio1 = Precio($GET_idPrecio,1,'Super',$con);
$Precio2 = Precio($GET_idPrecio,2,'Super',$con);
$Precio3 = Precio($GET_idPrecio,3,'Super',$con);
$Precio4 = Precio($GET_idPrecio,4,'Super',$con);
$Precio5 = Precio($GET_idPrecio,5,'Super',$con);
$Precio6 = Precio($GET_idPrecio,6,'Super',$con);
$Precio7 = Precio($GET_idPrecio,7,'Super',$con);

$Precio8 = Precio($GET_idPrecio,1,'Premium',$con);
$Precio9 = Precio($GET_idPrecio,2,'Premium',$con);
$Precio10 = Precio($GET_idPrecio,3,'Premium',$con);
$Precio11 = Precio($GET_idPrecio,4,'Premium',$con);
$Precio12 = Precio($GET_idPrecio,5,'Premium',$con);
$Precio13 = Precio($GET_idPrecio,6,'Premium',$con);
$Precio14 = Precio($GET_idPrecio,7,'Premium',$con);

$Precio15 = Precio($GET_idPrecio,1,'Diesel',$con);
$Precio16 = Precio($GET_idPrecio,2,'Diesel',$con);
$Precio17 = Precio($GET_idPrecio,3,'Diesel',$con);
$Precio18 = Precio($GET_idPrecio,4,'Diesel',$con);
$Precio19 = Precio($GET_idPrecio,5,'Diesel',$con);
$Precio20 = Precio($GET_idPrecio,6,'Diesel',$con);
$Precio21 = Precio($GET_idPrecio,7,'Diesel',$con);

$Diferencia1 = "0.00";
$Diferencia2 = $Precio2 - $Precio1;
$Diferencia3 = $Precio3 - $Precio1;
$Diferencia4 = $Precio4 - $Precio1;
$Diferencia5 = $Precio5 - $Precio1;
$Diferencia6 = $Precio6 - $Precio1;
$Diferencia7 = $Precio7 - $Precio1;

$Diferencia8 = "0.00";
$Diferencia9 = $Precio9 - $Precio8;
$Diferencia10 = $Precio10 - $Precio8;
$Diferencia11 = $Precio11 - $Precio8;
$Diferencia12 = $Precio12 - $Precio8;
$Diferencia13 = $Precio13 - $Precio8;
$Diferencia14 = $Precio14 - $Precio8;

$Diferencia15 = "0.00";
$Diferencia16 = $Precio16 - $Precio15;
$Diferencia17 = $Precio17 - $Precio15;
$Diferencia18 = $Precio18 - $Precio15;
$Diferencia19 = $Precio19 - $Precio15;
$Diferencia20 = $Precio20 - $Precio15;
$Diferencia21 = $Precio21 - $Precio15;

$Min1 = min(array($Precio1, $Precio2, $Precio3, $Precio4, $Precio5, $Precio6, $Precio7));
$Min2 = min(array($Precio8, $Precio9, $Precio10, $Precio11, $Precio12, $Precio13, $Precio14));
$Min3 = min(array($Precio15, $Precio16, $Precio17, $Precio18, $Precio19, $Precio20, $Precio21));

if($Min1 == $Precio1){
$td1 = "table-warning";
}

if($Min1 == $Precio2){
$td2 = "table-warning";
}

if($Min1 == $Precio3){
$td3 = "table-warning";
}

if($Min1 == $Precio4){
$td4 = "table-warning";
}

if($Min1 == $Precio5){
$td5 = "table-warning";
}

if($Min1 == $Precio6){
$td6 = "table-warning";
}

if($Min1 == $Precio7){
$td7 = "table-warning";
}
//------------------------------------------------
if($Min2 == $Precio8){
$td8 = "table-warning";
}

if($Min2 == $Precio9){
$td9 = "table-warning";
}

if($Min2 == $Precio10){
$td10 = "table-warning";
}

if($Min2 == $Precio11){
$td11 = "table-warning";
}

if($Min2 == $Precio12){
$td12 = "table-warning";
}

if($Min2 == $Precio13){
$td13 = "table-warning";
}

if($Min2 == $Precio14){
$td14 = "table-warning";
}
//------------------------------------------------
if($Min3 == $Precio15){
$td15 = "table-warning";
}

if($Min3 == $Precio16){
$td16 = "table-warning";
}

if($Min3 == $Precio17){
$td17 = "table-warning";
}

if($Min3 == $Precio18){
$td18 = "table-warning";
}

if($Min3 == $Precio19){
$td19 = "table-warning";
}

if($Min3 == $Precio20){
$td20 = "table-warning";
}

if($Min3 == $Precio21){
$td21 = "table-warning";
}
?>

  <table class="table table-sm table-bordered mt-2" style="font-size: .85em;">
  <thead class="table-primary">
    <tr class="">
      <th class="align-middle text-center p-2">Modalidad</th> 
      <th class="align-middle text-center p-2">Terminal</th>  
      <th class="align-middle text-center p-2">Producto</th>  
      <th class="align-middle text-center p-2" width="180">Precio</th>  
      <th class="align-middle text-center p-2" width="180">Diferencia vs Pemex</th> 
      <th class="align-middle text-center p-2">Comercializa</th>  
      <th class="align-middle text-center p-2">Distribuye</th>
    </tr>
  </thead>
  <tbody>

<tr>
  <td>Network Pemex</td>
  <td>Azcapozalco</td>
  <td class="super text-center font-weight-bold">Super</td>
  <td class="text-center <?=$td1;?>">$ <?=number_format($Precio1,2);?></td>
  <td class="text-center bg-light">$ <?=$Diferencia1;?></td>
  <td>Network</td>
  <td>Pemex</td>
</tr>
<tr>
  <td>Delivery G500</td>
  <td>Vopack</td>
  <td class="super text-center font-weight-bold">Super</td>
  <td class="text-center <?=$td2;?>">$ <?=number_format($Precio2,2);?></td>
  <td class="text-center bg-light">$ <?=number_format($Diferencia2,2);?></td>
  <td>Network</td>
  <td>Network</td>
</tr>
<tr>
  <td>Delivery G500</td>
  <td>Tuxpan</td>
  <td class="super text-center font-weight-bold">Super</td>
  <td class="text-center <?=$td3;?>">$ <?=number_format($Precio3,2);?></td>
  <td class="text-center bg-light">$ <?=number_format($Diferencia3,2);?></td>
  <td>Network</td>
  <td>Network</td>
</tr>
<tr>
  <td>Pick up</td>
  <td>Vopack</td>
  <td class="super text-center font-weight-bold">Super</td>
  <td class="text-center <?=$td4;?>">$ <?=number_format($Precio4,2);?></td>
  <td class="text-center bg-light">$ <?=number_format($Diferencia4,2);?></td>
  <td>Network</td>
  <td>Vientos del norte</td>
</tr>
<tr>
  <td>Pick up</td>
  <td>Tuxpan</td>
  <td class="super text-center font-weight-bold">Super</td>
  <td class="text-center <?=$td5;?>">$ <?=number_format($Precio5,2);?></td>
  <td class="text-center bg-light">$ <?=number_format($Diferencia5,2);?></td>
  <td>Network</td>
  <td>Vientos del norte</td>
</tr>
<tr>
  <td>pick up/Simsa</td>
  <td>Tuxpan</td>
  <td class="super text-center font-weight-bold">Super</td>
  <td class="text-center <?=$td6;?>">$ <?=number_format($Precio6,2);?></td>
  <td class="text-center bg-light">$ <?=number_format($Diferencia6,2);?></td>
  <td>Corp</td>
  <td>Vientos del norte</td>
</tr>
<tr>
  <td>Pick up/Valero</td>
  <td>Tizayuca</td>
  <td class="super text-center font-weight-bold">Super</td>
  <td class="text-center <?=$td7;?>">$ <?=number_format($Precio7,2);?></td>
  <td class="text-center bg-light">$ <?=number_format($Diferencia7,2);?></td>
  <td>Corp</td>
  <td>Vientos del norte</td>
</tr>



<tr>
  <td>Network Pemex</td>
  <td>Pemex</td>
  <td class="premium text-center font-weight-bold">Premium</td>
  <td class="text-center <?=$td8;?>">$ <?=number_format($Precio8,2);?></td>
  <td class="text-center bg-light">$ <?=$Diferencia8;?></td>
  <td>Network</td>
  <td>Pemex</td>
</tr>
<tr>
  <td>Delivery G500</td>
  <td>Vopack</td>
  <td class="premium text-center font-weight-bold">Premium</td>
  <td class="text-center <?=$td9;?>">$ <?=number_format($Precio9,2);?></td>
  <td class="text-center bg-light">$ <?=number_format($Diferencia9,2);?></td>
  <td>Network</td>
  <td>Network</td>
</tr>
<tr>
  <td>Delivery G500</td>
  <td>Tuxpan</td>
  <td class="premium text-center font-weight-bold">Premium</td>
  <td class="text-center <?=$td10;?>">$ <?=number_format($Precio10,2);?></td>
  <td class="text-center bg-light">$ <?=number_format($Diferencia10,2);?></td>
  <td>Network</td>
  <td>Network</td>
</tr>
<tr>
  <td>Pick up</td>
  <td>Vopack</td>
  <td class="premium text-center font-weight-bold">Premium</td>
  <td class="text-center <?=$td11;?>">$ <?=number_format($Precio11,2);?></td>
  <td class="text-center bg-light">$ <?=number_format($Diferencia11,2);?></td>
  <td>Network</td>
  <td>Vientos del norte</td>
</tr>
<tr>
  <td>Pick up</td>
  <td>Tuxpan</td>
  <td class="premium text-center font-weight-bold">Premium</td>
  <td class="text-center <?=$td12;?>">$ <?=number_format($Precio12,2);?></td>
  <td class="text-center bg-light">$ <?=number_format($Diferencia12,2);?></td>
  <td>Network</td>
  <td>Vientos del norte</td>
</tr>
<tr>
  <td>pick up/Simsa</td>
  <td>Tuxpan</td>
  <td class="premium text-center font-weight-bold">Premium</td>
  <td class="text-center <?=$td13;?>">$ <?=number_format($Precio13,2);?></td>
  <td class="text-center bg-light">$ <?=number_format($Diferencia13,2);?></td>
  <td>corp</td>
  <td>Vientos del norte</td>
</tr>
<tr>
  <td>Pick up/Valero</td>
  <td>Tizayuca</td>
  <td class="premium text-center font-weight-bold">Premium</td>
  <td class="text-center <?=$td14;?>">$ <?=number_format($Precio14,2);?></td>
  <td class="text-center bg-light">$ <?=number_format($Diferencia14,2);?></td>
  <td>corp</td>
  <td>Vientos del norte</td>
</tr>







<tr>
  <td>Network Pemex</td>
  <td>Pemex</td>
  <td class="diesel text-center font-weight-bold">Diesel</td>
  <td class="text-center <?=$td15;?>">$ <?=number_format($Precio15,2);?></td>
  <td class="text-center bg-light">$ <?=$Diferencia15;?></td>
  <td>Network</td>
  <td>Pemex</td>
</tr>
<tr>
  <td>Delivery G500</td>
  <td>Vopack</td>
  <td class="diesel text-center font-weight-bold">Diesel</td>
  <td class="text-center <?=$td16;?>">$ <?=number_format($Precio16,2);?></td>
  <td class="text-center bg-light">$ <?=number_format($Diferencia16,2);?></td>
  <td>Network</td>
  <td>Network</td>
</tr>
<tr>
  <td>Delivery G500</td>
  <td>Tuxpan</td>
  <td class="diesel text-center font-weight-bold">Diesel</td>
  <td class="text-center <?=$td17;?>">$ <?=number_format($Precio17,2);?></td>
  <td class="text-center bg-light">$ <?=number_format($Diferencia17,2);?></td>
  <td>Network</td>
  <td>Network</td>
</tr>
<tr>
  <td>Pick up</td>
  <td>Vopack</td>
  <td class="diesel text-center font-weight-bold">Diesel</td>
  <td class="text-center <?=$td18;?>">$ <?=number_format($Precio18,2);?></td>
  <td class="text-center bg-light">$ <?=number_format($Diferencia18,2);?></td>
  <td>Network</td>
  <td>Vientos del norte</td>
</tr>
<tr>
  <td>Pick up</td>
  <td>Tuxpan</td>
  <td class="diesel text-center font-weight-bold">Diesel</td>
  <td class="text-center <?=$td19;?>">$ <?=number_format($Precio19,2);?></td>
  <td class="text-center bg-light">$ <?=number_format($Diferencia19,2);?></td>
  <td>Network</td>
  <td>Vientos del norte</td>
</tr>
<tr>
  <td>pick up/Simsa</td>
  <td>Tuxpan</td>
  <td class="diesel text-center font-weight-bold">Diesel</td>
  <td class="text-center <?=$td20;?>">$ <?=number_format($Precio20,2);?></td>
  <td class="text-center bg-light">$ <?=number_format($Diferencia20,2);?></td>
  <td>corp</td>
  <td>Vientos del norte</td>
</tr>
<tr>
  <td>Pick up/Valero</td>
  <td>Tizayuca</td>
  <td class="diesel text-center font-weight-bold">Diesel</td>
  <td class="text-center <?=$td21;?>">$ <?=number_format($Precio21,2);?></td>
  <td class="text-center bg-light">$ <?=number_format($Diferencia21,2);?></td>
  <td>corp</td>
  <td>Vientos del norte</td>
</tr>

</tbody>   
</table>

</div>
</div>
</div>

  <script src="<?php echo RUTA_JS ?>bootstrap.min.js"></script>
  </body>
  </html>
