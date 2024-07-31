<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$idArea = $_GET['idArea'];

$sql_lista = "SELECT * FROM op_refacciones WHERE id_estacion = '".$idEstacion."' AND area = '".$idArea."' AND status = 1 ORDER BY id ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

$sql_listaestacion = "SELECT localidad, recuperacion_vapores FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
$recuperacionvapores = $row_listaestacion['recuperacion_vapores'];
}

$sql_nom_area = "SELECT id,nombre_area FROM op_rh_areas WHERE id = '".$idArea."' ";
$result_nom_area = mysqli_query($con, $sql_nom_area);
while($row_nom_area = mysqli_fetch_array($result_nom_area, MYSQLI_ASSOC)){
$nombrearea = $row_nom_area['nombre_area'];
}
?>

 

<div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Importación</a></li>
  <li aria-current="page" class="breadcrumb-item active">Inventario <?= ucfirst(strtolower($nombrearea)) ?> (<?= $estacion; ?>)</li>
  </ol>
  </div>

  <div class="row">
  <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12">
  <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Inventario <?= ucfirst(strtolower($nombrearea)) ?> (<?= $estacion; ?>) </h3>
  <h6 class="text-secondary mt-1 mb-0 pb-0"><?=$recuperacionvapores;?></h6>
  </div>

  <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">

  <div class="text-end">

 <div class="dropdown d-inline ms-2 ">
 <button type="button" class="btn dropdown-toggle btn-info text-white" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">ÁREAS</span>
 </button>

  <ul class="dropdown-menu">
  <li onclick="BuscarArea(0,<?=$idEstacion;?>)"><a class="dropdown-item pointer">  <i class="fa-solid fa-list text-dark"></i> Todas</a></li>
  <?php 
  $sql_area = "SELECT id,nombre_area,abreviatura FROM op_rh_areas ";
  $result_area = mysqli_query($con, $sql_area);
  while($row_area = mysqli_fetch_array($result_area, MYSQLI_ASSOC)){
  $id = $row_area['id'];
  $area = $row_area['nombre_area'];
  $abreviatura = $row_area['abreviatura'];
  echo '<li onclick="BuscarArea('.$id.','.$idEstacion.')"><a class="dropdown-item pointer">('.$abreviatura.') '.$area.'</a></li>';
  }
  ?>
  </ul>

  </div>

  <!------- SEGUNDO OPCION ----->
  <div class="dropdown d-inline ms-2 ">
  <button type="button" class="btn dropdown-toggle btn-primary" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
  <i class="fa-solid fa-screwdriver-wrench"></i></span>
  </button>

  <ul class="dropdown-menu">
  <li onclick="Agregar(<?=$idEstacion;?>)"><a class="dropdown-item pointer"><i class="fa-solid fa-plus text-dark"></i> Agregar Refacción</a></li>
  <li onclick="Mantenimiento(<?=$idEstacion;?>)"><a class="dropdown-item pointer"><i class="fa-regular fa-file-lines"></i> Reporte de Refacciónes</a></li>
  <li onclick="Transaccion(<?=$idEstacion;?>)"><a class="dropdown-item pointer"><i class="fa-solid fa-shuffle"></i> Transacción de Refacciónes</a></li>

  </ul>
  </div>

  </div>

  </div>
  </div>

  <hr>
  </div>


<div class="table-responsive">
<table id="tabla_refacciones_<?=$idEstacion?>_<?=$idArea?>" class="custom-table" style="font-size: 12.5px;" width="100%"> 

<thead class="tables-bg">
  <tr>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>#</b></td>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Descripción (Factura)</b></td>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Nombre genérico </b></td>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Modelo</b></td>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Marca</b></td>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Proveedor</b></td>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Contacto</b></td>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Área</b></td>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Unidades</b></td>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Estado</b></td>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Costo por unidad</b></td>
  <td class="text-center align-middle" width="140px"><b>Total</b></td>
  <th class="align-middle text-center" width="20"><i class="fas fa-ellipsis-v"></i></th>
  </tr>
</thead> 

<tbody class="bg-white">
<?php
if ($numero_lista > 0) {
$num = 1;
$TotalNeto = 0;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];

$total = $row_lista['unidad'] * $row_lista['costo'];

if($row_lista['unidad'] == 0 || $row_lista['unidad'] == 1){
  $trColor = 'style="background-color: #ffb6af"'; 
  }else if($row_lista['unidad'] == 2){
  $trColor = 'style="background-color: #fcfcda"';
  }else if($row_lista['unidad'] == 3){
  $trColor = 'style="background-color: #b0f2c2"';
  }else{
  $trColor = "";
  } 
  
   
echo '<tr '.$trColor.'>';
echo '<th class="align-middle text-center">'.$num.'</th>';
echo '<td class="align-middle text-center"><b>'.$row_lista['descripcion_f'].'</b></td>';
echo '<td class="align-middle text-center"><b>'.$row_lista['nombre'].'</b></td>';
echo '<td class="align-middle text-center">'.$row_lista['modelo'].'</td>';
echo '<td class="align-middle text-center">'.$row_lista['marca'].'</td>';
echo '<td class="align-middle text-center">'.$row_lista['proveedor'].'</td>';
echo '<td class="align-middle text-center">'.$row_lista['contacto'].'</td>';

$sql_nom_area = "SELECT id,nombre_area,abreviatura FROM op_rh_areas WHERE id = '".$row_lista['area']."' ";
$result_nom_area = mysqli_query($con, $sql_nom_area);
$numero_nom_area = mysqli_num_rows($result_nom_area);

if($numero_nom_area > 0){

while($row_nom_area = mysqli_fetch_array($result_nom_area, MYSQLI_ASSOC)){
$area = $row_nom_area['nombre_area'];
$abreviatura = $row_nom_area['abreviatura'];

echo '<td class="align-middle text-center">'.$abreviatura.'</td>';

}

}else{
echo '<td class="align-middle text-center"></td>';
}

echo '<td class="align-middle text-center">'.$row_lista['unidad'].'</td>';

echo '<td class="align-middle text-center">'.$row_lista['estado_r'].'</td>';

echo '<td class="align-middle text-end">$ '.number_format($row_lista['costo'],2).'</td>';
echo '<td class="align-middle text-end"><b>$ '.number_format($total,2).'</b></td>';
echo '<td class="align-middle text-center">
<div class="dropdown">
<a class="btn btn-sm btn-icon-only text-dropdown-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
<i class="fas fa-ellipsis-v"></i>
</a>

<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
<a class="dropdown-item" onclick="ModalDetalle('.$idEstacion.','.$id.')"><i class="fa-regular fa-eye"></i> Detalle</a>
<a class="dropdown-item" onclick="ModalMas('.$idEstacion.','.$id.')"><i class="fa-solid fa-plus"></i> Agregar Unidades</a>
<a class="dropdown-item" onclick="ModalEditar('.$idEstacion.','.$id.')"><i class="fa-solid fa-pencil"></i> Editar</a>
<a class="dropdown-item" onclick="Eliminar('.$idEstacion.','.$id.')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>
</div>
</div>
</td>';
echo '</tr>';

$TotalNeto = $TotalNeto + $total;

$num++;
}
echo "<tr class='ultima-fila'>
<th colspan='10'></th>
<td class='text-end'><b>Total:</b></td>
<td class='text-end'><b>$ ".number_format($TotalNeto,2)."</b></td>
<td colspan='5'></td>
</tr>";
}

?>
</tbody>
</table>
</div>



