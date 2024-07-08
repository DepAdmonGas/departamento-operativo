<?php
require('../../../app/help.php');

$GET_idEstacion = $_GET['idEstacion'];
$GET_year = $_GET['year'];
$GET_idMes = $_GET['mes'];

if($GET_idMes == 13){
$tituloBreadcrumb = "del Año";

if($GET_idEstacion == 1 || $GET_idEstacion == 2 || $GET_idEstacion == 3 || $GET_idEstacion == 4 || $GET_idEstacion == 5 || $GET_idEstacion == 9 || $GET_idEstacion == 14){
    $descripcion = "Semana";
    $totalYear = obtenerNumeroSemanas($GET_year);

}else{
    $descripcion = "Quincena";
    $totalYear = 24;
}

}else{

if($GET_idEstacion == 1 || $GET_idEstacion == 2 || $GET_idEstacion == 3 || $GET_idEstacion == 4 || $GET_idEstacion == 5 || $GET_idEstacion == 9 || $GET_idEstacion == 14){
$descripcion = "Semana";
//---------- ARRAY DEL NUMERO DE SEMANAS DEL MES ----------
$listadoSemanas = SemanasDelMes($GET_idMes, $GET_year);

}else{
$descripcion = "Quincena";
//---------- ARRAY DEL NUMERO DE QUINCENAS DEL MES ----------
$listadoQuincenas = QuincenasDelMes($GET_idMes, $GET_year);
}

$tituloBreadcrumb = $ClassHerramientasDptoOperativo->nombremes($GET_idMes);
}


//---------- OBTENER EL NOMBRE DE LA ESTACION ----------
$sql = "SELECT localidad FROM op_rh_localidades WHERE id = '".$GET_idEstacion."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$Titulo = $row['localidad'];
}

function nombreES($GET_idEstacion,$con){

    //---------- OBTENER EL NOMBRE DE LA ESTACION ----------
$sql = "SELECT localidad FROM op_rh_localidades WHERE id = '".$GET_idEstacion."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$Titulo = $row['localidad'];
}

return $Titulo;
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

//---------- OBTENER FECHA DE INICIO Y FIN DE LAS QUINCENAS ---------- 
function fechasNominaQuincenas($year, $mes, $quincena){

    // Calcular el primer día del mes
    $primer_dia = mktime(0, 0, 0, $mes, 1, $year);
  
    if ($quincena % 2 == 1) {
      $inicio = date('Y-m-01', $primer_dia);
      $fin = date('Y-m-15', $primer_dia);
    } else {
      $inicio = date('Y-m-16', $primer_dia);
      $fin = date('Y-m-t', $primer_dia);
    }
  
    $array = array(
      'inicioQuincenaDay' => $inicio, 
      'finQuincenaDay' => $fin
    );
  
    return $array; 
  }

 
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




//---------- OBTIENE EL NUMERO DE QUINCENAS QUE TIENE EL MES ----------
function QuincenasDelMes($GET_idMes, $GET_year){
$quincenas = array();
    
// Obtener el primer día del mes
$primerDia = strtotime("first day of $GET_year-$GET_idMes");
        
// Iterar solo dos veces para representar las dos quincenas
for ($i = 1; $i <= 2; $i++) {
// Calcular el número de quincena consecutivo
$quincena = (($GET_idMes - 1) * 2) + $i;
        
// Agregar la quincena al array
$quincenas[] = $quincena;
}
    
return $quincenas;
}


//---------- OBTIENE EL NUMERO DE SEMANAS QUE TIENE EL AÑO ----------
function obtenerNumeroSemanas($year) {
    // Definir el primer día del año
    $primerDia = strtotime("{$year}-01-01");

    // Encontrar el día de la semana del primer día del año (0 = domingo, 1 = lunes, ..., 6 = sábado)
    $diaInicio = date("w", $primerDia);

    // Calcular el desplazamiento para que la semana comience el jueves
    $desplazamiento = ($diaInicio - 4 + 7) % 7;

    // Ajustar el primer día al primer jueves del año
    $primerJueves = strtotime("+{$desplazamiento} days", $primerDia);

    // Calcular el último día del año
    $ultimoDia = strtotime("{$year}-12-31");

    // Calcular el número total de semanas
    $numeroSemanas = ceil(($ultimoDia - $primerJueves + 1) / (7 * 24 * 60 * 60));

    return $numeroSemanas;
}
 
function mostrarGraficoSemQuin($idEstacion, $year, $mes, $semana, $descripcion, $con) {

    $data = obtenerDatosGraficoSemQuin($idEstacion, $year, $mes, $semana, $descripcion, $con);
    if ($idEstacion == 1 || $idEstacion == 2 || $idEstacion == 3 || $idEstacion == 4 || $idEstacion == 5 || $idEstacion == 9 || $idEstacion == 14) {
        //---------- FECHA DE INICIO Y FIN DE LA SEMANA ----------
        $fechaNomiaSemana = fechasNominaSemana($year, $semana);
        $inicioFechas = $fechaNomiaSemana['inicioSemanaDay'];
        $finFechas = $fechaNomiaSemana['finSemanaDay'];
    } else {
        //---------- FECHA DE INICIO Y FIN DE LA QUINCENA ----------
        $fechaNomiaQuincena = fechasNominaQuincenas($year, $semana, $mes);
        $inicioFechas = $fechaNomiaQuincena['inicioQuincenaDay'];
        $finFechas = $fechaNomiaQuincena['finQuincenaDay'];
    }

    echo '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">';
    echo '<div class="table-responsive">';
    echo '<table id="tabla_bitacora" class="custom-table" style="font-size: 12.5px; width: 100%;">';
    echo '<thead class="title-table-bg">';
    echo '<tr>';
    echo '<th class="align-middle text-center">';
    echo 'Recibos de Nomina - ' . $descripcion . ' ' . $semana . '</b> <br> ' . formatoFecha($inicioFechas) . ' al ' . formatoFecha($finFechas);
    echo '</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody class="bg-white">'; 
    echo '<tr>';
    echo '<th class="no-hover">'; // Añadir la clase "no-hover" aquí
    echo '<div id="chart_div' . $semana . '" style="width: 100%; height: 500px;"></div>';
    echo '</th>';
    echo '</tr>';
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    echo '</div>';

    echo '<script>
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart' . $semana . ');

    function drawChart' . $semana . '() {
        var data = google.visualization.arrayToDataTable(' . json_encode($data) . ');

        var options = {
            width: "100%", // Ancho al 100% para ser responsive
            height: "auto", // Altura automática
            seriesType: "bars",
            series: {0: {type: "bars"}, 1: {type: "bars"}},
            legend: {
                position: "bottom"
            },
            hAxis: {
                slantedText: false,
                angle: 0
            }
        };

        var chart = new google.visualization.ComboChart(document.getElementById("chart_div' . $semana . '"));
        chart.draw(data, options);

        // Redibujar la gráfica al cambiar el tamaño de la ventana
        window.addEventListener("resize", function(){
            chart.draw(data, options);
        });
    }
    </script>';
}


function obtenerDatosGraficoSemQuin($idEstacion, $year, $mes, $semana, $descripcion, $con){
    
    // Ejemplo ficticio de obtención de datos desde la base de datos
    $puntajeTotalAlejandro = 3;
    $ActividadAlejandro = "Recibos Mexdesa";
    $puntajeObtenidoAlejandro = consultaPuntajeSemQuin($idEstacion, $year, $mes, $semana, $descripcion, $ActividadAlejandro, $con);

    $puntajeTotalEstaciones = 3;
    $ActividadEstaciones = "Recibos Estacion";
    $puntajeObtenidoEstaciones = consultaPuntajeSemQuin($idEstacion, $year, $mes, $semana, $descripcion, $ActividadEstaciones, $con);

    $puntajeTotalOperaciones = 3;
    $ActividadOperativo = "Recibos Operativo";
    $puntajeObtenidoOperaciones = consultaPuntajeSemQuin($idEstacion, $year, $mes, $semana, $descripcion, $ActividadOperativo, $con);

    $nombre = nombreES($idEstacion, $con);

    $data = [
        ['Elemento', 'Puntaje Total', 'Puntaje Obtenido'],
        ['Alejandro Guzman', $puntajeTotalAlejandro, $puntajeObtenidoAlejandro],
        [$nombre, $puntajeTotalEstaciones, $puntajeObtenidoEstaciones],
        ['Revisión Dirección de Operaciones', $puntajeTotalOperaciones, $puntajeObtenidoOperaciones]
    ];

    return $data;
}
 

function consultaPuntajeSemQuin($idEstacion, $year, $mes, $semana, $descripcion, $actividad, $con){
    
    $sql_lista3 = "SELECT puntaje FROM op_recibo_nomina_v2_puntaje WHERE id_estacion = '".$idEstacion."' AND year = '".$year."' AND mes = '".$mes."' AND no_semana_quincena = '".$semana."' AND descripcion = '".$descripcion."' AND actividad = '".$actividad."'";
    $result_lista3 = mysqli_query($con, $sql_lista3);
    $numero_lista3 = mysqli_num_rows($result_lista3);

    if($numero_lista3 == 0){
    $puntaje = 0;
    }else{

    while($row_lista3 = mysqli_fetch_array($result_lista3, MYSQLI_ASSOC)){
    $puntaje = (int)$row_lista3['puntaje'];
    }
    
    }

    return $puntaje;
    
}


//---------- MOSTRAR GRAFICAS DE LAS SEMANAS / QUINCENAS ---------- 
function mostrarGraficoMensual($idEstacion, $year, $mes, $totalSemQui, $descripcion, $con){
    
    $data = obtenerDatosGraficoMensual($idEstacion, $year, $mes, $totalSemQui, $descripcion, $con);
    echo '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">';
    echo '<div class="table-responsive">';
    echo '<table id="tabla_bitacora" class="custom-table" style="font-size: 12.5px; width: 100%;">';
    echo '<thead class="title-table-bg">';
    echo '<tr>';
    echo '<th class="align-middle text-center p-3">';
    echo 'Resumen Mensual';
    echo '</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody class="bg-white">'; 
    echo '<tr>';
    echo '<th class="no-hover">'; // Añadir la clase "no-hover" aquí
    echo '<div id="chart_div_mes' . $mes . '"></div>'; // Eliminado el estilo en línea
    echo '</th>';
    echo '</tr>';
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    echo '</div>';
    
    echo '<script>
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart' . $mes . ');
    
    function drawChart' . $mes . '() {
        var data = google.visualization.arrayToDataTable(' . json_encode($data) . ');
    
        var options = {
            width: "100%", // Ancho al 100% para ser responsive
            height: "510", // Altura automática
            seriesType: "bars",
            series: {0: {type: "bars"}, 1: {type: "bars"}},
            legend: {
                position: "bottom"
            },
            hAxis: {
                slantedText: false,
                angle: 0
            }
        };
    
        var chart = new google.visualization.ComboChart(document.getElementById("chart_div_mes' . $mes . '"));
        chart.draw(data, options);
    }
    </script>';   
}

function obtenerDatosGraficoMensual($idEstacion, $year, $mes, $totalSemQui, $descripcion, $con){
    
    // Ejemplo ficticio de obtención de datos desde la base de datos
    $puntajeTotalAlejandro = $totalSemQui * 3;
    $ActividadAlejandro = "Recibos Mexdesa";
    $puntajeObtenidoAlejandro = consultaPuntajeMensual($idEstacion, $year, $mes, $descripcion, $ActividadAlejandro, $con);

    $puntajeTotalEstaciones = $totalSemQui * 3;
    $ActividadEstaciones = "Recibos Estacion";
    $puntajeObtenidoEstaciones = consultaPuntajeMensual($idEstacion, $year, $mes, $descripcion, $ActividadEstaciones, $con);

    $puntajeTotalOperaciones = $totalSemQui * 3;
    $ActividadOperativo = "Recibos Operativo";
    $puntajeObtenidoOperaciones = consultaPuntajeMensual($idEstacion, $year, $mes, $descripcion, $ActividadOperativo, $con);

    $nombre = nombreES($idEstacion, $con);

    $data = [
        ['Elemento', 'Puntaje Total', 'Puntaje Obtenido'],
        ['Alejandro Guzman', $puntajeTotalAlejandro, $puntajeObtenidoAlejandro],
        [$nombre, $puntajeTotalEstaciones, $puntajeObtenidoEstaciones],
        ['Revisión Dirección de Operaciones', $puntajeTotalOperaciones, $puntajeObtenidoOperaciones]
    ];

    return $data;
}


function consultaPuntajeMensual($idEstacion, $year, $mes, $descripcion, $actividad, $con){
    
    $sql_lista3 = "SELECT puntaje FROM op_recibo_nomina_v2_puntaje WHERE id_estacion = '".$idEstacion."' AND year = '".$year."' AND mes = '".$mes."' AND descripcion = '".$descripcion."' AND actividad = '".$actividad."'";
    $result_lista3 = mysqli_query($con, $sql_lista3);
    $numero_lista3 = mysqli_num_rows($result_lista3);
    $puntaje = 0;

    if($numero_lista3 == 0){
    $puntaje = 0;
    }else{

    while($row_lista3 = mysqli_fetch_array($result_lista3, MYSQLI_ASSOC)){
    $puntaje_mes = (int)$row_lista3['puntaje'];

    $puntaje = $puntaje + $puntaje_mes;
    }
    
    }

    return $puntaje;
    
}



//---------- MOSTRAR GRAFICAS DE LAS SEMANAS / QUINCENAS ---------- 
function mostrarGraficoAnual($idEstacion, $year, $totalYear, $descripcion, $con){
    
    $data = obtenerDatosGraficoAnual($idEstacion, $year, $totalYear, $descripcion, $con);
    echo '<div class="col-12">';
    echo '<div class="table-responsive">';
    echo '<table id="tabla_bitacora" class="custom-table" style="font-size: 12.5px; width: 100%;">';
    echo '<thead class="title-table-bg">';
    echo '<tr>';
    echo '<th class="align-middle text-center p-4" style="font-size: 14px;">';
    echo 'Resumen Anual';
    echo '</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody class="bg-white">'; 
    echo '<tr>';
    echo '<th class="no-hover">'; // Añadir la clase "no-hover" aquí
    echo '<div id="chart_div_year' . $year . '"></div>'; // Eliminado el estilo en línea
    echo '</th>';
    echo '</tr>';
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    echo '</div>';
    
    echo '<script>
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart' . $year . ');
    
    function drawChart' . $year . '() {
        var data = google.visualization.arrayToDataTable(' . json_encode($data) . ');
    
        var options = {
            width: "100%", // Ancho al 100% para ser responsive
            height: 650,
            seriesType: "bars",
            series: {0: {type: "bars"}, 1: {type: "bars"}},
            legend: {
                position: "bottom"
            },
            hAxis: {
                slantedText: false,
                angle: 0
            }
        };
    
        var chart = new google.visualization.ComboChart(document.getElementById("chart_div_year' . $year . '"));
        chart.draw(data, options);
    }
    </script>';   
}


function obtenerDatosGraficoAnual($idEstacion, $year, $totalYear, $descripcion, $con){
    
    // Ejemplo ficticio de obtención de datos desde la base de datos
    $puntajeTotalAlejandro = $totalYear * 3;
    $ActividadAlejandro = "Recibos Mexdesa";
    $puntajeObtenidoAlejandro = consultaPuntajeAnual($idEstacion, $year, $descripcion, $ActividadAlejandro, $con);

    $puntajeTotalEstaciones = $totalYear * 3;
    $ActividadEstaciones = "Recibos Estacion";
    $puntajeObtenidoEstaciones = consultaPuntajeAnual($idEstacion, $year, $descripcion, $ActividadEstaciones, $con);

    $puntajeTotalOperaciones = $totalYear * 3;
    $ActividadOperativo = "Recibos Operativo";
    $puntajeObtenidoOperaciones = consultaPuntajeAnual($idEstacion, $year, $descripcion, $ActividadOperativo, $con);

    $nombre = nombreES($idEstacion, $con);

    $data = [
        ['Elemento', 'Puntaje Total', 'Puntaje Obtenido'],
        ['Alejandro Guzman', $puntajeTotalAlejandro, $puntajeObtenidoAlejandro],
        [$nombre, $puntajeTotalEstaciones, $puntajeObtenidoEstaciones],
        ['Revisión Dirección de Operaciones', $puntajeTotalOperaciones, $puntajeObtenidoOperaciones]
    ];

    return $data;
}


function consultaPuntajeAnual($idEstacion, $year, $descripcion, $actividad, $con){
    
    $sql_lista3 = "SELECT puntaje FROM op_recibo_nomina_v2_puntaje WHERE id_estacion = '".$idEstacion."' AND year = '".$year."' AND descripcion = '".$descripcion."' AND actividad = '".$actividad."'";
    $result_lista3 = mysqli_query($con, $sql_lista3);
    $numero_lista3 = mysqli_num_rows($result_lista3);
    $puntaje = 0;

    if($numero_lista3 == 0){
    $puntaje = 0;
    }else{

    while($row_lista3 = mysqli_fetch_array($result_lista3, MYSQLI_ASSOC)){
    $puntaje_mes = (int)$row_lista3['puntaje'];

    $puntaje = $puntaje + $puntaje_mes;
    }
    
    }

    return $puntaje;
    
}


?>

<div class="row">

<div class="col-12">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Recibo de nomina</a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase"><?=$Titulo;?> (Evaluación <?=$tituloBreadcrumb?> <?=$GET_year?>)</li>

</ol>
</div>
    
<div class="row"> 
<div class="col-10"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"><?=$Titulo;?> (Evaluación <?=$tituloBreadcrumb?> <?=$GET_year?>)</h3> </div>
<div class="col-2"> 

<div class="d-flex align-items-center">
<select class="form-select rounded-0" id="mesEstacion" onchange="SelMesEstaciones(<?=$GET_idEstacion?>,<?=$GET_year?>)"> 
<option value="">Seleccion un mes...</option>    
<?php  
// Array con los nombres de los meses
$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

// Bucle para generar las opciones del menú desplegable
for ($i = 0; $i < count($meses); $i++) {
echo "<option value='".($i+1)."'>$meses[$i]</option>";
}
?>

<option value="13">Anual</option>    
</select>
</div>
  
</div>
</div>
<hr>
</div>
</div>



<div class="row">

<?php

if($GET_idMes == 13){

echo mostrarGraficoAnual($GET_idEstacion, $GET_year, $totalYear, $descripcion, $con);

}else{

//---------- EVALUACION SEMANAL ----------
if($GET_idEstacion == 1 || $GET_idEstacion == 2 || $GET_idEstacion == 3 || $GET_idEstacion == 4 || $GET_idEstacion == 5 || $GET_idEstacion == 9 || $GET_idEstacion == 14){

// Imprimir el resultado como una lista
foreach ($listadoSemanas as $semana) {
$GET_idSemana = (int)$semana;
//$GET_idSemana . '<br>';
echo mostrarGraficoSemQuin($GET_idEstacion, $GET_year, $GET_idMes, $GET_idSemana, $descripcion, $con);
}
$totalMes = count($listadoSemanas);

}else{

foreach ($listadoQuincenas as $quincena) {
$GET_idQuincena = (int)$quincena;
//$GET_idQuincena . '<br>';
echo mostrarGraficoSemQuin($GET_idEstacion, $GET_year, $GET_idMes, $GET_idQuincena, $descripcion, $con);
}

$totalMes = count($listadoQuincenas);
}


echo mostrarGraficoMensual($GET_idEstacion, $GET_year, $GET_idMes, $totalMes, $descripcion, $con);

}

?>


</div>
