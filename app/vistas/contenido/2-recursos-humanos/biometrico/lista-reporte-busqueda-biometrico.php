<?php 
require('../../../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$Year = $_GET['Year'];
$Mes = $_GET['Mes'];

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

function tablasNomina($GET_idEstacion,$GET_year,$GET_idMes,$GET_idSemana,$session_nompuesto,$con){
$ClassHerramientasDptoOperativo = new HerramientasDptoOperativo($con);

$resultado = "";

//---------- VISUALIZACIONES PUESTOS ----------
if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"){
$ocultarBtn = "d-none";

}else{
$ocultarBtn = "";
}


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

    $resultado .= '
    <div class="row">

    <div class="col-12">
    <div class="row">

    <div class="col-11">
    <h6 class="text-secondary"> </h6>
    </div>

    <div class="col-1">';

    if($finFechas <= $fechaActual){

    $reporte = '
 
    <div class="dropdown d-inline ms-2 >">
    <button type="button" class="btn btn-labeled2 dropdown-toggle btn-success text-white" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
    <span class="btn-label2"><i class="fa-solid fa-download"></i></span>Descargar</button>
    </button>
        
    <ul class="dropdown-menu">
    <li><a class="dropdown-item pointer" href="public/recursos-humanos/vistas/reporte-asistencia-faltas-pdf-v2.php?idEstacion='.$GET_idEstacion.'&year='.$GET_year.'&mes='.$GET_idMes.'&semana='.$GET_idSemana.'"> <i class="fa-regular fa-file-pdf"></i> Reporte - Semana No. '. $GET_idSemana . '</a></li>
    <li ><a class="dropdown-item pointer" href="public/recursos-humanos/vistas/asistencias-excel-v3.php?idEstacion='.$GET_idEstacion.'&year='.$GET_year.'&mes='.$GET_idMes.'"> <i class="fa-regular fa-file-excel"></i> Reporte - '.$ClassHerramientasDptoOperativo->nombremes($GET_idMes).' '.$GET_year.'</a></li>
    <li class="'.$ocultarBtn.'"><a class="dropdown-item pointer" href="public/recursos-humanos/vistas/reporte-incidencias-estaciones.php?year='.$GET_year.'&mes='.$GET_idMes.'&semana='.$GET_idSemana.'"> <i class="fa-regular fa-file-pdf"></i> Reporte Estaciones - Semana No.'.$GET_idSemana.' </a></li>
        
    </ul>
    </div>';


    }else{
    $reporte = '<span class="badge rounded-pill bg-danger float-end text-center" style="font-size: .78em;">
    Reporte No disponible <i class="fa-solid fa-ban"></i>
    </span>';
    }

    $resultado .= ' 
 
    </div>

    </div> 
    </div>

    </div>'; 
     
    $resultado .= '<div class="table-responsive">';
    $resultado .= '<table class="custom-table mb-3" style="font-size: .8em;" width="100%">';
    $resultado .= '<thead class="title-table-bg">';
    $resultado .= '<tr class="tables-bg">';

    $resultado .= '<th class="align-middle text-center" colspan="8" >Semana '.$GET_idSemana.' <br> '.$ClassHerramientasDptoOperativo->formatoFecha($inicioFechas).' al '.$ClassHerramientasDptoOperativo->formatoFecha($finFechas).'</th>';

    $resultado .= '<th class="align-middle text-center" colspan="2"> '.$reporte.' </th>';
    $resultado .= '</tr>';

    $resultado .= '<tr>';

    $resultado .= '<td class="align-middle fw-bold">Nombre</td>';
    foreach ($diasEntre as $dia) {
    $resultado .= '<th class="align-middle text-center">'.$ClassHerramientasDptoOperativo->formatoFecha($dia).'</th>';
    }   

    $resultado .= '<th class="align-middle text-center">Retardos</th>';
    $resultado .= '<td class="align-middle text-center fw-bold">Faltas</td>';

    $resultado .= '</tr>';
    $resultado .= '</thead>'; 

    $resultado .= '<tbody class="bg-white">';

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




<?php 

//---------- VISUALIZACIONES PUESTOS ----------
if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"){
    
if($idEstacion == 9){
$divisionHR = "<hr>";
$nombreES = '<h3 class="text-secondary">Autolavado</h3>';
$btnRegreso = '';
}else{
$divisionHR = "";
$nombreES = "";
$btnRegreso = '

<div class="row">
<div class="col-12">
<button type="button" class="btn btn-labeled2 btn-danger float-end" onclick="SelEstacionReturn('.$idEstacion.')">
<span class="btn-label2"><i class="fa-solid fa-rotate-left"></i></span>Regresar al listado mensual</button>
</div>
</div>';

}
    
}else{
$divisionHR = "";
$nombreES = "";
$btnRegreso = '';
}

echo $btnRegreso;
echo $divisionHR;
echo $nombreES;


foreach ($listadoSemanas as $semana) {
$GET_idSemana = (int)$semana;

echo tablasNomina($idEstacion, $Year, $Mes, $GET_idSemana, $session_nompuesto, $con);


}
    
?>