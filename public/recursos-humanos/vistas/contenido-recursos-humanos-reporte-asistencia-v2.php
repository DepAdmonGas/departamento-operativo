<?php 
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$Year = $_GET['Year'];
$Mes = $_GET['Mes'];
$Val = $_GET['Val'];

$sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}
 
 
if($session_nompuesto == "Encargado"){
$inicioDiv = "";
$finDiv = "";
$ocultarDiv = "d-none";
                
}else{
$inicioDiv = '<div class="border-0 p-3">';
$finDiv = "</div>";
$ocultarDiv = "";
                
}

$listadoSemanas = SemanasDelMes($Mes, $Year);

//---------- OBTIENE EL NUMERO DE SEMANAS QUE TIENE EL MES ----------
function SemanasDelMes($GET_idMes, $GET_year) {
// Obtener el primer día del mes
$primerDia = strtotime("$GET_year-$GET_idMes-01");
  
// Ajustar el primer día al primer día de la semana
$primerDia = strtotime("this Wednesday", $primerDia);
  
// Inicializar el array para almacenar las semanas
$semanas = array();
  
// Iterar desde el primer día hasta el último día del mes
for ($currentDate = $primerDia; date('m', $currentDate) == $GET_idMes; $currentDate = strtotime('+1 week', $currentDate)) {
// Calcular el número de semana
$semana = date('W', $currentDate);
  
// Agregar la semana al array solo si no está ya presente
if (!in_array($semana, $semanas)) {
$semanas[] = $semana;
}
}
  
return $semanas;
}

//---------- OBTENER FECHA DEL PRIMER Y ULTIMO DIA DE LA SEMANA ----------
function fechasNominaSemana($year, $semana){
// Obtener la fecha del primer día de la semana
$inicioDay = new DateTime();
$inicioDay->setISODate($year, $semana, 1);
$inicioDay->modify('last thursday');
      
// Calcular la fecha de fin de la semana (6 días después del inicio)
$finDay = clone $inicioDay;
$finDay->modify('+6 days');
      
// Formatear las fechas para mostrarlas
$inicioDayFormateada = $inicioDay->format('Y-m-d');
$finDayFormateada = $finDay->format('Y-m-d');
      
$array = array(
'inicioSemanaDay' => $inicioDayFormateada, 
'finSemanaDay' => $finDayFormateada
);
      
return $array; 
      
}  

function tablasNomina($GET_idEstacion,$GET_year,$GET_idMes,$GET_idSemana,$con){

    $fechaNomiaSemana = fechasNominaSemana($GET_year, $GET_idSemana);
    $inicioFechas = $fechaNomiaSemana['inicioSemanaDay'];
    $finFechas = $fechaNomiaSemana['finSemanaDay'];
    $fechaActual = date("Y-m-d H:i:s");

    // Convertir las fechas de inicio y fin a objetos DateTime
    $inicioDayObj = new DateTime($inicioFechas);
    $finDayObj = new DateTime($finFechas);

    // Inicializar un arreglo para almacenar los días entre el inicio y el fin
    $diasEntre = array();

    // Bucle para recorrer los días entre el inicio y el fin
    while ($inicioDayObj <= $finDayObj) {
    // Agregar el día al arreglo
    $diasEntre[] = $inicioDayObj->format('Y-m-d');
    
    // Avanzar al siguiente día
    $inicioDayObj->modify('+1 day');
    }

    $resultado .= '<div class="p-3 border mb-3">
    <div class="row">

    <div class="col-12">
    <div class="row">

    <div class="col-11">
    <h6 class="text-secondary"> Semana '.$GET_idSemana.',  '.formatoFecha($inicioFechas).' al '.formatoFecha($finFechas).'</h6>
    </div>

    <div class="col-1">';

    if($finFechas <= $fechaActual){
        $reporte = '
        <a href="public/recursos-humanos/vistas/reporte-incidencias-estaciones.php?year=' . $GET_year . '&mes=' . $GET_idMes . '&semana= '. $GET_idSemana . '" download>
        <img class="pointer float-end ms-2" src="'.RUTA_IMG_ICONOS.'gas.png">
        </a>
        
        <a href="public/recursos-humanos/vistas/reporte-asistencia-faltas-pdf-v2.php?idEstacion=' . $GET_idEstacion . '&year=' . $GET_year . '&mes=' . $GET_idMes . '&semana= '. $GET_idSemana . '" download>
        <img class="pointer float-end ms-2" src="'.RUTA_IMG_ICONOS.'pdf.png">
        </a>';

    }else{
        $reporte = '<span class="badge rounded-pill bg-danger float-end text-center" style="font-size: .78em;">
        Reporte No disponible <i class="fa-solid fa-ban"></i>
        </span>';
    }

    // $resultado .= '<a class="decorado" href="public/recursos-humanos/vistas/reporte-asistencia-faltas-pdf.php?idEstacion='.$idEstacion.'&FechaInicio='.$timestamp1.'&FechaFin='.$timestamp2.'" download>';
    $resultado .= '
    
    '.$reporte.'
 
    </div>

    </div> 
    </div>

    </div>
    <hr>';
     
    $resultado .= '<div class="table-responsive">';
    $resultado .= '<table class="table table-sm table-bordered table-hover pb-0 mb-0 mt-0" style="font-size: .8em;">';
    $resultado .= '<thead class="tables-bg">';
   
    $resultado .= '<tr>';
    $resultado .= '<th class="align-middle">Nombre</th>';
    
    foreach ($diasEntre as $dia) {
    $resultado .= '<th class="align-middle text-center">'.formatoFecha($dia).'</th>';
    }   

    $resultado .= '<th class="align-middle text-center">Retardos</th>';
    $resultado .= '<th class="align-middle text-center">Faltas</th>';
    $resultado .= '</tr>';
    $resultado .= '</thead>'; 

    $resultado .= '<tbody>';

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
    WHERE op_rh_personal.id_estacion = '".$GET_idEstacion."' AND op_rh_personal.estado = 1 ORDER BY op_rh_personal.id ASC ";
    $result_personal = mysqli_query($con, $sql_personal);
    $numero_personal = mysqli_num_rows($result_personal);

    while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){
    $idPersonal = $row_personal['id'];  
    $Retardo = 0;
    $Falta = 0;
    
    if($idPersonal == 387 || $idPersonal == 358 || $idPersonal == 296 || $idPersonal == 326 || $idPersonal == 300 || $idPersonal == 335){
 
    }else{

    $resultado .= '<tr>';
    $resultado .= '<td>'.$row_personal['nombre_completo'].'</td>';

    foreach ($diasEntre as $dia) {
 
    $Detalle = ValidaFecha($idPersonal,$dia,$con);
    
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
    
    }else{
    $Color = 'text-black';
    }
             
    
    $resultado .= '<td class="align-middle text-center '.$Color.'">'.$Detalle.'</td>';
    } 


    $resultado .= '<td class="align-middle text-center">'.$Retardo.'</td>';
    $resultado .= '<td class="align-middle text-center">'.$Falta.'</td>';


    $resultado .= '</tr>';
    }
}

    $resultado .= '</tbody>';

    $resultado .= '</table>';
    $resultado .= '</div>';

    $resultado .= '</div>';

return $resultado;

}


function ValidaFecha($idPersonal,$dia,$con){

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
    op_rh_personal.puesto,
    op_rh_personal.id_estacion
    FROM op_rh_personal_asistencia 
    INNER JOIN op_rh_personal 
    ON op_rh_personal_asistencia.id_personal = op_rh_personal.id
    WHERE op_rh_personal_asistencia.id_personal = '".$idPersonal."' AND op_rh_personal_asistencia.fecha = '".$dia."' ";
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


<?=$inicioDiv?>

<div class="row">

<?php if($Val == 0){ ?>

<div class="col-12 <?=$ocultarDiv?>">
<div class="row">

<div class="col-10">
<h5 ><?=$estacion;?></h5>
<h6>Incidencias de Nomina - <?=nombremes($Mes);?> del <?=$Year;?></h6>
</div> 
<div class="col-2">
<img class="mt-2 p-1 ms-2 float-end pointer" src="<?=RUTA_IMG_ICONOS;?>buscar-tb.png" onclick="ModalReporte(<?=$idEstacion;?>)"></a>

<a class="ms-2" href="public/recursos-humanos/vistas/asistencias-excel-v3.php?idEstacion=<?=$idEstacion?>&year=<?=$Year?>&mes=<?=$Mes?>" download>
<img class="mt-2 p-1 ms-2 float-end pointer" src="<?=RUTA_IMG_ICONOS;?>excel.png"></a>
</div>

</div> 

<hr>
</div> 

<?php }else{ ?>
 
 
<div class="col-12 <?=$ocultarDiv?>">
<h5 ><?=$estacion;?></h5>
<h6>Reporte de <?=nombremes($Mes);?> del <?=$Year;?></h6>
<hr>
</div> 

<div class="col-6 mb-3">
<div class="text-start"> 
<a class="ms-2" href="public/recursos-humanos/vistas/asistencias-excel-v3.php?idEstacion=<?=$idEstacion?>&year=<?=$Year?>&mes=<?=$Mes?>" download>
<img class="pr-2 mt-2" src="<?=RUTA_IMG_ICONOS;?>excel.png"></a>
<!-- <a class="ms-2" href="public/recursos-humanos/vistas/asistencias-excel.php?idEstacion=<?=$idEstacion;?>&FechaInicio=<?=strtotime($FechaInicio);?>&FechaFin=<?=strtotime($FechaTermino);?>" download><img class="pr-2 mt-2" src="<?=RUTA_IMG_ICONOS;?>excel.png"></a>-->
</div>
</div> 


<div class="col-6 mb-3">
<div class="float-end">

<!--<a class="decorado" href="public/recursos-humanos/vistas/reporte-asistencia-pdf.php?idEstacion=<?=$idEstacion;?>&FechaInicio=<?=$FechaInicio;?>&FechaTermino=<?=$FechaTermino;?>" download>
<img class="pointer pr-2 mt-2" src="<?=RUTA_IMG_ICONOS;?>pdf.png">
</a>-->
<button type="button" class="btn btn-outline-danger btn-sm mt-2 p-1 ms-2" onclick="SelEstacionReturn(<?=$idEstacion;?>)">Cancelar</button>
<button type="button" class="btn btn-outline-primary btn-sm mt-2 p-1 ms-2" onclick="ModalReporte(<?=$idEstacion;?>)">Reporte</button>
</div>
</div>
 
<?php } ?>

<div>

<?php 

foreach ($listadoSemanas as $semana) {
$GET_idSemana = (int)$semana;

echo tablasNomina($idEstacion, $Year, $Mes, $GET_idSemana, $con);

}
    
?>


<?=$finDiv?>


