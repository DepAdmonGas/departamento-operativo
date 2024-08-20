<?php
require('app/help.php');
$ClassRecursosHumanosGeneral->ValAsistencia($Session_IDEstacion,0);

if($Session_IDEstacion == 2){ 
$ClassRecursosHumanosGeneral->ValAsistencia(9,0);
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
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

  <!---------- LIBRERIAS DEL DATATABLE ---------->
  <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">
  <script type="text/javascript" src="<?=RUTA_JS ?>alertify.js"></script> 

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  SelEstacion(<?=$Session_IDEstacion?>);

  if(<?=$Session_IDEstacion?> == 2){
  SelEstacion(9);
  }
  
  }); 
  
  function Regresar(){
  sessionStorage.removeItem('idestacion');
  window.history.back();
  }

  function ConfiguracionBiometrico(valBiometrico){
  if(valBiometrico == 0){
  window.location.href = "recursos-humanos-estacion-configuracion-retardo-horarios-incidencias";
  }  
  }

  function SelEstacion(idEstacion) {
  let referencia, targets;
    
  if(idEstacion == 9){
  referencia = '#ListaAsistenciaAutolavado';
  }else{
  referencia = '#ListaAsistencia';
  }

  targets = [8];
  
  $(referencia).load('app/vistas/contenido/2-recursos-humanos/biometrico/lista-biometrico-estaciones.php?idEstacion=' + idEstacion, function() {
  $('#tabla_biometrico_' + idEstacion).DataTable({
  "language": {
  "url": "<?=RUTA_JS2?>/es-ES.json"
  },
  "order": [[0, "asc"]],
  "lengthMenu": [25, 50, 75, 100],
  "columnDefs": [
  { "orderable": false, "targets": targets },
  { "searchable": false, "targets": targets }
  ]
  });
  });
  
  }


  //---------- MODAL BUSCAR REPORTE ----------
  function ModalReporte(idEstacion){
  $('#ModalIncidencias').modal('show');
  $('#ContenidoModal').load('app/vistas/contenido/2-recursos-humanos/biometrico/modal-buscar-reporte-biometrico.php?idEstacion=' + idEstacion); 
  } 
 
  function btnBuscar(idEstacion){
  
  var Year = $('#Year').val();
  var Mes = $('#Mes').val();

  if(Year != ""){
  $('#Year').css('border','');
  if(Mes != ""){
  $('#Mes').css('border','');

  $('#ModalIncidencias').modal('hide');
  $('#DivBusquedaReporte').load('app/vistas/contenido/2-recursos-humanos/biometrico/lista-reporte-busqueda-biometrico.php?idEstacion=' + idEstacion + '&Year=' + Year + '&Mes=' + Mes);

  if(idEstacion == 2){
  $('#ListaAsistenciaAutolavado').load('app/vistas/contenido/2-recursos-humanos/biometrico/lista-reporte-busqueda-biometrico.php?idEstacion=' + 9 + '&Year=' + Year + '&Mes=' + Mes);
  }


 
  }else{
  $('#Mes').css('border','2px solid #A52525'); 
  }
  }else{
  $('#Year').css('border','2px solid #A52525'); 
  }

  }

  function SelEstacionReturn(idEstacion){
  sessionStorage.setItem('idestacion', idEstacion);
  SelEstacion(idEstacion)

  if(idEstacion == 2){
  SelEstacion(9)

  }

  }

  function ModalDetalleI(idPersonal,id,idEstacion){
  $('#ModalIncidencias').modal('show');
  $('#ContenidoModal').load('app/vistas/contenido/2-recursos-humanos/biometrico/modal-detalle-incidencias-asistencia.php?idAsistencia=' + id);  
  }  
 

  function ModalIncidencias(idPersonal,id,idEstacion){
  $('#ModalIncidencias').modal('show');
  $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-agregar-incidencias.php?idAsistencia=' + id + '&idPersonal=' + idPersonal + '&idEstacion=' + idEstacion); 
  }
 
  function GuardarIncidencia(idAsistencia,idPersonal,idEstacion){
  var Comentario = $('#Comentario').val();

  if(document.querySelector('input[name="CheckBox"]:checked')) {
  var incidencia = document.querySelector('input[name="CheckBox"]:checked').value;
  $('#bordercheck').css('border','');
  if(Comentario != ""){
  $('#Comentario').css('border','');

alertify.confirm('',
function(){

var parametros = {
"idAsistencia" : idAsistencia,
"incidencia" : incidencia,
"Comentario" : Comentario
};

$.ajax({
data:  parametros,
url:   'public/recursos-humanos/modelo/agregar-incidencia.php',
type:  'POST',
        
beforeSend: function() {
$(".LoaderPage").show();
},

complete: function(){
},

success:  function (response) {

if(response == 1){
$(".LoaderPage").hide();
$('#ModalIncidencias').modal('hide'); 
alertify.success('Se creo la incidencia');
SelEstacion(idEstacion)
}else{
$(".LoaderPage").hide();
alertify.error('Error al crear la incidencia');
}
 
}
});

},
function(){
}).setHeader('Agregar Incidencia').set({transition:'zoom',message: '¿Desea agregar la incidencia?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

}else{
$('#Comentario').css('border','2px solid #A52525');    
}
}else{
$('#bordercheck').css('border','2px solid #A52525'); 
}

}
 
function EditarSaldoTMR(idAsistencia,idPersonal,idEstacion){

var SueldoDiaTMR = $('#SueldoDiaTMR').val();

if(SueldoDiaTMR != ""){
$('#SueldoDiaTMR').css('border','');

alertify.confirm('',
function(){

var parametros = {
"idAsistencia" : idAsistencia,
"SueldoDiaTMR" : SueldoDiaTMR
};

$.ajax({
data:  parametros,
url:   'public/recursos-humanos/modelo/editar-sueldo-incidencia.php',
type:  'POST',
        
beforeSend: function() {
},
complete: function(){
},
success:  function (response) {

if(response == 1){

alertify.success('Se edito la incidencia');
$('#ContenidoModal').load('public/recursos-humanos/vistas/modal-agregar-incidencias.php?idAsistencia=' + idAsistencia + '&idPersonal=' + idPersonal + '&idEstacion=' + idEstacion); 


}else{
$(".LoaderPage").hide();
alertify.error('Error al editar la incidencia');
}
 
}
});

},
function(){
}).setHeader('Editar sueldo').set({transition:'zoom',message: '¿Desea editar el sueldo del día?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

}else{
$('#SueldoDiaTMR').css('border','2px solid #A52525'); 
}

}

function GuardarDoc(idAsistencia,idPersonal,idEstacion){
var data = new FormData();
var url = 'public/recursos-humanos/modelo/agregar-documento-incidencia.php';

var FechaInicio = $('#FechaIni').val();
var FechaFin = $('#FechaFin').val();
var SueldoDiaI = $('#SueldoDiaI').val();

var Documento = document.getElementById("Documento");
var Documento_file = Documento.files[0];
var Documento_filePath = Documento.value;
var Documento_ext = $("#Documento").val().split('.').pop();

if(Documento_ext == "pdf"){
if(FechaInicio < FechaFin){
$('#FechaFin').css('border',''); 

data.append('Documento_file', Documento_file);
data.append('idPersonal', idPersonal);
data.append('idAsistencia', idAsistencia);
data.append('idEstacion', idEstacion); 
data.append('FechaInicio', FechaInicio);
data.append('FechaFin', FechaFin);
data.append('SueldoDiaI', SueldoDiaI);

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
alertify.success('Se agrego el documento');
$('#ContenidoModal').load('public/recursos-humanos/vistas/modal-agregar-incidencias.php?idAsistencia=' + idAsistencia + '&idPersonal=' + idPersonal + '&idEstacion=' + idEstacion); 
SelEstacion(idEstacion)
 
}else{
alertify.error('Error al agregar el documento');
}
 
});

}else{
$('#FechaFin').css('border','2px solid #A52525'); 
}
}else{
alertify.error('El formato debe ser PDF');
}


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
  <div class="col-12" id="ListaAsistencia"></div> 
  <div class="col-12" id="ListaAsistenciaAutolavado"></div> 
  </div>
  </div>
  </div>

  <!---------- MODAL ----------> 
  <div class="modal fade" id="ModalIncidencias" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  <div class="modal-content" id="ContenidoModal">
  </div>
  </div>
  </div>

  <!---------- MODAL COVID (RIGHT)---------->  
  <div class="modal right fade" id="ModalIncidenciasR" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
  <div class="modal-content" id="ContenidoModalR"></div>
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