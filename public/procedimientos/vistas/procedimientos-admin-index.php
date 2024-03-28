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

  function Modulo(modulo){
  window.location.href = "procedimientos/" + modulo;
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

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    
    <div class="row">
    <div class="col-12">

     <h5>Procedimientos</h5>
    
    </div>
    </div>

    </div>
    </div>

  <hr>


  <div class="row">

  <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 mb-1 mt-2 ">
  <div class="card card-menuB rounded shadow-sm pointer" onclick="Modulo('administrativos')">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon "> 
  <i class="fa-solid fa-users color-CB"></i>
  </div>
 
  <div class="m-details ms-2"> 
  <span>Modulo:</span> 
  <br>
  <h6>Administrativos</h6> 
  </div>
  </div>
 
  </div>
  </div> 

  <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 mb-1 mt-2 ">
  <div class="card card-menuB rounded shadow-sm pointer" onclick="Modulo('importacion')">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon "> 
  <i class="fa-solid fa-cart-flatbed color-CB"></i>
  </div>
 
  <div class="m-details ms-2"> 
  <span>Modulo:</span> 
  <br>
  <h6>Importación</h6> 
  </div>
  </div>

  </div>
  </div>

    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 mb-1 mt-2 ">
  <div class="card card-menuB rounded shadow-sm pointer" onclick="Modulo('mantenimiento')">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon "> 
  <i class="fa-solid fa-screwdriver-wrench color-CB"></i>
  </div>
 
  <div class="m-details ms-2"> 
  <span>Modulo:</span> 
  <br>
  <h6>Mantenimiento</h6> 
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

  </div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>
  
  </body>
  </html>
   