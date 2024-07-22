<?php
require('../../../app/help.php');


$sql_lista = "SELECT * FROM op_pinturas_complementos_reporte WHERE id_estacion = '".$Session_IDEstacion."' ORDER BY id DESC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$Session_IDEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
}

function Personal($idusuario,$con){
$sql = "SELECT nombre FROM tb_usuarios WHERE id = '".$idusuario."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$nombre = $row['nombre'];
}
return $nombre;
}
$idRefaccion = 0;
?>

<div class="table-responsive">
	<table id="tabla-principal" class="custom-table " style="font-size: .8em;" width="100%">
		<thead class="navbar-bg">
  <tr>
  <th class="text-center align-middle">#</th>
  <th class="text-center align-middle">Personal</th>
  <th class="text-center align-middle">Fecha y hora</th>
  <th class="text-center align-middle">Detalle</th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>ver-tb.png"></th>
    <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
  </tr>
</thead> 
<tbody class="bg-white">
<?php
if ($numero_lista > 0) {

while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$status = $row_lista['status'];

if($status == 0){ 
$tableColor = "background-color: #fcfcda";
$Editar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="EditarReporte('.$id.')">';
$Eliminar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarReporte('.$id.')">';
}else if($status == 1){
$tableColor = "background-color: #b0f2c2";
$Editar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'editar-tb.png" >';
$Eliminar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'eliminar.png" >';
}

echo '<tr style="'.$tableColor.'">';
echo '<th class="align-middle text-center">'.$id.'</th>';
echo '<td class="align-middle text-center">'.Personal($row_lista['id_usuario'],$con).'</td>';
echo '<td class="align-middle text-center">'.FormatoFecha($row_lista['fecha']).', '.date('g:i a', strtotime($row_lista['hora'])).'</td>';
echo '<td class="align-middle text-center">'.$row_lista['detalle'].'</td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="ModalDetalleReporte('.$id.','.$idRefaccion.')"></td>';
echo '<td class="align-middle text-center">'.$Editar.'</td>';
echo '<td class="align-middle text-center">'.$Eliminar.'</td>';
echo '</tr>';

}
}else{
echo "<tr><th colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar </small></th></tr>";
}
?>
</tbody>
</table>
</div>