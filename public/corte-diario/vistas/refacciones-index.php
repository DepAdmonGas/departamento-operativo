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
  
 ListaRefacciones();
 
  }); 

  function Regresar(){
   window.history.back();
  } 

  function ListaRefacciones(){
  $('#ListaRefacciones').load('public/corte-diario/vistas/lista-reporte-refacciones.php');
  } 

  function Agregar(){

    $.ajax({
    url:   'public/corte-diario/modelo/crear-reporte-refacciones.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 0) {
     alertify.error('Error al crear el reporte');   
    }else{
    ListaRefacciones()   

    $('#Modal').modal('show');  
    $('#ContenidoModal').load('public/corte-diario/vistas/modal-reporte-refacciones.php?idReporte=' + response);

    }
 
    }
    });
  
  }

function Almacen(){
window.location.href = "refacciones-almacen";   
}
  function GuardarReporte(idReporte){

    var Fecha = $('#Fecha').val();
    var Hora = $('#Hora').val();
    var Dispensario = $('#Dispensario').val();
    var Motivo = $('#Motivo').val();

    if (Fecha != "") {
    $('#Fecha').css('border','');
    if (Hora != "") {
    $('#Hora').css('border','');

    var parametros = {
  "idReporte" : idReporte,
  "Fecha" : Fecha,
  "Hora" : Hora,
  "Dispensario" : Dispensario,
  "Motivo" : Motivo
    };

    $.ajax({
    data:  parametros,
     url:   'public/corte-diario/modelo/finalizar-refaccion-reporte.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    $('#ContenidoModal').load('public/corte-diario/vistas/modal-reporte-refacciones.php?idReporte=' + idReporte);  
    ListaRefacciones()     
    }else if(response == 0){
      alertify.error('Error al crear el reporte');
    }else if(response == 2){
      alertify.warning('No cuenta con suficientes unidades');
    }

    }
    });

    }else{
    $('#Hora').css('border','2px solid #A52525');
    }
    }else{
    $('#Fecha').css('border','2px solid #A52525');
    }

    }

    function AgregarRR(idReporte){

    var Refaccion = $('#Refaccion').val();
    var Unidad = $('#Unidad').val();

    if (Refaccion != "") {
    $('#Refaccion').css('border','');
    if (Unidad != "") {
    $('#Unidad').css('border','');

    var parametros = {
    "idReporte" : idReporte,
    "Refaccion" : Refaccion,
    "Unidad" : Unidad
    };

    $.ajax({
    data:  parametros,
    url:   'public/corte-diario/modelo/agregar-refaccion-reporte.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {    
    $('#ContenidoModal').load('public/corte-diario/vistas/modal-reporte-refacciones.php?idReporte=' + idReporte); 
     alertify.success('Refaccion agregada exitosamente.');  
    }else if(response == 0){
      alertify.error('Error al agregar la refaccion');
    }else if(response == 2){
      alertify.warning('No cuenta con suficientes unidades');
    }

    }
    });

    }else{
    $('#Hora').css('border','2px solid #A52525');
    }
    }else{
    $('#Refaccion').css('border','2px solid #A52525');
    }

    }

    function EliminarRefaccionReporte(idReporte,id,idRefaccion){

    var parametros = {
    "id" : id,
    "idRefaccion" : idRefaccion
    };

   alertify.confirm('',
   function(){

      $.ajax({
    data:  parametros,
    url:   'public/corte-diario/modelo/eliminar-refaccion-reporte.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

 
    if (response == 1) {
    alertify.success('Refaccion eliminada exitosamente.');  
    $('#ContenidoModal').load('public/corte-diario/vistas/modal-reporte-refacciones.php?idReporte=' + idReporte);
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

    }

        function EditarReporte(idReporte){

    $('#Modal').modal('show');  
    $('#ContenidoModal').load('public/corte-diario/vistas/modal-reporte-refacciones.php?idReporte=' + idReporte); 

    } 
 
     function EliminarReporte(id,idRefaccion){

    var parametros = {
    "id" : id,
    "idRefaccion" : idRefaccion
    };


alertify.confirm('',
 function(){

      $.ajax({
    data:  parametros,
    url:   'public/corte-diario/modelo/eliminar-reporte-refaccion.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

 
    if (response == 1) {
    ListaRefacciones();  
     alertify.success('Reporte eliminado exitosamente.');  
    
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

    }

    function ModalDetalleReporte(id,idRefaccion){      
    $('#Modal').modal('show');  
    $('#ContenidoModal').load('public/corte-diario/vistas/modal-detalle-reporte-refaccion.php?idReporte=' + id + '&idRefaccion=' + idRefaccion);
    } 
 
   function Transaccion(){
    window.location.href = "refacciones-transaccion";  
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
    <div class="col-7">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    <div class="row">

     <div class="col-12">

    <h5>Refacciones</h5>

    </div>

    </div>

    </div>


  <div class="col-5">

  <img class="float-end pointer ms-2" src="<?=RUTA_IMG_ICONOS;?>agregar.png"  onclick="Agregar()">
  <img class="float-end pointer ms-2" src="<?=RUTA_IMG_ICONOS;?>almacen-tb.png"  onclick="Almacen()">
  <img class="float-end pointer" src="<?=RUTA_IMG_ICONOS;?>aleatorio.png"  onclick="Transaccion()">

  </div>

  </div>

  <hr>

  
  <div id="ListaRefacciones"></div>
  

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



                      
