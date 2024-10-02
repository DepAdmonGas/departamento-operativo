<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$year = $_GET['year'];
$tipo = $_GET['tipo'];
 
//---------- OBTENER EL NOMBRE DE LA ESTACION ----------
function nombreES($GET_idEstacion, $con) {
$Titulo = "";
$sql = "SELECT localidad FROM op_rh_localidades WHERE id = '" . $GET_idEstacion . "'";
$result = mysqli_query($con, $sql);
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
$Titulo = $row['localidad'];
}

return $Titulo;
}
 

$sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}

if($tipo == 1){
$nombreTipo = "Altas del personal";

}else if($tipo == 2){
$nombreTipo = "Bajas del personal";

}


//---------- MOSTRAR GRAFICA (ANUAL) ----------
function mostrarGraficoPersonalMes($GET_idEstacion, $GET_year, $con) {
$data = obtenerDatosPersonalMes($GET_idEstacion, $GET_year, $con);
     
echo '<div class="col-12">';
echo '<div class="table-responsive">';
echo '<table class="custom-table" style="font-size: 12.5px; width: 100%;">';
echo '<thead class="tables-bg">';
echo '<tr>';
echo '<th class="align-middle text-center">';
echo 'Altas del Personal';
echo '</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody class="bg-white">'; 
echo '<tr>';
echo '<th class="no-hover">'; // Añadir la clase "no-hover" aquí
echo '<div id="chart_div_personal' . $GET_idEstacion . '' . $GET_year . '" style="width: 100%; height: 500px;"></div>';
echo '</th>';
echo '</tr>';
echo '</tbody>';
echo '</table>';
echo '</div>';
echo '</div>';

    
echo '<script>
google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChart' . $GET_idEstacion . '' . $GET_year . ');
    
function drawChart' . $GET_idEstacion . '' . $GET_year . '() {
    var data = new google.visualization.DataTable();
    data.addColumn("string", "Mes");
    data.addColumn("number", "No. total de altas");
    data.addColumn({type: "string", role: "style"});

    data.addRows(' . json_encode($data['values']) . ');
     
    var options = {
        width: "100%", // Ancho al 100% para ser responsive
        height: "auto", // Altura automática
        legend: "none",
        colors: ' . json_encode($data['colors'] ?? null) . ',
        title: "Altas del personal - '.nombreES($GET_idEstacion,$con).' \n\n", // Agrega el salto de línea con \n
        hAxis: {
            title: "Meses",
        },
        vAxis: {
            title: "No. de altas del personal"
        },
        fontSize: 13 // Ajusta el tamaño de la fuente aquí
    };
   
    
    var chart = new google.visualization.ColumnChart(document.getElementById("chart_div_personal' . $GET_idEstacion . '' . $GET_year . '"));
    chart.draw(data, options);
}

</script>'; 
}


function obtenerDatosPersonalMes($GET_idEstacion,$GET_year,$con) {
   
$totalEnero = consultaPuntajePersonalMes($GET_idEstacion,$GET_year,1,$con);
$totalFebrero = consultaPuntajePersonalMes($GET_idEstacion,$GET_year,2,$con);
$totalMarzo = consultaPuntajePersonalMes($GET_idEstacion,$GET_year,3,$con);
$totalAbril = consultaPuntajePersonalMes($GET_idEstacion,$GET_year,4,$con);
$totalMayo = consultaPuntajePersonalMes($GET_idEstacion,$GET_year,5,$con);
$totalJunio = consultaPuntajePersonalMes($GET_idEstacion,$GET_year,6,$con);
$totalJulio = consultaPuntajePersonalMes($GET_idEstacion,$GET_year,7,$con);
$totalAgosto = consultaPuntajePersonalMes($GET_idEstacion,$GET_year,8,$con);
$totalSeptiembre = consultaPuntajePersonalMes($GET_idEstacion,$GET_year,9,$con);
$totalOctubre = consultaPuntajePersonalMes($GET_idEstacion,$GET_year,10,$con);
$totalNoviembre = consultaPuntajePersonalMes($GET_idEstacion,$GET_year,11,$con);
$totalDiciembre = consultaPuntajePersonalMes($GET_idEstacion,$GET_year,12,$con);

$totalAnual = $totalEnero + $totalFebrero + $totalMarzo + $totalAbril + $totalMayo + $totalJunio + $totalJulio + $totalAgosto + $totalSeptiembre + $totalOctubre + $totalNoviembre + $totalDiciembre;

    $data = [
        'values' => [
            ['Enero', $totalEnero, '#ca6ed0'],
            ['Febrero', $totalFebrero, '#dc3912'],
            ['Marzo', $totalMarzo, '#ff9900'],
            ['Abril', $totalAbril, '#109618'],
            ['Mayo', $totalMayo, '#990099'],
            ['Junio', $totalJunio, '#0099c6'],
            ['Julio', $totalJulio, '#dd4477'],
            ['Agosto', $totalAgosto, '#66aa00'],
            ['Septiembre', $totalSeptiembre, '#b82e2e'],
            ['Octubre', $totalOctubre, '#316395'],
            ['Noviembre', $totalNoviembre, '#994499'],
            ['Diciembre', $totalDiciembre, '#22aa99'],
            ['Anual', $totalAnual, '#FFD300']
        ]
    ];

    return $data;
}
   
     
function consultaPuntajePersonalMes($GET_idEstacion,$GET_year,$GET_mes,$con){
$sql_lista3 = "SELECT id, fecha_ingreso, nombre_completo FROM op_rh_personal  
WHERE MONTH(fecha_ingreso) = '".$GET_mes."' AND YEAR(fecha_ingreso) = '".$GET_year."' AND id_estacion = '".$GET_idEstacion."'";

$result_lista3 = mysqli_query($con, $sql_lista3);
return $numero_lista3 = mysqli_num_rows($result_lista3);
    
}



//---------- MOSTRAR GRAFICA TODAS LAS ESTACIONES (ANUAL) ----------

function mostrarGraficoPersonalEstaciones($GET_year,$tipo,$con) {
    $data = obtenerDatosPersonalEstaciones($GET_year, $con);
    $mejorPuntaje = obtenerEstacionesConPuntajeMasAlto($GET_year,$tipo,$con);

    echo '<div class="col-12 mt-3">';
    echo '<div class="table-responsive">';
    echo '<table class="custom-table" style="font-size: 12.5px; width: 100%;">';
    echo '<thead class="tables-bg">';
    echo '<tr>';
    echo '<th class="align-middle text-center">';
    echo 'Altas del personal (Anual)';
    echo '</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody class="bg-white">'; 
    echo '<tr>';
    echo '<th class="no-hover">'; // Añadir la clase "no-hover" aquí
    echo '<div id="chart_div_general' . $tipo . '' . $GET_year . '" style="width: 100%; height: 500px;"></div>';
    echo '</th>';
    echo '</tr>';
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    echo '</div>';

    echo '<script>
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart' . $tipo . '' . $GET_year . ');

        function drawChart' . $tipo . '' . $GET_year . '() {
            var data = new google.visualization.DataTable();
            data.addColumn("string", "Mes");
            data.addColumn("number", "No. de altas del personal");
            data.addColumn({type: "string", role: "style"}); // Nueva columna para los colores

            data.addRows(' . json_encode($data['values']) . ');

            var options = {
            width: "100%", // Ancho al 100% para ser responsive
            height: "auto", // Altura automática
                legend: "none",
                colors: ' . json_encode($data['colors'] ?? null) . ',
                title: "Estacion(es) con mayor numero de altas: \n  '.implode(", ", $mejorPuntaje['estaciones']).' - Altas: '.$mejorPuntaje['puntaje'].'\n \n ",
                vAxis: {
                    title: "No. de altas del personal"
                },
                fontSize: 13 // Ajusta el tamaño de la fuente aquí
            };

            var chart = new google.visualization.ColumnChart(document.getElementById("chart_div_general' . $tipo . '' . $GET_year . '"));
            chart.draw(data, options);
        }
    </script>';
}


function obtenerDatosPersonalEstaciones($GET_year, $con) {
    $totalAperturasIN = consultaPersonalEstaciones(1,$GET_year,$con);
    $totalAperturasPS = consultaPersonalEstaciones(2,$GET_year,$con);
    $totalAperturasSA = consultaPersonalEstaciones(3,$GET_year,$con);
    $totalAperturasGA = consultaPersonalEstaciones(4,$GET_year,$con);
    $totalAperturasVG = consultaPersonalEstaciones(5,$GET_year,$con);
    $totalAperturasES = consultaPersonalEstaciones(6,$GET_year,$con);
    $totalAperturasXO = consultaPersonalEstaciones(7,$GET_year,$con);
    $totalAperturasBR = consultaPersonalEstaciones(14,$GET_year,$con);
    $totalAperturasAL = consultaPersonalEstaciones(9,$GET_year,$con);

    //---------- LISTA DE DEPARTAMENTOS -
    $totalAperturasDO = consultaPersonalEstaciones(11,$GET_year,$con);
    $totalAperturasDG = consultaPersonalEstaciones(13,$GET_year,$con);
    $totalAperturasDJ = consultaPersonalEstaciones(18,$GET_year,$con);
    $totalAperturasDM = consultaPersonalEstaciones(15,$GET_year,$con);
    $totalAperturasDS = consultaPersonalEstaciones(16,$GET_year,$con);


    $data = [
        'values' => [
            ['Interlomas', $totalAperturasIN, '#3366cc'],
            ['Palo Solo', $totalAperturasPS, '#dc3912'],
            ['San Agustin', $totalAperturasSA, '#ff9900'],
            ['Gasomira', $totalAperturasGA, '#109618'],
            ['Valle de Guadalupe', $totalAperturasVG, '#990099'],
            ['Esmegas', $totalAperturasES, '#0099c6'],
            ['Xochimilco', $totalAperturasXO, '#dd4477'],
            ['Bosque Real', $totalAperturasBR, '#66aa00'],
            ['Autolavado', $totalAperturasAL, '#0080aa'],
            ['Direccion de Operaciones', $totalAperturasDO, '#6533cc'],
            ['Depto. Gestión', $totalAperturasDG, '#009990'],
            ['Depto. Jurídico', $totalAperturasDJ, '#f87750'],
            ['Depto. Mantenimiento', $totalAperturasDM, '#967777'],
            ['Depto. Sistemas', $totalAperturasDS, '#00e4ff']
        ]
    ];

    return $data;
}


function consultaPersonalEstaciones($GET_idEstacion,$GET_year,$con){
    
    $sql_lista3 = "SELECT id, fecha_ingreso, nombre_completo FROM op_rh_personal  
    WHERE YEAR(fecha_ingreso) = '".$GET_year."' AND id_estacion = '".$GET_idEstacion."'";

    $result_lista3 = mysqli_query($con, $sql_lista3);
    return $numero_lista3 = mysqli_num_rows($result_lista3);

} 

//---------- BAJA DEL PERSONAL (ESTACION) ----------
function mostrarGraficoBajaMes($GET_idEstacion, $GET_year, $con) {
    $data = obtenerDatosBajaMes($GET_idEstacion, $GET_year, $con);
         
    echo '<div class="col-12">';
    echo '<div class="table-responsive">';
    echo '<table class="custom-table" style="font-size: 12.5px; width: 100%;">';
    echo '<thead class="tables-bg">';
    echo '<tr>';
    echo '<th class="align-middle text-center">';
    echo 'Altas del Personal';
    echo '</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody class="bg-white">'; 
    echo '<tr>';
    echo '<th class="no-hover">'; // Añadir la clase "no-hover" aquí
    echo '<div id="chart_div_bajas' . $GET_idEstacion . '' . $GET_year . '" style="width: 100%; height: 500px;"></div>';
    echo '</th>';
    echo '</tr>';
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    echo '</div>';

        
    echo '<script>
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart' . $GET_idEstacion . '' . $GET_year . ');
        
    function drawChart' . $GET_idEstacion . '' . $GET_year . '() {
        var data = new google.visualization.DataTable();
        data.addColumn("string", "Mes");
        data.addColumn("number", "No. total de bajas");
        data.addColumn({type: "string", role: "style"});
    
        data.addRows(' . json_encode($data['values']) . ');
         
        var options = {
            width: "100%", // Ancho al 100% para ser responsive
            height: "auto", // Altura automática
            legend: "none",
            colors: ' . json_encode($data['colors'] ?? null) . ',
            hAxis: {
                title: "Meses",
            },
            vAxis: {
                title: "No. de bajas del personal"
            },
            fontSize: 13 // Ajusta el tamaño de la fuente aquí
        };
        
        var chart = new google.visualization.ColumnChart(document.getElementById("chart_div_bajas' . $GET_idEstacion . '' . $GET_year . '"));
        chart.draw(data, options);
    }
    
    </script>'; 
    }


    function obtenerDatosBajaMes($GET_idEstacion,$GET_year,$con) {
   
    $totalEnero = consultaPuntajeBajaMes($GET_idEstacion,$GET_year,1,$con);
    $totalFebrero = consultaPuntajeBajaMes($GET_idEstacion,$GET_year,2,$con);
    $totalMarzo = consultaPuntajeBajaMes($GET_idEstacion,$GET_year,3,$con);
    $totalAbril = consultaPuntajeBajaMes($GET_idEstacion,$GET_year,4,$con);
    $totalMayo = consultaPuntajeBajaMes($GET_idEstacion,$GET_year,5,$con);
    $totalJunio = consultaPuntajeBajaMes($GET_idEstacion,$GET_year,6,$con);
    $totalJulio = consultaPuntajeBajaMes($GET_idEstacion,$GET_year,7,$con);
    $totalAgosto = consultaPuntajeBajaMes($GET_idEstacion,$GET_year,8,$con);
    $totalSeptiembre = consultaPuntajeBajaMes($GET_idEstacion,$GET_year,9,$con);
    $totalOctubre = consultaPuntajeBajaMes($GET_idEstacion,$GET_year,10,$con);
    $totalNoviembre = consultaPuntajeBajaMes($GET_idEstacion,$GET_year,11,$con);
    $totalDiciembre = consultaPuntajeBajaMes($GET_idEstacion,$GET_year,12,$con);
        
    $totalAnual = $totalEnero + $totalFebrero + $totalMarzo + $totalAbril + $totalMayo + $totalJunio + $totalJulio + $totalAgosto + $totalSeptiembre + $totalOctubre + $totalNoviembre + $totalDiciembre;
        
    $data = [
        'values' => [
        ['Enero', $totalEnero, '#ca6ed0'],
        ['Febrero', $totalFebrero, '#dc3912'],
        ['Marzo', $totalMarzo, '#ff9900'],
        ['Abril', $totalAbril, '#109618'],
        ['Mayo', $totalMayo, '#990099'],
        ['Junio', $totalJunio, '#0099c6'],
        ['Julio', $totalJulio, '#dd4477'],
        ['Agosto', $totalAgosto, '#66aa00'],
        ['Septiembre', $totalSeptiembre, '#b82e2e'],
        ['Octubre', $totalOctubre, '#316395'],
        ['Noviembre', $totalNoviembre, '#994499'],
        ['Diciembre', $totalDiciembre, '#22aa99'],
        ['Anual', $totalAnual, '#FFD300']
        ]
    ];

    return $data;
}

function consultaPuntajeBajaMes($GET_idEstacion,$GET_year,$GET_mes,$con){

$sql_lista3 = "SELECT 
op_rh_personal.nombre_completo,
op_rh_personal.id_estacion,
op_rh_personal_baja.fecha_baja
FROM 
op_rh_personal_baja 
INNER JOIN 
op_rh_personal ON op_rh_personal.id = op_rh_personal_baja.id_personal
WHERE 
MONTH(op_rh_personal_baja.fecha_baja) = '".$GET_mes."'
AND YEAR(op_rh_personal_baja.fecha_baja) = '".$GET_year."'
AND op_rh_personal.id_estacion = '".$GET_idEstacion."'";
  
$result_lista3 = mysqli_query($con, $sql_lista3);
return $numero_lista3 = mysqli_num_rows($result_lista3);
        
}


//---------- BAJA DEL PERSONAL (TODAS LAS ESTACIONES) ----------
function mostrarGraficoBajaEstaciones($GET_year,$tipo,$con) {
    $data = obtenerDatosBajaEstaciones($GET_year,$con);
    $mejorPuntaje = obtenerEstacionesConPuntajeMasAlto($GET_year,$tipo,$con);

    echo '<div class="col-12 mt-3">';
    echo '<div class="table-responsive">';
    echo '<table class="custom-table" style="font-size: 12.5px; width: 100%;">';
    echo '<thead class="tables-bg">';
    echo '<tr>';
    echo '<th class="align-middle text-center">';
    echo 'Bajas del personal (Anual)';
    echo '</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody class="bg-white">'; 
    echo '<tr>';
    echo '<th class="no-hover">'; // Añadir la clase "no-hover" aquí
    echo '<div id="chart_div_general_bajas' . $GET_year . '" style="width: 100%; height: 500px;"></div>';
    echo '</th>';
    echo '</tr>';
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    echo '</div>';

    echo '<script>
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart' . $GET_year . ');

        function drawChart' . $GET_year . '() {
            var data = new google.visualization.DataTable();
            data.addColumn("string", "Mes");
            data.addColumn("number", "No. de bajas del personal");
            data.addColumn({type: "string", role: "style"}); // Nueva columna para los colores

            data.addRows(' . json_encode($data['values']) . ');

            var options = {
            width: "100%", // Ancho al 100% para ser responsive
            height: "auto", // Altura automática
                legend: "none",
                colors: ' . json_encode($data['colors'] ?? null) . ',
                title: "Estacion(es) con mayor numero de bajas: \n  '.implode(", ", $mejorPuntaje['estaciones']).' - Bajas: '.$mejorPuntaje['puntaje'].'\n \n ",
                vAxis: {
                    title: "No. de bajas del personal"
                },
                fontSize: 13 // Ajusta el tamaño de la fuente aquí
            };

            var chart = new google.visualization.ColumnChart(document.getElementById("chart_div_general_bajas' . $GET_year . '"));
            chart.draw(data, options);
        }
    </script>';
}

function obtenerDatosBajaEstaciones($GET_year, $con) {
    $totalAperturasIN = consultaBajasEstaciones(1,$GET_year,$con);
    $totalAperturasPS = consultaBajasEstaciones(2,$GET_year,$con);
    $totalAperturasSA = consultaBajasEstaciones(3,$GET_year,$con);
    $totalAperturasGA = consultaBajasEstaciones(4,$GET_year,$con);
    $totalAperturasVG = consultaBajasEstaciones(5,$GET_year,$con);
    $totalAperturasES = consultaBajasEstaciones(6,$GET_year,$con);
    $totalAperturasXO = consultaBajasEstaciones(7,$GET_year,$con);
    $totalAperturasBR = consultaBajasEstaciones(14,$GET_year,$con);
    $totalAperturasAL = consultaBajasEstaciones(9,$GET_year,$con);

    //---------- LISTA DE DEPARTAMENTOS -
    $totalAperturasDO = consultaBajasEstaciones(11,$GET_year,$con);
    $totalAperturasDG = consultaBajasEstaciones(13,$GET_year,$con);
    $totalAperturasDJ = consultaBajasEstaciones(18,$GET_year,$con);
    $totalAperturasDM = consultaBajasEstaciones(15,$GET_year,$con);
    $totalAperturasDS = consultaBajasEstaciones(16,$GET_year,$con);


    $data = [
        'values' => [
            ['Interlomas', $totalAperturasIN, '#3366cc'],
            ['Palo Solo', $totalAperturasPS, '#dc3912'],
            ['San Agustin', $totalAperturasSA, '#ff9900'],
            ['Gasomira', $totalAperturasGA, '#109618'],
            ['Valle de Guadalupe', $totalAperturasVG, '#990099'],
            ['Esmegas', $totalAperturasES, '#0099c6'],
            ['Xochimilco', $totalAperturasXO, '#dd4477'],
            ['Bosque Real', $totalAperturasBR, '#66aa00'],
            ['Autolavado', $totalAperturasAL, '#0080aa'],
            ['Direccion de Operaciones', $totalAperturasDO, '#6533cc'],
            ['Depto. Gestión', $totalAperturasDG, '#009990'],
            ['Depto. Jurídico', $totalAperturasDJ, '#f87750'],
            ['Depto. Mantenimiento', $totalAperturasDM, '#967777'],
            ['Depto. Sistemas', $totalAperturasDS, '#00e4ff']
        ]
    ];

    return $data;
}


function consultaBajasEstaciones($GET_idEstacion,$GET_year,$con){

    $sql_lista3 = "SELECT 
    op_rh_personal.nombre_completo,
    op_rh_personal.id_estacion,
    op_rh_personal_baja.fecha_baja
    FROM 
    op_rh_personal_baja 
    INNER JOIN 
    op_rh_personal ON op_rh_personal.id = op_rh_personal_baja.id_personal
    WHERE 
    YEAR(op_rh_personal_baja.fecha_baja) = '".$GET_year."'
    AND op_rh_personal.id_estacion = '".$GET_idEstacion."'";

    $result_lista3 = mysqli_query($con, $sql_lista3);
    return $numero_lista3 = mysqli_num_rows($result_lista3);

}


//---------- PUNTAJE MAS ALTO ----------//
function obtenerEstacionesConPuntajeMasAlto($GET_year,$tipo,$con) {
    // Obtener los datos de apertura de todas las estaciones
    if($tipo == 1){
    $data = obtenerDatosPersonalEstaciones($GET_year, $con);

    }else if($tipo == 2){
    $data = obtenerDatosBajaEstaciones($GET_year, $con);

    }

    // Obtener las estaciones y sus aperturas
    $estaciones = array_column($data['values'], 0); // Nombres de las estaciones
    $aperturas = array_column($data['values'], 1); // Valores de apertura

    // Encontrar el puntaje más bajo
    $puntajeMasBajo = max($aperturas);

    // Encontrar los índices de las estaciones con el puntaje más bajo
    $indicesEstacionesMasBajas = array_keys($aperturas, $puntajeMasBajo);

    // Obtener las estaciones con el puntaje más bajo
    $estacionesMasBajas = array_intersect_key($estaciones, array_flip($indicesEstacionesMasBajas));

    return ['puntaje' => $puntajeMasBajo, 'estaciones' => $estacionesMasBajas];
}


?>
 
 <div class="row">


<div class="col-12">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Control de Documentos del Personal</a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase"><?=$nombreTipo?> (<?=$estacion?>), <?=$year?></li>

</ol>
</div>
    
<div class="row"> 
<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"><?=$nombreTipo?> (<?=$estacion?>), <?=$year?></h3> </div>
<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12"> 
<button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="BuscarYear(<?=$idEstacion?>,<?=$tipo?>)"><span class="btn-label2"><i class="fa fa-search"></i></span>Buscar</button>
</div>
</div>
<hr>
</div>


<?php

if($tipo == 1){
$kpiMensual = mostrarGraficoPersonalMes($idEstacion,$year,$con);
$kpiGeneral = mostrarGraficoPersonalEstaciones($year,$tipo,$con);

}else if($tipo == 2){
$kpiMensual = mostrarGraficoBajaMes($idEstacion,$year,$con);
$kpiGeneral = mostrarGraficoBajaEstaciones($year,$tipo,$con);
    
}

?>

</div>


 