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
  .grayscale {
      filter: opacity(50%); 
  }
  </style>

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  sizeWindow();


  if(sessionStorage){ 
    if (sessionStorage.getItem('idestacion') !== undefined && sessionStorage.getItem('idestacion')) {

    idEstacion = sessionStorage.getItem('idestacion');
    year = sessionStorage.getItem('year');
    mes = sessionStorage.getItem('mes');

    $('#ListaNominaRevision').load('../public/recibo-nomina/vistas/lista-nomina-estaciones-revision.php?idEstacion=' + idEstacion +  '&year=' + year + '&mes=' + mes);
    
    }   
     
   } 
 

  });  
 
  function Regresar(){
   sessionStorage.removeItem('idestacion');
   sessionStorage.removeItem('year');
   sessionStorage.removeItem('mes');
   sessionStorage.removeItem('scrollTop');
   window.history.back();
  }

//---------- SELECCION DE ESTACIONES ---------- 
  function SelRevisionES(idEstacion,year,mes){
    sizeWindow();
    sessionStorage.setItem('idestacion', idEstacion);
    sessionStorage.setItem('year', year);
    sessionStorage.setItem('mes', mes);

  $('#ListaNominaRevision').load('../public/recibo-nomina/vistas/lista-nomina-estaciones-revision.php?idEstacion=' + idEstacion +  '&year=' + year + '&mes=' + mes);

  }

  function SelMesEstaciones(idEstacion,year){
    sizeWindow();
    var mes = $('#mesEstacion').val();
    sessionStorage.setItem('mes', mes);

    $('#ListaNominaRevision').load('../public/recibo-nomina/vistas/lista-nomina-estaciones-revision.php?idEstacion=' + idEstacion +  '&year=' + year + '&mes=' + mes);

  }


  //---------- COMENTARIOS DEL RECIBO DE NOMINA ----------
  function ModalComentario(idReporte,idEstacion,year,mes,SemQui,descripcion){
  $('#Modal').modal('show');  
  $('#DivContenido').load('../public/recibo-nomina/vistas/modal-comentarios-nomina.php?idReporte=' + idReporte + '&idEstacion=' + idEstacion + '&year=' + year + '&mes=' + mes + '&SemQui=' + SemQui + '&descripcion=' + descripcion);
  }

  function GuardarComentario(idReporte,idEstacion,year,mes,SemQui,descripcion){

var Comentario = $('#Comentario').val();

var parametros = {
"idReporte" : idReporte,
"Comentario" : Comentario
}; 
 
if(Comentario != ""){
$('#Comentario').css('border',''); 
  
$.ajax({
data:  parametros,
url:   '../public/recibo-nomina/modelo/agregar-comentario-nomina-v2.php',
type:  'post',
beforeSend: function() {
},
complete: function(){

},
success:  function (response) {

if (response == 1) {

$('#ListaNominaRevision').load('../public/recibo-nomina/vistas/lista-nomina-estaciones-revision.php?idEstacion=' + idEstacion +  '&year=' + year + '&mes=' + mes);

sizeWindow();
$('#Comentario').val('');
$('#DivContenido').load('../public/recibo-nomina/vistas/modal-comentarios-nomina.php?idReporte=' + idReporte + '&idEstacion=' + idEstacion + '&year=' + year + '&mes=' + mes + '&SemQui=' + SemQui + '&descripcion=' + descripcion);

}else{
 alertify.error('Error al guardar el comentario');  
}

} 
});

}else{
$('#Comentario').css('border','2px solid #A52525'); 
}

}


//---------- PUNTAJE RECIBO DE NOMINA (KPI) ----------
function FinalizarNomina(idResponsable,idEstacion,year,mes,SemQui,descripcion){

var data = new FormData(); 
var url = '../public/recibo-nomina/modelo/finalizar-recibos-nomina.php';

alertify.confirm('',
function(){
 
data.append('idResponsable', idResponsable);
data.append('idEstacion', idEstacion);
data.append('year', year);
data.append('mes', mes);
data.append('SemQui', SemQui);
data.append('descripcion', descripcion);
 
$(".LoaderPage").show();

  $.ajax({
  url: url,
  type: 'POST',
  contentType: false,
  data: data,
  processData: false,
  cache: false
  }).done(function(data){

  if(data == 1){
  $(".LoaderPage").hide();
  sizeWindow() 
  
  $('#ListaNominaRevision').load('../public/recibo-nomina/vistas/lista-nomina-estaciones-revision.php?idEstacion=' + idEstacion +  '&year=' + year + '&mes=' + mes);

  if(idResponsable == 1){
  $('#Modal').modal('hide'); 
  }

  alertify.success('Actividad finalizada exitosamente.');

  }else{
  $(".LoaderPage").hide();
  alertify.error('Error al finalizar la actividad'); 
  
  if(idResponsable == 1){
  $('#Modal').modal('hide'); 
  }

  }
  
  }); 

},
function(){

}).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea finalizar la actividad?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();
  
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
  
  $sql_listaestacion = "SELECT id, numlista, localidad FROM op_rh_localidades WHERE numlista <= 8 OR numlista = 10 OR numlista = 12 OR numlista = 14 OR numlista = 15 OR numlista = 16 OR numlista = 17 ORDER BY numlista ASC";

  $result_listaestacion = mysqli_query($con, $sql_listaestacion);
  while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
  $id = $row_listaestacion['id'];
  $estacion = $row_listaestacion['localidad'];
  $GET_mes_actual = date("n");

  $SelEstacion = "onclick='SelRevisionES(".$id.",".$GET_year.",".$GET_mes_actual.")'";


  if ($id == 6 || $id == 7) {
  $ocultarDiv = "d-none";
   
  }else{
    $ocultarDiv = "";
  }


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
  <li class="'.$ocultarDiv.'">
    <a class="pointer" '.$SelEstacion.'>
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
  <a class="text-dark" onclick="history.back()">Revisión recibos de nomina <?=$GET_year;?> </a>
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
  <div id="ListaNominaRevision" class="cardAG"></div>
  <?php

  ?>
  </div> 

  </div>
  </div>


  </div>
</div>


  <div class="modal" id="Modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" style="margin-top: 83px;">
      <div id="DivContenido"></div>
      </div>
    </div>
  </div>



  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>navbar-functions.js"></script>
  
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>


</body>
</html>