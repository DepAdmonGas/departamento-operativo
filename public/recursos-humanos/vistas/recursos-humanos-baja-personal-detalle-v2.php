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
  .decorado:hover {
  text-decoration: none;
  }
 
  .grayscale{
    opacity: 50%;
  }
  </style>

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  SelBajaPersonal(<?=$GET_idBaja?>)
  }); 
 
  function Regresar(){
  window.history.back();
  }
 
  function SelBajaPersonal(idBaja){
  $('#ListaBaja').load('../public/recursos-humanos/vistas/lista-detalle-baja-personal.php?idBaja=' + idBaja);

  }

  // ---------- EDITAR BAJA (MODAL) ----------
  function EditarProceso(idBaja, idEstacion){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('../public/recursos-humanos/vistas/modal-editar-proceso-baja.php?idBaja=' + idBaja + '&idEstacion=' + idEstacion);

  }   

  function EditarProcesoPersonal(idBaja,idEstacion){

var Proceso = $('#Proceso').val();
var Status = $('#Status').val();

var parametros = {
"idBaja" : idBaja,
"Proceso" : Proceso,
"Status" : Status
};

if(Proceso != ""){
$('#Proceso').css('border',''); 

$.ajax({
data:  parametros,
url:   '../public/recursos-humanos/modelo/editar-proceso-baja-personal.php',
type:  'post',
beforeSend: function() {
},
complete: function(){

},
success:  function (response) {
  console.log(response);

if (response == 1) {

  $('#Proceso').val('');
  SelBajaPersonal(idBaja)
  $('#Modal').modal('hide');
  alertify.success('Proceso de baja editado exitosamente');

}else{
 alertify.error('Error al editar el proceso de baja');  
}

} 
});

}else{
$('#Proceso').css('border','2px solid #A52525'); 
}


}

  // ---------- DETALLE DE BAJA (MODAL) ----------
  function ArchivosBaja(idBaja,idEstacion){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('../public/recursos-humanos/vistas/modal-archivos-baja-personal-v2.php?idBaja=' + idBaja + "&idEstacion=" + idEstacion);
  }

 
  function subirArchivoBaja(idBaja,idEstacion){

var DescripcionArchivo   = $('#DescripcionArchivo').val();
var ArchivoInput   = $('#Archivo').val();

Archivo = document.getElementById("Archivo");
Archivo_file = Archivo.files[0];
Archivo_filePath = Archivo.value;

var data = new FormData();
var url = '../public/recursos-humanos/modelo/agregar-archivo-baja-personal.php';

if(DescripcionArchivo != ""){
$('#DescripcionArchivo').css('border','');
if(Archivo_filePath != ""){
$('#Archivo').css('border','');

data.append('idBaja', idBaja);
data.append('DescripcionArchivo', DescripcionArchivo);
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
  SelBajaPersonal(idBaja)
  $('#Modal').modal('hide');
  alertify.success('Archivo agregado exitosamente.');
  }else{
  alertify.error('Error al agregar el archivo'); 
  }
   
  }); 


}else{
$('#Archivo').css('border','2px solid #A52525'); 
}
}else{
$('#DescripcionArchivo').css('border','2px solid #A52525'); 
}

}



function eliminarArchivoBaja(idArchivo,idBaja,idEstacion){
   
   alertify.confirm('',
    function(){

   var parametros = {
   "idArchivo" : idArchivo
   };

   $.ajax({
   data:  parametros,
   url:   '../public/recursos-humanos/modelo/eliminar-archivo-baja-personal.php',
   type:  'post',
   beforeSend: function() {
   },
   complete: function(){

   },
   success:  function (response) {

     if(response == 1){
    SelBajaPersonal(idBaja)
      alertify.success('Registro eliminado exitosamente.');  
     }else{
     alertify.error('Error al eliminar');    
     }

   }
   });

    },
    function(){

    }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar lel archivo seleccionado?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();


 } 


   // ---------- COMENTARIOS BAJA (MODAL) ----------
   function ComentarioBaja(idBaja,idEstacion){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('../public/recursos-humanos/vistas/modal-comentarios-baja-personal.php?idBaja=' + idBaja + "&idEstacion=" + idEstacion);
  }

function GuardarComentario(idBaja,idEstacion){

var Comentario = $('#Comentario').val();

var parametros = {
"idBaja" : idBaja,
"Comentario" : Comentario
};

if(Comentario != ""){
$('#Comentario').css('border',''); 

$.ajax({
data:  parametros, 
url:   '../public/recursos-humanos/modelo/agregar-comentario-baja-personal.php',
type:  'post',
beforeSend: function() {
},
complete: function(){

},
success:  function (response) {

if (response == 1) {
$('#Comentario').val('');
SelBajaPersonal(idBaja)
$('#ContenidoModal').load('../public/recursos-humanos/vistas/modal-comentarios-baja-personal.php?idBaja=' + idBaja + "&idEstacion=" + idEstacion);

}else{
 alertify.error('Error al agregar el comentario');  
}

} 
});

}else{
$('#Comentario').css('border','2px solid #A52525'); 
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

  <div class="col-12 mb-3">
  <div class="cardAG">



  <div class="row">  
  
  <div class="col-12 mb-3">
  <div id="ListaBaja" class="cardAG"></div>
  </div> 

  </div>

  </div>

  </div>
  </div>

  </div>


    <div class="modal" id="Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin-top: 83px;">
    <div class="modal-content border-0 rounded-0">
    <div id="ContenidoModal"></div>
    </div>
    </div>
    </div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>
