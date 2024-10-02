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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
 
  <script type="text/javascript">
  
  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");

  localStorage.clear();
  });
 
  function Regresar(){
  window.history.back();
  }

  function Refacciones(){window.location.href = "../administracion/refacciones";}
  function Pinturas(){window.location.href = "../administracion/pinturas";} 
  function Papeleria(){window.location.href = "../administracion/papeleria";}
  function Limpieza(){window.location.href = "../administracion/limpieza";}
  function PedidoMaterial(){window.location.href = "../administracion/pedido-material";} 
  function ModalTelefono(){$('#Modal').modal('show');}
  function OrdenCompra(){window.location.href = "../administracion/orden-compra";}
  function OrdenMantenimiento(){window.location.href = "../administracion/orden-mantenimiento";}
  function TerminalesPV(){window.location.href = "../administracion/terminales-tpv";}
  function CalibracionDispensarios(){window.location.href = "../administracion/calibracion-dispensarios";}
  function ContratosAdmin(){window.location.href = "../contratos";} 
  function Explosividad(){window.location.href = "../administracion/nivel-explosividad";}
  function MantenimientoPreventivo(){window.location.href = "../administracion/mantenimiento-preventivo";}
  function Mantenimiento(){window.location.href = "../administracion/mantenimiento";}

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
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> Almacén</a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Mantenimiento</li>
  </ol>
  </div>

  <div class="row">
  <div class="col-12"><h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Mantenimiento</h3></div>
  </div>
  <hr>
  </div>


  <!-- TPV -->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
  <article class="plan card2 border-0 shadow position-relative" onclick="TerminalesPV()">
          
  <div class="inner">
  <div class="row">
  <div class="col-2"> <span class="pricing"><i class="fa-solid fa-1"></i></span> </div>
  <div class="col-10"><h5 class="text-white text-center">Terminales Punto de Venta </h5></div>
  </div>

  </div>
  </article>
  </div>

  <!-- Calibración de dispensarios -->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
  <article class="plan card2 border-0 shadow position-relative" onclick="CalibracionDispensarios()">
          
  <div class="inner">
  <div class="row">
  <div class="col-2"> <span class="pricing"><i class="fa-solid fa-2"></i></span> </div>
  <div class="col-10"><h5 class="text-white text-center">Calibración de dispensarios</h5></div>
  </div>

  </div>
  </article>
  </div>

  <!-- Medición nivel de explosividad -->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
  <article class="plan card2 border-0 shadow position-relative" onclick="MantenimientoPreventivo()">
          
  <div class="inner">
  <div class="row">
  <div class="col-2"> <span class="pricing"><i class="fa-solid fa-3"></i></span> </div>
  <div class="col-10"><h5 class="text-white text-center">Mantenimiento preventivo</h5></div>
  </div>

  </div>
  </article>
  </div>

  <!-- Medición nivel de explosividad -->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
  <article class="plan card2 border-0 shadow position-relative" onclick="Explosividad()">
          
  <div class="inner">
  <div class="row">
  <div class="col-2"> <span class="pricing"><i class="fa-solid fa-4"></i></span> </div>
  <div class="col-10"><h5 class="text-white text-center">Medición nivel de explosividad</h5></div>
  </div>

  </div>
  </article>
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
