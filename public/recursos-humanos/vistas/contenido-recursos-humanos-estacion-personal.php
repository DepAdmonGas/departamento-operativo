<?php 
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
 
$sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}
 

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
WHERE op_rh_personal.id_estacion = '".$idEstacion."' AND op_rh_personal.estado = 1 ORDER BY op_rh_personal.id ASC";

$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);


?>  

<script type="text/javascript">
 $(document).ready(function($){
  $('[data-toggle="tooltip"]').tooltip(); 

  })	
</script>
 

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



<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0" style="font-size: .9em;">
<thead class="tables-bg">
	<tr class="text-center align-middle">
	<th >#</th>
	<th class="align-middle">Fecha ingreso</th>
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
	<th class="align-middle">SD</th>
	<!-- <th class="text-center align-middle" width="24"><img src="<?=RUTA_IMG_ICONOS;?>archivo-tb.png"></th> -->
	<th class="text-center align-middle" width="24"><img src="<?=RUTA_IMG_ICONOS;?>reloj-tb.png"></th>
	<th class="text-center align-middle" width="24"><img src="<?=RUTA_IMG_ICONOS;?>huella-dactilar-tb.png"></th>
	<!-- <th class="text-center align-middle" width="24"><img src="<?=RUTA_IMG_ICONOS;?>nomina-tb.png"></th> -->
	<th class="text-center align-middle <?=$ocultarOpcion?>" width="24"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
	</tr>
</thead> 
<tbody>
<?php 
if ($numero_personal > 0) {
while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){
$id = $row_personal['id'];
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
$detalleIne = '<a href="'.RUTA_ARCHIVOS.'documentos-personal/ine/'.$ine.'" download>
<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Identificacion Oficial"></a>';
	
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
$detalleRfc = '<a href="'.RUTA_ARCHIVOS.'/documentos-personal/rfc/'.$rfc.'" download>
     <img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Constancia de Situación Fiscal (CSF)"></a>';

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


echo '<tr '.$bgTable.'>
<td class="text-center align-middle">'.$row_personal['id'].'</td>
<td class="align-middle">'.FormatoFecha($row_personal['fecha_ingreso']).'</td>
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

echo '<td class="align-middle"><img class="pointer" src="'.RUTA_IMG_ICONOS.'reloj-tb.png" data-toggle="tooltip"  data-placement="top" title="Asistencia" onclick="Asistencia('.$id.')"></td>

<td class="align-middle"><img class="pointer" src="'.RUTA_IMG_ICONOS.'huella-dactilar-tb.png" data-toggle="tooltip"  data-placement="top" title="Acceso" onclick="Acceso('.$id.')"></td>';

//echo '<td class="align-middle"><img class="pointer" src="'.RUTA_IMG_ICONOS.'nomina-tb.png" data-toggle="tooltip"  data-placement="top" title="Recibo de Nomina" onclick="NominaIndividual('.$id.')"></td>';

echo '<td class="align-middle '.$ocultarOpcion.'"><img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" data-toggle="tooltip"  data-placement="top" title="Editar" onclick="EditarPersonal('.$idEstacion.','.$id.')"></td>

</tr>';

}
}else{
echo "<tr><td colspan='15' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>

<?php 
if($idEstacion == 2){

$sql = "SELECT
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
WHERE op_rh_personal.id_estacion = 9 AND op_rh_personal.estado = 1 ORDER BY op_rh_personal.id ASC";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
?>

<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0 mt-4" style="font-size: .9em;">
<thead class="bg-light">
<th class="text-center align-middle" colspan="30">Autolavado</th>
</thead>

<thead class="tables-bg">
	<tr class="text-center align-middle">
	<th >#</th>
	<th class="align-middle">Fecha ingreso</th>
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
	<th class="align-middle">SD</th>
	<!-- <th class="text-center align-middle" width="24"><img src="<?=RUTA_IMG_ICONOS;?>archivo-tb.png"></th> -->
	<th class="text-center align-middle" width="24"><img src="<?=RUTA_IMG_ICONOS;?>reloj-tb.png"></th>
	<th class="text-center align-middle" width="24"><img src="<?=RUTA_IMG_ICONOS;?>huella-dactilar-tb.png"></th>
	<!-- <th class="text-center align-middle" width="24"><img src="<?=RUTA_IMG_ICONOS;?>nomina-tb.png"></th> -->
	<th class="text-center align-middle <?=$ocultarOpcion?>" width="24"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
	</tr>
</thead> 
<tbody>
<?php 
if ($numero > 0) {
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
	$id = $row['id'];
	$puesto = $row['puesto'];
	
	$Documento = $row['documentos'];
	$requisicion = $row['requisicion'];
	$curriculum = $row['curriculum'];
	$ine = $row['ine'];
	$acta_nacimiento = $row['acta_nacimiento'];
	$c_domicilio = $row['c_domicilio'];
	$nss = $row['nss'];
	$c_estudios = $row['c_estudios'];
	$nss = $row['nss'];
	$c_recomendacion = $row['c_recomendacion'];
	$curp = $row['curp'];
	$a_infonavit = $row['a_infonavit'];
	$rfc = $row['rfc'];
	$c_antecedentes = $row['c_antecedentes'];
	
	$contrato = $row['contrato'];

	$extensionCurp = pathinfo($curp, PATHINFO_EXTENSION);
	$extensionRfc = pathinfo($rfc, PATHINFO_EXTENSION);
	$extensionNss = pathinfo($nss, PATHINFO_EXTENSION);

  
	if($curriculum != "" && $ine != "" && $acta_nacimiento != "" && $c_domicilio != "" &&  $nss != "" && $c_estudios != "" && $nss != "" && $c_recomendacion != ""
	&& $curp != "" && $rfc != "" && $contrato != ""){
	$bgTable = 'style="background-color: #b0f2c2"';
		
	}else if($curriculum == "" && $ine == "" && $acta_nacimiento == "" && $c_domicilio == "" &&  $nss == "" && $c_estudios == "" && $nss == "" && $c_recomendacion == ""
	&& $curp == "" && $rfc == "" && $contrato == ""){
	$bgTable = 'style="background-color: #ffb6af"';
		
	}else{
	$bgTable = 'style="background-color: #fcfcda"';
		
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
	$detalleIne = '<a href="'.RUTA_ARCHIVOS.'documentos-personal/ine/'.$ine.'" download>
	<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Identificacion Oficial"></a>';
		
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
	$detalleRfc = '<a href="'.RUTA_ARCHIVOS.'/documentos-personal/rfc/'.$rfc.'" download>
		 <img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Constancia de Situación Fiscal (CSF)"></a>';
	
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
	 
	
	echo '<tr '.$bgTable.'>
	<td class="text-center align-middle">'.$row['id'].'</td>
	<td class="align-middle">'.FormatoFecha($row['fecha_ingreso']).'</td>
	<td class="align-middle text-center">'.$row['no_colaborador'].'</td>
	<td class="align-middle">'.$row['nombre_completo'].'</td>
	<td class="align-middle text-center">'.$row['puesto'].'</td>
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
	<td class="align-middle text-center">'.number_format($row['sd'],2).'</td>';
	 
	// echo '<td class="align-middle text-center"> <img class="pointer" src="'.RUTA_IMG_ICONOS.'archivo-tb.png" data-toggle="tooltip" data-placement="top" title="Documentos" onclick="Documentos('.$id.')"> </td>';
	
	echo '<td class="align-middle"><img class="pointer" src="'.RUTA_IMG_ICONOS.'reloj-tb.png" data-toggle="tooltip"  data-placement="top" title="Asistencia" onclick="Asistencia('.$id.')"></td>
	
	<td class="align-middle"><img class="pointer" src="'.RUTA_IMG_ICONOS.'huella-dactilar-tb.png" data-toggle="tooltip"  data-placement="top" title="Acceso" onclick="Acceso('.$id.')"></td>';
	
	//echo '<td class="align-middle"><img class="pointer" src="'.RUTA_IMG_ICONOS.'nomina-tb.png" data-toggle="tooltip"  data-placement="top" title="Recibo de Nomina" onclick="NominaIndividual('.$id.')"></td>';
	
	echo '<td class="align-middle '.$ocultarOpcion.'"><img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" data-toggle="tooltip"  data-placement="top" title="Editar" onclick="EditarPersonal(9,'.$id.')"></td>
	
	</tr>';

}
}else{
echo "<tr><td colspan='15' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>
<?php
}
?>
