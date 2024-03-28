<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}


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

  function Guardar(){

  var Fecha = $('#Fecha').val();
  var IP11 = $('#IP11').val();
  var IP21 = $('#IP21').val();
  var IP31 = $('#IP31').val();
  var IP41 = $('#IP41').val();
  var IP51 = $('#IP51').val();
  var IP61 = $('#IP61').val();
  var IP71 = $('#IP71').val();
  var IP81= $('#IP81').val();
  var IP91 = $('#IP91').val();

  var IP12 = $('#IP12').val();
  var IP22 = $('#IP22').val();
  var IP32 = $('#IP32').val();
  var IP42 = $('#IP42').val();
  var IP52 = $('#IP52').val();
  var IP62 = $('#IP62').val();
  var IP72 = $('#IP72').val();
  var IP82 = $('#IP82').val();
  var IP92 = $('#IP92').val();

  var IP13 = $('#IP13').val();
  var IP23 = $('#IP23').val();
  var IP33 = $('#IP33').val();
  var IP43 = $('#IP43').val();
  var IP53 = $('#IP53').val();
  var IP63 = $('#IP63').val();
  var IP73 = $('#IP73').val();
  var IP83 = $('#IP83').val();
  var IP93 = $('#IP93').val();

  var IP14 = $('#IP14').val();
  var IP24 = $('#IP24').val();
  var IP34 = $('#IP34').val();
  var IP44 = $('#IP44').val();
  var IP54 = $('#IP54').val();
  var IP64 = $('#IP64').val();
  var IP74 = $('#IP74').val();
  var IP84 = $('#IP84').val();
  var IP94 = $('#IP94').val();

  var IP15 = $('#IP15').val();
  var IP25 = $('#IP25').val();
  var IP35 = $('#IP35').val();
  var IP45 = $('#IP45').val();
  var IP55 = $('#IP55').val();
  var IP65 = $('#IP65').val();
  var IP75 = $('#IP75').val();
  var IP85 = $('#IP85').val();
  var IP95 = $('#IP95').val();

  var IP16 = $('#IP16').val();
  var IP26 = $('#IP26').val();
  var IP36 = $('#IP36').val();
  var IP46 = $('#IP46').val();
  var IP56 = $('#IP56').val();
  var IP66 = $('#IP66').val();
  var IP76 = $('#IP76').val();
  var IP86 = $('#IP86').val();
  var IP96 = $('#IP96').val();

  var IP17 = $('#IP17').val();
  var IP27 = $('#IP27').val();
  var IP37 = $('#IP37').val();
  var IP47 = $('#IP47').val();
  var IP57 = $('#IP57').val();
  var IP67 = $('#IP67').val();
  var IP77 = $('#IP77').val();
  var IP87 = $('#IP87').val();
  var IP97 = $('#IP97').val();

 var parametros = {
      "Fecha" : Fecha,
      "IP11" : IP11,
      "IP21" : IP21,
      "IP31" : IP31,
      "IP41" : IP41,
      "IP51" : IP51,
      "IP61" : IP61,
      "IP71" : IP71,
      "IP81" : IP81,
      "IP91" : IP91,
      "IP12" : IP12,
      "IP22" : IP22,
      "IP32" : IP32,
      "IP42" : IP42,
      "IP52" : IP52,
      "IP62" : IP62,
      "IP72" : IP72,
      "IP82" : IP82,
      "IP92" : IP92,
      "IP13" : IP13,
      "IP23" : IP23,
      "IP33" : IP33,
      "IP43" : IP43,
      "IP53" : IP53,
      "IP63" : IP63,
      "IP73" : IP73,
      "IP83" : IP83,
      "IP93" : IP93,
      "IP14" : IP14,
      "IP24" : IP24,
      "IP34" : IP34,
      "IP44" : IP44,
      "IP54" : IP54,
      "IP64" : IP64,
      "IP74" : IP74,
      "IP84" : IP84,
      "IP94" : IP94,
      "IP15" : IP15,
      "IP25" : IP25,
      "IP35" : IP35,
      "IP45" : IP45,
      "IP55" : IP55,
      "IP65" : IP65,
      "IP75" : IP75,
      "IP85" : IP85,
      "IP95" : IP95,
      "IP16" : IP16,
      "IP26" : IP26,
      "IP36" : IP36,
      "IP46" : IP46,
      "IP56" : IP56,
      "IP66" : IP66,
      "IP76" : IP76,
      "IP86" : IP86,
      "IP96" : IP96,
      "IP17" : IP17,
      "IP27" : IP27,
      "IP37" : IP37,
      "IP47" : IP47,
      "IP57" : IP57,
      "IP67" : IP67,
      "IP77" : IP77,
      "IP87" : IP87,
      "IP97" : IP97
      };

     $.ajax({
     data:  parametros,
     url:   '../public/admin/modelo/agregar-precio-combustible.php',
     type:  'POST',
     beforeSend: function() {
      $(".LoaderPage").show();
     },
     complete: function(){

     },
     success:  function (response) {

      if (response == 1) {
        Regresar();
      }else{
      alertify.error('Error al agregar')
      $(".LoaderPage").hide();
      }


     }
     });
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

      <div class="row">
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
    <div class="">Fecha:</div>
    <input type="date" id="Fecha" class="form-control" style="width: 40%;font-size: .9em;" value="<?=$fecha_del_dia;?>">
    </div>

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 text-end">
    <button type="button" class="btn btn-primary " onclick="Guardar()">Guardar Formato</button>
    </div>      
    </div>

    <hr>

<div class="table-responsive">
    <table class="table table-sm table-bordered" style="font-size: .9em;">
        <tr>
          <th rowspan="3"></th>
          <th colspan="3" class="text-center">TAD AZCAPOTZALCO</th>
          <th colspan="3" class="text-center">VOPACK/ATLACOMULCO</th>
          <th colspan="3" class="text-center">ATLACOMULCO</th>
        </tr>
        <tr>
          
          <th colspan="3" class="text-center">ENTREGA G500</th>
          <th colspan="3" class="text-center">ENTREGA G500 DELIVERY</th>
          <th colspan="3" class="text-center">AUTOABASTO/PICK UP</th>
        </tr>
        <tr>
          
          <td class="bg-success text-white text-center">87 octanos</td>
          <td class="bg-danger text-white text-center">91 octanos</td>
          <td class="bg-dark text-white text-center">Diesel</td>

          <td class="bg-success text-white text-center">87 octanos</td>
          <td class="bg-danger text-white text-center">91 octanos</td>
          <td class="bg-dark text-white text-center">Diesel</td>

          <td class="bg-success text-white text-center">87 octanos</td>
          <td class="bg-danger text-white text-center">91 octanos</td>
          <td class="bg-dark text-white text-center">Diesel</td>
        </tr>
      <tbody>
        <?php

$sql_listaestacion = "SELECT id, nombre FROM tb_estaciones WHERE id <= 6";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);

   while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
    $id = $row_listaestacion['id'];
    $estacion = $row_listaestacion['nombre'];

  echo '<tr>
  <td class="font-weight-bold">'.Destino($estacion).' <small>'.$estacion.'</small></td>
  <td class="pr-1 pt-0 pb-0 pl-0 m-0 align-middle">$ <input type="number" step="any" class="border-0 p-1 text-end" style="width: 85%" id="IP1'.$id.'"></td>
  <td class="pr-1 pt-0 pb-0 pl-0 m-0 align-middle">$ <input type="number" step="any" class="border-0 p-1 text-end" style="width: 85%" id="IP2'.$id.'"></td>
  <td class="pr-1 pt-0 pb-0 pl-0 m-0 align-middle">$ <input type="number" step="any" class="border-0 p-1 text-end" style="width: 85%" id="IP3'.$id.'"></td>
  <td class="pr-1 pt-0 pb-0 pl-0 m-0 align-middle">$ <input type="number" step="any" class="border-0 p-1 text-end" style="width: 85%" id="IP4'.$id.'"></td>
  <td class="pr-1 pt-0 pb-0 pl-0 m-0 align-middle">$ <input type="number" step="any" class="border-0 p-1 text-end" style="width: 85%" id="IP5'.$id.'"></td>
  <td class="pr-1 pt-0 pb-0 pl-0 m-0 align-middle">$ <input type="number" step="any" class="border-0 p-1 text-end" style="width: 85%" id="IP6'.$id.'"></td>
  <td class="pr-1 pt-0 pb-0 pl-0 m-0 align-middle">$ <input type="number" step="any" class="border-0 p-1 text-end" style="width: 85%" id="IP7'.$id.'"></td>
  <td class="pr-1 pt-0 pb-0 pl-0 m-0 align-middle">$ <input type="number" step="any" class="border-0 p-1 text-end" style="width: 85%" id="IP8'.$id.'"></td>
  <td class="pr-1 pt-0 pb-0 pl-0 m-0 align-middle">$ <input type="number" step="any" class="border-0 p-1 text-end" style="width: 85%" id="IP9'.$id.'"></td>
  </tr>';
  }

        ?>

      </tbody>
    </table>
  </div>

<div class="table-responsive">
    <table class="table table-sm table-bordered mt-3 mb-0" style="font-size: .9em;">
        <tr>
          <th rowspan="3"></th>
          <th colspan="3" class="text-center">TAD BARRANCA</th>
          <th colspan="3" class="text-center">VOPACK/ATLACOMULCO</th>
          <th colspan="3" class="text-center">ATLACOMULCO</th>
        </tr>
        <tr>
          
          <th colspan="3" class="text-center">ENTREGA G500</th>
          <th colspan="3" class="text-center">ENTREGA G500 DELIVERY</th>
          <th colspan="3" class="text-center">AUTOABASTO/PICK UP</th>
        </tr>
        <tr>
          
          <td class="bg-success text-white text-center">87 octanos</td>
          <td class="bg-danger text-white text-center">91 octanos</td>
          <td class="bg-dark text-white text-center">Diesel</td>

          <td class="bg-success text-white text-center">87 octanos</td>
          <td class="bg-danger text-white text-center">91 octanos</td>
          <td class="bg-dark text-white text-center">Diesel</td>

          <td class="bg-success text-white text-center">87 octanos</td>
          <td class="bg-danger text-white text-center">91 octanos</td>
          <td class="bg-dark text-white text-center">Diesel</td>
        </tr>
      <tbody>
        <?php

$sql_listaestacion1 = "SELECT id, nombre FROM tb_estaciones WHERE id = 7";
$result_listaestacion1 = mysqli_query($con, $sql_listaestacion1);

   while($row_listaestacion1 = mysqli_fetch_array($result_listaestacion1, MYSQLI_ASSOC)){
    $id1 = $row_listaestacion1['id'];
    $estacion1 = $row_listaestacion1['nombre'];

echo '<tr>
  <td class="font-weight-bold">'.Destino($estacion1).' <small>'.$estacion1.'</small></td>
  <td class="pr-1 pt-0 pb-0 pl-0 m-0 align-middle">$ <input type="number" step="any" class="border-0 p-1 text-end" style="width: 85%" id="IP1'.$id1.'"></td>
  <td class="pr-1 pt-0 pb-0 pl-0 m-0 align-middle">$ <input type="number" step="any" class="border-0 p-1 text-end" style="width: 85%" id="IP2'.$id1.'"></td>
  <td class="pr-1 pt-0 pb-0 pl-0 m-0 align-middle">$ <input type="number" step="any" class="border-0 p-1 text-end" style="width: 85%" id="IP3'.$id1.'"></td>
  <td class="pr-1 pt-0 pb-0 pl-0 m-0 align-middle">$ <input type="number" step="any" class="border-0 p-1 text-end" style="width: 85%" id="IP4'.$id1.'"></td>
  <td class="pr-1 pt-0 pb-0 pl-0 m-0 align-middle">$ <input type="number" step="any" class="border-0 p-1 text-end" style="width: 85%" id="IP5'.$id1.'"></td>
  <td class="pr-1 pt-0 pb-0 pl-0 m-0 align-middle">$ <input type="number" step="any" class="border-0 p-1 text-end" style="width: 85%" id="IP6'.$id1.'"></td>
  <td class="pr-1 pt-0 pb-0 pl-0 m-0 align-middle">$ <input type="number" step="any" class="border-0 p-1 text-end" style="width: 85%" id="IP7'.$id1.'"></td>
  <td class="pr-1 pt-0 pb-0 pl-0 m-0 align-middle">$ <input type="number" step="any" class="border-0 p-1 text-end" style="width: 85%" id="IP8'.$id1.'"></td>
  <td class="pr-1 pt-0 pb-0 pl-0 m-0 align-middle">$ <input type="number" step="any" class="border-0 p-1 text-end" style="width: 85%" id="IP9'.$id1.'"></td>
  </tr>';
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
