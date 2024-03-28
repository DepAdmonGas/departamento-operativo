<?php
require('../../../app/help.php');
$idEstacion = $_GET['idEstacion'];

$sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}


$sql_poliza_inc = "SELECT * FROM op_poliza_incidencia WHERE id_estacion = '".$idEstacion ."' ORDER BY id_poliza_incidencia DESC ";  
$result_poliza_inc = mysqli_query($con, $sql_poliza_inc);
$numero_poliza_inc = mysqli_num_rows($result_poliza_inc);

?>
 
  
<div class="border-0 p-3"> 

<div class="row">

<div class="col-9 mb-0">
<h5><?=$estacion;?></h5>
</div> 

<div class="col-3 mb-0">
  <img src="<?=RUTA_IMG_ICONOS;?>agregar.png" class="float-end pointer ms-2" onclick="ModalAgregarIncidente(<?=$idEstacion;?>)">
  <img src="<?=RUTA_IMG_ICONOS;?>poliza-s.png" width="24px" class="float-end pointer ms-2" onclick="ModalPoliza(<?=$idEstacion;?>)">

</div> 

</div> 

<hr> 

<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0" style="font-size: .9em;">
<thead class="tables-bg">
  <tr>
  <th class="text-center align-middle tableStyle font-weight-bold" width="40">#</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Fecha</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Hora</th>

  <th class="text-center align-middle tableStyle font-weight-bold">Asunto</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Observaciones</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Solucion</th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>multimedia.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>ver-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
  </tr>
</thead> 
<tbody>
<?php 
$i = 1;
if ($numero_poliza_inc > 0) {
while($row = mysqli_fetch_array($result_poliza_inc, MYSQLI_ASSOC)){
$id_poliza_inc = $row['id_poliza_incidencia'];
$id_poliza_inc = $row['id_poliza_incidencia'];
$explode = explode(' ',$row['fecha_hora']);


if($row['archivo'] != ""){

$PDF = '<a href="archivos/incidencias-poliza-es/'.$row['archivo'].'" download>
<img class="pointer" src="'.RUTA_IMG_ICONOS.'multimedia.png">
</a>';

}else{
$PDF = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png">';
}  

echo '<tr class="text-center align-middle">
<td>'.$i.'</td>
<td class="align-middle">'.FormatoFecha($row['fecha']).'</td>
<td class="align-middle">'.date("g:i a",strtotime($row['hora'])).'</td>

<td>'.$row['asunto'].'</td>
<td>'.$row['observaciones'].'</td>
<td>'.$row['solucion'].'</td>
<td>'.$PDF.'</td>
<td><img class="pointer" onclick="DetallePolizaInc('.$id_poliza_inc.')" src="'.RUTA_IMG_ICONOS.'ver-tb.png"></td>
<td><img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="ModalEditarIncP('.$id_poliza_inc.')"></td>
<td><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarInc('.$id_poliza_inc.','.$idEstacion.')"></td>

</tr>';
$i++;
} 
}else{
echo "<tr><td colspan='10' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table> 
</div>


</div>
