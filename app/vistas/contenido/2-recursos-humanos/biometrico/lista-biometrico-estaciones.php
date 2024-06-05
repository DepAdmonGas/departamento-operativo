<?php 
require('../../../../../app/help.php');
$idEstacion = $_GET['idEstacion'];

$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($idEstacion);
$Estacion = $datosEstacion['localidad'];
  
// '".$fecha_mes."' ;

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
op_rh_personal.id_estacion
FROM op_rh_personal_asistencia 
INNER JOIN op_rh_personal 
ON op_rh_personal_asistencia.id_personal = op_rh_personal.id
WHERE op_rh_personal.id_estacion = '".$idEstacion."' 
AND YEAR(op_rh_personal_asistencia.fecha) = '".$fecha_year."' 
AND MONTH(op_rh_personal_asistencia.fecha) = 2 
ORDER BY op_rh_personal_asistencia.fecha DESC  ";

$result_asistencia = mysqli_query($con, $sql_asistencia);
$numero_asistencia = mysqli_num_rows($result_asistencia);
 
//---------- VISUALIZACIONES PUESTOS ----------
if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"){
$ocultarbtn = "d-none";
$ocultatTitle = "";
$valConfiguracion = 0;

if($idEstacion == 9){
$titleMenu = "";  
$tituloTablaPersonal = 'Autolavado';
$ocultarTitle = "d-none";
$divisionTable = "<hr>";
     
}else{
$titleMenu = "Biometrico";  
$tituloTablaPersonal = $Estacion;
$ocultarTitle = "";
$divisionTable = "";
  
}
      
}else{
$ocultarbtn = "";  
$tituloTablaPersonal = $Estacion;
$titleMenu = "Biometrico ($Estacion)";  
$ocultarTitle = "";
$divisionTable = "";
$ocultatTitle = "d-none";
$valConfiguracion = 1;
}


?>


<div class="col-12 <?=$ocultarTitle?>">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Recursos Humanos</a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase"><?=$titleMenu?></li>
</ol>
</div>
   
<div class="row"> 
<div class="col-9"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"><?=$titleMenu?></h3> </div>
  
<div class="col-3">
<div class="text-end">
<div class="dropdown d-inline ms-2">
<button type="button" class="btn dropdown-toggle btn-primary" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
<i class="fa-solid fa-screwdriver-wrench"></i></span>
</button>

<ul class="dropdown-menu">

<li onclick="ModalReporte(<?=$idEstacion?>)"><a class="dropdown-item pointer"> <i class="fa-solid fa-search"></i> Buscar Reporte</a></li>
<li onclick="ConfiguracionBiometrico(<?=$valConfiguracion?>)"><a class="dropdown-item pointer"> <i class="fa-solid fa-gear"></i> Configuracion Biometrico</a></li>

</ul>
</div>

</div>

</div>
</div>

<hr>
</div>

<?=$divisionTable?>

<div id="DivBusquedaReporte" class="pt-0 mt-0">

  <div class="table-responsive">
  <table id="tabla_biometrico_<?=$idEstacion?>" class="custom-table mt-2" style="font-size: .8em;" width="100%">

  <thead class="title-table-bg">

  <tr class="tables-bg <?=$ocultatTitle?>">
  <th class="text-center align-middle fw-bold" colspan="9"><?=$tituloTablaPersonal?></th>
  </tr>

  <tr>
  <td class="text-center align-middle fw-bold">#</td>
  <th class="align-middle text-center">Nombre</th>
  <th class="align-middle text-center">Fecha</th>
  <th class="align-middle text-center">Sistema (Entrada)</th>
  <th class="align-middle text-center">Sistema (Salida)</th>
  <th class="align-middle text-center">Sensor (Entrada)</th>
  <th class="align-middle text-center">Sensor (Salida)</th>
  <th class="align-middle text-center">Detalle</th>
  <td class="text-center align-middle" width="24"><img src="<?=RUTA_IMG_ICONOS;?>incidencia-tb.png"></td>
  </tr>
  </thead>

  <tbody>
  <?php

  if ($numero_asistencia > 0) {
  $num = 1;
  while($row_asistencia = mysqli_fetch_array($result_asistencia, MYSQLI_ASSOC)){
  $id = $row_asistencia['id'];
  $idpersonal = $row_asistencia['id_personal'];
  $nombre_completo = $row_asistencia['nombre_completo'];
  $idEstacion = $row_asistencia['id_estacion'];
  $fecha = $row_asistencia['fecha'];
  $hora_entrada = $row_asistencia['hora_entrada'];
  $hora_salida = $row_asistencia['hora_salida'];
  $hora_entrada_sensor = $row_asistencia['hora_entrada_sensor'];
  $hora_salida_sensor = $row_asistencia['hora_salida_sensor'];
  $retardominutos = $row_asistencia['retardo_minutos'];
  $incidenciadias = $row_asistencia['incidencia_dias'];
  $incidencia = $row_asistencia['incidencia'];
  $ToIncidencia = $row_asistencia['incidencia_dias'];
    
  if($hora_entrada == "00:00:00"){
  $horaentrada = "S/I"; 
  }else{
  $horaentrada = date("g:i a",strtotime($hora_entrada));
  }

  if($hora_salida == "00:00:00"){
  $horasalida = "S/I";  
  }else{
  $horasalida = date("g:i a",strtotime($hora_salida));
  }

  if($hora_entrada_sensor == "00:00:00"){
  $horaentradasensor = "S/I";
  }else{
  $horaentradasensor = date("g:i a",strtotime($hora_entrada_sensor)); 
  }
  if($hora_salida_sensor == "00:00:00"){
  $horasalidasensor = "S/I";
  }else{
  $horasalidasensor = date("g:i a",strtotime($hora_salida_sensor)); 
  }

  if($hora_entrada == "00:00:00" && $hora_salida == "00:00:00"){
  if($hora_entrada_sensor != "00:00:00" && $hora_salida_sensor == "00:00:00"){
  $colorTable = 'style="background-color: #b0f2c2"';
  $colorDetalle = "text-success";
  }else if($hora_entrada_sensor != "00:00:00" && $hora_salida_sensor != "00:00:00"){
  $colorTable = 'style="background-color: #b0f2c2"';
  $colorDetalle = "text-success";
  }else if($hora_entrada == "00:00:00" && $hora_salida == "00:00:00" && $hora_entrada_sensor == "00:00:00" && $hora_salida_sensor == "00:00:00"){
  $colorTable = 'style="background-color: #cfe2ff"';
  $colorDetalle = "text-secondary";
  }

  }else{

  if($hora_entrada_sensor != "00:00:00" || $hora_salida_sensor != "00:00:00"){
  $ts_fin = strtotime($hora_entrada_sensor);
  $ts_ini = strtotime($hora_entrada);

  $retardo = $retardominutos * 60;
  $horainicio = $ts_ini + $retardo;

  if($horainicio < $ts_fin){
  $colorTable = 'style="background-color: #fcfcda"';
  $colorDetalle = "text-warning";

  }else{
  $colorTable = 'style="background-color: #ffffff"'; 
  $colorDetalle = "";
  }

  }else{
  $colorTable = 'style="background-color: #ffb6af"';  
  $colorDetalle = "text-danger";
  }

  }

  $fechaIncidencia = date("d-m-Y",strtotime($fecha."+ ".$ToIncidencia." days")); 
  if(strtotime($fechaIncidencia) < strtotime($fecha_del_dia)){
  $iconIncidencia = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'incidencia-tb.png" onclick="ModalDetalleI('.$idpersonal.','.$id .','.$idEstacion.')" />';
    
  }else{
  $iconIncidencia = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'incidencia-tb.png" onclick="ModalIncidencias('.$idpersonal.','.$id .','.$idEstacion.')" />';
  } 


  $incidenciasUser = $ClassRecursosHumanosGeneral->Incidencias($id);

  if($incidenciasUser > 0){
  $incidencia = '<small><span class="badge rounded-pill bg-info fw-light p-1"> </span></small>';
  }else{
  $incidencia = '';
  }
    

  $detalleAsistencia = $ClassRecursosHumanosGeneral->Detalle($id,$fecha,$hora_entrada,$hora_salida,$hora_entrada_sensor,$hora_salida_sensor,$retardominutos);

  echo '<tr '.$colorTable.'>
  <th class="align-middle fs-6 text-center fw-light"><b>'.$num.'</b></th>
  <td class="align-middle fs-6 font-weight-light">'.$nombre_completo.'</td>
  <td class="align-middle fs-6 font-weight-light"><b>'.$ClassHerramientasDptoOperativo->FormatoFecha($fecha).'</b></td>
  <td class="align-middle fs-6 font-weight-light">'.$horaentrada.'</td>
  <td class="align-middle fs-6 font-weight-light">'.$horasalida.'</td>
  <td class="align-middle fs-6 font-weight-light"><b>'.$horaentradasensor.'</b></td>
  <td class="align-middle fs-6 font-weight-light"><b>'.$horasalidasensor.'</b></td>
  <td class="align-middle fs-6 font-weight-bold '.$colorDetalle.'">'.$detalleAsistencia.'</td>
  <td class="align-middle fs-6 text-center">'.$iconIncidencia.$incidencia.'</td>
  </tr>';
  $num++;
  }

  }else{
  echo "<tr><td colspan='11'><div class='text-secondary text-center p-2 fs-6 fw-light'>No se encontró información para mostrar </div></td></tr>"; 
  }
  ?>
  </tbody>
  </table>
  </div>
  
  </div>