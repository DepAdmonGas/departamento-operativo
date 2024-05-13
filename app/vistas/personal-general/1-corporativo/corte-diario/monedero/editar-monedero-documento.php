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

      <div class="text-end">
      	<button type="button" class="btn btn-danger" onclick="Cancelar(<?=$IdReporte;?>)">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="EditarInfo(<?=$IdReporte;?>,<?=$id;?>)">Guardar</button>
      </div>