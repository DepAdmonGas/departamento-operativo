<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}


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

  function Embarques(){window.location.href = "embarques";}
  function Mediciones(){window.location.href = "mediciones";}
  function BitacoraAditivo(){window.location.href = "bitacora-aditivo";}
  function DescargaTuxpan(){window.location.href = "descarga-tuxpan";}
  function InventarioD(){window.location.href = "importacion-inventarios-diarios";}  
  function AnalisisCompra(){window.location.href = "importacion-analisis-compra";}
  function Pivoteo(){window.location.href = "pivoteo";}
  function CombustibleD(){window.location.href = "precios-combustible";}

  function CuentaLitros(){  
    window.location.href = "cuenta-litros";
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

    <?php if($Session_IDUsuarioBD != 509){ ?>
    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    <?php } ?>
    

    <div class="row">
    <div class="col-12">

     <h5>Importación</h5>
     
    </div>
    </div>

    </div>
    </div>

  <hr>  

   <div class="row">

  <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-1 mt-2 <?=$ocultarDivGrnl?>">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer" onclick="Embarques()">          
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5 class="text-secondary">Embarques</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>embarques-tb.png">
  </div>
  </div>
  </div>

  <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-1 mt-2 <?=$ocultarDivGrnl?>">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer" onclick="Mediciones()">          
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5 class="text-secondary">Mediciones</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>mediciones-tb.png">
  </div>
  </div>
  </div>

  <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-1 mt-2 <?=$ocultarDivBitacora?>">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer" onclick="BitacoraAditivo()">          
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5 class="text-secondary">Bitácora aditivo</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>aditivo-tb.png">
  
  </div>
  </div>
  </div>

  <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-1 mt-2 <?=$ocultarDivGrnl?>">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer" onclick="DescargaTuxpan()">          
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5 class="text-secondary">Formato de descarga merma</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>descarga-merma-tb.png">
  </div>
  </div>
  </div>

  <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-1 mt-2 <?=$ocultarDivGrnl?>">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer" onclick="InventarioD()">          
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5 class="text-secondary">Inventarios diarios</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>calendario.png">
  </div>
  </div>
  </div>

  <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-1 mt-2 <?=$ocultarDivGrnl?>">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer" onclick="AnalisisCompra()">          
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5 class="text-secondary">Análisis de compra</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>area-departamento-puesto.png">
  </div>
  </div>
  </div>

  <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-1 mt-2 <?=$ocultarDivGrnl?>">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer" onclick="Pivoteo()">          
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5 class="text-secondary">Pivoteo</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>icon-pivoteo.png">
  </div>
  </div>
  </div>


  <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-1 mt-2 <?=$ocultarDivGrnl?>">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer" onclick="CombustibleD()">          
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5 class="text-secondary">Precios diarios de combustible</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>icon-combustible.png">   
  </div>
  </div>
  </div>


    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-1 mt-2 <?=$ocultarDivGrnl?>">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer" onclick="CuentaLitros()">          
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5 class="text-secondary">Tabla de Descarga (Cuenta Litros)</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>cuenta-litros.png">   
  </div>
  </div>
  </div>


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
