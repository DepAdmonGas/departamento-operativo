<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

$year = date("Y");
$mes = date("m");

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
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  $('[data-toggle="tooltip"]').tooltip();
  sizeWindow();

    if(sessionStorage){
    if (sessionStorage.getItem('year') !== undefined && sessionStorage.getItem('year')) {

      idEstacion = sessionStorage.getItem('idestacion');
      year = sessionStorage.getItem('year');
      tipo = sessionStorage.getItem('tipo')
      
      $('#ContenidoOrganigrama').load('../public/recursos-humanos/vistas/lista-kpi-personal.php?idEstacion=' + idEstacion + '&year=' + year + '&tipo=' + tipo);

    }    
    }  
    }); 
 
    function Regresar(){
    sessionStorage.removeItem('year');
    sessionStorage.removeItem('tipo');
    window.history.back();
    }


    function EvaluacionPersonal(tipo,idEstacion,year,mes){
    sizeWindow();
    sessionStorage.setItem('idestacion', idEstacion);
    sessionStorage.setItem('year', year);
    sessionStorage.setItem('tipo', tipo);
    
    $('#ContenidoOrganigrama').load('../public/recursos-humanos/vistas/lista-kpi-personal.php?idEstacion=' + idEstacion + '&year=' + year + '&tipo=' + tipo);
    }
 

    function BuscarYear(idEstacion,tipo){
    $('#Modal').modal('show');  
    $('#ContenidoModal').load('../public/recursos-humanos/vistas/modal-buscar-kpi-personal.php?idEstacion=' + idEstacion + '&tipo=' + tipo);
 
    } 



  function btnBuscar(idEstacion,tipo){ 
  
  var year = $('#years').val();
  
  if(year != ""){ 
  $('#years').css('border','');

  sessionStorage.setItem('year', year);
  $('#Modal').modal('hide');
  $('#ContenidoOrganigrama').load('../public/recursos-humanos/vistas/lista-kpi-personal.php?idEstacion=' + idEstacion + '&year=' + year + '&tipo=' + tipo);
      
  }else{
  $('#years').css('border','2px solid #A52525'); 
  }
  
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
     
  <li id="menu-item">
   <a class="pointer" href="<?=SERVIDOR_ADMIN?>">
    <i class="fa-solid fa-house" aria-hidden="true" style="padding-right: 10px;"></i>Menu
    </a>
  </li>


  <!---------- SESIONES CLEAN ---------->
  <script>
  document.addEventListener('DOMContentLoaded', function () {
  var menuItem = document.getElementById('menu-item');
    
  menuItem.addEventListener('click', function () {
  sessionStorage.removeItem('idestacion');
  sessionStorage.removeItem('year');
  sessionStorage.removeItem('tipo');
    });
  });
  </script>
  
  <li>
    <a class="pointer" onclick="Regresar()">
    <i class="fas fa-arrow-left" aria-hidden="true" style="padding-right: 10px;"></i>Regresar
    </a>
  </li>


  <li>
    <a class="pointer" onclick="EvaluacionPersonal(1,<?=$GET_idEstacion?>,<?=$year?>,<?=$mes?>)">
    <i class="fa-solid fa-user-plus" aria-hidden="true" style="padding-right: 10px;"></i>Altas del personal
    </a>
  </li>

  <li>
    <a class="pointer" onclick="EvaluacionPersonal(2,<?=$GET_idEstacion?>,<?=$year?>,<?=$mes?>)">
    <i class="fa-solid fa-user-xmark" aria-hidden="true" style="padding-right: 10px;"></i>Bajas del personal
    </a>
  </li>



</ul>
</nav>

  <!---------- DIV - CONTENIDO ----------> 
  <div id="content">
  <!---------- NAV BAR - PRINCIPAL (TOP) ---------->  
 <nav class="navbar navbar-expand navbar-light navbar-bg" >
  
  <i class="fa-solid fa-bars menu-btn rounded pointer" 
  id="sidebarCollapse"></i>

  <div class="pointer">
  <a class="text-dark" onclick="history.back()">Recursos humanos - Evaluacion Personal (KPI'S)</a>
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
  
  <div class="col-12 mb-3">
  <div id="ContenidoOrganigrama" class="cardAG"></div>
  </div> 

  </div>
  </div> 
  </div>



</div>





  <div class="modal" id="Modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" style="margin-top: 83px;">
      <div id="ContenidoModal"></div>
      </div>
    </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>navbar-functions.js"></script>
  
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>


</body>
</html>