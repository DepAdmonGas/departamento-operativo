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
  $('[data-toggle="tooltip"]').tooltip();
  
  SelEstacion(<?=$GET_year;?>,<?=$GET_mes;?>);

  });

  function Regresar(){
   window.history.back();
  } 
 
  function SelEstacion(year,mes){
    $('#ListaSolicitudes').load('../../public/corte-diario/vistas/lista-solicitud-cheques-mes.php?year=' + year + '&mes=' + mes);
  }

  function Mas(year,mes){
  window.location.href = "../../solicitud-cheque-crear/" + year + "/" + mes; 
  } 

   function ModalDetalle(id){
    $('#Modal').modal('show');  
    $('#DivContenido').load('../../public/corte-diario/vistas/modal-detalle-solicitud-cheque.php?idReporte=' + id);
   
 }  

  function Editar(idReporte){
 window.location.href = "../../solicitud-cheque-editar/" + idReporte;  
 }

  function Eliminar(year,mes,idReporte){

      var parametros = {
    "idReporte" : idReporte
    };


alertify.confirm('',
 function(){

      $.ajax({
    data:  parametros,
    url:   '../../public/corte-diario/modelo/eliminar-solicitud-cheque.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    SelEstacion(year,mes);
    alertify.success('Solicitud eliminada exitosamente'); 
    }else{
     alertify.error('Error al eliminar la solicitud');  
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();
  
 }


 function ModalComentario(year,mes,id){
   $('#ModalComentario').modal('show');  
    $('#DivContenidoComentario').load('../../public/corte-diario/vistas/modal-comentarios-solicitud-cheque.php?idReporte=' + id + '&year=' + year + '&mes=' + mes );
 }

 function GuardarComentario(year,mes,idReporte){

    var Comentario = $('#Comentario').val();

    var parametros = {
    "idReporte" : idReporte,
    "Comentario" : Comentario
    };

    if(Comentario != ""){
    $('#Comentario').css('border',''); 

    $.ajax({
    data:  parametros,
    url:   '../../public/corte-diario/modelo/agregar-comentario-solicitud-cheque.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    $('#Comentario').val('');
    SelEstacion(year,mes);     
    $('#DivContenidoComentario').load('../../public/corte-diario/vistas/modal-comentarios-solicitud-cheque.php?idReporte=' + idReporte + '&year=' + year + '&mes=' + mes);
    }else{
     alertify.error('Error al eliminar la solicitud');  
    }

    }
    });

    }else{
    $('#Comentario').css('border','2px solid #A52525'); 
    }

    }

    function DescargarPDF(idReporte){

    window.location.href = "../../solicitud-cheque-pdf/" + idReporte;  

    }

    function Pago(year,mes,id){
    $('#ModalComentario').modal('show');  
    $('#DivContenidoComentario').load('../../public/corte-diario/vistas/modal-pagos-solicitud-cheque.php?idReporte=' + id + '&year=' + year + '&mes=' + mes); 
    }

    function AgregarPago(year,mes,id){

    var data = new FormData();
    var url = '../../public/corte-diario/modelo/agregar-pago-solicitud-cheque.php';

    Documento = document.getElementById("Documento");
    Documento_file = Documento.files[0];
    Documento_filePath = Documento.value;

    if(Documento_filePath != ""){
    $('#Documento').css('border','');

    data.append('idReporte', id);
    data.append('Documento_file', Documento_file);

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
      $('#DivContenidoComentario').load('../../public/corte-diario/vistas/modal-pagos-solicitud-cheque.php?idReporte=' + id + '&year=' + year + '&mes=' + mes);
      SelEstacion(year,mes)
     }else{
      $(".LoaderPage").hide();
      alertify.error('Error al guardar pago'); 
     }
     
    });      

    }else{
    $('#Documento').css('border','2px solid #A52525'); 
    }

    }

    //---------------------------------------------------------------------

    function Firmar(year,mes,idReporte){
    window.location.href = "../../solicitud-cheque-firmar/" + idReporte;  
    }

    function ModalArchivos(year,mes,id){
      $('#ModalComentario').modal('show');  
    $('#DivContenidoComentario').load('../../public/corte-diario/vistas/modal-archivos-solicitud-cheque.php?idReporte=' + id + '&year=' + year + '&mes=' + mes );
    }
 
    function AgregarArchivo(year,mes,id){

    var Documento = $('#Documento').val();
    var data = new FormData();
    var url = '../../public/corte-diario/modelo/agregar-archivo-solicitud-cheque.php';

    Archivo = document.getElementById("Archivo");
    Archivo_file = Archivo.files[0];
    Archivo_filePath = Archivo.value;

    if(Documento != ""){
    $('#Documento').css('border','');
    if(Archivo_filePath != ""){
    $('#Archivo').css('border','');

    data.append('idReporte', id);
    data.append('Documento', Documento);
    data.append('Archivo_file', Archivo_file);

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
      alertify.success('Archivo agregado exitosamente')
      SelEstacion(year,mes)
      $('#DivContenidoComentario').load('../../public/corte-diario/vistas/modal-archivos-solicitud-cheque.php?idReporte=' + id + '&year=' + year + '&mes=' + mes );
     }else{
      $(".LoaderPage").hide();
      alertify.error('Error al guardar pago'); 
     }
     
    });      

    }else{
    $('#Archivo').css('border','2px solid #A52525'); 
    }
    }else{
    $('#Documento').css('border','2px solid #A52525'); 
    }

    }

    function EliminarArchivo(year,mes,idReporte,id){

    var parametros = {
    "id" : id
    };


alertify.confirm('',
 function(){

    $.ajax({
    data:  parametros,
    url:   '../../public/corte-diario/modelo/eliminar-documento-solicitud-cheque.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    SelEstacion(year,mes)
    $('#DivContenidoComentario').load('../../public/corte-diario/vistas/modal-archivos-solicitud-cheque.php?idReporte=' + idReporte + '&year=' + year + '&mes=' + mes );
    alertify.success('Archivo eliminado exitosamente')
    }else{
     alertify.error('Error al eliminar el archivo');  
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

    }
    //-----------------------------------------------------------------------------------
    function FacTelcel(idEstacion,year,mes){
    $('#Modal').modal('show');  
    $('#DivContenido').load('../../public/corte-diario/vistas/modal-telcel-solicitud-cheque.php?idEstacion=' + idEstacion + '&year=' + year + '&mes=' + mes);   
    }

    function EditarTelcel(idEstacion,year,mes,id){
    $('#DivContenido').load('../../public/corte-diario/vistas/modal-editar-telcel-solicitud-cheque.php?idEstacion=' + idEstacion + '&year=' + year + '&mes=' + mes + '&id=' + id); 
    }

    function CancelarTelcel(idEstacion,year,mes){
   $('#DivContenido').load('../../public/corte-diario/vistas/modal-telcel-solicitud-cheque.php?idEstacion=' + idEstacion + '&year=' + year + '&mes=' + mes); 
  }

  function EditarTelcelInfo(idEstacion,year,mes,id){

    var data = new FormData();
    var url = '../../public/corte-diario/modelo/editar-factura-telcel-solicitud-cheque.php';

    Pago = document.getElementById("Pago");
    Pago_file = Pago.files[0];
    Pago_filePath = Pago.value;

    data.append('id', id);
    data.append('Pago_file', Pago_file);

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
      $('#DivContenido').load('../../public/corte-diario/vistas/modal-telcel-solicitud-cheque.php?idEstacion=' + idEstacion + '&year=' + year + '&mes=' + mes);  
      alertify.success('Comprobante editado exitosamente'); 
     }else{
      $(".LoaderPage").hide();
      alertify.error('Error al editar'); 
     }
     
    });      

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
    <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    
    <div class="row">
    <div class="col-12">
    <h5>Solicitud de cheques, <?=nombremes($GET_mes);?> <?=$GET_year;?></h5>
    </div>
    </div>

    </div>

    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
    <?php if ($session_nompuesto != "Contabilidad" && $session_nompuesto != "Comercializadora" && $session_nompuesto != "Dirección de operaciones servicio social") { ?>
    <img class="pointer float-end ms-2" onclick="Mas(<?=$GET_year;?>,<?=$GET_mes;?>)" src="<?=RUTA_IMG_ICONOS;?>agregar.png">
    <?php } ?>

    <?php if($Session_IDEstacion == 6 || $Session_IDEstacion == 7){ ?>
    <img class="pointer float-end ms-2" width="24px" onclick="FacTelcel(<?=$Session_IDEstacion;?>,<?=$GET_year;?>,<?=$GET_mes;?>)" src="<?=RUTA_IMG_ICONOS;?>telefono.png">
    <?php } ?>

    </div>


    </div>

  <hr>

  <div id="ListaSolicitudes"></div>
  
  </div>
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

    <div class="modal" id="ModalComentario">
    <div class="modal-dialog">
      <div class="modal-content" style="margin-top: 83px;">
      <div id="DivContenidoComentario"></div>
      </div>
    </div>
  </div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

</body>
</html>