<?php
require('app/help.php');

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
  <link href="<?=RUTA_CSS2?>cards-utilities.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script> 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
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

  function Perfil(){
  window.location.href = "recursos-humanos-configuracion-perfil";  
  }

  function Puesto(){
  window.location.href = "recursos-humanos-configuracion-puesto";  
  }


  function ReHoIn(){
  window.location.href = "recursos-humanos-configuracion-retardo-horarios-incidencias";  
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
      <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i
            class="fa-solid fa-chevron-left"></i> Biometrico</a></li>
      <li aria-current="page" class="breadcrumb-item active text-uppercase">Configuración</li>
    </ol>
  </div>

  <div class="row">
    <div class="col-12">
      <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Configuración</h3>
    </div>

  </div>

  <hr>
</div>


<div class="row justify-content-md-center">

<!----- 1. Perfil aplicación ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2" onclick="Perfil()">  
<section class="card3 plan2 shadow-lg">
<div class="inner2">
  
<div class="product-image"><img src="<?=RUTA_IMG_ICONOS;?>perfil-estacion.png" draggable="false"/></div>
  
<div class="product-info">
<!--<p class="mb-0 pb-0">Perfil aplicación</p> -->
 <h2>Perfil de aplicación</h2>
</div>

</div>
</section>
</div>

<!----- 2. Puestos ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2" onclick="Puesto()"> 
<section class="card3 plan2 shadow-lg">
<div class="inner2">
  
<div class="product-image"><img src="<?=RUTA_IMG_ICONOS;?>area-departamento-puesto.png" draggable="false"/></div>
  
<div class="product-info">
<!--<p class="mb-0 pb-0">Perfil aplicación</p> -->
 <h2>Puestos</h2>
</div>

</div>
</section>
</div>

<!----- 3. Calendario ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2" onclick="ReHoIn()">  
<section class="card3 plan2 shadow-lg">
<div class="inner2">
  
<div class="product-image"><img src="<?=RUTA_IMG_ICONOS;?>calendario.png" draggable="false"/></div>
  
<div class="product-info">
<!--<p class="mb-0 pb-0">Perfil aplicación</p> -->
<h2>Retardos, Horarios e Incidencias</h2>
</div>

</div>
</section>
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