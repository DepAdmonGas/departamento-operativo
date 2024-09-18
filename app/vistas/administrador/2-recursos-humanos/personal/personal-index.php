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
  $('[data-toggle="tooltip"]').tooltip();
  sizeWindow();

  if(sessionStorage){
  if (sessionStorage.getItem('idestacion') !== undefined && sessionStorage.getItem('idestacion')) {

  idEstacion = sessionStorage.getItem('idestacion');
  SelEstacion(idEstacion,1,true)
  SelEstacion(idEstacion,0,true)
  }     
  }  

  }); 
   
  function SelEstacion(idEstacion, idActivos, validacion){
  sizeWindow();  
  sessionStorage.setItem('idestacion', idEstacion);

  let referencia, targets;
    
    if (idActivos == 1) {
    referencia = '#ContenidoPersonalRH';
    targets = [6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21];
    
    SelEstacion(idEstacion, 0, validacion);

    }else{
    referencia = '#ContenidoPersonalRHNoActivo';
    targets = [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21];
  
    if (validacion) {
    targets.push(22);
    }
  
    }
  
    $(referencia).load('app/vistas/contenido/2-recursos-humanos/personal/lista-personal.php?idEstacion=' + idEstacion + '&idActivos=' + idActivos, function() {
    $('#tabla_personal_' + idActivos + '_' + idEstacion).DataTable({
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

  //---------- DOCUMENTACION PUESTO ----------
  function PuestoDiv(){
  var Puesto  = $('#Puesto').val();

  if(Puesto == 4){ 
  document.getElementById("Cartas_Penales").style.display = "block";
  }else{
  document.getElementById("Cartas_Penales").style.display = "none";
  }

  }

  //---------- AGREGAR DEL PERSONAL ----------
  function Mas(idEstacion){
  $('#Modal2').modal('show');  
  $('#ContenidoModal2').load('app/vistas/contenido/2-recursos-humanos/personal/modal-personal-estacion.php?idEstacion=' + idEstacion + '&idPersonal=0&Tipo=0');  

  }  

  //---------- EDITAR DEL PERSONAL ----------
  function EditarPersonal(idEstacion,idPersonal){
  $('#Modal2').modal('show');  
  $('#ContenidoModal2').load('app/vistas/contenido/2-recursos-humanos/personal/modal-personal-estacion.php?idEstacion=' + idEstacion + '&idPersonal=' + idPersonal + '&Tipo=1'); 
  }

  function personalRecursosHumanos(idEstacion, idPersonal, idTipo){
   
  if(idTipo == 0){
  var msg = "agregado"  
  var msg2 = "agregar";
  var valAccion = "agregar-informacion-personal";

  }else{
  var msg = "editado";
  var msg2 = "editar";
  var valAccion = "editar-informacion-personal";
  }
   
  var NoColaborador = $('#NoColaborador').val();
  var NombresCompleto = $('#NombresCompleto').val();
  var Puesto = $('#Puesto').val();
  var FechaIngreso = $('#FechaIngreso').val();
  var R_Personal = $('#R_Personal').val();
  var CV = $('#CV').val();
  var INE = $('#INE').val();
  var A_Nacimiento = $('#A_Nacimiento').val();
  var C_Domicilio = $('#C_Domicilio').val();
  var C_IMSS = $('#C_IMSS').val();
  var C_Recomendacion = $('#C_Recomendacion').val();
  var C_Estudios = $('#C_Estudios').val();
  var CURP = $('#CURP').val(); 
  var A_Infonavit = $('#A_Infonavit').val();
  var RFC = $('#RFC').val();
  var C_Antecedentes = $('#C_Antecedentes').val();
  var Contrato = $('#Contrato').val();
  var sd = $('#sd').val();

  //---------- DOCUMENTACION ----------
  DocumentoPersonal = document.getElementById("R_Personal");
  DocumentoPersonal_file = DocumentoPersonal.files[0];
  DocumentoPersonal_filePath = DocumentoPersonal.value;

  DocumentoCV = document.getElementById("CV");
  DocumentoCV_file = DocumentoCV.files[0];
  DocumentoCV_filePath = DocumentoCV.value;

  DocumentoINE = document.getElementById("INE");
  DocumentoINE_file = DocumentoINE.files[0];
  DocumentoINE_filePath = DocumentoINE.value;

  DocumentoNacimiento = document.getElementById("A_Nacimiento");
  DocumentoNacimiento_file = DocumentoNacimiento.files[0];
  DocumentoNacimiento_filePath = DocumentoNacimiento.value;

  DocumentoDomicilio = document.getElementById("C_Domicilio");
  DocumentoDomicilio_file = DocumentoDomicilio.files[0];
  DocumentoDomicilio_filePath = DocumentoDomicilio.value;

  DocumentoNSS = document.getElementById("C_IMSS");
  DocumentoNSS_file = DocumentoNSS.files[0];
  DocumentoNSS_filePath = DocumentoNSS.value;
 
  DocumentoRecomendacion = document.getElementById("C_Recomendacion");
  DocumentoRecomendacion_file = DocumentoRecomendacion.files[0];
  DocumentoRecomendacion_filePath = DocumentoRecomendacion.value;
  
  DocumentoEstudios = document.getElementById("C_Estudios");
  DocumentoEstudios_file = DocumentoEstudios.files[0];
  DocumentoEstudios_filePath = DocumentoEstudios.value; 

  DocumentoCURP = document.getElementById("CURP");
  DocumentoCURP_file = DocumentoCURP.files[0];
  DocumentoCURP_filePath = DocumentoCURP.value;

  DocumentoInfonavit = document.getElementById("A_Infonavit");
  DocumentoInfonavit_file = DocumentoInfonavit.files[0];
  DocumentoInfonavit_filePath = DocumentoInfonavit.value;

  DocumentoRFC = document.getElementById("RFC");
  DocumentoRFC_file = DocumentoRFC.files[0];
  DocumentoRFC_filePath = DocumentoRFC.value;

  DocumentoAntecedentes = document.getElementById("C_Antecedentes");
  DocumentoAntecedentes_file = DocumentoAntecedentes.files[0];
  DocumentoAntecedentes_filePath = DocumentoAntecedentes.value;

  DocumentoContrato = document.getElementById("Contrato");
  DocumentoContrato_file = DocumentoContrato.files[0];
  DocumentoContrato_filePath = DocumentoContrato.value;

  var data = new FormData();
  var url = 'app/controlador/2-recursos-humanos/controladorDocumentosPersonal.php';
   
  if(FechaIngreso != ""){
  $('#FechaIngreso').css('border','');
  if(NombresCompleto != ""){
  $('#NombresCompleto').css('border','');
  if(Puesto != ""){
  $('#Puesto').css('border','');
 
  data.append('idEstacion', idEstacion);
  data.append('idPersonal', idPersonal); 
  data.append('FechaIngreso', FechaIngreso); 
  data.append('NoColaborador', NoColaborador);
  data.append('NombreCompleto', NombresCompleto);
  data.append('Puesto', Puesto);
  data.append('sd', sd);

  data.append('DocumentoPersonal_file', DocumentoPersonal_file);
  data.append('DocumentoCV_file', DocumentoCV_file);
  data.append('DocumentoINE_file', DocumentoINE_file);
  data.append('DocumentoNacimiento_file', DocumentoNacimiento_file);
  data.append('DocumentoDomicilio_file', DocumentoDomicilio_file);
  data.append('DocumentoNSS_file', DocumentoNSS_file);
  data.append('DocumentoEstudios_file', DocumentoEstudios_file);
  data.append('DocumentoRecomendacion_file', DocumentoRecomendacion_file);
  data.append('DocumentoCURP_file', DocumentoCURP_file);
  data.append('DocumentoInfonavit_file', DocumentoInfonavit_file);
  data.append('DocumentoRFC_file', DocumentoRFC_file);
  data.append('DocumentoAntecedentes_file', DocumentoAntecedentes_file);
  data.append('DocumentoContrato_file', DocumentoContrato_file);

  data.append('Accion', valAccion);
   
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
  $('#Modal2').modal('hide');  
  SelEstacion(idEstacion,1,false);
  alertify.success('Personal ' + msg + ' exitosamente.');

  }else{
  alertify.error('Error al ' + msg2 + ' personal'); 
  }

  }); 
 

  }else{
  $('#Puesto').css('border','2px solid #A52525'); 
  }
  }else{
  $('#NombresCompleto').css('border','2px solid #A52525'); 
  }
  }else{
  $('#FechaIngreso').css('border','2px solid #A52525'); 
  }
    
  }

  //---------- COMENTARIOS PERSONAL ----------
  function ComentariosPersonal(idEstacion,idPersonal){
  $('#Modal').modal('show');  
  $('#ContenidoModal').load('app/vistas/contenido/2-recursos-humanos/personal/modal-comentarios-personal.php?idEstacion=' + idEstacion + '&idPersonal=' + idPersonal); 
  }
  
  function GuardarComentario(idEstacion,idPersonal){
  var Comentario = $('#Comentario').val();

  var parametros = {
  "idPersonal" : idPersonal,
  "idUsuario" : <?=$Session_IDUsuarioBD?>,
  "Comentario" : Comentario,
  "Accion" : "agregar-comentario-personal"
  }; 
    
  if(Comentario != ""){
  $('#Comentario').css('border',''); 

  $.ajax({
  data:  parametros,
  //url:   'public/recursos-humanos/modelo/agregar-comentario-personal.php', 
  url:   'app/controlador/2-recursos-humanos/controladorDocumentosPersonal.php', 
  type:  'post',
  beforeSend: function() {

  },
  complete: function(){  

  },
  success:  function (response) {

  if (response == 1) {
  sizeWindow();
  SelEstacion(idEstacion,1,true)
  $('#Comentario').val('');
  $('#ContenidoModal').load('app/vistas/contenido/2-recursos-humanos/personal/modal-comentarios-personal.php?idEstacion=' + idEstacion + '&idPersonal=' + idPersonal); 

  }else{
  alertify.error('Error al guardar el comentario');  
  }

  } 
  });

  }else{
  $('#Comentario').css('border','2px solid #A52525'); 
  }

  }

  //---------- ELIMINAR DEL PERSONAL ----------
  function EliminarPersonalV2(idPersonal){
  window.location.href = "recursos-humanos-baja-personal/" + idPersonal; 
  }

  function DetalleBajaPersonalV2(idBaja){
  window.location.href = "recursos-humanos-detalle-baja-personal/" + idBaja; 
  } 

  //---------- ACCESO DEL PERSONAL ----------
  function Acceso(idPersonal){
  $('#Modal').modal('show');   
  $('#ContenidoModal').load('app/vistas/contenido/2-recursos-humanos/personal/modal-acceso-personal.php?idPersonal=' + idPersonal);  
  } 
   
  function EditPin(idPersonal){
  var PinAcceso = $('#PinAcceso').val();

  if(PinAcceso != ""){
  if(PinAcceso.length >= 5){

  alertify.confirm('',
  function(){

  var parametros = {
  "idPersonal" : idPersonal,
  "PinAcceso" : PinAcceso,
  "Accion" : "agregar-pin-personal"
  };
   
  $.ajax({
  data:  parametros,
  //url:   'public/recursos-humanos/modelo/agregar-pin-personal.php',
  url:   'app/controlador/2-recursos-humanos/controladorDocumentosPersonal.php', 
  type:  'POST',
  beforeSend: function() {
  $(".LoaderPage").show();
  },

  complete: function(){

  },
  success:  function (response) {

  if (response == 1) { 
  //$('#ContenidoModal').load('public/recursos-humanos/vistas/modal-personal-acceso.php?idPersonal=' + idPersonal); 
  $('#ContenidoModal').load('app/vistas/contenido/2-recursos-humanos/personal/modal-acceso-personal.php?idPersonal=' + idPersonal);  
  $(".LoaderPage").hide();
  alertify.success('El PIN fue agregado exitosamente');

  }else if (response == 0){
  $(".LoaderPage").hide();
  alertify.error('El PIN no fue agregado');

  }else if (response == 2){
  $(".LoaderPage").hide();
  $('#PinAcceso').css('border','2px solid #A52525');  
  $('#Resultado').html('<div class="text-center text-danger"><small>El PIN ya esta utilizado intente con otro</small></div>');
  alertify.error('El PIN no fue agregado');
  }
 
  }
  });

  },
  function(){
  }).setHeader('Agregar PIN').set({transition:'zoom',message: '¿Desea agregar el siguiente PIN al personal de la empresa?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

  }else{
  $('#PinAcceso').css('border','2px solid #A52525');  
  $('#Resultado').html('<div class="text-center text-danger"><small>El PIN debe tener mínimo 5 dígitos</small></div>');
  }
  }else{
  $('#PinAcceso').css('border','2px solid #A52525');  
  }

  }
 
  function EditarPin() {
  var x = document.getElementById("inputEditar");
  if (x.style.display === "none") {
  x.style.display = "block";
    
  }else{
  x.style.display = "none";
  }

  } 

  //-----------------------------------------------------
  function Asistencia(idPersonal){
  window.location.href = "recursos-humanos-personal-asistencia/" + idPersonal; 
  } 

  function NominaIndividual(idPersonal){
  window.location.href = "recibo-nomina-individual/" + idPersonal;
  }

  function EvaluacionPersonal(idEstacion){
  window.location.href = "recursos-humanos-evaluacion-personal/" + idEstacion; 
  }


  window.addEventListener('pageshow', function(event) {
  if (event.persisted) {
  // Si la página está en la caché del navegador, recargarla
  window.location.reload();
  }
  });

  </script>
  </head>

  <body> 
 
  <div class="LoaderPage"></div>
   
  <!---------- CONTENIDO Y BARRA DE NAVEGACION ---------->
  <div class="wrapper">

  <!---------- BARRA DE NAVEGACION ---------->
  <nav id="sidebar">

  <div class="sidebar-header text-center"> <img class="" src="<?=RUTA_IMG_LOGOS."Logo.png";?>" style="width: 100%;"> </div>

  <ul class="list-unstyled components">
  <li> <a class="pointer" href="<?=SERVIDOR_ADMIN?>"> <i class="fa-solid fa-house" aria-hidden="true" style="padding-right: 10px;"></i>Menu </a> </li>
  <li> <a class="pointer" onclick="history.back()"> <i class="fas fa-arrow-left" aria-hidden="true" style="padding-right: 10px;"></i>Regresar </a> </li>
  <?php
 
  $sql_listaestacion = "SELECT id, numlista, localidad FROM op_rh_localidades WHERE numlista <= 8 OR numlista = 10 OR numlista = 12 OR numlista = 14 OR numlista = 15 OR numlista = 16 OR numlista = 17  ORDER BY numlista ASC";
  $result_listaestacion = mysqli_query($con, $sql_listaestacion);
  while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
  $id = $row_listaestacion['id'];
  $estacion = $row_listaestacion['localidad'];

  if($Session_IDUsuarioBD == 354 && ($id == 6 || $id == 7)){

  }else{

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

  echo '<li> <a class="pointer" onclick="SelEstacion('.$id.',1,true)"> <i class="'.$icon.'" aria-hidden="true" style="padding-right: 10px;"></i> '.$estacion.' </a> </li>';

  }
  }
  ?>
 
  </ul>
  </nav>

  <!---------- DIV - CONTENIDO ----------> 
  <div id="content">
  <!---------- NAV BAR - PRINCIPAL (TOP) ---------->  
  <nav class="navbar navbar-expand navbar-light navbar-bg" >
  <i class="fa-solid fa-bars menu-btn rounded pointer" id="sidebarCollapse"></i>
  <div class="pointer"> <a class="text-dark" onclick="history.back()">Recursos humanos</a> </div>
 
   
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
  
  <div id="ContenidoPersonalRH"></div>
  <div id="ContenidoPersonalRHNoActivo"></div>

  </div>
  </div> 

  </div>
  </div>

  <!---------- MODAL CENTRADO ----------> 
  <div class="modal fade" id="Modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
  <div class="modal-content" id="ContenidoModal"></div>
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