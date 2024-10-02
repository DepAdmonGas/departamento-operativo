<?php 
require('../../../../../app/help.php');
$idEstacion = $_GET['idEstacion'];
$idActivos = $_GET['idActivos'];
$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($idEstacion);

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
WHERE op_rh_personal.id_estacion = '".$idEstacion."' AND op_rh_personal.estado = ".$idActivos." ORDER BY op_rh_personal.id ASC";
$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);

function ToComentarios($idPersonal,$con){
$sql_lista = "SELECT id FROM op_rh_personal_comentarios WHERE id_personal = '".$idPersonal."' ";
$result_lista = mysqli_query($con, $sql_lista);   
return $numero_lista = mysqli_num_rows($result_lista);      
}


//---------- VISUALIZACIONES PUESTOS ----------
if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"){
$Estacion = "";
$ocultarbtn = "d-none";
   
}else{
$Estacion = '('.$datosEstacion['localidad'].')';
$ocultarbtn = "";
        
}

//---------- VISUALIZACIONES PERSONAL ACTIVO / NO ACTIVO ----------
if($idActivos == 1){
$fechaBajaTb = "";
$divisionTable = "";

if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"){

if($idEstacion == 9){
$tituloTablaPersonal = '<th class="text-center align-middle fw-bold" colspan="22">Personal Activo - Autolavado</th>';
$ocultarTitle = "d-none";
$divisionTable = "<hr>";
   
}else{
$tituloTablaPersonal = '<th class="text-center align-middle fw-bold" colspan="22">Personal Activo</th>';
$ocultarTitle = "";
$divisionTable = "";

}
    
}else{

$tituloTablaPersonal = '<th class="text-center align-middle fw-bold" colspan="22">Personal Activo</th>';
$ocultarTitle = "";
$divisionTable = "";
    
}


}else{
$tituloTablaPersonal = '<th class="text-center align-middle fw-bold" colspan="23">Personal No Activo</th>';
$fechaBajaTb = '<th class="align-middle">Fecha de baja</th>';
$ocultarTitle = "d-none";
$divisionTable = "<hr>";

}


?>

<div class="col-12 <?=$ocultarTitle?>">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-home"></i> Recursos Humanos</a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase">Control de Documentos del Personal <?=$Estacion?></li>
</ol>
</div>
   
<div class="row"> 
<div class="col-9"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Control de Documentos del Personal <?=$Estacion?></h3> </div>
  
<div class="col-3">
    
<div class="text-end">
<div class="dropdown d-inline ms-2 <?=$ocultarbtn?>">
<button type="button" class="btn dropdown-toggle btn-primary" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
<i class="fa-solid fa-screwdriver-wrench"></i></span>
</button>

<ul class="dropdown-menu">
<li onclick="Mas(<?=$idEstacion?>)"><a class="dropdown-item pointer"> <i class="fa-solid fa-plus"></i> Agregar Personal</a></li>
<li><a class="dropdown-item pointer" href="public/recursos-humanos/vistas/personal-excel.php?idEstacion=<?=$idEstacion?>"> <i class="fa-solid fa-file-excel"></i> Descargar Excel Personal</a></li>
<?php if ($Session_IDUsuarioBD == 19 || $Session_IDUsuarioBD == 318) { ?>
<li onclick="EvaluacionPersonal(<?=$idEstacion?>)"><a class="dropdown-item pointer"> <i class="fa-solid fa-chart-column"></i> Evaluacion Personal (KPI'S)</a></li>
<?php } ?>

</ul>
</div>
</div>

</div>
</div>

<hr>
</div>

<!---------- TABLA DE ABREVIATURAS ---------->
<div class="alert alert-success <?=$ocultarTitle?>" role="alert">

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

<?=$divisionTable?>

<!---------- TABLA DEL PERSONAL ABREVIATURAS ---------->
<div class="table-responsive">
<table id="tabla_personal_<?=$idActivos?>_<?=$idEstacion?>" class="custom-table" style="font-size: .75em;" width="100%">

<thead class="title-table-bg">

<tr class="tables-bg">
<?=$tituloTablaPersonal?>
</tr>

<tr>
<td>#</td>
<th class="text-start align-middle fw-bold">Fecha ingreso</th>
<?=$fechaBajaTb?>
<th class="text-center align-middle" width="22">No. de colaborador</th>
<th class="text-start align-middle">Nombre completo</th>
<th class="text-center align-middle">Puesto</th>
<th class="text-center align-middle">SD</th>
<th class="text-center align-middle">Documentos <br>Personales</th>
<th class="text-center align-middle">RP</th>
<th class="text-center align-middle">CV</th>
<th class="text-center align-middle">IO</th>
<th class="text-center align-middle">AN</th>
<th class="text-center align-middle">CD</th>
<th class="text-center align-middle">CAI</th>
<th class="text-center align-middle">CE</th>
<th class="text-center align-middle">CR</th> 
<th class="text-center align-middle">CURP</th>
<th class="text-center align-middle">ARI</th>
<th class="text-center align-middle">CSF</th>
<th class="text-center align-middle">CANP</th>
<th class="text-center align-middle">Contrato</th>
<th class="text-center align-middle" width="24"><img src="<?=RUTA_IMG_ICONOS?>comentario-tb.png"></th>
<td class="text-center align-middle" width="24"><i class="fas fa-ellipsis-v"></i></td>
</tr>

</thead>

<tbody>
<?php
if ($numero_personal > 0){
$bgTable = 'style="background-color: #ffffff"';

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

//---------- LLENADO DE DATOS DE LA TABLA -----------
if($puesto == "Despachador"){

if($curriculum != "" && $ine != "" && $acta_nacimiento != "" && $c_domicilio != "" &&  $nss != "" && $c_estudios != "" && $nss != "" && $c_recomendacion != "" && $curp != "" && $rfc != "" && $c_antecedentes != "" && $contrato != ""){
$bgTable = 'style="background-color: #b0f2c2"';
                
}else if($curriculum == "" && $ine == "" && $acta_nacimiento == "" && $c_domicilio == "" &&  $nss == "" && $c_estudios == "" && $nss == "" && $c_recomendacion == "" && $curp == "" && $rfc == "" && $c_antecedentes == "" && $contrato == ""){
$bgTable = 'style="background-color: #ffb6af"';
                
}else{
$bgTable = 'style="background-color: #fcfcda"';              
}
        
}else{
        
if($curriculum != "" && $ine != "" && $acta_nacimiento != "" && $c_domicilio != "" &&  $nss != "" && $c_estudios != "" && $nss != "" && $c_recomendacion != "" && $curp != "" && $rfc != "" && $contrato != ""){
$bgTable = 'style="background-color: #b0f2c2"';
            
}else if($curriculum == "" && $ine == "" && $acta_nacimiento == "" && $c_domicilio == "" &&  $nss == "" && $c_estudios == "" && $nss == "" && $c_recomendacion == "" && $curp == "" && $rfc == "" && $contrato == ""){
$bgTable = 'style="background-color: #ffb6af"';
            
}else{
$bgTable = 'style="background-color: #fcfcda"';         
} 
            
}

//---------- DOCUMENTACION DEL PERSONAL -----------
$detalleDoc = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS, $Documento, 'Documentos Personales');
$detallerequisicion = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS . 'documentos-personal/requisicion/', $requisicion, 'Requisición del Personal');
$detallecurriculum = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS . 'documentos-personal/curriculum/', $curriculum, 'Curriculum Vitae');
$detalleIne = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS . 'documentos-personal/ine/', $ine, 'Identificación Oficial');
$detalleacta = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS . 'documentos-personal/acta_nacimiento/', $acta_nacimiento, 'Acta de Nacimiento');
$detallec_domicilio = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS . 'documentos-personal/comprobante_domicilio/', $c_domicilio, 'Comprobante de Domicilio');
$detalleNss = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS . 'documentos-personal/nss/', $nss, 'Comprobante de Afiliación del IMSS');
$detallec_estudios = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS . 'documentos-personal/comprobante_estudios/', $c_estudios, 'Comprobante de Estudios');
$detallec_recomendacion = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS . 'documentos-personal/cartas_recomendacion/', $c_recomendacion, 'Cartas de Recomendación');
$detalleCurp = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS . 'documentos-personal/curp/', $curp, 'Clave Única de Registro de Población (CURP)');
$detallea_infonavit = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS . 'documentos-personal/acta_infonavit/', $a_infonavit, 'Aviso de Retención de Infonavit');
$detalleRfc = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS . 'documentos-personal/rfc/', $rfc, 'Constancia de Situación Fiscal (CSF)');
$detallec_antecedentes = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS . 'documentos-personal/carta_antecedentes/', $c_antecedentes, 'Carta de Antecedentes No Penales');
$detalleContrato = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS . 'documentos-personal/contrato/', $contrato, 'Contrato');


//---------- COMENTARIOS DEL PERSONAL -----------
$ToComentarios = ToComentarios($id,$con);

if($ToComentarios > 0){
$Nuevo = '<div class="position-absolute" style="margin-bottom: -15px; right: 2px;"><span class="badge bg-danger text-white rounded-circle"><span class="fw-bold" style="font-size: 10px;">'.$ToComentarios.' </span></span></div>';
}else{
$Nuevo = ''; 
} 

//---------- BOTONES DE ENCARGADO Y ADMINISTRADOR -----------
if($idActivos == 1){
$tablaInfo2 = '';
$btnEditarUser = '<a class="dropdown-item" onclick="EditarPersonal('.$idEstacion.','.$id.')"><i class="fa-solid fa-pencil"></i> Editar información</a>';
$btnEliminarUser = '<a class="dropdown-item '.$ocultarbtn.'" onclick="EliminarPersonalV2('.$id.')"><i class="fa-regular fa-trash-can"></i> Eliminar personal</a>';

}else{
$btnEditarUser = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar información</a>';

$datosBajaPersonal = $ClassRecursosHumanosGeneral->PersonalBaja($id);
$num_listaBaja = $datosBajaPersonal['num_listaBaja'];
$id_baja = $datosBajaPersonal['id_baja'];
$fecha_baja = $datosBajaPersonal['fecha_baja'];
$estado_proceso = $datosBajaPersonal['estado_proceso'];

$tablaInfo2 = '<td class="align-middle text-center">'.$fecha_baja.'</td>';

//----- COLOR PROCESO DE BAJA -----
if($estado_proceso == 0){
$bgTable = 'style="background-color: #ffb6af"';
	
}else if($estado_proceso == 1){
$bgTable = 'style="background-color: #fcfcda"';

	
}else if($estado_proceso == 2){
$bgTable = 'style="background-color: #b0f2c2"';
	
}

//----- BOTON PARA EL PROCESO DE BAJA -----
if($num_listaBaja == 0){
$btnEliminarUser = '<a class="dropdown-item" onclick="EliminarPersonalV2('.$id.')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';

}else{
$btnEliminarUser = '<a class="dropdown-item" onclick="DetalleBajaPersonalV2('.$id_baja.')"><i class="fa-regular fa-eye"></i> Detalle de baja</a>';
	
} 

}

echo '<tr '.$bgTable.'>
<th class="text-center align-middle fw-normal">'.$row_personal['id'].'</th>
<td class="align-middle text-start">'.$ClassHerramientasDptoOperativo->FormatoFecha($row_personal['fecha_ingreso']).'</td>
'.$tablaInfo2.'
<td class="align-middle text-center">'.$row_personal['no_colaborador'].'</td>
<td class="align-middle text-start">'.$row_personal['nombre_completo'].'</td>
<td class="align-middle text-center">'.$row_personal['puesto'].'</td>
<td class="align-middle text-center">'.number_format($row_personal['sd'],2).'</td>
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
<td class="align-middle text-center position-relative" onclick="ComentariosPersonal('.$idEstacion.','.$id.')">'.$Nuevo.'<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-comentario-tb.png" data-toggle="tooltip" data-placement="top" title="Comentarios"></td>';

echo '<td class="align-middle">
<div class="dropdown">

<a class="btn btn-sm btn-icon-only text-dropdown-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
<i class="fas fa-ellipsis-v"></i>
</a>

<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
<a class="dropdown-item" onclick="Asistencia('.$id.')"><i class="fa-regular fa-clock"></i> Asistencia</a>
<a class="dropdown-item" onclick="Acceso('.$id.')"><i class="fa-solid fa-key"></i> Acceso</a>
'.$btnEditarUser.'
'.$btnEliminarUser.'
</div>
</div>

</td>


</tr>';

}
}

?>
</tbody>


</table>
</div>







