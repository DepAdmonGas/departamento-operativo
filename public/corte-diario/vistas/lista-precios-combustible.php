 <?php
require('../../../app/help.php');

$year = $_GET['year'];
$mes = $_GET['mes'];

$sql_lista = "SELECT * FROM op_formato_precios WHERE year = '".$year."' AND mes = '".$mes."' AND estatus = 1 ORDER BY fecha ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>
   
<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0" style="font-size: .9em;">
<thead class="tables-bg">

  <th class="text-center align-middle font-weight-bold" width="40">#</th>
  <th class="align-middle font-weight-bold">Fecha</th>
  <th class="text-center align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>ver-tb.png"></th>


</thead> 
<tbody>

<?php
if ($numero_lista > 0) {
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$estado = $row_lista['estatus'];

if($estado == 0){
$TrColor = 'table-warning';
}else{
$TrColor = '';
}


echo '<tr class="'.$TrColor.'">';
echo '<td class="align-middle text-center" onclick="Detalle('.$id.')">'.$num.'</td>';
echo '<td class="align-middle">'.FormatoFecha($row_lista['fecha']).'</td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png"  onclick="Detalle('.$id.')"></td>';

echo '</tr>';

$num++;
}
}else{
echo "<tr><td colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>  
</div>