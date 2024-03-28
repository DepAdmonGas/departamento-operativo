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
  <link href="<?=RUTA_CSS2;?>navbar-utilities.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

  <script src="<?=RUTA_JS?>size-window.js"></script>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
 
  <style media="screen">
  .decorado:hover {
  text-decoration: none;
  }
  </style>

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  sizeWindow();

if(sessionStorage){
if (sessionStorage.getItem('idestacion') !== undefined && sessionStorage.getItem('idestacion')) {

idestacion = sessionStorage.getItem('idestacion');
Mes = sessionStorage.getItem('mes');
Year = sessionStorage.getItem('year');

$('#ListaAsistencia').load('public/recursos-humanos/vistas/contenido-recursos-humanos-reporte-asistencia-v2.php?idEstacion=' + idestacion + '&Year=' + Year + '&Mes=' + Mes + '&Val=0');        
}  
      
}
 
});  

function Regresar(){
sessionStorage.removeItem('idestacion');
sessionStorage.removeItem('mes');
sessionStorage.removeItem('year');

window.history.back();
}

function SelEstacion(idEstacion,Mes,Year){
sizeWindow();  
sessionStorage.setItem('idestacion', idEstacion);
sessionStorage.setItem('mes', Mes);
sessionStorage.setItem('year', Year);

$('#ListaAsistencia').load('public/recursos-humanos/vistas/contenido-recursos-humanos-reporte-asistencia-v2.php?idEstacion=' + idEstacion + '&Year=' + Year + '&Mes=' + Mes + '&Val=0');
}

function ModalReporte(idEstacion){
$('#ModalIncidencias').modal('show');
$('#ContenidoModal').load('public/recursos-humanos/vistas/modal-reporte-asistencia.php?idEstacion=' + idEstacion); 
} 

function btnBuscar(idEstacion){ 
 
var Year = $('#Year').val();
var Mes = $('#Mes').val();

if(Year != ""){ 
$('#Year').css('border','');
if(Mes != ""){
$('#Mes').css('border',''); 

sessionStorage.setItem('mes', Mes);
sessionStorage.setItem('year', Year);

$('#ModalIncidencias').modal('hide');
$('#ListaAsistencia').load('public/recursos-humanos/vistas/contenido-recursos-humanos-reporte-asistencia-v2.php?idEstacion=' + idEstacion + '&Year=' + Year + '&Mes=' + Mes + '&Val=0');
    
}else{
$('#Mes').css('border','2px solid #A52525'); 
}
}else{
$('#Year').css('border','2px solid #A52525'); 
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
 sessionStorage.removeItem('mes');
 sessionStorage.removeItem('year');
    });
  });
  </script>


    <li>
    <a class="pointer" onclick="Regresar()">
    <i class="fas fa-arrow-left" aria-hidden="true" style="padding-right: 10px;"></i>Regresar
    </a>
    </li>

  <?php

  $FInicio = date("Y").'-'.date("m").'-01';
  $FTermino = date("Y-m-t", strtotime($FInicio));
  $mesActual = date("m");
  $yearActual = date("Y");


  $sql_listaestacion = "SELECT id, numlista, localidad FROM op_rh_localidades WHERE numlista <= 10 ORDER BY numlista ASC";
  $result_listaestacion = mysqli_query($con, $sql_listaestacion);
  while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
  $id = $row_listaestacion['id'];
  $estacion = $row_listaestacion['localidad'];




if($estacion == "Comodines"){
 $icon = "fa-solid fa-users";

}else if($estacion == "Autolavado"){
 $icon = "fa-solid fa-car";

}else if($estacion == "Almacen"){
$icon = "fa-sharp fa-solid fa-shop";

}else if($estacion == "Directivos"){
$icon = " fa-solid fa-user-tie"; 

}else if($estacion == "Servicio Profesionales Operación Servicio y Mantenimiento de Personal"){
$icon = "fa-solid fa-screwdriver-wrench";

}else if($estacion == "Dirección de operaciones" ||
 $estacion == "Departamento Gestión" ||
 $estacion == "Departamento Jurídico" ||
 $estacion == "Departamento Mantenimiento" ||
 $estacion == "Departamento Sistemas"){
   $icon = "fa-solid fa-briefcase"; 


}else{
 $icon = "fa-solid fa-gas-pump";    
}

  if($id <> 8){
  echo '  
  <li>
    <a class="pointer" onclick="SelEstacion('.$id.','.$mesActual.','.$yearActual.')">
    <i class="'.$icon.'" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$estacion.'
    </a>
  </li>';
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
  <a class="text-dark" onclick="history.back()">Recursos humanos incidencia de nomina</a>
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
  <div id="ListaAsistencia" class="cardAG"></div>
  </div> 

  </div>
  </div> 

  </div>

</div>



<div class="modal" id="ModalIncidencias" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog" style="margin-top: 83px;">
<div class="modal-content border-0 rounded-0" >
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