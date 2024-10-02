<?php
require('../../../../../app/help.php');

$idReporte = $_GET['idReporte'];
$depu = $_GET['depu'];
$year = $_GET['year'];
$mes = $_GET['mes'];
$idEstacion = $_GET['idEstacion'];

$sql_documento = "SELECT * FROM op_solicitud_vale_documento WHERE id_solicitud = '".$idReporte."' AND nombre <> 'PAGO' ";
$result_documento = mysqli_query($con, $sql_documento);
$numero_documento = mysqli_num_rows($result_documento);

?>  
<div class="modal-header">
<h5 class="modal-title">Documentación</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<div class="text-secondary fw-bold">* DOCUMENTO: </div>
<select class="form-select" id="Documento">
<option></option>
<option>VALE</option> 
<option>RECIBO</option> 
<option>FACTURA</option>
<option>PDF</option>
<option>XML</option>
</select>


<div class="text-secondary mt-2 fw-bold">* ARCHIVO:</div>
<div class="input-group">
<input type="file" class="form-control rounded-0" id="Archivo">
</div>
 

<div class="table-responsive">
  <table class="custom-table mt-3" width="100%" style="font-size: .9em;">
  <thead class="tables-bg">

<tr>
<td class="text-center align-middle"><b>Descripción</b></td>
<td class="text-center" width="24px"><img src="<?=RUTA_IMG_ICONOS;?>descargar.png"></td>
<td class="text-center" width="24px"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></td>
</tr>

</thead> 

 <tbody class="bg-light">
<?php
if ($numero_documento > 0) {
while($row_documento = mysqli_fetch_array($result_documento, MYSQLI_ASSOC)){

$idDocumento = $row_documento['id'];

echo '<tr>';
echo '<th class="align-middle fw-normal">'.$row_documento['nombre'].'</th>';
echo '<td class="align-middle font-weight-light"><a href="'.RUTA_ARCHIVOS.'vales/'.$row_documento['documento'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'descargar.png"></a></td>';
echo '<td class="align-middle font-weight-light"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarArchivo('.$year.','.$mes.','.$idEstacion.','.$depu.','.$idReporte.','.$idDocumento.')"></td>';
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

<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-success" onclick="AgregarArchivo(<?=$year;?>,<?=$mes;?>,<?=$idEstacion;?>,<?=$depu;?>,<?=$idReporte;?>)">
<span class="btn-label2"><i class="fa fa-check"></i></span>Agregar</button>

</div>


