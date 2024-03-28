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
  <link rel="stylesheet" href="<?php echo RUTA_CSS ?>bootstrap-select.css">
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
  background: url('../../imgs/iconos/load-img.gif') 50% 50% no-repeat rgb(249,249,249);
  }
  </style>
  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  
  });

  function Regresar(){
   window.history.back();
  }

  function EmbarquesM(year,mes){
  window.location.href = year + "/" + mes;
  }

  </script>
  </head>
  <body>

<div class="LoaderPage"></div>
<div class="p-4">
   <div class="card">
  <div class="card-body">
    <div class="border-bottom">
    <h5 class="card-title"><img class="pr-2" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()"> Embarques <?=$GET_year;?></h5>
    </div>

<?php
 $year_c = date("Y");
  $mes_c = date("m");
   echo '<div class="row">';
   
   for ($i=1; $i <= 12; $i++) { 

            if ($GET_year >= $year_c) {
  if ($mes_c >= $i) {
  $color = "bg-info";
  }else{
  $color = "bg-secondary";
  }
  }else{
  $color = "bg-info";
  }

   echo '<div class="col-12 col-sm-3 p-2"><div class="'.$color.' text-white shadow-sm p-3 text-center" onclick="EmbarquesM('.$GET_year.','.$i.')">'.'<strong>'.nombremes($i).' '.$GET_year.'</strong></div></div>';

   }
   echo '</div>';


?>
  
</div>
</div>
</div>

  <script src="<?php echo RUTA_JS ?>bootstrap.min.js"></script>
  </body>
  </html>
