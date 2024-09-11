<?php
require('../../../app/help.php');

$IdReporte = $_GET['IdReporte'];

$sql_lista = "SELECT * FROM op_directorio WHERE id_mes = '".$IdReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if ($session_nompuesto == "Contabilidad"){
$ocultar = "d-none"; 
}else{
$ocultar = ""; 	
}
 
?>

<div class="table-responsive">
<table class="custom-table" style="font-size: .8em;" width="100%">
<thead class="tables-bg">

<tr>
<th colspan="5" class="text-center">DIRECTORIO</th>
</tr>

<tr class="title-table-bg">
<td class="text-center align-middle fw-bold">CUENTA</td>
<th class="text-center align-middle">PUESTO</th>
<th class="text-center align-middle">CLAVE</th>
<th class="align-middle text-center <?=$ocultar?>" width="24"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
<td class="align-middle text-center <?=$ocultar?>" width="24"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></td>
</tr>
</thead>

<tbody class="bg-white">
<?php
if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

if ($row_lista['clave'] == "") {
$fondo = "bg-light";
}else{
$fondo = "";
} 

echo '<tr class="'.$fondo.'">';
echo '<th class="align-middle text-center">'.$row_lista['cuenta'].'</th>';
echo '<td class="align-middle text-center">'.$row_lista['puesto'].'</td>';
echo '<td class="align-middle text-center">'.$row_lista['clave'].'</td>';
echo '<td class="text-center align-middle '.$ocultar.'"><img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="btnModalDirectorio('.$IdReporte.','.$row_lista['id'].')"></td>';
echo '<td class="text-center align-middle '.$ocultar.'"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$IdReporte.','.$row_lista['id'].')"></td>';
echo '</tr>';

}
}else{
echo "<tr><th colspan='5' class='text-center text-secondary fw-normal'><small>No se encontró información para mostrar </small></th></tr>";
}
?>
</tbody>
</table>
</div>

