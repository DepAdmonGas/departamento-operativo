<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];

$sql_lista = "SELECT * FROM op_pivoteo WHERE id_estacion = '".$idEstacion."' ORDER BY id DESC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista); 

$sql_listaestacion = "SELECT localidad, recuperacion_vapores FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}

?>

<div class="border-0 p-3">

<div class="row">

<div class="col-11">
  <h5><?=$estacion;?></h5>
</div>

<div class="col-1">
  <img class="pointer float-end" src="<?=RUTA_IMG_ICONOS;?>agregar.png" onclick="Nuevo(<?=$idEstacion;?>)">
</div>

</div>
<hr>

<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0" style="">
<thead class="tables-bg">
 <tr>
  <th class="text-center align-middle tableStyle font-weight-bold">No. de control</th>
  <th class="align-middle text-center tableStyle font-weight-bold">Fecha</th>
  <th class="align-middle text-center tableStyle font-weight-bold">Sucursal</th> 
  <th class="align-middle text-center tableStyle font-weight-bold">Causa</th>  
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>ver-tb.png"></th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>gmail.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
  </tr>
</thead> 
<tbody>
<?php
if ($numero_lista > 0) {

while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$nocontrol = $row_lista['nocontrol'];
$status = $row_lista['estatus'];

if($status == 0){
$tableColor = "table-warning";
$Detalle = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'ver-tb.png">';
$PDF = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'pdf.png">';
$Editar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="Editar('.$idEstacion.','.$id.')">';
$Eliminar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$idEstacion.','.$id.')">';
$GMAIL = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'gmail.png">';
}else if($status == 1){
$tableColor = "table-info";
$Detalle = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="VerPivoteo('.$id.')">';
$PDF = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'pdf.png" onclick="PivoteoPDF('.$id.')">';
$Editar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="Editar('.$idEstacion.','.$id.')">';
$Eliminar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$idEstacion.','.$id.')">';
$GMAIL = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'gmail.png">';
}else if($status == 2){
$tableColor = "table-success";
$Detalle = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="VerPivoteo('.$id.')">';
$PDF = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" onclick="PivoteoPDF('.$id.')">';
$Editar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'editar-tb.png">';
$Eliminar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'eliminar.png">';
$GMAIL = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'gmail.png" onclick="GMail('.$idEstacion.','.$id.')">';
}

echo '<tr class="'.$tableColor.'">';
echo '<td class="align-middle text-center"><b>0'.$nocontrol.'</b></td>';
echo '<td class="align-middle text-center">'.FormatoFecha($row_lista['fecha']).'</td>';
echo '<td class="align-middle text-center">'.$row_lista['sucursal'].'</td>';
echo '<td class="align-middle text-center">'.$row_lista['causa'].'</td>';
echo '<td class="align-middle text-center">'.$Detalle.'</td>';
echo '<td class="align-middle text-center">'.$PDF.'</td>';
echo '<td class="align-middle text-center">'.$GMAIL.'</td>';
echo '<td class="align-middle text-center">'.$Editar.'</td>';
echo '<td class="align-middle text-center">'.$Eliminar.'</td>';
echo '</tr>';

}
}else{
echo "<tr><td colspan='9' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>

</div>

