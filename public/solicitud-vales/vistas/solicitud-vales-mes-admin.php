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
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

  <!---------- LIBRERIAS DEL DATATABLE ---------->
  <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">
  <script type="text/javascript" src="<?=RUTA_JS ?>alertify.js"></script> 


  <script type="text/javascript">
 
  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  ListaVales(<?=$Session_IDEstacion;?>,<?=$session_idpuesto;?>,<?=$GET_year;?>,<?=$GET_mes;?>)
  });

  function Regresar(){
  window.history.back();
  }


  function ListaVales(idEstacion, depu, year, mes){
  let targets;
    
  targets = [7, 8];

  $('#ListaVales').load('../../public/solicitud-vales/vistas/lista-solicitud-vales-mes-admin.php?year=' + year + '&mes=' + mes + '&idEstacion=' + idEstacion + '&depu=' + depu, function() {
  $('#tabla_vales_' + idEstacion).DataTable({
  "language": {
  "url": "<?=RUTA_JS2?>/es-ES.json"
  },
  "order": [[0, "DESC"]],
  "lengthMenu": [15, 30, 75, 100],
  "columnDefs": [
  { "orderable": false, "targets": targets },
  { "searchable": false, "targets": targets }
  ]
  });
  });
  
  }



  function Mas(idEstacion,depu,year,mes){
  window.location.href = "../../solicitud-vales-nuevo/" + year + "/" + mes + "/" + idEstacion + "/" + depu; 
  }
 
   function ModalDetalle(id){
    $('#Modal').modal('show');  
    $('#DivContenido').load('../../app/vistas/personal-general/1-corporativo/solicitud-vales/modal-detalle-solicitud-vale.php?idReporte=' + id);

    }

    function DescargarPDF(idReporte){
    window.location.href = "../../solicitud-vales-pdf/" + idReporte;
    }
    //--------------------------------------------------------------

     function ModalArchivos(year,mes,idEstacion,depu,id){
    $('#ModalComentario').modal('show');  
    $('#DivContenidoComentario').load('../../app/vistas/personal-general/1-corporativo/solicitud-vales/modal-archivos-solicitud-vale.php?idReporte=' + id + '&year=' + year + '&mes=' + mes + '&idEstacion=' + idEstacion + '&depu=' + depu);
  } 



  function AgregarArchivo(year,mes,idEstacion,depu,id){

  var Documento = $('#Documento').val();
  var data = new FormData();
  //var url = '../../public/solicitud-vales/modelo/agregar-archivo-solicitud-vale.php';
  var url = '../../app/controlador/1-corporativo/controladorSolicitudVale.php',

  Archivo = document.getElementById("Archivo");
  Archivo_file = Archivo.files[0];
  Archivo_filePath = Archivo.value;

  if(Documento != ""){ 
  $('#Documento').css('border','');
  if(Archivo_filePath != ""){
  $('#Archivo').css('border','');

  data.append('idReporte', id);
  data.append('Documento', Documento);
  data.append('Archivo_file', Archivo_file);
  data.append('Accion','agregar-archivo-solicitud-vale');

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
  ModalArchivos(year,mes,idEstacion,depu,id);
  ListaVales(idEstacion,depu,year,mes); 
  alertify.success('Archivo agregado exitosamente.')

  }else{
  $(".LoaderPage").hide();
  alertify.error('Error al guardar archivo'); 
  }
    
  });      

  }else{
  $('#Archivo').css('border','2px solid #A52525'); 
  }
  }else{
  $('#Documento').css('border','2px solid #A52525'); 
  }

  }




  function EliminarArchivo(year,mes,idEstacion,depu,idReporte,id){
  var parametros = {
  "id" : id
  };


alertify.confirm('',
 function(){

    $.ajax({
    data:  parametros,
    url:   '../../public/solicitud-vales/modelo/eliminar-documento-solicitud-vale.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
      ModalArchivos(year,mes,idEstacion,depu,id);
     ListaVales(idEstacion, depu, year, mes);
      
    alertify.success('Archivo eliminado exitosamente.');  
   
    }else{
     alertify.error('Error al eliminar el archivo');  
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

    }

    //-----------------------------------

    function Editar(year,mes,idEstacion,idReporte){
 window.location.href = "../../solicitud-vales-editar/" + year + "/" + mes + "/" + idEstacion + "/" + idReporte;  
 }

 function Firmar(year,mes,idEstacion,idReporte){
 window.location.href = "../../solicitud-vales-firmar/" + idReporte;  
 }

 //------------------------------------------------------
  //------------------------------------------------------
   function ModalComentario(year,mes,idEstacion,depu,id){
   $('#ModalComentario').modal('show');  
   $('#DivContenidoComentario').load('../../app/vistas/personal-general/1-corporativo/solicitud-vales/modal-comentarios-solicitud-vale.php?idReporte=' + id + '&year=' + year + '&mes=' + mes + '&depu=' + depu + '&idEstacion=' + idEstacion);
  }

     function GuardarComentario(year,mes,idestacion,depu,idReporte){

    var Comentario = $('#Comentario').val();

    var parametros = {
    "idReporte" : idReporte,
    "Comentario" : Comentario
    };

    if(Comentario != ""){
    $('#Comentario').css('border',''); 

    $.ajax({
    data:  parametros,
    url:   '../../public/solicitud-vales/modelo/agregar-comentario-solicitud-vale.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    $('#Comentario').val('');
    ListaVales(idestacion,depu,year,mes);     
    
    $('#DivContenidoComentario').load('../../app/vistas/personal-general/1-corporativo/solicitud-vales/modal-comentarios-solicitud-vale.php?idReporte=' + idReporte + '&year=' + year + '&mes=' + mes + '&depu=' + depu + '&idEstacion=' + idestacion);
  }else{
     alertify.error('Error al eliminar la solicitud');  
    }

    }
    });

    }else{
    $('#Comentario').css('border','2px solid #A52525'); 
    }

    }
  //------------------------------------------------------
  //------------------------------------------------------

  function Eliminar(year,mes,idestacion,depu,idReporte){

    var parametros = {
    "idReporte" : idReporte
    };


  alertify.confirm('',
   function(){

      $.ajax({
    data:  parametros,
    url:   '../../public/solicitud-vales/modelo/eliminar-solicitud-vale.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    ListaVales(idestacion,depu,year,mes); 
     alertify.success('Solicitud eliminada exitosamente.');      
    }else{
     alertify.error('Error al eliminar la solicitud');  
    }

    }
    });
 
   },
   function(){

   }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();
  
 }
 //---------------------------------------------

 function ModalBuscar(idEstacion,depu,year,mes){
 $('#ModalComentario').modal('show');
 $('#DivContenidoComentario').load('../../public/solicitud-vales/vistas/modal-buscar-solicitud-vale.php?year=' + year + '&mes=' + mes + '&idEstacion=' + idEstacion + '&depu=' + depu);
 }

 function Buscar(idEstacion,depu,year,mes){

  const BuscarSolicitante = $('#BuscarSolicitante').val();
  let procesado
  procesado = BuscarSolicitante.replace(/\s+/g, '_')

  $('#ListaVales').load('../../public/solicitud-vales/vistas/lista-solicitud-vales-mes-admin.php?year=' + year + '&mes=' + mes + '&idEstacion=' + idEstacion + '&depu=' + depu);
  $('#ModalComentario').modal('hide');
  }

  window.addEventListener('pageshow', function(event) {
  if (event.persisted) {
  // Si la página está en la caché del navegador, recargarla
  window.location.reload();
  }
  });

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
 
  <div class="col-12" id="ListaVales"></div>

  </div>
  </div>
  </div>

  </div>
  </div>

  </div>

  <!---------- MODAL (RIGHT)---------->  
  <div class="modal right fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
  <div class="modal-content" id="DivContenido"></div>
  </div>
  </div>

  <!---------- MODAL (CENTER) ----------> 
  <div class="modal fade" id="ModalComentario" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  <div class="modal-content" id="DivContenidoComentario">
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
