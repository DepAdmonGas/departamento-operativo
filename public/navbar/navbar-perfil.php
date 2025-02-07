<?php
/*
$componentes_url = parse_url($_SERVER["REQUEST_URI"]);
$ruta = $componentes_url['path'];

$partes_ruta = explode("/", $ruta);
$partes_ruta = array_filter($partes_ruta);
$partes_ruta = array_slice($partes_ruta, 0);

$ruta_elegida = '';

if (count($partes_ruta) == 1){
$ruta_elegida = 'perfil';
}else if(count($partes_ruta) == 2){
$ruta_elegida = 'perfil';
}else if(count($partes_ruta) == 3){
$ruta_elegida = '../perfil';
}else if(count($partes_ruta) == 4){
$ruta_elegida = '../../perfil'; 
}else if(count($partes_ruta) == 5){
$ruta_elegida = '../../../perfil'; 
}else if(count($partes_ruta) == 6){
$ruta_elegida = '../../../../perfil';
}else if(count($partes_ruta) == 7){
$ruta_elegida = '../../../../../perfil';
}else if(count($partes_ruta) == 8){
$ruta_elegida = '../../../../../../perfil';
}
*/
 
if($Session_IDUsuarioBD == 332 || $session_nompuesto == "Capex"){
$nombreBar = "AdmonGas";
$onclickF = "href='miselanea-30-31'";

}else if($Session_IDUsuarioBD == 509){
  $nombreBar = "AdmonGas";
  $onclickF = "onclick='location.reload();'";
    
}else if ($session_nompuesto == "Auditor"){

if($Session_IDUsuarioBD == 346){
  $nombreBar = "AdmonGas";
  $onclickF = "onclick='history.back()'";
}else{
  $nombreBar = "AdmonGas";
  $onclickF = "href='descarga-tuxpan'";
}

}else if($Session_IDUsuarioBD == 2 || $Session_IDUsuarioBD == 22){
$nombreBar = "AdmonGas";
$onclickF = "href='administracion'";

}else if($Session_IDUsuarioBD == 357){
$nombreBar = "AdmonGas";
$onclickF = "href='solicitud-cheque'";

}else if($Session_IDEstacion == 8){
$nombreBar = "AdmonGas";
$onclickF = "onclick='history.back()'";

}else{ 
$nombreBar = $session_nomestacion;
$onclickF = "onclick='history.back()'";
}
  
?> 


<script>
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



  function pdfManualTelegram(){
    
  }
</script>


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

  <span class="text-white" style="padding-left: 10px;">
  <?=$session_nompuesto;?>  
  </span>
  </a> 
  
  <div class="dropdown-menu dropdown-menu-end">
  
  <div class="user-box">

  <div class="u-text">
  <p class="text-muted">Nombre de usuario:</p>
  <h4><?=$session_nomusuario;?></h4>
  </div>

  </div>

  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="<?=PERFIL_ADMIN?>">
  <i class="fa-solid fa-user" style="padding-right: 5px;"></i>Perfil
  </a>   
 
  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="<?=RUTA_SALIR2?>salir">
  <i class="fa-solid fa-power-off" style="padding-right: 5px;"></i> Cerrar Sesión
  </a>

  </div>
  </li>
  
  </ul>
  </div>

  </nav>