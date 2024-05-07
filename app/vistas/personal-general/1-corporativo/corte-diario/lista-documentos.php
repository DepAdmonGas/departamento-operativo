<?php
require('../../../../help.php');

$idReporte = $_GET['idReporte'];

$sql_lista = "SELECT * FROM op_corte_dia_archivo WHERE id_reportedia = '".$idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
    
?>    

<div class="table-responsive">
<table style="font-size: .9em;" class="table table-sm table-bordered mb-0">
<thead class="tables-bg">
<tr>
<th class="text-center align-middle">Documento</th>
<th class="text-center align-middle" width="24px"><img src="<?=RUTA_IMG_ICONOS;?>descargar.png"></th>
<th class="text-center align-middle" width="24px"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
</tr>
</thead>
<tbody>
<?php
if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
  $eliminar = '<a onclick="EliminarDoc('.$id.', '.$idReporte.')"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png"></a>';
echo "<tr>";
echo "<td class='align-middle'>".$row_lista['detalle']."</td>";
echo '<td width="24px"><a href="../../../archivos/'.$row_lista['documento'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'descargar.png"></a></td>';
echo '<td width="24px">'.$eliminar.'</td>';
echo "</tr>";

}
}else{
echo "<tr><td colspan='3' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table> 
</div>