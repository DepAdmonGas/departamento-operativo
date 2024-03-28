<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];
$idEstacion = $_GET['idEstacion'];

$sql_lista = "SELECT * FROM op_pivoteo_correo WHERE id_pivoteo = '".$idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

$sql = "SELECT * FROM op_pivoteo WHERE id = '".$idReporte."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result); 
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$idestacion = $row['id_estacion'];
$nocontrol = $row['nocontrol'];
$fecha = $row['fecha'];
$sucursal = $row['sucursal'];
$causa = $row['causa'];
$estatus = $row['estatus'];
}

?>
<div class="modal-header">
<h5 class="modal-title">Enviar por correo el pivoteo</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<div>Correo electrónico:</div>
<input type="text" class="form-control mb-2" id="CorreoElectronico" value="cambiosdedestinovdm@g500network.com">

<div>Asunto:</div>
<textarea class="form-control mb-2" id="Asunto">Formato de Pivoteo</textarea>
<div>Contenido:</div>
<textarea class="form-control mb-3" id="Contenido">Envió formato de Pivoteo con número de folio: 0<?=$nocontrol;?></textarea>

<div class="text-end">
<button type="button" class="btn btn-success" onclick="EnviarCorreo(<?=$idReporte;?>,<?=$idEstacion;?>)">Enviar</button>
</div>

<hr>

<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0" style="">
<thead class="tables-bg">
 <tr>
  <th class="text-center align-middle tableStyle font-weight-bold">Correo</th>
  <th class="align-middle text-center tableStyle font-weight-bold">Fecha y Hora</th>
  </tr>
</thead> 
<tbody>
<?php
if ($numero_lista > 0) {

while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

echo '<tr>';
echo '<td class="align-middle text-center">'.$row_lista['correo'].'</td>';
echo '<td class="align-middle text-center">'.$row_lista['fecha_creacion'].'</td>';
echo '</tr>';

}
}else{
echo "<tr><td colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>

</div>

