<?php
require('app/help.php');

$FInicio = date("Y").'-'.date("m").'-01';
$FTermino = date("Y-m-t", strtotime($FInicio));

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
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");

  ListaEstimulo(<?=$Session_IDEstacion;?>,'<?=$FInicio;?>','<?=$FTermino;?>');
  ListaPagoEstimulo(<?=$Session_IDEstacion;?>);
    
  }); 

  function Regresar(){
  window.history.back();
  }  
 
  function ListaEstimulo(idestacion,fechainicio,fechatermino){
   $('#ListaEstimulo').load('app/vistas/personal-general/1-corporativo/estimulo-fiscal/lista-estimulo-fiscal.php?idEstacion=' + idestacion + '&FechaInicio=' + fechainicio + '&FechaTermino=' + fechatermino);
  }
  
  function ListaPagoEstimulo(idestacion){
  $('#ListaPagoEstimulo').load('app/vistas/personal-general/1-corporativo/estimulo-fiscal/lista-pago-estimulo-fiscal.php?idEstacion=' + idestacion);

  } 

  function btnModalBuscar(idEstacion){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('app/vistas/personal-general/1-corporativo/estimulo-fiscal/modal-buscar-estimulo.php?idEstacion=' + idEstacion); 
  } 

  function BuscarReporte(idestacion){
  var fechainicio = $('#FInicio').val();
  var fechatermino = $('#FTermino').val();

  if (fechainicio != "") {
  $('#FInicio').css('border','');
  if (fechatermino != "") {
  $('#FTermino').css('border','');

  $('#Modal').modal('hide');
  $('#ListaEstimulo').load('app/vistas/personal-general/1-corporativo/estimulo-fiscal/lista-estimulo-fiscal.php?idEstacion=' + idestacion + '&FechaInicio=' + fechainicio + '&FechaTermino=' + fechatermino);


  }else{
  $('#FTermino').css('border','2px solid #A52525');
  }
  }else{
  $('#FInicio').css('border','2px solid #A52525');
  }
   

  }

  function btnModal(idEstacion){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('app/vistas/personal-general/1-corporativo/estimulo-fiscal/modal-agregar-estimulo-fiscal.php?idEstacion=' + idEstacion); 
  } 


  function Guardar(idEstacion){

  var MFInicio = $('#MFInicio').val();
  var MFTermino = $('#MFTermino').val();

  var data = new FormData();
  //var url = 'public/corte-diario/modelo/agregar-estimulo-fiscal.php';
  var url = 'app/controlador/1-corporativo/controladorEstimuloFiscal.php',

  PDF = document.getElementById("PDF");
  PDF_file = PDF.files[0];
  PDF_filePath = PDF.value;

  XML = document.getElementById("XML");
  XML_file = XML.files[0];
  XML_filePath = XML.value;

  if (MFInicio != "") {
  $('#MFInicio').css('border','');
  if (MFTermino != "") {
  $('#MFTermino').css('border','');
  if (PDF_filePath != "") {
  $('#PDF').css('border','');
  if (XML_filePath != "") {
  $('#XML').css('border','');

  data.append('idEstacion', idEstacion);
  data.append('MFInicio', MFInicio);
  data.append('MFTermino', MFTermino);
  data.append('PDF_file', PDF_file);
  data.append('XML_file', XML_file);
  data.append('Accion','agregar-estimulo-fiscal');
 
  $.ajax({
  url: url,
  type: 'POST',
  contentType: false,
  data: data,
  processData: false,
  cache: false
  }).done(function(data){


  if(data == 1){
  ListaPagoEstimulo(idEstacion)
  alertify.success('Facturas agregadas exitosamente')
  $('#Modal').modal('hide');
  }else{
  alertify.error('Error al agregar las facturas.')
  
  }

  });

  }else{
  $('#XML').css('border','2px solid #A52525');
  }
  }else{
  $('#PDF').css('border','2px solid #A52525');
  }
  }else{
  $('#MFTermino').css('border','2px solid #A52525');
  }
  }else{
  $('#MFInicio').css('border','2px solid #A52525');
  }
   
  }

  function Eliminar(id,idEstacion){

  var parametros = {
  "idReporte" : id,
  "Accion" : "eliminar-estimulo-fiscal"
  };

  alertify.confirm('',
  function(){

  $.ajax({
  data:  parametros,
  //url:   'public/corte-diario/modelo/eliminar-estimulo-fiscal.php',
  url: 'app/controlador/1-corporativo/controladorEstimuloFiscal.php',
  type:  'post',
  beforeSend: function() {
    
  },
  complete: function(){

  },
  success:  function (response) {

  if (response == 1) {
  ListaPagoEstimulo(idEstacion) 
  alertify.success('Facturas eliminadas exitosamente')
  }else{
  alertify.error('Error al eliminar las facturas')
  }

  }
  });

  },
  function(){

  }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();
  }

  function Editar(id,idEstacion){
  $('#Modal').modal('show'); 
  $('#ContenidoModal').load('app/vistas/personal-general/1-corporativo/estimulo-fiscal/modal-editar-estimulo-fiscal.php?IdReporte=' + id + '&idEstacion=' + idEstacion); 
  }
 
  function EditarPago(IdReporte,idEstacion){

  var EFInicio = $('#EFInicio').val();
  var EFTermino = $('#EFTermino').val();

  var data = new FormData();
  //var url = 'public/corte-diario/modelo/editar-estimulo-fiscal.php';
  var url = 'app/controlador/1-corporativo/controladorEstimuloFiscal.php',
    
  EPDF = document.getElementById("EPDF");
  EPDF_file = EPDF.files[0];
  EPDF_filePath = EPDF.value;

  EXML = document.getElementById("EXML");
  EXML_file = EXML.files[0];
  EXML_filePath = EXML.value;

  CPDF = document.getElementById("CPDF");
  CPDF_file = CPDF.files[0];
  CPDF_filePath = CPDF.value;

  CXML = document.getElementById("CXML");
  CXML_file = CXML.files[0];
  CXML_filePath = CXML.value;

  alertify.confirm('',
  function(){

  data.append('IdReporte', IdReporte);
  data.append('idEstacion', idEstacion);
  data.append('EFInicio', EFInicio);
  data.append('EFTermino', EFTermino);
  data.append('EPDF_file', EPDF_file);
  data.append('EXML_file', EXML_file);
  data.append('CPDF_file', CPDF_file);
  data.append('CXML_file', CXML_file);
  data.append('Accion','editar-estimulo-fiscal');

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
  ListaPagoEstimulo(idEstacion)
  $('#Modal').modal('hide');
  alertify.success('Facturas editadas exitosamente')
  }else{
  alertify.error('Error al editar las facturas')

  }

  });

  },
  function(){
  }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea editar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();
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

  <div class="col-12">

  <div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> Corporativo</a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Estimulo Fiscal (<?=$session_nomestacion ;?>)</li>
  </ol>
  </div>
   
  <div class="row"> 
  <div class="col-9"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Estimulo Fiscal (<?=$session_nomestacion ;?>)</h3> </div>
  
  <div class="col-3">

  <div class="text-end">
  <div class="dropdown d-inline ms-2 <?=$ocultarbtnEn?>">
  <button type="button" class="btn dropdown-toggle btn-primary" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
  <i class="fa-solid fa-screwdriver-wrench"></i></span>
  </button>

  <ul class="dropdown-menu">
  <?php if ($session_nompuesto != "Contabilidad" && $session_nompuesto != "Comercializadora" && $session_nompuesto != "Dirección de operaciones servicio social") { ?>
  <li onclick="btnModal(<?=$Session_IDEstacion;?>)"><a class="dropdown-item pointer">  <i class="fa-solid fa-plus text-dark"></i> Agregar Comprobante</a></li>
  <?php } ?>

  <li onclick="btnModalBuscar(<?=$Session_IDEstacion;?>)"><a class="dropdown-item pointer">  <i class="fa-solid fa-magnifying-glass text-dark"></i> Buscar Reporte</a></li>
  </ul>
  </div>

  </div>

  </div>
  </div>

  <hr>
  </div>

  </div>

  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
  <div id="ListaEstimulo"></div>
  </div>

  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
  <div id="ListaPagoEstimulo"></div>
  </div>


  </div>

  </div>
  </div>
  </div>
  </div>



  <div class="modal" id="Modal">
  <div class="modal-dialog modal-lg">
  <div class="modal-content" >
  <div id="ContenidoModal"></div>
  </div>
  </div>
  </div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>


</body>
</html>