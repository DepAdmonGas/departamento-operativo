<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$idRefaccion = $_GET['idRefaccion'];

$sql_lista = "SELECT * FROM op_refacciones WHERE id = '".$idRefaccion."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$nombre = !empty($row_lista['nombre']) ? $row_lista['nombre'] : 'S/I';
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
<div class="col-12 mb-3">
<h6 class="mb-2 text-secondary ">Refacción:</h6>
<?php if($imagen != ""){ ?>
<div class="border p-1 text-center"><img src="<?=RUTA_ARCHIVOS;?><?=$imagen;?>" width="200px"></div>
<?php }else{ ?>
<div class="">Sin información</div>
<?php } ?>
</div>

<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
<h6 class="mb-2 text-secondary ">Nombre Refacción:</h6>
<div class=""><?=$nombre;?></div>
</div>

<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
<h6 class="mb-2 text-secondary ">Unidades:</h6>
<div class=""><?=$unidad;?></div>
</div>

<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
<h6 class="mb-2 text-secondary ">Agregar Unidades:</h6>
<input type="number" name="" class="form-control rounded-0" id="Unidades">
</div>

<?php 

$sql_lista = "SELECT * FROM op_refacciones_unidades WHERE id_refaccion = '".$idRefaccion."' ORDER BY id ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>

<div class="col-12 ">
<div class="table-responsive">
<table class="custom-table" style="font-size: 12.5px;" width="100%">
<thead class="tables-bg">
  <tr>
  <th class="text-center align-middle">#</th>
  <th class="text-center align-middle">Fecha y hora</th>
  <th class="text-center align-middle">Unidades</th>
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

echo '<tr>';
echo '<th class="align-middle text-center">'.$num.'</th>';
echo '<td class="align-middle text-center">'.$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.date('g:i a', strtotime($explode[1])).'</td>';
echo '<td class="align-middle text-center"><b>'.$row_lista['unidad'].'</b></td>';
echo '<td class="align-middle text-center"><img width="18px" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarUnidad('.$idEstacion.','.$id.','.$idRefaccion.')"></td>';
echo '</tr>';
$num++;
}
}else{
echo "<tr><th colspan='8' class='text-center text-secondary fw-normal no-hover2'><small>No se encontró información para mostrar </small></th></tr>";
}
?>
</tbody>
</table>
</div>
</div>

</div>
</div>

<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-success" onclick="AgregarPiezas(<?=$idEstacion;?>,<?=$idRefaccion;?>)">
<span class="btn-label2"><i class="fa fa-check"></i></span>Agregar</button>


</div>