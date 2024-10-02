<?php
require('../../../../../help.php');

$IdReporte = $_GET['IdReporte'];
$id = $_GET['id'];

$sql_lista = "SELECT * FROM op_monedero_documento WHERE id = '".$id."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$fecha = $row_lista['fecha']; 
$monedero = $row_lista['monedero']; 
$diferencia = $row_lista['diferencia']; 
}
?>

<div class="modal-header">
<h5 class="modal-title">Facturas</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
<div class="mb-1 text-secondary">Agregar fecha</div>
<input type="date" class="form-control" id="Fecha" value="<?=$fecha;?>">

        <div class="mb-1 mt-2 text-secondary">Agregar monedero</div>
        <select class="form-select" id="Cilote">
          <option><?=$monedero;?></option>
          <option>Edenred</option>
          <option>Efectivale</option>
          <option>Inburgas</option>
          <option>Ultragas</option>
          <option>Sodexo</option>

        </select>

        <div class="mb-1 mt-2 text-secondary">Diferencia</div>
        <input type="number" class="form-control" id="Diferencia" step="any" value="<?=$diferencia;?>">

        <div class="mb-1 mt-2 text-secondary">Agregar PDF</div>
        <input class="form-control" type="file" id="PDF">

        <div class="mb-1 mt-2 text-secondary">Agregar XML</div>
        <input class="form-control" type="file" id="XML">

        <div class="mb-1 mt-2 text-secondary">Agregar EXCEL</div>
        <input class="form-control" type="file" id="EXCEL">
        <hr>

      </div>

      <div class="modal-footer">

      <button type="button" class="btn btn-labeled2 btn-danger float-end m-2" onclick="Cancelar(<?=$IdReporte;?>)">
          <span class="btn-label2"><i class="fa fa-x"></i></span>Cancelar</button>
        <button type="button" class="btn btn-labeled2 btn-success float-end m-2" onclick="EditarInfo(<?=$IdReporte;?>,<?=$id;?>)">
          <span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
      </div>

