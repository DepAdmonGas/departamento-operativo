<?php
require('../../../app/help.php');
$idEstacion = $_GET['idEstacion'];

if($idEstacion == 8){
$estacion = "Otros";
}else{
$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
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





?> 
<script type="text/javascript">
$(document).ready(function($){
$('[data-toggle="tooltip"]').tooltip();
});
</script>

<div class="border-0 p-3">
<div class="row">

<div class="col-10">
<?php if($idEstacion != $Session_IDEstacion){ ?>
<div><h5>Orden de Mantenimiento <?=$estacion;?></h5></div>
<?php }else{ ?>
   
  
    <div class="row">
    <div class="col-12">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    
    <div class="row">
    <div class="col-12">

     <h5>Orden de Mantenimiento</h5>
    
    </div>
    </div>

    </div>
    </div> 

<?php } ?>

</div>
  
 
<div class="col-2">
<img class="float-end pointer" src="<?=RUTA_IMG_ICONOS;?>agregar.png" onclick="Nuevo(<?=$idEstacion;?>)">
</div>

</div>

<hr> 

<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0">
<thead class="tables-bg">
 <tr>
  <th class="align-middle tableStyle font-weight-bold text-center">Folio</th>
  <th class="align-middle tableStyle font-weight-bold text-center">Fecha</th>
  <th class="align-middle tableStyle font-weight-bold text-center" width="350">Asunto</th>
  <!-- <th class="align-middle text-center tableStyle font-weight-bold">Tipo de servicio</td> -->
  <th class="align-middle tableStyle font-weight-bold text-center">¿En que afecta a la estación?</th>
  <th class="align-middle tableStyle font-weight-bold text-center">Estatus</td>  
  <th class="align-middle tableStyle font-weight-bold text-center" width="20">Evidencia</td> 
  <th class="align-middle tableStyle font-weight-bold text-center" width="20">Causa</td>   
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>ver-tb.png"></th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-firmar-w.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-comentario-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
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
$bgTable = 'style="background-color: #fcfcda"';

$PDF = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Descargar PDF">';
$Pago = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'pago.png" data-toggle="tooltip" data-placement="top" title="Agregar pago">';
$Editar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="Editar('.$id.')" data-toggle="tooltip" data-placement="top" title="Editar">';
$Eliminar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$idEstacion.','.$id.')" data-toggle="tooltip" data-placement="top" title="Eliminar">';
$Firmar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" data-toggle="tooltip" data-placement="top" title="Firmar Orden">';
$evidencia = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'descargar.png" data-toggle="tooltip" data-placement="top" title="Evidencia" />';
$causa = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'archivo-tb.png" data-toggle="tooltip" data-placement="top" title="Causa" />';


$Estatus = 'Orden de Mantenimiento Pendiente';
 
}else if($row_lista['estatus'] == 1){
$bgTable = 'style="background-color: #fcfcda"';

$PDF = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Descargar PDF">';
$Editar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'editar-tb.png" data-toggle="tooltip" data-placement="top" title="Editar">';
$Eliminar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Eliminar">';

if($firmaB == 1){
$Firmar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-firmar-vb.png" onclick="Firmar('.$id.')" data-toggle="tooltip" data-placement="top" title="Firmar Orden">';  
}else{
$Firmar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" onclick="Firmar('.$id.')" data-toggle="tooltip" data-placement="top" title="Firmar Orden">';  
}

$evidencia = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'descargar.png" data-toggle="tooltip" data-placement="top" title="Evidencia" />';
$causa = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'archivo-tb.png" data-toggle="tooltip" data-placement="top" title="Causa" />';


$Estatus = 'Pendiente por firmar';

}else if($row_lista['estatus'] == 2 || $row_lista['estatus'] == 3){

$PDF = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" onclick="DescargarPDF('.$id.')" data-toggle="tooltip" data-placement="top" title="Descargar PDF">';
$Editar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'editar-tb.png" data-toggle="tooltip" data-placement="top" title="Editar">';
$Firmar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-firmar-ao.png" data-toggle="tooltip" data-placement="top" title="Firmar solicitud">';
$Eliminar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Eliminar">';

  
$EvidenciaNum = ToEvidencia($id,$con); 
$CausaNum = ToCausa($id,$con); 

if($EvidenciaNum != 0){
  $bgTable = 'style="background-color: #b0f2c2"';
  $Estatus = 'Refacción Instalada';
  $evidencia = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'descargar.png" onclick="ModalEvidencia('.$idEstacion.','.$id.')" data-toggle="tooltip" data-placement="top" title="Evidencia" />';
  $causa = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'archivo-tb.png" data-toggle="tooltip" data-placement="top" title="Causa" />';
  
  
  }else if($CausaNum != 0){
  $bgTable = 'style="background-color: #b0f2c2"';
  $Estatus = 'Orden cerrada'; 
  $evidencia = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'descargar.png" data-toggle="tooltip" data-placement="top" title="Evidencia" />';
  $causa = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'archivo-tb.png" onclick="ModalCausa('.$idEstacion.','.$id.')">';

  
  }else{ 
  $bgTable = 'style="background-color: #ffb6af"';
  $Estatus = 'Tienes 5 días hábiles para instalar la refacción';
  $evidencia = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'descargar.png" onclick="ModalEvidencia('.$idEstacion.','.$id.')" data-toggle="tooltip" data-placement="top" title="Evidencia" />';
  $causa = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'archivo-tb.png" onclick="ModalCausa('.$idEstacion.','.$id.')">';
  
  }

}   

  $ToComentarios = ToComentarios($id,$con);

  if($ToComentarios > 0){
    $Nuevo = '<div class="float-end" style="margin-bottom: -5px"><span class="badge bg-danger text-white rounded-circle"><small>'.$ToComentarios.'</small></span></div>';
  }else{
   $Nuevo = ''; 
  }
 

  $sql_detalle = "SELECT * FROM op_pedido_materiales_detalle WHERE id_pedido = '".$id."' LIMIT 1 ";
  $result_detalle = mysqli_query($con, $sql_detalle);
  $numero_detalle = mysqli_num_rows($result_detalle);


echo '<tr '.$bgTable.'>'; 
echo '<td class="align-middle text-center"><b>00'.$row_lista['folio'].'</b></td>';
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
echo '<td class="align-middle text-center">'.$evidencia.'</td>';
echo '<th class="align-middle text-center" width="20">'.$causa.'</th>';
echo '<td class="align-middle text-center">
<img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="ModalDetalle('.$id.')" data-toggle="tooltip" data-placement="top" title="Detalle" /></td>';
echo '<td class="align-middle text-center">'.$PDF.'</td>';
echo '<td class="align-middle text-center">'.$Editar.'</td>';
echo '<td class="align-middle text-center">'.$Firmar.'</td>';
echo '<td class="align-middle text-center">'.$Nuevo.'<img class="pointer" width="20" src="'.RUTA_IMG_ICONOS.'icon-comentario-tb.png" onclick="ModalComentario('.$idEstacion.','.$id.')" data-toggle="tooltip" data-placement="top" title="Comentarios"></td>';
echo '<td class="align-middle text-center">'.$Eliminar.'</td>';
echo '</tr>';
  
$num++;
}

}else{
echo "<tr><td colspan='15' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>   
</div>

</div>