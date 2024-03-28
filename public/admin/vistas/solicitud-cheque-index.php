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
  </style>
  <script type="text/javascript">
 
  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  });

  function Regresar(){
  window.history.back();
  }

  function SolicitudCheque(year){
  window.location.href = "solicitud-cheque/" + year;
  }

  </script>
  </head>
  <body>
  <div class="LoaderPage"></div>

  <div class="p-4">
  <div class="card">
  <div class="card-body">
 

     <div class="row">
    <div class="col-12">

    <img class="float-left" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    
    <div class="row">
    <div class="col-12">

    <h5>Solicitud de cheques</h5>
    
    </div>
    </div>

    </div>
    </div>

<hr> 
 
  <?php
  $sql_listayear = "SELECT id, year FROM op_corte_year GROUP BY year ORDER BY year desc";
  $result_listayear = mysqli_query($con, $sql_listayear);
  echo '<div class="row">';
  while($row_listayear = mysqli_fetch_array($result_listayear, MYSQLI_ASSOC)){
  $year = $row_listayear['year'];



  echo '<div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 p-2">
  <div class="bg-info text-white shadow-sm p-3 text-center" onclick="SolicitudCheque('.$year.')">'.'<strong>Año '.$year.'</strong></div></div>';
  }
  echo '</div>';
  ?>
  </div>
  </div>
  </div>

  <script src="<?php echo RUTA_JS ?>bootstrap.min.js"></script>
  </body>
  </html>
