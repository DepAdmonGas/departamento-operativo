<?php
require '../../help.php';

$idUsuario = $_GET['idUsuario'];
$token_actualizado = $_GET['tokenActualizado'];
$result2  = "";
// Verfica si el token se actualizo para poder mostrarlo
if ($token_actualizado != 1) {
  $result2 .=  '<div class="mt-2 fw-bold text-secondary">USA EL SIGUIENTE TOKEN ACTUALIZADO:</div>';

  $token = $token_actualizado;
  $digits = str_split($token);

  $result2 .=  '<ul class="code-number text-center">';
  // Iterar sobre cada dígito y hacer lo que necesites con ellos
  foreach ($digits as $digit) {
    $result2 .= "<li class='fw-bold'>" . $digit . "</li>"; // Imprimir cada dígito en una nueva línea
  }
  $result2 .= '</ul>';

  $footer = '';
} else {
  // si no se actualiza el token se muestra lo siguiente
  // Valida que halla un token existente y que este valido
  $sql = "SELECT token FROM op_token_telegram WHERE id_usuario = '" . $idUsuario . "' AND estatus = 0 ORDER BY id DESC LIMIT 1";
  $result = mysqli_query($con, $sql);
  $numero_lista = mysqli_num_rows($result);
  $footer = '';
  if ($numero_lista > 0) {
    $result2 .=  '<div class="mt-2 fw-bold text-secondary">YA ESTAS REGISTRADO PARA LA RECEPCION DE TOKEN EN TELEGRAM</div>';

    $token = '';
    $footer = '<button type="button" class="btn btn-labeled2 btn-success" onclick="actualizaTokenTelegram(' . $idUsuario . ')">
    <span class="btn-label2"><i class="fa fa-check"></i></span>Actualizar Token</button>';
  } else {
    // Se agrega el nuevo token an caso que no haber generado uno anteriormente
    // estatus 0=activo, 1= inactivo
// Generar el token
$token = bin2hex(random_bytes(3));

// Convertir el token en un array de caracteres
$digits = str_split($token);



$result2 .=  '<div class="mt-2 fw-bold text-secondary">  USA EL SIGUIENTE TOKEN PARA DARTE DE ALTA EN TELEGRAM:</div>';
  $result2 .=  '<ul class="code-number text-center">';
  // Iterar sobre cada dígito y hacer lo que necesites con ellos
  foreach ($digits as $digit) {
    $result2 .= "<li class='fw-bold'>" . $digit . "</li>"; // Imprimir cada dígito en una nueva línea
  }
  $result2 .= '</ul>';

    $sql = "INSERT INTO op_token_telegram (id_usuario,token,estatus) VALUES ('$idUsuario','$token',0)";
    $result = mysqli_query($con, $sql);
  }
}
?>

<style>
  .code-number {
      padding: 0;
      margin: 0 0 20px;
      list-style: none;
    }

    .code-number li {
      color: #000;
      background: #F2F2F2;
      font-size: 18px;
      font-weight: 400;
      line-height: 40px;
      width: 40px;
      height: 40px;
      margin: 0 10px;
      border-radius: 50%;
      display: inline-block;
    }
    @media only screen and (max-width: 476px) {
      .code-number li {
        font-size: 16px;
        line-height: 40px;
        height: 40px;
        width: 40px;
        margin: 0 7px;
      }
    }
</style>
<div class="modal-header">
  <h5 class="modal-title">Telegram Token</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">
  <div class="text-center">
    <img src="<?= RUTA_IMG_ICONOS . "telegramQR.png" ?>" class="img-fluid w-50" />
  </div>

<?=$result2?>
  
</div>

<div class="modal-footer">
  <?= $footer ?>
  <button type="button" class="btn btn-labeled2 btn-danger" onclick="pdfManual()">
    <span class="btn-label2"><i class="fa-solid fa-file-pdf"></i></span>Descargar Manual</button>
</div>