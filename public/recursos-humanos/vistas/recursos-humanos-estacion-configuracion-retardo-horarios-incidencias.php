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
 <!---------- LIBRERIAS DEL DATATABLE ---------->
 <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");

  SelEstacion(<?=$Session_IDEstacion;?>)

  });

  function Regresar(){
  window.history.back();
  }

  //------------------------------------------------
  function SelEstacion(idEstacion){
  sessionStorage.setItem('idestacion', idEstacion);
  //$('#Contenido').load('public/recursos-humanos/vistas/contenido-recursos-humanos-estacion-retardo-horarios-incidencias.php?idEstacion=' + idEstacion);
  let targets;
      targets = [4,5];
      $('#Contenido').load('public/recursos-humanos/vistas/contenido-recursos-humanos-retardo-horarios-incidencias.php?idEstacion=' + idEstacion, function () {
        $('#tabla-principal').DataTable({
          "stateSave": true,
          "language": {
            "url": '<?= RUTA_JS2 ?>' + "/es-ES.json"
          },
          "order": [[0, "desc"]],
          "lengthMenu": [15, 30, 50, 100],
          "columnDefs": [
            { "orderable": false, "targets": targets },
            { "searchable": false, "targets": targets }
          ]
        });
      });
  
  //$('#Contenido').load('public/recursos-humanos/vistas/contenido-recursos-humanos-retardo-horarios-incidencias.php?idEstacion=' + idEstacion);

  }  
  //------------------------------------------------

function Actualizar(idEstacion){
var Retardo = $('#Retardo').val();
var Incidencia  = $('#Incidencia').val();

if(Retardo != ""){
$('#Retardo').css('border','');
alertify.confirm('',
function(){

var parametros = {
"idEstacion" : idEstacion,
"Retardo" : Retardo,
"Incidencia" : Incidencia
};

$.ajax({
data:  parametros,
url:   'public/recursos-humanos/modelo/agregar-retardo-horario.php',
type:  'POST',
beforeSend: function() {
$(".LoaderPage").show();
},

complete: function(){

},

success:  function (response) {

if (response == 1) { 
$(".LoaderPage").hide();
alertify.success('Se actualizo el correctamente');
}else if (response == 0){
$(".LoaderPage").hide();
alertify.success('Error al actualizar');
}
 
}
});

},
function(){
}).setHeader('Actualizar').set({transition:'zoom',message: '¿Desea actualizar la información?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

}else{
$('#Retardo').css('border','2px solid #A52525');  
}

}
  function ModalAgregar(idEstacion){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-horarios.php?idEstacion=' + idEstacion + '&Tipo=0&idHorario=0');  
  }
 
  function Horario(idEstacion,idHorario,Tipo){
 
    if(Tipo == 0){
    Mensaje = "¿Desea agregar el siguiente horario?";
    Respuesta1 = "Horario agregado exitosamente";
    Respuesta2 = "Error al agregar";
    }else if(Tipo == 1){
    Mensaje = "¿Desea editar el siguiente horario?";
    Respuesta1 = "Horario actualizado exitosamente";
    Respuesta2 = "Error al actualizar";
    }

  var Titulo = $('#Titulo').val();
  var HoraEntrada  = $('#HoraEntrada').val();
  var HoraSalida  = $('#HoraSalida').val();

  if(Titulo != ""){
  $('#Titulo').css('border','');
  if(HoraEntrada != ""){
  $('#HoraEntrada').css('border','');
  if(HoraSalida != ""){
  $('#HoraSalida').css('border','');

  alertify.confirm('',
  function(){

  var parametros = {
  "idEstacion" : idEstacion,
  "idHorario" : idHorario,
  "Tipo" : Tipo,
  "Titulo" : Titulo,
  "HoraEntrada" : HoraEntrada,
  "HoraSalida" : HoraSalida
  };

  $.ajax({
  data:  parametros,
  url:   'public/recursos-humanos/modelo/agregar-editar-horario.php',
  type:  'POST',
  beforeSend: function() {
  $(".LoaderPage").show();
  },

  complete: function(){

  },

  success:  function (response) {

  if (response == 1) { 
  SelEstacion(idEstacion)
  $(".LoaderPage").hide();
  $('#Modal').modal('hide');
  alertify.success(Respuesta1);
  }else if (response == 0){
  $(".LoaderPage").hide();
  alertify.success(Respuesta2);
  }
   
  }
  });

  },
  function(){
  }).setHeader('Mensaje').set({transition:'zoom',message: Mensaje,labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

  }else{
  $('#HoraSalida').css('border','2px solid #A52525');  
  }
  }else{
  $('#HoraEntrada').css('border','2px solid #A52525');  
  }
  }else{
  $('#Titulo').css('border','2px solid #A52525');  
  }

  }

  function editarHorario(idEstacion,idHorario){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-horarios.php?idEstacion=' + idEstacion + '&Tipo=1&idHorario=' + idHorario);  
  }

  function eliminarHorario(idEstacion,idHorario){

    var parametros = {
    "idHorario" : idHorario
    };

alertify.confirm('',
 function(){

    $.ajax({
    data:  parametros,
    url:   'public/recursos-humanos/modelo/eliminar-horario.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    SelEstacion(idEstacion)
    alertify.success('Horario eliminado exitosamente');  
    }else{
     alertify.error('Error al eliminar');  
    }

    }
    });

   },
   function(){

   }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();
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
  <div class="col-12" id="Contenido"></div> 
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
    <script
      src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.js"></script>

</body>
</html>