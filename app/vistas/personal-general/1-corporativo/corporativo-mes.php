<?php
require('app/help.php');
 
if ($Pagina == "corte-diario"){
$IdReporte = $ClassHomeCorporativo->IdReporte($Session_IDEstacion,$GET_year); 
$ClassHomeCorporativo->ValidaMesReporte($IdReporte,$fecha_mes);
$breadcrumbMes = $ClassHomeCorporativo->tituloMenuCorporativoMes($Pagina,$Session_IDUsuarioBD,$session_idpuesto,$GET_year);
$cardsMes = $ClassHomeCorporativo->cardsCorporativoMes($Pagina,$IdReporte,$Session_IDEstacion,$Session_IDUsuarioBD,$session_idpuesto,$GET_year);
   
}else if($Pagina == "solicitud-cheque"){
$IdReporte = ""; 
$breadcrumbMes = $ClassHomeCorporativo->tituloMenuCorporativoMes($Pagina,$Session_IDUsuarioBD,$session_idpuesto,$GET_year);
$cardsMes = $ClassHomeCorporativo->cardsCorporativoMes($Pagina,$IdReporte,$Session_IDEstacion,$Session_IDUsuarioBD,$session_idpuesto,$GET_year);

}else if($Pagina == "despacho-factura"){
$IdReporte = ""; 
$breadcrumbMes = $ClassHomeCorporativo->tituloMenuCorporativoMes($Pagina,$Session_IDUsuarioBD,$session_idpuesto,$GET_year);
$cardsMes = $ClassHomeCorporativo->cardsCorporativoMes($Pagina,$IdReporte,$Session_IDEstacion,$Session_IDUsuarioBD,$session_idpuesto,$GET_year);
   
}else if($Pagina == "solicitud-vales"){
$IdReporte = ""; 
$breadcrumbMes = $ClassHomeCorporativo->tituloMenuCorporativoMes($Pagina,$Session_IDUsuarioBD,$session_idpuesto,$GET_year);
$cardsMes = $ClassHomeCorporativo->cardsCorporativoMes($Pagina,$IdReporte,$Session_IDEstacion,$Session_IDUsuarioBD,$session_idpuesto,$GET_year);
   
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

  function menuCorporativoMes(referencia){
  window.location.href = referencia;
  }

  function corporativoMes(year,mes){
  window.location.href = year + "/" + mes;
  }

  function corporativoMesAdmin(year,mes){
  window.location.href = "../admin-solicitud-vales/" + year + "/" + mes;
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
  <?=$breadcrumbMes?>
  <?=$cardsMes?>
  </div>

  </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>
