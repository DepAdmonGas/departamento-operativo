<?php
require('../../../app/help.php');

$sql_lista = "SELECT * FROM op_papeleria_lista WHERE estatus = 1 ORDER BY producto ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
?>


<div class="border-0 p-3">

<div class="row">

<div class="col-10">
<h5>Catálogo de papeleria</h5>
</div>


<div class="col-2">
<img class="float-end pointer" src="<?=RUTA_IMG_ICONOS;?>agregar.png" onclick="ModalNevo()"> 
</div>
</div>

<hr>


<div class="table-responsive">
<table class="table table-sm table-bordered table-hover">
<thead class="tables-bg">
  <th class="text-center align-middle font-weight-bold">#</th>
  <th class="align-middle font-weight-bold">Producto</th>
  <th class="text-center align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
  <th class="text-center align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
</thead> 
<tbody>
<?php
if ($numero_lista > 0) {
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];

echo '<tr>';
echo '<td class="align-middle text-center">'.$num.'</td>';
echo '<td class="align-middle"><b>'.$row_lista['producto'].'</b></td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="EditarProducto('.$id.')"></td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarProducto('.$id.')"></td>';
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

</div>