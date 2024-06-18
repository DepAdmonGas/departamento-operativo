<?php
require('../../../app/help.php');

$idPedido = $_GET['idPedido'];

$sql_pedido = "SELECT * FROM op_pedido_materiales WHERE id = '".$idPedido."' ";
$result_pedido = mysqli_query($con, $sql_pedido);
$numero_pedido = mysqli_num_rows($result_pedido);
while($row_pedido = mysqli_fetch_array($result_pedido, MYSQLI_ASSOC)){
$folio = $row_pedido['folio'];
$id_estacion = $row_pedido['id_estacion'];
$fecha = $row_pedido['fecha'];
$afectacion = $row_pedido['afectacion'];
$estatus = $row_pedido['estatus'];
$tiposervicio = $row_pedido['tipo_servicio'];
$ordentrabajo = $row_pedido['orden_trabajo'];
$ordenriesgo = $row_pedido['orden_riesgo'];
$comentarios = $row_pedido['comentarios'];
}
  
$sql_listaestacion = "SELECT razonsocial FROM tb_estaciones WHERE id = '".$id_estacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$razonsocial = $row_listaestacion['razonsocial'];
}

if($id_estacion == 9){
$razonsocialDesc = "Autolavado";
$DescripcionES = "¿EN QUE AFECTA AL AUTOLAVADO?";
$ocultarDivs = "d-none";
  
}else{
$razonsocialDesc = $razonsocial;
$DescripcionES = "¿EN QUE AFECTA A LA ESTACIÓN?";
$ocultarDivs = "";
  
}

function EvidenciaImagen($idEvidencia,$con){

$sql = "SELECT id, imagen FROM op_pedido_materiales_evidencia_foto WHERE id_evidencia = '".$idEvidencia."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$id = $row['id'];
$imagen = $row['imagen'];

$Contenido .= ' 
 <iframe class="border-0 mt-1" src="'.RUTA_ARCHIVOS.$imagen.'" width="250px" height="250px">
  </iframe>';
}

return $Contenido;
}

function Personal($idusuario,$con){
$sql = "SELECT nombre FROM tb_usuarios WHERE id = '".$idusuario."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$nombre = $row['nombre'];
}
return $nombre;
}

function DetalleArea($id,$con){

$sql = "SELECT * FROM op_pedido_materiales_area_otros WHERE id_area = '".$id."' AND estatus = 1 ";
  $result = mysqli_query($con, $sql);
  $numero = mysqli_num_rows($result);
  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
  $Result .= '<small class="text-secondary">('.$row['sub_area'].')</small> '; 
  }

return $Result;
}
?>

<div class="modal-header">
<h5 class="modal-title">Detalle Orden de Mantenimiento</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<div class="table-responsive">
  <table class="table table-bordered">
    <tr>
      <td class="align-middle"><b>Razón social:</b> <br><?=$razonsocialDesc;?></td>
      <td class="align-middle"><b>Folio:</b> <br>00<?=$folio;?></td>
      <td class="align-middle"><b>Fecha:</b> <br><?=FormatoFecha($fecha);?></td>
    </tr>
  </table>
</div>



<!-- APARTADO ¿EN QUE AFECTA A LA ESTACION? -->
<div class="p-3 border mb-3">
<h6><?=$DescripcionES?></h6>
<hr>
<div class="row p-1">

<div class="col-12 mb-2">
<label id="afectacionOM"><?=$afectacion?></label>
  
</div>

</div>
</div> 


  <div class="border p-3 mb-3 d-none">
    <h6>TIPO DE SERVICIO</h6>

  <hr>

  <div class="row">
  	
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2 text-center">PREVENTIVO <?php if($tiposervicio == 1){echo '<br>
    <img class="ms-2" src="'.RUTA_IMG_ICONOS.'icon-check.png" >';} ?> </div>

   <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2 text-center">CORRECTIVO <?php if($tiposervicio == 2){echo '<br>
    <img class="ms-2" src="'.RUTA_IMG_ICONOS.'icon-check.png" >';} ?></div>

   <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2 text-center">EMERGENTE <?php if($tiposervicio == 3){echo '<br>
    <img class="ms-2" src="'.RUTA_IMG_ICONOS.'icon-check.png" >';} ?></div>
  </div>

  </div>



  <div class="border p-3 mb-3">
    <h6>LA ORDEN DE TRABAJO SE PUEDE ATENDER INTERNAMENTE</h6>
    <hr>

    <div class="row">
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2 text-center">SI <?php if($ordentrabajo == 1){echo '<img class="ms-2" src="'.RUTA_IMG_ICONOS.'icon-check.png" >';} ?></div>
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2 text-center">NO <?php if($ordentrabajo == 2){echo '<img class="ms-2" src="'.RUTA_IMG_ICONOS.'icon-check.png" >';} ?></div>
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2 text-center">AMBAS <?php if($ordentrabajo == 3){echo '<img class="ms-2" src="'.RUTA_IMG_ICONOS.'icon-check.png" >';} ?></div>
  </div>

</div>



  <div class="border p-3 mb-3">
    <h6>LA ORDEN DE TRABAJO ES DE ALTO RIESGO</h6>
    <hr>

    <div class="row justify-content-center">
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2 text-center">SI <?php if($ordenriesgo == 1){echo '<img class="ms-2" src="'.RUTA_IMG_ICONOS.'icon-check.png" >';} ?></div>
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2 text-center">NO <?php if($ordenriesgo == 2){echo '<img class="ms-2" src="'.RUTA_IMG_ICONOS.'icon-check.png" >';} ?></div>
  </div>

</div>



<div class="table-responsive <?=$ocultarDivs?>">
  <table class="table table-bordered table-sm mt-3">
  <thead class="tables-bg">
  <tr>
    <th class="text-center">ÁREA</th>
    <th class="text-center p-0 m-0" width="30"></th>
  </tr>
  </thead>
  <tbody>
  <?php  
  $sql_lista = "SELECT * FROM op_pedido_materiales_area WHERE id_pedido = '".$idPedido."' ";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);
  while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

    $id  = $row_lista['id'];

    if($row_lista['estatus'] == 1){
    $checked = '<img class="" src="'.RUTA_IMG_ICONOS.'icon-check.png" >';
    $SADetalle = DetalleArea($id,$con);
    }else{
    $checked = '';
    $SADetalle = '';
    }
 
  echo '<tr>
       <td>'.$row_lista['area'].' '.$SADetalle.'</td>
       <td class="align-middle text-center">'.$checked.'</td>
       </tr>';

  }
  ?>
  </tbody>
</table>
</div>


<div class="table-responsive">
<table class="table table-bordered table-sm">
  <thead class="tables-bg text-center align-middle">
  <tr>
    <th colspan="3">REFACCIONES</th>
  </tr>

  <tr>
    <th class="">REFACCIÓN</th>
    <th class="text-center">CANTIDAD</th>
    <th class="">ESTATUS</th>
  </tr>
  </thead>
  <tbody>
  <?php  
  $sql_detalle = "SELECT * FROM op_pedido_materiales_detalle WHERE id_pedido = '".$idPedido."' ";
  $result_detalle = mysqli_query($con, $sql_detalle);
  $numero_detalle = mysqli_num_rows($result_detalle);
  if ($numero_detalle > 0) {
  while($row_detalle = mysqli_fetch_array($result_detalle, MYSQLI_ASSOC)){

    $id  = $row_detalle['id'];

       echo '<tr>
       <td class="align-middle">'.$row_detalle['concepto'].'</td>       
       <td class="align-middle text-center">'.$row_detalle['cantidad'].'</td>
       <td class="align-middle">'.$row_detalle['nota'].'</td>
       </tr>';
  }
  }else{
  echo "<tr><td colspan='6' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";  
  }
  ?>
  </tbody>
</table>
</div>



<div class="border p-3 mb-3">
  <h6>EVIDENCIA</h6>

<hr> 


<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0 ">
        <thead>
        <tr class="tables-bg">
        <th class="align-middle text-center" width="20" >ARCHIVO</th>
        <th class="align-middle text-center">AREA</th>
        <th class="align-middle text-center">MOTIVO</th>
        </tr>
        </thead>
  
<?php  

  $sql_evidencia = "SELECT * FROM op_pedido_materiales_evidencia_archivo WHERE id_pedido = '".$idPedido."' ";

  
  $result_evidencia = mysqli_query($con, $sql_evidencia);
  $numero_evidencia = mysqli_num_rows($result_evidencia);

    if ($numero_evidencia > 0) {
  while($row_evidencia = mysqli_fetch_array($result_evidencia, MYSQLI_ASSOC)){
  
  $idEvidencia = $row_evidencia['id'];

echo'   <tr>
        <td class="align-middle text-center"> 
        <a class="pointer" href="'.RUTA_ARCHIVOS.'material-evidencia/'.$row_evidencia['archivo'].'" download><img src="'.RUTA_IMG_ICONOS.'descargar.png"></a>
        </td> 
        <td class="align-middle text-center">'.$row_evidencia['area'].'</td>
        <td class="align-middle text-center">'.$row_evidencia['motivo'].'</td>
        </tr>';

  }

  }else{
  echo "<tr><td colspan='6' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";  
  }

  ?>


</table>
</div>
</div>


<div class="border p-3 mb-3">
<div ><h6>COMENTARIOS</h6></div>
<hr>
<div class="border p-2"><?=$comentarios;?></div>
</div>



<div class="border p-3 mb-3">

<h6>FIRMAS</h6>
<hr>
 
<div class="row">
<?php

$sql_firma = "SELECT * FROM op_pedido_materiales_firma WHERE id_pedido = '".$idPedido."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){

$explode = explode(' ', $row_firma['fecha']);

if($row_firma['tipo_firma'] == "A"){
$TipoFirma = "NOMBRE Y FIRMA DEL ENCARGADO";
$Detalle = '<div class="border p-1 text-center"><img src="'.RUTA_IMG_Firma.$row_firma['firma'].'" width="70%"></div>';
}else if($row_firma['tipo_firma'] == "B"){
$TipoFirma = "NOMBRE Y FIRMA DE VOBO";
$Detalle = '<div class="border-bottom text-center p-2" style="font-size: 0.9em;"><small>La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
}else if($row_firma['tipo_firma'] == "C"){
$TipoFirma = "NOMBRE Y FIRMA DE AUTORIZACIÓN";
$Detalle = '<div class="border-bottom text-center p-2" style="font-size: 0.9em;"><small>La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
}


echo '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mt-2 mb-2"> ';
echo '<div class="border p-3"> ';
echo '<div class="mb-2 text-center">'.Personal($row_firma['id_usuario'],$con).'<hr></div>';
echo $Detalle;
echo '<h6 class="mt-2 text-secondary text-center">'.$TipoFirma.'</h6>';
echo '</div>';
echo '</div>';
}

?> 
</div>
</div>

</div>