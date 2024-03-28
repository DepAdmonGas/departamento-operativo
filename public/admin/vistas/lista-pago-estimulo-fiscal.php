<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];

$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
}
?>

<div class="border-0 p-3">

<?php if ($session_nompuesto != "Contabilidad" && $session_nompuesto != "Comercializadora" && $session_nompuesto != "Dirección de operaciones servicio social") { ?>

<div class="row">
<div class="col-12">

<img class="float-end pointer" onclick="btnModal(<?=$idEstacion;?>)" src="<?=RUTA_IMG_ICONOS;?>agregar.png">

</div>
</div>

<hr>
<?php } ?>


<div class="table-responsive">
<table class="table table-sm table-bordered mb-0" style="font-size: 0.9em">
<thead class="tables-bg">
	<tr>
		<th class="text-center align-middle" colspan="3">Periodo</th>
		<th class="text-center align-middle" colspan="2">Pago</th>
		<th class="text-center align-middle" colspan="2">Complemento</th>
		<td colspan="2"></td>
	</tr>
<tr>
<th class="align-middle text-center">ID</th>
<th class="align-middle text-center">FECHA INICIO</th>
<th class="align-middle text-center">FECHA TERMINO</th>
<th class="align-middle text-center" width="24"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
<th class="align-middle text-center" width="24"><img src="<?=RUTA_IMG_ICONOS;?>xml.png"></th>
<th class="align-middle text-center" width="24"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
<th class="align-middle text-center" width="24"><img src="<?=RUTA_IMG_ICONOS;?>xml.png"></th>
<th class="align-middle text-center" width="24"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
<th class="align-middle text-center" width="24"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
</tr>	
</thead>
<tbody>

<?php  

$sql_lista = "SELECT * FROM op_estimulo_fiscal_pago WHERE id_estacion = '".$idEstacion."' ORDER BY id desc ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];

if($row_lista['co_pdf'] == ""){
$coPDF = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png">';
}else{
$coPDF = '<a class="pointer" href="../archivos/'.$row_lista['co_pdf'].'" download><img src="'.RUTA_IMG_ICONOS.'pdf.png"></a>';	
}

if($row_lista['co_xml'] == ""){
$coXML = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png">';
}else{
$coXML = '<a class="pointer" href="../archivos/'.$row_lista['co_xml'].'" download><img src="'.RUTA_IMG_ICONOS.'xml.png"></a>';	
}

echo '<tr>
<td class="text-center align-middle"><b>'.$id.'</b></td>
<td class="text-center align-middle">'.FormatoFecha($row_lista['fecha_inicio']).'</td>
<td class="text-center align-middle">'.FormatoFecha($row_lista['fecha_termino']).'</td>
<td class="text-center align-middle"><a class="pointer" href="../archivos/'.$row_lista['pdf'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png"></a></td>
<td class="text-center align-middle"><a class="pointer" href="../archivos/'.$row_lista['xml'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'xml.png"></a></td>
<td class="text-center align-middle">'.$coPDF.'</td>
<td class="text-center align-middle">'.$coXML.'</td>
<td class="text-center align-middle"><a class="pointer" onclick="Editar('.$id.','.$idEstacion.')"><img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png"></a></td>
<td class="text-center align-middle"><a class="pointer" onclick="Eliminar('.$id.','.$idEstacion.')"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png"></a></td>
</tr>';

}
}else{
echo "<tr><td colspan='9' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>

</tbody>
</table>
</div>	

</div>









