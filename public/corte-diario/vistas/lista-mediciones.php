<?php
require('../../../app/help.php');

$sql_lista = "SELECT * FROM op_mediciones WHERE id_estacion = '".$Session_IDEstacion."' ORDER BY fecha DESC ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>

<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0 font-weight-light">
<thead class="tables-bg">
	<th class="align-middle text-center">FECHA</th>
	<th class="align-middle text-center">FACTURA</th>
	<th class="align-middle text-center">NETO</th>
	<th class="align-middle text-center">BRUTO</th>
	<th class="align-middle text-center">CUENTA LITROS</th>	
	<th class="align-middle text-center">PROVEEDOR</th>
	<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
</thead>
<tbody>
<?php
 
if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

echo '<tr>';
echo '<td class="align-middle">'.FormatoFecha($row_lista['fecha']).'</td>';
echo '<td class="align-middle text-center">'.$row_lista['factura'].'</td>';
echo '<td class="align-middle text-center">'.$row_lista['neto'].'</td>';
echo '<td class="align-middle text-center">'.$row_lista['bruto'].'</td>';
echo '<td class="align-middle text-center">'.$row_lista['cuenta_litros'].'</td>';
echo '<td class="align-middle text-center">'.$row_lista['proveedor'].'</td>';
echo '<td class="text-center align-middle" width="20"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$row_lista['id'].')"></td>';
echo '</tr>';

}
}else{
echo "<tr><td colspan='7' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";	
}
?>
</tbody>
</table> 
</div>