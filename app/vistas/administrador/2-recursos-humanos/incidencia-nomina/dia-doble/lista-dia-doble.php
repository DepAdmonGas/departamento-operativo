<?php 
require('../../../../../../app/help.php');
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
              
  $resultado .= '<tbody class="bg-white">';

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
  </div>';

  return $resultado;
}


?>

  <div class="row">

  <div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-home"></i> Incidencia de Nomina </a></li>
  <li class="breadcrumb-item text-uppercase text-primary pointer" >Dias dobles, <?=$year?></li>
  </ol>
  </div>
    
  <div class="row"> 
  <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Dias dobles, <?=$year?></h3> </div>
  <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12">
  <div class="d-flex align-items-center">
  <!----- SELECT DE SEMANAS DEL AÑO ----->
  <select class="form-select" id="SemanaEstacion_<?=$year?>" onchange="SelNoSemana(<?=$year?>)"> 
  <option value="">Selecciona una semana...</option>
      
  <?php
  // Crear objeto DateTime para el primer día del año
  $startDate = new DateTime("$year-01-01");
  // Asegurarse de obtener el día jueves que inicia la primera semana
  if ($startDate->format('N') !== '4') { // '4' es jueves en ISO-8601
  $startDate->modify('next thursday');
  }
  // Crear objeto DateTime para el último día del año
  $endDate = new DateTime("$year-12-31");
  // Obtener el número de la semana
  $numeroSemana = 1;
  $options = '';
  // Iterar desde la fecha de inicio hasta la fecha de fin
  while ($startDate <= $endDate) {
  $startFormatted = $startDate->format('d-m-Y');
  $endFormatted = $startDate->modify('+6 days')->format('d-m-Y');
  // Construir las opciones para el select
  //$options .= "<option value='$numeroSemana'>Semana $numeroSemana: $startFormatted - $endFormatted</option>";
  $options .= "<option value='$numeroSemana'>Semana $numeroSemana</option>";
  // Avanzar un día para iniciar la siguiente semana
  $startDate->modify('+1 day');
  $numeroSemana++;
  }
  echo $options;
  ?>

  </select>
  </div>
  </div>
  </div>

  <hr>
  </div> 


  <div class="col-12">

  <div class="row">
  <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 mb-2 mt-1">
  <h5 class="text-secondary"> Semana <?=$semana?></h5>
  <h6 class="text-secondary mb-3"> del <?=$ClassHerramientasDptoOperativo->formatoFecha($inicioSemanaDay)?> al <?=$ClassHerramientasDptoOperativo->formatoFecha($finSemanaDay)?></th></h6>
  </div>

  <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 mb-2 mt-1">
  <a href="../app/vistas/administrador/2-recursos-humanos/incidencia-nomina/dia-doble/reporte-dia-doble-estaciones-pdf.php?year=<?=$year?>&semana=<?=$semana?>" download>
	<button type="button" class="btn btn-labeled2 btn-success float-end">
  <span class="btn-label2"><i class="fa-solid fa-gas-pump"></i></span>Decargar reporte PDF</button>
  </a>
  </div>
  </div>


  <div class="row">
  <?php
  $idsEstaciones = [1, 2, 3, 4, 5, 6, 7, 14]; // Ejemplo de IDs de estaciones a mostrar
  foreach ($idsEstaciones as $idEstacion) {
  echo '<div class="mb-3">' . diasDoblesEstaciones($idEstacion, $year, $semana, $con) . '</div>';
  }
  ?>
  </div>

  </div>

  </div>
