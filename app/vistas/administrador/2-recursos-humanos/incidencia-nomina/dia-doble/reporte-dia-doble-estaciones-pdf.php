<?php
require '../../../../../help.php';
require '../../../../../lib/dompdf/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$year = $_GET['year'];
$semana = $_GET['semana'];

// FECHA DE INICIO Y FIN DE LA SEMANA
$fechaSemana = $ClassHerramientasDptoOperativo->fechasNominaSemana($year, $semana);
$inicioSemanaDay = $fechaSemana['inicioSemanaDay'];
$finSemanaDay = $fechaSemana['finSemanaDay'];

//---------- FUNCIONES DE VALIDACIÓN ----------
function ValidaFecha($idPersonal, $dia, $con) {
$sql_asistencia = "SELECT incidencia FROM op_rh_personal_asistencia WHERE id_personal = '".$idPersonal."' AND fecha = '".$dia."' ";
$result_asistencia = mysqli_query($con, $sql_asistencia);

if (mysqli_num_rows($result_asistencia) > 0) {
$row_asistencia = mysqli_fetch_array($result_asistencia, MYSQLI_ASSOC);
return Incidencias($row_asistencia['incidencia'], $dia, $con);
}

return 'S/I';
}

function Incidencias($id, $fecha, $con) {
if ($id == 7 || $id == 8 || $id == 18) {
return "Dia doble";
} else {
$sql = "SELECT detalle FROM op_rh_lista_incidencias WHERE id = '".$id."'";
$result = mysqli_query($con, $sql);
if (mysqli_num_rows($result) > 0) {
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
return validarDiaDoble($row['detalle'], $fecha, $con);
}
}
return "";
}

function validarDiaDoble($detalle, $fecha, $con) {
$dia = date("d", strtotime($fecha));
$mes = date("m", strtotime($fecha));
$year = date("y", strtotime($fecha));

$sql = "SELECT dia, mes, descripcion FROM op_rh_dias_dobles WHERE dia = '".$dia."' AND mes = '".$mes."' ";
$result = mysqli_query($con, $sql);

while ($row = mysqli_fetch_assoc($result)) {
$descripcionD = $row['descripcion'];
        
if ($descripcionD == "Día de la Constitución") {
$fechaDobles = date("Y-m-d", strtotime("first monday of February $year"));
        
} elseif ($descripcionD == "Natalicio de Benito Juárez") {
$fechaDobles = date("Y-m-d", strtotime("third monday of March $year"));
        
} elseif ($descripcionD == "Revolución Mexicana") {
$fechaDobles = date("Y-m-d", strtotime("third monday of November $year"));
} else {
            $fechaDobles = date("Y-m-d", strtotime("$year-{$row['mes']}-{$row['dia']}"));
}

if ($fecha == $fechaDobles) {
return "Dia doble";
}
    
}
    
return $detalle;
}


function diasDoblesEstaciones($idEstacion, $year, $semana, $con) {
  $resultado = "";
  $ClassHerramientasDptoOperativo = new HerramientasDptoOperativo($con);

  // NOMBRE DE LA ESTACION
  $datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($idEstacion);
  $nombreEstacion = $datosEstacion['localidad'];

  // FECHA DE INICIO Y FIN DE LA SEMANA
  $fechaSemana = $ClassHerramientasDptoOperativo->fechasNominaSemana($year, $semana);
  $inicioSemanaDay = $fechaSemana['inicioSemanaDay'];
  $finSemanaDay = $fechaSemana['finSemanaDay'];

  // Obtener los días entre inicio y fin de semana
  $inicioDayObj = new DateTime($inicioSemanaDay); 
  $finDayObj = new DateTime($finSemanaDay);
  $diasEntre = array();
  while ($inicioDayObj <= $finDayObj) {
      $diasEntre[] = $inicioDayObj->format('Y-m-d');
      $inicioDayObj->modify('+1 day');
  }

  $resultado .= '
  <div class="table-responsive">
  <table class="custom-table" style="font-size: .8em;" width="100%">
      <thead class="title-table-bg">
          <tr class="tables-bg">
              <th class="text-center align-middle" colspan="4">'.$nombreEstacion.'</th>
          </tr>
          <tr>
              <td class="text-center align-middle fw-bold" width="48px">No.</td>
              <th class="text-start align-middle">Nombre</th>
              <th class="text-center align-middle">Puesto</th>
              <td class="text-center align-middle fw-bold">Día doble</td>
          </tr>
      </thead>';
              
  $resultado .= '<tbody class="bg-light">';

  // Consulta para obtener el personal de la estación
  $sql_personal = "SELECT 
      op_rh_personal.id, 
      op_rh_personal.nombre_completo, 
      op_rh_puestos.puesto
      FROM op_rh_personal 
      INNER JOIN op_rh_puestos ON op_rh_personal.puesto = op_rh_puestos.id 
      WHERE op_rh_personal.id_estacion = '".$idEstacion."' AND op_rh_personal.estado = 1 
      AND (op_rh_puestos.id = 1 OR op_rh_puestos.id = 6) 
      ORDER BY op_rh_puestos.puesto, op_rh_personal.id ASC";
  
  $result_personal = mysqli_query($con, $sql_personal);
  $numero_personal = mysqli_num_rows($result_personal);

  if ($numero_personal > 0) {
      $num = 1;
      while ($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)) {
          $idPersonal = $row_personal['id'];
          $nombreUser = $row_personal['nombre_completo'];
          $puestoUser = $row_personal['puesto'];
          $diasDobles = [];


          if($idPersonal == 387 || $idPersonal == 358 || $idPersonal == 296 || $idPersonal == 326 || $idPersonal == 300 || $idPersonal == 335){

          }else{
           

          foreach ($diasEntre as $dia) {
              if (ValidaFecha($idPersonal, $dia, $con) == "Dia doble") {
                  $diasDobles[] = $dia;
              }
          }

          // Verificar si hay días dobles para el usuario
          if (count($diasDobles) > 0) {
              $resultado .= '<tr>';
              $resultado .= '<th rowspan="'.count($diasDobles).'" class="text-center align-middle no-hover">'.$num.'</th>';
              $resultado .= '<td rowspan="'.count($diasDobles).'" class="text-start align-middle no-hover">'.$nombreUser.'</td>';
              $resultado .= '<td rowspan="'.count($diasDobles).'" class="text-center align-middle no-hover">'.$puestoUser.'</td>';

              foreach ($diasDobles as $index => $diaDoble) {
                  if ($index > 0) $resultado .= '<tr>';
                  $resultado .= '<th class="text-center align-middle fw-normal no-hover">'.$ClassHerramientasDptoOperativo->FormatoFecha($diaDoble).'</th>';
                  $resultado .= '</tr>';
              }
              $num++;
          } else {
              // Si no tiene días dobles, muestra un mensaje específico para este usuario
              $resultado .= '<tr>';
              $resultado .= '<th class="text-center align-middle no-hover">'.$num.'</th>';
              $resultado .= '<td class="text-start align-middle no-hover">'.$nombreUser.'</td>';
              $resultado .= '<td class="text-center align-middle no-hover">'.$puestoUser.'</td>';
              $resultado .= '<th class="text-center align-middle no-hover text-secondary">No tiene día doble</th>';
              $resultado .= '</tr>';
              $num++;
          }
        }
      }
  } else {
      // Si no hay datos de personal, mostrar mensaje de "No se encontró información para mostrar"
      $resultado .= "<tr><th colspan='4' class='no-hover text-secondary text-center'>No se encontró información para mostrar</th></tr>";
  }

  $resultado .= '</tbody>
  </table>
  </div>
  <br><br>';

  return $resultado;
}


// Genera el contenido HTML de la tabla
ob_start();
?>

<html lang="es">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Dirección de operaciones</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <link rel="shortcut icon" href="<?=RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="apple-touch-icon" href="<?=RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="stylesheet" href="<?=RUTA_CSS2 ?>alertify.css">
  <link rel="stylesheet" href="<?=RUTA_CSS2 ?>themes/default.rtl.css">
  <link href="<?=RUTA_CSS2;?>bootstrap.min.css" rel="stylesheet" />
  <link href="<?=RUTA_CSS2;?>navbar-utilities.min.css" rel="stylesheet" />
  <link href="<?=RUTA_CSS2;?>cards-utilities.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <script src="<?=RUTA_JS?>size-window.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
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


.custom-table {
    width: 100%; /* Asegúrate de que la tabla ocupe el 100% del área disponible */
   
}

    /* Ajuste adicional para las celdas de la tabla */
    .custom-table th,
    .custom-table td {
        max-width: 100px; /* Ajusta según tus necesidades */
        word-wrap: break-word;
    }
      
    .custom-table thead tr, .custom-table thead th {
      border-top: none;
      border-bottom: none !important;
      text-transform: uppercase;
    }
    
    /* Estilo para th en el encabezado de la tabla */
    .custom-table thead th {
      color: #000;
      padding-bottom: 10px;
      padding-top: 10px;
      font-size: 9.5px !important;
    }
    
    .custom-table thead th small {
      color: #000;
    }
     
    /* Estilo para th en el cuerpo de la tabla con mayor especificidad */
    .custom-table thead tr th {
      border: none; 
      color: #fff;
    }
    
    /*---------- TD (DESING TD) ----------- */
    .custom-table tbody th, .custom-table tbody td {
      /* color: #000; */
      padding-bottom: 10px;
      padding-top: 10px;
      font-size: 10.5px !important;
    }
    
    .custom-table tbody th small, .custom-table tbody td small {
      color: #aaaaaa;
    }
    
    .custom-table tbody tr th, .custom-table tbody tr td {
      border: none; 
    }
    
    /* Asegúrate de que no haya reglas más específicas que sobrescriban esta */
.custom-table tbody th, .custom-table tbody td {
    cursor: pointer !important;
  }
    
    .custom-table thead tr th:first-child, .custom-table tbody tr td:first-child{
      border-top-left-radius: 7px;
      border-bottom-left-radius: 0px; 
      
    }
    
    .custom-table thead tr th:last-child {
      border-top-right-radius: 7px;
      border-bottom-right-radius: 0px; 
    }
    
    .custom-table tbody tr.active {
      opacity: .4; 
    }

    /* Mantener el estilo hover para las filas */
    .custom-table tbody tr:hover {
        background-color: #e1e1e1 !important; /* Cambia el color de fondo cuando se hace hover */
        cursor: pointer; /* Cambia el cursor a una mano cuando pasa sobre la fila */
    }

    /* Quitar el estilo hover para celdas específicas */
    .custom-table tbody tr:hover th.no-hover, 
    .custom-table tbody tr:hover td.no-hover {
        background-color: #fff !important; /* Quita el color de fondo cuando se hace hover */
    }

    /* Asegurarse de que el estilo se aplique incluso si hay reglas más específicas */
    .custom-table tbody tr:hover th.no-hover,
    .custom-table tbody tr:hover td.no-hover {
        background-color: #fff !important; /* Quita el color de fondo cuando se hace hover */
    }


    /* Quitar el estilo hover para celdas específicas */
    .custom-table tbody tr:hover th.no-hover2, 
    .custom-table tbody tr:hover td.no-hover2 {
    background-color: #f8f9fa !important; /* Quita el color de fondo cuando se hace hover */
    }
    
    /* Asegurarse de que el estilo se aplique incluso si hay reglas más específicas */
    .custom-table tbody tr:hover th.no-hover2,
    .custom-table tbody tr:hover td.no-hover2 {
    background-color: #f8f9fa !important; /* Quita el color de fondo cuando se hace hover */
    }

    /* Quitar el estilo hover para celdas específicas */
    .custom-table tbody tr:hover th.no-hoverRed, 
    .custom-table tbody tr:hover td.no-hoverRed {
    background-color: #ffb6af !important; /* Quita el color de fondo cuando se hace hover */
    }
        
    /* Asegurarse de que el estilo se aplique incluso si hay reglas más específicas */
    .custom-table tbody tr:hover th.no-hoverRed,
    .custom-table tbody tr:hover td.no-hoverRed {
    background-color: #ffb6af !important; /* Quita el color de fondo cuando se hace hover */

    }

    .tables-bg {
        background: #215D98;
        color: white;
    }

    .title-table-bg {
    background: #749ABF;
    color: white;
    }

    .contenido-table-bg {
    background: #f2f2f2;
    color: dark;
    }
</style>


</head><body>

<div class="row"> 
<div class="col-12">
<h3 class="text-secondary"> Reporte dias dobles de las estaciones <br> Semana <?=$semana?> <br>  del <?=$ClassHerramientasDptoOperativo->formatoFecha($inicioSemanaDay)?> al <?=$ClassHerramientasDptoOperativo->formatoFecha($finSemanaDay)?></h3>
<br><br>
</div>
</div>



<div class="row">
  <?php
  $idsEstaciones = [1, 2, 3, 4, 5, 6, 7, 14]; // Ejemplo de IDs de estaciones a mostrar
  foreach ($idsEstaciones as $idEstacion) {
  echo '<div>'.diasDoblesEstaciones($idEstacion, $year, $semana, $con).'</div>';
  }
  ?>
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
$dompdf->setPaper("A4", "portrait"); // Cambia "landscape" a "portrait"
$dompdf->render();

// Salida del PDF generado al navegador
$dompdf->stream("Reporte de incidencias - Semana ".$semana.".pdf", ["Attachment" => 0]); // Attachment => false lo abre en el navegador
?>

