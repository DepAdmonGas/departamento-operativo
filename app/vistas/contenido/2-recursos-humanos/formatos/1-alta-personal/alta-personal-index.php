<?php
require 'app/help.php';
$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($GET_idEstacion);
$estacion = '('.$datosEstacion['localidad'].')';

$sql_formatos = "SELECT fecha FROM op_rh_formatos WHERE id = '" . $GET_idReporte . "' ";
$result_formatos = mysqli_query($con, $sql_formatos);

while ($row_formatos = mysqli_fetch_array($result_formatos, MYSQLI_ASSOC)) {
$explode = explode(' ', $row_formatos['fecha']);
$HoraFormato = date("g:i a",strtotime($explode[1]));
}

$sql_lista = "SELECT id FROM op_rh_formatos_alta WHERE id_formulario = '" . $GET_idReporte . "' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
 


?>

<html lang="es">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Dirección de operaciones</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <link rel="shortcut icon" href="<?= RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="apple-touch-icon" href="<?= RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="stylesheet" href="<?= RUTA_CSS2 ?>alertify.css">
  <link rel="stylesheet" href="<?= RUTA_CSS2 ?>themes/default.rtl.css">
  <link href="<?= RUTA_CSS2; ?>bootstrap.min.css" rel="stylesheet" />
  <link href="<?= RUTA_CSS2; ?>navbar-general.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?= RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS ?>signature_pad.js"></script>
  <link rel="stylesheet" href="<?=RUTA_CSS ?>selectize.css">


  <script type="text/javascript">
  $(document).ready(function ($) {
  $(".LoaderPage").fadeOut("slow");
  listaAltaPersonal(<?=$GET_idReporte?>)

  });

  function listaAltaPersonal(idReporte){
  $('#DivAltaPersonal').load('../../app/vistas/contenido/2-recursos-humanos/formatos/1-alta-personal/lista-alta-personal.php?idReporte=' + idReporte);
  }
 
  // ---------- MODAL AGREGAR PERSONAL ----------//
  function modalNuevoPersonal(idReporte,idEstacion){
  $('#Modal').modal('show');  
  $('#ContenidoModal').load('../../app/vistas/contenido/2-recursos-humanos/formatos/1-alta-personal/modal-alta-personal.php?idReporte=' + idReporte + '&idEstacion=' + idEstacion);
  }

  // ---------- AGREGAR PERSONAL (SERVER) ----------//
  function agregarPersonal(idReporte, idEstacion) {

  var NombresCompleto = $('#NombresCompleto').val();
  var Puesto = $('#Puesto').val();
  var FechaIngreso = $('#FechaIngreso').val();
  var sd = $('#sd').val();

  //---------- DOCUMENTACION ----------
  var DocumentoCV = document.getElementById("CV");
  var DocumentoCV_file = DocumentoCV.files[0];

  var DocumentoINE = document.getElementById("INE");
  var DocumentoINE_file = DocumentoINE.files[0];

  var DocumentoNacimiento = document.getElementById("A_Nacimiento");
  var DocumentoNacimiento_file = DocumentoNacimiento.files[0];

  var DocumentoNSS = document.getElementById("C_IMSS");
  var DocumentoNSS_file = DocumentoNSS.files[0];

  var DocumentoDomicilio = document.getElementById("C_Domicilio");
  var DocumentoDomicilio_file = DocumentoDomicilio.files[0];
 
  var DocumentoEstudios = document.getElementById("C_Estudios");
  var DocumentoEstudios_file = DocumentoEstudios.files[0];

  var DocumentoRecomendacion = document.getElementById("C_Recomendacion");
  var DocumentoRecomendacion_file = DocumentoRecomendacion.files[0];

  var DocumentoCURP = document.getElementById("CURP");
  var DocumentoCURP_file = DocumentoCURP.files[0];

  var DocumentoRFC = document.getElementById("RFC");
  var DocumentoRFC_file = DocumentoRFC.files[0];

  var DocumentoAntecedentes = document.getElementById("C_Antecedentes");
  var DocumentoAntecedentes_file = DocumentoAntecedentes.files[0];

  var DocumentoInfonavit = document.getElementById("A_Infonavit");
  var DocumentoInfonavit_file = DocumentoInfonavit.files[0];

  if (NombresCompleto != "") {
  $('#NombresCompleto').css('border', '');
  if (Puesto != "") {
  $('#Puesto').css('border', '');
  if (FechaIngreso != "") {
  $('#FechaIngreso').css('border', '');
  if (sd != "") {
  $('#sd').css('border', '');
  if (DocumentoCV_file) {
  $('#CV').css('border', '');                  
  if (DocumentoINE_file) {
  $('#INE').css('border', '');                     
  if (DocumentoNacimiento_file) {
  $('#A_Nacimiento').css('border', '');                          
  if (DocumentoNSS_file) {
  $('#C_IMSS').css('border', '');                           
  if (DocumentoDomicilio_file) {
  $('#C_Domicilio').css('border', '');                                  
  if (DocumentoEstudios_file) {
  $('#C_Estudios').css('border', '');                                     
  if (DocumentoRecomendacion_file) {
  $('#C_Recomendacion').css('border', '');                                         
  if (DocumentoCURP_file) {
  $('#CURP').css('border', '');                                              
  if (DocumentoRFC_file) {
  $('#RFC').css('border', '');                                               

  // Validar solo si el puesto es igual a 6
  if (Puesto == "4") {
  if (DocumentoAntecedentes_file) {
  $('#C_Antecedentes').css('border', '');
  } else {
  alertify.error('La carta de antecedentes no penales es obligatoria.');
  $('#C_Antecedentes').css('border', '2px solid #A52525');
  return;
  }
  }   

  var data = new FormData();
  var url = '../../app/controlador/2-recursos-humanos/controladorFormatos.php';

  data.append('idReporte', idReporte);
  data.append('idEstacion', idEstacion);
  data.append('NombreCompleto', NombresCompleto);
  data.append('Puesto', Puesto);
  data.append('FechaIngreso', FechaIngreso);
  data.append('sd', sd);

  data.append('CV', DocumentoCV_file);
  data.append('INE', DocumentoINE_file);
  data.append('A_Nacimiento', DocumentoNacimiento_file);
  data.append('C_IMSS', DocumentoNSS_file);
  data.append('C_Domicilio', DocumentoDomicilio_file);
  data.append('C_Estudios', DocumentoEstudios_file);
  data.append('C_Recomendacion', DocumentoRecomendacion_file);
  data.append('CURP', DocumentoCURP_file);
  data.append('RFC', DocumentoRFC_file);
  data.append('C_Antecedentes', DocumentoAntecedentes_file);
  data.append('A_Infonavit', DocumentoInfonavit_file);
  data.append('accion', 'agregar-personal-alta');

  $(".LoaderPage").show();

  $.ajax({
  url: url,
  type: 'POST',
  contentType: false,
  data: data,
  processData: false,
  cache: false
  }).done(function (data) {

  if (data == 1) {
  $(".LoaderPage").hide();
  $('#Modal').modal('hide');
  listaAltaPersonal(idReporte);
  alertify.success('Empleado agregado exitosamente.');
  
  } else {
  alertify.error('Error al agregar empleado');
  }
  
  });

  } else {
  alertify.error('La Constancia de Situación Fiscal es obligatoria.');
  $('#RFC').css('border', '2px solid #A52525');
  }
  } else {
  alertify.error('El CURP es obligatorio.');
  $('#CURP').css('border', '2px solid #A52525');
  }
  } else {
  alertify.error('Las cartas de recomendación son obligatorias.');
  $('#C_Recomendacion').css('border', '2px solid #A52525');  }
  } else {
  alertify.error('El comprobante de estudios es obligatorio.');
  $('#C_Estudios').css('border', '2px solid #A52525');
  }
  } else {
  alertify.error('El comprobante de domicilio es obligatorio.');
  $('#C_Domicilio').css('border', '2px solid #A52525');
  }
  } else {
  alertify.error('El comprobante de afiliación del IMMS es obligatorio.');
  $('#C_IMSS').css('border', '2px solid #A52525');
  }
  } else {
  alertify.error('El acta de nacimiento es obligatoria.');
  $('#A_Nacimiento').css('border', '2px solid #A52525');
  }
  } else {
  alertify.error('La identificación es obligatoria.');
  $('#INE').css('border', '2px solid #A52525');
  }
  } else {
  $('#CV').css('border', '2px solid #A52525');
  alertify.error('La solicitud de empleo es obligatoria.');
  }
  } else {
  $('#sd').css('border', '2px solid #A52525');
  alertify.error('El salario diario es obligatorio.');
  }
  } else {
  $('#FechaIngreso').css('border', '2px solid #A52525');
  alertify.error('La fecha de alta es obligatoria.');
  }
  } else {
  $('#Puesto').css('border', '2px solid #A52525');
  alertify.error('El puesto es obligatorio.');
  }

  } else {
  $('#NombresCompleto').css('border', '2px solid #A52525');
  alertify.error('El nombre es obligatorio.');

  }
  }


  // ---------- ELIMINAR PERSONAL (SERVER) ----------//
  function eliminarPersonal(idUsuario,idReporte){
    
  alertify.confirm('',
  function(){

  var parametros = {
  "idUsuario" : idUsuario,
  "accion" : "eliminar-personal-alta"
  };

  $.ajax({ 
  data:  parametros,
  url:    '../../app/controlador/2-recursos-humanos/controladorFormatos.php',
  type:  'post',
  beforeSend: function() {
        
  },
  complete: function(){

  }, 
  success:  function (response) {
    console.log(response)

  if(response == 1){ 
  listaAltaPersonal(idReporte);
  alertify.success('Empleado eliminado exitosamente.');   
  
  }else{
  alertify.error('Error al eliminar empleado');    
  }

  }
  });
  },
  function(){

  }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar el empleado seleccionado?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();
  
  }


  //---------- FINALIZAR ALTA PERSONAL ----------//
  function Finalizar(idReporte, tipoFirma) {
  let signatureBlank = signaturePad.isEmpty();
  var ctx = document.getElementById("canvas");
  var image = ctx.toDataURL();
  document.getElementById('base64').value = image;
  var base64 = $('#base64').val();
  var canvas = $('#canvas').val();

  if (!signatureBlank) {

  var data = new FormData();
  var url = '../../app/controlador/2-recursos-humanos/controladorFormatos.php';

  data.append('idReporte', idReporte);
  data.append('idUsuario', <?=$Session_IDUsuarioBD?>);
  data.append('tipoFirma', tipoFirma);
  data.append('base64', base64);
  data.append('accion', 'finalizar-formato-firma');

  alertify.confirm('',
  function () {

  $(".LoaderPage").show();

  $.ajax({
  url: url,
  type: 'POST',
  contentType: false,
  data: data,
  processData: false,
  cache: false 
  }).done(function (data) {


  if (data == 1) {
  history.go(-1);
  } else {
  $(".LoaderPage").hide();
  alertify.error('Error al finalizar');
  }

  });

  },
  function () {


  }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea finalizar el formato?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();


  } else {
  alertify.error('Falta agregar la firma');
  }

  }

  function documentosPersonal(idUsuario,idReporte){
  $('#Modal2').modal('show');  
  $('#ContenidoModal2').load('../../app/vistas/contenido/2-recursos-humanos/formatos/1-alta-personal/modal-documentos-alta-personal.php?idUsuario=' + idUsuario + '&idReporte=' + idReporte + '&idTipo=' + 0 + '&formato=' + 0);
  }

  </script>
  </head>

  <body>
  <div class="LoaderPage"></div>

  <!---------- DIV - CONTENIDO ---------->
  <div id="content">
  <!---------- NAV BAR - PRINCIPAL (TOP) ---------->
  <?php include_once "public/navbar/navbar-perfil.php"; ?>
  <!---------- CONTENIDO PAGINA WEB---------->
  <div class="contendAG container">
  <div class="cardAG p-3">

  <div class="row">

  <div class="col-12 ">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Recursos Humanos</a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Formulario Alta de Personal <?=$estacion?></li>
  </ol>
  </div>

  <div class="row">
  <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
  <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Formulario Alta de Personal <?=$estacion?></h3>
  </div>
                  
  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">       
  <button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="modalNuevoPersonal(<?=$GET_idReporte?>,<?=$GET_idEstacion?>)">
  <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar personal</button>
  </div>
                
  </div>      
  <hr>   
  </div>


  <div class="col-12 text-end mb-3 ">
  <b>Formato:</b> RH-ALT-01
  <br>
  <b>No. De control:</b> 00<?=$GET_idReporte?>
  
  <p>Huixquilucan, Edo. de México a <?=$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.$HoraFormato;?></p>
  </div>

  <div class="col-12">
  <b>Lic. Alejandro Guzmán</b>
  <br>
  <p><b>Departamento de Recursos Humanos</b></p>
  <p>Buenos días por medio del presente solicito de su amable apoyo para realizar la siguiente alta de personal.</p>
  </div>
 
  <div id="DivAltaPersonal" class="col-12"></div>

  <div class="col-12 text-center"><p>Sin más por el momento quedo de usted.</p><hr></div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
  <div class="table-responsive">
  <table class="custom-table" style="font-size: .8em;" width="100%">
  
  <thead class="tables-bg">
  <tr><th class="text-center align-middle">Firma de quien elabora</th></tr>
  </thead>

  <tbody class="bg-light"> 
  <tr>
  <td class="no-hover2 p-0">
  <div id="signature-pad" class="signature-pad border-0" style="cursor:crosshair">
  <div class="signature-pad--body">
  <canvas style="width: 100%; height: 200px; border-right: 0.1px solid rgb(33, 93, 152); border-left: 0.1px solid rgb(33, 93, 152); cursor: crosshair; touch-action: none;" id="canvas" width="900" height="150"></canvas>  
  <input type="hidden" name="base64" value="" id="base64">
  </div>
  </div>
  </td>
  </tr>
                      
  <tr><th colspan="6" class="bg-danger text-white p-2" onclick="resizeCanvas()"><i class="fa-solid fa-broom"></i> Limpiar firma</th></tr>
  </tbody>
  </table>
  </div>
  </div>

  <div class="col-12">
  <hr>
  <button type="button" class="btn btn-labeled2 btn-success float-end" onclick="Finalizar(<?=$GET_idReporte?>,'A')">
  <span class="btn-label2"><i class="fa fa-check"></i></span>Finalizar</button>
  </div>

  </div>
  </div>

  <!---------- MODAL RIGHT ----------> 
  <div class="modal right fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
  <div class="modal-content" id="ContenidoModal"></div>
  </div>
  </div>

  <!---------- MODAL CENTER ----------> 
  <div class="modal fade" id="Modal2" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  <div class="modal-content" id="ContenidoModal2">
  </div>
  </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="<?= RUTA_JS2 ?>signature-pad-functions.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html> 

