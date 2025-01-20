<?php
require('../../../app/help.php');
$idEstacion = $_GET['idEstacion'];
$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosEstacion($idEstacion);

if($idEstacion == 8){
$estacion = "Otros";
}else{
$sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}
}   

$sql_lista = "SELECT * FROM op_pedido_materiales WHERE id_estacion = '".$idEstacion."' ORDER BY folio DESC ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

function ToComentarios($IdReporte,$con){

$sql_lista = "SELECT id FROM op_pedido_materiales_comentarios WHERE id_pedido = '".$IdReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);
}

function FirmaSC($idReporte,$tipoFirma,$con){
$sql_lista = "SELECT * FROM op_pedido_materiales_firma WHERE id_pedido = '".$idReporte."' AND tipo_firma = '".$tipoFirma."' ";
$result_lista = mysqli_query($con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);
}

function ToEvidencia($IdReporte,$con){

$sql_lista = "SELECT id FROM op_pedido_materiales_instalacion WHERE id_pedido = '".$IdReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);
}

function ToCausa($IdReporte,$con){
$sql_lista = "SELECT id FROM op_pedido_materiales_causa WHERE id_reporte = '".$IdReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);

}


if($idEstacion == 9){
$DescripcionES = "¿En que afecta al autolavado?";
    
}else{
$DescripcionES = "¿En que afecta a la estación?";
    
}

//---------- Configuracion personal ----------//
if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"){
$ocultarOp = "d-none";
$Estacion = '';
$tituloTablaPersonal = "";
$ocultarTitle = "";
$divisionTable = "";
$etqiuetaTB = 'th';

if($idEstacion == 9){
$ocultarTitle = "d-none";
$divisionTable = "<hr>";
$tituloTablaPersonal = '<tr class="tables-bg">
<th class="text-center align-middle fw-bold" colspan="8">Autolavado</th>
</tr>';
$etqiuetaTB = 'td';
}
  
}else{ 
$ocultarOp = "";
$tituloTablaPersonal = ''; 
$ocultarTitle = "";
$divisionTable = "";     
$etqiuetaTB = 'th';  

if($idEstacion == 9){
$Estacion = '(Autolavado)';

}else{
$Estacion = '('.$datosEstacion['nombre'].')';

}

} 


?> 

<div class="col-12 <?=$ocultarTitle?>">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> Almacén</a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase">Orden de Mantenimiento <?=$Estacion?></li>
</ol>
</div>

<div class="row">
<div class="col-xl-9 col-lg-9 col-md-6 col-sm-12"><h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Orden de Mantenimiento <?=$Estacion?></h3></div>
<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">

<?php 
if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"){
if($idEstacion == 2){

echo '<div class="text-end">
<div class="dropdown d-inline ms-2 <?=$ocultarbtn?>">
<button type="button" class="btn dropdown-toggle btn-primary" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
<i class="fa-solid fa-screwdriver-wrench"></i></span>
</button>

<ul class="dropdown-menu">
<li onclick="Nuevo('.$idEstacion.')"><a class="dropdown-item pointer"> <i class="fa-solid fa-gas-pump"></i> Agregar Orden Palo Solo</a></li>
<li onclick="Nuevo(9)"><a class="dropdown-item pointer"> <i class="fa-solid fa-car"></i> Agregar Orden Autolavado</a></li>

</ul>
</div>
</div>';



}else{
echo '<button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="Nuevo('.$idEstacion.')">
<span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>';
}

}else{

echo '<button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="Nuevo('.$idEstacion.')">
<span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>';

}


?>
</div>

</div>
<hr>
</div>


<?=$divisionTable?>



<div class="table-responsive">
<table id="tabla_orden_<?=$idEstacion?>" class="custom-table" style="font-size: 12.5px;" width="100%">

<thead class="tables-bg">

<?=$tituloTablaPersonal?>

 <tr>
  <<?=$etqiuetaTB?> class="align-middle tableStyle fw-bold text-center">Folio</<?=$etqiuetaTB?>>
  <th class="align-middle tableStyle font-weight-bold text-center">Fecha</th>
  <th class="align-middle tableStyle font-weight-bold text-center" width="350">Asunto</th>
  <!-- <th class="align-middle text-center tableStyle font-weight-bold">Tipo de servicio</td> -->
  <th class="align-middle tableStyle font-weight-bold text-center"><?=$DescripcionES?></th>
  <th class="align-middle tableStyle font-weight-bold text-center">Estatus</td>  
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-firmar-w.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-comentario-tb.png"></th>
  <<?=$etqiuetaTB?> class="align-middle text-center" width="40"><i class="fas fa-ellipsis-v"></i></<?=$etqiuetaTB?>>

  </tr>
</thead> 
<tbody>

<?php
if ($numero_lista > 0) {
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$id = $row_lista['id'];
$afectacion = $row_lista['afectacion'];

 
if($row_lista['tipo_servicio'] == 1){
$TipoServicio = 'PREVENTIVO';	
}else if($row_lista['tipo_servicio'] == 2){
$TipoServicio = 'CORRECTIVO';	
}else if($row_lista['tipo_servicio'] == 3){
$TipoServicio = 'EMERGENTE';	
}

$firmaB = FirmaSC($id,'B',$con);
$firmaC = FirmaSC($id,'C',$con);

if($row_lista['estatus'] == 0){
$Excel2 = '<a class="dropdown-item grayscale"><i class="fa-regular fa-file-excel"></i> Descargar Excel</a>';
$bgTable = 'style="background-color: #fcfcda"';
$PDF = '<a class="dropdown-item grayscale"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
$Editar = '<a class="dropdown-item" onclick="Editar('.$id.')"><i class="fa-solid fa-pencil"></i> Editar</a>';
$Eliminar = '<a class="dropdown-item" onclick="Eliminar('.$idEstacion.','.$id.')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
$Firmar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" >';
$evidencia = '<a class="dropdown-item grayscale"><i class="fa-regular fa-file-image"></i> Evidencia</a>';
$causa = '<a class="dropdown-item grayscale"><i class="fa-regular fa-circle-question"></i> Causa</a>';
$Estatus = 'Orden de Mantenimiento Pendiente';
 
}else if($row_lista['estatus'] == 1){
$bgTable = 'style="background-color: #fcfcda"';
$PDF = '<a class="dropdown-item grayscale"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
$Excel2 = '<a class="dropdown-item grayscale"><i class="fa-regular fa-file-excel"></i> Descargar Excel</a>';
$Editar = '<a class="dropdown-item" onclick="Editar('.$id.')"><i class="fa-solid fa-pencil"></i> Editar</a>';
$Eliminar = '<a class="dropdown-item grayscale"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';

if($firmaB == 1){
$Firmar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-firmar-vb.png" onclick="Firmar('.$id.')" >';  
}else{
$Firmar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" onclick="Firmar('.$id.')" >';  
}

$evidencia = '<a class="dropdown-item grayscale"><i class="fa-regular fa-file-image"></i> Evidencia</a>';
$causa = '<a class="dropdown-item grayscale"><i class="fa-regular fa-circle-question"></i> Causa</a>';


$Estatus = 'Pendiente por firmar';

}else if($row_lista['estatus'] == 2 || $row_lista['estatus'] == 3){
$PDF = '<a class="dropdown-item" onclick="DescargarPDF('.$id.')"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
$Excel2 = '<a class="dropdown-item" onclick="DescargarExcel('.$id.')"><i class="fa-regular fa-file-excel"></i> Descargar Excel</a>';

$Editar = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';
$Firmar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-firmar-ao.png">';
$Eliminar = '<a class="dropdown-item grayscale"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';

$EvidenciaNum = ToEvidencia($id,$con); 
$CausaNum = ToCausa($id,$con); 

if($EvidenciaNum != 0){
$bgTable = 'style="background-color: #b0f2c2"';
$Estatus = 'Refacción Instalada';
$evidencia = '<a class="dropdown-item" onclick="ModalEvidencia('.$idEstacion.','.$id.')"><i class="fa-regular fa-file-image"></i> Evidencia</a>';
$causa = '<a class="dropdown-item grayscale"><i class="fa-regular fa-circle-question"></i> Causa</a>';
  
  
}else if($CausaNum != 0){
$bgTable = 'style="background-color: #b0f2c2"';
$Estatus = 'Orden cerrada'; 
$evidencia = '<a class="dropdown-item grayscale"><i class="fa-regular fa-file-image"></i> Evidencia</a>';
$causa = '<a class="dropdown-item" onclick="ModalCausa('.$idEstacion.','.$id.')"><i class="fa-regular fa-circle-question"></i> Causa</a>';

  
}else{ 
$bgTable = 'style="background-color: #ffb6af"';
$Estatus = 'Tienes 5 días hábiles para instalar la refacción';
$evidencia = '<a class="dropdown-item" onclick="ModalEvidencia('.$idEstacion.','.$id.')"><i class="fa-regular fa-file-image"></i> Evidencia</a>';
$causa = '<a class="dropdown-item" onclick="ModalCausa('.$idEstacion.','.$id.')"><i class="fa-regular fa-circle-question"></i> Causa</a>';
  
}

}   

  $ToComentarios = ToComentarios($id,$con);

  if($ToComentarios > 0){ 
    $Nuevo = '<div class="position-absolute" style="margin-bottom: -15px; right: 2px;"><span class="badge bg-danger text-white rounded-circle"><span class="fw-bold" style="font-size: 10px;">'.$ToComentarios.' </span></span></div>';
 
  }else{
   $Nuevo = ''; 
  }
 

  $sql_detalle = "SELECT * FROM op_pedido_materiales_detalle WHERE id_pedido = '".$id."' LIMIT 1 ";
  $result_detalle = mysqli_query($con, $sql_detalle);
  $numero_detalle = mysqli_num_rows($result_detalle);


echo '<tr '.$bgTable.'>'; 
echo '<th class="align-middle text-center"><b>00'.$row_lista['folio'].'</b></th>';
echo '<td class="align-middle">'.FormatoFecha($row_lista['fecha']).'</td>';
 
if ($numero_detalle > 0) {
while($row_detalle = mysqli_fetch_array($result_detalle, MYSQLI_ASSOC)){
$concepto = $row_detalle['concepto'];
echo '<td class="align-middle text-center"> '.$concepto.' </td>';
}
  
}else{
echo '<td class="align-middle text-center"></td>';
}

// echo '<td class="align-middle text-center">'.$TipoServicio.'</td>';
echo '<td class="align-middle text-center">'.$afectacion.'</td>';
echo '<td class="align-middle text-center">'.$Estatus.'</td>';
echo '<td class="align-middle text-center">'.$Firmar.'</td>';
echo '<td class="align-middle text-center position-relative" onclick="ModalComentario('.$idEstacion.','.$id.')">'.$Nuevo.'<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-comentario-tb.png"  data-toggle="tooltip" data-placement="top" title="Comentarios"></td>';

echo '<td class="align-middle text-center">
<div class="dropdown">

<a class="btn btn-sm btn-icon-only text-dropdown-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
<i class="fas fa-ellipsis-v"></i>
</a>

<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
<a class="dropdown-item" onclick="ModalDetalle('.$id.')"><i class="fa-regular fa-eye"></i> Detalle</a>
'.$evidencia.'
'.$causa.'
'.$PDF.'
'.$Excel2.'
'.$Editar.'
'.$Eliminar.'
</div>
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

