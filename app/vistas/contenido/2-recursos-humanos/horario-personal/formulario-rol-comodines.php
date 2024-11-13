<?php
require ('app/help.php');

?>
  <html lang="es">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Departamento Operativo</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <link rel="shortcut icon" href="<?= RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="apple-touch-icon" href="<?= RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="stylesheet" href="<?= RUTA_CSS2 ?>alertify.css">
  <link rel="stylesheet" href="<?= RUTA_CSS2 ?>themes/default.rtl.css">
  <link href="<?= RUTA_CSS2; ?>bootstrap.min.css" rel="stylesheet" />
  <link href="<?= RUTA_CSS2; ?>navbar-general.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?= RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

  <script type="text/javascript">
  $(document).ready(function ($) {
  $(".LoaderPage").fadeOut("slow");
  ListaComodines(<?=$GET_idReporte?>);

  });

  function Regresar() {
  window.history.back();
  }

  function ListaComodines(idReporte) {
  $('#ListaComodines').load('../app/vistas/contenido/2-recursos-humanos/horario-personal/contenido-formulario-rol-comodines.php?idReporte=' + idReporte);
  } 

  function EditEstacion(titulo, dia, idUsuario, idReporte) {
  var idEstacion = titulo.value;

  var parametros = {
  "idEstacion": idEstacion,
  "dia": dia,
  "idUsuario": idUsuario,
  "idReporte": idReporte,
  "accion": "editar-estacion-comodin"
  };
   
  $.ajax({
  data: parametros,
  url: '../app/controlador/2-recursos-humanos/controladorHorario.php',
  type: 'POST',
  beforeSend: function () {
  $(".LoaderPage").show();
  },
  complete: function () { 

  },
  success: function (response) {

  if(response == 1){
  $(".LoaderPage").hide();
  ListaComodines(idReporte)
  alertify.success('La estación fue editada exitosamente.');
  } else {
  $(".LoaderPage").hide();
  alertify.error('El horario no fue editado');
  }
  }
  });
  }
        
  function GuardarRol(idReporte) {
  var fechaInicio = $('#fechaInicio').val();
  var fechaTermino = $('#fechaTermino').val();

  if (fechaInicio != "") {
  $("#fechaInicio").css('border', '');

  if (fechaTermino != "") {
  $("#fechaTermino").css('border', '');

  var parametros = {
  "idReporte": idReporte,
  "fechaInicio": fechaInicio,
  "fechaTermino": fechaTermino,
  "accion": "finalizar-rol-comodines"
  };
   
  $.ajax({
  data: parametros,
  url: '../app/controlador/2-recursos-humanos/controladorHorario.php',
  //url: '../public/recursos-humanos/modelo/guardar-personal-programar-horiario.php',
  type: 'POST',
  beforeSend: function () {
  $(".LoaderPage").show();
  }, 
  complete: function () { 

  },
  success: function (response) {
  if (response == 1) {
  $(".LoaderPage").hide();
  history.back();

  }else if (response == 0){
  $(".LoaderPage").hide();
  alertify.error('Error al finalizar el rol de comodines');
  }

  }
  });

  }else{
  $("#fechaInicio").css('border', '2px solid #A52525');
  alertify.error('Falta ingresar la fecha de termino.');
  }

  }else{
  $("#fechaInicio").css('border', '2px solid #A52525');
  alertify.error('Falta ingresar la fecha de inicio.');
  }

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
  <div class="container bg-white p-3"> 

  <div class="row">

  <div class="col-12">     
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">                       
  <ol class="breadcrumb breadcrumb-caret">                          
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Rol de Comodines </a></li>                           
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Formulario Rol de Comodines</li>
  </ol>             
  </div>

  <div class="row">
  <div class="col-12"><h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Formulario Rol de Comodines</h3><hr></div>
  <!-- <div class="col-2"><input type="date" class="form-control" id="Fecha"></div> -->
  <div class="col-12" id="ListaComodines"></div>
                                          
  <div class="col-12">
  <hr>
  <button type="button" class="btn btn-labeled2 btn-success float-end mb-0 pb-0" onclick="GuardarRol(<?= $GET_idReporte; ?>)">
  <span class="btn-label2"><i class="fa fa-check"></i></span>Finalizar</button>
  </div>
                    
  </div>

  </div>

  </div>
  </div>
  </div>

  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

</body>
</html>