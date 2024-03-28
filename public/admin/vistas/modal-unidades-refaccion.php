<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
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
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

<div class="row">
  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-2">
    <h6 class="mb-2 text-secondary ">Refacción:</h6>
    <div class="border p-1 text-center"><img src="../archivos/<?=$imagen;?>" width="150px"></div>
  </div>

  <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 mb-2">

<div class="row mt-4">
  <div class="col-9">
    <h6 class="mb-2 text-secondary ">Nombre Refacción:</h6>
    <div class=""><?=$nombre;?></div>
  </div>
    <div class="col-3">
    <h6 class="mb-2 text-secondary ">Unidades:</h6>
    <div class=""><?=$unidad;?></div>
  </div>
</div>

<hr>
<h6 class="mb-2 text-secondary ">Agregar Unidades:</h6>
<input type="number" name="" class="form-control rounded-0" id="Unidades">

<div class="text-end mt-2">
<button type="button" class="btn btn-primary btn-sm rounded-0" onclick="AgregarPiezas(<?=$idEstacion;?>,<?=$idRefaccion;?>)">Agregar</button>
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

<table class="table table-sm table-bordered table-hover mb-0" style="font-size: .7em;">
<thead class="tables-bg">
  <tr>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>#</b></td>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Fecha y hora</b></td>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Unidades</b></td>
  <th class="align-middle text-center" width="18px"><img width="18px" src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
  </tr>
</thead> 
<tbody>
<?php
if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];

$explode = explode(" ", $row_lista['fechacreacion']);

echo '<tr>';
echo '<td class="align-middle text-center">'.$id.'</td>';
echo '<td class="align-middle text-center">'.FormatoFecha($explode[0]).', '.date('g:i a', strtotime($explode[1])).'</td>';
echo '<td class="align-middle text-center"><b>'.$row_lista['unidad'].'</b></td>';
echo '<td class="align-middle text-center"><img width="18px" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarUnidad('.$idEstacion.','.$id.','.$idRefaccion.')"></td>';
echo '</tr>';

}
}else{
echo "<tr><td colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>

</div>
