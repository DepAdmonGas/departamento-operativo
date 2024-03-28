<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];

$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
}

$sql_lista = "
          SELECT op_corte_year.id AS idYear, op_corte_year.id_estacion, op_corte_year.year, op_corte_mes.id AS idMes, op_corte_mes.mes FROM op_corte_year INNER JOIN op_corte_mes ON op_corte_year.id = op_corte_mes.id_year WHERE op_corte_year.id_estacion = '".$idEstacion."' ORDER BY op_corte_year.year DESC, op_corte_mes.mes DESC ";
          $result_lista = mysqli_query($con, $sql_lista);
          $numero_lista = mysqli_num_rows($result_lista);
?>


<div class="border-0 p-3">
<h5>Inventario inicial <?=$estacion;?> </h5>
<hr> 

<div class="table-responsive">
<table class="table table-bordered table-striped table-sm" >

<thead class="tables-bg">
<tr>
<th class="text-center">#</th>
<th class="text-center">AÑO</th>
<th class="text-center">MES</th>
<th class="text-center" width="24px"></td>
</tr>

</thead>

<tbody>
<?php
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['idMes'];
echo '<tr>';
echo '<td class="text-center">'.$id.'</td>';
echo '<td class="text-center">'.$row_lista['year'].'</td>';
echo '<td class="text-center">'.nombremes($row_lista['mes']).'</td>';
echo '<td class="text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'aceite-24.png" onclick="InventarioInicial('.$idEstacion.','.$id.')"></td>';
echo '</tr>';
}
?>	
</tbody>
</table>
</div>


</div>

