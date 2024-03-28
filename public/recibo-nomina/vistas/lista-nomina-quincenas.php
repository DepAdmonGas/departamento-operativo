<?php
require('../../../app/help.php');

   $idEstacion = $_GET['idEstacion'];
   $year = $_GET['year'];
   $quincena = $_GET['quincena'];
   $descripcion = "Quincena";

   if($Session_IDUsuarioBD == 19 || $Session_IDUsuarioBD == 318){
    $ocultarPrima = "";
    $ocultarRecOriginal = "d-none";
  
  }else{
  
    if($Session_IDUsuarioBD == 354){
    $ocultarPrima = "d-none";
    $ocultarRecOriginal = ""; 
    
    }else{
    $ocultarPrima = "d-none";
    $ocultarRecOriginal = "d-none"; 
    }
   
  }
 
  //---------- OBTENER NUMERO DE LA QUINCENA ACTUAL ---------- 
  function QuincenaActual(){
    // Obtener el número del día en el año actual
    $numeroDiaAnio = date('z') + 1; // Se agrega 1 ya que 'z' cuenta desde 0
      
    // Calcular el número de quincena
    $numeroQuincena = ceil($numeroDiaAnio / 15); // Redondear hacia arriba para obtener el número de quincena
    
    return $numeroQuincena;
  }

  //---------- OBTENER NUMERO DEL MES DE LA QUINCENA SELECCIONADA ---------- 
  function obtenerMesPorQuincena($numeroQuincena) {
  // Validar que el número de quincena esté en el rango correcto (1-24)
  if ($numeroQuincena < 1 || $numeroQuincena > 24) {
  return 0;
  }
    
  // Calcular el número de mes
  $mes = ceil($numeroQuincena / 2);

  return $mes;
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

  //---------- CONFIGURACION RECIBO DE NOMINA MEXDESA ----------//
  function documentoNomina($idEstacion,$year,$mes,$quincena,$descripcion,$con){
    $sql_lista4 = "SELECT doc_nomina_acuse FROM op_recibo_nomina_v2_acuses WHERE id_estacion = '".$idEstacion."' AND year = '".$year."' AND mes = '".$mes."' AND no_semana_quincena = '".$quincena."' AND descripcion = '".$descripcion."'";
    $result_lista4 = mysqli_query($con, $sql_lista4);
    $numero_lista4 = mysqli_num_rows($result_lista4);
    
    $finalizacionMexdesa = finalizacionMexdesa($idEstacion,$year,$mes,$quincena,$descripcion,$con);

    if($finalizacionMexdesa == 0){
       
    $acusesArchivo = '<span class="badge rounded-pill bg-danger float-end" style="font-size: .78em;">
    Recibos de Nomina No Disponibles  <i class="fa-solid fa-ban" style="font-size: 16px; margin-left: 3px;"></i>
    </span>';

    }else{

    if($numero_lista4 == 0) {

    $acusesArchivo = '<span class="badge rounded-pill bg-danger float-end" style="font-size: .78em;">
    Recibos de Nomina No Disponibles  <i class="fa-solid fa-ban" style="font-size: 16px; margin-left: 3px;"></i>
    </span>';
     
    }else{
    
    while($row_lista4 = mysqli_fetch_array($result_lista4, MYSQLI_ASSOC)){
    $doc_nomina_acuse = $row_lista4['doc_nomina_acuse'];
    }
     
    $acusesArchivo = '
    <a href="'.RUTA_ARCHIVOS.'recibos-nomina-v2/recibos-mexdesa/'.$doc_nomina_acuse.'" download>
    <span class="badge rounded-pill bg-success float-end pointer text-center" style="font-size: .78em;">
    Descargar Recibos de Nomina del Personal <i class="fa-solid fa-circle-down" style="font-size: 16px; margin-left: 3px;"></i>
    </span>
    </a>';
    }

  }

    return $acusesArchivo;

  }

  //---------- BLOQUEO DE ACTIVIDADES (FINALIZACION) ----------
  function finalizacionMexdesa($idEstacion,$year,$mes,$quincena,$descripcion,$con){

  $sql_listaPuntaje = "SELECT id FROM op_recibo_nomina_v2_puntaje WHERE id_estacion = '".$idEstacion."' AND year = '".$year."' AND mes = '".$mes."' AND no_semana_quincena = '".$quincena."' AND descripcion = '".$descripcion."' AND actividad = 'Recibos Mexdesa'";
  $result_listaPuntaje = mysqli_query($con, $sql_listaPuntaje);
  return $numero_listaPuntaje = mysqli_num_rows($result_listaPuntaje);
  
  }

  //---------- CONFIGURACION FINALIZAR RECIBOS DE NOMINA ESTACIONES ----------//
  function botonFinalizar($idEstacion,$year,$mes,$quincena,$descripcion,$con){

  $finalizacionMexdesa = finalizacionMexdesa($idEstacion,$year,$mes,$quincena,$descripcion,$con);

  if($finalizacionMexdesa != 0){

    $sql_lista3 = "SELECT id FROM op_recibo_nomina_v2_puntaje WHERE id_estacion = '".$idEstacion."' AND year = '".$year."' AND mes = '".$mes."' AND no_semana_quincena = '".$quincena."' AND descripcion = '".$descripcion."' AND actividad = 'Recibos Estacion'";
    $result_lista3 = mysqli_query($con, $sql_lista3);
    $numero_lista3 = mysqli_num_rows($result_lista3);

    if($numero_lista3 == 0){

      $sql_lista4 = "SELECT importe_total,doc_nomina,doc_nomina_firma,nomina_original FROM op_recibo_nomina_v2 WHERE id_estacion = '".$idEstacion."' AND year = '".$year."' AND mes = '".$mes."' AND no_semana_quincena = '".$quincena."' AND descripcion = '".$descripcion."' ";
      $result_lista4 = mysqli_query($con, $sql_lista4);
      $numero_lista4 = mysqli_num_rows($result_lista4);
    
      if($numero_lista4 != 0){
        
      while($row_lista4 = mysqli_fetch_array($result_lista4, MYSQLI_ASSOC)){ 
      $importe_total = $row_lista4['importe_total'];
      $DocumentoNomina = $row_lista4['doc_nomina'];
      $DocumentoFirmado = $row_lista4['doc_nomina_firma'];
      $DocumentoOriginal = $row_lista4['nomina_original'];
      
      if (!empty($importe_total) && !empty($DocumentoNomina) && !empty($DocumentoFirmado)) {
      $docCompleta = 1;
          
      }else{
      $docCompleta = 0;
          
      }
      
      $totalDocumentos = $totalDocumentos + $docCompleta;
      
      }
      
      if($totalDocumentos == $numero_lista4){
      $btnFinalizarES = '<button type="button" class="btn btn-success" onclick="FinalizarNomina(2,'.$idEstacion.','.$year.','.$mes.','.$quincena.',\''.$descripcion.'\')">Finalizar</button>';
      
      }else{
      $btnFinalizarES = '<span class="badge rounded-pill bg-warning float-start text-dark" style="font-size: .78em;">
      No es posible finalizar la actividad, se debe de agregar toda la información.</i>
      </span>';
            
      }
    
      }
  
    }else{
      $btnFinalizarES = '<span class="badge rounded-pill bg-success float-start" style="font-size: .78em;">
      La actividad fue finalizada.</i>
      </span>';
    }


  }else{

      $btnFinalizarES = '<span class="badge rounded-pill bg-danger float-start" style="font-size: .78em;">
      Alejandro Guzman no ha finalizado su actividad.</i>
      </span>';
 
  }

    $array = array(
      'num_listaES' => $numero_lista3, 
      'btnFinalizarES' => $btnFinalizarES
      );
  
    return $array; 
        
  }
  
  //---------- INSERT DE ACUERDO AL NUMERO DE QUINCENA Y AÑO ACTUAL ----------
  $quincenaActual = QuincenaActual();
  $mes = obtenerMesPorQuincena($quincena);

  //---------- FECHA DE INICIO Y FIN DE LA QUINCENA ----------
  $fechaNomiaQuincena = fechasNominaQuincenas($year,$mes,$quincena);
  $inicioQuincenaDay = $fechaNomiaQuincena['inicioQuincenaDay'];
  $finQuincenaDay = $fechaNomiaQuincena['finQuincenaDay'];


   //----- QUITAR ESTO EL DIA 31 -----
   $fecha_actual = new DateTime();
   // Sumar dos días
   $fecha_actual->modify('+5 days');
   $fecha_resultante = $fecha_actual->format('Y-m-d');


  if($finQuincenaDay <= $fecha_resultante && 2024 <= $year && $year <= $fecha_year){

  //----- Configuracion Nomina de Alejandro Guzman ----------
  if($Session_IDUsuarioBD == 354){
  $acusesArchivo = '<img class="ms-3 float-end pointer" onclick="AcusesNomina('.$idEstacion.','.$year.','.$mes.','.$quincena.',\''.$descripcion.'\')" src="'.RUTA_IMG_ICONOS.'archivo-tb.png">';
  
  }else{
  $acusesArchivo = documentoNomina($idEstacion,$year,$mes,$quincena,$descripcion,$con);
  }

  //---------- Boton Finalizar Estaciones----------
  $configFinalizar = botonFinalizar($idEstacion,$year,$mes,$quincena,$descripcion,$con);
  $numero_fin_ES = $configFinalizar['num_listaES'];
  $btnFinalizarES = $configFinalizar['btnFinalizarES'];
  
  $sql_lista2 = "SELECT * FROM op_recibo_nomina_v2 WHERE id_estacion = '".$idEstacion."' AND year = '".$year."' AND mes = '".$mes."' AND no_semana_quincena = '".$quincena."' AND descripcion = '".$descripcion."'";
  $result_lista2 = mysqli_query($con, $sql_lista2);
  $numero_lista2 = mysqli_num_rows($result_lista2);
    
  if ($numero_lista2 == 0) {

  $sql_lista3 = "SELECT id, puesto FROM op_rh_personal WHERE id_estacion = '".$idEstacion."' AND estado = 1";
  $result_lista3 = mysqli_query($con, $sql_lista3);
  $numero_lista3 = mysqli_num_rows($result_lista3);
  
  while($row_lista3 = mysqli_fetch_array($result_lista3, MYSQLI_ASSOC)){ 
  $GET_idUsuario = $row_lista3['id'];
  $GET_idPuesto = $row_lista3['puesto'];


  GuardarPersonalNomina($year,$mes,$quincena,$descripcion,$idEstacion,$GET_idUsuario,$GET_idPuesto,$con);
  
  }
    
  }
  
  }else{
    $acusesArchivo = '';
  }


    //---------- GUARDAR LISTADO DE PERSONAL DE LA ESTACION ----------
  function GuardarPersonalNomina($year,$mes,$quincena,$descripcion,$idEstacion,$idUsuario,$idPuesto,$con){
    $sql_insert = "INSERT INTO op_recibo_nomina_v2 (
    year,
    mes,
    no_semana_quincena,
    descripcion,
    id_estacion,
    id_usuario,
    id_puesto,
    importe_total,
    doc_nomina,
    doc_nomina_firma
    )
    VALUES 
    (
    '".$year."',
    '".$mes."',
    '".$quincena."',
    '".$descripcion."',
    '".$idEstacion."',
    '".$idUsuario."',
    '".$idPuesto."',
    '0',
    '',
    ''
    )";
  
    mysqli_query($con, $sql_insert);
  }


  //---------- OBTENER EL NOMBRE DE LA ESTACION ----------
    $sql = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
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


  
  //---------- ALERTAS PRIMA VACACIONAL ----------
  function ToAlertaPrima($idNomina,$id_usuario,$fecha_del_dia,$con){ 

    $sql_listaPV = "SELECT id, inicio_notificacion, limite_notificacion, titulo_nomina, status
    FROM op_recibo_nomina_v2_prima_vacacional
    WHERE id_usuario = '".$id_usuario."' AND status = 0 ORDER BY id ASC LIMIT 1";
  
    $result_listaPV = mysqli_query($con, $sql_listaPV);
    $numero_listaPV = mysqli_num_rows($result_listaPV); 
  
    if($numero_listaPV > 0){
  
    while($row_listaPV = mysqli_fetch_array($result_listaPV, MYSQLI_ASSOC)){
      $GET_id_primaV = $row_listaPV['id'];
      $inicio_notificacion = $row_listaPV['inicio_notificacion'];
      $limite_notificacion = $row_listaPV['limite_notificacion'];
      $titulo_nomina = $row_listaPV['titulo_nomina'];
      $status = $row_listaPV['status'];
    }
  
    if($limite_notificacion < $fecha_del_dia){
      
    $sql_update = "UPDATE op_recibo_nomina_v2_prima_vacacional 
    SET status = 1 
    WHERE id = '".$GET_id_primaV."'";

  
    if(mysqli_query($con, $sql_update)){

    $sql_update2 = "UPDATE op_recibo_nomina_v2 
    SET prima_vacacional = 1 
    WHERE id = '".$idNomina."'";
    
    mysqli_query($con, $sql_update2);

    }
     
  
    }
    
    }
  
  }

  function ToPrimaVacacional($idNomina,$id_usuario,$year,$fecha_del_dia,$fecha_ingreso,$con){
  
    // Fecha de ingreso usuario (Año que se selecciono)
    $fechaIngresoYear = date("$year-m-d", strtotime($fecha_ingreso));
    $fechaIngresoAlerta = date('Y-m-d', strtotime($fechaIngresoYear . ' +11 months'));
        
    if (date('Y', strtotime($fechaIngresoAlerta)) > $year) {
    $fechaIngresoAlerta = date('Y-m-d', strtotime($fechaIngresoAlerta . ' -1 year'));
    $year = date('Y', strtotime($fechaIngresoAlerta . ' -1 year'));
    }
      
    $fechaEstimada = date('Y-m-d', strtotime($fechaIngresoAlerta));
    $limiteUnAnio = date('Y-m-d', strtotime('+1 year -1 week', strtotime($fechaEstimada)));

    // Verificar si la fecha estimada está dentro del rango de un año desde la fecha actual y no es una fecha pasada
    if ($fechaEstimada <= $fecha_del_dia) {
    
    //---------- Consulta prima vacacional usuario -----
    $sql_listaPV = "SELECT id FROM op_recibo_nomina_v2_prima_vacacional WHERE id_usuario = '".$id_usuario."' AND titulo_nomina = 'Prima Vacacional " . $year . "'";
    $result_listaPV = mysqli_query($con, $sql_listaPV);
    $numero_listaPV = mysqli_num_rows($result_listaPV); 
    
    if($numero_listaPV == 0){
    
      $sql_insert = "INSERT INTO op_recibo_nomina_v2_prima_vacacional 
      (
      inicio_notificacion,
      limite_notificacion,
      id_usuario,
      titulo_nomina,
      status
      )

      VALUES 
      (
      '".$fechaEstimada."',
      '".$limiteUnAnio."',
      '".$id_usuario."',
      'Prima Vacacional " . $year . "',
      0
      )";
      
      mysqli_query($con, $sql_insert);

    }

    }

    ToAlertaPrima($idNomina,$id_usuario,$fecha_del_dia,$con);

  }
 

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

 
  //---------- OBTENER NUMERO DE COMENTARIOS ----------
  function ToComentarios($IdReporte,$con){

  $sql_lista = "SELECT id FROM op_recibo_nomina_v2_comentarios WHERE id_nomina = '".$IdReporte."' ";
  $result_lista = mysqli_query($con, $sql_lista);
  return $numero_lista = mysqli_num_rows($result_lista);
            
  }


  //---------- CONFIGURACION DE VISTAS  ----------
  if($session_nompuesto == "Sistemas" || $session_nompuesto == "Gestoria" || $session_nompuesto == "Mantenimiento" || $session_nompuesto == "Departamento Jurídico"){
  $inicioDiv = "";
  $finDiv = "";
    
  }else{
  $inicioDiv = '<div class="border-0 p-3">';
  $finDiv = "</div>";  
  }


  $finalizacionMexdesa = finalizacionMexdesa($idEstacion,$year,$mes,$quincena,$descripcion,$con);


  $sql_lista = "SELECT * FROM op_recibo_nomina_v2 WHERE id_estacion = '".$idEstacion."' AND year = '".$year."' AND mes = '".$mes."' AND no_semana_quincena = '".$quincena."' AND descripcion = '".$descripcion."' ORDER BY id_usuario ASC ";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);

?>



<?=$inicioDiv?>

<div class="row">

<?php 
if($session_nompuesto == "Sistemas" || $session_nompuesto == "Gestoria" || $session_nompuesto == "Mantenimiento" || $session_nompuesto == "Departamento Jurídico"){

?>

  <div class="col-10">
  <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    
  <div class="row">
  <div class="col-12">

  <h5>Recibo de Nomina - Quincena <?=$quincena?></h5>
    
  </div>
  </div>

  </div>


<?php 
}else{

?>
  
  <div class="col-10">
  <h5><?=$Titulo;?> - Quincena <?=$quincena?></h5>
  </div>

<?php 
}
?>
  
<div class="col-2">
<div class="d-flex align-items-center">

<!----- SELECT DE QUINCENAS DEL AÑO ----->
<select class="form-select" id="QuincenaEstacion" onchange="SelNoQuincena(<?=$idEstacion?>,<?=$year?>)"> 

<option value="">Selecciona una quincena...</option>

<?php
// Inicializar la variable de enumeración

$quincenaNumero = 1;

for ($mes = 1; $mes <= 12; $mes++) {
  echo "<option value='" . $quincenaNumero . "'>Quincena " . $quincenaNumero . "</option><br>";
  $quincenaNumero++;
  echo "<option value='" . $quincenaNumero . "'>Quincena " . $quincenaNumero . "</option><br>";
  $quincenaNumero++;

  // Calcular el primer día del mes
  //$primer_dia = mktime(0, 0, 0, $mes, 1, $year);
    
  // Calcular el último día del mes
  //$ultimo_dia = mktime(0, 0, 0, $mes + 1, 0, $year);

  // Agregar opciones al elemento select
  //$options .= "<option value='" . $quincenaNumero++ . "'>Quincena " . $quincenaNumero - 1 . ": " . date('d-m-Y', $primer_dia) . " al 15-" . date('m-Y', $primer_dia) . "</option>";
  //$options .= "<option value='" . $quincenaNumero++ . "'>Quincena " . $quincenaNumero -1 . ": 16-" . date('m-Y', $primer_dia) . " al " . date('d-m-Y', $ultimo_dia) . "</option>";
  }

?>

</select>

</div>
 
</div>

</div>

<hr>


<div class="row">

<div class="col-12 mb-3">
<?=$acusesArchivo?>
</div>

</div>


<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0" style="font-size: .9em;">

<thead class="tables-bg">
  
<tr>
  <th class="text-center align-middle tableStyle font-weight-bold" colspan="15"><?=formatoFecha($inicioQuincenaDay)?> al <?=formatoFecha($finQuincenaDay)?></th>
  </tr>
   
<tr>
  <th class="text-center align-middle tableStyle font-weight-bold">#</th>
  <th class="text-center align-middle tableStyle font-weight-bold" width="100">No. Colaborador</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Nombre del personal</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Puesto</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Importe</th>
  <th class="text-center align-middle tableStyle font-weight-bold <?=$ocultarPrima?>" width="100">Prima Vacacional</th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf-firma.png"></th>
  <th class="align-middle text-center <?=$ocultarRecOriginal?>" width="20"><img src="<?=RUTA_IMG_ICONOS;?>original-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-comentario-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
  </tr>
</thead> 

<tbody> 
<?php
if ($numero_lista > 0) {
$num = 1;
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
  
  
  if($Session_IDUsuarioBD == 354){

    //---------- DOCUMENTOS SUBIDOS DEL RECIBO DE NOMINA ----------
    if($DocumentoNomina != "" && $DocumentoFirmado != "" && $DocumentoOriginal != 0 && $importe_total != 0){
      $bgTable = 'style="background-color: #b0f2c2"';
      
      }else if($DocumentoNomina == "" && $DocumentoFirmado == "" && $DocumentoOriginal == 0 && $importe_total == 0){
      $bgTable = 'style="background-color: #ffb6af"';
      
      }else{
      $bgTable = 'style="background-color: #fcfcda"';
      
      }
    
    
    }else{
    
    //---------- DOCUMENTOS SUBIDOS DEL RECIBO DE NOMINA ----------
    if($DocumentoNomina != "" && $DocumentoFirmado != ""  && $importe_total != 0){
      $bgTable = 'style="background-color: #b0f2c2"';
      
      }else if($DocumentoNomina == "" && $DocumentoFirmado == "" && $importe_total == 0){
      $bgTable = 'style="background-color: #ffb6af"';
      
      }else{
      $bgTable = 'style="background-color: #fcfcda"';
      
      }
    
    }

  if($importe_total == 1){
    $importe_total2 = 0;
  }else{
    $importe_total2 = $importe_total;
  }
  
  $totalGeneral = $totalGeneral + $importe_total2;
  
  $ToComentarios = ToComentarios($id,$con);
  
  if($ToComentarios > 0){
  $Nuevo = '<div class="float-end" style="margin-bottom: -5px"><span class="badge bg-danger text-white rounded-circle"><small>'.$ToComentarios.'</small></span></div>';
  }else{
  $Nuevo = ''; 
  } 

  if($finalizacionMexdesa != 0){
    
    $editarNominaUser = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="EditarRecibosNomina('.$id.','.$idEstacion.','.$year.','.$quincena.',\''.$descripcion.'\')" data-toggle="tooltip" data-placement="top" title="Subir Recibo de Nomina">';
  
  
    }else{
    $editarNominaUser = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'editar-tb.png">';
  
    }

$ToPrimaVacacional = ToPrimaVacacional($id,$id_usuario,$year,$fecha_del_dia,$fecha_ingreso,$con);
$ToAlertaBD = ToAlertaBd($id_usuario,$con);


if($prima_vacacional == 0 && $ToAlertaBD == 0 ){
  $badgePV = '<span class="badge rounded-pill bg-warning text-dark">Realizar pago <br>en las proximas semanas</span>';

}else if($prima_vacacional == 1 && $ToAlertaBD == 1){
  $badgePV = '<span class="badge rounded-pill bg-danger">No se realizo el pago <br> del ejercicio correspondiente</span>';

}else if($prima_vacacional == 2 && $ToAlertaBD == 1){
  $badgePV = '<span class="badge rounded-pill bg-success">Se realizo el pago</span>';

}else{
  $badgePV = '';

}


echo '<tr '.$bgTable.'>';
echo '<td class="align-middle text-center"><b>'.$num.'</b></td>';
echo '<td class="align-middle text-center">'.$no_colaborador2 .'</td>';
echo '<td class="align-middle text-center">'.$nombreNomina.'</td>';
echo '<td class="align-middle text-center">'.$puestoNomina.'</td>';
echo '<td class="align-middle text-center">$'.number_format($importe_total,2).'</td>'; 
echo '<td class="align-middle text-center '.$ocultarPrima.'">'.$badgePV.'</td>'; 

echo '<td class="align-middle text-center">
        '.$archivoNominaAcuse.'
	  </td>'; 

echo '<td class="align-middle text-center">
        '.$archivoNominaFirma.'
	  </td>'; 

    echo '<td class="align-middle text-center '.$ocultarRecOriginal.'">
    '.$archivoNominaOriginal.'
    </td>'; 

echo '<td class="align-middle text-center">
'.$Nuevo.'<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-comentario-tb.png" onclick="ModalComentario('.$id.','.$idEstacion.','.$year.','.$mes.','.$quincena.',\''.$descripcion.'\')" data-toggle="tooltip" data-placement="top" title="Comentarios">
</td>';

echo '<td class="align-middle text-center">'.$editarNominaUser.'</td>'; 

echo '</tr>';

$num++;
}


$EtiquetaTotal = '<h6 class="text-end"> Importe Total: '.$totalGeneral.' </h6>';

}else{
echo "<tr><td colspan='16' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";

$EtiquetaTotal = '<h6 class="text-end"> Importe Total: 0 </h6>';

}

?>


</tbody>
</table>
</div>

<hr>

<div class="row">

<div class="col-6 mb-3">
<?=$btnFinalizarES?>
</div>

<div class="col-6">
<?=$EtiquetaTotal?>
</div>

</div>

</div>   

<?=$finDiv?>