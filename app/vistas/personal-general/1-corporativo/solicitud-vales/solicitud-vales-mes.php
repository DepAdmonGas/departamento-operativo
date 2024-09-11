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
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" ></script>
  <link rel="stylesheet" href="<?php echo RUTA_CSS ?>selectize.css">
  <!---------- LIBRERIAS DEL DATATABLE ---------->
  <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">
  <script type="text/javascript" src="<?=RUTA_JS ?>alertify.js"></script> 
<style>
  .table-responsive {
    overflow: visible; /* Permitir que el menú se muestre fuera del contenedor */
}

.dropdown-menu {
    position: absolute;
    z-index: 1000;
    display: none; /* Ocultar el menú por defecto */
    float: left;
    min-width: 160px;
    padding: 5px 0;
    margin: 2px 0 0;
    font-size: 14px;
    text-align: left;
    list-style: none;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ccc;
    border: 1px solid rgba(0,0,0,.15);
    border-radius: 4px;
    box-shadow: 0 6px 12px rgba(0,0,0,.175);
}

/* Mostrar el menú cuando esté abierto */
.dropdown-menu.show {
    display: block;
}

/* Ajustar la posición del menú a la derecha */
.dropdown-menu-right {
    right: 0;
    left: auto;
}

/* Asegúrate de que los íconos tengan suficiente espacio */
.btn-icon-only {
    display: inline-block;
    padding: 0.5rem;
}

</style>
  <script type="text/javascript">
 
  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  ListaVales(<?=$Session_IDEstacion;?>,<?=$session_idpuesto;?>,<?=$GET_year;?>,<?=$GET_mes;?>,'<?=$Pagina;?>')
  }); 

  function Regresar(){
  window.history.back();
  } 

  function ListaVales(idEstacion, depu, year, mes, pagina){
    
  let targets = [];// Variable para almacenar los targets dinámicos
  if (idEstacion == 8) {
  targets = [7, 8];
  
  }else{
  targets = [6, 7];
  }
  
  $('#ListaVales').load('../../app/vistas/personal-general/1-corporativo/solicitud-vales/lista-solicitud-vales-mes.php?year=' + year + '&mes=' + mes + '&idEstacion=' + idEstacion + '&depu=' + depu + '&pagina=' + pagina, function() {
  // Una vez que se carguen los datos en la tabla, inicializa DataTables
  $('#tabla_solicitud_vales').DataTable({
    "language": { // Corrección de "lenguage" a "language"
    "url": "<?=RUTA_JS2?>/es-ES.json" // Corrección de la ruta del archivo de idioma
  },
    "order": [[0, "desc"]],  // Ordenar por la tercera columna de forma descendente
    "lengthMenu": [25,50,75,100], // Número de registros que se mostrarán
    "columnDefs": [
    { "orderable": false, "targets": targets }, // Deshabilitar ordenación en las columnas 1, 2 y 3 (comenzando desde 0)
    { "searchable": false, "targets": targets } // Deshabilitar filtrado en las columnas 1, 2 y 3 (comenzando desde 0)
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

  function ModalArchivos(year,mes,idEstacion,depu,id){
  $('#ModalArchivo').modal('show');  
  $('#DivContenidoArchivo').load('../../app/vistas/personal-general/1-corporativo/solicitud-vales/modal-archivos-solicitud-vale.php?idReporte=' + id + '&year=' + year + '&mes=' + mes + '&idEstacion=' + idEstacion + '&depu=' + depu);
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
  ListaVales(idEstacion,depu,year,mes,'<?=$Pagina?>'); 
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
  "idDocumento" : id,
  "Accion" : "eliminar-documento-solicitud-vale"
  };

  alertify.confirm('',
  function(){

  $.ajax({
  data:  parametros,
  //url:   '../../public/solicitud-vales/modelo/eliminar-documento-solicitud-vale.php',
  url: '../../app/controlador/1-corporativo/controladorSolicitudVale.php',
  type:  'post',
  beforeSend: function() {
    
  }, 
  complete: function(){

  },
  success:  function (response) {

  if (response == 1) {
    ModalArchivos(year,mes,idEstacion,depu,id);
    ListaVales(idEstacion,depu,year,mes,'<?=$Pagina?>'); 
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

  function ModalComentario(year,mes,idEstacion,depu,id){
  $('#ModalComentario').modal('show');  
  $('#DivContenidoComentario').load('../../app/vistas/personal-general/1-corporativo/solicitud-vales/modal-comentarios-solicitud-vale.php?idReporte=' + id + '&year=' + year + '&mes=' + mes + '&depu=' + depu + '&idEstacion=' + idEstacion);
  }

  function GuardarComentario(year,mes,idEstacion,depu,idReporte){

  var Comentario = $('#Comentario').val();

  var parametros = {
  "idReporte" : idReporte,
  "idUsuario" : <?=$Session_IDUsuarioBD?>,
  "Comentario" : Comentario,
  "Accion" : "agregar-comentario-solicitud-vale"
  };

  if(Comentario != ""){
  $('#Comentario').css('border',''); 

  $.ajax({
  data:  parametros,
  //url:   '../../public/solicitud-vales/modelo/agregar-comentario-solicitud-vale.php',
  url: '../../app/controlador/1-corporativo/controladorSolicitudVale.php',
  type:  'post',
  beforeSend: function() {

  },
  complete: function(){

  },
  success:  function (response) {

  if (response == 1) {
  $('#Comentario').val('');
  ListaVales(idEstacion,depu,year,mes,'<?=$Pagina?>'); 
  $('#DivContenidoComentario').load('../../app/vistas/personal-general/1-corporativo/solicitud-vales/modal-comentarios-solicitud-vale.php?idReporte=' + idReporte + '&year=' + year + '&mes=' + mes + '&depu=' + depu + '&idEstacion=' + idEstacion);

  }else{
  alertify.error('Error al agregar el comentario');  
  }

  }
  });

  }else{
  $('#Comentario').css('border','2px solid #A52525'); 
  }

  }


  function Eliminar(year,mes,idEstacion,depu,idReporte){

  var parametros = {
  "idReporte" : idReporte,
  "Accion" : "eliminar-solicitud-vale"
  };

  alertify.confirm('',
  function(){

  $.ajax({
  data:  parametros,
  //url:   '../../public/solicitud-vales/modelo/eliminar-solicitud-vale.php',
  url: '../../app/controlador/1-corporativo/controladorSolicitudVale.php',
  type:  'post',
  beforeSend: function() {
  },
  complete: function(){

  },
  success:  function (response) {

  if (response == 1) {
  ListaVales(idEstacion,depu,year,mes,'<?=$Pagina?>'); 
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


  function DescargarPDF(idReporte){
  window.location.href = "../../solicitud-vales-pdf/" + idReporte; 
  }

  function Editar(year,mes,idEstacion,idReporte){
  window.location.href = "../../solicitud-vales-editar/" + year + "/" + mes + "/" + idEstacion + "/" + idReporte;  
  }

  function Firmar(year,mes,idEstacion,idReporte){
  window.location.href = "../../solicitud-vales-firmar/" + idReporte;  
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
  <div class=""> 
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
  <div class="modal-dialog modal-md">
  <div class="modal-content" id="DivContenidoComentario">
  </div>
  </div>
  </div>

  <div class="modal fade" id="ModalArchivo" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  <div class="modal-content" id="DivContenidoArchivo">
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
