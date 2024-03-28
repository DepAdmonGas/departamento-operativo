<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];
$depu = $_GET['depu'];
$year = $_GET['year'];
$mes = $_GET['mes'];
$idEstacion = $_GET['idEstacion'];

$orderFolio = $_GET['orderFolio'];
$orderFecha = $_GET['orderFecha'];

$orderCuenta = $_GET['orderCuenta'];
$orderMonto = $_GET['orderMonto'];
$orderSolicitante = $_GET['orderSolicitante'];
$buscarSolicitante = $_GET['buscarSolicitante'];

$sql_documento = "SELECT * FROM op_solicitud_vale_documento WHERE id_solicitud = '".$idReporte."' AND nombre <> 'PAGO' ";
$result_documento = mysqli_query($con, $sql_documento);
$numero_documento = mysqli_num_rows($result_documento);

?>  
 
<div class="modal-header">
<h5 class="modal-title">Archivos</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

	<div class="mb-1 text-secondary">Documento:</div>
	<select class="form-select" id="Documento">
	<option></option>
	<option>VALE</option> 
	<option>RECIBO</option> 
	<option>FACTURA</option>
	<option>PDF</option>
	<option>XML</option>
</select>


<div class="mb-1 mt-2 text-secondary">Archivo:</div>
<div class="input-group">
  <input type="file" class="form-control" id="Archivo">
</div>
 
<hr> 

<div class="row">
<div class="col-12">
    <button class="btn btn-outline-secondary btn-sm mb-3 float-end" type="button" onclick="AgregarArchivo(<?=$year;?>,<?=$mes;?>,<?=$idEstacion;?>,<?=$depu;?>,<?=$idReporte;?>,'<?=$orderFolio;?>','<?=$orderFecha;?>','<?=$orderCuenta;?>','<?=$orderMonto;?>','<?=$orderSolicitante;?>','<?=$buscarSolicitante;?>')">Agregar archivo</button></div>
</div>
 
<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0 " style="font-size: .8em;">
<thead class="tables-bg">
<tr>
<th class="align-middle text-center">Nombre archivo</th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>descargar.png"></th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
</tr>
</thead>
<tbody>
<?php
if ($numero_documento > 0) {
while($row_documento = mysqli_fetch_array($result_documento, MYSQLI_ASSOC)){

$id = $row_documento['id'];

echo '<tr>';
echo '<td class="align-middle font-weight-light">'.$row_documento['nombre'].'</td>';
echo '<td class="align-middle font-weight-light"><a href="../../archivos/vales/'.$row_documento['documento'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'descargar.png"></a></td>';
echo '<td class="align-middle font-weight-light"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarArchivo('.$year.','.$mes.','.$idEstacion.','.$depu.','.$idReporte.','.$id.',
	\''.$orderFolio.'\',
	\''.$orderFecha.'\',
	\''.$orderCuenta.'\',
	\''.$orderMonto.'\',
	\''.$orderSolicitante.'\',
	\''.$buscarSolicitante.'\')"></td>';
echo '</tr>';

}
}else{
echo "<tr><td colspan='3' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>

</div>
