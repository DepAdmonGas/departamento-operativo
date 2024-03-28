<?php 
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];

$sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}


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


function ToComentarios($idBaja,$con){

$sql_lista = "SELECT id FROM op_rh_personal_baja_comentarios WHERE id_baja = '".$idBaja."' ";
$result_lista = mysqli_query($con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);
   
}


?>



<div class="border-0 p-3">
 
<div class="row">

<div class="col-12">
  <h5><?=$estacion;?></h5>
</div>

<!--
<div class="col-2">
 <a class="float-end pointer" onclick="Modal(<?=$idEstacion;?>)"><img src="<?=RUTA_IMG_ICONOS;?>agregar.png"></a>
</div>
-->

</div>

<hr>

<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0" style="font-size: .9em;">
<thead class="tables-bg">
  <tr class="text-center align-middle">
  <th class=" tableStyle font-weight-bold">#</th>
  <th class="align-middle tableStyle font-weight-bold">Nombre</th>
  <th class="align-middle tableStyle font-weight-bold">Puesto</th>
  <th class="align-middle tableStyle font-weight-bold">Fecha ingreso</th>
  <th class="align-middle tableStyle font-weight-bold">Fecha baja</th>
  <th class="align-middle tableStyle font-weight-bold">Motivo</th>
  <th class="align-middle tableStyle font-weight-bold">Detalle</th>
  
  <th class="align-middle">Documentos <br>Personales</th>
  <th class="align-middle">Identificacion <br>Oficial</th>
  <th class="align-middle">CURP</th>
  <th class="align-middle">RFC</th>
  <th class="align-middle">NSS</th>
  <th class="align-middle">Contrato</th>

  
  <th class="align-middle tableStyle font-weight-bold">Proceso</th>
  <th class="align-middle tableStyle font-weight-bold">Status</th>


  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>archivo-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-comentario-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>


</thead> 
<tbody>

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

  $ToComentarios = ToComentarios($GET_idBaja,$con);

  if($ToComentarios > 0){
  $Nuevo = '<div class="float-end" style="margin-bottom: -5px"><span class="badge bg-danger text-white rounded-circle"><small>'.$ToComentarios.'</small></span></div>';
  }else{
  $Nuevo = ''; 
  }

 
  if($status == 0){
 
    $badgeAlert = '<span class="badge bg-danger">Pendiente</span>';
    $editartb = '<a class="pointer" onclick="EditarProceso('.$GET_idBaja.','.$GET_idEstacion.')"><img src="'.RUTA_IMG_ICONOS.'editar-tb.png"></a>';
    $tableColor = 'table-danger';

  }else if($status == 1){

    $badgeAlert = '<span class="badge bg-warning text-white">En Proceso</span>';
    $editartb = '<a class="pointer" onclick="EditarProceso('.$GET_idBaja.','.$GET_idEstacion.')"><img src="'.RUTA_IMG_ICONOS.'editar-tb.png"></a>';
    $tableColor = 'table-warning';

  }else if($status == 2){

    $badgeAlert = '<span class="badge bg-success">Finalizado</span>';
    $editartb = '<a class="grayscale"><img src="'.RUTA_IMG_ICONOS.'editar-tb.png"></a>';
    $tableColor = 'table-success';

  }


  if($contrato != ""){
    $ContratoDoc = '<a href="'.RUTA_ARCHIVOS.'documentos-personal/contrato/'.$contrato.'" download>
     <img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Contrato"></a>';
  }else{
    $ContratoDoc = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Sin Información">';

  }
   

echo '<tr class="align-middle '.$tableColor.'" >';
echo '<td class="text-center">'.$num .'</td>';
echo '<td>'.$row_lista['nombre_completo'].'</td>';
echo '<td class="text-center">'.$row_lista['puesto'].'</td>';
echo '<td class="text-center">'.FormatoFecha($row_lista['fecha_ingreso']).'</td>';
echo '<td class="text-center">'.FormatoFecha($row_lista['fecha_baja']).'</td>';
echo '<td class="text-center">'.$row_lista['motivo'].'</td>';
echo '<td class="text-center">'.$row_lista['detalle'].'</td>';

echo '<td class="text-center"><a href="'.RUTA_ARCHIVOS.''.$Documento.'" download>
     <img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Documentos Personales"></a></td>';
echo '<td class="text-center"><a href="'.RUTA_ARCHIVOS.'documentos-personal/ine/'.$ine.'" download>
     <img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Identificacion Oficial"></a></td>';
echo '<td class="text-center"><a href="'.RUTA_ARCHIVOS.'documentos-personal/curp/'.$curp.'" download>
<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="CURP"></a></td>';
echo '<td class="text-center"><a href="'.RUTA_ARCHIVOS.'documentos-personal/rfc/'.$rfc.'" download>
     <img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="RFC"></a></td>';
echo '<td class="text-center"><a href="'.RUTA_ARCHIVOS.'documentos-personal/nss/'.$nss.'" download>
     <img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Numero de Seguro Social"></a></td>';
echo '<td class="text-center">'.$ContratoDoc.'</td>';

echo '<td class="text-center">'.$proceso.'</td>';
echo '<td class="text-center">'.$badgeAlert.'</td>';


echo '<td class="text-center"><a class="pointer" onclick="ArchivosBaja('.$GET_idBaja.','.$GET_idEstacion.')"><img src="'.RUTA_IMG_ICONOS.'archivo-tb.png"></a></td>';
echo '<td class="align-middle text-center">'.$Nuevo.'<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-comentario-tb.png" onclick="ComentarioBaja('.$GET_idBaja.','.$GET_idEstacion.')" data-toggle="tooltip" data-placement="top" title="Comentarios"></td>';
echo '<td class="text-center">'.$editartb.'</td>';

echo '</tr>';

$num++;
}
}else{
echo "<tr><td colspan='20'><div class='text-secondary text-center p-1 fs- fw-light'>No se encontró información para mostrar </div></td></tr>";	
}
?>
</tbody>
</table>
</div>

</div>