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

  idestacion = sessionStorage.getItem('idestacion');
  SelEstacion(idestacion)         
  }
  }

  });

  function Regresar(){
  sessionStorage.removeItem('idestacion');
  window.history.back();
  }

  function SelEstacion(idEstacion){
  let targets;
  targets = [7,8];

  sizeWindow();
  sessionStorage.setItem('idestacion', idEstacion);

  $('#ListaNegra').load('app/vistas/administrador/2-recursos-humanos/baja-personal/contenido-baja-personal-estaciones.php?idEstacion=' + idEstacion, function() {
  $('#tabla_baja_personal_' + idEstacion).DataTable({
  "stateSave": true,
  "language": {
  "url": "<?=RUTA_JS2?>/es-ES.json"
  },
  "order": [[0, "asc"]],
  "lengthMenu": [25, 50, 75, 100],
  "columnDefs": [
  { "orderable": false, "targets": targets },
  { "searchable": false, "targets": targets }
  ]
  });
  });
  
  }


  // ---------- ARCHIVOS DEL PERSONAL (MODAL) ----------
  function ArchivosBaja(idBaja,idEstacion){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('app/vistas/administrador/2-recursos-humanos/baja-personal/modal-archivos-baja-personal.php?idBaja=' + idBaja + "&idEstacion=" + idEstacion);
  }

  function subirArchivoBaja(idBaja,idEstacion){

  var DescripcionArchivo   = $('#DescripcionArchivo').val();
  var ArchivoInput   = $('#Archivo').val();

  Archivo = document.getElementById("Archivo");
  Archivo_file = Archivo.files[0];
  Archivo_filePath = Archivo.value;

  var data = new FormData();
  //var url = 'public/recursos-humanos/modelo/agregar-archivo-baja-personal.php';
  var url = 'app/controlador/2-recursos-humanos/controladorDocumentosPersonal.php';

  if(DescripcionArchivo != ""){
  $('#DescripcionArchivo').css('border','');
  if(Archivo_filePath != ""){  
  $('#Archivo').css('border','');

  data.append('idBaja', idBaja);
  data.append('DescripcionArchivo', DescripcionArchivo);
  data.append('Archivo_file', Archivo_file);
  data.append('Accion', 'agregar-archivo-baja-personal');

  $(".LoaderPage").show();

  $.ajax({
  url: url,
  type: 'POST',
  contentType: false,
  data: data,
  processData: false,
  cache: false
  }).done(function(data){
  console.log(data)


  if(data == 1){
  $(".LoaderPage").hide();
  $('#ContenidoModal').load('app/vistas/administrador/2-recursos-humanos/baja-personal/modal-archivos-baja-personal.php?idBaja=' + idBaja + "&idEstacion=" + idEstacion);
  sizeWindow();
  alertify.success('Archivo agregado exitosamente.');
  }else{
  alertify.error('Error al agregar el archivo'); 
  }
  
  }); 

  }else{
  $('#Archivo').css('border','2px solid #A52525'); 
  }  
  }else{
  $('#DescripcionArchivo').css('border','2px solid #A52525'); 
  }

  }

  // ---------- COMENTARIOS BAJA (MODAL) ----------
  function ComentarioBaja(idBaja,idEstacion){
  $('#ModalComentario').modal('show');
  $('#ContenidoModalComentario').load('app/vistas/administrador/2-recursos-humanos/baja-personal/modal-comentarios-baja-personal.php?idBaja=' + idBaja + "&idEstacion=" + idEstacion);
  }

  function GuardarComentario(idBaja,idEstacion){

  var Comentario = $('#Comentario').val();
  var parametros = {
  "idBaja" : idBaja,
  "idUsuario" : <?=$Session_IDUsuarioBD?>,
  "Comentario" : Comentario,
  "Accion" : "agregar-comentario-baja-personal"
  };

  if(Comentario != ""){
  $('#Comentario').css('border',''); 

  $.ajax({
  data:  parametros,
  //url:   'public/recursos-humanos/modelo/agregar-comentario-baja-personal.php',
  url:   'app/controlador/2-recursos-humanos/controladorDocumentosPersonal.php', 
  type:  'post',
  beforeSend: function() {

  },
  complete: function(){

  },
  success:  function (response) {
  if (response == 1) {
  $('#Comentario').val('');
  alertify.success('Comentario agregado exitosamente');
  ComentarioBaja(idBaja,idEstacion)  
  SelEstacion(idEstacion);
  sizeWindow();

  }else{
  alertify.error('Error al agregar el comentario');  
  }

  } 
  });

  }else{
  $('#Comentario').css('border','2px solid #A52525'); 
  }

  }
 
  // ---------- EDITAR PROCESO DE BAJA (MODAL) ----------
  function EditarProceso(idBaja, idEstacion){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('app/vistas/administrador/2-recursos-humanos/baja-personal/modal-editar-proceso-baja.php?idBaja=' + idBaja + '&idEstacion=' + idEstacion);
  }
  
  function EditarProcesoPersonal(idBaja,idEstacion){
 
  var Proceso = $('#Proceso').val();
  var Status = $('#Status').val();
  var Solucion = $('#Solution').val(); 


  var parametros = {
  "idBaja" : idBaja,
  "Solucion" : Solucion,
  "Proceso" : Proceso,
  "Status" : Status,
  "Accion" : "editar-proceso-baja-personal"
  };
 
  if(Proceso != ""){
  $('#Proceso').css('border',''); 

  $.ajax({
  data:  parametros,
  //url:   'public/recursos-humanos/modelo/editar-proceso-baja-personal.php',
  url:   'app/controlador/2-recursos-humanos/controladorDocumentosPersonal.php', 
  type:  'post',
  beforeSend: function() {

  },
  complete: function(){

  }, 
  success:  function (response) {
  console.log(response);

  if (response == 1) {
  $('#Proceso').val('');
  SelEstacion(idEstacion);
  sizeWindow();
  $('#Modal').modal('hide');
  alertify.success('Proceso de baja editado exitosamente');

  }else{
  alertify.error('Error al editar el proceso de baja');  
  }

  } 
  });

  }else{
  $('#Proceso').css('border','2px solid #A52525'); 
  }

  }

  // ---------- ELIMINAR ARCHIVO BAJA ----------
  function eliminarArchivoBaja(idArchivo,idBaja,idEstacion){
   
  alertify.confirm('',
  function(){
 
  var parametros = {
  "idArchivo" : idArchivo,
  "Accion" : "eliminar-archivo-baja-personal"
  };
 
  $.ajax({
  data:  parametros,
  //url:   'public/recursos-humanos/modelo/eliminar-archivo-baja-personal.php',
  url:   'app/controlador/2-recursos-humanos/controladorDocumentosPersonal.php', 
  type:  'post',
  beforeSend: function() {
    
  },
  complete: function(){
 
  },
  success:  function (response) {
 
  if(response == 1){
  sizeWindow();
  $('#ContenidoModal').load('app/vistas/administrador/2-recursos-humanos/baja-personal/modal-archivos-baja-personal.php?idBaja=' + idBaja + "&idEstacion=" + idEstacion);
  alertify.success('Archivo eliminado exitosamente.');  
  
  }else{
  alertify.error('Error al eliminar el archivo');    
  }
 
  } 
  });
 
  },
  function(){
  }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar el archivo seleccionado?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();
 
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

  $FInicio = date("Y").'-'.date("m").'-01';
  $FTermino = date("Y-m-t", strtotime($FInicio));

  $sql_listaestacion = "SELECT id, numlista, localidad FROM op_rh_localidades WHERE numlista <= 8 OR numlista = 10 ORDER BY numlista ASC";
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

$ToSolicitudBaja = $ClassRecursosHumanosGeneral->ToSolicitudBaja($id);


  if($ToSolicitudBaja > 0){
    $Total = '<div class="float-end"><span class="badge bg-danger text-white rounded-circle"><small>'.$ToSolicitudBaja.'</small></span></div>';
  }else{
   $Total = ''; 
  }

  echo '  
  <li>
    <a class="pointer" onclick="SelEstacion('.$id.')">
    <i class="'.$icon.'" aria-hidden="true" style="padding-right: 10px;"></i>
     '.$Total.' '.$estacion.'
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
  <a class="text-dark" onclick="history.back()">Recursos Humanos</a>
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
  
  <div class="col-12" id="ListaNegra"> </div> 

  </div>
  </div>

  </div>
  </div>

  
  <!---------- MODAL AGREGAR ----------> 
  <div class="modal fade" id="Modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  <div class="modal-content" id="ContenidoModal">
  </div>
  </div>
  </div>

<!---------- MODAL COMENTARIO ----------> 
<div class="modal fade" id="ModalComentario" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
  <div class="modal-content" id="ContenidoModalComentario">
  </div>
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