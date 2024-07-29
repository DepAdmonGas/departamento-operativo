<?php
require('app/help.php');
$sqlFormato = "SELECT * FROM op_formato_precios WHERE id = '".$GET_idPrecio."' ";
$resultFormato = mysqli_query($con, $sqlFormato);
$numeroFormato = mysqli_num_rows($resultFormato);
while($rowFormato = mysqli_fetch_array($resultFormato, MYSQLI_ASSOC)){
$fecha = $rowFormato['fecha'];
}

$fecha_formato = date_create($fecha);
$fecha_formato2 = date_format($fecha_formato,"d/m/Y");

if("2024-02-20" < $fecha){
$ocultarInfo = "d-none";
$colspanTB = "9";
}else{
$ocultarInfo = "";
$colspanTB = "13";
}


if($session_nompuesto == "Dirección de operaciones"){
$ocultar = "";
$divSize = "col-xl-5 col-lg-5 col-md-12 col-sm-12";
  
}else{
$ocultar = "d-none";
$divSize = "col-xl-5 col-lg-5 col-md-12 col-sm-12";
}

?>
<html lang="es">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Dirección de operaciones</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <link rel="shortcut icon" href="<?=RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="apple-touch-icon" href="<?=RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="stylesheet" href="<?=RUTA_CSS2 ?>alertify.css">
  <link rel="stylesheet" href="<?=RUTA_CSS2 ?>themes/default.rtl.css">
  <link href="<?=RUTA_CSS2;?>bootstrap.min.css" rel="stylesheet" />
  <link href="<?=RUTA_CSS2;?>navbar-general.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  $('[data-toggle="tooltip"]').tooltip();
  reportePrecios(<?=$GET_idPrecio?>)
  });

  function Regresar(){
  window.history.back();
  }

  function SelPrecioBajo(idPrecio,valCheck,num,producto){

  var parametros = {
  "idPrecio" : idPrecio,
  "valCheck" : valCheck,
  "num" : num,
  "producto" : producto
  };


  $.ajax({
  data:  parametros,
  url:   '../public/admin/modelo/activar-precio-combustible.php',
  type:  'post',
  beforeSend: function() {
    
  },
  complete: function(){

  },
  success:  function (response) {
  
  if (response == 1) {
  //alertify.success('Precio seleccionado exitosamente.')
  reportePrecios(idPrecio);
    
  }else{
  alertify.error('Error al seleccionar el precio.')
  }

  }
  });
 
  }
 
  function reportePrecios(idPrecio){
  $('#DivReportePrecios').load('../public/admin/vistas/lista-reporte-precios.php?idPrecio=' + idPrecio);

  }   
    
  </script> 
  </head>

  <body>
  <div class="LoaderPage"></div>

  <!---------- DIV - CONTENIDO ----------> 
  <div id="content">
  <!---------- NAV BAR - PRINCIPAL (TOP) ---------->  
  <?php include_once "public/navbar/navbar-perfil.php";?>
  <!---------- CONTENIDO PAGINA WEB----------> 
  <div class="contendAG">
  <div class="row">

  <div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.go(-1)"  class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Precios diarios de combustible</a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Detalle (<?=$ClassHerramientasDptoOperativo->FormatoFecha($fecha)?>)</li>
  </ol>
  </div>
 
  <div class="row"> 
  <div class="col-12"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Detalle (<?=$ClassHerramientasDptoOperativo->FormatoFecha($fecha)?>)</div>
  </div>

  <hr>
  </div>

  <div class="col-12 mb-3 <?=$ocultar?>">
  <div class="table-responsive">
  <table class="custom-table" style="font-size: 12.5px;" width="100%">
  
  <thead class="title-table-bg">
  <tr class="tables-bg">
  <th class="align-middle text-center" colspan="6">Precio del transporte</th>
  </tr>

  <tr>
  <td class="align-middle text-center fw-bold">Terminal</td>
  <th class="align-middle text-center">Pickup</th>
  <th class="align-middle text-center">IVA 16%</th>
  <th class="align-middle text-center">Retencion 4%</th>
  <td class="align-middle text-center fw-bold">Tarifa final transporte <br> Pickup</td>
  </tr>
  </thead>
  
  <tbody class="bg-white">
  <?php 
  $sql = "SELECT * FROM op_formato_precios_transporte WHERE id_formato = '".$GET_idPrecio."' ";
  $result = mysqli_query($con, $sql);
  $numero = mysqli_num_rows($result);
  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

  $precioT = $row['precio']; 
  $precioIVA = number_format(($precioT * 0.16),4);
  $precioRetencion = number_format(($precioT * 0.04),4);
  $totalPickUp = number_format(($precioT + $precioIVA - $precioRetencion),4);


  echo '<tr class="text-center align-middle">
  <td class="no-hover"><b>'.$row['detalle'].'</b></td>
  <td class="no-hover">$ '.number_format($precioT,2).'</td>
  <td class="no-hover">$ '.$precioIVA.'</td>
  <td class="no-hover">$ '.$precioRetencion.'</td>
  <td class="no-hover">$ '.$totalPickUp.'</td>
  </tr>';

  } 
  ?>    
  </tbody>
  
  </table>
  </div>
  </div>


<div class="col-12 mb-3 <?=$ocultar?>">
<div class="table-responsive">
<table class="custom-table" style="font-size: 12.5px;" width="100%">
<thead>

<tr class="tables-bg">
<th class="text-center align-middle"></th>
<th class="text-center align-middle" colspan="<?=$colspanTB?>">Delivery</th>
<th class="text-center align-middle" colspan="13">Pick Up</th>
</tr>

<tr>
<td class="text-center align-middle tables-bg fw-bold">Producto</td>
<th class="text-center align-middle text-white" style="background-color: #535252;">Pemex</th>

<th class="text-center align-middle" style="background-color: #d6dce4;">Delivery<br>G500 Network<br>Monterra</th>
<th class="text-center align-middle" style="background-color: #d6dce4;">Diferencia<br>vs<br>Pemex</th>

<th class="text-center align-middle <?=$ocultarInfo?>" style="background-color: #cfcfcf;">Delivery<br>G500 Network<br>Vopak</th>
<th class="text-center align-middle <?=$ocultarInfo?>" style="background-color: #cfcfcf;">Diferencia<br>vs<br>Pemex</th>

<th class="text-center align-middle" style="background-color: #e2efda;">Delivery<br>G500 Network<br>Tuxpan</th>
<th class="text-center align-middle" style="background-color: #e2efda;">Diferencia<br>vs<br>Pemex</th>

<th class="text-center align-middle <?=$ocultarInfo?>" style="background-color: #cfcfcf;">Pick up<br>G500 Network<br>Vopak</th>
<th class="text-center align-middle <?=$ocultarInfo?>" style="background-color: #cfcfcf;">Diferencia<br>vs<br>Pemex</th>

<th class="text-center align-middle" style="background-color: #e2efda;">Pick up<br>G500 Network<br>Tuxpan</th>
<th class="text-center align-middle" style="background-color: #e2efda;">Diferencia<br>vs<br>Pemex</th>

<th class="text-center align-middle" style="background-color: #d6dce4;">Pick up<br>G500 Network<br>Monterra</th>
<th class="text-center align-middle" style="background-color: #d6dce4;">Diferencia<br>vs<br>Pemex</th>

<th class="text-center align-middle" style="background-color: #94b8da;">Pick up<br>G500 Network<br>Tizayuca</th>
<th class="text-center align-middle" style="background-color: #94b8da;">Diferencia<br>vs<br>Pemex</th>

<th class="text-center align-middle" style="background-color: #922d9a;">Pick up<br>G500 Network<br>Puebla</th>
<td class="text-center align-middle fw-bold text-white" style="background-color: #922d9a;">Diferencia<br>vs<br>Pemex</td>
  
</tr>
</thead>

<tbody class="bg-white">
<?php 

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

$tuxpanVal = PrecioPU($GET_idPrecio,"Tuxpan",$con);
$vopakVal = PrecioPU($GET_idPrecio,"Vopack",$con);
$tizayucaVal = PrecioPU($GET_idPrecio,"Tizayuca",$con);
$pueblaVal = PrecioPU($GET_idPrecio,"Puebla",$con);


//---------- CONSULTAR PRECIO DETALLE ----------
$sql_lista = "SELECT * FROM op_formato_precios_detalle_c WHERE id_precio = '".$GET_idPrecio."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$id = $row_lista['id'];
$pemex = $row_lista['pemex']; 

$delivery_montera = $row_lista['delivery_montera']; 
$delivery_vopak = $row_lista['delivery_vopak']; 
$delivery_tuxpan = $row_lista['delivery_tuxpan']; 

$pickup_vopak = $row_lista['pickup_vopak'] + $vopakVal; 
$pickup_tuxpan = $row_lista['pickup_tuxpan'] + $tuxpanVal; 
$pickup_montera = $row_lista['pickup_montera']  + $tuxpanVal; 
$pickup_tizayuca = $row_lista['pickup_tizayuca'] + $tizayucaVal; 
$pickup_puebla = $row_lista['pickup_puebla'] + $pueblaVal; 

$DifPvsMoD = $delivery_montera - $pemex ;
$DifPvsVoD = $delivery_vopak - $pemex ;
$DifPvsTuD = $delivery_tuxpan - $pemex ;

$DifPvsVoP = $pickup_vopak - $pemex;
$DifPvsTuP = $pickup_tuxpan - $pemex;
$DifPvsMoP = $pickup_montera - $pemex;
$DifPvsTiP = $pickup_tizayuca - $pemex;
$DifPvsPuP = $pickup_puebla - $pemex;

$pemexBG = "";
$vopakDBG = "";
$monterraDBG = "";
$vopakDBG = "";
$tuxpanDBG = "";
$vopakpBG = "";
$tuxpanpBG = "";
$monterrapBG = "";
$tizayucapBG = "";
$pueblapBG = "";

if($row_lista['producto'] == "Super"){
$ColorProducto = "background-color: #74bc1f; color:white;";

if("2024-02-20" < $fecha){

$preciosSuper = array($delivery_montera, $delivery_tuxpan, $pickup_tuxpan, $pickup_montera, $pickup_tizayuca, $pickup_puebla, $pemex);
$numeroMenorSuper = min($preciosSuper);

if($pemex == $numeroMenorSuper){
$pemexBG = $ColorProducto;
   
}if($delivery_montera == $numeroMenorSuper){
$monterraDBG = $ColorProducto;
   
}if($delivery_tuxpan == $numeroMenorSuper){
$tuxpanDBG = $ColorProducto;
   
}if($pickup_tuxpan == $numeroMenorSuper){
$tuxpanpBG = $ColorProducto;
   
}if($pickup_montera == $numeroMenorSuper){
$monterrapBG = $ColorProducto;
   
}if($pickup_tizayuca == $numeroMenorSuper){
$tizayucapBG = $ColorProducto;
   
}if($pickup_puebla == $numeroMenorSuper){
$pueblapBG = $ColorProducto;
}
   
}else{

$preciosSuper = array($delivery_montera,$delivery_vopak, $delivery_tuxpan, $pickup_vopak, $pickup_tuxpan, $pickup_montera, $pickup_tizayuca, $pickup_puebla, $pemex);
$numeroMenorSuper = min($preciosSuper);

if($pemex == $numeroMenorSuper){
$pemexBG = $ColorProducto;
   
}if($delivery_montera == $numeroMenorSuper){
$monterraDBG = $ColorProducto;
   
}if($delivery_vopak == $numeroMenorSuper){
$vopakDBG = $ColorProducto;
   
}if($delivery_tuxpan == $numeroMenorSuper){
$tuxpanDBG = $ColorProducto;
   
}if($pickup_vopak == $numeroMenorSuper){
$vopakpBG = $ColorProducto;
   
}if($pickup_tuxpan == $numeroMenorSuper){
$tuxpanpBG = $ColorProducto;
   
}if($pickup_montera == $numeroMenorSuper){
$monterrapBG = $ColorProducto;
   
}if($pickup_tizayuca == $numeroMenorSuper){
$tizayucapBG = $ColorProducto;
   
}if($pickup_puebla == $numeroMenorSuper){
$pueblapBG = $ColorProducto;
}
   
}

echo '<tr class="align-middle text-center">

<th class="text-white" style="'.$ColorProducto.'">'.$row_lista['producto'].'</th>
<td class="" style="'.$pemexBG.'"><b>$ '.number_format($pemex,4).'</b></td>

<td style="'.$monterraDBG.'">$ '.number_format($delivery_montera,4).'</td>
<td class=" table-light font-weight-bold"><b>$ '.number_format($DifPvsMoD,4).'</b></td>

<td class="'.$ocultarInfo.'" style="'.$vopakDBG.'">$ '.number_format($delivery_vopak,4).'</td>
<td class="'.$ocultarInfo.' table-light font-weight-bold"><b>$ '.number_format($DifPvsVoD,4).'</b></td>

<td style="'.$tuxpanDBG.'">$ '.number_format($delivery_tuxpan,4).'</td>
<td class="table-light font-weight-bold"><b>$ '.number_format($DifPvsTuD,4).'</b></td>


<td class="'.$ocultarInfo.'" style="'.$vopakpBG.'">$ '.number_format($pickup_vopak ,4).'</td>
<td class="'.$ocultarInfo.' table-light font-weight-bold"><b>$ '.number_format($DifPvsVoP,4).'</b></td>

<td style="'.$tuxpanpBG.'">$ '.number_format($pickup_tuxpan ,4).'</td>
<td class=" table-light font-weight-bold"><b>$ '.number_format($DifPvsTuP,4).'</b></td>

<td style="'.$monterrapBG.'">$ '.number_format($pickup_montera,4).'</td>
<td class=" table-light font-weight-bold"><b>$ '.number_format($DifPvsMoP,4).'</b></td>

<td style="'.$tizayucapBG.'">$ '.number_format($pickup_tizayuca,4).'</td>
<td class=" table-light font-weight-bold"><b>$ '.number_format($DifPvsTiP,4).'</b></td>

<td style="'.$pueblapBG.'">$ '.number_format($pickup_puebla ,4).'</td>
<td class=" table-light font-weight-bold"><b>$ '.number_format($DifPvsPuP,4).'</b></td

</tr>'; 


}if($row_lista['producto'] == "Premium"){
$ColorProducto = "background-color: #e01883; color:white;";

if("2024-02-20" < $fecha){

 $preciosPremium = array($delivery_montera, $delivery_tuxpan, $pickup_tuxpan, $pickup_montera, $pickup_tizayuca, $pickup_puebla, $pemex);
 $numeroMenorPremium = min($preciosPremium);
 
 if($pemex == $numeroMenorPremium){
 $pemexBG = $ColorProducto;
 
 }if($delivery_montera == $numeroMenorPremium){
 $monterraDBG = $ColorProducto;
 
 }if($delivery_tuxpan == $numeroMenorPremium){
 $tuxpanDBG = $ColorProducto;
 
 }if($pickup_tuxpan == $numeroMenorPremium){
 $tuxpanpBG = $ColorProducto;
 
 }if($pickup_montera == $numeroMenorPremium){
 $monterrapBG = $ColorProducto;
 
 }if($pickup_tizayuca == $numeroMenorPremium){
 $tizayucapBG = $ColorProducto;
 
 }if($pickup_puebla == $numeroMenorPremium){
 $pueblapBG = $ColorProducto;
 }


}else{

$preciosPremium = array($delivery_montera,$delivery_vopak, $delivery_tuxpan, $pickup_vopak, $pickup_tuxpan, $pickup_montera, $pickup_tizayuca, $pickup_puebla, $pemex);
$numeroMenorPremium = min($preciosPremium);

if($pemex == $numeroMenorPremium){
$pemexBG = $ColorProducto;

}if($delivery_montera == $numeroMenorPremium){
$monterraDBG = $ColorProducto;

}if($delivery_vopak == $numeroMenorPremium){
$vopakDBG = $ColorProducto;

}if($delivery_tuxpan == $numeroMenorPremium){
$tuxpanDBG = $ColorProducto;

}if($pickup_vopak == $numeroMenorPremium){
$vopakpBG = $ColorProducto;

}if($pickup_tuxpan == $numeroMenorPremium){
$tuxpanpBG = $ColorProducto;

}if($pickup_montera == $numeroMenorPremium){
$monterrapBG = $ColorProducto;

}if($pickup_tizayuca == $numeroMenorPremium){
$tizayucapBG = $ColorProducto;

}if($pickup_puebla == $numeroMenorPremium){
$pueblapBG = $ColorProducto;
}



}

echo '<tr class="align-middle text-center">

<th class="p-3 text-white" style="'.$ColorProducto.'">'.$row_lista['producto'].'</th>
<td style="'.$pemexBG.'"><b>$ '.number_format($pemex,4).'</b></td>


<td style="'.$monterraDBG.'">$ '.number_format($delivery_montera,4).'</td>
<td class=" table-light font-weight-bold"><b>$ '.number_format($DifPvsMoD,4).'</b></td>

<td class="'.$ocultarInfo.'" style="'.$vopakDBG.'">$ '.number_format($delivery_vopak,4).'</td>
<td class="'.$ocultarInfo.' table-light font-weight-bold"><b>$ '.number_format($DifPvsVoD,4).'</b></td>

<td style="'.$tuxpanDBG.'">$ '.number_format($delivery_tuxpan,4).'</td>
<td class="table-light font-weight-bold"><b>$ '.number_format($DifPvsTuD,4).'</b></td>

<td class="'.$ocultarInfo.'" style="'.$vopakpBG.'">$ '.number_format($pickup_vopak ,4).'</td>
<td class="'.$ocultarInfo.' table-light font-weight-bold"><b>$ '.number_format($DifPvsVoP,4).'</b></td>

<td style="'.$tuxpanpBG.'">$ '.number_format($pickup_tuxpan ,4).'</td>
<td class=" table-light font-weight-bold"><b>$ '.number_format($DifPvsTuP,4).'</b></td>

<td style="'.$monterrapBG.'">$ '.number_format($pickup_montera,4).'</td>
<td class=" table-light font-weight-bold"><b>$ '.number_format($DifPvsMoP,4).'</b></td>

<td style="'.$tizayucapBG.'">$ '.number_format($pickup_tizayuca,4).'</td>
<td class=" table-light font-weight-bold"><b>$ '.number_format($DifPvsTiP,4).'</b></td>

<td style="'.$pueblapBG.'">$ '.number_format($pickup_puebla ,4).'</td>
<td class=" table-light font-weight-bold"><b>$ '.number_format($DifPvsPuP,4).'</b></td

</tr>'; 


}if($row_lista['producto'] == "Diesel"){
$ColorProducto = "background-color: #5c108c; color:white;"; 

if("2024-02-20" < $fecha){

 $preciosDiesel = array($delivery_montera, $delivery_tuxpan, $pickup_tuxpan, $pickup_montera, $pickup_tizayuca, $pickup_puebla, $pemex);
 $numeroMenorDiesel = min($preciosDiesel);
 
 if($pemex == $numeroMenorDiesel){
 $pemexBG = $ColorProducto;
 
 }if($delivery_montera == $numeroMenorDiesel){
 $monterraDBG = $ColorProducto;
 
 }if($delivery_tuxpan == $numeroMenorDiesel){
 $tuxpanDBG = $ColorProducto;
 
 }if($pickup_tuxpan == $numeroMenorDiesel){
 $tuxpanpBG = $ColorProducto;
 
 }if($pickup_montera == $numeroMenorDiesel){
 $monterrapBG = $ColorProducto;
 
 }if($pickup_tizayuca == $numeroMenorDiesel){
 $tizayucapBG = $ColorProducto;
 
 }if($pickup_puebla == $numeroMenorDiesel){
 $pueblapBG = $ColorProducto;
 }


}else{

 $preciosDiesel = array($delivery_montera,$delivery_vopak, $delivery_tuxpan, $pickup_vopak, $pickup_tuxpan, $pickup_montera, $pickup_tizayuca, $pickup_puebla, $pemex);
 $numeroMenorDiesel = min($preciosDiesel);
 
 if($pemex == $numeroMenorDiesel){
 $pemexBG = $ColorProducto;
 
 }if($delivery_montera == $numeroMenorDiesel){
 $monterraDBG = $ColorProducto;
 
 }if($delivery_vopak == $numeroMenorDiesel){
 $vopakDBG = $ColorProducto;
 
 }if($delivery_tuxpan == $numeroMenorDiesel){
 $tuxpanDBG = $ColorProducto;
 
 }if($pickup_vopak == $numeroMenorDiesel){
 $vopakpBG = $ColorProducto;
 
 }if($pickup_tuxpan == $numeroMenorDiesel){
 $tuxpanpBG = $ColorProducto;
 
 }if($pickup_montera == $numeroMenorDiesel){
 $monterrapBG = $ColorProducto;
 
 }if($pickup_tizayuca == $numeroMenorDiesel){
 $tizayucapBG = $ColorProducto;
 
 }if($pickup_puebla == $numeroMenorDiesel){
 $pueblapBG = $ColorProducto;
 }

}

echo '<tr class="align-middle text-center">

<th class="p-3 text-white" style="'.$ColorProducto.'">'.$row_lista['producto'].'</th>
<td style="'.$pemexBG.'"><b>$ '.number_format($pemex,4).'</b></td>


<td style="'.$monterraDBG.'">$ '.number_format($delivery_montera,4).'</td>
<td class=" table-light font-weight-bold"><b>$ '.number_format($DifPvsMoD,4).'</b></td>

<td class="'.$ocultarInfo.'" style="'.$vopakDBG.'">$ '.number_format($delivery_vopak,4).'</td>
<td class="'.$ocultarInfo.' table-light font-weight-bold"><b>$ '.number_format($DifPvsVoD,4).'</b></td>

<td style="'.$tuxpanDBG.'">$ '.number_format($delivery_tuxpan,4).'</td>
<td class="table-light font-weight-bold"><b>$ '.number_format($DifPvsTuD,4).'</b></td>


<td class="'.$ocultarInfo.'" style="'.$vopakpBG.'">$ '.number_format($pickup_vopak ,4).'</td>
<td class="'.$ocultarInfo.' table-light font-weight-bold"><b>$ '.number_format($DifPvsVoP,4).'</b></td>

<td style="'.$tuxpanpBG.'">$ '.number_format($pickup_tuxpan ,4).'</td>
<td class=" table-light font-weight-bold"><b>$ '.number_format($DifPvsTuP,4).'</b></td>

<td style="'.$monterrapBG.'">$ '.number_format($pickup_montera,4).'</td>
<td class=" table-light font-weight-bold"><b>$ '.number_format($DifPvsMoP,4).'</b></td>

<td style="'.$tizayucapBG.'">$ '.number_format($pickup_tizayuca,4).'</td>
<td class=" table-light font-weight-bold"><b>$ '.number_format($DifPvsTiP,4).'</b></td>

<td style="'.$pueblapBG.'">$ '.number_format($pickup_puebla ,4).'</td>
<td class=" table-light font-weight-bold"><b>$ '.number_format($DifPvsPuP,4).'</b></td

</tr>'; 

}

}
?>
</tbody>
</table>
</div>
</div>

<div class="col-12" id="DivReportePrecios"></div>

</div>
</div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>
