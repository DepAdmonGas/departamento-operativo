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

$sql_lista = "SELECT * FROM op_bitacora_aditivo WHERE id_estacion = '".$idEstacion."' ORDER BY id desc";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>

<div class="border-0 p-3">
 
<div class="row">

  <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 ">
	<h5>Bitácora aditivo, <?=$estacion;?></h5>
  </div>

  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 ">

	<button type="button" class="btn btn-outline-primary btn-sm rounded-0 float-end ms-1" onclick="SelInventario(<?=$idEstacion;?>)">Inventario</button>
	<button type="button" class="btn btn-outline-info btn-sm rounded-0 float-end ms-2" onclick="SelReporte(<?=$idEstacion;?>)">Reporte</button>

</div>

</div>

<hr>

<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0 mt-1" style="font-size: 1em;">

<thead class="tables-bg">
	<th class="align-middle text-center">#</th>
	<th class="align-middle text-center">Folio</th>
	<th class="align-middle">Fecha</th>
	<th class="align-middle text-center">No. Factura</th>
	<th class="align-middle text-center">Producto</th>
	<th class="align-middle text-center">Galones</th>
	<th class="align-middle text-center">Fisico</th>
</thead>

<tbody>
<?php
if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['estado'];
if ($row_lista['estado'] == 0) {
$tableColor = "table-danger";
$iconCancelar = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png">';
}else{
$tableColor = "";
$iconCancelar = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$Session_IDEstacion.','.$id.')">';
}

echo '<tr class="'.$tableColor.'">
<td class="align-middle text-center">'.$row_lista['id'].'</td>
<td class="align-middle text-center">00'.$row_lista['folio'].'</td>
<td class="align-middle ">'.FormatoFecha($row_lista['fecha']).'</td>
<td class="align-middle text-center">'.$row_lista['no_factura'].'</td>
<td class="align-middle text-center">'.$row_lista['producto'].'</td>
<td class="align-middle text-center"><b>'.$row_lista['galones'].'</b></td>
<td class="align-middle text-center">'.$row_lista['inventario_fisico'].'</td>
</tr>';
}
}else{
echo "<tr><td colspan='7' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>	
</tbody>
</table>
</div>
</div>