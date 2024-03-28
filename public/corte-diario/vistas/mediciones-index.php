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


  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  
  ListaMedicion();
  });

  function ListaMedicion(){
 $('#DivContenido').load('public/corte-diario/vistas/lista-mediciones.php');
  }
 
  function Regresar(){
   window.history.back(); 
  }

function Modal(){
$('#Modal').modal('show');
}

function Guardar(){

var Fecha = $('#Fecha').val();
var Factura = $('#Factura').val();
var Neto = $('#Neto').val();
var Bruto = $('#Bruto').val();
var CuentaLitros = $('#CuentaLitros').val();
var Proveedor = $('#Proveedor').val();

if (Fecha != "") {
$('#Fecha').css('border','');
if (Factura != "") {
$('#Factura').css('border','');
if (Neto != "") {
$('#Neto').css('border','');
if (Bruto != "") {
$('#Bruto').css('border','');
if (CuentaLitros != "") {
$('#CuentaLitros').css('border','');
if (Proveedor != "") {
$('#Proveedor').css('border','');

  var parametros = {
"Fecha" : Fecha,
"Factura" : Factura,
"Neto" : Neto,
"Bruto" : Bruto,
"CuentaLitros" : CuentaLitros,
"Proveedor" : Proveedor
    };


       $.ajax({
     data:  parametros,
     url:   'public/corte-diario/modelo/agregar-mediciones.php',
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

   $('#Factura').val('');
$('#Neto').val('');
$('#Bruto').val('');
$('#CuentaLitros').val('');
$('#Proveedor').val('');

alertify.success('Registro agregado exitosamente.')

ListaMedicion();
   

    }else if (response == 0){
    alertify.error('Error al agregar')
    $(".LoaderPage").hide();
    }else if (response == 2){
    alertify.error('Error al agregar')
    $('#Fecha').css('border','2px solid #A52525');
    $(".LoaderPage").hide();
    }

     }
     });

}else{
$('#Proveedor').css('border','2px solid #A52525');
}
}else{
$('#CuentaLitros').css('border','2px solid #A52525');
}
}else{
$('#Bruto').css('border','2px solid #A52525');
}
}else{
$('#Neto').css('border','2px solid #A52525');
}
}else{
$('#Factura').css('border','2px solid #A52525');
}
}else{
$('#Fecha').css('border','2px solid #A52525');
}

}

function Eliminar(id){

    var parametros = {
    "id" : id
    };


alertify.confirm('',
  function(){



  $.ajax({
     data:  parametros,
     url:   'public/corte-diario/modelo/eliminar-mediciones.php',
     type:  'post',
     beforeSend: function() {
    $(".LoaderPage").show();
     },
     complete: function(){
    
     },
     success:  function (response) {

    if (response == 1) {

    $(".LoaderPage").hide();

ListaMedicion();   
alertify.success('Registro eliminado exitosamente.')


    }else if (response == 0){
    alertify.error('Error al agregar')
    $(".LoaderPage").hide();
    }

     }
   });

  },
  function(){
  }).setHeader('Eliminar medición').set({transition:'zoom',message: '¿Desea eliminar el la medición seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

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

    <div class="col-11">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
   
    <div class="row">
    <div class="col-12"> <h5>Mediciones</h5> </div>
    </div>

    </div>

    <div class="col-1">
    <img class="float-end pointer" src="<?=RUTA_IMG_ICONOS;?>agregar.png" onclick="Modal()">
    </div>

    </div>

  <hr>


  <div id="DivContenido"></div>


  </div>
  </div>
  </div>

  </div>
  </div>

  </div>




<div class="modal" id="Modal">
  <div class="modal-dialog">
    <div class="modal-content" style="margin-top: 83px;">
      <div class="modal-header">
        <h5 class="modal-title">Nuevo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <div class="mb-1"><small>* Fecha</small></div>
      <input type="date" class="mb-2 form-control" id="Fecha" value="<?=$fecha_del_dia;?>">

      <div class="mb-1"><small>* Factura</small></div>
      <input type="text" class="mb-2 form-control" id="Factura">

      <div class="mb-1"><small>* Neto</small></div>
      <input type="number" step="any" class="mb-2 form-control" id="Neto">

      <div class="mb-1"><small>* Bruto</small></div>
      <input type="number" step="any" class="mb-2 form-control" id="Bruto">

      <div class="mb-1"><small>* Cuenta litros</small></div>
      <input type="number" step="any" class="mb-2 form-control" id="CuentaLitros">
      
      <div class="mb-1"><small>* Proveedor</small></div>
      <select class="form-select" id="Proveedor">
        <option></option>
        <option>Pemex</option>
        <option>Delivery</option>
        <option>Pick Up</option>
      </select>
        

      </div>

      <div class="modal-footer">
    <button type="button" class="btn btn-primary" onclick="Guardar()">Guardar</button>
     </div>

    </div>
  </div>
</div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>
