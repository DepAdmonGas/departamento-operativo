<?php
require ('../../../app/help.php');

$idReporte = $_GET['idReporte'];
$idFuncion = $_GET['idFuncion'];

if ($idFuncion == 0) {
  $nameModal = "Agregar";
} else if ($idFuncion == 1) {
  $nameModal = "Editar";
}
$botonFunction = '<button type="button" class="btn btn-labeled2 btn-success float-end m-2"
    onclick="AgregarEstacion(' . $idReporte . ',' . $idFuncion . ')">
    <span class="btn-label2"><i class="fa fa-check"></i></span>'.$nameModal.'</button>';
?>


<div class="modal-header">
  <h5 class="modal-title"><?= $nameModal ?> estacion</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">

  <div class="mb-1 text-secondary fw-bold">* ESTACIÓN:</div>
  <select class="form-select" id="estacionName">
    <option></option>
    <?php
    $sql = "SELECT id, localidad FROM op_rh_localidades WHERE numlista <= 8 OR (numlista BETWEEN 22 AND 23)";
    $result = mysqli_query($con, $sql);
    $numero = mysqli_num_rows($result);
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $id = $row['id'];
      $nombreES = $row['localidad'];

      echo '<option value="' . $id . '">' . $nombreES . '</option>';
    }
    ?>
  </select>

</div>


<div class="modal-footer">
  <button type="button" class="btn btn-labeled2 btn-danger float-end m-2" data-bs-dismiss="modal">
    <span class="btn-label2"><i class="fa fa-x"></i></span>Cancelar</button>
  <?= $botonFunction ?>
</div>