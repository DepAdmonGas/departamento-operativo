<?php
require 'app/vistas/contenido/header.php';

?>
 

 <!---------- LIBRERIAS DEL DATATABLE ---------->
 <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">

  <script type="text/javascript">

  $(document).ready(function ($) {
  $(".LoaderPage").fadeOut("slow");
  SelEstacion(<?=$Session_IDEstacion;?>) 

  });
 


  function SelEstacion(idEstacion) {
  let targets;
    
  targets = [4, 5, 6];

  $('#ContenidoFormatos').load('app/vistas/contenido/2-recursos-humanos/formatos/lista-formatos.php?idEstacion=' + idEstacion, function() {
  $('#tabla_formatos_' + idEstacion).DataTable({
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


    //---------- AGREGAR FORMATOS ----------
    function Formulario(Formato,idEstacion){

var parametros = {
"idEstacion" : idEstacion,
"Formato" : Formato,
"accion": "agregar-formulario"
};

$.ajax({
data:  parametros,
url: 'app/controlador/2-recursos-humanos/controladorFormatos.php',
type:  'post',
beforeSend: function() {
  
},
complete: function(){

},
success:  function (response) {

if (response != 0) {

if(Formato == 1){
window.location.href = "recursos-humanos-formulario-alta-personal/" + idEstacion + '/' + response; 

}else if(Formato == 2){
window.location.href = "recursos-humanos-formulario-baja-personal/" + idEstacion + '/' + response; 

}else if(Formato == 3){
window.location.href = "recursos-humanos-formulario-falta-personal/" + idEstacion + '/' + response; 

}else if(Formato == 4){
window.location.href = "recursos-humanos-formulario-reestructuracion-personal/" + idEstacion + '/' + response; 

}else if(Formato == 5){
window.location.href = "recursos-humanos-formulario-ajuste-salarial/" + idEstacion + '/' + response; 

}else if(Formato == 6){
window.location.href = "recursos-humanos-formulario-vacaciones-personal/" + idEstacion + '/' + response; 

}else if(Formato == 7){
window.location.href = "recursos-humanos-formulario-prima-vacacional/" + idEstacion + '/' + response; 

}

}else{
alertify.error('Error al crear formato');  
}

}
}); 

}


//---------- EDITAR FORMATOS ----------
function EditFormulario(idEstacion,idReporte,Formato){

if(Formato == 1){  
window.location.href = "recursos-humanos-formulario-alta-personal/" + idEstacion + '/' + idReporte; 

}else if(Formato == 2){
window.location.href = "recursos-humanos-formulario-baja-personal/" + idEstacion + '/' + idReporte; 

}else if(Formato == 3){
window.location.href = "recursos-humanos-formulario-falta-personal/" + idEstacion + '/' + idReporte; 

}else if(Formato == 4){
window.location.href = "recursos-humanos-formulario-reestructuracion-personal/" + idEstacion + '/' + idReporte; 

}else if(Formato == 5){
window.location.href = "recursos-humanos-formulario-ajuste-salarial/" + idEstacion + '/' + idReporte; 

}else if(Formato == 6){
window.location.href = "recursos-humanos-formulario-vacaciones-personal/" + idEstacion + '/' + idReporte; 

}else if(Formato == 7){
window.location.href = "recursos-humanos-formulario-prima-vacacional/" + idEstacion + '/' + idReporte; 

}

}

  
  function DescargarPDF(idReporte,idFormato){
  window.location.href = 'app/vistas/contenido/2-recursos-humanos/formatos/pdf-formatos.php?idReporte=' + idReporte + '&idFormato=' + idFormato;
  }
 
  //---------- FIRMAR FORMATOS ----------
  function Firmar(idEstacion,idFormato){
  window.location.href = "recursos-humanos-formatos-firma/" + idFormato; 
  }

 //---------- COMENTARIOS FORMATOS ----------
 function ModalComentario(idReporte,idEstacion){
  $('#Modal').modal('show');  
  $('#ContenidoModal').load('app/vistas/contenido/2-recursos-humanos/formatos/modal-comentario-formatos.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte); 
  } 

  
  function GuardarComentario(idReporte,idEstacion){
  var Comentario = $('#Comentario').val();

  var parametros = {
  "idFormato" : idReporte,
  "idUsuario" : <?=$Session_IDUsuarioBD?>,
  "Comentario" : Comentario,
  "accion" : "agregar-comentario-formatos"
  }; 
    
  if(Comentario != ""){
  $('#Comentario').css('border',''); 

  $.ajax({
  data:  parametros,
  //url:   'public/recursos-humanos/modelo/agregar-comentario-personal.php', 
  url:   'app/controlador/2-recursos-humanos/controladorFormatos.php', 
  type:  'post',
  beforeSend: function() {

  },
  complete: function(){  

  },
  success:  function (response) {

  if (response == 1) {
  SelEstacion(idEstacion)
  alertify.success('Comentario agregado exitosamente');
  $('#Comentario').val('');
  $('#ContenidoModal').load('app/vistas/contenido/2-recursos-humanos/formatos/modal-comentario-formatos.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte); 

  }else{
  alertify.error('Error al guardar el comentario');  
  }

  } 
  });

  }else{
  $('#Comentario').css('border','2px solid #A52525'); 
  }

  }

  
  //---------- ELIMINAR FORMULARIO ----------
  function DeleteFormulario(idReporte,idEstacion){
    
    alertify.confirm('',
    function(){
  
    var parametros = {
    "idReporte" : idReporte,
    "accion" : "eliminar-formato"
    };
  
    $.ajax({ 
    data:  parametros,
    url:    'app/controlador/2-recursos-humanos/controladorFormatos.php',
    type:  'post',
    beforeSend: function() {
          
    },
    complete: function(){
  
    }, 
    success:  function (response) {
      console.log(response)
  
    if(response == 1){ 
    SelEstacion(idEstacion)
    alertify.success('Formato eliminado exitosamente.');   
    
    }else{
    alertify.error('Error al eliminar el formato');    
    }
  
    }
    });
    },
    function(){
  
    }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar el formato seleccionado?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();
    
    }
  

  //---------- DETALLE FORMATOS ----------
  function DetalleFormulario(idReporte,idFormato){
  $('#Modal2').modal('show');  
  $('#ContenidoModal2').load('app/vistas/contenido/2-recursos-humanos/formatos/modal-detalle-formatos.php?idReporte=' + idReporte + '&idFormato=' + idFormato); 
  } 


</script>
</head>

<body>

  <div class="LoaderPage"></div>


  <!---------- DIV - CONTENIDO ---------->
  <div id="content">
  <!---------- NAV BAR - PRINCIPAL (TOP) ---------->
  <?php include_once "public/navbar/navbar-perfil.php"; ?>
  <!---------- CONTENIDO PAGINA WEB---------->
  <div class="contendAG">
  
  <div class="row">
  <div class="col-12" id="ContenidoFormatos">
  </div>
  </div>

  </div>

  </div>

  <div class="modal" id="Modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
  <div class="modal-content">
  <div id="ContenidoModal"></div>
  </div>
  </div>
  </div>

  <!---------- MODAL RIGHT ----------> 
  <div class="modal right fade" id="Modal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
  <div class="modal-content" id="ContenidoModal2"></div>
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