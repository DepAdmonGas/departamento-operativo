<?php 
require('../../../../../app/help.php');
$idBaja = $_GET['idBaja'];

$sql_comen = "SELECT * FROM op_rh_personal_baja_comentarios WHERE id_baja = '".$idBaja."'";
$result_comen = mysqli_query($con, $sql_comen);
$numero_comen = mysqli_num_rows($result_comen);

$datosUsuario = $ClassRecursosHumanosGeneral->PersonalBajaDetalle($idBaja);
$id_estacion = $datosUsuario['id_estacion'];
$nombre_completo = $datosUsuario['nombre_completo'];
$no_colaborador = $datosUsuario['no_colaborador'];
$puesto = $datosUsuario['puesto'];
$fecha_ingreso = $datosUsuario['fecha_ingreso'];
$fecha_baja = $datosUsuario['fecha_baja'];
$motivo = $datosUsuario['motivo'];
$detalle = $datosUsuario['detalle'];
$proceso1 = $datosUsuario['proceso'];
$estado_proceso = $datosUsuario['estado_proceso'];

$documentos = $datosUsuario['documentos'];
$ine = $datosUsuario['ine'];
$nss = $datosUsuario['nss'];
$rfc = $datosUsuario['rfc'];
$curp = $datosUsuario['curp'];
$contrato = $datosUsuario['contrato'];

$detalleDoc = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS, $documentos, 'Documentos Personales');
$detalleIne = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS . 'documentos-personal/ine/', $ine, 'Identificación Oficial');
$detalleNss = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS . 'documentos-personal/nss/', $nss, 'Comprobante de Afiliación del IMSS');
$detalleRfc = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS . 'documentos-personal/rfc/', $rfc, 'Constancia de Situación Fiscal (CSF)');
$detalleCurp = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS . 'documentos-personal/curp/', $curp, 'Clave Única de Registro de Población (CURP)');
$detalleContrato = $ClassRecursosHumanosGeneral->generarDetalleIcono(RUTA_ARCHIVOS . 'documentos-personal/contrato/', $contrato, 'Contrato');

$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($id_estacion);
$nombreLocalidad = $datosEstacion['localidad'];
 
if($proceso1 == ""){
$proceso = "Pendiente";
}else{
$proceso = $proceso1; 
}
 
if($estado_proceso == 0){
$badgeAlert = '<span class="badge bg-danger">Pendiente</span>';
$editartb = '<button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="EditarProceso('.$idBaja.','.$id_estacion.')"><span class="btn-label2"><i class="fa-solid fa-pen"></i></span> Editar proceso de baja
</button>'; 


}else if($estado_proceso == 1){
$badgeAlert = '<span class="badge bg-warning text-white">En Proceso</span>';
$editartb = '<button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="EditarProceso('.$idBaja.','.$id_estacion.')"><span class="btn-label2"><i class="fa-solid fa-pen"></i></span> Editar proceso de baja
</button>'; 

}else if($estado_proceso == 2){
$badgeAlert = '<span class="badge bg-success">Finalizado</span>';
$editartb = '';

}


$ToComentarios = $ClassRecursosHumanosGeneral->ToComentarios($idBaja);

if($ToComentarios > 0){
$Nuevo = '<div class="float-end" style="margin-bottom: -5px"><span class="badge bg-danger text-white rounded-circle"><span class="fw-bold" style="font-size: 11px;">'.$ToComentarios.' </span></span></div>';
}else{
$Nuevo = ''; 
}

?>

<div class="row">

<div class="col-12">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Control de Documentos del Personal</a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase">Detalle baja de personal - <?=$nombreLocalidad?></li>
</ol>
</div>
 
<div class="row"> 
<div class="col-xl-9 col-lg-9 col-md-6 col-sm-12"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Detalle baja de personal - <?=$nombreLocalidad ?></h3> </div>
<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12"> <?=$editartb?> </div>
</div>

<hr>
</div>
</div>


<div class="row">

<div class="col-12">
<div class="row">

<div class="col-xl-2 col-lg-2 col-md-6 col-sm-12">
<div class="text-secondary mt-2"><small>No. de colaborador:</small></div>
<div class="mt-1"><h6><?=$no_colaborador?></h6></div>
</div>

<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
<div class="text-secondary mt-2"><small>Nombre completo:</small></div>
<div class="mt-1"><h6><?=$nombre_completo?></h6></div>
</div>

<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
<div class="text-secondary mt-2"><small>Fecha ingreso:</small></div>
<div class="mt-1"><h6><?=$fecha_ingreso?></h6></div>
</div>

<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
<div class="text-secondary mt-2"><small>Fecha baja:</small></div>
<div class="mt-1"><h6><?=$fecha_baja?></h6></div>
</div>

<div class="col-xl-2 col-lg-2 col-md-6 col-sm-12">
<div class="text-secondary mt-2"><small>Puesto:</small></div>
<div class="mt-1"><h6><?=$puesto;?></h6></div>
</div>

<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
<div class="text-secondary mt-2"><small>Motivo:</small></div>
<div class="mt-1"><h6><?=$motivo?></h6></div>
</div>

<div class="col-xl-2 col-lg-2 col-md-6 col-sm-12">
<div class="text-secondary mt-2"><small>Detalle:</small></div>
<div class="mt-1"><h6><?=$detalle?></h6></div>
</div>

<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
<div class="text-secondary mt-2"><small>Proceso de Baja:</small></div>
<div class="mt-1"><h6><?=$proceso?></h6></div>
</div>

<div class="col-xl-2 col-lg-2 col-md-6 col-sm-12">
<div class="text-secondary mt-2"><small>Status:</small></div>
<div class="mt-1"><h6><?=$badgeAlert?></h6></div>
</div>



</div>

</div>

<div class="col-12">
    <hr>
<div class="table-responsive">
<table class="custom-table" style="font-size: .9em;" width="100%">
<thead class="tables-bg">
<tr class="text-center align-middle tables-bg">
<th class="align-middle" colspan="8">Documentación del Personal</th>
</tr>

<tr class="text-center align-middle">
<td class="align-middle fw-bold">Documentos <br>Personales</td>
<th class="align-middle">Identificacion <br>Oficial</th>
<th class="align-middle">CURP</th>
<th class="align-middle">RFC</th>
<th class="align-middle">NSS</th>
<th class="align-middle">Contrato</th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>archivo-tb.png"></th>
<td class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>comentario-tb.png"></td>
</thead> 

<tbody class="bg-light">
<tr class="text-center align-middle">
<th class="align-middle"><?=$detalleDoc?></th>
<td class="align-middle"><?=$detalleIne?></td>
<td class="align-middle"><?=$detalleCurp?></td>
<td class="align-middle"><?=$detalleRfc?></td>
<td class="align-middle"><?=$detalleNss?></td>
<td class="align-middle"><?=$detalleContrato?></td>
<td class="align-middle"><a class="pointer" onclick="ArchivosBaja(<?=$idBaja?>,<?=$id_estacion?>)"><img src="<?=RUTA_IMG_ICONOS?>archivo-tb.png"></a></td>
<td class="align-middle text-center"> <?=$Nuevo?> <img class="pointer" src="<?=RUTA_IMG_ICONOS?>icon-comentario-tb.png" onclick="ComentarioBaja(<?=$idBaja?>,<?=$id_estacion?>)" data-toggle="tooltip" data-placement="top" title="Comentarios"></td>
 
</tr>
</tbody> 

</table>
</div>
</div>

</div>