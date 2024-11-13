<?php 
  require('../../../../../app/help.php');
  $idEstacion = $_GET['idEstacion'];
  $year = $_GET['year'];
  $semana = $_GET['semana'];

  //---------- NOMBRE DE LA ESTACION  ----------
  $datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($idEstacion);
  $nombreEstacion = $datosEstacion['localidad'];

  //---------- FECHA DE INICIO Y FIN DE LA SEMANA ----------
  $fechaSemana = $ClassHerramientasDptoOperativo->fechasNominaSemana($year, $semana);
  $inicioSemanaDay = $fechaSemana['inicioSemanaDay'];
  $finSemanaDay = $fechaSemana['finSemanaDay'];

  //---------- Convertir las fechas de inicio y fin a objetos DateTime  ----------
  $inicioDayObj = new DateTime($inicioSemanaDay); 
  $finDayObj = new DateTime($finSemanaDay);

  // Inicializar un arreglo para almacenar los días entre el inicio y el fin
  $diasEntre = array();

  // Bucle para recorrer los días entre el inicio y el fin
  while ($inicioDayObj <= $finDayObj) {
  // Agregar el día al arreglo
  $diasEntre[] = $inicioDayObj->format('Y-m-d');
      
  // Avanzar al siguiente día
  $inicioDayObj->modify('+1 day');
  }


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



  ?>

  <div class="row">

  <div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.go(-2)" class="text-uppercase text-primary pointer"><i class="fa-solid fa-home"></i> Recursos Humanos </a></li>
  <li class="breadcrumb-item text-uppercase text-primary pointer" onclick="history.back()">Incidencia de Nomina</li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase"><?=$year?></li>

  </ol>
  </div>
    
  <div class="row"> 
  <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Incidencia de Nomina (<?=$nombreEstacion?>), <?=$year?></h3> </div>
  <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12">
  <div class="d-flex align-items-center">
  <!----- SELECT DE SEMANAS DEL AÑO ----->
  <select class="form-select" id="SemanaEstacion_<?=$idEstacion?>" onchange="SelNoSemana(<?=$idEstacion?>,<?=$year?>)"> 
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

  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3 mt-1">
  <a href="../app/vistas/administrador/2-recursos-humanos/incidencia-nomina/reporte-incidencias-estaciones-pdf.php?year=<?=$year?>&semana=<?=$semana?>" download>
	<button type="button" class="btn btn-labeled2 btn-success">
  <span class="btn-label2"><i class="fa-solid fa-gas-pump"></i></span>Decargar Reporte (Estaciones)</button>
  </a>
  </div>

  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3 mt-1">
  <a href="../app/vistas/administrador/2-recursos-humanos/incidencia-nomina/reporte-incidencias-individual-pdf.php?idEstacion=<?=$idEstacion?>&year=<?=$year?>&semana=<?=$semana?>" download>
	<button type="button" class="btn btn-labeled2 btn-success float-end">
  <span class="btn-label2"><i class="fa-regular fa-file-pdf"></i></span>Decargar Reporte (<?=$nombreEstacion?>)</button>        
  </a>
  </div>

  </div>
  </div>


  <div class="table-responsive">
  <table id="tabla_incidencias_<?=$idEstacion?>_<?=$year?>_<?=$semana?>" class="custom-table" style="font-size: .8em;" width="100%">
  <thead class="tables-bg">

  <tr>
  <th class="text-center align-middle" colspan="13" >Semana <?=$semana?> 
  <br> del <?=$ClassHerramientasDptoOperativo->formatoFecha($inicioSemanaDay)?>
  al <?=$ClassHerramientasDptoOperativo->formatoFecha($finSemanaDay)?></th>
  </tr>

  <tr class="title-table-bg">
  <td class="text-center align-middle fw-bold" width="48px">No.</td>
  <th class="text-start align-middle">Nombre</th>
  <th class="text-center align-middle">Puesto</th>
  <?php
  foreach ($diasEntre as $dia) {
  echo '<th class="align-middle text-center">'.$ClassHerramientasDptoOperativo->FormatoFecha($dia).'</th>';
  }   
  ?>
  <th class="text-center align-middle">No. Retardos</th>
  <th class="text-center align-middle">No. Faltas</th>
  <td class="text-center align-middle fw-bold">Dias Dobles</td>
  </tr>
  </thead>

  <tbody class="bg-white">
  <?php
  $sql_personal = "SELECT 
  op_rh_personal.id,
  op_rh_personal.nombre_completo,
  op_rh_puestos.puesto
  FROM op_rh_personal
  INNER JOIN op_rh_puestos 
  ON op_rh_personal.puesto = op_rh_puestos.id
  WHERE op_rh_personal.id_estacion = '".$idEstacion."' AND op_rh_personal.estado = 1 ORDER BY op_rh_puestos.puesto AND op_rh_personal.id ASC";
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

  echo '<tr>';
  echo '<th class="text-center align-middle">'.$num.'</th>';
  echo '<td class="text-start align-middle">'.$nombreUser.'</td>';
  echo '<td class="text-center align-middle">'.$puestoUser.'</td>';

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
             
  echo '<td class="align-middle text-center '.$Color.'">'.$Detalle.'</td>';

  } 

  echo '<td class="align-middle text-center">'.$Retardo.'</td>';
  echo '<td class="align-middle text-center">'.$Falta.'</td>';
  echo '<td class="align-middle text-center">'.$DiaDoble.'</td>';

  echo '</tr>';

  $num++;
  }
  }

  ?>
  </tbody>
  </table>
  </div>

  </div>
  </div>

