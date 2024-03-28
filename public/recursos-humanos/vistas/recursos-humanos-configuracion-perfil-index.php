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

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  sizeWindow();

  });

  function Regresar(){
  window.history.back();
  }

  function SelEstacion(idEstacion){
   sizeWindow(); 
  $('#ContenidoPerfil').load('public/recursos-humanos/vistas/contenido-recursos-humanos-perfil.php?idEstacion=' + idEstacion);
  }   

  function ModalPerfil(idEstacion){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-sensorhuella.php?idEstacion=' + idEstacion);
  }

function validatePassword(password) {

var validar = "";

var matchedCase = new Array();
  matchedCase.push("[A-Z]");
  matchedCase.push("[0-9]");
  matchedCase.push("[a-z]");
  matchedCase.push("[a-zA-Z]");
 
if (password.length < 8) {
$('#txtPassword').css('border','2px solid #A52525');
 validar = 0;


}else{

var ctr = 0;
  for (var i = 0; i < matchedCase.length; i++) {
    if (new RegExp(matchedCase[i]).test(password)) {
    ctr++;
    }
  }

  var borde = "";

  switch (ctr) {
    
     case 0:
     borde = "2px solid #A52525";
     validar = 0;
      break;

    case 1:
       borde = "2px solid #A52525";
         validar = 0;
      break;

    case 2:
      borde = "2px solid #A52525";
        validar = 0;
      break;

    case 3:
      borde = "2px solid orange";
        validar = 0;
      break;

    case 4:
      borde = "2px solid green";
       validar = 1;
      break;

  }

  document.getElementById("txtPassword").style.border = borde;

  }

  return validar;
  
}

function btnAgregarHuella(idEstacion){

var txtUsuario = $('#txtUsuario').val();
var txtPassword = $('#txtPassword').val();
var txtValidaPassword = $('#txtValidaPassword').val();

if (txtUsuario != "") {
$('#txtUsuario').css('border','');

if (txtPassword != "") {
$('#txtPassword').css('border','');

if (validatePassword(txtPassword) != 0) {
$('#txtPassword').css('border','');


if (txtValidaPassword != "") {
$('#txtValidaPassword').css('border','');

if(txtPassword == txtValidaPassword){

alertify.confirm('',
function(){

var parametros = {

"idEstacion" : idEstacion,
"txtUsuario" : txtUsuario,
"txtPassword" : txtPassword,
"txtValidaPassword" : txtValidaPassword

};
 
$.ajax({
data:  parametros,
url:   'public/recursos-humanos/modelo/agregar-huella.php',
type:  'POST',
        
beforeSend: function() {
$(".LoaderPage").show();
},

complete: function(){
},

success:  function (response) {

if (response == 1) {

$(".LoaderPage").hide();
$('#Modal').modal('hide');
SelEstacion(idEstacion)
alertify.success('El usuario fue agregado exitosamente');
sizeWindow();

}else if(response == 0){
$(".LoaderPage").hide();
alertify.error('El usuario no fue agregado');
}else if(response == 2){
alertify.error('El usuario no fue agregado');
$(".LoaderPage").hide();
$('#resultadoModal').html('<div class="text-center text-danger"><small>Intente con otro usuario o contraseña</small></div>');
}

}
});

},
function(){
}).setHeader('Agregar Usuario y Contraseña').set({transition:'zoom',message: '¿Desea agregar el siguiente usuario?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

}else{  
$('#txtValidaPassword').css('border','2px solid #A52525');
$('#txtPassword').css('border','2px solid #A52525');
$('#resultadoModal').html('<div class="text-center text-danger"><small>Las contraseñas no coinciden</small></div>');
}

}else{
$('#txtValidaPassword').css('border','2px solid #A52525');
}

}else{
$('#txtPassword').css('border','2px solid #A52525');
}

}else{
$('#txtPassword').css('border','2px solid #A52525');
}

}else{
$('#txtUsuario').css('border','2px solid #A52525');
}

}

function eliminarPerfil(id, idEstacion){

alertify.confirm('',
function(){

var parametros = {
"id" : id
};
 
$.ajax({
data:  parametros,
url:   'public/recursos-humanos/modelo/eliminar-perfil.php',
type:  'POST',
        
beforeSend: function() {
$(".LoaderPage").show();
},

complete: function(){
},

success:  function (response) {

if (response == 1) {

$(".LoaderPage").hide();
SelEstacion(idEstacion) 
alertify.success('El usuario fue eliminado exitosamente');
sizeWindow()

}else if(response == 0){
$(".LoaderPage").hide();
alertify.error('El usuario no fue eliminado');
}else if(response == 2){
alertify.error('El usuario no fue eliminado');
$(".LoaderPage").hide();
}
 
}
});

},
function(){
}).setHeader('Eliminar Usuario (Panel de Control)').set({transition:'zoom',message: '¿Desea eliminar el siguiente usuario?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

}

function editar(id, idEstacion){
$('#Modal').modal('show');
$('#ContenidoModal').load('public/recursos-humanos/vistas/modal-editarhuella.php?id=' + id + '&idEstacion=' + idEstacion);
}

function btnEditarPerfil(id, idEstacion){

var txtUsuario = $('#txtUsuario').val();
var txtPassword = $('#txtPassword').val();
var txtValidaPassword = $('#txtValidaPassword').val();

if (txtUsuario != "") {
$('#txtUsuario').css('border','');
if (txtPassword != "") {
$('#txtPassword').css('border','');
if (validatePassword(txtPassword) != 0) {
$('#txtPassword').css('border','');
if (txtValidaPassword != "") {
$('#txtValidaPassword').css('border','');

if(txtPassword == txtValidaPassword){

alertify.confirm('',
function(){

var parametros = {

"id" : id,
"txtUsuario" : txtUsuario,
"txtPassword" : txtPassword,
"txtValidaPassword" : txtValidaPassword

};
 
$.ajax({
data:  parametros,
url:   'public/recursos-humanos/modelo/editar-perfil.php',
type:  'POST',
        
beforeSend: function() {
$(".LoaderPage").show();
},

complete: function(){
},

success:  function (response) {

if (response == 1) {

$(".LoaderPage").hide();
$('#Modal').modal('hide');
SelEstacion(idEstacion) 
alertify.success('El usuario fue editado exitosamente');
sizeWindow()

}else if(response == 0){
$(".LoaderPage").hide();
alertify.error('El usuario no fue editado');
}else if(response == 2){
alertify.error('El usuario no fue editado');
$(".LoaderPage").hide();
$('#resultadoModal').html('<div class="text-center text-danger"><small>Intente con otro usuario o contraseña</small></div>');
}
 
}
});

},
function(){
}).setHeader('Editar Usuario (Panel de Control)').set({transition:'zoom',message: '¿Desea editar el siguiente usuario?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

}else{  
$('#txtValidaPassword').css('border','2px solid #A52525');
$('#txtPassword').css('border','2px solid #A52525');
$('#resultadoModal').html('<div class="text-center text-danger"><small>Las contraseñas no coinciden</small></div>');
}

}else{
$('#txtValidaPassword').css('border','2px solid #A52525');
}

}else{
$('#txtPassword').css('border','2px solid #A52525');
}
}else{
$('#txtPassword').css('border','2px solid #A52525');
}

}else{
$('#txtUsuario').css('border','2px solid #A52525');
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
  <a class="text-dark" onclick="history.back()">Recursos humanos perfil</a>
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
  
  <div class="col-12">
  <div id="ContenidoPerfil" class="cardAG"></div>
  </div> 

  </div>
  </div> 

</div>

  <div class="modal" id="Modal">
    <div class="modal-dialog" style="margin-top: 83px;">
      <div class="modal-content">
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