<?php
require('../../../app/help.php');

$IdReporte = $_GET['IdReporte'];

$sql_lista = "SELECT * FROM op_factura_telcel WHERE id_mes = '".$_GET['IdReporte']."' ORDER BY id desc";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);


if ($session_nompuesto != "Contabilidad" && $session_nompuesto != "Comercializadora" && $session_nompuesto != "Dirección de operaciones servicio social" || $Session_IDUsuarioBD == 334) {
$ocultarDelete = "";
}else{
$ocultarDelete = "d-none";
}

?>


<div class="border p-3">

<?php if ($session_nompuesto != "Contabilidad" && $session_nompuesto != "Comercializadora" && $session_nompuesto != "Dirección de operaciones servicio social" || $Session_IDUsuarioBD == 334) { ?>
<div class="text-end mt-2">
<img class="pointer" src="<?=RUTA_IMG_ICONOS;?>agregar.png" onclick="btnModal(<?=$IdReporte;?>)">
</div>
<hr>
<?php } ?>


<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0" style="font-size: .8em;">
<thead class="tables-bg">
	<th class="align-middle text-center">DETALLE</th>
	<th class="align-middle text-center">FECHA Y HORA</th>
	<th class="align-middle text-center" width="24"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
	<th class="align-middle text-center <?=$ocultarDelete?>" width="24"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
</thead>
<tbody>
<?php
if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$fechahora = explode(' ', $row_lista['fecha_hora']);

echo '<tr>';
echo '<td class="align-middle text-center"><b>'.$row_lista['detalle'].'</b></td>';
echo '<td class="align-middle text-center">'.FormatoFecha($fechahora[0]).', '.date("g:i a",strtotime($fechahora[1])).'</td>';
echo '<td class="text-center align-middle"><a class="pointer" href="../../../../archivos/'.$row_lista['factura'].'" download><img src="'.RUTA_IMG_ICONOS.'pdf.png"></a></td>';
echo '<td class="text-center align-middle '.$ocultarDelete.'"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarFactura('.$IdReporte.','.$id.')"></td>';
echo '</tr>';

}
}else{
echo "<tr><td colspan='4' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>

</div>