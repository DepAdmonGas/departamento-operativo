<?php
require '../../../../help.php';
require '../../../../lib/dompdf/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$year = $_GET['year'];
$semana = $_GET['semana'];

    //---------- VERIFICAR FECHAS LABORALES ----------//
    function ValidaFecha($idPersonal,$dia,$con){
    $Resultado = "";

    $sql_asistencia = "SELECT 
    id, fecha, incidencia FROM op_rh_personal_asistencia 
    WHERE id_personal = '".$idPersonal."' AND fecha = '".$dia."' ";
    $result_asistencia = mysqli_query($con, $sql_asistencia);
    $numero_asistencia = mysqli_num_rows($result_asistencia);
      
    if ($numero_asistencia > 0) {
    while($row_asistencia = mysqli_fetch_array($result_asistencia, MYSQLI_ASSOC)){
    $idincidencia = $row_asistencia['incidencia'];
    $fechaIncidencia = $row_asistencia['fecha'];
  
    $Resultado = Incidencias($idincidencia, $fechaIncidencia, $con);
    }
  
    }else{
      
    $Resultado = 'S/I';
    }
      
    return $Resultado;
    }
  
  
  
    function Incidencias($id, $fecha, $con){
    if($id ==  7 || $id == 8 || $id == 18){
    $resultado = "Dia doble";
    
    }else{
  
    $sql = "SELECT detalle FROM op_rh_lista_incidencias WHERE id = '".$id."' ";
    $result = mysqli_query($con, $sql);
    $numero = mysqli_num_rows($result);
        
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $detalle = $row['detalle'];
    }
  
    $resultado = validarDiaDoble($detalle, $fecha, $con);
  
    }
  
    return $resultado;
    }
  
  
    function validarDiaDoble($detalle, $fecha, $con){
    $fechaDobles = "";
  
    $dia = date("d", timestamp: strtotime($fecha));
    $mes = date(format: "m", timestamp: strtotime($fecha));
    $year = date(format: "y", timestamp: strtotime($fecha));
  
    $sql = "SELECT dia, mes, descripcion FROM op_rh_dias_dobles WHERE dia = '".$dia."' AND mes = '".$mes."' ";
    $result = mysqli_query($con, $sql);
    $numero = mysqli_num_rows($result);
  
    while ($row = mysqli_fetch_assoc($result)) {
    $diaD = $row['dia'];
    $mesD = $row['mes'];
    $descripcionD = $row['descripcion'];
    
    if($descripcionD == "Día de la Constitución"){
    $fechaDobles = date("Y-m-d", strtotime("first monday of February $year"));
  
    }else if($descripcionD == "Natalicio de Benito Juárez"){
    $fechaDobles = date("Y-m-d", strtotime("third monday of March $year"));
  
    }else if($descripcionD == "Revolución Mexicana"){
    $fechaDobles = date("Y-m-d", strtotime("third monday of November $year"));
  
    }else{
    $fechaDobles = date("Y-m-d", strtotime("$year-$mesD-$diaD"));
  
    }
  
    }
  
    if($fecha == $fechaDobles){
    $resultado = "Dia doble";
    }else{
    $resultado = $detalle;
  
    }
  
    return $resultado;
    }


    function tablasNomina($GET_idEstacion,$GET_year,$GET_idSemana,$con){
        $resultado = "";
        $ClassHerramientasDptoOperativo = new HerramientasDptoOperativo($con);
    
        //---------- NOMBRE DE LA ESTACION  ----------
        $datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($GET_idEstacion);
        $nombreEstacion = $datosEstacion['localidad'];
    
        //---------- FECHA DE INICIO Y FIN DE LA SEMANA ----------
        $fechaSemana = $ClassHerramientasDptoOperativo->fechasNominaSemana($GET_year, $GET_idSemana);
        $inicioFechas = $fechaSemana['inicioSemanaDay'];
        $finFechas = $fechaSemana['finSemanaDay'];
    
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
 
        <h1 class="text-secondary"> '.$nombreEstacion.' <br> 
        <div class="mt-1" style="font-size: .7em;">Semana '.$GET_idSemana.'</div>
        <div class="mt-1" style="font-size: .5em;">'.$ClassHerramientasDptoOperativo->FormatoFecha($inicioFechas).' al '.$ClassHerramientasDptoOperativo->FormatoFecha($finFechas).'</div>
        </h1>
        ';

         
        $resultado .= '<div class="table-responsive">';
        $resultado .= '<table class="table table-sm table-bordered table-hover pb-0 mb-0 mt-2" style="font-size: .75em;">';
        $resultado .= '<thead class="tables-bg">';
       
        $resultado .= '<tr>';
        $resultado .= '<th class="text-center align-middle fw-bold" width="48px">No.</th>';
        $resultado .= '<th class="text-start align-middle">Nombre</th>';
        $resultado .= '<th class="text-center align-middle">Puesto</th>';
    
        foreach ($diasEntre as $dia) {
        $resultado .= '<th class="align-middle text-center">'.$ClassHerramientasDptoOperativo->FormatoFecha($dia).'</th>';
        }   
    
        $resultado .= '<th class="align-middle text-center">Retardos</th>';
        $resultado .= '<th class="align-middle text-center">Faltas</th>';
        $resultado .= '<th class="text-center align-middle fw-bold">Dias Dobles</th>';
    
        $resultado .= '</tr>';
        $resultado .= '</thead>'; 
    
        $resultado .= '<tbody class="bg-light">';
    
        $sql_personal = "SELECT 
        op_rh_personal.id,
        op_rh_personal.nombre_completo,
        op_rh_puestos.puesto
        FROM op_rh_personal
        INNER JOIN op_rh_puestos 
        ON op_rh_personal.puesto = op_rh_puestos.id
        WHERE op_rh_personal.id_estacion = '".$GET_idEstacion."' AND op_rh_personal.estado = 1 ORDER BY op_rh_puestos.puesto AND op_rh_personal.id ASC";
        $result_personal = mysqli_query($con, $sql_personal);
        $numero_personal = mysqli_num_rows($result_personal);
       
        $num = 1;
        while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){
        $idPersonal = $row_personal['id'];  
        $nombreUser = $row_personal['nombre_completo'];  
        $puestoUser = $row_personal['puesto'];  
          
        $Retardo = 0;
        $Falta = 0;
        $DiaDoble = 0;
       
        if($idPersonal == 387 || $idPersonal == 358 || $idPersonal == 296 || $idPersonal == 326 || $idPersonal == 300 || $idPersonal == 335){
    
        }else{
    
        $resultado .= '<tr>';
        $resultado .= '<th class="text-center align-middle">'.$num.'</th>';
        $resultado .= '<td class="text-start align-middle">'.$nombreUser.'</td>';
        $resultado .= '<td class="text-center align-middle">'.$puestoUser.'</td>';
    
    
        foreach ($diasEntre as $dia) {
        $Detalle = ValidaFecha($idPersonal,$dia,$con);
              
        if($Detalle == "Dia doble"){
        $DiaDoble = $DiaDoble + 1;
        $Color = 'fw-bold text-success';
          
        }else if($Detalle == "Retardo"){
        $Retardo = $Retardo + 1;
        $Color = 'text-warning';
              
        }else if($Detalle == "Falta" || $Detalle == "Falta fin de semana"){
        $Falta = $Falta + 1;
        $Color = 'text-danger';
              
        }else if($Detalle == "OK"){
        $Color = 'fw-bold text-success';
              
        }else if($Detalle == "Descanso"){
        $Color = 'text-secondary';
              
        }else{
        $Color = 'text-black';
        }
                       
        $resultado .= '<td class="align-middle text-center '.$Color.'">'.$Detalle.'</td>';
          
        } 
    
    
        $resultado .= '<td class="align-middle text-center">'.$Retardo.'</td>';
        $resultado .= '<td class="align-middle text-center">'.$Falta.'</td>';
        $resultado .= '<td class="align-middle text-center">'.$DiaDoble.'</td>';
    
        $resultado .= '</tr>';
        }
        $num++;
        }
    
    
        $resultado .= '</tbody>';
    
        $resultado .= '</table>';
        $resultado .= '</div>
        ';
    
    
    return $resultado;
    
    }


// Genera el contenido HTML de la tabla
ob_start();
?>

<html><head>


<style>
@page {
  margin: 0.8cm 1cm; /* Ajusta los márgenes según sea necesario */
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
</style>


</head><body>


<?=tablasNomina(2, $year, $semana, $con)?>

<div style="page-break-before: always;">
<?=tablasNomina(1, $year, $semana, $con)?>
</div>

<div style="page-break-before: always;">
<?=tablasNomina(3, $year, $semana, $con)?>
</div>

<div style="page-break-before: always;">
<?=tablasNomina(4, $year, $semana, $con)?>
</div>

<div style="page-break-before: always;">
<?=tablasNomina(5, $year, $semana, $con)?>
</div>

<div style="page-break-before: always;">
<?=tablasNomina(6, $year, $semana, $con)?>
</div>

<div style="page-break-before: always;">
<?=tablasNomina(7, $year, $semana, $con)?>
</div>

<div style="page-break-before: always;">
<?=tablasNomina(9, $year, $semana, $con)?>
</div>

<div style="page-break-before: always;">
<?=tablasNomina(14, $year, $semana, $con)?>
</div>

</body></html>

<?php
$html = ob_get_clean(); // Captura el contenido HTML generado

// Configuración de DomPDF
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper("A4", "landscape"); // Cambia "landscape" a "portrait"
$dompdf->render();

// Salida del PDF generado al navegador
$dompdf->stream("Reporte de incidencias - Semana ".$semana.".pdf", ["Attachment" => 0]); // Attachment => false lo abre en el navegador
?>

