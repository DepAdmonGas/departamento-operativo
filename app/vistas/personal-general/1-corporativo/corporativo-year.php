<?php
require('app/help.php');

if ($Pagina == "corte-diario"){
$ClassHomeCorporativo->ValidaYearReporte($Session_IDEstacion,$fecha_year,$con);
$breadcrumbYear = $ClassHomeCorporativo->tituloMenuCorporativoYear($Pagina,$Session_IDUsuarioBD,$session_idpuesto);
$cardsYear = $ClassHomeCorporativo->cardsCorporativoYear($Pagina,$Session_IDEstacion,$con);

}else if($Pagina == "solicitud-cheque"){
$breadcrumbYear = $ClassHomeCorporativo->tituloMenuCorporativoYear($Pagina,$Session_IDUsuarioBD,$session_idpuesto);
$cardsYear = $ClassHomeCorporativo->cardsCorporativoYear($Pagina,$Session_IDEstacion,$con);

}else if($Pagina == "ingresos-facturacion"){
$ClassHomeCorporativo->ValidaYearReporte($Session_IDEstacion,$fecha_year,$con);
$breadcrumbYear = $ClassHomeCorporativo->tituloMenuCorporativoYear($Pagina,$Session_IDUsuarioBD,$session_idpuesto);
$cardsYear = $ClassHomeCorporativo->cardsCorporativoYear($Pagina,$Session_IDEstacion,$con);

}else if($Pagina == "despacho-factura"){
$breadcrumbYear = $ClassHomeCorporativo->tituloMenuCorporativoYear($Pagina,$Session_IDUsuarioBD,$session_idpuesto);
$cardsYear = $ClassHomeCorporativo->cardsCorporativoYear($Pagina,$Session_IDEstacion,$con);

}else if($Pagina == "solicitud-vales"){
$breadcrumbYear = $ClassHomeCorporativo->tituloMenuCorporativoYear($Pagina,$Session_IDUsuarioBD,$session_idpuesto);
$cardsYear = $ClassHomeCorporativo->cardsCorporativoYear($Pagina,$Session_IDEstacion,$con);

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

  function menuCorporativoYear(referencia){
  window.location.href = referencia;
  }

  function corporativoYear(ruta,year){
  window.location.href = ruta + "/" + year;

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
  <?=$breadcrumbYear?>
  <?=$cardsYear?>
  </div>

  </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>