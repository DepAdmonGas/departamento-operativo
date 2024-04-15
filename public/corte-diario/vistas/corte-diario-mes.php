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
 
  <style media="screen">
  .tooltip1 {
    display:inline-block;
    position:relative;
    text-align:left;
  }

  .tooltip1 {
      display:inline-block;
      position:relative;
      text-align:left;
  }

  .tooltip1 .bottom {
      top:35px;
      left:35%;
      transform:translate(-50%, 0);
      padding:5px;
      color:white;
      background-color:black;
      font-weight:normal;
      font-size:13px;
      border-radius:8px;
      position:absolute;
      z-index:999999999;
      box-shadow:0 1px 8px rgba(0,0,0,0.5);
      display:none;
      text-align: center;
  }

  .tooltip1:hover .bottom {
      display:block;
  }

  .grayscale {
      filter: grayscale(100%);
  }
  </style>

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  
  });

  function Regresar(){
   window.history.back();
  }

  function CoreteDiarioM(year,mes){
  window.location.href = year + "/" + mes;
  }

  function ventas(year,mes,idDias){
  console.log(window.location.href = "../../corte-ventas/" + year + "/" + mes + "/" + idDias);
  }

    function cierrelote(year,mes,idDias){
  window.location.href = "../../cierre-lote/" + year + "/" + mes + "/" + idDias;
  }

    function monedero(year,mes,idDias){
  window.location.href = "../../monedero/" + year + "/" + mes + "/" + idDias;
  }

  function Aceites(year,mes){
  window.location.href =  "../../aceites-mes/" + year + "/" + mes;
  }

  function impuestos(year,mes,idDias){
    window.location.href =  "../../impuestos-mes/" + year + "/" + mes + "/" + idDias;
  }

  function clientes(year,mes,idDias){

     window.location.href = "../../clientes/" + year + "/" + mes + "/" + idDias;

  }

    function ResumenImpuestos(year,mes){

  window.location.href =  "../../resumen-impuestos/" + year + "/" + mes;
  }

  function ResumenMonedero(year,mes){
 window.location.href =  "../../resumen-monedero/" + year + "/" + mes;
  }

    function Clientes(year,mes){
  window.location.href =  "../../clientes-mes/" + year + "/" + mes;
  }

      function Embarques(year,mes){
  window.location.href =  "../../embarques-mes/" + year + "/" + mes;
  }

    function ControlVolumetrico(estacion,year,mes){

  
    window.location.href =  "../../administracion/control-volumetrico/" + estacion + "/" + year + "/" + mes;

  }

  function ConcentradoVentas(estacion,year,mes){
  var scrollTop = window.scrollY;
  sessionStorage.setItem('scrollTop', 0);
  window.location.href =  "../../administracion/concentrado-ventas/" + estacion + "/" + year + "/" + mes;

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

  <div class="float-left col-xl-6 col-lg-6 col-md-6 col-12 mb-2">
    <h5 class="card-title">
    <img class="pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()"> Corte Diario, <?=nombremes($GET_mes);?> <?=$GET_year;?>
    </h5>
  </div>


<div class="text-end col-xl-6 col-lg-6 col-md-6 col-12 mb-2">

  <div class="tooltip1">
<img class="ms-1 pointer" onclick="ControlVolumetrico(<?=$Session_IDEstacion;?>,<?=$GET_year;?>,<?=$GET_mes;?>)" src="<?=RUTA_IMG_ICONOS;?>control-volumetrico.png">
  <div class="bottom">Control volumétrico</div>
</div>


<div class="tooltip1">
<img class="ms-1 pointer" onclick="ConcentradoVentas(<?=$Session_IDEstacion;?>,<?=$GET_year;?>,<?=$GET_mes;?>)" src="<?=RUTA_IMG_ICONOS;?>concentrado-ventas.png">
  <div class="bottom">Concentrado de Ventas</div>
</div>


    <div class="tooltip1">
     <img class="ms-1 pointer" onclick="ResumenImpuestos(<?=$GET_year;?>,<?=$GET_mes;?>)" src="<?=RUTA_IMG_ICONOS;?>impuestos.png">
       <div class="bottom">Resumen Impuestos</div>
    </div>

      <div class="tooltip1">
      <img class="ms-1 pointer" onclick="ResumenMonedero(<?=$GET_year;?>,<?=$GET_mes;?>)" src="<?=RUTA_IMG_ICONOS;?>monedero.png">
        <div class="bottom">Resumen Monedero</div>
      </div>

      <div class="tooltip1">
      <img class="ms-1 pointer" onclick="Aceites(<?=$GET_year;?>,<?=$GET_mes;?>)" src="<?=RUTA_IMG_ICONOS;?>aceite.png">
        <div class="bottom">Resumen Aceites</div>
      </div>

      <div class="tooltip1">
      <img class="ms-1 pointer" onclick="Clientes(<?=$GET_year;?>,<?=$GET_mes;?>)" src="<?=RUTA_IMG_ICONOS;?>clientes.png">
        <div class="bottom">Resumen Clientes</div>
      </div>

      <div class="tooltip1">
      <img class="ms-1 pointer" onclick="Embarques(<?=$GET_year;?>,<?=$GET_mes;?>)" src="<?=RUTA_IMG_ICONOS;?>embarque.png">
        <div class="bottom">Resumen Embarques</div>
      </div>

    </div>

  </div>

  <hr>
 

    <?php

  function IdReporte($Session_IDEstacion,$GET_year,$GET_mes,$con){
    $sql_year = "SELECT id, id_estacion, year FROM op_corte_year WHERE id_estacion = '".$Session_IDEstacion."' AND year = '".$GET_year."' ";
    $result_year = mysqli_query($con, $sql_year);
    while($row_year = mysqli_fetch_array($result_year, MYSQLI_ASSOC)){
      $idyear = $row_year['id'];
    }

  $sql_mes = "SELECT id, id_year, mes FROM op_corte_mes WHERE id_year = '".$idyear."' AND mes = '".$GET_mes."' ";
  $result_mes = mysqli_query($con, $sql_mes);
  while($row_mes = mysqli_fetch_array($result_mes, MYSQLI_ASSOC)){
  $idmes = $row_mes['id'];
  }

  return $idmes;
}

$IdReporte = IdReporte($Session_IDEstacion,$GET_year,$GET_mes,$con); 

    function ultimodia($GET_year,$GET_mes) { 
      $month = $GET_mes;
      $year = $GET_year;
      $day = date("d", mktime(0,0,0, $month+1, 0, $year)); 
      return date('d', mktime(0,0,0, $month, $day, $year));
  };
 
  
  function primerdia($GET_year,$GET_mes) {
      $month = $GET_mes;
      $year = $GET_year;
      return date('d', mktime(0,0,0, $month, 1, $year));
  }

  $Pdia = primerdia($GET_year,$GET_mes);
  $Udia = ultimodia($GET_year,$GET_mes);

for ($Pdia = 1; $Pdia <= $Udia; $Pdia++) {
    

ValidaFechaReporte($IdReporte,$GET_year,$GET_mes,$Pdia,$con);


}


function ValidaFechaReporte($IdReporte,$GET_year,$GET_mes,$Pdia,$con){

  $fecha = $GET_year."-".$GET_mes."-".$Pdia;

   $sql_reporte = "SELECT id, id_mes, fecha FROM op_corte_dia WHERE id_mes = '".$IdReporte."' AND fecha = '".$fecha."' ";
   $result_reporte = mysqli_query($con, $sql_reporte);
   $numero_reporte = mysqli_num_rows($result_reporte);

      if($numero_reporte == 0){
    $sql_insert = "INSERT INTO op_corte_dia (
    id_mes,
    fecha,
    ventas,
    tpv,
    monedero
    )
    VALUES 
    (
    '".$IdReporte."',
    '".$fecha."',
    0,
    0,
    0
    )";
    mysqli_query($con, $sql_insert);
  }
  }

    ?>

      <div class="table-responsive"> 
        <table class="table table-bordered table-striped table-hover mb-0" >
          <thead class="tables-bg">
          <tr>
            <th class="text-center">FECHA</th>
            <th class="text-center" width="60px">VENTAS</th>
            <th class="text-center" width="60px">TPV</th>
            <th class="text-center" width="60px">IMPUESTOS</th>
            <th class="text-center" width="60px">MONEDERO</th>
            <th class="text-center" width="50px">CLIENTES</th>
          </tr>
        </thead>
           
          <?php
          $sql_listadia = "
          SELECT 
          op_corte_year.id_estacion,
          op_corte_year.year,
          op_corte_mes.mes,
          op_corte_dia.id AS idDia,
          op_corte_dia.fecha
          FROM op_corte_year
          INNER JOIN op_corte_mes ON op_corte_year.id = op_corte_mes.id_year
          INNER JOIN op_corte_dia ON op_corte_mes.id = op_corte_dia.id_mes 
          WHERE op_corte_year.id_estacion = '".$Session_IDEstacion."' AND 
          op_corte_year.year = '".$GET_year."' AND 
          op_corte_mes.mes = '".$GET_mes."' ORDER BY op_corte_dia.fecha ASC";
          $result_listadia = mysqli_query($con, $sql_listadia);
          $numero_listadia = mysqli_num_rows($result_listadia);

          while($row_listadia = mysqli_fetch_array($result_listadia, MYSQLI_ASSOC)){
          $idDias = $row_listadia['idDia'];
          $fecha = $row_listadia['fecha'];

          if (strtotime($fecha_del_dia) >= strtotime($fecha)) {
          $text = "text-black font-weight-bold";
          $img = "";
          }else{
          $text = "text-secondary";
          $img = "grayscale";
          }

          echo "<tr>";
          echo "<td class='align-middle ".$text."'>".FormatoFecha($fecha)."</td>";

          echo "<td class='align-middle text-center' onclick='ventas(".$GET_year.",".$GET_mes.",".$idDias.")'><img class='".$img." pointer' src='".RUTA_IMG_ICONOS."ventas.png' ></td>";
          echo "<td class='align-middle text-center' onclick='cierrelote(".$GET_year.",".$GET_mes.",".$idDias.")'><img class='".$img." pointer' src='".RUTA_IMG_ICONOS."tpv.png' ></td>";

          echo "<td class='align-middle text-center' onclick='impuestos(".$GET_year.",".$GET_mes.",".$idDias.")'><img class='".$img." pointer' src='".RUTA_IMG_ICONOS."impuestos.png' ></td>";

          echo "<td class='align-middle text-center' onclick='monedero(".$GET_year.",".$GET_mes.",".$idDias.")'><img class='".$img." pointer' src='".RUTA_IMG_ICONOS."monedero.png' ></td>";

          echo "<td class='align-middle text-center' onclick='clientes(".$GET_year.",".$GET_mes.",".$idDias.")'><img class='".$img." pointer' src='".RUTA_IMG_ICONOS."clientes.png' ></td>";
          echo "</tr>";
          }

          ?>
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

