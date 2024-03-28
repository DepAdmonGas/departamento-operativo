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
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>

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
    <div class="col-11">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    
    <div class="row">
    <div class="col-12">

    <h5>Mantenimiento</h5>
    
    </div>
    </div>

    </div>

    </div>

    <hr>


<div class="row">

   <!-- TPV -->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-1 mt-2 ">
  <div class="card card-menuB rounded shadow-sm pointer"  onclick="TerminalesPV()">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-1 color-CB"></i>
  </div>
 
  <div class="m-details ms-2"> 
  <h5>TPV</h5> 
  </div>
  </div>

  </div>
  </div>
  <!-- -->

    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-1 mt-2 ">
  <div class="card card-menuB rounded shadow-sm pointer"  onclick="CalibracionDispensarios()">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-2 color-CB"></i>
  </div>
 
  <div class="m-details ms-2"> 
  <h5>Calibración de dispensarios</h5> 
  </div>
  </div>

  </div>
  </div>
  <!-- -->

    <!-- Medición nivel de explosividad -->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-1 mt-2 ">
  <div class="card card-menuB rounded shadow-sm pointer"  onclick="MantenimientoPreventivo()">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-3 color-CB"></i>
  </div>
 
  <div class="m-details ms-2"> 
  <h5>Mantenimiento preventivo</h5> 
  </div>
  </div>

  </div>
  </div>
  <!-- -->

    <!-- Medición nivel de explosividad -->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-1 mt-2 ">
  <div class="card card-menuB rounded shadow-sm pointer"  onclick="Explosividad()">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-4 color-CB"></i>
  </div>
 
  <div class="m-details ms-2"> 
  <h5>Medición nivel de explosividad</h5> 
  </div>
  </div>

  </div>
  </div>
  <!-- -->

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
