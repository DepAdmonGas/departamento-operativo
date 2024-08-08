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
  <link href="<?=RUTA_CSS2;?>cards-utilities.min.css" rel="stylesheet" />
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
 
  function Documental(year){
  window.location.href = "../miselanea-30-31/etapa-documental/" + year;
  }

  /*function Sitio(){
  window.location.href = "miselanea-30-31/etapa-sitio";
  }
  */

  function Certificacion(year){
    window.location.href = "../miselanea-30-31/certificacion/" + year;
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
  <li class="breadcrumb-item" onclick="history.go(-2)"><a class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> Portal</a></li>
  <li class="breadcrumb-item" onclick="history.go(-1)"><a class="text-uppercase text-primary pointer">Miselanea 30, 31</a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Periodo <?=$GET_idYear;?></li>
  </ol>
  </div>

  <div class="row">
  <div class="col-12">
  <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Miselanea 30, 31 (Periodo <?=$GET_idYear;?>)</h3>
  </div>

  </div>
  <hr>

  <div class="row">

  <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2" onclick="Documental(<?=$GET_idYear;?>)"> 
  <section class="card3 plan2 shadow-lg">
  <div class="inner2">
    
  <div class="product-image"><img src="<?=RUTA_IMG_ICONOS;?>formatos.png" draggable="false"/></div>

  <div class="product-info">
  <h2>1. Etapa documental </h2>
  <p class="mb-0 pb-0">Es la etapa inicial del proceso de inspección, se realiza previo a la visita en sitio de las instalaciones y se basa en evaluar los requisitos a partir de la revisión de la siguiente documentación.</p>

  </div>

  </div>
  </section>
  </div>
  
  <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2" onclick="Sitio(<?=$GET_idYear;?>)">
  <section class="card3 plan2 shadow-lg">
  <div class="inner2">
    
  <div class="product-image"><img src="<?=RUTA_IMG_ICONOS;?>gasolinera.png" draggable="false"/></div>

  <div class="product-info">
  <h2>2. Etapa en sitio</h2>
  <p class="mb-0 pb-0">Luego de analizar la documentación presentada durante la etapa documental se procede a realizar la visita en sitio con el fin de constatar las instalaciones y realizar algunas pruebas de funcionamiento del sistema de controles volumétricos. Para su desarrollo se requerirá la presencia del personal de la estación de servicio que preste las facilidades para el acceso a las instalaciones, así como el acceso al programa informático con los diferentes perfiles.</p>

  </div>

  </div>
  </section>
  </div>


  <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2" onclick="Certificacion(<?=$GET_idYear;?>)">
  <section class="card3 plan2 shadow-lg">
  <div class="inner2">
    
  <div class="product-image"><img src="<?=RUTA_IMG_ICONOS;?>permisos.png" draggable="false"/></div>

  <div class="product-info">
  <h2>3. Certificación</h2>
  <p class="mb-0 pb-0">Es la etapa final del proceso de inspección, durante esta se analizan los hallazgos de la etapa documental y en sitio, para emitir conclusiones respecto al cumplimiento con el Anexo 30 y 31 de la RMF 2022.</p>

  </div>
 
  </div>
  </section>
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