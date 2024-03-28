<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];
$idEstacion = $_GET['idEstacion'];

$sql_lista = "SELECT * FROM op_solicitud_aditivo_documento WHERE id_reporte = '".$idReporte."' AND nombre = 'PAGO' ORDER BY id ASC ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>
<div class="modal-header">
<h5 class="modal-title">Pagos</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">


<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0" style="font-size: .8em;">
<thead class="tables-bg">
<tr>
<th class="align-middle text-center">Fecha</th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
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
echo '<td class="align-middle font-weight-light"><a href="archivos/'.$row_lista['documento'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png"></a></td>';
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
