<?php
require('../../../app/help.php');

$sql_lista = "SELECT * FROM op_control_despacho WHERE id_mes = '".$_GET['IdReporte']."' ORDER BY id desc ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>
<table class="table table-sm table-bordered pb-0 mb-0 mt-2" style="font-size: .8em;">
<thead>
	<th class="align-middle text-center">Fecha y hora</th>
	<th class="align-middle text-center" width="24"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
</thead>
<tbody>
<?php
if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$fechahora = explode(' ', $row_lista['fecha_hora']);
echo '<tr>';
echo '<td class="align-middle">'.FormatoFecha($fechahora[0]).', '.date("g:i a",strtotime($fechahora[1])).'</td>';
echo '<td><a href="../../archivos/'.$row_lista['documento'].'" download><img src="'.RUTA_IMG_ICONOS.'pdf.png"></a></td>';
echo '</tr>';

}
}else{
echo "<tr><td colspan='2' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
