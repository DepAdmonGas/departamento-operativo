<?php 
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];

$sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}


if ($Session_IDUsuarioBD == 19 || $Session_IDUsuarioBD == 318) {
$evaluacionPersonal = '<img class="float-end pointer ms-2" src="'.RUTA_IMG_ICONOS.'grafico.png" width="26px" onclick="EvaluacionPersonal('.$idEstacion.')">';
}

//---------- OCULTAR TITULO ----------
if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"){
$divInicio = "";
$menuRH = "";
$divFin = "";

}else{
$divInicio = '<div class="border-0 p-3">';
$menuRH = '<div class="row">

<div class="col-11">
<h5>'.$estacion.'</h5>
</div>

<div class="col-1">
<img class="float-end pointer ms-2" src="'.RUTA_IMG_ICONOS.'agregar.png" onclick="Mas('.$idEstacion.')">

<a class="ms-2 float-end " href="public/recursos-humanos/vistas/personal-excel.php?idEstacion='.$idEstacion.'" download>
<img src="'.RUTA_IMG_ICONOS.'excel.png">
</a>

'.$evaluacionPersonal.'

</div>
 
</div>

<hr>';

$divFin = "<div>";

}

if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"){
    $ocultartb = "d-none";   
}else{
    $ocultartb = "";    
} 


//---------- OBTENER NUMERO DE COMENTARIOS ----------
function ToComentarios($idPersonal,$con){
$sql_lista = "SELECT id FROM op_rh_personal_comentarios WHERE id_personal = '".$idPersonal."' ";
$result_lista = mysqli_query($con, $sql_lista);
	
return $numero_lista = mysqli_num_rows($result_lista);      
}

function PersonalBaja($idPersonal,$con){
$sql_baja = "SELECT * FROM op_rh_personal_baja WHERE id_personal = '".$idPersonal."' ";
$result_lista_baja = mysqli_query($con, $sql_baja);
$numero_lista_baja = mysqli_num_rows($result_lista_baja);


if($numero_lista_baja != 0){
	
while($row_lista_baja = mysqli_fetch_array($result_lista_baja, MYSQLI_ASSOC)){

$id_baja = $row_lista_baja['id'];
$fecha_baja = formatoFecha($row_lista_baja['fecha_baja']);
$estado_proceso = $row_lista_baja['estado_proceso'];

}

}else{
	
$id_baja = "";
$fecha_baja = "S/I";
$estado_proceso = 0;

}


$array = array(
    'num_listaBaja' => $numero_lista_baja, 
	'id_baja' => $id_baja, 
    'fecha_baja' => $fecha_baja,
	'estado_proceso' => $estado_proceso
  );
  
  return $array; 

}


function tablaPersonal($idEstacion,$info,$ocultartb,$con){
	
	$sql_personal = "SELECT
	op_rh_personal.id,
	op_rh_personal.id_estacion,
	op_rh_personal.fecha_ingreso,
	op_rh_personal.no_colaborador,
	op_rh_personal.nombre_completo,
	op_rh_personal.puesto AS idPuesto,
	
	op_rh_personal.documentos,
	op_rh_personal.requisicion,
	op_rh_personal.curriculum,
	op_rh_personal.ine,
	op_rh_personal.acta_nacimiento,
	op_rh_personal.c_domicilio,
	op_rh_personal.nss,
	op_rh_personal.c_estudios,
	op_rh_personal.c_recomendacion,
	op_rh_personal.curp,
	op_rh_personal.a_infonavit,
	op_rh_personal.rfc,
	op_rh_personal.c_antecedentes,
	 
	op_rh_personal.contrato,
	op_rh_personal.sd,
	op_rh_puestos.puesto,
	op_rh_personal.estado
	FROM op_rh_personal
	INNER JOIN op_rh_puestos 
	ON op_rh_personal.puesto = op_rh_puestos.id 
	WHERE op_rh_personal.id_estacion = '".$idEstacion."' AND op_rh_personal.estado = '".$info."' ORDER BY op_rh_personal.id ASC ";
	$result_personal = mysqli_query($con, $sql_personal);
	$numero_personal = mysqli_num_rows($result_personal);

	if($info == 1){
	$tituloTabla = "PERSONAL ACTIVO";
	$margentb = "mb-0";
	$buscadorMgn = "mb-3";
	$tablaInfo = "";
	$detalleBtnBuscar = "Buscar Personal Activo...";
	
	}else{
	$tituloTabla = "PERSONAL NO ACTIVO";
	$margentb = "mt-3";
	$buscadorMgn = "mt-3";
	$tablaInfo = '<th class="align-middle">Fecha de baja</th>';
	$detalleBtnBuscar = "Buscar Personal No Activo...";
	}

	$resultado .= '<div class="row '.$ocultartb.'">
	<div class="col-12 '.$buscadorMgn.'">
	<div class="float-end">
	<input type="text" class="form-control" placeholder="'.$detalleBtnBuscar.'" oninput="Buscar(this,'.$info.','.$idEstacion.')">
	</div>
 
	</div>	
	</div>';


	$resultado .= '<div id="BuscarPersonal'.$info.'">';

	$resultado .= '
	<div class="table-responsive">
	<table class="table table-sm table-bordered table-hover p-0 '.$margentb.'" style="font-size: .78em;">
	<thead class="tables-bg">
	
		<tr class="text-center align-middle bg-light text-dark">
		<th colspan="26">'.$tituloTabla.'</th>
		</tr>
	
		<tr class="text-center align-middle">
		<th>#</th>
		<th class="align-middle">Fecha ingreso</th>
		'.$tablaInfo.'
		<th class="align-middle" width="24">No. de colaborador</th>
		<th class="align-middle">Nombre completo</th>
		<th class="align-middle">Puesto</th>
		<th class="align-middle">Documentos <br>Personales</th>
	
		<th class="align-middle">RP</th>
		<th class="align-middle">CV</th>
		<th class="align-middle">IO</th>
		<th class="align-middle">AN</th>
		<th class="align-middle">CD</th>
		<th class="align-middle">CAI</th>
		<th class="align-middle">CE</th>
		<th class="align-middle">CR</th> 
		<th class="align-middle">CURP</th>
		<th class="align-middle">ARI</th>
		<th class="align-middle">CSF</th>
		<th class="align-middle">CANP</th>
	
		<th class="align-middle">Contrato</th>
		<th class="align-middle">SD</th>';
		// <th class="text-center align-middle" width="24"><img src="'.RUTA_IMG_ICONOS.'archivo-tb.png"></th> -->
		$resultado .= '<th class="text-center align-middle" width="24"><img src="'.RUTA_IMG_ICONOS.'reloj-tb.png"></th>
		<th class="text-center align-middle" width="24"><img src="'.RUTA_IMG_ICONOS.'huella-dactilar-tb.png"></th>';
		//<th class="text-center align-middle" width="24"><img src="'.RUTA_IMG_ICONOS.'nomina-tb.png"></th> 
		$resultado .= '<th class="text-center align-middle" width="24"><img src="'.RUTA_IMG_ICONOS.'editar-tb.png"></th>';
		//<th class="text-center align-middle '.$ocultartb.'" width="24"><img src="'.RUTA_IMG_ICONOS.'pago-tb.png"></th>
		$resultado .= '<th class="text-center align-middle" width="24"><img src="'.RUTA_IMG_ICONOS.'comentario-tb.png"></th>
		<th class="text-center align-middle '.$ocultartb.'" width="24"><img src="'.RUTA_IMG_ICONOS.'usuario-eliminar-tb.png"></th>
		</tr>
	</thead> 
	<tbody>';

	if ($numero_personal > 0) {
	while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){
	$id = $row_personal['id'];
	$fecha_ingreso = $row_personal['fecha_ingreso'];
	
	$puesto = $row_personal['puesto'];
	
	$Documento = $row_personal['documentos'];
	$requisicion = $row_personal['requisicion'];
	$curriculum = $row_personal['curriculum'];
	$ine = $row_personal['ine'];
	$acta_nacimiento = $row_personal['acta_nacimiento'];
	$c_domicilio = $row_personal['c_domicilio'];
	$nss = $row_personal['nss'];
	$c_estudios = $row_personal['c_estudios'];
	$nss = $row_personal['nss'];
	$c_recomendacion = $row_personal['c_recomendacion'];
	$curp = $row_personal['curp'];
	$a_infonavit = $row_personal['a_infonavit'];
	$rfc = $row_personal['rfc'];
	$c_antecedentes = $row_personal['c_antecedentes'];
	
	$contrato = $row_personal['contrato'];
	
	$extensionCurp = pathinfo($curp, PATHINFO_EXTENSION);
	$extensionRfc = pathinfo($rfc, PATHINFO_EXTENSION);
	$extensionNss = pathinfo($nss, PATHINFO_EXTENSION);
	
	//---------- COMENTARIOS DEL PERSONAL -----------
	$ToComentarios = ToComentarios($id,$con);

	if($ToComentarios > 0){
	$Nuevo = '<div class="float-end" style="margin-bottom: -5px"><span class="badge bg-danger text-white rounded-circle"><small>'.$ToComentarios.'</small></span></div>';
	}else{
	$Nuevo = ''; 
	} 

	
	//---------- LLENADO DE DATOS DE LA TABLA -----------

	if($puesto == "Despachador"){
	
	if($curriculum != "" && $ine != "" && $acta_nacimiento != "" && $c_domicilio != "" &&  $nss != "" && $c_estudios != "" && $nss != "" && $c_recomendacion != ""
	&& $curp != "" && $rfc != "" && $c_antecedentes != "" && $contrato != ""){
	$bgTable = 'style="background-color: #b0f2c2"';
			
	}else if($curriculum == "" && $ine == "" && $acta_nacimiento == "" && $c_domicilio == "" &&  $nss == "" && $c_estudios == "" && $nss == "" && $c_recomendacion == ""
	&& $curp == "" && $rfc == "" && $c_antecedentes == "" && $contrato == ""){
	$bgTable = 'style="background-color: #ffb6af"';
			
	}else{
	$bgTable = 'style="background-color: #fcfcda"';
			
	}
	
	}else{
	
	if($curriculum != "" && $ine != "" && $acta_nacimiento != "" && $c_domicilio != "" &&  $nss != "" && $c_estudios != "" && $nss != "" && $c_recomendacion != ""
	&& $curp != "" && $rfc != "" && $contrato != ""){
	$bgTable = 'style="background-color: #b0f2c2"';
		
	}else if($curriculum == "" && $ine == "" && $acta_nacimiento == "" && $c_domicilio == "" &&  $nss == "" && $c_estudios == "" && $nss == "" && $c_recomendacion == ""
	&& $curp == "" && $rfc == "" && $contrato == ""){
	$bgTable = 'style="background-color: #ffb6af"';
		
	}else{
	$bgTable = 'style="background-color: #fcfcda"';
		
	} 
		
	}
	    

	//----- Requisicion del Personal ----- 
	if($requisicion != ""){
	$detallerequisicion = '<a href="'.RUTA_ARCHIVOS.'documentos-personal/requisicion/'.$requisicion.'" download>
	<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Documentos Personales"></a>';
	
	}else{
	$detallerequisicion = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Sin Información">';   
	}
	
	//----- Curriculum Vitae ----- 
	if($curriculum != ""){
	$detallecurriculum = '<a href="'.RUTA_ARCHIVOS.'documentos-personal/curriculum/'.$curriculum.'" download>
	<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Curriculum Vitae"></a>';
		
	}else{
	$detallecurriculum = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Sin Información">';   
	}
	
	//----- Identificacion Oficial -----
	if($ine != ""){
	
	$nombreArchivoINE = "../../../archivos/documentos-personal/ine/$ine";
	if (file_exists($nombreArchivoINE)) {
	$fechaHoy = date("Y-m-d");
	$fechaCreacion = filectime($nombreArchivoINE);
	$nuevaFecha = strtotime('+1 year', $fechaCreacion);
	$fechaFormateada = date('Y-m-d', $nuevaFecha);
	 
	if($fechaFormateada <= $fechaHoy){
	$bg_alerta = 'actualizar-tb.png';
	}else{ 
	$bg_alerta = 'pdf.png';
	}
		 		  
	}else{
	$bg_alerta = 'pdf.png';
	}
	 
	$detalleIne = '<a href="'.RUTA_ARCHIVOS.'documentos-personal/ine/'.$ine.'" download> 
	<img class="pointer" src="'.RUTA_IMG_ICONOS.''.$bg_alerta.'" data-toggle="tooltip" data-placement="top" title="Identificacion Oficial"></a>';
		
	}else{
	$detalleIne = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Sin Información">';   
	}
	
	//----- Acta de Nacimiento ----- 
	if($acta_nacimiento != ""){
	$detalleacta = '<a href="'.RUTA_ARCHIVOS.'documentos-personal/acta_nacimiento/'.$acta_nacimiento.'" download>
	<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Acta de Nacimiento"></a>';
			
	}else{
	$detalleacta = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Sin Información">';   
	}
	
	//----- Comprobante de Domicilio ----- 
	if($c_domicilio != ""){
	$detallec_domicilio = '<a href="'.RUTA_ARCHIVOS.'documentos-personal/comprobante_domicilio/'.$c_domicilio.'" download>
	<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Comprobante de Domicilio"></a>';
				
	}else{
	$detallec_domicilio = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Sin Información">';   
	}
	
	//----- Comprobante de Afiliación del IMSS ----- 
	if($extensionNss == "pdf" || $extensionNss == "jpg" || $extensionNss == "png" || $extensionNss == "txt" || $extensionNss == "xml" || $extensionNss == "jpeg" || $extensionNss == "JPG" || $extensionNss == "JPEG" ){
	$detalleNss = '<a href="'.RUTA_ARCHIVOS.'/documentos-personal/nss/'.$nss.'" download>
	<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Comprobante de Afiliación del IMSS"></a>';
		
	}else if($nss == ""){ 
	$detalleNss = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Sin Información">';   
						
	}else{
	$detalleNss = $nss;
	$bgTable = 'style="background-color: #fcfcda"';
	}
	
	
	
	//----- Comprobante de Estudios ----- 
	if($c_estudios != ""){
	$detallec_estudios = '<a href="'.RUTA_ARCHIVOS.'documentos-personal/comprobante_estudios/'.$c_estudios.'" download>
	<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Comprobante de Estudios"></a>';
		
	}else{
	$detallec_estudios = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Sin Información">';   
	}
	
	//----- Cartas de Recomendación ----- 
	if($c_recomendacion != ""){
	$detallec_recomendacion = '<a href="'.RUTA_ARCHIVOS.'documentos-personal/cartas_recomendacion/'.$c_recomendacion.'" download>
	<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Cartas de Recomendación"></a>';
			
	}else{
	$detallec_recomendacion = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Sin Información">';   
	}
		
	//----- CURP ----- 
	if($extensionCurp == "pdf" || $extensionCurp == "jpg" || $extensionCurp == "png" || $extensionCurp == "txt" || $extensionCurp == "xml" || $extensionCurp == "jpeg" || $extensionCurp == "JPG"){
	
	$detalleCurp = '<a href="'.RUTA_ARCHIVOS.'/documentos-personal/curp/'.$curp.'" download>
	<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Clave Única de Registro de Población (CURP)"></a>';
	
	}else if($curp == ""){ 
	$detalleCurp = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Sin Información">';   
	
	}else{
	$detalleCurp = $curp;
	$bgTable = 'style="background-color: #fcfcda"';
	}
	   
	//----- Cartas de Recomendación ----- 
	if($a_infonavit != ""){
	$detallea_infonavit = '<a href="'.RUTA_ARCHIVOS.'documentos-personal/acta_infonavit/'.$a_infonavit.'" download>
	<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Aviso de Retención de Infonavit"></a>';
				
	}else{
	$detallea_infonavit = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Sin Información">';   
	}
	
	 
	//----- Constancia de Situacion Fiscal ----- 
	
	if($extensionRfc == "pdf" || $extensionRfc == "jpg" || $extensionRfc == "png" || $extensionRfc == "txt" || $extensionRfc == "xml" || $extensionRfc == "jpeg" || $extensionRfc == "JPG"){
	
	$nombreArchivoRFC = "../../../archivos/documentos-personal/rfc/$rfc";
	if (file_exists($nombreArchivoRFC)) {
	$fechaHoy2 = date("Y-m-d");
	$fechaCreacion2 = filectime($nombreArchivoRFC);
	$nuevaFecha2 = strtotime('+1 year', $fechaCreacion2);
	$fechaFormateada2 = date('Y-m-d', $nuevaFecha2);
		 
	if($fechaFormateada2 <= $fechaHoy2){
	$bg_alerta2 = 'actualizar-tb.png';
	}else{ 
	$bg_alerta2 = 'pdf.png';
	}
					  
	}else{
	$bg_alerta2 = 'pdf.png';
	}
	
	
	$detalleRfc = '<a href="'.RUTA_ARCHIVOS.'/documentos-personal/rfc/'.$rfc.'" download>
	<img class="pointer" src="'.RUTA_IMG_ICONOS.''.$bg_alerta2.'" data-toggle="tooltip" data-placement="top" title="Constancia de Situación Fiscal (CSF)"></a>';
	
	}else if($rfc == ""){ 
	$detalleRfc = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Sin Información">';   
			
	
	}else{
	$detalleRfc = $rfc;
	$bgTable = 'style="background-color: #fcfcda"';
	}
	 
	
	//----- Carta de Antecedentes No Penales ----- 
	if($c_antecedentes != ""){
	$detallec_antecedentes = '<a href="'.RUTA_ARCHIVOS.'documentos-personal/carta_antecedentes/'.$c_antecedentes.'" download>
	<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Carta de Antecedentes No Penales"></a>';
					
	}else{
	$detallec_antecedentes = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Sin Información">';   
	}
	  
	
	//----- Contrato ----- 
	if($contrato != ""){
	$detalleContrato = '<a href="'.RUTA_ARCHIVOS.'documentos-personal/contrato/'.$contrato.'" download>
	<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Contrato"></a>';
		
	}else{
	$detalleContrato = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Sin Información">';   
	}
		   
	  
	if($Documento != ""){
	$detalleDoc = '<a href="'.RUTA_ARCHIVOS.''.$Documento.'" download>
	<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Documentos Personales"></a>';
	
	
	}else{
	$detalleDoc = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Sin Información">';   
	}

 
	//---------- CONFIGURACION DE USUARIOS ACTIVOS Y NO ACTIVOS ----------
	if($info == 1){
	$btnEditarUser = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" data-toggle="tooltip"  data-placement="top" title="Editar" onclick="EditarPersonal('.$idEstacion.','.$id.')">';
	$btnEliminarUser = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'usuario-eliminar-tb.png" onclick="EliminarPersonalV2('.$id.')" data-toggle="tooltip"  data-placement="top" title="Eliminar">';
	$bgTable2 = $bgTable;


	}else{
	$btnEditarUser = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'editar-tb.png" data-toggle="tooltip"  data-placement="top" title="Editar">';
	 
	$datosBajaPersonal = PersonalBaja($id, $con);
	$num_listaBaja = $datosBajaPersonal['num_listaBaja'];
	$id_baja = $datosBajaPersonal['id_baja'];
	$fecha_baja = $datosBajaPersonal['fecha_baja'];
	$estado_proceso = $datosBajaPersonal['estado_proceso'];

	if($estado_proceso == 0){
	$bgTable2 = 'style="background-color: #ffb6af"';
	
	}else if($estado_proceso == 1){
	$bgTable2 = 'style="background-color: #fcfcda"';

	
	}else if($estado_proceso == 2){
	$bgTable2 = 'style="background-color: #b0f2c2"';
	
	}
	 

	if($num_listaBaja == 0){
	$btnEliminarUser = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'usuario-eliminar-tb.png" onclick="EliminarPersonalV2('.$id.')" data-toggle="tooltip"  data-placement="top" title="Eliminar">';

	}else{
	$btnEliminarUser = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'usuario-eliminar-tb.png" onclick="DetalleBajaPersonalV2('.$id_baja.')" data-toggle="tooltip"  data-placement="top" title="Detalle Baja">';
	
	}


	if($fecha_baja == "S/I"){
	$alinearTB = "text-center";	
	}else{
	$alinearTB = "";		
	}

	$tablaInfo2 = '<td class="align-middle '.$alinearTB.'">'.$fecha_baja.'</td>';
	}
	
	
	$resultado .= '<tr '.$bgTable2.'>
	<td class="text-center align-middle">'.$row_personal['id'].'</td>
	<td class="align-middle">'.FormatoFecha($row_personal['fecha_ingreso']).'</td>
	'.$tablaInfo2.'
	<td class="align-middle text-center">'.$row_personal['no_colaborador'].'</td>
	<td class="align-middle">'.$row_personal['nombre_completo'].'</td>
	<td class="align-middle text-center">'.$row_personal['puesto'].'</td>
	<td class="align-middle text-center">'.$detalleDoc.'</td>
	<td class="align-middle text-center">'.$detallerequisicion.'</td>
	<td class="align-middle text-center">'.$detallecurriculum.'</td>
	<td class="align-middle text-center">'.$detalleIne.'</td>
	<td class="align-middle text-center">'.$detalleacta.'</td>
	<td class="align-middle text-center">'.$detallec_domicilio.'</td>
	<td class="align-middle text-center">'.$detalleNss.'</td>
	<td class="align-middle text-center">'.$detallec_estudios.'</td>
	<td class="align-middle text-center">'.$detallec_recomendacion.'</td> 
	<td class="align-middle text-center">'.$detalleCurp.'</td>
	<td class="align-middle text-center">'.$detallea_infonavit.'</td>
	<td class="align-middle text-center">'.$detalleRfc.'</td>
	<td class="align-middle text-center">'.$detallec_antecedentes.'</td>
	<td class="align-middle text-center">'.$detalleContrato.'</td>
	<td class="align-middle text-center">'.number_format($row_personal['sd'],2).'</td>';
	 
	// echo '<td class="align-middle text-center"> <img class="pointer" src="'.RUTA_IMG_ICONOS.'archivo-tb.png" data-toggle="tooltip" data-placement="top" title="Documentos" onclick="Documentos('.$id.')"> </td>';
	
	$resultado .= '<td class="align-middle"><img class="pointer" src="'.RUTA_IMG_ICONOS.'reloj-tb.png" data-toggle="tooltip"  data-placement="top" title="Asistencia" onclick="Asistencia('.$id.')"></td>
	
	<td class="align-middle"><img class="pointer" src="'.RUTA_IMG_ICONOS.'huella-dactilar-tb.png" data-toggle="tooltip"  data-placement="top" title="Acceso" onclick="Acceso('.$id.')"></td>';
	
	//echo '<td class="align-middle"><img class="pointer" src="'.RUTA_IMG_ICONOS.'nomina-tb.png" data-toggle="tooltip"  data-placement="top" title="Recibo de Nomina" onclick="NominaIndividual('.$id.')"></td>';
	
	$resultado .= '
	<td class="align-middle">'.$btnEditarUser.'</td>
	<td class="align-middle">'.$Nuevo.'<img class="pointer" src="'.RUTA_IMG_ICONOS.'comentario-tb.png" data-toggle="tooltip"  data-placement="top" title="Comentarios" onclick="ComentariosPersonal('.$idEstacion.','.$id.')"></td>
	<td class="align-middle '.$ocultartb.'">'.$btnEliminarUser.'</td>
	</tr>';
	
	}
	}else{
	$resultado .= "<tr><td colspan='26' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
	}

	$resultado .= '</tbody> </table> </div>';

	$resultado .= '</div>';


	return $resultado;

}



?>
<script type="text/javascript">
$(document).ready(function($){
$('[data-toggle="tooltip"]').tooltip();
});
</script>

  
<?=$divInicio?>

<?=$menuRH?>

<!---------- TABLA DE ABREVIATURAS ---------->
<div class="alert alert-success" role="alert">

<div class="table-responsive">
<table class="table table-sm table-bordered border-secondary pb-0 mb-0" style="font-size: .7em;">
<tr><th class="text-center" colspan="20" style="font-size: 1.1em;">Abreviaturas de documentación</th></tr>

<tr>
<td><b>RP:</b> Requisición del Personal</td>
<td><b>CV:</b> Curriculum Vitae</td>
<td><b>IO:</b> Identificación Oficial</td>
<td><b>AN:</b> Acta de Nacimiento</td>
<td><b>CD:</b> Comprobante de Domicilio</td>
<td><b>CAI:</b> Comprobante de Afiliación del IMSS</td>
</tr>

<tr>
<td><b>CE:</b> Comprobante de Estudios</td>
<td><b>CR:</b> Cartas de Recomendación</td>
<td><b>CURP:</b> Clave Única de Registro de Población</td>
<td><b>ARI:</b> Aviso de Retención de Infonavit</td>
<td><b>CSF:</b> Constancia de Situación Fiscal</td>
<td><b>CANP:</b> Carta de Antecedentes No Penales</td>
</tr>

</tbody>
</table>
</div>

</div>

<!----- TABLA DEL PERSONAL ACTIVO ----->
<?php echo tablaPersonal($idEstacion,1,$ocultartb,$con)?>

<!----- TABLA DEL PERSONAL ACTIVO (PALO SOLO) ----->
<?php
if(($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo") && $Session_IDEstacion == 2){
echo "<div class='mt-4'>";
echo tablaPersonal(9,1,$ocultartb,$con);
echo "</div>";
}
?>

<!----- TABLA DEL PERSONAL NO ACTIVO ----->
<?php 
if($session_nompuesto != "Asistente Administrativo" && $session_nompuesto != "Encargado"){
echo tablaPersonal($idEstacion,0,$ocultartb,$con);
}
?>

<?=$divFin?>



