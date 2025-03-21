<?php
require('../../../app/help.php');

  $GET_idEstacion = $_GET['idEstacion'];
  $GET_year = $_GET['year'];
  $GET_idMes = $_GET['mes'];

  if($GET_idEstacion == 1 || $GET_idEstacion == 2 || $GET_idEstacion == 3 || $GET_idEstacion == 4 || $GET_idEstacion == 5 || $GET_idEstacion == 9 || $GET_idEstacion == 14){
  $descripcion = "Semana";
  //---------- ARRAY DEL NUMERO DE SEMANAS DEL MES ----------
  $listadoSemanas = SemanasDelMes($GET_idMes, $GET_year);

  if($GET_idEstacion == 9){
  $excelEncargados = '';
  $divBuscador = 'col-12';

  }else{
  $divBuscador = 'col-10';
  $excelEncargados = '  <div class="col-2">
  <a class="mt-2 float-end" href="../public/recibo-nomina/vistas/excel-recibo-nomina-despachadores.php?idEstacion=' . $GET_idEstacion . '&year=' . $GET_year . '&mes=' . $GET_idMes . '" download>
  <img src="' . RUTA_IMG_ICONOS . 'excel.png">
  </a></div>';

  }
  
  }else{
  $descripcion = "Quincena";
  //---------- ARRAY DEL NUMERO DE QUINCENAS DEL MES ----------
  $listadoQuincenas = QuincenasDelMes($GET_idMes, $GET_year);
  $excelEncargados = '';
  $divBuscador = 'col-12';

  }

  //---------- OBTENER EL NOMBRE DE LA ESTACION ----------
  $sql = "SELECT localidad FROM op_rh_localidades WHERE id = '".$GET_idEstacion."' ";
  $result = mysqli_query($con, $sql);
  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
  $Titulo = $row['localidad'];
  }
 
  //---------- OBTENER LOS DATOS DEL PERSONAL DE LA ESTACION ----------
  function PersonalNomina($idPersonal, $con){
  $sql = "SELECT
  op_rh_personal.fecha_ingreso, 
  op_rh_personal.no_colaborador, 
  op_rh_personal.nombre_completo, 
  op_rh_puestos.puesto 
  FROM op_rh_personal 
  INNER JOIN op_rh_puestos ON op_rh_personal.puesto = op_rh_puestos.id
  WHERE op_rh_personal.id = '".$idPersonal."' ";
      
  $result = mysqli_query($con, $sql);
  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
  $fecha_ingreso = $row['fecha_ingreso'];
  $no_colaborador = $row['no_colaborador'];
  $nombreNomina = $row['nombre_completo'];
  $puesto = $row['puesto'];
  }
      
  $array = array(
  'fecha_ingreso' => $fecha_ingreso,  
  'no_colaborador' => $no_colaborador, 
  'nombreNomina' => $nombreNomina,
  'puesto' => $puesto
  );
      
  return $array; 
      
  }

  //---------- OBTENER NUMERO DE COMENTARIOS ----------
  function ToComentarios($IdReporte,$con){
  $sql_lista = "SELECT id FROM op_recibo_nomina_v2_comentarios WHERE id_nomina = '".$IdReporte."' ";
  $result_lista = mysqli_query($con, $sql_lista);
  return $numero_lista = mysqli_num_rows($result_lista);      
  }

  //---------- BLOQUEO DE ACTIVIDADES (FINALIZACION) ----------
  function finalizacionEstaciones($idEstacion,$year,$mes,$semana,$descripcion,$con){
  $sql_listaPuntaje = "SELECT id FROM op_recibo_nomina_v2_puntaje WHERE id_estacion = '".$idEstacion."' AND year = '".$year."' AND mes = '".$mes."' AND no_semana_quincena = '".$semana."' AND descripcion = '".$descripcion."' AND actividad = 'Recibos Estacion'";
  $result_listaPuntaje = mysqli_query($con, $sql_listaPuntaje);
  return $numero_listaPuntaje = mysqli_num_rows($result_listaPuntaje);
  }
  

  //---------- CONFIGURACION FINALIZAR RECIBOS DE NOMINA ESTACIONES ----------//
  function botonFinalizarOP($idEstacion,$year,$mes,$semana,$descripcion,$con){
  $finalizacionEstaciones = finalizacionEstaciones($idEstacion,$year,$mes,$semana,$descripcion,$con);
  $numero_lista3 = "";

  if($idEstacion == 1 || $idEstacion == 2 || $idEstacion == 3 || $idEstacion == 4 || $idEstacion == 5 || $idEstacion == 9 || $idEstacion == 14){
  $msg = "La estación no ha finalizado su actividad.";
  }else{
  $msg = "El departamento no ha finalizado su actividad.";
  }

  if($finalizacionEstaciones != 0){
  $sql_lista3 = "SELECT id FROM op_recibo_nomina_v2_puntaje WHERE id_estacion = '".$idEstacion."' AND year = '".$year."' AND mes = '".$mes."' AND no_semana_quincena = '".$semana."' AND descripcion = '".$descripcion."' AND actividad = 'Recibos Operativo'";
  $result_lista3 = mysqli_query($con, $sql_lista3);
  $numero_lista3 = mysqli_num_rows($result_lista3);

  if($numero_lista3 == 0){
  $btnFinalizarES = '<button type="button" class="btn btn-labeled2 btn-success" onclick="FinalizarNomina(3,'.$idEstacion.','.$year.','.$mes.','.$semana.',\''.$descripcion.'\')">
  <span class="btn-label2"><i class="fa-regular fa-circle-check"></i></span>Finalizar actividad</button>';
  
  }else{
  $btnFinalizarES  = '<span class="badge rounded-pill bg-success float-end" style="font-size: .78em;">
  La actividad fue finalizada.</i>
  </span>';
  } 

  }else{
  $btnFinalizarES = '<span class="badge rounded-pill bg-danger float-end" style="font-size: .78em;">'.$msg.'</span>';
  }

  $array = array(
  'num_listaES' => $numero_lista3, 
  'btnFinalizarES' => $btnFinalizarES
  );
  
  return $array; 
          
  }

//---------- PRIMA VACACIONAL ALERTA----------
function ToAlertaBd($id_usuario,$con){
    
$sql_listaPV = "SELECT id, inicio_notificacion, limite_notificacion, titulo_nomina, status
FROM op_recibo_nomina_v2_prima_vacacional
WHERE id_usuario = '".$id_usuario."' AND status = 0 ORDER BY id ASC LIMIT 1";
  
$result_listaPV = mysqli_query($con, $sql_listaPV);
$numero_listaPV = mysqli_num_rows($result_listaPV); 
    
if($numero_listaPV > 0){
    
$valor = 0;
}else{
$valor = 1;
}
  
return $valor;
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
  function QuincenasDelMes($GET_idMes, $GET_year) {
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
  
  function obtenerMesPorSemana($year, $semana) {
  // Crear un objeto DateTime para el primer día de la semana
  $primerDiaSemana = new DateTime();
  $primerDiaSemana->setISODate($year, $semana);
  
  // Obtener el número del mes
  $numeroMes = $primerDiaSemana->format('n');
  
  return $numeroMes;
  }

  function tablasNomina($GET_idEstacion,$GET_year,$GET_idMes,$GET_idSemana,$descripcion,$menorNumero,$con){
  $resultado = "";
  $valSalto = "";

  if($menorNumero != $GET_idSemana){
  $valSalto = "<hr>";
  }

  if($GET_idEstacion == 1 || $GET_idEstacion == 2 || $GET_idEstacion == 3 || $GET_idEstacion == 4 || $GET_idEstacion == 5 || $GET_idEstacion == 9 || $GET_idEstacion == 14){
  //---------- FECHA DE INICIO Y FIN DE LA SEMANA ----------
  $fechaNomiaSemana = fechasNominaSemana($GET_year, $GET_idSemana);
  $inicioFechas = $fechaNomiaSemana['inicioSemanaDay'];
  $finFechas = $fechaNomiaSemana['finSemanaDay'];

  $GET_idMes = obtenerMesPorSemana($GET_year, $GET_idSemana);

  }else{

  //---------- FECHA DE INICIO Y FIN DE LA QUINCENA ----------
  $fechaNomiaQuincena = fechasNominaQuincenas($GET_year,$GET_idMes,$GET_idSemana);
  $inicioFechas = $fechaNomiaQuincena['inicioQuincenaDay'];
  $finFechas = $fechaNomiaQuincena['finQuincenaDay'];
  }


  $sql_lista = "SELECT * FROM op_recibo_nomina_v2 WHERE id_estacion = '".$GET_idEstacion."' AND year = '".$GET_year."' AND mes= '".$GET_idMes."' AND no_semana_quincena = '".$GET_idSemana."' AND descripcion = '".$descripcion."' ORDER BY id_usuario ASC ";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);
    

  //---------- BOTON FINALIZAR DIRECCION DE OPERACIONES ----------
  $configFinalizar = botonFinalizarOP($GET_idEstacion,$GET_year,$GET_idMes,$GET_idSemana,$descripcion,$con);
  $numero_fin_ES = $configFinalizar['num_listaES'];
  $btnFinalizarES = $configFinalizar['btnFinalizarES'];

  if($numero_lista > 0){
  $ocultarFinalizar = "";
  }else{
  $ocultarFinalizar = "d-none";    
  }


  $resultado .= ' '.$valSalto.'
  <div class="mb-3">

  <div class="table-responsive">
  <table id="tabla_nomina_revision" class="custom-table" style="font-size: .9em;" width="100%">

  <thead class="title-table-bg">
  
  <tr class="tables-bg">
  <th class="text-center align-middle tableStyle font-weight-bold" colspan="5">'.$descripcion.' '.$GET_idSemana.' <br> '.formatoFecha($inicioFechas).' al '.formatoFecha($finFechas).'</th>
  <th class="text-center align-middle tableStyle font-weight-bold" colspan="4"> <div class="'.$ocultarFinalizar.'">'.$btnFinalizarES.'</div> </th>
  </tr>

  <tr>
  <td class="text-center align-middle tableStyle fw-bold">#</td>
  <th class="text-center align-middle tableStyle font-weight-bold" width="100">No. Colaborador</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Nombre del personal</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Puesto</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Importe</th>
  <th class="text-center align-middle tableStyle font-weight-bold" width="100">Prima Vacacional</th>
  <th class="align-middle text-center" width="20"><img src="'.RUTA_IMG_ICONOS.'pdf.png"></th>
  <th class="align-middle text-center" width="20"><img src="'.RUTA_IMG_ICONOS.'pdf-firma.png"></th>
  <td class="align-middle text-center" width="20"><img src="'.RUTA_IMG_ICONOS.'icon-comentario-tb.png"></td>

  </tr>
  </thead> 

  <tbody>';

  if ($numero_lista > 0) {
    $num = 1;
    $totalGeneral = 0;

    while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
    $id = $row_lista['id'];
    $id_usuario = $row_lista['id_usuario'];
    $importe_total = $row_lista['importe_total'];
    $prima_vacacional = $row_lista['prima_vacacional'];

    $datosNomina = PersonalNomina($id_usuario, $con);
    $fecha_ingreso = $datosNomina['fecha_ingreso'];
    $no_colaborador = $datosNomina['no_colaborador'];
    $nombreNomina = $datosNomina['nombreNomina'];
    $puestoNomina = $datosNomina['puesto'];

    if($no_colaborador == 0){
    $no_colaborador2 = "S/I";
      
    }else{
    $no_colaborador2 = $no_colaborador;
    }

    $DocumentoNomina = $row_lista['doc_nomina'];
    $DocumentoFirmado = $row_lista['doc_nomina_firma'];
    $DocumentoOriginal = $row_lista['nomina_original'];
    
    $ruta_nomina_archivo = 'href="'.RUTA_ARCHIVOS.'recibos-nomina-v2/acuses/'.$DocumentoNomina.'"';
    $ruta_nomina_archivo_firma = 'href="'.RUTA_ARCHIVOS.'recibos-nomina-v2/firmados/'.$DocumentoFirmado.'"';   
    
//---------- ACUSE DE RECIBO DE NOMINA ----------
    if($DocumentoNomina != ""){
    $archivoNominaAcuse = '<a class="pointer" '.$ruta_nomina_archivo.' download>
    <img src="'.RUTA_IMG_ICONOS.'pdf-firma.png" data-toggle="tooltip" data-placement="top" title="Recibos de nomina firmados">
    </a>';
        
    }else{
    $archivoNominaAcuse = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Sin Información">';
    }
    
    //---------- RECIBO DE NOMINA FIRMADO ----------
    if($DocumentoFirmado != ""){
    $archivoNominaFirma = '<a class="pointer" '.$ruta_nomina_archivo_firma.' download>
    <img src="'.RUTA_IMG_ICONOS.'pdf-firma.png" data-toggle="tooltip" data-placement="top" title="Recibos de nomina firmados">
    </a>';
    
    }else{
    $archivoNominaFirma = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Sin Información">';
    }
    
    //---------- RECIBO DE NOMINA ORIGINAL ----------
    if($DocumentoOriginal != 0){
    $archivoNominaOriginal = '<img src="'.RUTA_IMG_ICONOS.'original-tb.png" data-toggle="tooltip" data-placement="top" title="Recibido">';
    
    }else{
    $archivoNominaOriginal = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="No recibido">';
    }

    //---------- DOCUMENTOS SUBIDOS DEL RECIBO DE NOMINA ----------
    if($DocumentoNomina != "" && $DocumentoFirmado != "" ){
    $bgTable = 'style="background-color: #b0f2c2"';
    
    }else if($DocumentoNomina == "" && $DocumentoFirmado == "" ){
    $bgTable = 'style="background-color: #ffb6af"';
    
    }else{
    $bgTable = 'style="background-color: #fcfcda"';
    
    }

    $totalGeneral = $totalGeneral + $importe_total;
    $ToComentarios = ToComentarios($id,$con);
    
    if($ToComentarios > 0){
    $Nuevo = '<div class="position-absolute" style="margin-bottom: -15px; right: 3px;"><span class="badge bg-danger text-white rounded-circle"><span class="fw-bold" style="font-size: 10px;">'.$ToComentarios.' </span></span></div>';
    }else{
    $Nuevo = ''; 
    } 

    $ToAlertaBD = ToAlertaBd($id_usuario,$con);

    if($prima_vacacional == 0 && $ToAlertaBD == 0 && $numero_fin_ES == 0){
    $badgePV = '<span class="badge rounded-pill bg-warning text-dark">Realizar pago <br>en las proximas semanas</span>';
      
    }else if($prima_vacacional == 1 && $ToAlertaBD == 1){
    $badgePV = '<span class="badge rounded-pill bg-danger">No se realizo el pago <br> del ejercicio correspondiente</span>';
      
    }else if($prima_vacacional == 2 && $ToAlertaBD == 1){
    $badgePV = '<span class="badge rounded-pill bg-success">Se realizo el pago</span>';
      
    }else{
    $badgePV = '';

    }

  $resultado .= '<tr '.$bgTable.'>
  <th class="align-middle text-center"><b>'.$num.'</b></th>
  <td class="align-middle text-center">'.$no_colaborador2 .'</td>
  <td class="align-middle text-center">'.$nombreNomina.'</td>
  <td class="align-middle text-center">'.$puestoNomina.'</td>
  <td class="align-middle text-center">$'.number_format($importe_total,2).'</td>
  <td class="align-middle text-center">'.$badgePV.'</td>
  <td class="align-middle text-center">'.$archivoNominaAcuse.'</td>
  <td class="align-middle text-center">'.$archivoNominaFirma.'</td>
  <td class="align-middle text-center position-relative" onclick="ModalComentario('.$id.','.$GET_idEstacion.','.$GET_year.','.$GET_idMes.','.$GET_idSemana.',\''.$descripcion.'\')">'.$Nuevo.'<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-comentario-tb.png" data-toggle="tooltip" data-placement="top" title="Comentarios"></td>
	</td>
  </tr>';

  $num++;
  }

  $EtiquetaTotal = '$'.number_format($totalGeneral,2).'';

  $resultado .= '<tr class="bg-white">
  <th class="align-middle text-end" colspan="4"><b>Importe Total:</b></th>
  <th class="align-middle text-center"><b>'.$EtiquetaTotal.'</b></th>
  <th class="align-middle text-end" colspan="4"></th>
  </tr>';



  }else{
  $resultado .=  "<tr class='bg-white'><td colspan='16' class='text-center text-secondary no-hover'><small>No se encontró información para mostrar </small></td></tr>";

  }

  $resultado .= '</tbody>
  </table>
  </div>

  </div>';


  return $resultado;

  }

  
  ?>




<div class="row">

<div class="col-12">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Recibo de nomina</a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase"><?=$Titulo;?> (Revisión <?=$ClassHerramientasDptoOperativo->nombremes($GET_idMes)?> <?=$GET_year?>)</li>

</ol>
</div>
    
<div class="row"> 
<div class="col-10"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"><?=$Titulo;?> (Revisión <?=$ClassHerramientasDptoOperativo->nombremes($GET_idMes)?> <?=$GET_year?>)</h3> </div>
<div class="col-2"> 
<div class="row">
  
  <div class="<?=$divBuscador?>">
  <div class="d-flex align-items-center ">
  <select class="form-select rounded-0 float-end" id="mesEstacion" onchange="SelMesEstaciones(<?=$GET_idEstacion?>,<?=$GET_year?>)"> 
  <option value="">Selecciona un mes...</option>    
  <?php  
  // Array con los nombres de los meses
  $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
  
  // Bucle para generar las opciones del menú desplegable
  for ($i = 0; $i < count($meses); $i++) {
  echo "<option value='".($i+1)."'>$meses[$i]</option>";
  }
  ?>
  </select>
  </div>
  </div> 
  
  <?=$excelEncargados?>
  
  </div>
</div>

</div>

<hr>
</div>
</div>



<?php


if($GET_idEstacion == 1 || $GET_idEstacion == 2 || $GET_idEstacion == 3 || $GET_idEstacion == 4 || $GET_idEstacion == 5 || $GET_idEstacion == 9 || $GET_idEstacion == 14){

    // Imprimir el resultado como una lista
    foreach ($listadoSemanas as $semana) {
    $GET_idSemana = (int)$semana;

    // Convertir cada elemento del array a entero
    $listadoSemanasEnteros = array_map('intval', $listadoSemanas);
    // Obtener el menor valor usando la función min
    $menorNumeroS = min($listadoSemanasEnteros);

    //$GET_idSemana . '<br>';
    echo tablasNomina($GET_idEstacion,$GET_year,$GET_idMes,$GET_idSemana,$descripcion,$menorNumeroS,$con);
    //echo mostrarGraficoGoogleCharts($GET_idEstacion, $GET_year, $GET_idMes, $GET_idSemana, $descripcion, $con);
    
    }

}else{ 

    foreach ($listadoQuincenas as $quincena) {
    $GET_idQuincena = (int)$quincena;
    //$GET_idQuincena . '<br>';

    // Convertir cada elemento del array a entero
    $listadoQuincenaEnteros = array_map('intval', $listadoQuincenas);
    // Obtener el menor valor usando la función min
    $menorNumeroQ = min($listadoQuincenaEnteros);
        
    echo tablasNomina($GET_idEstacion,$GET_year,$GET_idMes,$GET_idQuincena,$descripcion,$menorNumeroQ,$con);
    //echo mostrarGraficoGoogleCharts($GET_idEstacion, $GET_year, $GET_idMes, $GET_idQuincena, $descripcion, $con);

    }

}


?>


