<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];

?>
<div class="modal-header">
<h5 class="modal-title">Agregar Pivoteo</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">

<h5>Documentación Facturada (CANCELAR)</h5>

<div><b>Estación:</b></div>
<select class="form-control" id="EstacionFC">
<option></option>
<?php
$sql_lista = "SELECT * FROM tb_estaciones WHERE numlista <= 8";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista); 
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
echo '<option>'.$row_lista['razonsocial'].'</option>';
}
?>
<option>SERVICIO MENA, S.A. DE C.V.</option>
<option>SUPER SERVICIO VALLEJO, S.A. DE C.V.</option>
<option>SUPER SERVICIO PERIFERICO, S.A. DE C.V.</option>
</select>

<div class="border p-1 mt-2">
<div class="text-center"><small>Otra estación:</small></div>

<div><b>Estación:</b></div>
<input type="text" class="form-control" id="EstacionOtroFC">
<div><b>Destino:</b></div>
<input type="number" class="form-control" id="DestinoOtroFC">

</div>

<div class="mt-2"><b>Producto:</b></div>
<select class="form-control" id="Producto">
  <option></option>
  <option>87 OCTANOS</option>
  <option>91 OCTANOS</option>
  <option>DIESEL</option>
</select>

<div><b>Tanque:</b></div>
<select class="form-control" id="Tanque">
  <option></option>
  <option>Tanque 1</option>
  <option>Tanque 2</option>
  <option>Tanque 3</option>
  <option>Tanque 4</option>
  <option>Tanque 5</option>
</select>

<div><b>Litros:</b></div>
<input type="number" class="form-control" id="Litros">

<hr>
<h5>Documentación a refacturar</h5>
 
<div class=""><b>Tanque vertido:</b></div>
<select class="form-control" id="TanqueFN">
  <option></option>
  <option>Tanque 1</option>
  <option>Tanque 2</option>
  <option>Tanque 3</option>
  <option>Tanque 4</option>
  <option>Tanque 5</option>
</select>

</div>
<div class="modal-footer">
<button type="button" class="btn btn-primary" onclick="Guardar(<?=$idReporte;?>)">Guardar</button>
</div>



