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
  $('[data-toggle="tooltip"]').tooltip();

  SelEstacion(<?=$Session_IDEstacion;?>)

    });

  function Regresar(){
  sessionStorage.removeItem('idestacion');
  window.history.back();
  }
 
  function SelEstacion(idEstacion){
  sessionStorage.setItem('idestacion', idEstacion);
  //$('#ContenidoOrganigrama').load('public/recursos-humanos/vistas/contenido-recursos-humanos-estacion-personal.php?idEstacion=' + idEstacion);
  $('#ContenidoOrganigrama').load('public/recursos-humanos/vistas/contenido-recursos-humanos-personal.php?idEstacion=' + idEstacion); 
 
  }
 
  function Mas(idEstacion){
  $('#Modal').modal('show');  
  $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-agregar-personal-estacion.php?idEstacion=' + idEstacion + '&idPersonal=0&Tipo=0');  
  } 

  //---------- AGREGAR PERSONAL V2 ----------
  function AgregarPersonal(idEstacion,idPersonal,Tipo){ 
       
if(Tipo == 0){
 var msg = "agregado"
 var msg2 = "agregar"

 }else{
 var msg = "editado"
 var msg2 = "editar"
 }

 var NoColaborador = $('#NoColaborador').val();
 var NombresCompleto = $('#NombresCompleto').val();
 var Puesto = $('#Puesto').val();
 var FechaIngreso = $('#FechaIngreso').val();

 var R_Personal = $('#R_Personal').val();
 var CV = $('#CV').val();
 var INE = $('#INE').val();
 var A_Nacimiento = $('#A_Nacimiento').val();
 var C_Domicilio = $('#C_Domicilio').val();
 var C_IMSS = $('#C_IMSS').val();
 var C_Recomendacion = $('#C_Recomendacion').val();
 var C_Estudios = $('#C_Estudios').val();
 var CURP = $('#CURP').val(); 
 var A_Infonavit = $('#A_Infonavit').val();
 var RFC = $('#RFC').val();
 var C_Antecedentes = $('#C_Antecedentes').val();

 var Contrato = $('#Contrato').val();
 var sd = $('#sd').val();

 //---------- DOCUMENTACION ----------
 DocumentoPersonal = document.getElementById("R_Personal");
 DocumentoPersonal_file = DocumentoPersonal.files[0];
 DocumentoPersonal_filePath = DocumentoPersonal.value;

 DocumentoCV = document.getElementById("CV");
 DocumentoCV_file = DocumentoCV.files[0];
 DocumentoCV_filePath = DocumentoCV.value;

 DocumentoINE = document.getElementById("INE");
 DocumentoINE_file = DocumentoINE.files[0];
 DocumentoINE_filePath = DocumentoINE.value;

 DocumentoNacimiento = document.getElementById("A_Nacimiento");
 DocumentoNacimiento_file = DocumentoNacimiento.files[0];
 DocumentoNacimiento_filePath = DocumentoNacimiento.value;

 DocumentoDomicilio = document.getElementById("C_Domicilio");
 DocumentoDomicilio_file = DocumentoDomicilio.files[0];
 DocumentoDomicilio_filePath = DocumentoDomicilio.value;

 DocumentoNSS = document.getElementById("C_IMSS");
 DocumentoNSS_file = DocumentoNSS.files[0];
 DocumentoNSS_filePath = DocumentoNSS.value;

 DocumentoRecomendacion = document.getElementById("C_Recomendacion");
 DocumentoRecomendacion_file = DocumentoRecomendacion.files[0];
 DocumentoRecomendacion_filePath = DocumentoRecomendacion.value;

 DocumentoEstudios = document.getElementById("C_Estudios");
 DocumentoEstudios_file = DocumentoEstudios.files[0];
 DocumentoEstudios_filePath = DocumentoEstudios.value;

 DocumentoCURP = document.getElementById("CURP");
 DocumentoCURP_file = DocumentoCURP.files[0];
 DocumentoCURP_filePath = DocumentoCURP.value;

 DocumentoInfonavit = document.getElementById("A_Infonavit");
 DocumentoInfonavit_file = DocumentoInfonavit.files[0];
 DocumentoInfonavit_filePath = DocumentoInfonavit.value;

 DocumentoRFC = document.getElementById("RFC");
 DocumentoRFC_file = DocumentoRFC.files[0];
 DocumentoRFC_filePath = DocumentoRFC.value;

 DocumentoAntecedentes = document.getElementById("C_Antecedentes");
 DocumentoAntecedentes_file = DocumentoAntecedentes.files[0];
 DocumentoAntecedentes_filePath = DocumentoAntecedentes.value;

 DocumentoContrato = document.getElementById("Contrato");
 DocumentoContrato_file = DocumentoContrato.files[0];
 DocumentoContrato_filePath = DocumentoContrato.value;

 var data = new FormData();
 var url = 'public/recursos-humanos/modelo/editar-personal-rh.php';

 if(FechaIngreso != ""){
 $('#FechaIngreso').css('border','');
 if(NombresCompleto != ""){
 $('#NombresCompleto').css('border','');
 if(Puesto != ""){
 $('#Puesto').css('border','');


 data.append('idEstacion', idEstacion);
 data.append('idPersonal', idPersonal); 
 data.append('FechaIngreso', FechaIngreso); 
 data.append('NoColaborador', NoColaborador);
 data.append('NombresCompleto', NombresCompleto);
 data.append('Puesto', Puesto);
 data.append('sd', sd);

 data.append('DocumentoPersonal_file', DocumentoPersonal_file);
 data.append('DocumentoCV_file', DocumentoCV_file);
 data.append('DocumentoINE_file', DocumentoINE_file);
 data.append('DocumentoNacimiento_file', DocumentoNacimiento_file);
 data.append('DocumentoDomicilio_file', DocumentoDomicilio_file);
 data.append('DocumentoNSS_file', DocumentoNSS_file);
 data.append('DocumentoEstudios_file', DocumentoEstudios_file);
 data.append('DocumentoRecomendacion_file', DocumentoRecomendacion_file);
 data.append('DocumentoCURP_file', DocumentoCURP_file);
 data.append('DocumentoInfonavit_file', DocumentoInfonavit_file);
 data.append('DocumentoRFC_file', DocumentoRFC_file);
 data.append('DocumentoAntecedentes_file', DocumentoAntecedentes_file);
 data.append('DocumentoContrato_file', DocumentoContrato_file);

 data.append('Tipo', Tipo);

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
  $('#Modal').modal('hide');  

  if(idEstacion == 9){
  SelEstacion(2);
  
  }else{
  SelEstacion(idEstacion);

  }

   alertify.success('Personal ' + msg + ' exitosamente.');
  }else{
   alertify.error('Error al ' + msg2 + ' personal'); 
  }
   
 }); 


}else{
$('#Puesto').css('border','2px solid #A52525'); 
}
}else{
$('#NombresCompleto').css('border','2px solid #A52525'); 
}
}else{
$('#FechaIngreso').css('border','2px solid #A52525'); 
}


}

  function Documentos(idPersonal){
  $('#Modal').modal('show');  
  $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-documentos-personal-estacion.php?idPersonal=' + idPersonal);  
  }   

  function AgregarDocumento(idPersonal){

  var Documento   = $('#Documento').val();
  var Archivo   = $('#Archivo').val();

  Archivo = document.getElementById("Archivo");
  Archivo_file = Archivo.files[0];
  Archivo_filePath = Archivo.value;

  var data = new FormData();
  var url = 'public/recursos-humanos/modelo/agregar-personal-documentos.php';

  if(Documento != ""){
  $('#Documento').css('border','');
  if(Archivo_filePath != ""){
  $('#Archivo').css('border','');

  data.append('idPersonal', idPersonal);
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
    $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-documentos-personal-estacion.php?idPersonal=' + idPersonal); 
    alertify.success('Documento agregado exitosamente.')

    }else{
    alertify.error('Error al crear'); 
    }
     
    }); 
  
  }else{
  $('#Archivo').css('border','2px solid #A52525'); 
  }
  }else{
  $('#Documento').css('border','2px solid #A52525'); 
  }  


  }

  function Eliminar(Tipo, IdDato, idPersonal){

    if(Tipo == 1){
    $('#Eliminar'+ IdDato).tooltip('hide')
    }else{
    $('#Eliminar'+ IdDato).tooltip('hide')
    }


  var parametros = {
    "Tipo" : Tipo,
    "IdDato": IdDato
    };
 
    $.ajax({
    data:  parametros,
    url:   'public/recursos-humanos/modelo/editar-personal-documentos.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

      if(response == 1){

      $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-documentos-personal-estacion.php?idPersonal=' + idPersonal); 
      alertify.success('Documento eliminado exitosamente.')
      }else{
      alertify.error('Error al eliminar');
      $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-documentos-personal-estacion.php?idPersonal=' + idPersonal); 
      }

    }
    });

  }

  function EliminarPersonal(idEstacion, idPersonal){

    var parametros = {
    "idEstacion" : idEstacion,
    "idPersonal" : idPersonal
    };

alertify.confirm('',
 function(){

    $.ajax({
    data:  parametros,
    url:   'public/recursos-humanos/modelo/eliminar-personal.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
     SelEstacion(idEstacion);  
     alertify.success('Personal eliminado exitosamente.')     
    }else{
     alertify.error('Error al eliminar');  
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

  }

  function Acceso(idPersonal){
  $('#Modal').modal('show');  
  $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-estacion-personal-acceso.php?idPersonal=' + idPersonal);  
  } 
 
  //-----------------------------------------------------

  function EditarPin() {
    var x = document.getElementById("inputEditar");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

function EditPin(idPersonal){

var PinAcceso = $('#PinAcceso').val();

if(PinAcceso != ""){

if(PinAcceso.length >= 5){

alertify.confirm('',
function(){

var parametros = {
"idPersonal" : idPersonal,
"PinAcceso" : PinAcceso
};

$.ajax({
data:  parametros,
url:   'public/recursos-humanos/modelo/agregar-pin-personal.php',
type:  'POST',
beforeSend: function() {
$(".LoaderPage").show();
},

complete: function(){

},

success:  function (response) {

if (response == 1) { 
$('#ContenidoModal').load('public/recursos-humanos/vistas/modal-personal-acceso.php?idPersonal=' + idPersonal); 
$(".LoaderPage").hide();
alertify.success('El PIN fue agregado exitosamente');
}else if (response == 0){
$(".LoaderPage").hide();
alertify.error('El PIN no fue agregado');
}else if (response == 2){
$(".LoaderPage").hide();
$('#PinAcceso').css('border','2px solid #A52525');  
$('#Resultado').html('<div class="text-center text-danger"><small>El PIN ya esta utilizado intente con otro</small></div>');
alertify.error('El PIN no fue agregado');
}
 
}
});

}, 
function(){
}).setHeader('Agregar PIN').set({transition:'zoom',message: '¿Desea agregar el siguiente PIN al personal de la empresa?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

}else{
$('#PinAcceso').css('border','2px solid #A52525');  
$('#Resultado').html('<div class="text-center text-danger"><small>El PIN debe tener mínimo 5 dígitos</small></div>');
}
}else{
$('#PinAcceso').css('border','2px solid #A52525');  
}

}
//-----------------------------------------------------
function Asistencia(idPersonal){
window.location.href = "recursos-humanos-personal-asistencia/" + idPersonal; 
}
//-------------------------------------------------------

function EditarPersonal(idEstacion,idPersonal){
$('#Modal').modal('show');  
  $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-agregar-personal-estacion.php?idEstacion=' + idEstacion + '&idPersonal=' + idPersonal + '&Tipo=1'); 
}


//---------- COMENTARIOS PERSONAL ----------
function ComentariosPersonal(idEstacion,idPersonal){
  $('#Modal').modal('show');  
  $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-comentarios-personal.php?idEstacion=' + idEstacion + '&idPersonal=' + idPersonal);
}
  
function GuardarComentario(idEstacion,idPersonal){

var Comentario = $('#Comentario').val();

var parametros = {
"idPersonal" : idPersonal,
"Comentario" : Comentario
}; 
   
if(Comentario != ""){
$('#Comentario').css('border',''); 
  
$.ajax({
data:  parametros,
url:   'public/recursos-humanos/modelo/agregar-comentario-personal.php', 
type:  'post',
beforeSend: function() {
},
complete: function(){

},
success:  function (response) {

if (response == 1) {

if(idEstacion == 9){
SelEstacion(2);
  
}else{
SelEstacion(idEstacion);

}

$('#Comentario').val('');
$('#ContenidoModal').load('public/recursos-humanos/vistas/modal-comentarios-personal.php?idEstacion=' + idEstacion + '&idPersonal=' + idPersonal);

}else{
 alertify.error('Error al guardar el comentario');  
}

} 
});

}else{
$('#Comentario').css('border','2px solid #A52525'); 
}

}


function Buscar(e,idTipo,idEstacion){
var Buscar = e.value;

var parametros = {
    "Buscar" : Buscar,
    "idTipo" : idTipo,
    "idEstacion" : idEstacion
  };

  $.ajax({
    data:  parametros, 
    url:   'public/recursos-humanos/vistas/lista-personal-buscar.php',
    type:  'post',
    beforeSend: function() {
    }, 
    complete: function(){

    },
    success:  function (response) {
    $('#BuscarPersonal' + idTipo).html(response);
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
    <div class="col-12">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    
    <div class="row">
    <div class="col-12">

     <h5>Recursos humanos (Personal)</h5>
    
    </div>
    </div>

    </div>

<!--
    <div class="col-1">
    <img class="pointer float-end" src="<?=RUTA_IMG_ICONOS;?>agregar.png" onclick="Mas(<?=$Session_IDEstacion;?>)">
    </div>
-->
    </div>

  <hr>

  <div id="ContenidoOrganigrama"></div>


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