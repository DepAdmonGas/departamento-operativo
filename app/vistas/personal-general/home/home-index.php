<?php
require 'app/help.php';

$sql_listComunicados = "SELECT * FROM tb_comunicados_do ORDER BY id_comunicado DESC ";  
$result_listComunicados = mysqli_query($con, $sql_listComunicados);
$numero_listComunicados = mysqli_num_rows($result_listComunicados);

$sql_listComunicadosUsu = "SELECT * FROM tb_comunicados_grte WHERE id_gerente = ".$Session_IDUsuarioBD." "; 
$result_listComunicadosUsu = mysqli_query($con, $sql_listComunicadosUsu);
$numero_listComunicadosUsu = mysqli_num_rows($result_listComunicadosUsu);

$vistaComunicados = $numero_listComunicados - $numero_listComunicadosUsu;

if($vistaComunicados == 0){
$spanAlert = '<i class="fa-solid fa-bell"></i>'; 

}else{
$spanAlert = '<span class="ms-1 badge bg-danger text-white rounded-circle">
<small>'.$vistaComunicados.'</small>
</span> ';
}

if ($session_nompuesto == "Auditor") {
$onclickF = '';
$nombreBar = 'Admongas';
}else{ 
$onclickF = 'href="'.PORTAL.'"';
$nombreBar = 'Portal';

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
  <link href="<?=RUTA_CSS2;?>cards-utilities.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  <script src="<?=RUTA_JS2?>home-general-functions.js"></script>

  <script type="text/javascript">
  function tokenTelegram(idUsuario) {
  $('#Modal').modal('show')
  $('#ContenidoModal').load('app/vistas/perfil-personal/modal-token-telegram.php?idUsuario=' + idUsuario )
  }
 
  function actualizaTokenTelegram(idUsuario,dato){
  let msg, msg2;

  if(dato == 0){
  msg = "¿Deseas generar un nuevo codigo de verificacion?";
  msg2 = 'Nuevo token generado exitosamente';
  msg3 = 'Error al generar un nuevo codigo de verificación';
  }else{

  msg = "¿Deseas revocar el acceso a tu dispositivo movil que se encuentra registrado para la recepcion de tokens?";
  msg2 = 'Acceso revocado exitosamente';
  msg3 = 'Error al revocar el acceso';
  }

  var parametros = {
  "idUsuario": idUsuario
  };

  alertify.confirm('',
  function () {
  $.ajax({
  data: parametros,
  url: 'public/admin/modelo/actualizar-token-telegram.php',
  type: 'post',
  beforeSend: function () {
 
  },
  complete: function () {

  },
  success: function (response) {


  if (response != 0) {
  tokenTelegram(idUsuario,response)
  alertify.success(msg2);
  
 } else {
  alertify.error(msg3);
  }

  }
  });
  },
  function () {

  }).setHeader('¡Alerta!').set({ transition: 'zoom', message: msg, labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();
  }
  
    window.addEventListener('pageshow', function(event) {
      if (event.persisted) {
        // Si la página está en la caché del navegador, recargarla
        window.location.reload();
      }
    });

  window.addEventListener('pageshow', function (event) {
  if (event.persisted) {
  // Si la página está en la caché del navegador, recargarla
  window.location.reload();
  }
  });
  </script> 

  </head>

  <body>
  <div class="LoaderPage"></div>

  <!---------- CONTENIDO DE PAGINA WEB ----------> 
  <div id="content">

  <!---------- NAV BAR (TOP) ---------->   
  <nav class="navbar navbar-expand navbar-light navbar-bg">

  <div class="pointer">
  <a class="text-white" <?=$onclickF?>><?=$nombreBar?></a>
  </div>
 
  <div class="navbar-collapse collapse">

  <ul class="navbar-nav navbar-align">
  <li class="nav-item dropdown"> 

  <a class=" dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
  <i class="align-middle" data-feather="settings"></i>
  </a>

  <a class="nav-link dropdown-toggle d-none d-sm-inline-block pointer text-white" data-bs-toggle="dropdown">
  <img src="<?=RUTA_IMG_ICONOS."usuarioBar.png";?>" class="avatar img-fluid rounded-circle"/>
  <span class="text-white" style="padding-left: 10px;"><?=$session_nompuesto;?> </span>
  </a> 
    
  <div class="dropdown-menu dropdown-menu-end">
  <div class="user-box"> <div class="u-text"> <p class="text-muted">Nombre de usuario:</p> <h4><?=$session_nomusuario;?></h4> </div> </div>

  <div class="dropdown-divider"></div> 
  <a class="dropdown-item" href="<?=PERFIL_ADMIN?>"> <i class="fa-solid fa-user" style="padding-right: 5px;"></i>Perfil </a>
   
  <?php if ($Session_IDUsuarioBD == 2 || $Session_IDUsuarioBD == 19 || 
  $Session_IDUsuarioBD == 21 || $Session_IDUsuarioBD == 22 || $Session_IDUsuarioBD == 30 || $Session_IDUsuarioBD == 318): ?>
  <div class="dropdown-divider"></div>
  <a class="dropdown-item pointer" onclick="tokenTelegram(<?= $Session_IDUsuarioBD ?>)">
  <i class="fa-brands fa-telegram" style="padding-right: 5px;"></i>Token Telegram
  </a>
  <?php endif; ?>

  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="<?=RUTA_SALIR2?>salir"> <i class="fa-solid fa-power-off" style="padding-right: 5px;"></i> Cerrar Sesión </a>
  </div>

  </li>
  </ul>

  </div>
  </nav>

  <!---------- CONTENIDO ----------> 
  <div class="contendAG">  

  <div class="row"> 

  <div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a <?=$onclickF?>  class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> Portal</a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Dirección de operaciones</li>
  </ol>
  </div>
 
  <div class="row"> 
  <div class="col-10"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Dirección de operaciones</h3> </div>
  <div class="col-2">
  <?php if ($session_nompuesto == "Encargado") { ?>
    <button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="comunicadoEncargado()">
    <span class="btn-label2"><?=$spanAlert;?></span>Comunicados 
  </button>
  <?php } ?>
  </div>

  </div>

  <hr>
  </div>


  <div class="col-12">
  <div id="DivlistaMenuDO"></div>
  </div>

  </div>

  </div>
  </div>




  <div class="modal fade" id="Modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <!-- Aquí se cargará el contenido dinámicamente -->
        <div id="ContenidoModal"></div>
      </div>
    </div>
  </div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>
