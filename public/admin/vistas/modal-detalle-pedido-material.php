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
$Contenido = "";
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
  $Result = "";
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
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<div class="row">

  <!---------- INFORMACION FORMULARIO ---------->
  <div class="col-12 mb-3">
  <div class="table-responsive">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> 
    <th class="align-middle text-center">Razón social</th>
    <th class="align-middle text-center">Folio</th>
    <th class="align-middle text-center">Fecha</th>

  </tr>
  </thead>

  <tbody>
  <tr class="no-hover">
  <th class="align-middle text-center bg-light fw-normal"><?=$razonsocialDesc?></th>
  <th class="align-middle text-center bg-light fw-normal"><?=$folio?></th>
  <th class="align-middle text-center bg-light fw-normal"><?=$ClassHerramientasDptoOperativo->FormatoFecha($fecha)?></th>
  </tr>
  </tbody>
  </table>


  </table>
  </div>
  </div>


  <!---------- APARTADO ¿EN QUE AFECTA A LA ESTACION? ---------->
  <div class="col-12 mb-3">
  <div class="table-responsive">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> 
    <th class="align-middle text-center"><?=$DescripcionES?></th>
  </tr>
  </thead>

  <tbody class="bg-light">
  <tr class="no-hover2">
  <th class="align-middle text-center fw-normal no-hover2"><?=$afectacion;?></th>
  </tr>
  </tbody>
  </table>

  </table>
  </div>
  </div>

  <!---------- APARTADO TIPO DE SERVICIO ---------->
  <div class="col-12 mb-3">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> 
  <th class="align-middle text-center" colspan="3">TIPO DE SERVICIO</th>
  </tr>
  </thead>

  <tbody class="bg-light">

  <tr>
  <td class="align-middle text-center no-hover2 p-2"> PREVENTIVO</td>
  <td class="align-middle text-center no-hover2 p-2">CORRECTIVO</td>
  <td class="align-middle text-center no-hover2 p-2">EMERGENTE</td>

  </tr>

  <tr>
  <td class="align-middle text-center no-hover2 p-2">
   <?php if($tiposervicio == 1){echo '<i class="fa-regular fa-circle-check text-success" style="font-size: 20px;"></i>';} ?> 
  </td>

  <td class="align-middle text-center no-hover2 p-2">
   <?php if($tiposervicio == 2){echo '<i class="fa-regular fa-circle-check text-success" style="font-size: 20px;"></i>';} ?> 
  </td>

  <td class="align-middle text-center no-hover2 p-2">
   <?php if($tiposervicio == 3){echo '<i class="fa-regular fa-circle-check text-success" style="font-size: 20px;"></i>';} ?> 
  </td>

  </tr>

  </tbody>
  </table>
  </div>


    <!---------- LA ORDEN DE TRABAJO SE PUEDE ATENDER INTERNAMENTE ---------->
    <div class="col-12 mb-3">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> 
  <th class="align-middle text-center" colspan="3">LA ORDEN DE TRABAJO SE PUEDE ATENDER INTERNAMENTE</th>
  </tr>
  </thead>

  <tbody class="bg-light">

  <tr>
  <td class="align-middle text-center no-hover2 p-2">SI</td>
  <td class="align-middle text-center no-hover2 p-2">NO</td>
  <td class="align-middle text-center no-hover2 p-2">AMBAS</td>

  </tr>

  <tr>
  <td class="align-middle text-center no-hover2 p-2">
  <?php if($ordentrabajo == 1){echo '<i class="fa-regular fa-circle-check text-success" style="font-size: 20px;"></i>';} ?>
  </td>

  <td class="align-middle text-center no-hover2 p-2">
  <?php if($ordentrabajo == 2){echo '<i class="fa-regular fa-circle-check text-success" style="font-size: 20px;"></i>';} ?>
  </td>

  <td class="align-middle text-center no-hover2 p-2">
  <?php if($ordentrabajo == 3){echo '<i class="fa-regular fa-circle-check text-success" style="font-size: 20px;"></i>';} ?>
  </td>

  </tr>

  </tbody>
  </table>
  </div>


  
  <!---------- LA ORDEN DE TRABAJO SE PUEDE ATENDER INTERNAMENTE ---------->
  <div class="col-12 mb-3">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> 
  <th class="align-middle text-center" colspan="2">LA ORDEN DE TRABAJO ES DE ALTO RIESGO</th>
  </tr>
  </thead>

  <tbody class="bg-light">

  <tr>
  <td class="align-middle text-center no-hover2 p-2">SI</td>
  <td class="align-middle text-center no-hover2 p-2">NO</td>

  </tr>

  <tr>
  <td class="align-middle text-center no-hover2 p-2">
  <?php if($ordenriesgo == 1){echo '<i class="fa-regular fa-circle-check text-success" style="font-size: 20px;"></i>';} ?></div>
  </td>

  <td class="align-middle text-center no-hover2 p-2">
  <?php if($ordenriesgo == 2){echo '<i class="fa-regular fa-circle-check text-success" style="font-size: 20px;"></i>';} ?></div>
  </td>


  </tr>

  </tbody>
  </table>
  </div>

  <!---------- AREA ---------->
  <div class="col-12 mb-3 <?=$ocultarDivs?>">
  <div class="table-responsive">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> 
  <th class="align-middle text-center" colspan="2">ÁREA</th>

  </tr>
  </thead>

  <tbody class="bg-light">


  <?php  
  $sql_lista = "SELECT * FROM op_pedido_materiales_area WHERE id_pedido = '".$idPedido."' ";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);

  if ($numero_lista > 0) {
  while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
  $id  = $row_lista['id'];
  if($row_lista['estatus'] == 1){
  $checked = '<i class="fa-regular fa-circle-check text-success" style="font-size: 22px;"></i>';
  $SADetalle = DetalleArea($id,$con);
  }else{
  $checked = '';
  $SADetalle = '';
  }

  echo '<tr>
  <th class="align-middle text-start no-hover2 fw-normal">'.$row_lista['area'].' '.$SADetalle.'</th>
  <td class="align-middle text-center no-hover2" width="40px">'.$checked.'</td>
  </tr>';

  }

  }else{
  echo "<tr><th colspan='6' class='text-center text-secondary no-hover2 fw-normal'>No se encontró información para mostrar</th></tr>";  
  }
  ?>


  </tbody>
  </table>
  </div>
  </div>

  <!---------- REFACCIONES ---------->
  <div class="col-12 mb-3">
  <div class="table-responsive">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> 
  <th class="align-middle text-center" colspan="3">REFACCIONES</th>
  </tr>

  <tr class="title-table-bg">
  <td class="fw-bold align-middle">REFACCIÓN</td>
  <th class="text-center align-middle">CANTIDAD</th>
  <td class="fw-bold text-center align-middle">ESTATUS</td>
  </tr>

  </thead>

  <tbody class="bg-light">
  <?php  
  $sql_detalle = "SELECT * FROM op_pedido_materiales_detalle WHERE id_pedido = '".$idPedido."' ";
  $result_detalle = mysqli_query($con, $sql_detalle);
  $numero_detalle = mysqli_num_rows($result_detalle);
  if ($numero_detalle > 0) {


    
  while($row_detalle = mysqli_fetch_array($result_detalle, MYSQLI_ASSOC)){

  $id  = $row_detalle['id'];

  echo '<tr>
  <th class="fw-normal no-hover2">'.$row_detalle['concepto'].'</th>
  <td class="text-center no-hover2">'.$row_detalle['cantidad'].'</td>
  <td class="text-center no-hover2">'.$row_detalle['nota'].'</td>
  </tr>';
  }
  }else{
  echo "<tr><th colspan='6' class='text-center text-secondary no-hover2 fw-normal'>No se encontró información para mostrar</th></tr>";  
  }
  ?>

  </tbody>
  </table>
  </div>
  </div>



  <!---------- EVIDENCIA ---------->
  <div class="col-12 mb-3">
  <div class="table-responsive">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> 
  <th class="align-middle text-center" colspan="3">EVIDENCIA</th>
  </tr>

  <tr class="title-table-bg">
  <td class="fw-bold align-middle" width="20px">ARCHIVO</td>
  <th class="text-center align-middle">ÁREA</th>
  <th class="text-center align-middle">MOTIVO</th>
  </tr>

  </thead>

  <tbody class="bg-light">
  <?php  

  $sql_evidencia = "SELECT * FROM op_pedido_materiales_evidencia_archivo WHERE id_pedido = '".$idPedido."' ";

  $result_evidencia = mysqli_query($con, $sql_evidencia);
  $numero_evidencia = mysqli_num_rows($result_evidencia);

  if ($numero_evidencia > 0) {
  while($row_evidencia = mysqli_fetch_array($result_evidencia, MYSQLI_ASSOC)){
  $idEvidencia = $row_evidencia['id'];

  echo'
  
  <tr>
  <th class="align-middle text-center no-hover2"> 
  <a class="pointer" href="'.RUTA_ARCHIVOS.'material-evidencia/'.$row_evidencia['archivo'].'" download><img src="'.RUTA_IMG_ICONOS.'pdf.png"></a>
  </th> 
  <td class="align-middle text-center no-hover2">'.$row_evidencia['area'].'</td>
  <td class="align-middle text-center no-hover2">'.$row_evidencia['motivo'].'</td>
  </tr>';


  }
  }else{
  echo "<tr><th colspan='6' class='text-center text-secondary no-hover2 fw-normal'>No se encontró información para mostrar</th></tr>";  
  }
  ?>

  </tbody>
  </table>
  </div>
  </div>


  <!---------- COMENTARIO ---------->
  <div class="col-12">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> <th class="align-middle text-center">COMENTARIOS</th> </tr>
  </thead>
  <tbody>
  <tr class="no-hover">
  <th class="align-middle text-center fw-normal no-hover2 bg-light"><?=$comentarios;?></th>
  </tr>
  </tbody>
  </table>
  <hr>
  </div>


  <!---------- FIRMAS ---------->

<div class="col-12">
<div class="row">
<?php

$sql_firma = "SELECT * FROM op_pedido_materiales_firma WHERE id_pedido = '".$idPedido."' ";

$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){

$explode = explode(' ', $row_firma['fecha']);

if($row_firma['tipo_firma'] == "A"){
  $TipoFirma = "NOMBRE Y FIRMA DEL ENCARGADO";
  $Detalle = '<div class="border-0 text-center"><img src="'.RUTA_IMG.'firma/'.$row_firma['firma'].'" width="70%"></div>';
  }else if($row_firma['tipo_firma'] == "B"){
  $TipoFirma = "NOMBRE Y FIRMA DE VOBO";
  $Detalle = '<div class="text-center" style="font-size: 1em;"><small class="text-secondary">La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
  }else if($row_firma['tipo_firma'] == "C"){
  $TipoFirma = "NOMBRE Y FIRMA DE AUTORIZACIÓN";
  $Detalle = '<div class="text-center" style="font-size: 1em;"><small class="text-secondary">La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
  }



  echo '  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> <th class="align-middle text-center">'.Personal($row_firma['id_usuario'],$con).'</th> </tr>
  </thead>
  <tbody class="bg-light">
  <tr>
  <th class="align-middle text-center no-hover2">'.$Detalle.'</th>
  </tr>

  <tr>
  <th class="align-middle text-center no-hover2">'.$TipoFirma.'</th>
  </tr>
  
  </tbody>
  </table>
  </div>';
}

?> 
</div>
</div>




</div>



</div>