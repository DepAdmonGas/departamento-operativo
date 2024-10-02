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


  <div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Importación</a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Inventario de aditivo (<?=$estacion;?>)</li>
  </ol>
  </div>

  <div class="row">
  <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
  <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Inventario de Aditivo (<?=$estacion;?>)</h3>
  </div>

  <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">

  <div class="text-end">
  <div class="dropdown d-inline ms-2 <?=$ocultarbtnEn?>">
  <button type="button" class="btn dropdown-toggle btn-primary" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
  <i class="fa-solid fa-screwdriver-wrench"></i></span>
  </button>

  <ul class="dropdown-menu">
  <li onclick="ModalAgregar(<?=$idEstacion;?>)"><a class="dropdown-item pointer">  <i class="fa-solid fa-plus text-dark"></i> Agregar Aditivo</a></li>
  <li onclick="SelBitacoraReturn(<?=$idEstacion;?>)"><a class="dropdown-item pointer"> <i class="fa-solid fa-arrow-left"></i> Regresar</a></li>
  </ul>
  </div>
  </div>

  </div>
  </div>

  <hr>
  </div>

  <?php
  $sql_aditivo_hist = "SELECT * FROM op_inventario_aditivo_hist WHERE id_estacion = '".$idEstacion."' ORDER BY id desc ";
  $result_aditivo_hist = mysqli_query($con, $sql_aditivo_hist);
  $numero_aditivo_hist = mysqli_num_rows($result_aditivo_hist);
  ?>

  <div class="row">

  <div class="col-6 mb-1">
  <div class="alert title-table-bg text-center p-1" role="alert">
  Inventario (Gasolina Hitec 6590C): <strong><?=$gasolina;?></strong> Galones
  </div>
  </div>

  <?php
  if ($Session_ProductoTres != "") {
  ?>
  <div class="col-6 mb-1">
  <div class="alert title-table-bg text-center p-1" role="alert">
  Inventario (Diesel Hitec 4133G): <strong><?=$diesel;?></strong> Galones
  </div>
  </div>
  <?php
  }
  ?>
  </div>
  
<div class="table-responsive">
<table id="tabla_inventario_aditivo_<?=$idEstacion?>" class="custom-table" style="font-size: 12.5px;" width="100%">


<thead class="tables-bg">
	<tr>
	<th class="align-middle text-center">#</th>
	<th class="align-middle text-center">Fecha</th>
	<th class="align-middle text-center">Aditivo</th>
  <th class="align-middle text-center">Galones</th>
  <th class="align-middle text-center">Detalle</th>
  </tr>
</thead>

<tbody class="bg-white">

<?php
if ($numero_aditivo_hist > 0) {
while($row_aditivo_hist = mysqli_fetch_array($result_aditivo_hist, MYSQLI_ASSOC)){
$aditivo = $row_aditivo_hist['aditivo'];
$galones = $row_aditivo_hist['galones'];
$fecha = explode(" ", $row_aditivo_hist['fecha']);
$detalle = $row_aditivo_hist['detalle'];
echo '<tr>
<th class="text-center">'.$row_aditivo_hist['id'].'</th>
<td class="text-center">'.$ClassHerramientasDptoOperativo->FormatoFecha($fecha[0]).'</td>
<td class="text-center">'.$aditivo.'</td>
<td class="text-center">'.$galones.' <small>Galones</small></td>
<td class="text-center">'.$detalle.'</td>
</tr>';
}
}
?>

</tbody>
</table>
</div>


