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
  <link href="<?=RUTA_CSS2;?>navbar-general.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

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

  SelPersonalES(<?=$Session_IDEstacion?>,1,false)

  if(<?=$Session_IDEstacion?> == 2){
  SelPersonalES(9,1,false)
  }

  });

  function Regresar(){
  sessionStorage.removeItem('idestacion');
  window.history.back();
  }
 
  function SelPersonalES(idEstacion, idActivos, validacion) {
  let referencia, targets;
    
  if (idActivos == 1) {

  if(idEstacion == 9){
  referencia = '#ContenidoPersonalRHAutolavado';
  }else{
  referencia = '#ContenidoPersonalRH';
  }

  targets = [6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21];
  
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

  //---------- ASISTENCIA DEL PERSONAL ----------
  function Asistencia(idPersonal){
  window.location.href = "recursos-humanos-personal-asistencia/" + idPersonal; 
  }

  //---------- ACCESO DEL PERSONAL ----------
  function Acceso(idPersonal){
  $('#Modal').modal('show');   
  $('#ContenidoModal').load('app/vistas/contenido/2-recursos-humanos/personal/modal-acceso-personal.php?idPersonal=' + idPersonal);  
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

    console.log(data)

  if(data == 1){
  $(".LoaderPage").hide();
  $('#Modal2').modal('hide');  
  SelPersonalES(idEstacion,1,false);
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
  SelPersonalES(idEstacion,1,false);
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
  <div id="ContenidoPersonalRH"></div>
  <div id="ContenidoPersonalRHAutolavado"></div>
  <div id="ContenidoPersonalRHNoActivo"></div>
  </div>

  </div>
  </div>

  <!---------- MODAL CENTRADO ----------> 
  <div class="modal fade" id="Modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
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
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>
  
  <!---------- LIBRERIAS DEL DATATABLE ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.js"></script>

</body>
</html>