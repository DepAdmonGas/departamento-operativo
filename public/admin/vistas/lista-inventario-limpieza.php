<?php
require('../../../app/help.php');
$idEstacion = $_GET['idEstacion'];

$sql_lista = "SELECT * FROM op_inventario_limpieza WHERE id_estacion = '".$idEstacion."' AND status = 1 ORDER BY id ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
}

function Producto($idProducto, $con){

$sql_listaestacion = "SELECT producto FROM op_limpieza_lista WHERE id = '".$idProducto."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$producto = $row_listaestacion['producto'];
}
$result = array('producto' => $producto);

return $result;
}
?> 




<div class="border-0 p-3">


    <div class="row">

    <div class="col-xl-11 col-lg-11 col-md-11 col-sm-12">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="SelEstacionReturn(<?=$idEstacion;?>)"> 
    <div class="row">

    <div class="col-12">
    <h5>Inventario <?=$estacion;?></h5>
    </div>

    </div>

    </div>

    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12">
    <img class="float-end pointer" src="<?=RUTA_IMG_ICONOS;?>agregar.png" onclick="ModalNevoInventario(<?=$idEstacion;?>)">
    </div>

    </div>

<hr>



<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0" style="font-size: .9em;">
<thead class="tables-bg">
  <th class="text-center align-middle font-weight-bold"><b>#</b></th>
  <th class="text-center align-middle font-weight-bold"><b>Producto</b></th>
  <th class="text-center align-middle font-weight-bold"><b>Piezas</b></th>
  <th class="text-center align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
</thead> 
<tbody>
<?php
if ($numero_lista > 0) {
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];

$Producto = Producto($row_lista['id_producto'], $con);


echo '<tr>';
echo '<td class="align-middle text-center">'.$num.'</td>';
echo '<td class="align-middle text-center"><b>'.$Producto['producto'].'</b></td>';
echo '<td class="align-middle text-center">'.$row_lista['piezas'].'</td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarInventario('.$id.','.$idEstacion.')"></td>';
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