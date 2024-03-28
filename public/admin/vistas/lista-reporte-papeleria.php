<?php
require('../../../app/help.php');
$idEstacion = $_GET['idEstacion'];

$sql_lista = "SELECT * FROM op_papeleria_reporte WHERE id_estacion = '".$idEstacion."' ORDER BY id DESC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$idEstacion."' ";
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
?> 


<div class="border-0 p-3">

    <div class="row">
    <div class="col-12">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="SelEstacionReturn(<?=$idEstacion;?>)"> 
    
    <div class="row">
    <div class="col-12">
    <h5>Reporte de papelería <?=$estacion;?></h5>
    </div>
    </div>

    </div>
    </div>

<hr> 

<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0" style="font-size: .9em;">
<thead>
  <tr class="tables-bg">
  <td class="text-center align-middle tableStyle font-weight-bold"><b>#</b></td>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Personal</b></td>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Fecha y hora</b></td>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Detalle</b></td>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>ver-tb.png"></th>
  </tr>
</thead> 
<tbody>
<?php
if ($numero_lista > 0) {

while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$status = $row_lista['status'];

if($status == 0){
$tableColor = "table-warning";
$Editar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="EditarReporte('.$idEstacion.','.$id.')">';
$Eliminar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarReporte('.$idEstacion.','.$id.')">';
}else if($status == 1){
$tableColor = "";
$Editar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'editar-tb.png">';
$Eliminar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'eliminar.png">';
}

echo '<tr class="'.$tableColor.'">';
echo '<td class="align-middle text-center"><b>'.$id.'</b></td>';
echo '<td class="align-middle text-center">'.Personal($row_lista['id_usuario'],$con).'</td>';
echo '<td class="align-middle text-center">'.FormatoFecha($row_lista['fecha']).', '.date('g:i a', strtotime($row_lista['hora'])).'</td>';
echo '<td class="align-middle text-center">'.$row_lista['detalle'].'</td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="ModalDetalleReporte('.$idEstacion.','.$id.','.$idRefaccion.')"></td>';
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