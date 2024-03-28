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
  <link rel="shortcut icon" href="<?php echo RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="apple-touch-icon" href="<?php echo RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="stylesheet" href="<?php echo RUTA_CSS ?>alertify.css">
  <link rel="stylesheet" href="<?php echo RUTA_CSS ?>themes/default.rtl.css">
  <link href="<?php echo RUTA_CSS ?>bootstrap.css" rel="stylesheet" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?php echo RUTA_JS ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  <style media="screen">
  .LoaderPage {
  position: fixed;
  left: 0px;
  top: 0px;
  width: 100%;
  height: 100%;
  z-index: 9999;
  background: url('../imgs/iconos/load-img.gif') 50% 50% no-repeat rgb(249,249,249);
  }
  </style>
  <script type="text/javascript">
  
  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  $('[data-toggle="tooltip"]').tooltip();
  ListaFecha(<?=$GET_idYear;?>,<?=$GET_idMes;?>);

  });

  function Regresar(){
   window.history.back();
  }

  function Mas(year,mes){
  
    $.ajax({    
     url:   '../../../public/admin/modelo/agregar-formato-precios.php',
     type:  'post',
     beforeSend: function() {
    
     },
     complete: function(){
    
     },
     success:  function (response) {

      if(response != 0){

       $('#Modal').modal('show');
       $('#DivPrecios').load('../../../public/admin/vistas/modal-formato-precios.php?Id=' + response + '&year=' + year + '&mes=' + mes + '&action=1'); 
      }

     } 
     });

  } 

  function ListaFecha(year,mes){
  $('#ListaFecha').load('../../../public/admin/vistas/lista-formato-precios.php?year=' + year + '&mes=' + mes);
  }  

  function Detalle(strtotime){
  window.location.href = "precio-combustible/" + strtotime;
  }

  function Cancelar(Id,year,mes){

    var parametros = {
    "idReporte" : Id
    };
 

    alertify.confirm('',
  function(){

       $.ajax({
     data:  parametros,
     url:   '../../../public/admin/modelo/eliminar-formato-precios.php',
     type:  'post',
     beforeSend: function() {
    $(".LoaderPage").show();
     },
     complete: function(){
    
     },
     success:  function (response) {

    if (response == 1) {

    $(".LoaderPage").hide();
    $('#Modal').modal('hide');
    ListaFecha(year,mes);

    }else{
    alertify.error('Error al eliminar')
    $(".LoaderPage").hide();

    }

     }
 });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

    }





function EditPrecio(e,id,num){

var valor = e.value;

var parametros = {
    "valor" : valor,
    "id" : id,
    "num" : num
    };

    $.ajax({
     data:  parametros,
     url:   '../../../public/admin/modelo/editar-formato-precios.php',
     type:  'post',
     beforeSend: function() {
     },
     complete: function(){
    
     },
     success:  function (response) {

    if (response == 1) {


    }else{
    alertify.error('Error al editar')

    }

     }
     });

}

function Guardar(IdPrecio,year,mes){

var Fecha = $('#Fecha').val();

if(Fecha != ""){
$('#Fecha').css('border','');

var parametros = {
    "id" : IdPrecio,
    "valor" : Fecha,
    "num" : 8
    };

    $.ajax({
     data:  parametros,
     url:   '../../../public/admin/modelo/editar-formato-precios.php',
     type:  'post',
     beforeSend: function() {
     },
     complete: function(){
    
     },
     success:  function (response) {

    if (response == 1) {
    $('#Modal').modal('hide');
    ListaFecha(year,mes)

    }else{
    alertify.error('Error al guardar')

    }

     }
     });


}else{
$('#Fecha').css('border','2px solid #A52525');
}

}

function Editar(id,year,mes){
  
   $('#Modal').modal('show');
       $('#DivPrecios').load('../../../public/admin/vistas/modal-formato-precios.php?Id=' + id + '&year=' + year + '&mes=' + mes+ '&action=2'); 

  }

  function Detalle(id){
window.location.href = "../../formato-precios-detalle/" + id;
  }

  </script>
  </head>
  <body>
<div class="LoaderPage"></div>

<div class="p-4">
   <div class="card">
  <div class="card-body">
    


    <div class="row">

    <div class="col-xl-11 col-lg-11 col-md-11 col-sm-12">

    <img class="float-left" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    <div class="row">

     <div class="col-12">

      <h5>Formato de precios</h5>

    </div>

    </div>

    </div>


    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12">
    <img class="float-right" onclick="Mas(<?=$GET_idYear;?>,<?=$GET_idMes;?>)" src="<?=RUTA_IMG_ICONOS;?>mas.png" data-toggle="tooltip" data-placement="top" title="Nuevo">
    </div>

    </div>

<hr> 

<div id="ListaFecha"></div>

  
</div>
</div>
</div>

<div class="modal" id="Modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div id="DivPrecios"></div>
  
    </div>
  </div>
</div>


  <script src="<?php echo RUTA_JS ?>bootstrap.min.js"></script>
  </body>
  </html>
