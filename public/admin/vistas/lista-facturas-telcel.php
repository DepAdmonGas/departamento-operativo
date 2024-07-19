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


<div class="table-responsive">
<table class="custom-table" style="font-size: .8em;" width="100%">
<thead class="tables-bg">

<tr>
<th colspan="5" class="text-center">FACTURA</th>
</tr>

<tr class="title-table-bg">
<td class="text-center align-middle fw-bold">DETALLE</td>
<th class="align-middle text-center">FECHA Y HORA</th>
<th class="align-middle text-center" width="24"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
<td class="text-center align-middle <?=$ocultarDelete?>" width="24"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></td>
</thead>

<tbody class="bg-white">
<?php
if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$fechahora = explode(' ', $row_lista['fecha_hora']);

echo '<tr>';
echo '<th class="align-middle text-center">'.$row_lista['detalle'].'</th>';
echo '<td class="align-middle text-center">'.FormatoFecha($fechahora[0]).', '.date("g:i a",strtotime($fechahora[1])).'</td>';
echo '<td class="text-center align-middle"><a class="pointer" href="'.RUTA_ARCHIVOS.''.$row_lista['factura'].'" download><img src="'.RUTA_IMG_ICONOS.'pdf.png"></a></td>';
echo '<td class="text-center align-middle '.$ocultarDelete.'"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarFactura('.$IdReporte.','.$id.')"></td>';
echo '</tr>';

}
}else{
echo "<tr><th colspan='5' class='text-center text-secondary fw-normal'><small>No se encontró información para mostrar </small></th></tr>";
}

?>
</tbody>
</table>
</div>

