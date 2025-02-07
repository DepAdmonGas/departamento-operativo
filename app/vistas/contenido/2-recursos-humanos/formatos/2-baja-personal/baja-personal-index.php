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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
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
  $('#DivBajaPersonal').load('../../app/vistas/contenido/2-recursos-humanos/formatos/2-baja-personal/lista-baja-personal.php?idReporte=' + idReporte);
  }

  // ---------- MODAL AGREGAR PERSONAL ----------//
  function modalBajaPersonal(idReporte,idEstacion){
  $('#Modal').modal('show');  
  $('#ContenidoModal').load('../../app/vistas/contenido/2-recursos-humanos/formatos/2-baja-personal/modal-baja-personal.php?idReporte=' + idReporte + '&idEstacion=' + idEstacion);
  }

  // ---------- AGREGAR PERSONAL (SERVER) ----------//
  function agregarPersonal(idReporte,idEstacion){

  var NombresCompleto = $('#NombresCompleto').val();
  var FechaBaja = $('#FechaBaja').val();
  var Motivo = $('#Motivo').val();
  var Detalle = $('#Detalle').val();


  if(NombresCompleto != ""){
  $('#NombresCompleto').css('border','');
  if(FechaBaja != ""){
  $('#FechaBaja').css('border','');
  if(Motivo != ""){
  $('#Motivo').css('border','');

  var data = new FormData();
  var url = '../../app/controlador/2-recursos-humanos/controladorFormatos.php';
 
  data.append('idReporte', idReporte); 
  data.append('idEstacion', idEstacion);
  data.append('NombreCompleto', NombresCompleto);
  data.append('FechaBaja', FechaBaja); 
  data.append('Motivo', Motivo); 
  data.append('Detalle', Detalle); 

  data.append('accion', 'agregar-personal-baja');
    
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
  $('#Modal').modal('hide');  
  listaAltaPersonal(idReporte);
  alertify.success('Empleado agregado exitosamente.');

  }else{
  alertify.error('Error al agregar empleado'); 
  }

  }); 
 
  }else{
  $('#Motivo').css('border','2px solid #A52525'); 
  }
  }else{
  $('#FechaBaja').css('border','2px solid #A52525'); 
  }
  }else{
  $('#NombresCompleto').css('border','2px solid #A52525'); 
  }

  }

  // ---------- ELIMINAR PERSONAL (SERVER) ----------//
  function eliminarPersonal(idUsuario,idReporte){
    
  alertify.confirm('',
  function(){

  var parametros = {
  "idUsuario" : idUsuario,
  "accion" : "eliminar-personal-baja"
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

  function modalAnexosBaja(idUsuario,idReporte){
  $('#Modal').modal('show');  
  $('#ContenidoModal').load('../../app/vistas/contenido/2-recursos-humanos/formatos/2-baja-personal/modal-anexos-baja.php?idUsuario=' + idUsuario + '&idReporte=' + idReporte);
  }

  function subirAnexoBaja(idUsuario,idReporte){

  var DescripcionArchivo   = $('#DescripcionArchivo').val();
  var ArchivoInput   = $('#Archivo').val();

  Archivo = document.getElementById("Archivo");
  Archivo_file = Archivo.files[0];
  Archivo_filePath = Archivo.value;

  var data = new FormData();
  var url = '../../app/controlador/2-recursos-humanos/controladorFormatos.php';
 
  if(DescripcionArchivo != ""){
  $('#DescripcionArchivo').css('border','');
  if(Archivo_filePath != ""){  
  $('#Archivo').css('border','');

  data.append('idUsuario', idUsuario);
  data.append('DescripcionArchivo', DescripcionArchivo);
  data.append('Archivo_file', Archivo_file);
  data.append('accion', 'agregar-archivo-baja-personal');

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
  $('#ContenidoModal').load('../../app/vistas/contenido/2-recursos-humanos/formatos/2-baja-personal/modal-anexos-baja.php?idUsuario=' + idUsuario + '&idReporte=' + idReporte);
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


    // ---------- ELIMINAR ARCHIVO BAJA ----------
    function eliminarArchivoBaja(idArchivo,idUsuario,idReporte){
   
   alertify.confirm('',
    function(){
    
    var parametros = {
    "idArchivo" : idArchivo,
    "accion" : "eliminar-archivo-baja-personal"
    };
    
    $.ajax({
    data:  parametros,
    url:   '../../app/controlador/2-recursos-humanos/controladorFormatos.php', 
    type:  'post',
    beforeSend: function() {
      
    },
    complete: function(){

    },
    success:  function (response) {

    if(response == 1){
    $('#ContenidoModal').load('../../app/vistas/contenido/2-recursos-humanos/formatos/2-baja-personal/modal-anexos-baja.php?idUsuario=' + idUsuario + '&idReporte=' + idReporte);
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
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Formulario Baja de Personal <?=$estacion?></li>
  </ol>
  </div>

  <div class="row">
  <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
  <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Formulario Baja de Personal <?=$estacion?></h3>
  </div>

  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">       
  <button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="modalBajaPersonal(<?=$GET_idReporte?>,<?=$GET_idEstacion?>)">
  <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar personal</button>
  </div>
           
  </div>      
  <hr>   
  </div>

 
  <div class="col-12 text-end mb-3 ">
  <b>Formato:</b> RH-BAJ-02
  <br>
  <b>No. De control:</b> 00<?=$GET_idReporte?>
  
  <p>Huixquilucan, Edo. de México a <?=$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.$HoraFormato;?></p>
  </div>

  <div class="col-12">
  <b>Lic. Alejandro Guzmán</b>
  <br>
  <p><b>Departamento de Recursos Humanos</b></p>
  <p>Buenos días por medio del presente solicito de su amable apoyo para realizar las siguientes bajas de personal.</p>
  </div>
 
  <div id="DivBajaPersonal" class="col-12"></div>

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

  <!---------- MODAL CENTRADO ----------> 
  <div class="modal fade" id="Modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  <div class="modal-content" id="ContenidoModal"></div>
  </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="<?= RUTA_JS2 ?>signature-pad-functions.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html> 