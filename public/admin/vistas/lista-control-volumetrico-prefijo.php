<?php
require('../../../app/help.php');

$IdReporteYear = $_GET['IdReporteYear'];
$GET_mes = $_GET['GET_mes'];
$IdReporte = $_GET['IdReporte'];
$idEstacion = $_GET['idEstacion'];

$sql_lista = "SELECT * FROM op_control_volumetrico_prefijos WHERE id_mes = '".$IdReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>


<div class="border p-3 mb-3">

<div><b>PREFIJOS Y SERIES DE FACTURACIÓN</b></div>
<hr>

<div class="table-responsive">
<table class="table table-sm table-bordered table-striped table-hover mb-0 pb-0" style="font-size: .90em">
<thead class="tables-bg">
<tr>
<th>SERIE</th>
<th>DETALLE</th>
<th class="text-end">TOTAL</th>
</tr> 
</thead> 
<tbody>
<?php
if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];

if($row_lista['total'] == 0){
$total = "";
}else{
$total = $row_lista['total'];	
}
echo '<tr>';
echo '<td>'.$row_lista['serie'].'</td>';
echo '<td>'.$row_lista['descripcion'].'</td>';
echo '<td class="text-end p-0 pb-0 mb-0">
$ <input type="number" id="Total'.$id.'" step="any" style="width: 90%;" class="text-end border-0 font-weight-light pt-1 pb-1" value="'.$total.'" onkeyup="EditPrefijo('.$id.','.$IdReporte.','.$IdReporteYear.','.$GET_mes.','.$idEstacion.')"></td>';
echo '</tr>';
}
}else{
echo "<tr><td colspan='3' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>

</div>