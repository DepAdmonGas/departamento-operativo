<?php
require ('../../../app/help.php');

$idProveedor = $_GET['idProveedor'];
$idReporte = $_GET['idReporte'];

$sql = "SELECT * FROM op_orden_compra_proveedor WHERE id = '" . $idProveedor . "' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
  $razon_social = $row['razon_social'];
  $direccion = $row['direccion'];
  $contacto = $row['contacto'];
  $email = $row['email'];

}

?>

<div class="modal-header">
  <h5 class="modal-title">Editar proveedor</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

  <div class="mb-1 text-secondary fw-bold">RAZÓN SOCIAL:</div>
  <input type="text" class="form-control" id="RazonSocial" value="<?= $razon_social ?>">

  <div class="mb-1 mt-2 text-secondary fw-bold">DIRECCIÓN:</div>
  <textarea class="form-control" id="Direccion"><?= $direccion ?></textarea>

  <div class="mb-1 mt-2 text-secondary fw-bold">CONTACTO:</div>
  <input type="text" class="form-control" id="Contacto" value="<?= $contacto ?>">

  <div class="mb-1 mt-2 text-secondary fw-bold">EMAIL:</div>
  <input type="text" class="form-control" id="Email" value="<?= $email ?>">


</div>
<div class="modal-footer">
  <button type="button" class="btn btn-labeled2 btn-danger float-end m-2" data-bs-dismiss="modal">
    <span class="btn-label2"><i class="fa fa-x"></i></span>Cancelar</button>
  <button type="button" class="btn btn-labeled2 btn-success float-end m-2"
    onclick="EditarProveedor(<?= $idProveedor ?>,<?= $idReporte; ?>)">
    <span class="btn-label2"><i class="fa fa-check"></i></span>Editar</button>

</div>