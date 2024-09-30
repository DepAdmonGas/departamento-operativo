<?php
require ('../../../app/help.php');

$idReporte = $_GET['idReporte'];
$idEstacion = $_GET['idEstacion'];
function Responsable($id, $con)
{

  $sql_resp = "SELECT * FROM tb_usuarios WHERE id = '" . $id . "'  ";
  $result_resp = mysqli_query($con, $sql_resp);
  $numero_resp = mysqli_num_rows($result_resp);
  while ($row_resp = mysqli_fetch_array($result_resp, MYSQLI_ASSOC)) {
    $Usuario = $row_resp['nombre'];

  }
  return $Usuario;

}

$sql_lista = "SELECT * FROM op_solicitud_aditivo WHERE id = '".$idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
$row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC);

$sql_comen = "SELECT * FROM op_solicitud_aditivo_comentario WHERE id_reporte = '" . $idReporte . "' ORDER BY id DESC ";
$result_comen = mysqli_query($con, $sql_comen);
$numero_comen = mysqli_num_rows($result_comen);


echo '
      <div class="modal-header">
      <h5 class="modal-title">Comentarios</h5>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

<div class="p-3">

<div class="" style="height: 300px;overflow: auto;">';

echo '<div style="font-size: .75em;" class="mb-1 text-secondary">Información</div> 
        <div class="bg-light fw-light pt-2 pb-1 ps-3 pe-3 mb-3" style="font-size: .85em;border-radius: 25px;"><b>No. Orden: </b>'.$row_lista['orden_compra'].', <b>Fecha:</b> '.FormatoFecha($row_lista['fecha']).', <b>Solicitado por:</b> '.Responsable($row_lista['id_personal'], $con).'</div>';

if ($numero_comen > 0) {
  while ($row_comen = mysqli_fetch_array($result_comen, MYSQLI_ASSOC)) {
    $idUsuario = $row_comen['id_usuario'];
    $comentario = $row_comen['comentario'];

    $NomUsuario = Responsable($idUsuario, $con);

    if ($Session_IDUsuarioBD == $idUsuario) {
      $margin = "margin-left: 30px;margin-right: 5px;";
    } else {
      $margin = "margin-right: 30px;margin-left: 5px;";
    }

    $fechaExplode = explode(" ", $row_comen['fecha_hora']);
    $FechaFormato = FormatoFecha($fechaExplode[0]);
    $HoraFormato = date("g:i a", strtotime($fechaExplode[1]));
    ?>
    <div class="mt-1" style="<?= $margin; ?>">

      <div style="font-size: .7em;" class="mb-1"><?= $NomUsuario; ?></div>
      <div class="title-table-bg text-white" style="border-radius: 30px;">
        <p class="p-2 pb-0"><?= $comentario; ?></p>
      </div>
      <div class="text-end" style="font-size: .7em;margin-top: -10px"><?= $FechaFormato; ?>, <?= $HoraFormato; ?></div>

    </div>
    <?php
  }
}
?>
</div>
</div>
<div class="border-top">
<textarea class="form-control rounded-0 border-0" id="Comentario" placeholder="* Comentarios"></textarea>
</div>


<div class="modal-footer">
  <button type="button" class="btn btn-labeled2 btn-success"
    onclick="GuardarComentario(<?= $idEstacion; ?>,<?= $idReporte; ?>)">
    <span class="btn-label2"><i class="fa fa-check"></i></span>Guardar
  </button>
</div>