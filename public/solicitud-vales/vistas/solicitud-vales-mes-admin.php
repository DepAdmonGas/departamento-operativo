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
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
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
  ListaVales(<?=$Session_IDEstacion;?>,<?=$session_idpuesto;?>,<?=$GET_year;?>,<?=$GET_mes;?>,'DESC','','','','','')
  });

  function Regresar(){
  window.history.back();
  }

  function ListaVales(idEstacion, depu, year, mes, orderFolio, orderFecha, orderCuenta, orderMonto, orderSolicitante,buscarSolicitante){
  $('#ListaVales').load('../../public/solicitud-vales/vistas/lista-solicitud-vales-mes-admin.php?year=' + year + '&mes=' + mes + '&idEstacion=' + idEstacion + '&depu=' + depu + '&orderFolio=' + orderFolio + '&orderFecha=' + orderFecha + '&orderCuenta=' + orderCuenta + '&orderMonto=' + orderMonto + '&orderSolicitante=' + orderSolicitante + '&buscarSolicitante=' + buscarSolicitante);
  }

  function Mas(idEstacion,depu,year,mes){
  window.location.href = "../../solicitud-vales-nuevo/" + year + "/" + mes + "/" + idEstacion + "/" + depu; 
  }

   function ModalDetalle(id){
    $('#Modal').modal('show');  
    $('#DivContenido').load('../../public/solicitud-vales/vistas/modal-detalle-solicitud-vale.php?idReporte=' + id);
    }

    function DescargarPDF(idReporte){
    window.location.href = "../../solicitud-vales-pdf/" + idReporte;
    }
    //--------------------------------------------------------------

     function ModalArchivos(year,mes,idEstacion,depu,id,orderFolio, orderFecha, orderCuenta, orderMonto, orderSolicitante,buscarSolicitante){
      $('#ModalComentario').modal('show');  
    $('#DivContenidoComentario').load('../../public/solicitud-vales/vistas/modal-archivos-solicitud-vale.php?idReporte=' + id + '&year=' + year + '&mes=' + mes + '&idEstacion=' + idEstacion + '&depu=' + depu + '&orderFolio=' + orderFolio + '&orderFecha=' + orderFecha + '&orderCuenta=' + orderCuenta + '&orderMonto=' + orderMonto + '&orderSolicitante=' + orderSolicitante + '&buscarSolicitante=' + buscarSolicitante);
    } 

    function AgregarArchivo(year,mes,idEstacion,depu,id,orderFolio,orderFecha,orderCuenta,orderMonto,orderSolicitante,BuscarSolicitante){

    var Documento = $('#Documento').val();
    var data = new FormData();
    var url = '../../public/solicitud-vales/modelo/agregar-archivo-solicitud-vale.php';

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
      ModalArchivos(year,mes,idEstacion,depu,id,orderFolio, orderFecha, orderCuenta, orderMonto, orderSolicitante,BuscarSolicitante);
     ListaVales(idEstacion, depu, year, mes, orderFolio, orderFecha, orderCuenta, orderMonto, orderSolicitante,BuscarSolicitante);
      
      alertify.success('Archivo agregado exitosamente.')
     }else{
      $(".LoaderPage").hide();
      alertify.error('Error al guardar archivo'); 
     }
     
    });      

    }else{
    $('#Archivo').css('border','2px solid #A52525'); 
    }
    }else{
    $('#Documento').css('border','2px solid #A52525'); 
    }

    }

        function EliminarArchivo(year,mes,idEstacion,depu,idReporte,id,orderFolio, orderFecha, orderCuenta, orderMonto, orderSolicitante,BuscarSolicitante){

    var parametros = {
    "id" : id
    };


alertify.confirm('',
 function(){

    $.ajax({
    data:  parametros,
    url:   '../../public/solicitud-vales/modelo/eliminar-documento-solicitud-vale.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    ModalArchivos(year,mes,idEstacion,depu,idReporte,orderFolio, orderFecha, orderCuenta, orderMonto, orderSolicitante,BuscarSolicitante);
    ListaVales(idEstacion,depu,year,mes,orderFolio, orderFecha, orderCuenta, orderMonto, orderSolicitante,BuscarSolicitante); 
    
    alertify.success('Archivo eliminado exitosamente.');  
   
    }else{
     alertify.error('Error al eliminar el archivo');  
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

    }

    //-----------------------------------

    function Editar(year,mes,idEstacion,idReporte){
 window.location.href = "../../solicitud-vales-editar/" + year + "/" + mes + "/" + idEstacion + "/" + idReporte;  
 }

 function Firmar(year,mes,idEstacion,idReporte){
 window.location.href = "../../solicitud-vales-firmar/" + idReporte;  
 }

 //------------------------------------------------------
  //------------------------------------------------------
   function ModalComentario(year,mes,idEstacion,depu,id,orderFolio, orderFecha, orderCuenta, orderMonto, orderSolicitante,BuscarSolicitante){
   $('#ModalComentario').modal('show');  
    $('#DivContenidoComentario').load('../../public/solicitud-vales/vistas/modal-comentarios-solicitud-vale.php?idReporte=' + id + '&year=' + year + '&mes=' + mes + '&depu=' + depu + '&idEstacion=' + idEstacion + '&orderFolio=' + orderFolio + '&orderFecha=' + orderFecha + '&orderCuenta=' + orderCuenta + '&orderMonto=' + orderMonto + '&orderSolicitante=' + orderSolicitante + '&buscarSolicitante=' + BuscarSolicitante);
    }

     function GuardarComentario(year,mes,idestacion,depu,idReporte,orderFolio, orderFecha, orderCuenta, orderMonto, orderSolicitante,BuscarSolicitante){

    var Comentario = $('#Comentario').val();

    var parametros = {
    "idReporte" : idReporte,
    "Comentario" : Comentario
    };

    if(Comentario != ""){
    $('#Comentario').css('border',''); 

    $.ajax({
    data:  parametros,
    url:   '../../public/solicitud-vales/modelo/agregar-comentario-solicitud-vale.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    $('#Comentario').val('');
    ListaVales(idestacion,depu,year,mes,orderFolio, orderFecha, orderCuenta, orderMonto, orderSolicitante,BuscarSolicitante);     
    
    $('#DivContenidoComentario').load('../../public/solicitud-vales/vistas/modal-comentarios-solicitud-vale.php?idReporte=' + idReporte + '&year=' + year + '&mes=' + mes + '&idEstacion=' + idestacion + '&orderFolio=' + orderFolio + '&orderFecha=' + orderFecha + '&orderCuenta=' + orderCuenta + '&orderMonto=' + orderMonto + '&orderSolicitante=' + orderSolicitante + '&buscarSolicitante=' + BuscarSolicitante);
    }else{
     alertify.error('Error al eliminar la solicitud');  
    }

    }
    });

    }else{
    $('#Comentario').css('border','2px solid #A52525'); 
    }

    }
  //------------------------------------------------------
  //------------------------------------------------------

  function Eliminar(year,mes,idestacion,depu,idReporte){

    var parametros = {
    "idReporte" : idReporte
    };


  alertify.confirm('',
   function(){

      $.ajax({
    data:  parametros,
    url:   '../../public/solicitud-vales/modelo/eliminar-solicitud-vale.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    ListaVales(idestacion,depu,year,mes); 
     alertify.success('Solicitud eliminada exitosamente.');      
    }else{
     alertify.error('Error al eliminar la solicitud');  
    }

    }
    });
 
   },
   function(){

   }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();
  
 }
 //---------------------------------------------

 function ModalBuscar(idEstacion,depu,year,mes,orderFolio,orderFecha,orderCuenta,orderMonto,orderSolicitante){
 $('#ModalComentario').modal('show');
 $('#DivContenidoComentario').load('../../public/solicitud-vales/vistas/modal-buscar-solicitud-vale.php?year=' + year + '&mes=' + mes + '&idEstacion=' + idEstacion + '&depu=' + depu + '&orderFolio=' + orderFolio + '&orderFecha=' + orderFecha + '&orderCuenta=' + orderCuenta + '&orderMonto=' + orderMonto + '&orderSolicitante=' + orderSolicitante);
 }

 function Buscar(idEstacion,depu,year,mes,orderFolio,orderFecha,orderCuenta,orderMonto,orderSolicitante){

const BuscarSolicitante = $('#BuscarSolicitante').val();
let procesado
procesado = BuscarSolicitante.replace(/\s+/g, '_')

 $('#ListaVales').load('../../public/solicitud-vales/vistas/lista-solicitud-vales-mes-admin.php?year=' + year + '&mes=' + mes + '&idEstacion=' + idEstacion + '&depu=' + depu + '&orderFolio=' + orderFolio + '&orderFecha=' + orderFecha + '&orderCuenta=' + orderCuenta + '&orderMonto=' + orderMonto + '&orderSolicitante=' + orderSolicitante + '&buscarSolicitante=' + procesado);

$('#ModalComentario').modal('hide');
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
 


  <div id="ListaVales"></div>


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
