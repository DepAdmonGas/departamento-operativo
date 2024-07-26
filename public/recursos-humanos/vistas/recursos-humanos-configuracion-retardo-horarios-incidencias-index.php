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
  if (sessionStorage.getItem('idestacion') !== undefined && sessionStorage.getItem('idestacion')) {

  idestacion = sessionStorage.getItem('idestacion');
  $('#Contenido').load('public/recursos-humanos/vistas/contenido-recursos-humanos-retardo-horarios-incidencias.php?idEstacion=' + idestacion);
  }    
  } 
  
  });

  function Regresar(){
  window.history.back();
  sessionStorage.removeItem('idestacion');
  }

  function SelEstacion(idEstacion){
  sizeWindow();  
  sessionStorage.setItem('idestacion', idEstacion);
  $('#Contenido').load('public/recursos-humanos/vistas/contenido-recursos-humanos-retardo-horarios-incidencias.php?idEstacion=' + idEstacion);
  }

  function Actualizar(idEstacion){
  var Retardo = $('#Retardo').val();
  var Incidencia  = $('#Incidencia').val();

  if(Retardo != ""){
  $('#Retardo').css('border','');
  alertify.confirm('',
  function(){

  var parametros = {
  "idEstacion" : idEstacion,
  "Retardo" : Retardo,
  "Incidencia" : Incidencia
  };

  $.ajax({
  data:  parametros,
  url:   'public/recursos-humanos/modelo/agregar-retardo-horario.php',
  type:  'POST',
  beforeSend: function() {
  $(".LoaderPage").show();
  },

  complete: function(){

  },

  success:  function (response) {

  if (response == 1) { 
  $(".LoaderPage").hide();
  alertify.success('Se actualizo el correctamente');
  }else if (response == 0){
  $(".LoaderPage").hide();
  alertify.success('Error al actualizar');
  }
  
  }
  });

  },
  function(){
  }).setHeader('Actualizar').set({transition:'zoom',message: '¿Desea actualizar la información?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

  }else{
  $('#Retardo').css('border','2px solid #A52525');  
  }

  }
  function ModalAgregar(idEstacion){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-horarios.php?idEstacion=' + idEstacion + '&Tipo=0&idHorario=0');  
  }


  function Horario(idEstacion,idHorario,Tipo){

    if(Tipo == 0){
    Mensaje = "¿Desea agregar el siguiente horario?";
    Respuesta1 = "Se agrego correctamente";
    Respuesta2 = "Error al agregar";
    }else if(Tipo == 1){
    Mensaje = "¿Desea editar el siguiente horario?";
    Respuesta1 = "Se actualizo el correctamente";
    Respuesta2 = "Error al actualizar";
    }

  var Titulo = $('#Titulo').val();
  var HoraEntrada  = $('#HoraEntrada').val();
  var HoraSalida  = $('#HoraSalida').val();

  if(Titulo != ""){
  $('#Titulo').css('border','');
  if(HoraEntrada != ""){
  $('#HoraEntrada').css('border','');
  if(HoraSalida != ""){
  $('#HoraSalida').css('border','');

  alertify.confirm('',
  function(){

  var parametros = {
  "idEstacion" : idEstacion,
  "idHorario" : idHorario,
  "Tipo" : Tipo,
  "Titulo" : Titulo,
  "HoraEntrada" : HoraEntrada,
  "HoraSalida" : HoraSalida
  };

  $.ajax({
  data:  parametros,
  url:   'public/recursos-humanos/modelo/agregar-editar-horario.php',
  type:  'POST',
  beforeSend: function() {
  $(".LoaderPage").show();
  },

  complete: function(){

  },

  success:  function (response) {

  if (response == 1) { 
  SelEstacion(idEstacion)
  $(".LoaderPage").hide();
  $('#Modal').modal('hide');
  alertify.success(Respuesta1);
  sizeWindow()
  }else if (response == 0){
  $(".LoaderPage").hide();
  alertify.success(Respuesta2);
  }
   
  }
  });

  },
  function(){
  }).setHeader('Mensaje').set({transition:'zoom',message: Mensaje,labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

  }else{
  $('#HoraSalida').css('border','2px solid #A52525');  
  }
  }else{
  $('#HoraEntrada').css('border','2px solid #A52525');  
  }
  }else{
  $('#Titulo').css('border','2px solid #A52525');  
  }

  }

  function editarHorario(idEstacion,idHorario){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-horarios.php?idEstacion=' + idEstacion + '&Tipo=1&idHorario=' + idHorario);  
  }

  function eliminarHorario(idEstacion,idHorario){

    var parametros = {
    "idHorario" : idHorario
    };

alertify.confirm('',
 function(){

    $.ajax({
    data:  parametros,
    url:   'public/recursos-humanos/modelo/eliminar-horario.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    SelEstacion(idEstacion)
    alertify.success('El horario fue eliminado correctamente');
    sizeWindow()
    }else{
     alertify.error('Error al eliminar');  
    }

    }
    });

   },
   function(){

   }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();
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

  $sql_listaestacion = "SELECT id, numlista, localidad FROM op_rh_localidades WHERE numlista <= 8 ORDER BY numlista ASC";
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


  echo '  
  <li>
    <a class="pointer" onclick="SelEstacion('.$id.')">
    <i class="'.$icon.'" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$estacion.'
    </a>
  </li>';
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
  <a class="text-dark" onclick="history.back()">Biometrico</a>
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
  <div class="col-12" id="Contenido"></div> 
  </div>
  </div> 

  </div>

  <!---------- MODAL ----------> 
  <div class="modal fade" id="Modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  <div class="modal-content" id="ContenidoModal">
  </div>
  </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>navbar-functions.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

</body>
</html>