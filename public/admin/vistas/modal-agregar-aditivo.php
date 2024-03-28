<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$sql_aditivo = "SELECT * FROM op_inventario_aditivo WHERE id_estacion = '".$idEstacion."' ";
$result_aditivo = mysqli_query($con, $sql_aditivo);
while($row_aditivo = mysqli_fetch_array($result_aditivo, MYSQLI_ASSOC)){
$gasolina = $row_aditivo['gasolina'];
$diesel = $row_aditivo['diesel'];
}

$sql_estacion = "SELECT * FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_estacion = mysqli_query($con, $sql_estacion);
$numero_estacion = mysqli_num_rows($result_estacion);

while($row_estacion = mysqli_fetch_array($result_estacion, MYSQLI_ASSOC)){
$Session_ProductoUno = $row_estacion['producto_uno'];
$Session_ProductoDos = $row_estacion['producto_dos'];
$Session_ProductoTres = $row_estacion['producto_tres'];
}
?>


<div class="modal-header">
  <h5 class="modal-title">Agregar aditivo al inventario</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

  <label class="text-secondary mb-1">* Aditivo Gasolina Hitec 6590C <small>Galones</small></label>
  <input type="number" class="form-control rounded-0" min="0" id="AditivoGasolina">

<?php
if ($Session_ProductoTres != "") {
?>
<label class="text-secondary mt-2 mb-1">* Aditivo Diesel Hitec 4133G <small>Galones</small></label>
<input type="number" class="form-control rounded-0" min="0" id="AditivoDiesel">
<?php
}
?>
</div>

<div class="modal-footer">
  <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cancelar</button>
  <button type="button" class="btn btn-primary rounded-0" onclick="Agregar(<?=$idEstacion;?>)">Agregar</button>
</div>
