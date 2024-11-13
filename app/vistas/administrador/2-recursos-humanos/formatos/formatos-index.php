<?php
require('app/help.php');
function ToSolicitud($idLocalidad,$idUsuario,$con){

if($idUsuario == 354){
  $sql_lista = "SELECT id FROM op_rh_formatos WHERE id_localidad = '".$idLocalidad."' AND status = 3 AND (formato IN (1, 2, 3, 4, 6, 7)) ORDER BY id DESC";

}else{
  $sql_lista = "SELECT id FROM op_rh_formatos WHERE id_localidad = '".$idLocalidad."' AND (status BETWEEN 1 AND 2) AND (formato IN (1, 2, 3, 4, 6, 7)) ORDER BY id DESC";
}

$result_lista = mysqli_query($con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);
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
 
  <!---------- LIBRERIAS DEL DATATABLE ---------->
  <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">
  <script type="text/javascript" src="<?=RUTA_JS ?>alertify.js"></script> 

  <script type="text/javascript">
  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  sizeWindow();

  if(sessionStorage){
  if (sessionStorage.getItem('idestacion') !== undefined && sessionStorage.getItem('idestacion')) {
    
  idEstacion = sessionStorage.getItem('idestacion');
  SelEstacion(idEstacion)
  }    
  }    
  }); 

 
  function Regresar(){
  sessionStorage.removeItem('idestacion');
  window.history.back();
  }
 
  function SelEstacion(idEstacion) {
  let targets;
  sizeWindow();
  sessionStorage.setItem('idestacion', idEstacion);
    
  targets = [4, 5, 6];

  $('#ContenidoFormatos').load('app/vistas/contenido/2-recursos-humanos/formatos/lista-formatos.php?idEstacion=' + idEstacion, function() {
  $('#tabla_formatos_' + idEstacion).DataTable({
  "stateSave": true,
  "language": {
  "url": "<?=RUTA_JS2?>/es-ES.json"
  },
  "order": [[0, "desc"]],
  "lengthMenu": [25, 50, 75, 100],
  "columnDefs": [
  { "orderable": false, "targets": targets },
  { "searchable": false, "targets": targets }
  ]
  });
  });
  
  } 

  //---------- AGREGAR FORMATOS ----------
  function Formulario(Formato,idEstacion){

  var parametros = {
  "idEstacion" : idEstacion,
  "Formato" : Formato,
  "accion": "agregar-formulario"
  };
 
  $.ajax({
  data:  parametros,
  url: 'app/controlador/2-recursos-humanos/controladorFormatos.php',
  type:  'post',
  beforeSend: function() {
    
  },
  complete: function(){
  
  },
  success:  function (response) {

  if (response != 0) {
 
  if(Formato == 1){
  window.location.href = "recursos-humanos-formulario-alta-personal/" + idEstacion + '/' + response; 

  }else if(Formato == 2){
  window.location.href = "recursos-humanos-formulario-baja-personal/" + idEstacion + '/' + response; 

  }else if(Formato == 3){
  window.location.href = "recursos-humanos-formulario-falta-personal/" + idEstacion + '/' + response; 

  }else if(Formato == 4){
  window.location.href = "recursos-humanos-formulario-reestructuracion-personal/" + idEstacion + '/' + response; 

  }else if(Formato == 5){
  window.location.href = "recursos-humanos-formulario-ajuste-salarial/" + idEstacion + '/' + response; 

  }else if(Formato == 6){
  window.location.href = "recursos-humanos-formulario-vacaciones-personal/" + idEstacion + '/' + response; 

  }else if(Formato == 7){
  window.location.href = "recursos-humanos-formulario-prima-vacacional/" + idEstacion + '/' + response; 

  }
 
  }else{
  alertify.error('Error al crear formato');  
  }

  }
  }); 
 
  }


  //---------- EDITAR FORMATOS ----------
  function EditFormulario(idEstacion,idReporte,Formato){

  if(Formato == 1){  

  window.location.href = "recursos-humanos-formulario-alta-personal/" + idEstacion + '/' + idReporte; 

  }else if(Formato == 2){
  window.location.href = "recursos-humanos-formulario-baja-personal/" + idEstacion + '/' + idReporte; 

  }else if(Formato == 3){
  window.location.href = "recursos-humanos-formulario-falta-personal/" + idEstacion + '/' + idReporte; 

  }else if(Formato == 4){
  window.location.href = "recursos-humanos-formulario-reestructuracion-personal/" + idEstacion + '/' + idReporte; 

  }else if(Formato == 5){
  window.location.href = "recursos-humanos-formulario-ajuste-salarial/" + idEstacion + '/' + idReporte; 

  }else if(Formato == 6){
  window.location.href = "recursos-humanos-formulario-vacaciones-personal/" + idEstacion + '/' + idReporte; 

  }else if(Formato == 7){
  window.location.href = "recursos-humanos-formulario-prima-vacacional/" + idEstacion + '/' + idReporte; 

  }

  }


  //---------- FIRMAR FORMATOS ----------
  function Firmar(idEstacion,idFormato){
  window.location.href = "recursos-humanos-formatos-firma/" + idFormato; 

  }


  //---------- COMENTARIOS FORMATOS ----------
  function ModalComentario(idReporte,idEstacion){
  $('#ModalComentario').modal('show');  
  $('#ContenidoModalComentario').load('app/vistas/contenido/2-recursos-humanos/formatos/modal-comentario-formatos.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte); 
  } 

  
  function GuardarComentario(idReporte,idEstacion){
  var Comentario = $('#Comentario').val();

  var parametros = {
  "idFormato" : idReporte,
  "idUsuario" : <?=$Session_IDUsuarioBD?>,
  "Comentario" : Comentario,
  "accion" : "agregar-comentario-formatos"
  }; 
    
  if(Comentario != ""){
  $('#Comentario').css('border',''); 

  $.ajax({
  data:  parametros,
  //url:   'public/recursos-humanos/modelo/agregar-comentario-personal.php', 
  url:   'app/controlador/2-recursos-humanos/controladorFormatos.php', 
  type:  'post',
  beforeSend: function() {

  },
  complete: function(){  

  },
  success:  function (response) {

  if (response == 1) {
  sizeWindow();
  SelEstacion(idEstacion)
  alertify.success('Comentario agregado exitosamente');
  $('#Comentario').val('');
  ModalComentario(idReporte,idEstacion)
  }else{
  alertify.error('Error al guardar el comentario');  
  }

  } 
  });

  }else{
  $('#Comentario').css('border','2px solid #A52525'); 
  }

  }


  //---------- ELIMINAR FORMULARIO ----------
  function DeleteFormulario(idReporte,idEstacion){
    
  alertify.confirm('',
  function(){

  var parametros = {
  "idReporte" : idReporte,
  "accion" : "eliminar-formato"
  };

  $.ajax({ 
  data:  parametros,
  url:    'app/controlador/2-recursos-humanos/controladorFormatos.php',
  type:  'post',
  beforeSend: function() {
        
  },
  complete: function(){

  }, 
  success:  function (response) {
    console.log(response)

  if(response == 1){ 
  SelEstacion(idEstacion)
  alertify.success('Formato eliminado exitosamente.');   
  
  }else{
  alertify.error('Error al eliminar el formato');    
  }

  }
  });
  },
  function(){

  }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar el formato seleccionado?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();
  
  }


  //---------- DETALLE FORMATOS ----------
  function DetalleFormulario(idReporte,idFormato){
  $('#Modal2').modal('show');  
  $('#ContenidoModal2').load('app/vistas/contenido/2-recursos-humanos/formatos/modal-detalle-formatos.php?idReporte=' + idReporte + '&idFormato=' + idFormato); 
  } 

    //---------- DETALLE FORMATOS ----------

  function DescargarPDF(idReporte,idFormato){
  window.location.href = 'app/vistas/contenido/2-recursos-humanos/formatos/pdf-formatos.php?idReporte=' + idReporte + '&idFormato=' + idFormato;
  }

  window.addEventListener('pageshow', function(event) {
  if (event.persisted) {
  // Si la página está en la caché del navegador, recargarla
  window.location.reload();
  }
  });


  </script>
  </head>

  <body class="bodyAG"> 

  <div class="LoaderPage"></div>
  <!---------- CONTENIDO Y BARRA DE NAVEGACION ---------->
  <div class="wrapper">
  <!---------- BARRA DE NAVEGACION ---------->
  <nav id="sidebar">
  <div class="sidebar-header text-center"><img class="" src="<?=RUTA_IMG_LOGOS."Logo.png";?>" style="width: 100%;"></div>
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

  $FInicio = date("Y").'-'.date("m").'-01';
  $FTermino = date("Y-m-t", strtotime($FInicio));

  $sql_listaestacion = "SELECT id, numlista, localidad FROM op_rh_localidades WHERE numlista <= 8 OR numlista = 10 OR numlista = 12 OR numlista = 14 OR numlista = 15 OR numlista = 16 OR numlista = 17  ORDER BY numlista ASC";
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

  }else if($estacion == "Dirección de Operaciones" ||
  $estacion == "Departamento Gestión" ||
  $estacion == "Departamento Jurídico" ||
  $estacion == "Departamento Mantenimiento" ||
  $estacion == "Departamento Sistemas"){
  $icon = "fa-solid fa-briefcase"; 
 
  }else{
  $icon = "fa-solid fa-gas-pump";    
  }
   

  $ToSolicitud = ToSolicitud($id,$Session_IDUsuarioBD,$con);

  if($ToSolicitud > 0){
  $Nuevo = '<div class="float-end"><span class="badge bg-danger text-white rounded-circle"><small>'.$ToSolicitud.'</small></span></div>';
  }else{
  $Nuevo = ''; 
  }

  echo '  
  <li> <a class="pointer" onclick="SelEstacion('.$id.')"> <i class="'.$icon.'" aria-hidden="true" style="padding-right: 10px;"></i> '.$Nuevo.' '.$estacion.' </a> </li>';

  }

  ?> 

  </ul>
  </nav>
   
  <!---------- DIV - CONTENIDO ----------> 
  <div id="content">
  <!---------- NAV BAR - PRINCIPAL (TOP) ---------->  
  <nav class="navbar navbar-expand navbar-light navbar-bg" >
  
  <i class="fa-solid fa-bars menu-btn rounded pointer" id="sidebarCollapse"></i>

  <div class="pointer"><a class="text-dark" onclick="history.back()">Recursos humanos</a></div>
 
  <div class="navbar-collapse collapse">
  <div class="dropdown-divider"></div>

  <ul class="navbar-nav navbar-align">

  <li class="nav-item dropdown">
  <a class=" dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown"><i class="align-middle" data-feather="settings"></i></a>
  
  <a class="nav-link dropdown-toggle d-none d-sm-inline-block pointer" data-bs-toggle="dropdown">
  <img src="<?=RUTA_IMG_ICONOS."usuarioBar.png";?>" class="avatar img-fluid rounded-circle"/>
  <span class="text-dark" style="padding-left: 10px;"><?=$session_nompuesto;?> </span>
  </a>
  
  <div class="dropdown-menu dropdown-menu-end">
  <div class="user-box">
  <div class="u-text"><p class="text-muted">Nombre de usuario:</p><h4><?=$session_nomusuario;?></h4></div>
  </div>
 
  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="<?=PERFIL_ADMIN?>"><i class="fa-solid fa-user" style="padding-right: 5px;"></i>Perfil</a>
 
  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="<?=RUTA_SALIR2?>salir"><i class="fa-solid fa-power-off" style="padding-right: 5px;"></i> Cerrar Sesión</a>
  </div>
  </li>
  
  </ul>
  </div>

  </nav>
 
  <!---------- CONTENIDO PAGINA WEB----------> 
  <div class="contendAG">
  <div class="row">  

  <div id="ContenidoFormatos" class="col-12"></div>
  
  </div>
  </div> 
  </div>

  </div>


  <div class="modal" id="ModalComentario" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md">
  <div class="modal-content">
  <div id="ContenidoModalComentario"></div>
  </div>
  </div>
  </div>


  <div class="modal" id="Modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
  <div class="modal-content">
  <div id="ContenidoModal"></div>
  </div>
  </div>
  </div>


  <!---------- MODAL RIGHT ----------> 
  <div class="modal right fade" id="Modal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
  <div class="modal-content" id="ContenidoModal2"></div>
  </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>navbar-functions.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  <!---------- LIBRERIAS DEL DATATABLE ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.js"></script>

</body>
</html> 