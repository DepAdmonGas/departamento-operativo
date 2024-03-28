<?php
require('../../../app/help.php');
$idMes = $_GET['idMes'];
$sql_lista = "
SELECT 
op_inventario_aceites.id,
op_inventario_aceites.exhibidores,
op_inventario_aceites.bodega,
op_aceites.id_aceite AS NumAceite,
op_aceites.concepto,
op_aceites.precio
FROM op_inventario_aceites
INNER JOIN op_aceites
ON op_inventario_aceites.id_aceite = op_aceites.id WHERE id_mes = '".$idMes."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>



<div class="table-responsive">
<table class="table table-bordered table-striped table-hover table-sm mb-0" style="font-size: .9em">
<thead class="tables-bg">
	<tr>
		<td class="text-center align-middle" colspan="2"><b>Concepto</b></td>
		<td class="text-center align-middle"><b>Precio</b></td>
		<td class="text-center align-middle"><b>Exhibidores</b></td>
		<td class="text-center align-middle"><b>Inventario bodega</b></td>
		<td class="text-center align-middle"><b>Fisico</b></td>
	</tr>
</thead>
<tbody>
<?php
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$fisico = $row_lista['exhibidores'] + $row_lista['bodega'];
echo '<tr>';
echo '<td class="text-center align-middle">'.$row_lista['NumAceite'].'</td>';
echo '<td class="text-center align-middle">'.$row_lista['concepto'].'</td>';
echo '<td class="text-center align-middle">'.number_format($row_lista['precio'],2).'</td>';
echo '<td class="text-center align-middle">'.$row_lista['exhibidores'].'</td>';
echo '<td class="text-center align-middle">'.$row_lista['bodega'].'</td>';
echo '<td class="text-center align-middle">'.$fisico.'</td>';
echo '</tr>';
}
?>	
</tbody>
</table>
</div>