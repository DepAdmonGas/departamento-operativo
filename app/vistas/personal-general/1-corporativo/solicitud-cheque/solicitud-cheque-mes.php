  <?php
  require('app/help.php');
  $breadcrumbYearMes = $ClassHomeCorporativo->tituloMenuCorporativoYearMes($Pagina,$Session_IDUsuarioBD,$session_idpuesto,$GET_year,$GET_mes);
  
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
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" ></script>
  <link rel="stylesheet" href="<?php echo RUTA_CSS ?>selectize.css">
  <!---------- LIBRERIAS DEL DATATABLE ---------->
  <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">
  <script type="text/javascript" src="<?=RUTA_JS ?>alertify.js"></script> 

  <script type="text/javascript">
 
  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  $('[data-toggle="tooltip"]').tooltip();
  
  SelEstacion(<?=$GET_year;?>,<?=$GET_mes;?>);

  }); 

  function SelEstacion(year,mes) {
    
  let nombrePuesto = "<?=$session_nompuesto?>";
  let idUsuario = "<?=$Session_IDUsuarioBD?>";

  let targets = []; // Variable para almacenar los targets dinámicos

  if (nombrePuesto == "Gestoria") {
  
  if(idUsuario == 30){
  targets = [9, 10, 11]; // Asigna los targets para el caso de "Gestoria"

  }else{
  targets = [9, 10]; // Asigna los targets para el caso de "Gestoria"
  }

  }else{
  targets = [10, 11]; // Asigna los targets para el caso por defecto
  
  } 

  $('#ListaSolicitudes').load('../../app/vistas/personal-general/1-corporativo/solicitud-cheque/lista-solicitud-cheques-mes.php?year=' + year + '&mes=' + mes, function() {
  // Una vez que se carguen los datos en la tabla, inicializa DataTables
  $('#tabla_solicitud_cheque').DataTable({
    "language": { // Corrección de "lenguage" a "language"
    "url": "<?=RUTA_JS2?>/es-ES.json" // Corrección de la ruta del archivo de idioma
    },
    "order": [[0, "desc"]],  // Ordenar por la tercera columna de forma descendente
    "lengthMenu": [15,30,50,100], // Número de registros que se mostrarán
    "columnDefs": [
    { "orderable": false, "targets": targets }, // Deshabilitar ordenación en las columnas 1, 2 y 3 (comenzando desde 0)
    { "searchable": false, "targets": targets } // Deshabilitar filtrado en las columnas 1, 2 y 3 (comenzando desde 0)
    ]
  });
  });
  }

  function Mas(year,mes){
  window.location.href = "../../solicitud-cheque-crear/" + year + "/" + mes; 
  } 

  function ModalDetalle(id){
  $('#Modal').modal('show');  
  $('#DivContenido').load('../../app/vistas/personal-general/1-corporativo/solicitud-cheque/modal-detalle-solicitud-cheque.php?idReporte=' + id);
  }  
  
  function Editar(idReporte){
  window.location.href = "../../solicitud-cheque-editar/" + idReporte;  
  }
 
  function Eliminar(year,mes,idReporte){
  
  var parametros = {
  "idReporte" : idReporte,
  "Accion" : "eliminar-solicitud-cheque"
  };

  alertify.confirm('',
  function(){

  $.ajax({  
  data:  parametros,
  //url:   '../../public/corte-diario/modelo/eliminar-solicitud-cheque.php',
  url : '../../app/controlador/1-corporativo/controladorSolicitudCheque.php',
  type:  'post',
  beforeSend: function() {
  },
  complete: function(){

  },
  success:  function (response) {

  if (response == 1) {
  SelEstacion(year,mes);
  alertify.success('Solicitud eliminada exitosamente'); 
  }else{
  alertify.error('Error al eliminar la solicitud');  
  }

  }
  }); 
 
  },
  function(){

  }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();
    
  }

  function ModalComentario(year,mes,id){
  $('#ModalComentario').modal('show');  
  $('#DivContenidoComentario').load('../../app/vistas/personal-general/1-corporativo/solicitud-cheque/modal-comentarios-solicitud-cheque.php?idReporte=' + id + '&year=' + year + '&mes=' + mes );
  }

  function GuardarComentario(year,mes,idReporte){

  var Comentario = $('#Comentario').val();

  var parametros = {
  "idReporte" : idReporte,
  "idUsuario" : <?=$Session_IDUsuarioBD?>,
  "Comentario" : Comentario,
  "Accion" : "agregar-comentario-solicitud-cheque"
  };

  if(Comentario != ""){
  $('#Comentario').css('border',''); 

  $.ajax({ 
  data:  parametros,
  //url:   '../../public/corte-diario/modelo/agregar-comentario-solicitud-cheque.php',
  url : '../../app/controlador/1-corporativo/controladorSolicitudCheque.php',
  type:  'post',
  beforeSend: function() {
  },
  complete: function(){

  },
  success:  function (response) {

  if (response == 1) {
  $('#Comentario').val('');
  SelEstacion(year,mes);     
  $('#DivContenidoComentario').load('../../app/vistas/personal-general/1-corporativo/solicitud-cheque/modal-comentarios-solicitud-cheque.php?idReporte=' + idReporte + '&year=' + year + '&mes=' + mes);
  alertify.success('Comentario agregado exitosamente');  

  }else{
  alertify.error('Error al agregar el comentario');  
  }

  }
  });

  }else{
  $('#Comentario').css('border','2px solid #A52525'); 
  }

  } 

  function DescargarPDF(idReporte){
  window.location.href = "../../solicitud-cheque-pdf/" + idReporte;  
  }
 
  function Pago(year,mes,id){
  $('#ModalComentario').modal('show');  
  $('#DivContenidoComentario').load('../../app/vistas/personal-general/1-corporativo/solicitud-cheque/modal-pagos-solicitud-cheque.php?idReporte=' + id + '&year=' + year + '&mes=' + mes); 
  }
  
  function AgregarPago(year,mes,id){

  var data = new FormData();
  //var url = '../../public/corte-diario/modelo/agregar-pago-solicitud-cheque.php';
  var url = '../../app/controlador/1-corporativo/controladorSolicitudCheque.php',

  Documento = document.getElementById("Documento");
  Documento_file = Documento.files[0];
  Documento_filePath = Documento.value;
 
  if(Documento_filePath != ""){
  $('#Documento').css('border','');

  data.append('idReporte', id);
  
  data.append('idUsuario', 0);
  data.append('Documento', 'PAGO');
  data.append('Archivo_file', Documento_file);
  data.append('Accion','agregar-archivos-solicitud-cheque');

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
  $('#DivContenidoComentario').load('../../app/vistas/personal-general/1-corporativo/solicitud-cheque/modal-pagos-solicitud-cheque.php?idReporte=' + id + '&year=' + year + '&mes=' + mes);
  SelEstacion(year,mes)
  alertify.success('Pago agregado exitosamente'); 

  }else{
  $(".LoaderPage").hide();
  alertify.error('Error al guardar pago'); 
  }
     
  });      

  }else{
  $('#Documento').css('border','2px solid #A52525'); 
  }

  }

  //---------------------------------------------------------------------
  function Firmar(year,mes,idReporte){
  window.location.href = "../../solicitud-cheque-firmar/" + idReporte;  
  } 

  function ModalArchivos(year,mes,id){
  $('#ModalComentario').modal('show');  
  $('#DivContenidoComentario').load('../../app/vistas/personal-general/1-corporativo/solicitud-cheque/modal-archivos-solicitud-cheque.php?idReporte=' + id + '&year=' + year + '&mes=' + mes );
  }
 
  function AgregarArchivo(year,mes,id){

  var Documento = $('#Documento').val();
  var data = new FormData();
  //var url = '../../public/corte-diario/modelo/agregar-archivo-solicitud-cheque.php';
  var url = '../../app/controlador/1-corporativo/controladorSolicitudCheque.php',

  Archivo = document.getElementById("Archivo");
  Archivo_file = Archivo.files[0];
  Archivo_filePath = Archivo.value;

  if(Documento != ""){
  $('#Documento').css('border','');
  if(Archivo_filePath != ""){
  $('#Archivo').css('border','');

  data.append('idReporte', id);
  data.append('idUsuario', <?=$Session_IDUsuarioBD?>);
  data.append('Documento', Documento);
  data.append('Archivo_file', Archivo_file);
  data.append('Accion','agregar-archivos-solicitud-cheque');
 
  $(".LoaderPage").show();

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
  $(".LoaderPage").hide();
  alertify.success('Archivo agregado exitosamente')
  SelEstacion(year,mes)
  $('#DivContenidoComentario').load('../../app/vistas/personal-general/1-corporativo/solicitud-cheque/modal-archivos-solicitud-cheque.php?idReporte=' + id + '&year=' + year + '&mes=' + mes );
  }else{
  $(".LoaderPage").hide();
  alertify.error('Error al guardar el archivo'); 
  } 
  });      

  }else{
  $('#Archivo').css('border','2px solid #A52525'); 
  }
  }else{
  $('#Documento').css('border','2px solid #A52525'); 
  }
  }

  function EliminarArchivo(year,mes,idReporte,id){
  
  var parametros = {
  "idDocumento" : id,
  "Accion" : "eliminar-documentos-solicitud-cheque"
  };

  alertify.confirm('',
  function(){

  $.ajax({
  data:  parametros,
  // url:   '../../public/corte-diario/modelo/eliminar-documento-solicitud-cheque.php',
  url : '../../app/controlador/1-corporativo/controladorSolicitudCheque.php',
  type:  'post',
  beforeSend: function() {
  },
  complete: function(){

  },
  success:  function (response) {

  if (response == 1) {
  SelEstacion(year,mes)
  $('#DivContenidoComentario').load('../../app/vistas/personal-general/1-corporativo/solicitud-cheque/modal-archivos-solicitud-cheque.php?idReporte=' + idReporte + '&year=' + year + '&mes=' + mes );
  alertify.success('Documento eliminado exitosamente')
  
  }else{
  alertify.error('Error al eliminar el documento');  
  }

  }
  });

  },
  function(){

  }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

  }
    
  //-----------------------------------------------------------------------------------
  function FacTelcel(idEstacion,year,mes){
  $('#ModalComentario').modal('show');  
  $('#DivContenidoComentario').load('../../app/vistas/personal-general/1-corporativo/solicitud-cheque/modal-telcel-solicitud-cheque.php?idEstacion=' + idEstacion + '&year=' + year + '&mes=' + mes);   
  }

  function EditarTelcel(idEstacion,year,mes,id){
  $('#DivContenidoComentario').load('../../app/vistas/personal-general/1-corporativo/solicitud-cheque/modal-editar-telcel-solicitud-cheque.php?idEstacion=' + idEstacion + '&year=' + year + '&mes=' + mes + '&id=' + id); 
  }

  function CancelarTelcel(idEstacion,year,mes){
  $('#DivContenidoComentario').load('../../app/vistas/personal-general/1-corporativo/solicitud-cheque/modal-telcel-solicitud-cheque.php?idEstacion=' + idEstacion + '&year=' + year + '&mes=' + mes); 
  }

  function EditarTelcelInfo(idEstacion,year,mes,id){

  var data = new FormData();
  //var url = '../../public/corte-diario/modelo/editar-factura-telcel-solicitud-cheque.php';
  var url = '../../app/controlador/1-corporativo/controladorSolicitudCheque.php',
 
  Pago = document.getElementById("Pago");
  Pago_file = Pago.files[0];
  Pago_filePath = Pago.value;

  if(Pago_filePath != ""){
  $('#Pago').css('border','');

  data.append('idFactura', id);
  data.append('Pago_file', Pago_file);
  data.append('Accion','editar-factura-telcel-solicitud-cheque');

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
  $('#DivContenidoComentario').load('../../app/vistas/personal-general/1-corporativo/solicitud-cheque/modal-telcel-solicitud-cheque.php?idEstacion=' + idEstacion + '&year=' + year + '&mes=' + mes);  
  alertify.success('Comprobante editado exitosamente'); 
    
  }else{
  $(".LoaderPage").hide();
  alertify.error('Error al editar'); 
  }   
  }); 


  }else{
  $('#Pago').css('border','2px solid #A52525'); 
  }

  }

  function menuCorporativoYearMes(referencia){
  window.location.href = "../../" + referencia;
  }

  function returnCorporativoItem(referencia){
  window.location.href = "../../" + referencia;
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

  <div class="col-12">
  <?=$breadcrumbYearMes?>
        
  <div class="row"> 
  <div class="col-lg-9 col-12 mb-1"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Solicitud de cheques, <?=nombreMes($GET_mes)?> <?=$GET_year?></h3> </div>
  
  <div class="col-lg-3 col-12 mt-1"> 	 

  <?php if ($session_nompuesto != "Contabilidad" && $session_nompuesto != "Comercializadora" && $session_nompuesto != "Dirección de operaciones servicio social") { ?>
  <button type="button" class="btn btn-labeled2 btn-primary float-end ms-2" onclick="Mas(<?=$GET_year;?>,<?=$GET_mes;?>)">
  <span class="btn-label2"><i class="fa-solid fa-plus"></i></span>Agregar</button> 
  
  <?php }
  if($Session_IDEstacion == 6 || $Session_IDEstacion == 7){ 
  ?>
  <button type="button" class="btn btn-labeled2 btn-info float-end text-white" onclick="FacTelcel(<?=$Session_IDEstacion;?>,<?=$GET_year;?>,<?=$GET_mes;?>)">
  <span class="btn-label2"><i class="fa-solid fa-file-invoice"></i></span>Facturas Telcel</button> 
  <?php } ?>

  </div>
  </div>
      
  <hr>
  </div>


  <div class="col-12 mb-3">
  <div id="ListaSolicitudes"></div>
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
  
  <!---------- MODAL (CENTER)---------->  
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