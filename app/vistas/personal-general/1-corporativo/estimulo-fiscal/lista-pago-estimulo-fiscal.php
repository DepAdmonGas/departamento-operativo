<?php
require('../../../../../app/help.php');
$idEstacion = $_GET['idEstacion'];

?>


<div class="table-responsive">
<table class="custom-table" style="font-size: 14px;" width="100%">

<thead>
<tr class="tables-bg">
<th class="text-center" colspan="3">Periodo</th>
<th class="text-center" colspan="2">Pago</th>
<th class="text-center" colspan="2">Complemento</th>
<th colspan="2"></th>
</tr>

<tr class="navbar-bg align-middle text-center">
<td class="align-middle text-center"><b>ID</b></td>
<th class="align-middle text-center">FECHA INICIO</th>
<th class="align-middle text-center">FECHA TERMINO</th>
<th class="align-middle text-center" width="24"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
<th class="align-middle text-center" width="24"><img src="<?=RUTA_IMG_ICONOS;?>xml.png"></th>
<th class="align-middle text-center" width="24"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
<th class="align-middle text-center" width="24"><img src="<?=RUTA_IMG_ICONOS;?>xml.png"></th>
<th class="align-middle text-center" width="24"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
<td class="align-middle text-center" width="24"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></td>
</tr>	
</thead>

<tbody class="bg-white">
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
$coPDF = '<a href="archivos/'.$row_lista['co_pdf'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png"></a>';	
}

if($row_lista['co_xml'] == ""){
$coXML = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png">';
}else{
$coXML = '<a href="archivos/'.$row_lista['co_xml'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'xml.png"></a>';	
}

echo '<tr>
<th class="text-center align-middle"><b>'.$id.'</b></th>
<td class="text-center align-middle">'.FormatoFecha($row_lista['fecha_inicio']).'</td>
<td class="text-center align-middle">'.FormatoFecha($row_lista['fecha_termino']).'</td>
<td class="text-center align-middle"><a href="archivos/'.$row_lista['pdf'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png"></a></td>
<td class="text-center align-middle"><a href="archivos/'.$row_lista['xml'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'xml.png"></a></td>
<td class="text-center align-middle">'.$coPDF.'</td>
<td class="text-center align-middle">'.$coXML.'</td>
<td class="text-center align-middle"><a onclick="Editar('.$id.','.$idEstacion.')"><img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png"></a></td>
<td class="text-center align-middle"><a onclick="Eliminar('.$id.','.$idEstacion.')"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png"></a></td>
</tr>';

}
}else{
echo "<tr><th colspan='9' class='text-center text-secondary'><small>No se encontró información para mostrar </small></th></tr>";
}
?>

</tbody>
</table>
</div>	






 