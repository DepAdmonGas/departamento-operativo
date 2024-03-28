<?php
require('../../../app/help.php');

$id = $_GET['id'];
$idEstacion = $_GET['idEstacion'];
$year = $_GET['year'];
$mes = $_GET['mes'];
$esdep = $_GET['esdep'];

$sql_lista = "SELECT * FROM op_recibo_nomina WHERE id = '".$id."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$periodo = $row_lista['periodo'];
  }

?>
<div class="modal-header">
<h5 class="modal-title">Agregar documento</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<h6><?=$periodo;?></h6>


        <div class="mb-1 text-secondary mt-2">Documento:</div>
        <input class="form-control" type="file" id="Documento">


      </div>

          <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="EditarDocumento(<?=$id;?>,<?=$idEstacion;?>,<?=$esdep;?>,<?=$year;?>,<?=$mes;?>)">Agregar</button>
      </div>
 