<?php
require('../../../app/help.php');

$sql_lista = "SELECT * FROM op_modelo_negocio";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);	

?>

<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0" style="">
<thead class="tables-bg">
 <tr>
  <th class="text-center align-middle tableStyle font-weight-bold">#</th>
  <th class="align-middle text-center tableStyle font-weight-bold">Fecha Hora</th>
  <th class="align-middle text-center tableStyle font-weight-bold">Titulo</th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-firmar-w.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
  </tr>
</thead> 
<tbody>
<?php
if ($numero_lista > 0) {

while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$Explode = explode(" ", $row_lista['fecha_hora']);

echo '<tr>';
echo '<td class="align-middle text-center">'.$row_lista['id'].'</td>';
echo '<td class="align-middle text-center">'.FormatoFecha($Explode[0]).'</td>';
echo '<td class="align-middle text-center">'.$row_lista['titulo'].'</td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" onclick="Firmar('.$row_lista['id'].')"></td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="Editar('.$row_lista['id'].', 2)"></td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$row_lista['id'].')"></td>';
echo '</tr>';

}
}else{
echo "<tr><td colspan='7' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>