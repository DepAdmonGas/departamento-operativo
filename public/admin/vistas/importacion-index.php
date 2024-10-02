<?php
require 'app/help.php';

if($Session_IDUsuarioBD == 353){
  $ocultarDivGrnl = "";
  $ocultarDivBitacora = "d-none";

}else if($session_nompuesto == "Comercializadora"){
  $ocultarDivGrnl = "d-none";
  $ocultarDivBitacora = "";

}else{
  $ocultarDivGrnl = "";
  $ocultarDivBitacora= "";
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  
  <script type="text/javascript">
  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  
  localStorage.clear();
  });

  function Embarques(){window.location.href = "embarques";}
  function Mediciones(){window.location.href = "mediciones";}
  function BitacoraAditivo(){window.location.href = "bitacora-aditivo";}
  function DescargaTuxpan(){window.location.href = "descarga-tuxpan";}
  function InventarioD(){window.location.href = "importacion-inventarios-diarios";}  
  function AnalisisCompra(){window.location.href = "importacion-analisis-compra";}
  function Pivoteo(){window.location.href = "pivoteo";}
  function CombustibleD(){window.location.href = "precios-combustible";}
  function CuentaLitros(){  window.location.href = "cuenta-litros"; }

  window.addEventListener('pageshow', function (event) {
  if (event.persisted) {
  // Si la página está en la caché del navegador, recargarla
  window.location.reload();
  }
  });
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
  <li class="breadcrumb-item"><a href="<?=SERVIDOR_ADMIN?>" class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> Inicio</a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Importación</li>
  </ol>
  </div>
 
  <div class="row"> 
  <div class="col-12"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Importación</h3> </div>
  </div>

  <hr>
  </div>

  <!---------- EMBARQUES ---------->
  <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2 <?=$ocultarDivGrnl?>" onclick="Embarques()">      
  <section class="card3 plan2 shadow-lg">
  <div class="inner2">
  <div class="product-image"><img src="<?=RUTA_IMG_ICONOS;?>embarques-tb.png" draggable="false"/></div>
    
  <div class="product-info">
  <h2>Embarques</h2>
  </div>

  </div>
  </section>
  </div>

  <!---------- MEDICIONES ---------->
  <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2 <?=$ocultarDivGrnl?>" onclick="Mediciones()">      
  <section class="card3 plan2 shadow-lg">
  <div class="inner2">
  <div class="product-image"><img src="<?=RUTA_IMG_ICONOS;?>mediciones-tb.png" draggable="false"/></div>
    
  <div class="product-info">
  <h2>Mediciones</h2>
  </div>

  </div>
  </section>
  </div>

  <!---------- BITACORA DE ADITIVO ---------->
  <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2 <?=$ocultarDivBitacora?>" onclick="BitacoraAditivo()">      
  <section class="card3 plan2 shadow-lg">
  <div class="inner2">
  <div class="product-image"><img src="<?=RUTA_IMG_ICONOS;?>aditivo-tb.png" draggable="false"/></div>
    
  <div class="product-info">
  <h2>Bitácora aditivo</h2>
  </div>

  </div>
  </section>
  </div>

  <!---------- DERCARGA DE MERMA ---------->
  <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2 <?=$ocultarDivGrnl?>" onclick="DescargaTuxpan()">      
  <section class="card3 plan2 shadow-lg">
  <div class="inner2">
  <div class="product-image"><img src="<?=RUTA_IMG_ICONOS;?>descarga-merma-tb.png" draggable="false"/></div>
    
  <div class="product-info">
  <h2>Formato de descarga merma</h2>
  </div>

  </div>
  </section>
  </div>

  <!---------- INVENTARIOS DIARIOS ---------->
  <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2 <?=$ocultarDivGrnl?>" onclick="InventarioD()">      
  <section class="card3 plan2 shadow-lg">
  <div class="inner2">
  <div class="product-image"><img src="<?=RUTA_IMG_ICONOS;?>calendario.png" draggable="false"/></div>
    
  <div class="product-info">
  <h2>Inventarios diarios</h2>
  </div>

  </div>
  </section>
  </div>

  <!----------  ANALISIS DE COMPRA ---------->
  <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2 <?=$ocultarDivGrnl?>" onclick="AnalisisCompra()">      
  <section class="card3 plan2 shadow-lg">
  <div class="inner2">
  <div class="product-image"><img src="<?=RUTA_IMG_ICONOS;?>area-departamento-puesto.png" draggable="false"/></div>
    
  <div class="product-info">
  <h2>Análisis de compra</h2>
  </div>

  </div>
  </section>
  </div>

  <!---------- PIVOTEO ---------->
  <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2 <?=$ocultarDivGrnl?>" onclick="Pivoteo()">      
  <section class="card3 plan2 shadow-lg">
  <div class="inner2">
  <div class="product-image"><img src="<?=RUTA_IMG_ICONOS;?>icon-pivoteo.png" draggable="false"/></div>
    
  <div class="product-info">
  <h2>Pivoteo</h2>
  </div>

  </div>
  </section>
  </div>

  <!---------- PRECIOS DIARIOS DE COMBUSTIBLE ---------->
  <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2 <?=$ocultarDivGrnl?>" onclick="CombustibleD()">      
  <section class="card3 plan2 shadow-lg">
  <div class="inner2">
  <div class="product-image"><img src="<?=RUTA_IMG_ICONOS;?>icon-combustible.png" draggable="false"/></div>
    
  <div class="product-info">
  <h2>Precios diarios de combustible</h2>
  </div>

  </div>
  </section>
  </div>


  <!---------- CUENTA LITROS ---------->
  <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2 <?=$ocultarDivGrnl?>" onclick="CuentaLitros()">      
  <section class="card3 plan2 shadow-lg">
  <div class="inner2">
  <div class="product-image"><img src="<?=RUTA_IMG_ICONOS;?>cuenta-litros.png" draggable="false"/></div>
    
  <div class="product-info">
  <h2>Tabla de Descarga (Cuenta Litros)</h2>
  </div>

  </div>
  </section>
  </div>

  </div>
  </div>

  </div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>
  

  </body>
  </html>
