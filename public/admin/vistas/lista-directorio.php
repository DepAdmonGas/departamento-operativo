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


<div class="border p-3">


<?php if ($session_nompuesto != "Contabilidad" && $session_nompuesto != "Comercializadora" && $session_nompuesto != "Dirección de operaciones servicio social") { ?>

<div class="text-end">
<img class="pointer" src="<?=RUTA_IMG_ICONOS;?>agregar.png" onclick="btnModalDirectorio(<?=$IdReporte;?>,0)">
</div>
<hr>

<?php } ?>


<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0" style="font-size: .8em;">
<thead class="tables-bg">
<tr>
<th colspan="5" class="text-center">DIRECTORIO</th>
</tr>
<tr>
<th class="text-center align-middle">CUENTA</th>
<th class="text-center align-middle">PUESTO</th>
<th class="text-center align-middle">CLAVE</th>
<th class="align-middle text-center <?=$ocultar?>" width="24"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
<th class="align-middle text-center <?=$ocultar?>" width="24"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
</tr>
</thead>
<tbody>
<?php
if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

if ($row_lista['clave'] == "N/A") {
$fondo = "bg-light";
}else{
$fondo = "";
} 

echo '<tr>';
echo '<td class="align-middle text-center font-weight-light">'.$row_lista['cuenta'].'</td>';
echo '<td class="align-middle text-center font-weight-light">'.$row_lista['puesto'].'</td>';
echo '<td class="align-middle text-center font-weight-light '.$fondo.'">'.$row_lista['clave'].'</td>';
echo '<td class="text-center align-middle '.$ocultar.'"><img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="btnModalDirectorio('.$IdReporte.','.$row_lista['id'].')"></td>';
echo '<td class="text-center align-middle '.$ocultar.'"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$IdReporte.','.$row_lista['id'].')"></td>';
echo '</tr>';

}
}else{
echo "<tr><td colspan='5' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>

</div>