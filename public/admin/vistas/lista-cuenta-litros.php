<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$GET_year = $_GET['year'];
$GET_mes = $_GET['mes']; 


$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
}


if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo" ){
$ocultarM = "d-none";
$ocultarTB = "";
$divBorderI = "";
$divBorderF = "";

}else{
$ocultarM = "";
$ocultarTB = "d-none";
$divBorderI = "<div class='border-0 p-3'>";
$divBorderF = "</div>";
}


$sql_lista = "SELECT * FROM op_cuenta_litros WHERE id_estacion = '".$idEstacion."' AND year = '".$GET_year."'  AND mes = '".$GET_mes."' ORDER BY fecha ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>




<?=$divBorderI?>

<div class="row <?=$ocultarM?>">

<div class="col-11 mb-0">
<h5><?=$estacion;?></h5>
</div> 

<div class="col-1 mb-0 <?=$ocultarTB?>">
  <img src="<?=RUTA_IMG_ICONOS;?>agregar.png" class="float-end pointer " onclick="NuevoCuentaLitros(<?=$idEstacion;?>,<?=$GET_year;?>,<?=$GET_mes;?>)">
</div> 

</div> 

<hr class="<?=$ocultarM?>"> 


<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0" style="font-size: .9em;">
<thead class="tables-bg">

  <th class="text-center align-middle font-weight-bold" width="60">#</th>
  <th class="align-middle font-weight-bold">Fecha</th>
  <th class="text-center align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>ver-tb.png"></th>
  <th class="text-center align-middle text-center " width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
  <th class="text-center align-middle text-center <?=$ocultarTB?>" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>

</thead> 
<tbody>

<?php
if ($numero_lista > 0) {

while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id_cuenta_litros = $row_lista['id_cuenta_litros'];
$estado = $row_lista['estatus'];

if($estado == 0 AND $session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo" ){
$TrColor = 'table-warning';
$detalletb = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'ver-tb.png">';
$editartb = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="EditarCL('.$id_cuenta_litros.')">';

}else if($estado == 1 AND $session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo" ){
$TrColor = '';
$detalletb = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png"  onclick="DetalleCL('.$id_cuenta_litros.')">';
$editartb = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'editar-tb.png">';


}else if($estado == 0){
$TrColor = 'table-warning';
$detalletb = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png"  onclick="DetalleCL('.$id_cuenta_litros.')">';
$editartb = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'editar-tb.png">';

}else if($estado == 1){
$TrColor = '';
$detalletb = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png"  onclick="DetalleCL('.$id_cuenta_litros.')">';
$editartb = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="HabilitarCL('.$id_cuenta_litros.')">';
}


echo '<tr class="'.$TrColor.'">';
echo '<td class="align-middle text-center" onclick="DetalleCL('.$id_cuenta_litros.')">'.$id_cuenta_litros.'</td>';
echo '<td class="align-middle">'.FormatoFecha($row_lista['fecha']).'</td>';
echo '<td class="align-middle text-center">'.$detalletb.'</td>';
echo '<td class="align-middle text-center">'.$editartb.'</td>';
echo '<td class="align-middle text-center '.$ocultarTB.'"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarCL('.$id_cuenta_litros.','.$idEstacion.','.$GET_year.','.$GET_mes.')"></td>';
echo '</tr>';


}
}else{
echo "<tr><td colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>  
</div>

 
<?=$divBorderF?>

