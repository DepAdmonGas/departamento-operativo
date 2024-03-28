<?php 
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];

$sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}

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
WHERE op_rh_personal.id_estacion = '".$idEstacion."' AND YEAR(op_rh_personal_asistencia.fecha) = '".$fecha_year."' AND MONTH(op_rh_personal_asistencia.fecha) = '".$fecha_mes."' ORDER BY op_rh_personal_asistencia.fecha desc  ";
$result_asistencia = mysqli_query($con, $sql_asistencia);
$numero_asistencia = mysqli_num_rows($result_asistencia);

    function AsistenciaIncidencias($id,$con){
    $sql = "SELECT * FROM op_rh_personal_asistencia_incidencia
     WHERE id_asistencia = '".$id."' ";
	$result = mysqli_query($con, $sql);
	return $numero = mysqli_num_rows($result);
    }

   function Incidencias($id,$con){
    $sql = "SELECT detalle FROM op_rh_lista_incidencias
       WHERE id = '".$id."' ";
    $result = mysqli_query($con, $sql);
    $numero = mysqli_num_rows($result);
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $detalle = $row['detalle'];
    }
    return $detalle;
  }
?>


<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0" style="font-size: .9em;">
<thead class="tables-bg">
  <tr>
  <th class="text-center align-middle">#</th>
  <th class="align-middle">Nombre</th>
  <th class="align-middle">Fecha</th>
  <th class="align-middle">Sistema (Entrada)</th>
  <th class="align-middle">Sistema (Salida)</th>
  <th class="align-middle">Sensor (Entrada)</th>
  <th class="align-middle">Sensor (Salida)</th>
  <th class="align-middle">Detalle</th>
  <th class="text-center align-middle" width="24"><img src="<?=RUTA_IMG_ICONOS;?>incidencia-tb.png"></th>
  </tr>
</thead> 
<body>
<?php
	if ($numero_asistencia > 0) {
	while($row_asistencia = mysqli_fetch_array($result_asistencia, MYSQLI_ASSOC)){

		$id = $row_asistencia['id'];
		$idpersonal = $row_asistencia['id_personal'];
		$fecha = $row_asistencia['fecha'];
        $hora_entrada = $row_asistencia['hora_entrada'];
		$hora_entrada_sensor = $row_asistencia['hora_entrada_sensor'];
		$retardominutos = $row_asistencia['retardo_minutos'];
		$incidenciadias = $row_asistencia['incidencia_dias'];
		$idincidencia = $row_asistencia['incidencia'];
		$ToIncidencia = $row_asistencia['incidencia_dias'];
		
		$status = $row_asistencia['status'];

		if($row_asistencia['hora_entrada'] == "00:00:00"){
		$horaentrada = "S/I";	
		}else{
		$horaentrada = date("g:i a",strtotime($row_asistencia['hora_entrada']));
		}

		if($row_asistencia['hora_salida'] == "00:00:00"){
		$horasalida = "S/I";	
		}else{
		$horasalida = date("g:i a",strtotime($row_asistencia['hora_salida']));
		}

		if($row_asistencia['hora_entrada_sensor'] == "00:00:00"){
		$horaentradasensor = "S/I";
		}else{
		$horaentradasensor = date("g:i a",strtotime($row_asistencia['hora_entrada_sensor']));	
		}
		if($row_asistencia['hora_salida_sensor'] == "00:00:00"){
		$horasalidasensor = "S/I";
		}else{
		$horasalidasensor = date("g:i a",strtotime($row_asistencia['hora_salida_sensor']));	
		}

		//-------------------------------------------
		if($row_asistencia['hora_entrada'] == "00:00:00" && $row_asistencia['hora_salida'] == "00:00:00"){
         if($row_asistencia['hora_entrada_sensor'] != "00:00:00" && $row_asistencia['hora_salida_sensor'] == "00:00:00"){
		 $colorTable = "table-success";	
		 $colorDetalle = "text-success";
		 }else if($row_asistencia['hora_entrada_sensor'] != "00:00:00" && $row_asistencia['hora_salida_sensor'] != "00:00:00"){
		 $colorTable = "table-success";	
		 $colorDetalle = "text-success";
		 }else if($row_asistencia['hora_entrada'] == "00:00:00" && $row_asistencia['hora_salida'] == "00:00:00" && $row_asistencia['hora_entrada_sensor'] == "00:00:00" && $row_asistencia['hora_salida_sensor'] == "00:00:00"){
		 $colorTable = "table-light";
		 $colorDetalle = "text-secondary";
		 }
		 }else{

		if($row_asistencia['hora_entrada_sensor'] != "00:00:00" || $row_asistencia['hora_salida_sensor'] != "00:00:00"){
		$ts_fin = strtotime($hora_entrada_sensor);
		$ts_ini = strtotime($hora_entrada);

		$retardo = $retardominutos * 60;
		$horainicio = $ts_ini + $retardo;

		if($horainicio < $ts_fin){
		$colorTable = "table-warning";
		$colorDetalle = "text-warning";
		}else{
		$colorTable = "";
		$colorDetalle = "";
		}

		}else{
		$colorTable = "table-danger";	
		$colorDetalle = "text-danger";
		}

		}
		//-------------------------------------------

		$fechaIncidencia = date("d-m-Y",strtotime($fecha."+ ".$ToIncidencia." days")); 
    	if(strtotime($fechaIncidencia) < strtotime($fecha_del_dia)){
    	$iconIncidencia = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'incidencia-tb.png" onclick="ModalDetalleI
    	('.$idpersonal.','.$row_asistencia['id'].','.$idEstacion.')" />';
    	}else{
    	$iconIncidencia = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'incidencia-tb.png" onclick="ModalIncidencias('.$idpersonal.','.$row_asistencia['id'].','.$idEstacion.')" />';
    	}

    	if(AsistenciaIncidencias($row_asistencia['id'],$con) > 0){
    	$incidencia = '<small><span class="badge rounded-pill bg-info fw-light p-1"> </span></small>';
    	}else{
    	$incidencia = '';
    	}

    	$Detalle = Incidencias($idincidencia,$con);
		

	echo '<tr class="'.$colorTable.'">
	<td class="align-middle fs-6 text-center fw-light"><b>'.$row_asistencia['id'].'</b></td>
	<td class="align-middle fs-6 font-weight-light">'.$row_asistencia['nombre_completo'].'</td>
	<td class="align-middle fs-6 font-weight-light"><b>'.FormatoFecha($fecha).'</b></td>
	<td class="align-middle fs-6 font-weight-light">'.$horaentrada.'</td>
	<td class="align-middle fs-6 font-weight-light">'.$horasalida.'</td>
	<td class="align-middle fs-6 font-weight-light"><b>'.$horaentradasensor.'</b></td>
	<td class="align-middle fs-6 font-weight-light"><b>'.$horasalidasensor.'</b></td>
	<td class="align-middle fs-6 font-weight-bold '.$colorDetalle.'">'.$Detalle.'</td>
	<td class="align-middle fs-6 text-center">'.$iconIncidencia.$incidencia.'</td>
	</tr>';

	}
	}else{
echo "<tr><td colspan='11'><div class='text-secondary text-center p-2 fs-6 fw-light'>No se encontró información para mostrar </div></td></tr>";	
}
?>
</body>
</table>
</div>


<?php
if($idEstacion == 2){
echo '<h6 class="mt-3">Autolavado <hr></h6>';

$sql_asistenciaA = "SELECT 
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
WHERE op_rh_personal.id_estacion = 9 AND YEAR(op_rh_personal_asistencia.fecha) = '".$fecha_year."' AND MONTH(op_rh_personal_asistencia.fecha) = '".$fecha_mes."' ORDER BY op_rh_personal_asistencia.fecha desc  ";
$result_asistenciaA = mysqli_query($con, $sql_asistenciaA);
$numero_asistenciaA = mysqli_num_rows($result_asistenciaA);
?>

<div style="overflow-y: hidden;">
<table class="table table-sm table-bordered table-hover mt-2" style="font-size: .9em;">
<thead>
  <tr>
  <th class="text-center align-middle">#</th>
  <th class="align-middle">Nombre</th>
  <th class="align-middle">Fecha</th>
  <th class="align-middle">Sistema (Entrada)</th>
  <th class="align-middle">Sistema (Salida)</th>
  <th class="align-middle">Sensor (Entrada)</th>
  <th class="align-middle">Sensor (Salida)</th>
  <th class="align-middle">Detalle</th>
  <th class="text-center align-middle" width="24"><img src="<?=RUTA_IMG_ICONOS;?>incidencia-tb.png"></th>
  </tr>
</thead> 
<body>
<?php
	if ($numero_asistenciaA > 0) {
	while($row_asistenciaA = mysqli_fetch_array($result_asistenciaA, MYSQLI_ASSOC)){

		$idA = $row_asistenciaA['id'];
		$idpersonalA = $row_asistenciaA['id_personal'];
		$fechaA = $row_asistenciaA['fecha'];
        $hora_entradaA = $row_asistenciaA['hora_entrada'];
		$hora_entrada_sensorA = $row_asistenciaA['hora_entrada_sensor'];
		$retardominutosA = $row_asistenciaA['retardo_minutos'];
		$incidenciadiasA = $row_asistenciaA['incidencia_dias'];
		$idincidenciaA = $row_asistenciaA['incidencia'];
		$ToIncidenciaA = $row_asistenciaA['incidencia_dias'];
		
		$statusA = $row_asistenciaA['status'];

		if($row_asistenciaA['hora_entrada'] == "00:00:00"){
		$horaentradaA = "S/I";	
		}else{
		$horaentradaA = date("g:i a",strtotime($row_asistenciaA['hora_entrada']));
		}

		if($row_asistenciaA['hora_salida'] == "00:00:00"){
		$horasalidaA = "S/I";	
		}else{
		$horasalidaA = date("g:i a",strtotime($row_asistenciaA['hora_salida']));
		}

		if($row_asistenciaA['hora_entrada_sensor'] == "00:00:00"){
		$horaentradasensorA = "S/I";
		}else{
		$horaentradasensorA = date("g:i a",strtotime($row_asistenciaA['hora_entrada_sensor']));	
		}
		if($row_asistenciaA['hora_salida_sensor'] == "00:00:00"){
		$horasalidasensorA = "S/I";
		}else{
		$horasalidasensorA = date("g:i a",strtotime($row_asistenciaA['hora_salida_sensor']));	
		}

		//-------------------------------------------
		if($row_asistenciaA['hora_entrada'] == "00:00:00" && $row_asistenciaA['hora_salida'] == "00:00:00"){
         if($row_asistenciaA['hora_entrada_sensor'] != "00:00:00" && $row_asistenciaA['hora_salida_sensor'] == "00:00:00"){
		 $colorTableA = "table-success";	
		 $colorDetalleA = "text-success";
		 }else if($row_asistenciaA['hora_entrada_sensor'] != "00:00:00" && $row_asistenciaA['hora_salida_sensor'] != "00:00:00"){
		 $colorTableA = "table-success";	
		 $colorDetalleA = "text-success";
		 }else if($row_asistenciaA['hora_entrada'] == "00:00:00" && $row_asistenciaA['hora_salida'] == "00:00:00" && $row_asistenciaA['hora_entrada_sensor'] == "00:00:00" && $row_asistenciaA['hora_salida_sensor'] == "00:00:00"){
		 $colorTableA = "table-light";
		 $colorDetalleA = "text-secondary";
		 }
		 }else{

		if($row_asistenciaA['hora_entrada_sensor'] != "00:00:00" || $row_asistenciaA['hora_salida_sensor'] != "00:00:00"){
		$ts_finA = strtotime($hora_entrada_sensorA);
		$ts_iniA = strtotime($hora_entradaA);

		$retardoA = $retardominutosA * 60;
		$horainicioA = $ts_iniA + $retardoA;

		if($horainicioA < $ts_finA){
		$colorTableA = "table-warning";
		$colorDetalleA = "text-warning";
		}else{
		$colorTableA = "";
		$colorDetalleA = "";
		}

		}else{
		$colorTableA = "table-danger";	
		$colorDetalleA = "text-danger";
		}

		}
		//-------------------------------------------


		$fechaIncidenciaA = date("d-m-Y",strtotime($fechaA."+ ".$ToIncidenciaA." days")); 
    	if(strtotime($fechaIncidenciaA) < strtotime($fecha_del_diaA)){
    	$iconIncidenciaA = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'incidencia-tb.png" onclick="ModalDetalleI
    	('.$idpersonalA.','.$row_asistenciaA['id'].',9)" />';
    	}else{
    	$iconIncidenciaA = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'incidencia-tb.png" onclick="ModalIncidencias('.$idpersonal.','.$row_asistenciaA['id'].',9)" />';
    	}

    	if(Incidencias($row_asistenciaA['id'],$con) > 0){
    	$incidenciaA = '<small><span class="badge rounded-pill bg-info fw-light p-1"> </span></small>';
    	}else{
    	$incidenciaA = '';
    	}

    	$DetalleA = Incidencias($idincidenciaA,$con);
		

	echo '<tr class="'.$colorTableA.'">
	<td class="align-middle fs-6 text-center fw-light"><b>'.$row_asistenciaA['id'].'</b></td>
	<td class="align-middle fs-6 font-weight-light">'.$row_asistenciaA['nombre_completo'].'</td>
	<td class="align-middle fs-6 font-weight-light"><b>'.FormatoFecha($fechaA).'</b></td>
	<td class="align-middle fs-6 font-weight-light">'.$horaentradaA.'</td>
	<td class="align-middle fs-6 font-weight-light">'.$horasalidaA.'</td>
	<td class="align-middle fs-6 font-weight-light"><b>'.$horaentradasensorA.'</b></td>
	<td class="align-middle fs-6 font-weight-light"><b>'.$horasalidasensorA.'</b></td>
	<td class="align-middle fs-6 font-weight-bold '.$colorDetalleA.'">'.$DetalleA.'</td>
	<td class="align-middle fs-6 text-center">'.$iconIncidenciaA.$incidenciaA.'</td>
	</tr>';

	}
	}else{
echo "<tr><td colspan='11'><div class='text-secondary text-center p-2 fs-6 fw-light'>No se encontró información para mostrar </div></td></tr>";	
}
?>
</body>
</table>
</div>
<?php
}

?>