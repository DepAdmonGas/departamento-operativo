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
  <link rel="stylesheet" href="<?=RUTA_CSS2?>alertify.css">
  <link rel="stylesheet" href="<?=RUTA_CSS2?>themes/default.rtl.css">
  <link href="<?=RUTA_CSS2;?>bootstrap.min.css" rel="stylesheet" />
  <link href="<?=RUTA_CSS2;?>navbar-general.min.css" rel="stylesheet"/>


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>

  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  <script type="text/javascript" src="<?=RUTA_JS ?>alertify.js"></script>

<!---------- LIBRERIAS DEL DATATABLE ---------->
<link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">
   
  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  SelEstacionLts(<?=$Session_IDEstacion?>,<?=$GET_idYear?>,<?=$GET_idMes?>)
  }); 

  window.addEventListener('pageshow', function(event) {
  if (event.persisted) {
  // Si la página está en la caché del navegador, recargarla
  window.location.reload();
  }
  });

  function SelEstacionLts(idEstacion,year,mes) {
    
    let targets;
    targets = [2];

    $('#ListaCuentaLts').load('../../public/admin/vistas/lista-cuenta-litros.php?idEstacion=' + idEstacion + '&year=' + year + '&mes=' + mes, function () {
      $('#tabla_cuenta_litros').DataTable({
        "language": {
          "url": "<?= RUTA_JS2 ?>/es-ES.json"
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
  //---------- FORMULARIO EDITAR CUENTA LITROS ----------
  function EditarCL(idCuentaLitros){
  window.location.href = "../../cuenta-litros-formato/" + idCuentaLitros; 
  }

  //---------- MODAL NUEVO CUENTA LITROS ----------
  function DetalleCL(idCuentaLitros){
  window.location.href = "../../cuenta-litros-detalle/" + idCuentaLitros;  
  }

  //---------- FORMULARIO AGREGAR CUENTA LITROS ----------
  function NuevoCuentaLitros(idEstacion,year,mes){

  var parametros = {
  "idEstacion" : idEstacion,
  "year" : year,
  "mes" : mes
  };

  $.ajax({   
  data:  parametros,
  url:   '../../public/admin/modelo/agregar-formato-cuenta-litros.php',
  type:  'POST',
  beforeSend: function() { 
     
  },  
  complete: function(){
    
  },
  success:  function (response) {
 
  if(response != 0){
  window.location.href = "../../cuenta-litros-formato/" + response; 
  }
 
  } 
  });
 
  }


  //---------- ELIMINAR CUENTA LITROS REGISTRO (SERVER) ----------
  function EliminarCL(idCuentaLitros,idEstacion,year,mes){

  var parametros = {
  "idCuentaLitros" : idCuentaLitros
  };

  alertify.confirm('',
  function(){

  $.ajax({
  data:  parametros,    
  url:   '../../public/admin/modelo/eliminar-cuenta-litros-registro.php',
  type:  'post',
  beforeSend: function() {
    
  }, 
  complete: function(){
 
  },
  success:  function (response) {

  if (response == 1) {
  alertify.success('Registro eliminado exitosamente.')
  SelEstacionLts(idEstacion,year,mes)

  }else{
  alertify.error('Error al eliminar el registro');  
  }

  }
  });

  },
  function(){

  }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar el registro seleccionado?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

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
  <div class="col-12" id="ListaCuentaLts"></div>
  </div>
  </div>

  </div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2?>bootstrap.min.js"></script>

<!---------- LIBRERIAS DEL DATATABLE ---------->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.js"></script>

  </body>
  </html>
           