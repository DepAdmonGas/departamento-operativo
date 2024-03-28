<?php 
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$Year = $_GET['Year'];
$Mes = $_GET['Mes'];

$sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}

 
function nWeeks($month, $year) {
$dayend = cal_days_in_month(CAL_GREGORIAN,$month,$year);
if ($month < 10) { $add = "-0"; } else {
$add = "-"; }
$date1 = $year.$add.$month."-01";
$date2 = $year.$add.$month."-".$dayend;

if($month == 1){
$weeks = date("W", strtotime($date2));
}else{
$weeks = date("W", strtotime($date2)) - date("W", strtotime($date1)) + 1;
}
return $weeks;
}
 
$Semanas = nWeeks($Mes,$Year);

$FechaInicio = $Year.'-'.$Mes.'-01';
$FechaTermino = date("Y-m-t", strtotime($FechaInicio));

function NumDia($fecha){
$fechats = strtotime($fecha);
$num = date('w', $fechats);

return $num;
}

$FINumDia = NumDia($FechaInicio);

if($FINumDia == 0){

$FIS1 = date("Y-m-d",strtotime($FechaInicio."+ 1 days"));

}else{

$RestaDia = $FINumDia - 1;

$FIS1 = date("Y-m-d",strtotime($FechaInicio."- $RestaDia days"));

}


$FFS1 = date("Y-m-d",strtotime($FIS1."+ 6 days"));


?>

<?php
if($session_nompuesto == "Encargado"){
$inicioDiv = "";
$finDiv = "";
$ocultarDiv = "d-none";

}else{
$inicioDiv = '<div class="border-0 p-3">';
$finDiv = "</div>";
$ocultarDiv = "";

}

?>


  
<?=$inicioDiv?>

<div class="row">

<div class="col-12 <?=$ocultarDiv?>">
<h5 ><?=$estacion;?></h5>
<h6>Reporte de <?=nombremes($Mes);?> del <?=$Year;?></h6>
<hr>
</div>


<div class="col-6">
<div class="text-start">
<a class="ms-2" href="public/recursos-humanos/vistas/asistencias-excel-v2.php?idEstacion=<?=$idEstacion;?>&FechaInicio=<?=strtotime($FechaInicio);?>&FechaFin=<?=strtotime($FechaTermino);?>" download><img class="pr-2 mt-2" src="<?=RUTA_IMG_ICONOS;?>descargar.png"></a>
<a class="ms-2" href="public/recursos-humanos/vistas/asistencias-excel.php?idEstacion=<?=$idEstacion;?>&FechaInicio=<?=strtotime($FechaInicio);?>&FechaFin=<?=strtotime($FechaTermino);?>" download><img class="pr-2 mt-2" src="<?=RUTA_IMG_ICONOS;?>excel.png"></a>
</div>
</div>


<div class="col-6">
<div class="float-end">

<!--<a class="decorado" href="public/recursos-humanos/vistas/reporte-asistencia-pdf.php?idEstacion=<?=$idEstacion;?>&FechaInicio=<?=$FechaInicio;?>&FechaTermino=<?=$FechaTermino;?>" download>
<img class="pointer pr-2 mt-2" src="<?=RUTA_IMG_ICONOS;?>pdf.png">
</a>-->
<button type="button" class="btn btn-outline-danger btn-sm mt-2 p-1 ms-2" onclick="SelEstacionReturn(<?=$idEstacion;?>)">Cancelar</button>
<button type="button" class="btn btn-outline-primary btn-sm mt-2 p-1 ms-2" onclick="ModalReporte(<?=$idEstacion;?>)">Reporte</button>
</div>
</div>


</div>


<?php 

for ($i = 1; $i <= $Semanas; $i++) {

if($i == 1){

$DateStar = $FIS1;
$DateEnd = $FFS1;

}else{
$SumSemana = $i - 1;
$FIS2 = date("Y-m-d",strtotime($FIS1."+ $SumSemana week"));
$FFS2 = date("Y-m-d",strtotime($FIS2."+ 6 days"));

$DateStar = $FIS2;
$DateEnd = $FFS2;
}

$timestamp1 = strtotime($DateStar);
$timestamp2 = strtotime($DateEnd);

echo '<div class="border p-3 mb-3 mt-3">';
echo '<div class=" text-secondary">

<a class="decorado" href="public/recursos-humanos/vistas/reporte-asistencia-faltas-pdf.php?idEstacion='.$idEstacion.'&FechaInicio='.$timestamp1.'&FechaFin='.$timestamp2.'" download>
<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png">
</a> 

Semana '.$i.', '.FormatoFecha($DateStar).' al '.FormatoFecha($DateEnd).' <hr></div> ';


echo ''.Contenido($idEstacion,$DateStar,$DateEnd,$con).'';

echo '</div>';
 
}

function DiaNum($numdia,$FechaInicio){
$fecha = date("Y-m-d",strtotime($FechaInicio."+ $numdia days"));

$explode = explode('-', $fecha);
return $explode[2].' '.nombremes($explode[1]);
}


function Contenido($idEstacion,$FechaInicio,$FechaFin,$con){

$result .= '<div class="table-responsive">';
$result .= '<table class="table table-sm table-bordered table-hover pb-0 mb-0 mt-0" style="font-size: .8em;">';
$result .= '<thead class="tables-bg">';
$result .= '<tr>';
$result .= '<th class="align-middle">Nombre</th>';
$result .= '<th class="align-middle">Lunes '.DiaNum(0,$FechaInicio).'</th>';
$result .= '<th class="align-middle">Martes '.DiaNum(1,$FechaInicio).'</th>';
$result .= '<th class="align-middle">Miercoles '.DiaNum(2,$FechaInicio).'</th>';
$result .= '<th class="align-middle">Jueves '.DiaNum(3,$FechaInicio).'</th>';
$result .= '<th class="align-middle">Viernes '.DiaNum(4,$FechaInicio).'</th>';
$result .= '<th class="align-middle">Sabado '.DiaNum(5,$FechaInicio).'</th>';
$result .= '<th class="align-middle">Domingo '.DiaNum(6,$FechaInicio).'</th>';
$result .= '<th class="align-middle">Retardos</th>';
$result .= '<th class="align-middle">Faltas</th>';
$result .= '</tr>';
$result .= '</thead>'; 
$result .= '<body>';

$sql_personal = "SELECT
op_rh_personal.id,
op_rh_personal.id_estacion,
op_rh_personal.nombre_completo,
op_rh_personal.puesto AS idPuesto,
op_rh_personal.curp,
op_rh_personal.sd,
op_rh_puestos.puesto,
op_rh_personal.documentos,
op_rh_personal.estado
FROM op_rh_personal
INNER JOIN op_rh_puestos 
ON op_rh_personal.puesto = op_rh_puestos.id
WHERE op_rh_personal.id_estacion = '".$idEstacion."' AND op_rh_personal.estado = 1 ORDER BY op_rh_personal.id ASC ";
$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);

while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){
$idPersonal = $row_personal['id'];

$result .= '<tr>';
$result .= '<td>'.$row_personal['nombre_completo'].'</td>';
$Retardo = 0;
$Falta = 0;
for ($i = 0; $i <= 6; $i++) {

$ValFecha = date("Y-m-d",strtotime($FechaInicio."+ $i days"));
$Detalle = ValidaFecha($idPersonal,$ValFecha,$con);

if($Detalle == "Retardo"){
$Retardo = $Retardo + 1;
$Color = 'text-warning';
}else if($Detalle == "Falta" || $Detalle == "Falta fin de semana"){
$Falta = $Falta + 1;
$Color = 'text-danger';
}else if($Detalle == "OK"){
$Color = 'font-weight-bold text-success';
}else if($Detalle == "Descanso"){
$Color = 'text-secondary';
}else{$Color = 'text-black';
}

$result .= '<td class="'.$Color.'">'.$Detalle.'</td>';

}

$result .= '<td>'.$Retardo.'</td>';
$result .= '<td>'.$Falta.'</td>';
$result .= '</tr>';
}

$result .= '</body>';
$result .= '</table>';
$result .= '</div>';
return $result;
}

function ValidaFecha($idPersonal,$ValFecha,$con){

$sql_asistencia = "SELECT 
op_rh_personal_asistencia.id,
op_rh_personal_asistencia.id_personal,
op_rh_personal_asistencia.fecha,
op_rh_personal_asistencia.hora_entrada,
op_rh_personal_asistencia.hora_salida,
op_rh_personal_asistencia.hora_entrada_sensor,
op_rh_personal_asistencia.hora_salida_sensor,
op_rh_personal_asistencia.retardo_minutos,
op_rh_personal_asistencia.incidencia_dias,
op_rh_personal_asistencia.incidencia,
op_rh_personal_asistencia.sd,
op_rh_personal.nombre_completo,
op_rh_personal.id_estacion
FROM op_rh_personal_asistencia 
INNER JOIN op_rh_personal 
ON op_rh_personal_asistencia.id_personal = op_rh_personal.id
WHERE op_rh_personal_asistencia.id_personal = '".$idPersonal."' AND op_rh_personal_asistencia.fecha = '".$ValFecha."' ";
$result_asistencia = mysqli_query($con, $sql_asistencia);
$numero_asistencia = mysqli_num_rows($result_asistencia);

if ($numero_asistencia > 0) {
while($row_asistencia = mysqli_fetch_array($result_asistencia, MYSQLI_ASSOC)){

$idincidencia = $row_asistencia['incidencia'];
$Resultado = Incidencias($idincidencia,$con);

}
}else{

$Resultado = 'S/I';

}

return $Resultado;
}

function Incidencias($id,$con){
$sql = "SELECT detalle FROM op_rh_lista_incidencias WHERE id = '".$id."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$detalle = $row['detalle'];
}
return $detalle;
}

?>

<?=$finDiv?>

