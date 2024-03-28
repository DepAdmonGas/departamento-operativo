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


<div class="border-0 p-3">

<div class="row">

<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 mb-2">

<div><h5>Inventario <?=$estacion;?></h5></div>
<h6><?=$recuperacionvapores;?></h6>

</div> 
  
<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-2">

 
<div class="float-end">

<div class="btn-group dropleft">
  
<div class="dropdown ms-2">
  <button class="btn btn-info dropdown-toggle text-white" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
   ÁREAS
  </button>

  <ul class="dropdown-menu mb-2" >
    <li><a class="dropdown-item pointer" onclick="BuscarArea(0,<?=$idEstacion;?>)">TODAS</a></li>
       <?php 
            $sql_area = "SELECT id,nombre_area,abreviatura FROM op_rh_areas ";
            $result_area = mysqli_query($con, $sql_area);
            while($row_area = mysqli_fetch_array($result_area, MYSQLI_ASSOC)){
            $id = $row_area['id'];
            $area = $row_area['nombre_area'];
            $abreviatura = $row_area['abreviatura'];
            echo '<li><a class="dropdown-item pointer" onclick="BuscarArea('.$id.','.$idEstacion.')">'.$area.' - '.$abreviatura.'</a><li';
            }
             ?>
  </ul>

</div>

</div>

</div>


<div class="float-end">
<input type="text" class="form-control" placeholder="Buscar" oninput="Buscar(this,0,<?=$idEstacion;?>)">
</div>

</div>


</div>

 

<div class="border-0 ">

<div class="row">

<div class="col-12 mt-2 mb-0">

  <img src="<?=RUTA_IMG_ICONOS;?>agregar.png" class="float-end ms-2 pointer" onclick="Agregar(<?=$idEstacion;?>)">

  <img src="<?=RUTA_IMG_ICONOS;?>mantenimiento-tb.png" class="float-end ms-2 pointer" onclick="Mantenimiento(<?=$idEstacion;?>)">

</div>

</div>

<hr> 

<div id="BuscarRefacciones">


<div class="table-responsive">
<table class="table table-sm table-bordered table-hovermt-1" style="font-size: .9em;">
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
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Total</b></td>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>ver-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>mas-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
  </tr>
</thead> 
<tbody>
<?php
if ($numero_lista > 0) {
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];

$total = $row_lista['unidad'] * $row_lista['costo'];

if($row_lista['unidad'] == 0 || $row_lista['unidad'] == 1){
$trColor = "table-danger";  
}else if($row_lista['unidad'] == 2){
$trColor = "table-warning";
}else if($row_lista['unidad'] == 3){
$trColor = "table-success";
}else{
$trColor = "";
}
 
echo '<tr class="'.$trColor.'">';
echo '<td class="align-middle text-center">'.$num.'</td>';
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
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="ModalDetalle('.$idEstacion.','.$id.')"></td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'mas-tb.png" onclick="ModalMas('.$idEstacion.','.$id.')"></td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="ModalEditar('.$idEstacion.','.$id.')"></td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$idEstacion.','.$id.')"></td>';
echo '</tr>';

$TotalNeto = $TotalNeto + $total;

$num++;
}
echo "<tr>
<td colspan='10'></td>
<td class='text-end'><b>Total:</b></td>
<td class='text-end'><b>$ ".number_format($TotalNeto,2)."</b></td>
<td colspan='5'></td></tr>";
}else{
echo "<tr><td colspan='14' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}

?>
</tbody>
</table>
</div>

</div>

</div>

</div>