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
  MantenimientoP(<?=$Session_IDEstacion;?>)

  });
 
  function Regresar(){
  window.history.back(); 
  }


  function MantenimientoP(idEstacion){
  let targets;
  targets = [3, 7];

  $('#ContenidoPrin').load('public/admin/vistas/lista-mantenimiento-preventivo.php?idEstacion=' + idEstacion, function() {
  $('#tabla_mantenimiento_' + idEstacion).DataTable({
  "stateSave": true,
  "language": {
  "url": "<?=RUTA_JS2?>/es-ES.json"
  },
  "order": [[0, "desc"]],
  "lengthMenu": [15, 30, 50, 100],
  "columnDefs": [
  { "orderable": false, "targets": targets },
  { "searchable": false, "targets": targets }
  ]
  });
  });
  
  }


  function Nuevo(idEstacion){ 

  var parametros = {
  "idEstacion" : idEstacion
  };

  $.ajax({
  data:  parametros,
  url:   'public/admin/modelo/agregar-mantenimiento-preventivo.php',
  type:  'post',
  beforeSend: function() {
    
  },
  complete: function(){

  },
  success:  function (response) {
  ModalEditar(idEstacion,response)
  MantenimientoP(idEstacion)

  }
  });
  }

  function ModalEditar(idEstacion,response){
  $('#Modal').modal('show');  
  $('#ContenidoModal').load('public/admin/vistas/modal-mantenimiento-preventivo-editar.php?idReporte=' + response + '&idEstacion=' + idEstacion);
  }

  function Guardar(idEstacion, idReporte) {
  var data = new FormData();
  var url = 'public/admin/modelo/editar-mantenimiento-preventivo.php';

  let Nombre = $('#Nombre').val();
  let Fecha = $('#Fecha').val();
  let Fecha2 = $('#Fecha2').val();
  let Observacion = $('#Observacion').val();

  let Archivo = document.getElementById("Archivo");
  let Archivo_file = Archivo.files[0];

  // Lista de campos a validar
  var campos = [
    { id: '#Nombre', valor: Nombre },
    { id: '#Fecha', valor: Fecha },
    { id: '#Fecha2', valor: Fecha2 },
    { id: '#Archivo', valor: Archivo_file } // Validar que se haya seleccionado un archivo
  ];

  var esValido = true;

  // Validar campos vacíos
  campos.forEach(function(campo) {
    if (!campo.valor) {
      $(campo.id).css('border', '2px solid red');
      esValido = false;
    } else {
      $(campo.id).css('border', '');
    }
  });

  // Si todos los campos son válidos, proceder con el envío AJAX
  if (esValido) {
    data.append('idReporte', idReporte);
    data.append('Archivo_file', Archivo_file);
    data.append('Nombre', Nombre);
    data.append('Fecha2', Fecha2);
    data.append('Fecha', Fecha);
    data.append('Observacion', Observacion);

    $.ajax({
      url: url,
      type: 'POST',
      contentType: false,
      data: data,
      processData: false,
      cache: false 
    }).done(function(data) {
      if (data == 1) {
        alertify.success('Registro agregado exitosamente');
        MantenimientoP(idEstacion);
        $('#Modal').modal('hide');
      } else {
        alertify.error('Error al agregar el registro');
      }
    }); 
  }
}


  function Eliminar(idEstacion,idReporte){

      var parametros = {
    "idEstacion" : idEstacion,
    "id" : idReporte
    };

alertify.confirm('',
 function(){
 
    $.ajax({
    data:  parametros,
    url:   'public/admin/modelo/eliminar-mantenimiento-preventivo.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    MantenimientoP(idEstacion)
    alertify.success('Mantenimiento eliminado exitosamente.');

    }
    });

},
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();
 }

 function ActualizarStatus(idEstacion,idReporte,status){
  if(status == 0){
  var msg = "cambiar el estatus del mantenimiento seleccionado a: En Proceso";

  }else if(status == 1){
  var msg = "cambiar el estatus del mantenimiento seleccionado a: Finalizado";

  }


  alertify.confirm('',
  function(){

  var parametros = {
  "idEstacion" : idEstacion,
  "idReporte" : idReporte,
  "Status" : status
  };

  $.ajax({
  data:  parametros,
  url:   'public/admin/modelo/actualizar-status-mantenimiento-preventivo.php',
  type:  'post',
  beforeSend: function() {
  }, 
  complete: function(){

  },
  success:  function (response) {

  if (response == 1) {
  MantenimientoP(idEstacion)
  alertify.success('Estatus de mantenimiento actualizado exitosamente.');

  }else{
  alertify.error('Error al actualizar el estatus del mantenimiento');  
  }

  } 
  });



  },
  function(){

  }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea ' + msg + '?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

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

  <div class="col-12" id="ContenidoPrin"></div>

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
