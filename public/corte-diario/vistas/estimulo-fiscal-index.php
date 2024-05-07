<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

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
 
  <style media="screen">
  .grayscale {
      filter: opacity(50%); 
  }
  </style>

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
   $('#ListaEstimulo').load('public/corte-diario/vistas/lista-estimulo-fiscal.php?idEstacion=' + idestacion + '&FechaInicio=' + fechainicio + '&FechaTermino=' + fechatermino);
  }

  function ListaPagoEstimulo(idestacion){
  $('#ListaPagoEstimulo').load('public/corte-diario/vistas/lista-pago-estimulo-fiscal.php?idEstacion=' + idestacion);
  } 

  function BuscarReporte(idestacion){

  var fechainicio = $('#FInicio').val();
  var fechatermino = $('#FTermino').val();

  $('#ListaEstimulo').load('public/corte-diario/vistas/lista-estimulo-fiscal.php?idEstacion=' + idestacion + '&FechaInicio=' + fechainicio + '&FechaTermino=' + fechatermino);  
  }

  function btnModal(idEstacion){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('public/corte-diario/vistas/modal-agregar-estimulo-fiscal.php?idEstacion=' + idEstacion); 
  } 

  function Guardar(idEstacion){

  var MFInicio = $('#MFInicio').val();
  var MFTermino = $('#MFTermino').val();

  var data = new FormData();
  var url = 'public/corte-diario/modelo/agregar-estimulo-fiscal.php';
  
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
    "idReporte" : id
    };


alertify.confirm('',
 function(){

      $.ajax({
    data:  parametros,
    url:   'public/corte-diario/modelo/eliminar-estimulo-fiscal.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    ListaPagoEstimulo(idEstacion) 
    alertify.success('Facturas eliminadas exitosamente')

    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();
  }

  function Editar(id,idEstacion,FInicio,FTermino){
  $('#Modal').modal('show'); 
  $('#ContenidoModal').load('public/corte-diario/vistas/modal-editar-estimulo-fiscal.php?idEstacion=' + idEstacion + 
    '&IdReporte=' + id   + '&FechaInicio=' + FInicio + '&FechaTermino=' + FTermino); 
  }

  function EditarPago(idEstacion,IdReporte){

  var EFInicio = $('#EFInicio').val();
  var EFTermino = $('#EFTermino').val();

  var data = new FormData();
  var url = 'public/corte-diario/modelo/editar-estimulo-fiscal.php';
  
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

    data.append('idEstacion', idEstacion);
    data.append('IdReporte', IdReporte);
    data.append('EFInicio', EFInicio);
    data.append('EFTermino', EFTermino);
    data.append('EPDF_file', EPDF_file);
    data.append('EXML_file', EXML_file);
    data.append('CPDF_file', CPDF_file);
    data.append('CXML_file', CXML_file);

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
        $('#Modal').modal('hide');
         alertify.success('Facturas editadas exitosamente')
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

  <div class="col-12 mb-3">
  <div class="cardAG">
  <div class="border-0 p-3">

    <div class="row">
    <div class="col-12">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    
    <div class="row">
    <div class="col-12">

     <h5>Estimulo Fiscal (<?=$session_nomestacion ;?>)</h5>
    
    </div>
    </div>

    </div>
    </div>

  <hr>  

   
  <div class="row"> 

  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
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
  </div>

  </div>



  <div class="modal" id="Modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" style="margin-top: 83px;">
      <div id="ContenidoModal"></div>
      </div>
    </div>
  </div>



  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>


</body>
</html>