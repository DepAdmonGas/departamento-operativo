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


<div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Importación</a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Bitácora aditivo (<?=$estacion;?>)</li>
  </ol>
  </div>

  <div class="row">
  <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
  <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Bitácora Aditivo (<?=$estacion;?>)</h3>
  </div>

  <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
  <div class="dropdown d-inline">
  <button type="button" class="btn dropdown-toggle btn-primary float-end" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
  <i class="fa-solid fa-screwdriver-wrench"></i></span>
  </button>

  <ul class="dropdown-menu">  
  <li onclick="SelReporte(<?=$idEstacion;?>)"><a class="dropdown-item pointer">  <i class="fa-regular fa-file-lines"></i> Reporte de aditivo</a></li>
  <li onclick="SelInventario(<?=$idEstacion;?>)"><a class="dropdown-item pointer">  <i class="fa-solid fa-bottle-droplet"></i> Inventario de aditivo</a></li>
  </ul>
  </div>

  </div>

  </div>

  <hr>
  </div>

<div class="table-responsive">
<table id="tabla_aditivo_<?=$idEstacion?>" class="custom-table" style="font-size: 12.5px;" width="100%">

<thead class="tables-bg">
	<th class="align-middle text-center">#</th>
	<th class="align-middle text-center">Folio</th>
	<th class="align-middle text-center">Fecha</th>
	<th class="align-middle text-center">No. Factura</th>
	<th class="align-middle text-center">Producto</th>
	<th class="align-middle text-center">Galones</th>
	<th class="align-middle text-center">Fisico</th>
</thead>

<tbody class="bg-white">
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
<th class="align-middle text-center">'.$row_lista['id'].'</th>
<td class="align-middle text-center">00'.$row_lista['folio'].'</td>
<td class="align-middle ">'.$ClassHerramientasDptoOperativo->FormatoFecha($row_lista['fecha']).'</td>
<td class="align-middle text-center">'.$row_lista['no_factura'].'</td>
<td class="align-middle text-center">'.$row_lista['producto'].'</td>
<td class="align-middle text-center"><b>'.$row_lista['galones'].'</b></td>
<td class="align-middle text-center">'.$row_lista['inventario_fisico'].'</td>
</tr>';
}
}

?>	
</tbody>
</table>
</div>
