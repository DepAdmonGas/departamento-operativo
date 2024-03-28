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
  <link rel="shortcut icon" href="<?php echo RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="apple-touch-icon" href="<?php echo RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="stylesheet" href="<?php echo RUTA_CSS ?>alertify.css">
  <link rel="stylesheet" href="<?php echo RUTA_CSS ?>themes/default.rtl.css">
  <link href="<?php echo RUTA_CSS ?>bootstrap.css" rel="stylesheet" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?php echo RUTA_JS ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  <style media="screen">
  .LoaderPage {
  position: fixed;
  left: 0px;
  top: 0px;
  width: 100%;
  height: 100%;
  z-index: 9999;
  background: url('../imgs/iconos/load-img.gif') 50% 50% no-repeat rgb(249,249,249);
  }
  </style>
  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  });

  function Regresar(){
  window.history.back();
  }

    function Nuevo(IDEstacion){

    var parametros = {
    "IDEstacion" : IDEstacion
    };

    $.ajax({
    data:  parametros,
    url:   'public/orden-servicio/modelo/crear-orden-servicio.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if(response != 0){
    window.location.href = "orden-servicio-nuevo/" + response;
    }else{
    alertify.error('Error al crear el reporte'); 
    }

    }
    });

  }

  </script>
  </head>
  <body>
  <div class="LoaderPage"></div>

  <div class="p-4">
  <div class="card">
  <div class="card-body">
  <div class="border-bottom pb-5">
  <div class="float-left">
  <h5 class="card-title"><img class="pr-2" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()"> Orden de Servicio</h5>
  </div>
  <div class="float-right">
  <img src="<?=RUTA_IMG_ICONOS;?>mas.png" class="ml-2" onclick="Nuevo(<?=$Session_IDEstacion;?>)">
  </div>
  </div>

<table class="table table-sm table-bordered table-hover mt-2" style="font-size: .9em;">
<thead>
  <tr>
  <td class="text-center align-middle tableStyle font-weight-bold">#</td>
  <td class="text-center align-middle tableStyle font-weight-bold">Folio</td>
  <td class="text-center align-middle tableStyle font-weight-bold">Fecha</td>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-detalle.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-comentario.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
  </tr>
</thead> 
<tbody> 
<tr>
<td colspan="8"></td>
</tr>
</tbody> 
</table>

  </div>
  </div>
  </div>

  <script src="<?php echo RUTA_JS ?>bootstrap.min.js"></script>
  </body>
  </html>
