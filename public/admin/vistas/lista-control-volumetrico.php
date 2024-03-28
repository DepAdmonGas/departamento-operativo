<?php
require('../../../app/help.php');

$IdReporte = $_GET['IdReporte'];

$sql_lista = "SELECT * FROM op_control_volumetrico WHERE id_mes = '".$IdReporte."' ORDER BY id desc";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
?>
<?php if ($session_nompuesto != "Contabilidad" && $session_nompuesto != "Comercializadora" && $session_nompuesto != "Dirección de operaciones servicio social") { ?>

<div class="border mb-3">
<div class="p-3">

<div class="text-end">
<img class="pointer" src="<?=RUTA_IMG_ICONOS;?>agregar.png" onclick="btnModal()">
</div>
 
<?php } ?>

<hr> 

<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0 font-weight-light">
<thead class="tables-bg">
	<th class="align-middle text-center">FECHA</th>
	<th class="align-middle text-center">ANEXOS</th>	
	<th class="align-middle text-center" width="24">
	<img src="<?=RUTA_IMG_ICONOS;?>xml.png">
	</th>
	<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
</thead>
<tbody>
<?php
if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

if ($session_nompuesto != "Contabilidad" && $session_nompuesto != "Dirección de operaciones servicio social") {
$eliminar = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$IdReporte.','.$row_lista['id'].')">';
}else{
$eliminar = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" >';
}
 
$extension = pathinfo($row_lista['documento'], PATHINFO_EXTENSION);

if ($extension == "xml" || $extension == "XML") {
$icon = RUTA_IMG_ICONOS.'xml.png';
}else if ($extension == "pdf") {
$icon = RUTA_IMG_ICONOS.'pdf.png';
}else if ($extension == "xlsx") {
$icon = RUTA_IMG_ICONOS.'excel.png';
}else if ($extension == "zip" || $extension == "ZIP") {
$icon = RUTA_IMG_ICONOS.'zip.png';
}else if ($extension == "xlsx" || $extension == "xls") {
$icon = RUTA_IMG_ICONOS.'excel.png';
}

$fechahora = explode(' ', $row_lista['fecha_hora']);
echo '<tr>';
echo '<td class="align-middle">'.FormatoFecha($fechahora[0]).'</td>';
echo '<td class="align-middle">'.$row_lista['anexos'].'</td>';
echo '<td><a href="../../../../archivos/'.$row_lista['documento'].'" download><img src="'.$icon.'"></a></td>';
echo '<td width="20">'.$eliminar.'</td>';
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
</div>