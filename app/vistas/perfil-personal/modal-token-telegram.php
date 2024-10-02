<?php
require '../../help.php';
$idUsuario = $_GET['idUsuario'];

$mensaje = "USA EL SIGUIENTE TOKEN PARA DARTE DE ALTA EN TELEGRAM:";
$token = bin2hex(random_bytes(3));
$sql = "SELECT token FROM op_token_telegram WHERE id_usuario = '" . $idUsuario . "' ";
$result = mysqli_query($con, $sql);
$numero_lista = mysqli_num_rows($result);
$footer = '';
if ($numero_lista > 0) {
  $mensaje = "YA ESTAS REGISTRADO PARA LA RECEPCION DE TOKEN EN TELEGRAM";
  $token ='';
  $footer = '<button type="button" class="btn btn-labeled2 btn-success" onclick="actualizaTokenTelegram(' . $idUsuario . ')">
    <span class="btn-label2"><i class="fa fa-check"></i></span>Actualizar Token</button>';
} else {
  // Se agrega el nuevo token an caso que no haber generado uno anteriormente
  // estatus 0=activo, 1= inactivo
  $sql = "INSERT INTO op_token_telegram (id_usuario,token,estatus) VALUES ('$idUsuario','$token',0)";
  $result = mysqli_query($con, $sql);
}


?>
<div class="modal-header">
  <h5 class="modal-title">Telegram Token</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">
  <div class="text-center">
    <img src="<?= RUTA_IMG_ICONOS . "telegramQR.png" ?>" class="img-fluid w-50" />
  </div>
  <div class="mt-2 fw-bold text-secondary"><?=$mensaje?></div>
    <?=$token?>
  </div>

<div class="modal-footer">
  <?=$footer?>
  <button type="button" class="btn btn-labeled2 btn-danger" onclick="Guardar(<?= $idReporte; ?>,<?= $Categoria; ?>)">
    <span class="btn-label2"><i class="fa-solid fa-file-pdf"></i></span>Descargar Manual</button>
</div>