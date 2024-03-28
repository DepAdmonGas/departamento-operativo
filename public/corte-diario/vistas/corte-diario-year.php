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

     <h5>Corte Diario <?=$GET_year;?></h5>
    
    </div>
    </div>

    </div>
    </div>

  <hr>





<?php

function IdReporte($Session_IDEstacion,$GET_year,$con){
   $sql_reporte = "SELECT id, id_estacion, year FROM op_corte_year WHERE id_estacion = '".$Session_IDEstacion."' AND year = '".$GET_year."' ";
   $result_reporte = mysqli_query($con, $sql_reporte);
   while($row_listayear = mysqli_fetch_array($result_reporte, MYSQLI_ASSOC)){
   $id = $row_listayear['id'];
   }

   return $id;
} 

$IdReporte = IdReporte($Session_IDEstacion,$GET_year,$con); 
  
ValidaYearReporte($IdReporte,$fecha_mes,$con);

function ValidaYearReporte($IdReporte,$fecha_mes,$con){

  $sql_reporte = "SELECT id_year, mes FROM op_corte_mes WHERE id_year = '".$IdReporte."' AND mes = '".$fecha_mes."' ";
  $result_reporte = mysqli_query($con, $sql_reporte);
  $numero_reporte = mysqli_num_rows($result_reporte);

   if($numero_reporte == 0){
    $sql_insert = "INSERT INTO op_corte_mes (
    id_year,
    mes
    ) 
    VALUES 
    (
    '".$IdReporte."',
    '".$fecha_mes."'
    )";
    mysqli_query($con, $sql_insert);
  }
  }

   $year_c = date("Y");
   $mes_c = date("m");

   $sql_listayear = "SELECT id, id_year, mes FROM op_corte_mes WHERE id_year = '".$IdReporte."' ORDER BY mes desc";
   $result_listayear = mysqli_query($con, $sql_listayear);

   echo '<div class="row">';
   while($row_listayear = mysqli_fetch_array($result_listayear, MYSQLI_ASSOC)){
   $id = $row_listayear['id'];
   $mes = $row_listayear['mes'];

  if ($GET_year >= $year_c) {
  if ($mes_c >= $i) {
  $color = "card-menuB";
  $icon = "bg-icon";
  }else{
  $color = "card-menuB-disabled";
  $icon = "bg-icon-disabled";
  }
  }else{
  $color = "card-menuB";
  $icon = "bg-icon";
  }


  echo '  <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 mb-1 mt-2 ">
  <div class="card '.$color.' rounded shadow-sm pointer" onclick="CoreteDiarioM('.$GET_year.','.$mes.')">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon '.$icon.'"> 
  <i class="fa-solid fa-calendar-days color-CB"></i>
  </div>
 
  <div class="m-details ms-2"> 
  <span>Mes:</span> 
  <br>
  <h6>'.nombremes($mes).' '.$GET_year.'</h6> 
  </div>
  </div>

  </div>
  </div>';


   }
   echo '</div>';

?> 






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
