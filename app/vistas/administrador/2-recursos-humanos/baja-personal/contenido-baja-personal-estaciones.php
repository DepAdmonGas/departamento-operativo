<?php 
require('../../../../../app/help.php');
$idEstacion = $_GET['idEstacion'];

$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($idEstacion);
$nombreLocalidad = $datosEstacion['localidad'];

$sql_lista = "SELECT 
op_rh_personal.id_estacion,
op_rh_personal.nombre_completo,
op_rh_personal.puesto,
op_rh_personal.fecha_ingreso,
op_rh_personal.ine,
op_rh_personal.curp,
op_rh_personal.rfc,
op_rh_personal.nss,
op_rh_personal.contrato,
op_rh_personal.documentos,
op_rh_personal.estado,
op_rh_personal_baja.id AS idBaja,
op_rh_personal_baja.fecha_baja,
op_rh_personal_baja.motivo,
op_rh_personal_baja.detalle,
op_rh_personal_baja.proceso,
op_rh_personal_baja.estado_proceso,

op_rh_puestos.puesto

FROM op_rh_personal_baja
INNER JOIN op_rh_personal ON op_rh_personal_baja.id_personal = op_rh_personal.id
INNER JOIN op_rh_puestos ON op_rh_personal.puesto = op_rh_puestos.id

WHERE op_rh_personal.estado = 0 AND op_rh_personal.id_estacion = '".$idEstacion."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>

<div class="row">
<div class="col-12">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Recursos humanos
</a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase">Baja Personal (<?=$nombreLocalidad?>)</li>
</ol>
</div>
 
<div class="row"> 
<div class="col-12"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Baja Personal (<?=$nombreLocalidad?>)</h3> </div>
</div>

<hr>
</div>
</div> 
 
<div class="table-responsive">
<table class="custom-table" style="font-size: .8em;" width="100%">

<thead class="tables-bg">
<tr class="text-center align-middle">
<th class=" tableStyle font-weight-bold">#</th>
<th class="align-middle tableStyle font-weight-bold">Nombre</th>
<th class="align-middle tableStyle font-weight-bold">Puesto</th>
<th class="align-middle tableStyle font-weight-bold">Fecha ingreso</th>
<th class="align-middle tableStyle font-weight-bold">Fecha baja</th>
<th class="align-middle tableStyle font-weight-bold">Motivo</th>
<th class="align-middle tableStyle font-weight-bold">Detalle</th>
<th class="align-middle tableStyle font-weight-bold">Proceso</th>
<th class="align-middle tableStyle font-weight-bold">Status</th>
<th class="align-middle">Documentos <br>Personales</th>
<th class="align-middle">IO</th>
<th class="align-middle">CURP</th>
<th class="align-middle">RFC</th>
<th class="align-middle">NSS</th>
<th class="align-middle">Contrato</th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>archivo-tb.png"></th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-comentario-tb.png"></th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
</thead> 

<tbody class="bg-white">

<?php
$num = 1;
 
if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$GET_idBaja = $row_lista['idBaja'];
$GET_idEstacion = $row_lista['id_estacion'];

$ine = $row_lista['ine'];
$curp = $row_lista['curp'];
$rfc = $row_lista['rfc'];
$nss = $row_lista['nss'];
$Documento = $row_lista['documentos'];
$contrato = $row_lista['contrato'];

$status = $row_lista['estado_proceso'];

if($row_lista['proceso'] == ""){
$proceso = "Pendiente";
}else{
$proceso = $row_lista['proceso']; 
}

$ToComentarios = $ClassRecursosHumanosGeneral->ToComentarios($GET_idBaja);

if($ToComentarios > 0){
$Nuevo = '<div class="position-absolute" style="margin-bottom: -15px; right: 2px;"><span class="badge bg-danger text-white rounded-circle"><span class="fw-bold" style="font-size: 10px;">'.$ToComentarios.' </span></span></div>';
}else{
$Nuevo = ''; 
}

if($status == 0){
$badgeAlert = '<span class="badge bg-danger">Pendiente</span>';
$editartb = '<a class="pointer" onclick="EditarProceso('.$GET_idBaja.','.$GET_idEstacion.')"><img src="'.RUTA_IMG_ICONOS.'editar-tb.png"></a>';
$tableColor = 'style="background-color: #ffb6af"'; 

}else if($status == 1){
$badgeAlert = '<span class="badge bg-warning text-white">En Proceso</span>';
$editartb = '<a class="pointer" onclick="EditarProceso('.$GET_idBaja.','.$GET_idEstacion.')"><img src="'.RUTA_IMG_ICONOS.'editar-tb.png"></a>';
$tableColor = 'style="background-color: #fcfcda"';

}else if($status == 2){
$badgeAlert = '<span class="badge bg-success">Finalizado</span>';
$editartb = '<a class="grayscale"><img src="'.RUTA_IMG_ICONOS.'editar-tb.png"></a>';
$tableColor = 'style="background-color: #b0f2c2"';

}

//---------- DOCUMENTACION DEL PERSONAL -----------
$detalleDoc = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS, $Documento, 'Documentos Personales');
$detalleIne = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS . 'documentos-personal/ine/', $ine, 'Identificación Oficial');
$detalleNss = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS . 'documentos-personal/nss/', $nss, 'Comprobante de Afiliación del IMSS');
$detalleCurp = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS . 'documentos-personal/curp/', $curp, 'Clave Única de Registro de Población (CURP)');
$detalleRfc = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS . 'documentos-personal/rfc/', $rfc, 'Constancia de Situación Fiscal (CSF)');
$detalleContrato = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS . 'documentos-personal/contrato/', $contrato, 'Contrato');
 
echo '<tr '.$tableColor.' >';
echo '<th class="text-center">'.$num .'</th>';
echo '<td>'.$row_lista['nombre_completo'].'</td>';
echo '<td class="text-center">'.$row_lista['puesto'].'</td>';
echo '<td class="text-center">'.FormatoFecha($row_lista['fecha_ingreso']).'</td>';
echo '<td class="text-center">'.FormatoFecha($row_lista['fecha_baja']).'</td>';
echo '<td class="text-center">'.$row_lista['motivo'].'</td>';
echo '<td class="text-center">'.$row_lista['detalle'].'</td>';
echo '<td class="text-center">'.$proceso.'</td>';
echo '<td class="text-center">'.$badgeAlert.'</td>';
echo '<td class="text-center">'.$detalleDoc.'</td>';
echo '<td class="text-center">'.$detalleIne.'</td>';
echo '<td class="text-center">'.$detalleCurp.'</td>';
echo '<td class="text-center">'.$detalleRfc.'</td>';
echo '<td class="text-center">'.$detalleNss.'</td>';
echo '<td class="text-center">'.$detalleContrato.'</td>';
echo '<td class="text-center"><a class="pointer" onclick="ArchivosBaja('.$GET_idBaja.','.$GET_idEstacion.')"><img src="'.RUTA_IMG_ICONOS.'archivo-tb.png"></a></td>';
echo '<td class="align-middle text-center position-relative" onclick="ComentarioBaja('.$GET_idBaja.','.$GET_idEstacion.')">'.$Nuevo.'<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-comentario-tb.png" data-toggle="tooltip" data-placement="top" title="Comentarios"></td>';
echo '<td class="text-center">'.$editartb.'</td>';
echo '</tr>';

$num++;
}
}else{
echo "<tr><th class='no-hover' colspan='20'><div class='text-secondary text-center fw-light'>No se encontró información para mostrar </div></th></tr>";	
}
?>
</tbody>
</table>
</div>

