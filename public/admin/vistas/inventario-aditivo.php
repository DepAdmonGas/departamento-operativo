<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];

$sql_listaestacion = "SELECT nombre, producto_uno, producto_dos, producto_tres FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
$Session_ProductoUno = $row_listaestacion['producto_uno'];
$Session_ProductoDos = $row_listaestacion['producto_dos'];
$Session_ProductoTres = $row_listaestacion['producto_tres'];
}

$sql_aditivo = "SELECT * FROM op_inventario_aditivo WHERE id_estacion = '".$idEstacion."' ";
$result_aditivo = mysqli_query($con, $sql_aditivo);
while($row_aditivo = mysqli_fetch_array($result_aditivo, MYSQLI_ASSOC)){
$gasolina = $row_aditivo['gasolina'];
$diesel = $row_aditivo['diesel'];
}
?>

<div class="border-0 p-3">


    <div class="row mb-0">

    <div class="col-xl-11 col-lg-11 col-md-11 col-sm-12">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="SelBitacoraReturn(<?=$idEstacion;?>)">
    <div class="row">

    <div class="col-12">
    <h5>Inventario aditivo, <?=$estacion;?></h5>
    </div>

    </div>

    </div>

    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12">
    <img src="<?=RUTA_IMG_ICONOS."agregar.png";?>" class="float-end pointer" onclick="ModalAgregar(<?=$idEstacion;?>)"/>
    </div>

    </div>

<hr>


<?php
$sql_aditivo_hist = "SELECT * FROM op_inventario_aditivo_hist WHERE id_estacion = '".$idEstacion."' ORDER BY id desc ";
$result_aditivo_hist = mysqli_query($con, $sql_aditivo_hist);
$numero_aditivo_hist = mysqli_num_rows($result_aditivo_hist);
?>


<div class="table-responsive">
<table class="table table-sm table-bordered ">
<tbody>

<tr>
<td></td>
<td colspan="2">Inventario (Gasolina Hitec 6590C): <strong><?=$gasolina;?></strong> Galones</td>
<?php
if ($Session_ProductoTres != "") {
?>
<td colspan="2">
Inventario (Diesel Hitec 4133G): <strong><?=$diesel;?></strong> Galones
</td>
<?php
}
?>
</tr>
<?php
if ($numero_aditivo_hist > 0) {
  while($row_aditivo_hist = mysqli_fetch_array($result_aditivo_hist, MYSQLI_ASSOC)){
  $aditivo = $row_aditivo_hist['aditivo'];
  $galones = $row_aditivo_hist['galones'];
  $fecha = explode(" ", $row_aditivo_hist['fecha']);
  $detalle = $row_aditivo_hist['detalle'];
echo '<tr>
<td class="text-center">'.$row_aditivo_hist['id'].'</td>
<td class="text-center">'.FormatoFecha($fecha[0]).'</td>
<td class="text-center">'.$aditivo.'</td>
<td class="text-center">'.$galones.' <small>Galones</small></td>
<td class="text-center">'.$detalle.'</td>
</tr>';
}
}else{
echo '<tr><td colspan="4" class="text-center"><small>No se encontró información</small></td></tr>';
}
?>
</tbody>
</table>
</div>


</div>