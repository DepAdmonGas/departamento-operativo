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
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<div>Correo electrónico:</div>
<input type="text" class="form-control mb-2" id="CorreoElectronico" value="cambiosdedestinovdm@g500network.com">

<div>Asunto:</div>
<textarea class="form-control mb-2" id="Asunto">Formato de Pivoteo</textarea>
<div>Contenido:</div>
<textarea class="form-control mb-3" id="Contenido">Envió formato de Pivoteo con número de folio: 0<?=$nocontrol;?></textarea>

<div class="table-responsive">
<table class="custom-table" style="font-size: .8em;" width="100%">
<thead class="tables-bg">
 <tr>
  <th class="text-center align-middle tableStyle font-weight-bold">Correo</th>
  <th class="align-middle text-center tableStyle font-weight-bold">Fecha y Hora</th>
  </tr>
</thead> 
<tbody class="bg-light">
<?php
if ($numero_lista > 0) {

while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

echo '<tr>';
echo '<th class="align-middle text-center fw-normal">'.$row_lista['correo'].'</th>';
echo '<td class="align-middle text-center">'.$row_lista['fecha_creacion'].'</td>';
echo '</tr>';

}
}else{
echo "<tr><th colspan='8' class='text-center text-secondary fw-normal no-hover2'><small>No se encontró información para mostrar </small></th></tr>";
}
?>
</tbody>
</table>
</div>

</div>

<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-success" onclick="EnviarCorreo(<?=$idReporte;?>,<?=$idEstacion;?>)">
<span class="btn-label2"><i class="fa-solid fa-envelope-circle-check"></i></span>Enviar</button>
</div>

