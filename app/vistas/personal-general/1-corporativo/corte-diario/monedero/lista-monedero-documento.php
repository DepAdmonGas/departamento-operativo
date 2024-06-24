<?php
require('../../../../../help.php');

$IdReporte = $_GET['IdReporte'];

$sql_lista = "SELECT * FROM op_monedero_documento WHERE id_mes = '".$IdReporte."' ORDER BY id desc";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
?>
 

<div class="table-responsive">
    <table class="custom-table mt-2" style="font-size: .75em;" width="100%">
        <thead class="navbar-bg">
	<th class="align-middle text-center">FECHA</th>
	<th class="align-middle text-center">MONEDERO</th>
	<th class="align-middle text-end">DIFERENCIA</th>	
	<th class="align-middle text-center" width="24"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
	<th class="align-middle text-center" width="24"><img src="<?=RUTA_IMG_ICONOS;?>xml.png"></th>
	<th class="align-middle text-center" width="24"><img src="<?=RUTA_IMG_ICONOS;?>excel.png"></th>
	<th class="align-middle text-end">EDI</th>
	<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
</thead>
<tbody class="bg-light">
<?php
if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

if ($session_nompuesto != "Contabilidad" && $session_nompuesto != "Dirección de operaciones servicio social") {
$eliminar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$IdReporte.','.$row_lista['id'].')">';
}else{
$eliminar = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" >';
}

if ($row_lista['excel'] == "") {

$excel = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png">';

}else{

$excel = '<a href="../../archivos/'.$row_lista['excel'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'excel.png"></a>';

}

echo '<tr>';
echo '<th class="text-start">'.$ClassHerramientasDptoOperativo->FormatoFecha($row_lista['fecha']).'</th>';
echo '<td class="align-middle text-center">'.$row_lista['monedero'].'</td>';
echo '<td class="align-middle text-end">$ '.number_format($row_lista['diferencia'],2).'</td>';
echo '<td><a href="../../archivos/'.$row_lista['pdf'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png"></a></td>';
echo '<td><a href="../../archivos/'.$row_lista['xml'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'xml.png"></a></td>';
echo '<td width="20">'.$excel.'</td>';
echo '<td width="20"><img class="pointer" src="'.RUTA_IMG_ICONOS.'descargar.png" onclick="Edi('.$IdReporte.','.$row_lista['id'].')"></td>';
echo '<td width="20"><img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="Editar('.$IdReporte.','.$row_lista['id'].')"></td>';
echo '</tr>';

}
}else{
echo "<tr><th colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar </small></th></tr>";	
}
?>
</tbody>
</table>
</div>