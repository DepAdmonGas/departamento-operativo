<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$idCategoria = $_GET['idCategoria'];
$GET_year = $_GET['year'];
$GET_mes = $_GET['mes']; 


$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
}

if($idEstacion == 501){
$nombreES = "Departamento";
}else if($idEstacion == 502){
$nombreES = "Varios";
}else{
$nombreES = $estacion;
}

?>


<div class="border-0 p-3"> 

<div class="row">

<div class="col-11 mb-0">
<h5><?=$nombreES;?></h5>
</div> 

<div class="col-1 mb-0">
  <img src="<?=RUTA_IMG_ICONOS;?>agregar.png" class="float-end pointer" onclick="Modal(<?=$idEstacion;?>,<?=$idCategoria;?>,<?=$GET_year;?>,<?=$GET_mes;?>,0)">
</div> 

</div> 

<hr> 



<?php

$sql = "SELECT * FROM op_incidencias WHERE id_estacion = '".$idEstacion."' AND id_categoria = '".$idCategoria."' AND year = '".$GET_year."' AND mes = '".$GET_mes."' ORDER BY id DESC ";  
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);

?>

<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0" style="font-size: .9em;">
<thead class="tables-bg">
  <tr>
  <th class="text-center align-middle tableStyle font-weight-bold" width="40">#</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Fecha</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Asunto</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Responsable</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Tiempo que duro la actividad</th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>ver-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
  </tr>
</thead> 
<tbody>
<?php 
$i = 1;
if ($numero > 0) {
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

if($row['archivo'] != ""){
$PDF = '<a href="../../../archivos/incidencias/'.$row['archivo'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png"></a>';
}else{
$PDF = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png">';
}  

echo '<tr class="text-center align-middle">
<td>'.$i.'</td>
<td>'.FormatoFecha($row['fecha']).'</td>
<td>'.$row['asunto'].'</td>
<td>'.$row['responsable'].'</td>
<td>'.$row['tiempo_actividad'].'</td>
<td>'.$PDF.'</td>
<td><img class="pointer" onclick="Detalle('.$row['id'].')" src="'.RUTA_IMG_ICONOS.'ver-tb.png"></td>
<td><img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="Modal('.$idEstacion.','.$idCategoria.','.$GET_year.','.$GET_mes.','.$row['id'].')"></td>
<td><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarInc('.$idEstacion.','.$idCategoria.','.$GET_year.','.$GET_mes.','.$row['id'].')"></td>

</tr>';
$i++;
}
}else{
echo "<tr><td colspan='9' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table> 
</div>


</div>
