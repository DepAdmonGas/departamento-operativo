<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

$newDate = date('Y-m-d',$GET_dia);

function Destino($estacion){

  switch ($estacion) 
  {
    case 'Interlomas':
    $return = 'Destino 21';
    break;     
    case 'Palo Solo':
    $return = 'Destino 19';
    break;    
    case 'San Agustin':
    $return = 'Destino 20';
    break;   
    case 'Gasomira':
    $return = 'Destino 23';
    break; 
    case 'Valle de Guadalupe':
    $return = 'Destino 22';
    break;    
    case 'Esmegas':
    $return = 'Destino 24';
    break;  
    case 'Xochimilco':
    $return = 'Destino 38';
    break;         
  } 

  return $return;

}

function Estacion($idestacion, $con){
$sql = "SELECT nombre FROM tb_estaciones WHERE id = '".$idestacion."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$nombre = $row['nombre'];
}
return $nombre;
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
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  
  });

  function Regresar(){
   window.history.back();
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

  <div class="col-12 mb-3">
  <div class="cardAG">
  <div class="border-0 p-3">

    <div class="row">
    <div class="col-12">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    
    <div class="row">
    <div class="col-12">

     <h5>Precios combustible (formato)</h5>
    
    </div>
    </div>

    </div>
    </div>

  <hr>

   <?php  
echo "<div style='font-size: 1em;;'><b>Fecha: ".FormatoFecha($newDate)."</b></div>";
?>

  <div class="table-responsive">
    <table class="table table-sm table-bordered mt-3" style="font-size: .8em;">
        <tr>
          <th rowspan="3" width="90px"></th>
          <th colspan="3" class="text-center align-middle">TAD AZCAPOTZALCO</th>
          <th colspan="3" class="text-center align-middle">VOPACK/ATLACOMULCO</th>
          <th colspan="3" rowspan="2" class="text-center table-secondary align-middle">TAD AZCAPOTZALCO VS VOPACK</th>
          <th colspan="3" class="text-center align-middle">ATLACOMULCO</th>
          <th colspan="3" rowspan="2" class="text-center table-secondary align-middle">TAD AZCAPOTZALCO VS ATLACOMULCO</th>
        </tr>
        <tr>
          
          <th colspan="3" class="text-center align-middle">ENTREGA G500</th>
          <th colspan="3" class="text-center align-middle">ENTREGA G500 DELIVERY</th>
          <th colspan="3" class="text-center align-middle">AUTOABASTO/PICK UP</th>
        </tr>
        <tr>
          
          <td class="bg-success text-white text-center align-middle" width="100px">87 octanos</td>
          <td class="bg-danger text-white text-center align-middle" width="100px">91 octanos</td>
          <td class="bg-dark text-white text-center align-middle" width="100px">Diesel</td>

          <td class="bg-success text-white text-center align-middle" width="100px">87 octanos</td>
          <td class="bg-danger text-white text-center align-middle" width="100px">91 octanos</td>
          <td class="bg-dark text-white text-center align-middle" width="100px">Diesel</td>

          <td class="bg-success text-white text-center align-middle" width="100px">87 octanos</td>
          <td class="bg-danger text-white text-center align-middle" width="100px">91 octanos</td>
          <td class="bg-dark text-white text-center align-middle" width="100px">Diesel</td>

          <td class="bg-success text-white text-center align-middle" width="100px">87 octanos</td>
          <td class="bg-danger text-white text-center align-middle" width="100px">91 octanos</td>
          <td class="bg-dark text-white text-center align-middle" width="100px">Diesel</td>

          <td class="bg-success text-white text-center align-middle" width="100px">87 octanos</td>
          <td class="bg-danger text-white text-center align-middle" width="100px">91 octanos</td>
          <td class="bg-dark text-white text-center align-middle" width="100px">Diesel</td>
        </tr>
      <tbody>
        <?php

$sql_listaestacion = "SELECT * FROM op_precio_combustible WHERE fecha = '".$newDate."' AND id_estacion <= 6 ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){

$estacion = Estacion($row_listaestacion['id_estacion'], $con);

$dif1 = $row_listaestacion['dato1'] - $row_listaestacion['dato4'];
$dif2 = $row_listaestacion['dato2'] - $row_listaestacion['dato5'];
$dif3 = $row_listaestacion['dato3'] - $row_listaestacion['dato6'];

$dif4 = $row_listaestacion['dato1'] - $row_listaestacion['dato7'];
$dif5 = $row_listaestacion['dato2'] - $row_listaestacion['dato8'];
$dif6 = $row_listaestacion['dato3'] - $row_listaestacion['dato9'];

echo '<tr>';
echo '
<td class="font-weight-bold align-middle">'.Destino($estacion).' <small>'.$estacion.'</small></td>
<td class="text-end align-middle">$ '.number_format($row_listaestacion['dato1'],4).'</td>
<td class="text-end align-middle">$ '.number_format($row_listaestacion['dato2'],4).'</td>
<td class="text-end align-middle">$ '.number_format($row_listaestacion['dato3'],4).'</td>
<td class="text-end align-middle">$ '.number_format($row_listaestacion['dato4'],4).'</td>
<td class="text-end align-middle">$ '.number_format($row_listaestacion['dato5'],4).'</td>
<td class="text-end align-middle">$ '.number_format($row_listaestacion['dato6'],4).'</td>

<td class="text-end bg-light align-middle">$ '.number_format($dif1,4).'</td>
<td class="text-end bg-light align-middle">$ '.number_format($dif2,4).'</td>
<td class="text-end bg-light align-middle">$ '.number_format($dif3,4).'</td>

<td class="text-end align-middle">$ '.number_format($row_listaestacion['dato7'],4).'</td>
<td class="text-end align-middle">$ '.number_format($row_listaestacion['dato8'],4).'</td>
<td class="text-end align-middle">$ '.number_format($row_listaestacion['dato9'],4).'</td>

<td class="text-end bg-light align-middle">$ '.number_format($dif4,4).'</td>
<td class="text-end bg-light align-middle">$ '.number_format($dif5,4).'</td>
<td class="text-end bg-light align-middle">$ '.number_format($dif6,4).'</td>
';
echo '</tr>';

  }

        ?>

      </tbody>
    </table>
</div>

<div class="table-responsive">
    <table class="table table-sm table-bordered mt-3 mb-0" style="font-size: .8em;">
        <tr>
          <th rowspan="3" width="90px"></th>
          <th colspan="3" class="text-center align-middle">TAD BARRANCA</th>
          <th colspan="3" class="text-center align-middle">VOPACK/ATLACOMULCO</th>
          <th colspan="3" rowspan="2" class="text-center table-secondary align-middle">TAD BARRANCA VS VOPACK</th>
          <th colspan="3" class="text-center align-middle">ATLACOMULCO</th>
          <th colspan="3" rowspan="2" class="text-center table-secondary align-middle">TAD BARRANCA VS ATLACOMULCO</th>
        </tr>
        <tr>
          
          <th colspan="3" class="text-center align-middle">ENTREGA G500</th>
          <th colspan="3" class="text-center align-middle">ENTREGA G500 DELIVERY</th>
          <th colspan="3" class="text-center align-middle">AUTOABASTO/PICK UP</th>
        </tr>
        <tr>
          
          <td class="bg-success text-white text-center align-middle" width="100px">87 octanos</td>
          <td class="bg-danger text-white text-center align-middle" width="100px">91 octanos</td>
          <td class="bg-dark text-white text-center align-middle" width="100px">Diesel</td>

          <td class="bg-success text-white text-center align-middle" width="100px">87 octanos</td>
          <td class="bg-danger text-white text-center align-middle" width="100px">91 octanos</td>
          <td class="bg-dark text-white text-center align-middle" width="100px">Diesel</td>

          <td class="bg-success text-white text-center align-middle" width="100px">87 octanos</td>
          <td class="bg-danger text-white text-center align-middle" width="100px">91 octanos</td>
          <td class="bg-dark text-white text-center align-middle" width="100px">Diesel</td>

          <td class="bg-success text-white text-center align-middle" width="100px">87 octanos</td>
          <td class="bg-danger text-white text-center align-middle" width="100px">91 octanos</td>
          <td class="bg-dark text-white text-center align-middle" width="100px">Diesel</td>

          <td class="bg-success text-white text-center align-middle" width="100px">87 octanos</td>
          <td class="bg-danger text-white text-center align-middle" width="100px">91 octanos</td>
          <td class="bg-dark text-white text-center align-middle" width="100px">Diesel</td>
        </tr>
      <tbody>
        <?php

$sql_listaestacion1 = "SELECT * FROM op_precio_combustible WHERE fecha = '".$newDate."' AND id_estacion = 7 ";
$result_listaestacion1 = mysqli_query($con, $sql_listaestacion1);

   while($row_listaestacion1 = mysqli_fetch_array($result_listaestacion1, MYSQLI_ASSOC)){

$estacion1 = Estacion($row_listaestacion1['id_estacion'], $con);

$dif11 = $row_listaestacion1['dato1'] - $row_listaestacion1['dato4'];
$dif21 = $row_listaestacion1['dato2'] - $row_listaestacion1['dato5'];
$dif31 = $row_listaestacion1['dato3'] - $row_listaestacion1['dato6'];

$dif41 = $row_listaestacion1['dato1'] - $row_listaestacion1['dato7'];
$dif51 = $row_listaestacion1['dato2'] - $row_listaestacion1['dato8'];
$dif61 = $row_listaestacion1['dato3'] - $row_listaestacion1['dato9'];

echo '<tr>';
echo '
<td class="font-weight-bold align-middle">'.Destino($estacion1).' <small>'.$estacion1.'</small></td>
<td class="text-end align-middle">$ '.number_format($row_listaestacion1['dato1'],4).'</td>
<td class="text-end align-middle">$ '.number_format($row_listaestacion1['dato2'],4).'</td>
<td class="text-end align-middle">$ '.number_format($row_listaestacion1['dato3'],4).'</td>
<td class="text-end align-middle">$ '.number_format($row_listaestacion1['dato4'],4).'</td>
<td class="text-end align-middle">$ '.number_format($row_listaestacion1['dato5'],4).'</td>
<td class="text-end align-middle">$ '.number_format($row_listaestacion1['dato6'],4).'</td>

<td class="text-end bg-light align-middle">$ '.number_format($dif11,4).'</td>
<td class="text-end bg-light align-middle">$ '.number_format($dif21,4).'</td>
<td class="text-end bg-light align-middle">$ '.number_format($dif31,4).'</td>

<td class="text-end align-middle">$ '.number_format($row_listaestacion1['dato7'],4).'</td>
<td class="text-end align-middle">$ '.number_format($row_listaestacion1['dato8'],4).'</td>
<td class="text-end align-middle">$ '.number_format($row_listaestacion1['dato9'],4).'</td>

<td class="text-end bg-light align-middle">$ '.number_format($dif41,4).'</td>
<td class="text-end bg-light align-middle">$ '.number_format($dif51,4).'</td>
<td class="text-end bg-light align-middle">$ '.number_format($dif61,4).'</td>
';
echo '</tr>';
  }

        ?>

      </tbody>
    </table>

</div>


  </div>
  </div>
  </div>

  </div>
  </div>

  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>
