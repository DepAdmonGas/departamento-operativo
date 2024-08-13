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
  <link href="<?=RUTA_CSS2;?>navbar-utilities.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

  <script src="<?=RUTA_JS?>size-window.js"></script>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  
  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  sizeWindow();
 
  if(sessionStorage){ 

  if (sessionStorage.getItem('idEstacion') !== undefined && sessionStorage.getItem('idEstacion')) {
    idEstacion = sessionStorage.getItem('idEstacion');
  year = sessionStorage.getItem('year');
  mes = sessionStorage.getItem('mes');

  SelEstacion(idEstacion,year,mes);

  }     
  }   

  });


  function Regresar(){
  sessionStorage.removeItem('idEstacion');
  sessionStorage.removeItem('year');
  sessionStorage.removeItem('mes');
   window.history.back();
  }

  function SelEstacion(idEstacion,year,mes){
  sizeWindow(); 
  sessionStorage.setItem('idEstacion', idEstacion);
  sessionStorage.setItem('year', year);
  sessionStorage.setItem('mes', mes);

  $('#ListaEmbarques').load('../../../app/vistas/personal-general/1-corporativo/despacho-factura/lista-despacho-factura-mes.php?idEstacion=' + idEstacion + '&Year=' + year + '&Mes=' + mes);
  }



  function Editar(e, idDias, Despacho) {
  var input = e.value;
  var Litros = $('#' + idDias + 'L' + Despacho).text();
  LitrosReplace = Litros.replace(/,/g, "");
  var TotalLitros = LitrosReplace - input;


  var parametros = {
  "idDias": idDias,
  "input": input,
  "Despacho": Despacho,
  "accion": "editar-despacho-factura"
  };

  $.ajax({
  data: parametros,
  //url: '../../public/corte-diario/modelo/editar-despacho-factura.php',
  url: '../../../app/controlador/1-corporativo/controladorDespacho.php',
  type: 'post',
  beforeSend: function () {
              
  },
  complete: function () {

  },
  success: function (response) {
  $('#' + idDias + 'LC' + Despacho).text(TotalLitros)

  }
  });
  }

  </script>
  </head>


<body> 
<div class="LoaderPage"></div>


  <!---------- CONTENIDO Y BARRA DE NAVEGACION ---------->
 <div class="wrapper"> 
  <!---------- BARRA DE NAVEGACION ---------->
  <nav id="sidebar">
          
  <div class="sidebar-header text-center">
  <img class="" src="<?=RUTA_IMG_LOGOS."Logo.png";?>" style="width: 100%;">
  </div>

    <ul class="list-unstyled components">
   
    <li>
    <a class="pointer" href="<?=SERVIDOR_ADMIN?>">
    <i class="fa-solid fa-house" aria-hidden="true" style="padding-right: 10px;"></i>Menu
    </a>
    </li>


    <li>
    <a class="pointer" onclick="Regresar()">
    <i class="fas fa-arrow-left" aria-hidden="true" style="padding-right: 10px;"></i>Regresar
    </a>
    </li>


<?php

$sql_listaestacion = "SELECT id, nombre, numlista FROM tb_estaciones WHERE numlista <= 8 ORDER BY numlista ASC";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);

   while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
    $id = $row_listaestacion['id'];
    $estacion = $row_listaestacion['nombre'];

    if ($session_nompuesto == "Contabilidad") {
      
      if ($id == 1 || $id == 2 || $id == 3 || $id == 4 || $id == 5 ) {
       
  echo '  
  <li>
    <a class="pointer"  onclick="SelEstacion('.$id.','.$GET_year.','.$GET_mes.')">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$estacion.'
    </a>
  </li>';
      }

    }else if ($session_nompuesto == "Comercializadora") {
      
      if ($id == 6 || $id == 7 ) {
  echo '  
  <li>
    <a class="pointer"  onclick="SelEstacion('.$id.','.$GET_year.','.$GET_mes.')">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$estacion.'
    </a>
  </li>';
      }

    }else {

      if ($Session_IDUsuarioBD == 293) {
      if ($id == 2) {
  echo '  
  <li>
    <a class="pointer"  onclick="SelEstacion('.$id.','.$GET_year.','.$GET_mes.')">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$estacion.'
    </a>
  </li>';
      }
      }else if ($Session_IDUsuarioBD == 294) {
      if ($id == 1) {
  echo '  
  <li>
    <a class="pointer"  onclick="SelEstacion('.$id.','.$GET_year.','.$GET_mes.')">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$estacion.'
    </a>
  </li>';
      }
      }else if ($Session_IDUsuarioBD == 295) {
      if ($id == 3) {
  echo '  
  <li>
    <a class="pointer"  onclick="SelEstacion('.$id.','.$GET_year.','.$GET_mes.')">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$estacion.'
    </a>
  </li>';
      }
      }else if ($Session_IDUsuarioBD == 296) {
      if ($id == 4) {
  echo '  
  <li>
    <a class="pointer"  onclick="SelEstacion('.$id.','.$GET_year.','.$GET_mes.')">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$estacion.'
    </a>
  </li>';
      }
      }else if ($Session_IDUsuarioBD == 297) {
      if ($id == 5) {
  echo '  
  <li>
    <a class="pointer"  onclick="SelEstacion('.$id.','.$GET_year.','.$GET_mes.')">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$estacion.'
    </a>
  </li>';
      }
      }else{
  echo '  
  <li>
    <a class="pointer"  onclick="SelEstacion('.$id.','.$GET_year.','.$GET_mes.')">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$estacion.'
    </a>
  </li>';
      }
    }
  
   }

?> 

</ul>
</nav>


  <!---------- DIV - CONTENIDO ----------> 
  <div id="content">
  <!---------- NAV BAR - PRINCIPAL (TOP) ---------->  
 <nav class="navbar navbar-expand navbar-light navbar-bg" >
  
  <i class="fa-solid fa-bars menu-btn rounded pointer" 
  id="sidebarCollapse"></i>

  <div class="pointer">
  <a class="text-dark" onclick="history.back()">Despachos VS Ventas, <?=nombremes($GET_mes);?> <?=$GET_year;?></a>
  </div>
 
   
  <div class="navbar-collapse collapse">

  <div class="dropdown-divider"></div>

  <ul class="navbar-nav navbar-align">

  <li class="nav-item dropdown">
  <a class=" dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
  <i class="align-middle" data-feather="settings"></i>
  </a>

 
  <a class="nav-link dropdown-toggle d-none d-sm-inline-block pointer" data-bs-toggle="dropdown">
  
  <img src="<?=RUTA_IMG_ICONOS."usuarioBar.png";?>" class="avatar img-fluid rounded-circle"/>

  <span class="text-dark" style="padding-left: 10px;">
  <?=$session_nompuesto;?>  
  </span>
  </a>
  
  <div class="dropdown-menu dropdown-menu-end">
  
  <div class="user-box">

  <div class="u-text">
  <p class="text-muted">Nombre de usuario:</p>
  <h4><?=$session_nomusuario;?></h4>
  </div>

  </div>

 
  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="<?=PERFIL_ADMIN?>">
  <i class="fa-solid fa-user" style="padding-right: 5px;"></i>Perfil
  </a>
 
  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="<?=RUTA_SALIR2?>salir">
  <i class="fa-solid fa-power-off" style="padding-right: 5px;"></i> Cerrar Sesión
  </a>

  </div>
  </li>
  
  </ul>
  </div>

  </nav>
 
  <!---------- CONTENIDO PAGINA WEB----------> 
  <div class="contendAG">
  <div class="row">  
  
  <div class="col-12" id="ListaEmbarques"></div> 

  </div>
  </div> 

  </div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>navbar-functions.js"></script>
  
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>


  </body>
  </html>

