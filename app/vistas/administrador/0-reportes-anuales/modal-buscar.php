<?php
require '../../../help.php';
?>
<div class="modal-header">
  <h5 class="modal-title">Buscar</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">


<label class="text-secondary">Estacion:</label>
<select class="form-select mb-2" id="Estaciones">
<option value="">Selecciona una opcion...</option>
<?php
$sql_estaciones = "SELECT id, localidad FROM op_rh_localidades WHERE numlista <= 8 ORDER BY numlista ASC";
$result_estaciones = mysqli_query($con, $sql_estaciones);
$numero_estaciones = mysqli_num_rows($result_estaciones);
 
while($row_estaciones = mysqli_fetch_array($result_estaciones, MYSQLI_ASSOC)){
$idEstacionOP = $row_estaciones['id'];
$nombreES = $row_estaciones['localidad']; 
echo '<option value="'.$idEstacionOP.'">'.$nombreES.'</option>';
}
echo '<option value="0">Todas las estaciones</option>';
?>
</select>


<label class="text-secondary">Año:</label>
<select class="form-select" id="Year">
<option value="">Selecciona una opcion...</option>
<?php
$Year = date("Y");
for ($i = $Year; $i >= 2021; $i--) {
echo '<option value="' . $i . '">' . $i . '</option>';
}
?>
</select>
</div>


<div class="modal-footer">

  <button type="button" class="btn btn-labeled2 btn-danger" data-bs-dismiss="modal">
    <span class="btn-label2"><i class="fa fa-xmark"></i></span>Cancelar</button>

  <button type="button" class="btn btn-labeled2 btn-success" onclick="Buscar()">
    <span class="btn-label2"><i class="fa fa-search"></i></span>Buscar</button>

</div>