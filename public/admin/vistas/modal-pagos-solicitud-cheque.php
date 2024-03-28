<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];
$depu = $_GET['depu'];
$year = $_GET['year'];
$mes = $_GET['mes'];
$idEstacion = $_GET['idEstacion'];

$sql_lista = "SELECT * FROM op_solicitud_cheque_documento WHERE id_solicitud = '".$idReporte."' AND nombre = 'PAGO' ORDER BY id ASC ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>
<div class="modal-header">
<h5 class="modal-title">Pagos</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">

<div class="mb-1text-secondary">Documento:</div>
<div class="input-group mb-3">
  <input type="file" class="form-control" id="Documento">
</div>

<hr>

<div class="row">
<div class="col-12">

<button class="btn btn-outline-secondary btn-sm float-end" type="button" onclick="AgregarPago(<?=$year;?>,<?=$mes;?>,<?=$idEstacion;?>,<?=$depu;?>,<?=$idReporte;?>)">Agregar pago</button>

</div>
</div>

<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0 mt-2 mb-0" style="font-size: .8em;">
<thead class="tables-bg">
<tr>
<th class="align-middle text-center">Fecha</th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
</tr>
</thead>
<tbody> 
<?php
if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$id = $row_lista['id'];
$explode = explode(' ', $row_lista['fecha']);


echo '<tr>';
echo '<td class="align-middle font-weight-light">'.FormatoFecha($explode[0]).'</td>';
echo '<td class="align-middle font-weight-light"><a class="pointer" href="../../../archivos/'.$row_lista['documento'].'" download><img src="'.RUTA_IMG_ICONOS.'pdf.png"></a></td>';
echo '<td class="align-middle font-weight-light"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarDoc('.$year.','.$mes.','.$idEstacion.','.$depu.','.$idReporte.','.$id.')"></td>';
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
