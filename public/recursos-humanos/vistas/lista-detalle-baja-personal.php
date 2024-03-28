<?php 
require('../../../app/help.php');

$idBaja = $_GET['idBaja'];

function ToComentarios($idBaja,$con){

  $sql_lista = "SELECT id FROM op_rh_personal_baja_comentarios WHERE id_baja = '".$idBaja."' ";
  $result_lista = mysqli_query($con, $sql_lista);
  return $numero_lista = mysqli_num_rows($result_lista);
     
  }

$sql = "SELECT
op_rh_personal.fecha_ingreso, 
op_rh_personal.no_colaborador, 
op_rh_personal.nombre_completo,
op_rh_personal.id_estacion,  
op_rh_personal_baja.fecha_baja,
op_rh_personal_baja.motivo,
op_rh_personal_baja.detalle,
op_rh_personal_baja.proceso,
op_rh_personal_baja.estado_proceso,
op_rh_puestos.puesto,
op_rh_localidades.id, 
op_rh_localidades.localidad 
FROM op_rh_personal_baja 
INNER JOIN op_rh_personal ON op_rh_personal_baja.id_personal = op_rh_personal.id
INNER JOIN op_rh_puestos ON op_rh_personal.puesto = op_rh_puestos.id
INNER JOIN op_rh_localidades ON op_rh_personal.id_estacion = op_rh_localidades.id

WHERE op_rh_personal_baja.id = '".$idBaja."' ";

$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$fecha_ingreso = $row['fecha_ingreso'];
$no_colaborador = $row['no_colaborador'];
$nombrePersonal = $row['nombre_completo'];
$fecha_baja = $row['fecha_baja'];
$motivo = $row['motivo'];
$detalle = $row['detalle'];
$proceso2 = $row['proceso'];
$estado_proceso = $row['estado_proceso'];
$puesto = $row['puesto'];

$idEstacion = $row['id_estacion'];
$localidad = $row['localidad'];

}
 
if($proceso2 == ""){
$proceso = "Pendiente";
}else{

$proceso = $proceso2; 
}

if($estado_proceso == 0){
$badgeAlert = '<span class="badge bg-danger">Pendiente</span>';
$editartb = '<a class="pointer float-end mt-3" onclick="EditarProceso('.$idBaja.','.$idEstacion.')"><img src="'.RUTA_IMG_ICONOS.'editar-tb.png"></a>';


}else if($estado_proceso == 1){
$badgeAlert = '<span class="badge bg-warning text-white">En Proceso</span>';
$editartb = '<a class="pointer float-end mt-3" onclick="EditarProceso('.$idBaja.','.$idEstacion.')"><img src="'.RUTA_IMG_ICONOS.'editar-tb.png"></a>';


}else if($estado_proceso == 2){
$badgeAlert = '<span class="badge bg-success">Finalizado</span>';
$editartb = '<a class="grayscale float-end mt-3"><img src="'.RUTA_IMG_ICONOS.'editar-tb.png"></a>';

}


$ToComentarios = ToComentarios($idBaja,$con);

if($ToComentarios > 0){
$Nuevo = '<div class="float-end" style="margin-bottom: -5px"><span class="badge bg-danger text-white rounded-circle"><small>'.$ToComentarios.'</small></span></div>';

}else{
$Nuevo = ''; 
}


?>

<div class="border-0 p-3">

<div class="row">
<div class="col-12">

<img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">

<div class="row"> 
  <div class="col-11">
    <h5>Detalle de Baja - <?=$nombrePersonal?></h5>
  </div>
  <div class="col-1" style="position: relative;">
    <div style="position: absolute; top: 0; left: 96%; transform: translateX(-90%); z-index: 1;">
      <?=$Nuevo?>
    </div>
    <img class="float-end pointer" src="<?=RUTA_IMG_ICONOS;?>chat.png" onclick="ComentarioBaja(<?=$idBaja?>,<?=$idEstacion?>)">
  </div>
</div>
 

</div>
</div>

<hr>
 
<div class="row">


<div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 mt-2 mb-1">
<div class="border p-3">

<div class="row">

    <div class="col-10">
    <div class="row">
  
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2 ">
      <div class="text-secondary"><small>Proceso de Baja:</small></div>
      <div class="mt-1"><h6><?=$proceso?></h6></div>
    </div>
  
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2 ">
      <div class="text-secondary"><small>Status de Baja:</small></div>
      <div class="mt-1"><?=$badgeAlert?></div>
    </div>
  
    </div>
    </div>
  
  
    <div class="col-2">
    <?=$editartb?>
    </div>

</div>

<hr>

<div class="row mt-4">

<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 mb-2 ">
      <div class="text-secondary"><small>Fecha ingreso:</small></div>
      <div class="mt-1"><h6><?=FormatoFecha($fecha_ingreso);?></h6></div>
    </div>
  
    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 mb-2 ">
      <div class="text-secondary"><small>No. de colaborador:</small></div>
      <div class="mt-1"><h6><?=$no_colaborador;?></h6></div>
    </div>
      
    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 mb-2 ">
      <div class="text-secondary"><small>Nombre completo:</small></div>
      <div class="mt-1"><h6><?=$nombrePersonal;?></h6></div>
    </div>
      
    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 mb-2 ">
      <div class="text-secondary"><small>Puesto:</small></div>
      <div class="mt-1"><h6><?=$puesto;?></h6></div>
    </div>
  
    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 mb-2 ">
      <div class="text-secondary"><small>Estación:</small></div>
      <div class="mt-1"><h6><?=$localidad?></h6></div>
    </div>
    </div>


    <div class="row">

    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-2 ">
    <div class="text-secondary mt-2">Fecha baja:</div>
    <div class="mt-1"><h6><?=FormatoFecha($fecha_baja);?></h6></div>
  </div>

  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-2 ">
    <div class="text-secondary mt-2">Motivo:</div>
    <div class="mt-1"><h6><?=$motivo;?></h6></div>
  </div>

  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-2 ">
    <div class="text-secondary mt-2">Detalle:</div>
    <div class="mt-1"><h6><?=$detalle;?></h6></div>
  </div>
  </div>


</div>
</div>


<div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 mt-2 mb-1">
<div class="border p-3">

<div class="row">
  <div class="col-11"><h5>Documentos</h5></div>
  <div class="col-1"><img class="float-end pointer" src="<?=RUTA_IMG_ICONOS;?>agregar.png" onclick="ArchivosBaja(<?=$idBaja?>,<?=$idEstacion?>)"></div>
  </div>
 
  <hr> 

  <?php
  $sql_archivos_baja = "SELECT * FROM op_rh_personal_baja_archivos WHERE id_baja = '".$idBaja."'";
  $result_archivos_baja = mysqli_query($con, $sql_archivos_baja);
  $numero_archivos_baja = mysqli_num_rows($result_archivos_baja);
  ?>

    <div class="table-responsive">
    <table class="table table-sm table-bordered pb-0 mb-0 " style="font-size: .8em;">
    <thead class="tables-bg">
    <tr>
    <th class="align-middle text-center">Descripción:</th>
    <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
    <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
    </tr>
    </thead>
    <tbody>
    <?php

if ($numero_archivos_baja > 0) {
while($row_archivos_baja = mysqli_fetch_array($result_archivos_baja, MYSQLI_ASSOC)){

$GET_idArchivo = $row_archivos_baja['id'];
$descripcionDoc = $row_archivos_baja['descripcion'];
$archivo = $row_archivos_baja['archivo'];


echo '<tr class="text-center">';
echo '<td class="align-middle">'.$descripcionDoc.'</td>';
echo '<td class="align-middle"><a href="'.RUTA_ARCHIVOS.'/documentos-personal/solicitud-baja/'.$archivo.'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png"></a></td>';
echo '<th class="align-middle text-center pointer" width="20" onclick="eliminarArchivoBaja('.$GET_idArchivo.','.$idBaja.','.$idEstacion.')"><img src="'.RUTA_IMG_ICONOS.'eliminar.png"></th>';
echo '</tr>';

}
}
?>
</tbody>
</table>
</div>


</div>
</div>

</div>



  </div>
  </div>


  </div>