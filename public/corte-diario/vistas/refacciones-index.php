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
  ListaRefacciones();
 
  }); 


  function ListaRefacciones() {
  let referencia, targets;
  targets = [5, 6, 7];

  $('#ListaRefacciones').load('public/corte-diario/vistas/lista-reporte-refacciones.php', function() {
  $('#tabla_refacciones').DataTable({
  "language": {
  "url": "<?=RUTA_JS2?>/es-ES.json"
  },
  "order": [[0, "desc"]],
  "lengthMenu": [25, 50, 75, 100],
  "columnDefs": [
  { "orderable": false, "targets": targets },
  { "searchable": false, "targets": targets }
  ]
  });
  });
  
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
    alertify.success('Reporte actualizado exitosamente.');     
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

    function ModalDetalleReporte(id){      
    $('#Modal').modal('show');  
    $('#ContenidoModal').load('public/corte-diario/vistas/modal-detalle-reporte-refaccion.php?idReporte=' + id);
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

  <div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> Almacén</a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Refacciones</li>
  </ol>
  </div>
 
  <div class="row"> 
  <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Refacciones</h3> </div>
  <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">  

  <div class="text-end">
  <div class="dropdown d-inline ms-2 <?=$ocultarbtn?>">
  <button type="button" class="btn dropdown-toggle btn-primary" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
  <i class="fa-solid fa-screwdriver-wrench"></i></span>
  </button>

  <ul class="dropdown-menu">
  <li onclick="Agregar()"><a class="dropdown-item pointer"> <i class="fa-solid fa-plus"></i> Agregar Refacción</a></li>
  <li onclick="Almacen()"><a class="dropdown-item pointer"> <i class="fa-solid fa-toolbox"></i> Refacciones en Almacén</a></li>
  <li onclick="Transaccion()"><a class="dropdown-item pointer"> <i class="fa-solid fa-shuffle"></i> Transacción de Refacciones</a></li>
  </ul>
  </div>
  </div>

  </div>
  </div>
  
  <hr>
  </div>

  <div class="col-12" id="ListaRefacciones"></div>

  </div>
  </div>
  </div>
  </div>


  <!---------- MODAL ----------> 
  <div class="modal fade" id="Modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  <div class="modal-content" id="ContenidoModal">
  </div>
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



                      
