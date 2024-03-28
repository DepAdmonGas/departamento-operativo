 <?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];

$sql_lista = "SELECT * FROM op_incidencias_estaciones WHERE id_estacion = '".$idEstacion."' ORDER BY fecha ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);


$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
}

?>

 <div class="border-0 p-3">

    <div class="row">

    <div class="col-11">
	<h5>Incidencias <?=$estacion;?></h5>
    </div>

    <div class="col-1">
    <img class="float-end pointer" src="<?=RUTA_IMG_ICONOS;?>agregar.png" onclick="ModalNuevaIncidencia(<?=$idEstacion;?>)">
    </div>

    </div>

<hr>
 
<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0" style="font-size: .9em;">
<thead class="tables-bg">
  <th class="text-center align-middle font-weight-bold"><b>#</b></th>
  <th class="text-center align-middle font-weight-bold"><b>Fecha y hora</b></th>
  <th class="text-center align-middle font-weight-bold"><b>Incidente</b></th>
  <th class="text-center align-middle font-weight-bold"><b>Responsable</b></th>
  <th class="text-center align-middle font-weight-bold"><b>Asunto</b></th>
  <th class="text-center align-middle font-weight-bold"><b>Comentarios</b></th>
  
  <th class="text-center align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>multimedia.png"></th>
  <th class="text-center align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>ver-tb.png"></th>
  <th class="text-center align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
  <th class="text-center align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>

</thead> 
<tbody>
<?php
if ($numero_lista > 0) {
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id_incidencia = $row_lista['id_incidencias_estaciones'];
$fecha = $row_lista['fecha'];
$hora = $row_lista['hora'];
$incidente = $row_lista['incidente'];
$responsable = $row_lista['responsable'];
$asunto = $row_lista['asunto'];
$comentarios = $row_lista['comentarios'];
$archivo = $row_lista['archivo'];
 

if($archivo != ""){
$MultimediaTB = '<a href="'.RUTA_ARCHIVOS.'incidencias/'.$archivo.'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'multimedia.png"></a>';
}else{
$MultimediaTB = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png">';
}  
 
echo '<tr>';
echo '<td class="align-middle text-center">'.$num.'</td>';
echo '<td class="align-middle text-center"><b>'.FormatoFecha($fecha).',  '.date("g:i a",strtotime($hora)).'</b></td>';
echo '<td class="align-middle text-center"><b>'.$incidente.'</b></td>';
echo '<td class="align-middle text-center"><b>'.$responsable.'</b></td>';
echo '<td class="align-middle text-center"><b>'.$asunto.'</b></td>';
echo '<td class="align-middle text-center"><b>'.$comentarios.'</b></td>';
echo '<td class="align-middle text-center"><b>'.$MultimediaTB.'</b></td>';

echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="ModalVerIncidencia('.$id_incidencia.')"></td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="ModalEditarIncidencia('.$id_incidencia.','.$idEstacion.')"></td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarIncidencia('.$id_incidencia.','.$idEstacion.')"></td>';
echo '</tr>';

$num++;
}
}else{
echo "<tr><td colspan='10' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>



</div>