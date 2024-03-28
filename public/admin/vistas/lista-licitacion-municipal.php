<?php
require('../../../app/help.php');

$idYear = $_GET['idYear'];

$sql_lista = "SELECT * FROM op_licitacion_municipal WHERE year = '".$idYear."' ORDER BY fecha ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>    


<div class="table-responsive">

<table class="table table-sm table-bordered table-hover mb-0" style="font-size: .9em;">
<thead class="tables-bg">
  <tr>
  <th class="text-center align-middle tableStyle font-weight-bold" width="40">No.</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Fecha</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Nombre del formato</th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>ver-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
  </tr>
</thead> 

<tbody>
<?php 
$i = 1;
if ($numero_lista > 0) {
while($row = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$GET_idLicitacion = $row['id'];


if($row['archivo'] != ""){
$PDF = '<a href="'.RUTA_ARCHIVOS.'licitacion-municipal/'.$row['archivo'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png"></a>';
}else{
$PDF = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png">';
}  

echo '<tr class="text-center align-middle">
<td>'.$i.'</td>
<td>'.FormatoFecha($row['fecha']).'</td>
<td>'.$row['nombre_formato'].'</td>
<td>'.$PDF.'</td>
<td><img class="pointer" onclick="DetalleLicitacion('.$GET_idLicitacion.')" src="'.RUTA_IMG_ICONOS.'ver-tb.png"></td>
<td><img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="EditarLicitacion('.$GET_idLicitacion.')"></td>
<td><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarLicitacion('.$idYear.','.$GET_idLicitacion.')"></td>

</tr>';
$i++;
}
}else{
echo "<tr><td colspan='7' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>

</div>