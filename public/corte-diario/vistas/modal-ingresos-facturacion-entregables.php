<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];

$sql_lista = "SELECT * FROM op_ingresos_facturacion_archivo WHERE id_year = '".$idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?> 
 
<div class="modal-header">
<h5 class="modal-title">Entregables</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<div><small>Archivo:</small></div>
<input class="form-control" type="file" class="mt-1" id="Archivo">

<div class="text-end mt-3">
<button type="button" class="btn btn-primary btn-sm" onclick="GuardarArchivo(<?=$idReporte;?>)">Guardar archivo</button>	
</div>

<hr>

<div class="table-responsive">
<table style="font-size: .9em;" class="table table-sm table-bordered ">
<thead class="tables-bg">
<tr>
<th class="text-center align-middle">Fecha</th>
<th class="text-center align-middle" width="24px"><img src="<?=RUTA_IMG_ICONOS;?>descargar.png"></th>
<th class="text-center align-middle" width="24px"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
</tr>
</thead>
<tbody>
<?php
if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];

$explode = explode(' ', $row_lista['fecha']);

echo "<tr>";
echo "<td class='align-middle text-center'>".FormatoFecha($explode[0])."</td>";
echo '<td width="24px"><a href="'.RUTA_ARCHIVOS.$row_lista['archivo'].'" download><img src="'.RUTA_IMG_ICONOS.'descargar.png"></a></td>';
echo '<td width="24px"><a class="pointer" onclick="EliminarDoc('.$id.', '.$idReporte.')"><img src="'.RUTA_IMG_ICONOS.'eliminar.png"></a></td>';
echo "</tr>";

}
}else{
echo "<tr><th colspan='3' class='text-center text-secondary'><small>No se encontró información para mostrar </small></th></tr>";
}
?>
</tbody>
</table> 
</div>

</div>
