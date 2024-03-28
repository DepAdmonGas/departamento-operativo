<?php
require('../../../app/help.php');
$idEstacion = $_GET['idEstacion'];

if($idEstacion == 8){
$estacion = "Otros";
}else{
$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
}
}   


$sql_lista = "SELECT * FROM op_mantenimiento_preventivo WHERE id_estacion = '".$idEstacion."' ORDER BY folio DESC ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);


function NombrePersonal($id,$con){
$sql_personal = "SELECT nombre FROM tb_usuarios WHERE id = '".$id."' ";
$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);

while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){
$return = $row_personal['nombre']; 
}

return $return;
}


?> 
<script type="text/javascript">
$(document).ready(function($){
$('[data-toggle="tooltip"]').tooltip();
});
</script>

<?php if($idEstacion != $Session_IDEstacion){ ?>

<div class="border-0 p-3">
<div class="row">
<div class="col-10">
<div><h5>Mantenimiento preventivo <?=$estacion;?></h5></div>
</div>
<div class="col-2">
<img class="float-end pointer ms-2" src="<?=RUTA_IMG_ICONOS;?>agregar.png" onclick="Nuevo(<?=$idEstacion;?>)">
<img class="float-end pointer ms-2" src="<?=RUTA_IMG_ICONOS?>archivo-tb.png" onclick="DocumentosMtto(<?=$idEstacion;?>)" data-toggle="tooltip" data-placement="top" title="Documentos">
</div>
</div>
<hr>
 
<?php }else{?>
<div class="border-0">
<?php } ?>


<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0">
<thead class="tables-bg">
 <tr class="align-middle text-center">
  <th class="align-middle tableStyle font-weight-bold">Folio</th>
  <th class="align-middle tableStyle font-weight-bold">Encargado</th>
  <th class="align-middle tableStyle font-weight-bold">Fecha Mantenimiento CECM </th>
  <th class="align-middle tableStyle font-weight-bold" width="145px">Orden de servicio</td> 

  <th class="align-middle tableStyle font-weight-bold">Proxima Prueba</td>  
  <th class="align-middle tableStyle font-weight-bold"  width="400">Observación</td>  
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>actualizar-tb.png"></th>


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
$fechaUno = FormatoFecha($row_lista['fecha']);
$fechaDos = FormatoFecha($row_lista['fecha2']);
$status = $row_lista['status'];

if($row_lista['fecha2'] == "0000-00-00"){
  $fechaOpc2 = "";
  $fechaForMes = date("m",strtotime($row_lista['fecha']."+ 4 month"));

}else{
  $fechaOpc2 = 'y <br> '.$fechaDos.'';
  $fechaForMes = date("m",strtotime($row_lista['fecha2']."+ 4 month"));
}
 

if($row_lista['orden_servicio'] != ""){
$Descargar = '<a href="'.RUTA_ARCHIVOS.'mantenimiento/'.$row_lista['orden_servicio'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'descargar.png" data-toggle="tooltip" data-placement="top" title="Descargar"></a>';
}else{
$Descargar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="">';  
}
 

  if($status == 0){
    $bgTable = 'style="background-color: #ffb6af"';
    $btnEditar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="ModalEditar('.$idEstacion.','.$id.')" data-toggle="tooltip" data-placement="top" title="Editar">';
    $btnEliminar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$idEstacion.','.$id.')" data-toggle="tooltip" data-placement="top" title="Eliminar">';
    $btnStatus = '<img class="pointer" onclick="ActualizarStatus('.$idEstacion.','.$id.','.$status.')" src="'.RUTA_IMG_ICONOS.'actualizar-tb-red.png" data-toggle="tooltip" data-placement="top" title="Pendiente">';

  }else if($status == 1){
    $bgTable = 'style="background-color: #fcfcda"';
    $btnEditar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'editar-tb.png" data-toggle="tooltip" data-placement="top" title="Editar">';
    $btnEliminar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$idEstacion.','.$id.')" data-toggle="tooltip" data-placement="top" title="Eliminar">';
    $btnStatus = '<img class="pointer" onclick="ActualizarStatus('.$idEstacion.','.$id.','.$status.')" src="'.RUTA_IMG_ICONOS.'actualizar-tb-yellow.png" data-toggle="tooltip" data-placement="top" title="En Proceso">';

  }else if($status == 2){
    $bgTable = 'style="background-color: #b0f2c2"';
    $btnEditar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'editar-tb.png" data-toggle="tooltip" data-placement="top" title="Editar">';
    $btnEliminar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Eliminar">';
    $btnStatus = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'actualizar-tb.png" data-toggle="tooltip" data-placement="top" title="Finalizado">';

  }
 

 
 
echo '<tr '.$bgTable.'>';
echo '<td class="align-middle text-center"><b>00'.$row_lista['folio'].'</b></td>';
echo '<td class="align-middle text-center">'.NombrePersonal($row_lista['id_encargado'],$con).'</td>';
echo '<td class="align-middle text-center">'.$fechaUno.' '.$fechaOpc2.'</td>';
echo '<td class="align-middle text-center">'.$Descargar.'</td>';

echo '<td class="align-middle text-center">'.nombremes($fechaForMes).'</td>';
echo '<td class="align-middle text-center">'.$row_lista['observaciones'].'</td>';
echo '<td class="align-middle text-center">'.$btnStatus.'</td>';
echo '<td class="align-middle text-center">'.$btnEditar.'</td>';
echo '<td class="align-middle text-center">'.$btnEliminar.'</td>';
echo '</tr>';

$num++;
}
}else{
echo "<tr><td colspan='7' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>

</table>
</div>

</div>