<?php
require('../../../app/help.php');

$idEstacion = $Session_IDEstacion;

$sql_lista = "SELECT * FROM op_refacciones_transaccion WHERE id_estacion = '".$idEstacion."' OR id_estacion_receptora = '".$idEstacion."' ORDER BY id DESC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

$sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}

function Refaccion($idRefaccion,$con){
$sql = "SELECT nombre FROM op_refacciones WHERE id = '".$idRefaccion."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$nombre = $row['nombre'];
}
return $nombre;
}

function Estacion($idEstacion,$con){
$sql = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$estacion = $row['localidad'];
}

return $estacion;
}
?>

<div class="border-0">

<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0" style="font-size: .9em;">
<thead class="tables-bg">
  <tr>
  <th class="text-center align-middle tableStyle font-weight-bold">#</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Fecha y hora</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Refacción</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Piezas</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Estación proveedora</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Estación receptora</th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>ver-tb.png"></th>
  </tr>
</thead> 
<tbody>
<?php
if ($numero_lista > 0) {

while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$status = $row_lista['estado'];

if($status == 0){
$tableColor = "table-warning";
}else if($status == 1){
$tableColor = "";
}else if($status == 2){
$tableColor = "table-primary";
}

$explode = explode(" ", $row_lista['fecha']);

$NomRefaccion = Refaccion($row_lista['id_refaccion'],$con);
$EstacionProveedora = Estacion($row_lista['id_estacion'],$con);
$Estacion = Estacion($row_lista['id_estacion_receptora'],$con);

echo '<tr class="'.$tableColor.'">';
echo '<td class="align-middle text-center"><b>'.$id.'</b></td>';
echo '<td class="align-middle text-center">'.FormatoFecha($explode[0]).', '.date('g:i a', strtotime($explode[1])).'</td>';
echo '<td class="align-middle text-center">'.$NomRefaccion.'</td>';
echo '<td class="align-middle text-center">1</td>';
echo '<td class="align-middle text-center"><b>'.$EstacionProveedora.'</b></td>';
echo '<td class="align-middle text-center"><b>'.$Estacion.'</b></td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" onclick="DescargarTransaccion('.$id.')"></td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="ModalDetalleT('.$id.')"></td>';
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
