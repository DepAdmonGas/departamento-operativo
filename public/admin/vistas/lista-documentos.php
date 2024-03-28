<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];

$sql_lista = "SELECT * FROM op_corte_dia_archivo WHERE id_reportedia = '".$idReporte."' ";
    $result_lista = mysqli_query($con, $sql_lista);
    
?>    
<div class="table-responsive">
<table style="font-size: .9em;" class="table table-sm table-bordered mb-0">
<thead class="tables-bg">
<tr>
<th class="text-center align-middle">DOCUMENTO</th>
<th class="text-center align-middle" width="24px"></th>
</tr>
</thead>
<tbody>
<?php
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

echo "<tr>";
echo "<td class='align-middle'>".$row_lista['detalle']."</td>";
echo '<td width="24px"><a href="../../../../archivos/'.$row_lista['documento'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'descargar.png"></a></td>';
echo "</tr>";

}
?>
</tbody>
</table> 
</div>