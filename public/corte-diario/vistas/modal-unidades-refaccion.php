<?php
require('../../../app/help.php');

$idRefaccion = $_GET['idRefaccion'];

$sql_lista = "SELECT * FROM op_refacciones WHERE id = '".$idRefaccion."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$nombre = $row_lista['nombre'];
$imagen = $row_lista['imagen'];
$unidad = $row_lista['unidad'];
$costo = $row_lista['costo'];

$total = $unidad * $costo;
}

?>
<div class="modal-header">
<h5 class="modal-title">Agregar unidades a Refacción</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
<div class="row">

<div class="col-12"> 
<div class="table-responsive">
<table class="custom-table" style="font-size: 12.5px;" width="100%">
<thead class="tables-bg">
<tr> <th class="align-middle text-center" colspan="2">Refacción</th> </tr>
</thead>

<tbody class="bg-light">
<tr>
<th class="align-middle text-center fw-normal no-hover2"><b>Nombre Refacción:</b> <br><?=$nombre;?></th>
<th class="align-middle text-center fw-normal no-hover2"><b>Unidades:</b> <br><?=$unidad;?></th>

</tr>

<tr>
<th colspan="2" class="align-middle text-center no-hover2"><img src="archivos/<?=$imagen;?>" width="100%" height="200px"></th>
</tr>
<tr>
<th class="align-middle text-center fw-normal p-0 no-hover2"><input type="number" name="" class="form-control rounded-0 border-0 bg-light" id="Unidades" value="0"></th>
<th class="align-middle text-center fw-normal p-0 no-hover2" width="200px">
<button type="button" class="btn btn-labeled2 btn-success" onclick="AgregarPiezas(<?=$idRefaccion;?>)">
<span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar unidades</button>
</th>

</tr>

</tbody>
</table>
</div>
</div>

</div>
 
<hr>


<?php 

$sql_lista = "SELECT * FROM op_refacciones_unidades WHERE id_refaccion = '".$idRefaccion."' ORDER BY id ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>

<div class="table-responsive">
<table class="custom-table" style="font-size: .7em;" width="100%">

<thead class="tables-bg">
  <tr>
  <th class="text-center align-middle tableStyle font-weight-bold">#</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Fecha y hora</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Unidades</th>
  <th class="align-middle text-center" width="18px"><img width="18px" src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
  </tr>
</thead> 
<tbody class="bg-light">
<?php
if ($numero_lista > 0) {
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];

$explode = explode(" ", $row_lista['fechacreacion']);

echo '<tr >';
echo '<th class="align-middle text-center">'.$num.'</th>';
echo '<td class="align-middle text-center">'.FormatoFecha($explode[0]).', '.date('g:i a', strtotime($explode[1])).'</td>';
echo '<td class="align-middle text-center"><b>'.$row_lista['unidad'].'</b></td>';
echo '<td class="align-middle text-center"><img class="pointer" width="18px" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarUnidad('.$id.','.$idRefaccion.')"></td>';
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


