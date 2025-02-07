<?php 
require('../../../../../app/help.php');
$idEstacion = $_GET['idEstacion'];

$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($idEstacion);
$nombreLocalidad = $datosEstacion['localidad'];

$sql_lista = "SELECT 
op_rh_personal.id_estacion,
op_rh_personal.nombre_completo,
op_rh_personal.puesto,
op_rh_personal.estado,
op_rh_personal_baja.id AS idBaja,
op_rh_personal_baja.fecha_baja,
op_rh_personal_baja.motivo,
op_rh_personal_baja.detalle,
op_rh_personal_baja.solucion,
op_rh_personal_baja.proceso,
op_rh_personal_baja.estado_proceso,
op_rh_puestos.puesto
FROM op_rh_personal_baja
INNER JOIN op_rh_personal ON op_rh_personal_baja.id_personal = op_rh_personal.id
INNER JOIN op_rh_puestos ON op_rh_personal.puesto = op_rh_puestos.id
WHERE op_rh_personal.estado = 0 AND op_rh_personal.id_estacion = '".$idEstacion."' ORDER BY op_rh_personal_baja.fecha_baja DESC";

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
<table id="tabla_baja_personal_<?=$idEstacion?>" class="custom-table" style="font-size: .8em;" width="100%">

<thead class="tables-bg">
<tr class="text-center align-middle">
<th class="text-center align-middle">#</th>
<th class="text-start align-middle">Nombre</th>
<th class="text-center align-middle">Puesto</th>
<th class="text-center align-middle">Fecha baja</th>
<th class="text-center align-middle">Motivo</th>
<th class="text-center align-middle">Descripción</th>
<!--<th class="text-center align-middle">Solución</th>-->
<th class="text-center align-middle">Proceso</th>
<th class="text-center align-middle">Status</th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-comentario-tb.png"></th>
<th class="align-middle text-center" width="20"><i class="fas fa-ellipsis-v"></i></th>
</thead> 

<tbody class="bg-white">
<?php
$num = 1;
 
if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$GET_idBaja = $row_lista['idBaja'];
$GET_idEstacion = $row_lista['id_estacion'];
$status = $row_lista['estado_proceso'];

if($row_lista['proceso'] == ""){
$proceso = "S/I";
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
$editartb = '<a class="dropdown-item"  onclick="EditarProceso('.$GET_idBaja.','.$GET_idEstacion.')"><i class="fa-solid fa-pencil"></i> Editar</a>';
$tableColor = 'style="background-color: #ffb6af"'; 

}else if($status == 1){
$badgeAlert = '<span class="badge bg-warning text-white">En Proceso</span>';
$editartb = '<a class="dropdown-item"  onclick="EditarProceso('.$GET_idBaja.','.$GET_idEstacion.')"><i class="fa-solid fa-pencil"></i> Editar</a>';
$tableColor = 'style="background-color: #fcfcda"';

}else if($status == 2){
$badgeAlert = '<span class="badge bg-success">Finalizado</span>';
$editartb = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';
$tableColor = 'style="background-color: #b0f2c2"';

}

echo '<tr '.$tableColor.' >';
echo '<th class="text-center align-middle">'.$num .'</th>';
echo '<td class="text-start align-middle">'.$row_lista['nombre_completo'].'</td>';
echo '<td class="text-center align-middle">'.$row_lista['puesto'].'</td>';
echo '<td class="text-center align-middle">'.$ClassHerramientasDptoOperativo->FormatoFecha($row_lista['fecha_baja']).'</td>';
echo '<td class="text-center align-middle">'.$row_lista['motivo'].'</td>';
echo '<td class="text-center align-middle">'.$row_lista['detalle'].'</td>';
//echo '<td class="text-center align-middle">'.$solucion.'</td>';
echo '<td class="text-center align-middle">'.$proceso.'</td>';
echo '<td class="text-center align-middle">'.$badgeAlert.'</td>';
echo '<td class="align-middle text-center align-middle position-relative" onclick="ComentarioBaja('.$GET_idBaja.','.$GET_idEstacion.')">'.$Nuevo.'<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-comentario-tb.png" data-toggle="tooltip" data-placement="top" title="Comentarios"></td>';
echo '
<td class="text-center align-middle">
<div class="dropdown-container">
<a class="btn btn-sm btn-icon-only text-dropdown-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
<i class="fas fa-ellipsis-v"></i>
</a>

<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton1">
'.$editartb.'
<a class="dropdown-item" onclick="ArchivosBaja('.$GET_idBaja.','.$GET_idEstacion.')"><i class="fa-regular fa-file-lines"></i> Documentos</a>
</ul>
</div>
</td>';

echo '</tr>';

$num++;
}
}
?>
</tbody>
</table>
</div>

