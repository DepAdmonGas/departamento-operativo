<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") { 
header("Location:".PORTAL."");
}

function ToSolicitud($idLocalidad,$con){

$sql_lista = "SELECT id FROM op_rh_formatos WHERE id_localidad = '".$idLocalidad."' AND status = 1 ";
$result_lista = mysqli_query($con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);
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

  SelEstacion(<?=$Session_IDEstacion;?>)
   
    });

  function Regresar(){
  window.history.back();
  }
 
  function SelEstacion(idEstacion){
  $('#ContenidoFormatos').load('public/recursos-humanos/vistas/contenido-recursos-humanos-formatos.php?idEstacion=' + idEstacion);
  } 
 
    function Formulario(Formato,idEstacion){
    var parametros = {
    "idEstacion" : idEstacion,
    "Formato" : Formato
    };

    $.ajax({
    data:  parametros,
    url:   'public/recursos-humanos/modelo/agregar-formato.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response != 0) {

   SelEstacion(idEstacion);
   $('#Modal').modal('show');  

    if(Formato == 1){
       $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario1.php?idEstacion=' + idEstacion + '&idReporte=' + response);

    }else if(Formato == 2){ 
      $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario2.php?idEstacion=' + idEstacion + '&idReporte=' + response);

    }else if(Formato == 3){
      $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario3.php?idEstacion=' + idEstacion + '&idReporte=' + response);

    }else if(Formato == 4){
      $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario4.php?idEstacion=' + idEstacion + '&idReporte=' + response);

    }else if(Formato == 5){      
      window.location.href = "recursos-humanos-formatos-vacaciones/" + response; 
    }
    }else{
    alertify.error('Error al crear');  
    }

    }
    });
 
    }

function GuardarPersonal(idEstacion,idReporte){

    var Nombres = $('#Nombres').val();
    var ApellidoP = $('#ApellidoP').val();
    var ApellidoM = $('#ApellidoM').val();
    var Puesto = $('#Puesto').val();
    var SalarioD =$('#SalarioD').val();
    var Detalle = $('#Detalle').val();
    var Documento   = $('#Documento').val();

    Documento = document.getElementById("Documento");
    Documento_file = Documento.files[0];
    Documento_filePath = Documento.value;

    var data = new FormData();
    var url = 'public/recursos-humanos/modelo/agregar-personal-formato1.php';

    if(Nombres != ""){
    $('#Nombres').css('border',''); 
    if(ApellidoP != ""){
    $('#ApellidoP').css('border',''); 
    if(ApellidoM != ""){
    $('#ApellidoM').css('border',''); 
    if(Puesto != ""){
    $('#Puesto').css('border',''); 
    if(SalarioD != ""){
    $('#SalarioD').css('border','');    
    if(Documento_filePath != ""){
    $('#Documento_filePath').css('border',''); 
    if(Detalle != ""){
    $('#Detalle').css('border',''); 

    data.append('idEstacion', idEstacion);
    data.append('idReporte', idReporte);
    data.append('Nombres', Nombres);
    data.append('ApellidoP', ApellidoP);
    data.append('ApellidoM', ApellidoM);
    data.append('Puesto', Puesto);
    data.append('SalarioD', SalarioD);
    data.append('Detalle', Detalle);
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
    $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario1.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte); 
     }else{
      alertify.error('Error al crear'); 
     }
     
    }); 


    }else{
    $('#Detalle').css('border','2px solid #A52525'); 
    }  
    }else{
    $('#Documento').css('border','2px solid #A52525'); 
    }
    }else{
    $('#SalarioD').css('border','2px solid #A52525'); 
    }  
    }else{
    $('#Puesto').css('border','2px solid #A52525'); 
    }
    }else{
    $('#ApellidoM').css('border','2px solid #A52525'); 
    }
    }else{
    $('#ApellidoP').css('border','2px solid #A52525'); 
    }
    }else{
    $('#Nombres').css('border','2px solid #A52525'); 
    }

}
 
function EditFormulario(idEstacion,idReporte,Formato){
$('#Modal').modal('show');  
 
    if(Formato == 1){
       $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario1.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);

    }else if(Formato == 2){
      $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario2.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);

    }else if(Formato == 3){
      $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario3.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);

    }else if(Formato == 4){
      $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario4.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);

    }else if(Formato == 5){
    window.location.href = "recursos-humanos-formatos-vacaciones/" + idReporte; 
    }
}

function Eliminar(idPersonal,idReporte,idEstacion){

    var parametros = {
    "Estado" : 1,
    "idPersonal" : idPersonal,
    "idFormulario" : idReporte
    };

    alertify.confirm('',
  function(){

    $.ajax({
    data:  parametros,
    url:   'public/recursos-humanos/modelo/eliminar-alta-personal.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

      if(response == 1){
      $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario1.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);
      SelEstacion(idEstacion);
      alertify.success('Registro eliminado exitosamente.'); 
      }else{
      alertify.error('Error al eliminar');    
      }

    }
 });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar el personal seleccionado?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

    }



    function Finalizar(idReporte,idEstacion){

    var parametros = {
    "idReporte" : idReporte,
    "idEstacion" : idEstacion
    };

    $.ajax({
    data:  parametros,
    url:   'public/recursos-humanos/modelo/finalizar-formulario.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

      if(response == 1){
       window.location.reload()
      }else{
       alertify.error('Error al finalizar'); 
      }

    }
    });

    }

    function DeleteFormulario(idEstacion,idFormulario){

     alertify.confirm('',
     function(){

    var parametros = {
        "idFormulario" : idFormulario
        };

        $.ajax({
        data:  parametros,
        url:   'public/recursos-humanos/modelo/formulario-alta-eliminar.php',
        type:  'post',
        beforeSend: function() {
        },
        complete: function(){

        },
        success:  function (response) {

          if(response == 1){
          window.location.reload()
          }else{
          alertify.error('Error al eliminar');    
          }

        }
        });
 
     },
     function(){

     }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

    }

    function DetalleFormulario(idFormato,Formato){

    $('#Modal').modal('show');  
    
    if(Formato == 1){
    $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-detalle-formulario1.php?idFormato=' + idFormato);

    }else if(Formato == 2){
     $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-detalle-formulario2.php?idFormato=' + idFormato);

 
    }else if(Formato == 3){
    $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-detalle-formulario3.php?idFormato=' + idFormato);

    }else if(Formato == 4){
    $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-detalle-formulario4.php?idFormato=' + idFormato);

    }else if(Formato == 5){
    $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-detalle-formulario5.php?idFormato=' + idFormato);

    }
    
    }

    function Firmar(idEstacion,idFormato){
    sessionStorage.setItem('idestacion', idEstacion);
    window.location.href = "recursos-humanos-formatos-firma/" + idFormato; 
    }

    function DescargarPDF(idFormato){
    window.location.href = "recursos-humanos-formatos-pdf/" + idFormato;  
    }

  function ModalComentario(id,idEstacion){
  $('#ModalComentario').modal('show');  
  $('#DivContenido').load('public/recursos-humanos/vistas/modal-comentarios-formatos.php?id=' + id + '&idEstacion=' + idEstacion );
  }

 function GuardarComentario(id,idEstacion){

    var Comentario = $('#Comentario').val();

    var parametros = {
    "idFormato" : id,
    "Comentario" : Comentario
    };

    if(Comentario != ""){
    $('#Comentario').css('border',''); 

    $.ajax({
    data:  parametros,
    url:   'public/recursos-humanos/modelo/agregar-comentario-formato.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    $('#Comentario').val('');
    SelEstacion(idEstacion)    
    $('#DivContenido').load('public/recursos-humanos/vistas/modal-comentarios-formatos.php?id=' + id + '&idEstacion=' + idEstacion );
    }else{
     alertify.error('Error al guardar el comentario');  
    }

    }
    });

    }else{
    $('#Comentario').css('border','2px solid #A52525'); 
    }

    }

    //-----------------------------------------------------------------------------------------

    function GuardarRestructuracion(idEstacion,idReporte){
    
    var Empleado = $('#Empleado').val();
    var Estacion = $('#Estacion').val();
    var SalarioD = $('#SalarioD').val();
    var Fecha = $('#Fecha').val();
    var Detalle = $('#Detalle').val();

    var parametros = {
    "idEstacion" : idEstacion,
    "idReporte" : idReporte,
    "Empleado" : Empleado,
    "Estacion" : Estacion,
    "SalarioD" : SalarioD,
    "Fecha" : Fecha,
    "Detalle" : Detalle
    };

    $.ajax({
    data:  parametros,
    url:   'public/recursos-humanos/modelo/agregar-cambio-restructuracion.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if(response == 1){
    $(".LoaderPage").hide();
    $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario2.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);
     }else{
      alertify.error('Error al crear'); 
     }

    }
    });
    }

    function EliminarRestructuracion(id,idReporte,idEstacion){

    var parametros = {
    "id" : id
    };

    $.ajax({
    data:  parametros,
    url:   'public/recursos-humanos/modelo/eliminar-formulario-restructuracion.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

      if(response == 1){
      $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario2.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);
      SelEstacion(idEstacion);
      alertify.success('Registro eliminado exitosamente.'); 
      }else{
      alertify.error('Error al eliminar');    
      }

    }
    });
    }

    function FinalizarRestructuracion(idReporte,idEstacion){

    var parametros = {
    "idReporte" : idReporte,
    "idEstacion" : idEstacion
    };

    $.ajax({
    data:  parametros,
    url:   'public/recursos-humanos/modelo/finalizar-formulario.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

      if(response == 1){
        window.location.reload()
      }else{
       alertify.error('Error al finalizar'); 
      }

    }
    });

    }

    //---------------------------------------------------------------------------------------
function GuardarFalta(idEstacion,idReporte){

    var Empleado = $('#Empleado').val();
    var DiasFalta = $('#DiasFalta').val();
    var Observaciones = $('#Observaciones').val();

    var parametros = {
    "idEstacion" : idEstacion,
    "idReporte" : idReporte,
    "Empleado" : Empleado,
    "DiasFalta" : DiasFalta,
    "Observaciones" : Observaciones
    };

    $.ajax({
    data:  parametros,
    url:   'public/recursos-humanos/modelo/agregar-falta.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if(response == 1){
    $(".LoaderPage").hide();
    $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario3.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);
     }else{
      alertify.error('Error al crear'); 
     }

    }
    }); 
    }


    function EliminarFalta(id,idReporte,idEstacion){

    var parametros = {
    "id" : id
    };

    $.ajax({
    data:  parametros,
    url:   'public/recursos-humanos/modelo/eliminar-formulario-falta.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

      if(response == 1){
      $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario3.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);
      SelEstacion(idEstacion);
      alertify.success('Registro eliminado exitosamente.'); 
      }else{
      alertify.error('Error al eliminar');    
      }

    }
    });
    }

    function FinalizarFalta(idReporte,idEstacion){

    var parametros = {
    "idReporte" : idReporte,
    "idEstacion" : idEstacion
    };

    $.ajax({
    data:  parametros,
    url:   'public/recursos-humanos/modelo/finalizar-formulario.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

      if(response == 1){
        window.location.reload()
      }else{
       alertify.error('Error al finalizar'); 
      }

    }
    });

    }

//---------------------------------------------------------------

function GuardarBaja(idEstacion,idReporte){

    var Empleado = $('#Empleado').val();
    var Baja = $('#Baja').val();

    var parametros = {
    "idEstacion" : idEstacion,
    "idReporte" : idReporte,
    "Empleado" : Empleado,
    "Baja" : Baja
    };

    $.ajax({
    data:  parametros,
    url:   'public/recursos-humanos/modelo/agregar-baja.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if(response == 1){
    $(".LoaderPage").hide();
    $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario4.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);
     }else{
      alertify.error('Error al crear'); 
     }

    }
    }); 
    }

    function EliminarBaja(id,idReporte,idEstacion){

    var parametros = {
    "id" : id
    };

    $.ajax({
    data:  parametros,
    url:   'public/recursos-humanos/modelo/eliminar-formulario-baja.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

      if(response == 1){
      $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-opciones-formulario4.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);
      SelEstacion(idEstacion);
      alertify.success('Registro eliminado exitosamente.'); 
      }else{
      alertify.error('Error al eliminar');    
      }

    }
    });
    }

    function FinalizarBaja(idReporte,idEstacion){

    var parametros = {
    "idReporte" : idReporte,
    "idEstacion" : idEstacion
    };

    $.ajax({
    data:  parametros,
    url:   'public/recursos-humanos/modelo/finalizar-formulario.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

      if(response == 1){
        window.location.reload()
      }else{
       alertify.error('Error al finalizar'); 
      }

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
  <div class="border-0 ">

  <div id="ContenidoFormatos"></div> 

  </div>
  </div>
  </div>

  </div>
  </div>

  </div>


  <div class="modal" id="Modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" style="margin-top: 83px;">
      <div id="ContenidoModal"></div>
      </div>
    </div>
  </div>

    <div class="modal" id="ModalComentario">
    <div class="modal-dialog">
      <div class="modal-content" style="margin-top: 83px;">
      <div id="DivContenido"></div>
      </div>
    </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

</body>
</html>