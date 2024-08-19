<?php
require('../../../app/help.php');

$sql_lista = "SELECT * FROM op_modelo_negocio";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);	

?>

<div class="table-responsive">
  <table id="tabla-principal" class="custom-table " style="font-size: .8em;" width="100%">
    <thead class="tables-bg">
 <tr>
  <th class="text-center align-middle">#</th>
  <th class="align-middle text-center">Fecha Hora</th>
  <th class="align-middle text-center">Titulo</th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-firmar-w.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
  </tr>
</thead> 
<tbody class="bg-white">
<?php
if ($numero_lista > 0) {

while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$Explode = explode(" ", $row_lista['fecha_hora']);

echo '<tr>';
echo '<th class="align-middle text-center">'.$row_lista['id'].'</th>';
echo '<td class="align-middle text-center">'.FormatoFecha($Explode[0]).'</td>';
echo '<td class="align-middle text-center">'.$row_lista['titulo'].'</td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" onclick="Firmar('.$row_lista['id'].')"></td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="Editar('.$row_lista['id'].', 2)"></td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$row_lista['id'].')"></td>';
echo '</tr>';

}
}else{
echo "<tr><th colspan='7' class='text-center text-secondary'><small>No se encontró información para mostrar </small></th></tr>";
}
?>
</tbody>
</table>
</div>