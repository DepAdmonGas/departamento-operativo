<?php
require ('../../../app/help.php');
require_once '../../../dompdf2/vendor/autoload.php';

$year = $_GET['year'];
$mes = $_GET['mes'];
$semana = $_GET['semana'];
 
function nombreES($idEstacion,$con){

  $sql_empresa = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
  $result_empresa = mysqli_query($con, $sql_empresa);
  $numero_empresa = mysqli_num_rows($result_empresa);
  while($row_empresa = mysqli_fetch_array($result_empresa, MYSQLI_ASSOC)){
  $nombreEmpresa = $row_empresa['localidad'];	
  }

  return $nombreEmpresa;

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


    $resultado .= '<div class="p-3 border">
 
    <div class="row">

    <div class="col-12">
    <div class="row">

    <div class="col-12">
    <h7 class="text-secondary"> '.nombreES($GET_idEstacion,$con).'</h7>
    <br>
    <h7 class="text-secondary"> '.formatoFecha($inicioFechas).' al '.formatoFecha($finFechas).'</h7>
    </div>';

    $resultado .= '  

    </div> 
    </div>

    </div>
    
    <hr>';
     
    $resultado .= '<div class="table-responsive">';
    $resultado .= '<table class="table table-sm table-bordered table-hover pb-0 mb-0 mt-2" style="font-size: .8em;">';
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



// reference the Dompdf namespace
use Dompdf\Dompdf;
// instantiate and use the dompdf class
$dompdf = new Dompdf();


$contenido .= '<html lang="es">';
$contenido .= '<head>';
$contenido .= '<style type="text/css">';
$contenido .= '
@page {
  margin: 0.3cm 0.3cm; /* Ajusta los márgenes según sea necesario */
}
html {
  font-family: sans-serif;
  line-height: 1;
  -webkit-text-size-adjust: 100%;
  -ms-text-size-adjust: 100%;
  -ms-overflow-style: scrollbar;
  -webkit-tap-highlight-color: transparent;
}

@-ms-viewport {
  width: device-width;
}

article, aside, dialog, figcaption, figure, footer, header, hgroup, main, nav, section {
  display: block;
}

body {
  margin: 0;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
  font-size: .8rem;
  font-weight: 400;
  line-height: 1;
  color: #212529;
  text-align: left;
  background-color: #fff;
}
  .row {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -ms-flex-wrap: wrap;
  flex-wrap: wrap;
  margin-right: -15px;
  margin-left: -15px;
}
.no-gutters {
  margin-right: 0;
  margin-left: 0;
}

.no-gutters > .col,
.no-gutters > [class*="col-"] {
  padding-right: 0;
  padding-left: 0;
}

.col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12, .col,
.col-auto, .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm,
.col-sm-auto, .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, .col-md,
.col-md-auto, .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg,
.col-lg-auto, .col-xl-1, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl,
.col-xl-auto {
  position: relative;
  width: 100%;
  min-height: 1px;
  padding-right: 15px;
  padding-left: 15px;
}
.col-5 {
  -webkit-box-flex: 0;
  -ms-flex: 0 0 41.666667%;
  flex: 0 0 41.666667%;
  max-width: 41.666667%;
}
.col-7 {
  -webkit-box-flex: 0;
  -ms-flex: 0 0 58.333333%;
  flex: 0 0 58.333333%;
  max-width: 58.333333%;
}

.mt-2,
.my-2 {
  margin-top: 0.5rem !important;
}
.bg-light {
  background-color: #f8f9fa !important;
}
.p-1 {
  padding: 0.25rem !important;
}
.p-3 {
  padding: 0.75rem !important;
}
.text-center {
  text-align: center !important;
}
.border {
  border: 1px solid #dee2e6 !important;
}
table {
  border-collapse: collapse;
}
th {
  text-align: inherit;
}
.table {
  width: 100%;
  max-width: 100%;
  margin-bottom: 1rem;
  background-color: transparent;
  border-collapse: collapse;
  font-size: 0.5rem; /* Ajusta el tamaño del texto de la tabla aquí */
}

.table,
.table th,
.table td {
    font-size: 0.5rem; /* Ajusta el tamaño de fuente según sea necesario */
}

.table th,
.table td {
    padding: 0.5rem; /* Ajusta el relleno según sea necesario */
}

.table thead th {
  vertical-align: bottom;
  border-bottom: 2px solid #dee2e6;
}

.table tbody + tbody {
  border-top: 2px solid #dee2e6;
}

.table .table {
  background-color: #fff;
}

.table-sm th,
.table-sm td {
  padding: 0.3rem;
}

.table-bordered {
  border: 1px solid #dee2e6;
}

.table-bordered th,
.table-bordered td {
  border: 1px solid #dee2e6;
}

.table-bordered thead th,
.table-bordered thead td {
  border-bottom-width: 2px;
}

.table-striped tbody tr:nth-of-type(odd) {
  background-color: rgba(0, 0, 0, 0.05);
}
.pb-0,
.py-0 {
  padding-bottom: 0 !important;
}
.mb-0,
.my-0 {
  margin-bottom: 0 !important;
}
.align-middle {
  vertical-align: middle !important;
}
.text-right {
  text-align: right !important;
}
.p-1 {
  padding: 0.25rem !important;
}
.border-0 {
  border: 0 !important;
}
.p-2 {
  padding: 0.5rem !important;
}
.text-end {
  text-align: right !important;
}
h1, .h1 {
  font-size: 1.25rem;
}

h6, .h6 {
  font-size: 1rem;
}

.text-danger {
  color: #dc3545 !important;
}

.text-warning {
  color: #ffc107 !important;
}

.text-success {
  color: #28a745 !important;
}
.text-secondary {
  color: #6c757d !important;
}

h3 {
  font-size: 1rem; /* Ajusta el tamaño de fuente según sea necesario */
}
';
$contenido .= '</style>';
$contenido .= '</head>';
$contenido .= '<body>';

$contenido .= '<div>';
$contenido .= '<h3>Reporte de incidencias - Semana ' . $semana . ' (General)</h3>';
$contenido .= '<div class="pr-2 pl-2 pb-2">' . tablasNomina(2, $year, $mes, $semana, $con) . '</div>';
$contenido .= '</div>';

// Añadir nueva página con contenido adicional
$contenido .= '<div style="page-break-before: always;">';  // Esto insertará un salto de página antes de la nueva sección
$contenido .= '<div class="pr-2 pl-2 pb-2">' . tablasNomina(1, $year, $mes, $semana, $con) . '</div>';
$contenido .= '</div>';

// Añadir nueva página con contenido adicional
$contenido .= '<div style="page-break-before: always;">';  // Esto insertará un salto de página antes de la nueva sección
$contenido .= '<div class="pr-2 pl-2 pb-2">' . tablasNomina(3, $year, $mes, $semana, $con) . '</div>';
$contenido .= '</div>';

// Añadir nueva página con contenido adicional
$contenido .= '<div style="page-break-before: always;">';  // Esto insertará un salto de página antes de la nueva sección
$contenido .= '<div class="pr-2 pl-2 pb-2">' . tablasNomina(4, $year, $mes, $semana, $con) . '</div>';
$contenido .= '</div>';

// Añadir nueva página con contenido adicional
$contenido .= '<div style="page-break-before: always;">';  // Esto insertará un salto de página antes de la nueva sección
$contenido .= '<div class="pr-2 pl-2 pb-2">' . tablasNomina(5, $year, $mes, $semana, $con) . '</div>';
$contenido .= '</div>';

// Añadir nueva página con contenido adicional
$contenido .= '<div style="page-break-before: always;">';  // Esto insertará un salto de página antes de la nueva sección
$contenido .= '<div class="pr-2 pl-2 pb-2">' . tablasNomina(6, $year, $mes, $semana, $con) . '</div>';
$contenido .= '</div>';

// Añadir nueva página con contenido adicional
$contenido .= '<div style="page-break-before: always;">';  // Esto insertará un salto de página antes de la nueva sección
$contenido .= '<div class="pr-2 pl-2 pb-2">' . tablasNomina(7, $year, $mes, $semana, $con) . '</div>';
$contenido .= '</div>';

// Añadir nueva página con contenido adicional
$contenido .= '<div style="page-break-before: always;">';  // Esto insertará un salto de página antes de la nueva sección
$contenido .= '<div class="pr-2 pl-2 pb-2">' . tablasNomina(9, $year, $mes, $semana, $con) . '</div>';
$contenido .= '</div>';

// Añadir nueva página con contenido adicional
$contenido .= '<div style="page-break-before: always;">';  // Esto insertará un salto de página antes de la nueva sección
$contenido .= '<div class="pr-2 pl-2 pb-2">' . tablasNomina(14, $year, $mes, $semana, $con) . '</div>';
$contenido .= '</div>';

$contenido .= '</body>';
$contenido .= '</html>';


$dompdf->loadHtml($contenido);
$dompdf->setPaper("A4", "portrait"); // Cambia "landscape" a "portrait"
$dompdf->render();
$dompdf->get_canvas()->page_text(540, 820, "Página: {PAGE_NUM} de {PAGE_COUNT}", $font, 6, array(0, 0, 0));
$dompdf->stream("Reporte de incidencias - Semana " . $semana . " (Estaciones).pdf");



