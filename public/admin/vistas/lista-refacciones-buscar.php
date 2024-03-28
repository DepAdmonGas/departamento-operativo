<?php
require('../../../app/help.php');

$Buscar = $_POST['Buscar'];
$idEstacion = $_POST['idEstacion'];
$idArea = $_POST['idArea'];

if($idArea == 0){
$buscarArea = "";
}else{
$buscarArea = 'AND area = '.$idArea;
}

if($Buscar != ""){
$Like = " AND (nombre like '%".$Buscar."%' OR modelo like '%".$Buscar."%' OR marca like '%".$Buscar."%' OR proveedor like '%".$Buscar."%')";  
}else{
$Like = "";
}
 
$sql_lista = "SELECT * FROM op_refacciones WHERE status = 1 AND id_estacion = '".$idEstacion."' $Like $buscarArea ORDER BY id ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>

 
<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0" style="font-size: .9em;">
<thead class="tables-bg">
  <tr>
  <th class="text-center align-middle tableStyle font-weight-bold">#</th>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Descripción (Factura)</b></td>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Nombre genérico </b></td>
  <th class="text-center align-middle tableStyle font-weight-bold">Modelo</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Marca</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Proveedor</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Contacto</th>
    <td class="text-center align-middle tableStyle font-weight-bold"><b>Área</b></td>


  <th class="text-center align-middle tableStyle font-weight-bold">Unidades</th>

  <th class="text-center align-middle tableStyle font-weight-bold">Estado</th>

  <th class="text-center align-middle tableStyle font-weight-bold">Costo por unidad</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Total</th>
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
