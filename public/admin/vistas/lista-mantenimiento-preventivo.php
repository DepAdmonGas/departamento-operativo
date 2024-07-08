<?php
require('../../../app/help.php');
$idEstacion = $_GET['idEstacion'];
$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosEstacion($idEstacion);
 
$sql_lista = "SELECT * FROM op_mantenimiento_preventivo WHERE id_estacion = '".$idEstacion."' ORDER BY folio DESC ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

function NombrePersonal($id,$con){
$return = "";
$sql_personal = "SELECT nombre FROM tb_usuarios WHERE id = '".$id."' ";
$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);

while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){
$return = $row_personal['nombre']; 
}

return $return;
}


//---------- Configuracion personal ----------//
if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"){
  $titleMenu = '<i class="fa-solid fa-house"></i> Almacén';
  $Estacion = '';
  $ocultarTB = "d-none";
  
  }else{ 
  $titleMenu = '<i class="fa-solid fa-chevron-left"></i> Mantenimiento';
  $ocultarTB = "";
    
  if($idEstacion == 8){
    $Estacion = "Otros";
  }else{
    $Estacion = '('.$datosEstacion['nombre'].')';
  }

} 


?> 


  <div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"> <?=$titleMenu?></a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Mantenimiento Preventivo <?=$Estacion?></li>
  </ol>
  </div>

  <div class="row">
  <div class="col-xl-9 col-lg-9 col-md-6 col-sm-12"><h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Mantenimiento Preventivo <?=$Estacion?></h3></div>
  <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">

  <?php
  if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"){
  ?>
  <button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="Nuevo(<?=$idEstacion;?>)">
  <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>

  <?php
  }else{
  ?>

  <div class="dropdown d-inline">
  <button type="button" class="btn dropdown-toggle btn-primary float-end" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
  <i class="fa-solid fa-screwdriver-wrench"></i></span>
  </button>

  <ul class="dropdown-menu">
  <li onclick="Nuevo(<?=$idEstacion;?>)"><a class="dropdown-item pointer">  <i class="fa-solid fa-plus text-dark"></i> Agregar</a></li>
  <li onclick="DocumentosMtto(<?=$idEstacion;?>)"><a class="dropdown-item pointer">  <i class="fa-solid fa-vial-circle-check text-dark"></i> Prueba de Eficiencia</a></li>

  </ul>
  </div>

  <?php
  }
  ?>


  </div>

  </div>
  <hr>
  </div>

  <div class="table-responsive">
  <table id="tabla_mantenimiento_<?=$idEstacion?>" class="custom-table" style="font-size: 12.5px;" width="100%">

  <thead class="title-table-bg">
  <tr>
  <th class="align-middle text-center" width="40">Folio</th>
  <th class="align-middle text-center">Encargado</th>
  <th class="align-middle text-center">Fecha Mantenimiento CECM </th>
  <th class="align-middle text-center" width="145px">Orden de servicio</td> 
  <th class="align-middle text-center">Proxima Prueba</td>  
  <th class="align-middle text-center">Observación</td>  
  <th class="align-middle text-center" width="80">Status</td>  
  <th class="align-middle text-center" width="20"><i class="fas fa-ellipsis-v"></i></th>

  </tr>
  </thead> 

  <tbody>
  <?php
  if ($numero_lista > 0) {
  $num = 1;
  while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

  $id = $row_lista['id'];
  $fechaUno = $ClassHerramientasDptoOperativo->FormatoFecha($row_lista['fecha']);
  $fechaDos = $ClassHerramientasDptoOperativo->FormatoFecha($row_lista['fecha2']);
  $status = $row_lista['status'];

  if($row_lista['fecha'] == "0000-00-00"){
    $fechaOpc1 = "";

  }else{
    $fechaOpc1 = ''.$fechaUno.'';
  }


  if($row_lista['fecha2'] == "0000-00-00"){
    $fechaOpc2 = "";
    $fechaForMes = date("m",strtotime($row_lista['fecha']."+ 4 month"));

  }else{
    $fechaOpc2 = 'y <br> '.$fechaDos.'';
    $fechaForMes = date("m",strtotime($row_lista['fecha2']."+ 4 month"));
  }
  

  if($row_lista['orden_servicio'] != ""){
  $Descargar = '<a href="'.RUTA_ARCHIVOS.'mantenimiento/'.$row_lista['orden_servicio'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'descargar.png" data-toggle="tooltip" data-placement="top" title="Descargar"></a>';
  }else{
  $Descargar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="">';  
  }
  
  if($status == 0){
    $bgTable = 'style="background-color: #ffb6af"';
    $btnEditar = '<a class="dropdown-item" onclick="ModalEditar('.$idEstacion.','.$id.')"><i class="fa-solid fa-pencil"></i> Editar</a>';
    $btnEliminar = '<a class="dropdown-item" onclick="Eliminar('.$idEstacion.','.$id.')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
    $btnStatus = '<a class="dropdown-item" onclick="ActualizarStatus('.$idEstacion.','.$id.','.$status.')"><i class="fa-solid fa-rotate"></i> Actualizar Status</a>';
    $nameStatus = '<span class="badge rounded-pill bg-danger">Pendiente</span>';


  }else if($status == 1){
    $bgTable = 'style="background-color: #fcfcda"';
    $btnEditar = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';
    $btnEliminar = '<a class="dropdown-item" onclick="Eliminar('.$idEstacion.','.$id.')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
    $btnStatus = '<a class="dropdown-item" onclick="ActualizarStatus('.$idEstacion.','.$id.','.$status.')"><i class="fa-solid fa-rotate"></i> Actualizar Status</a>';
    $nameStatus = '<span class="badge rounded-pill bg-warning text-dark">En Proceso</span>';

  }else if($status == 2){
    $bgTable = 'style="background-color: #b0f2c2"';
    $btnEditar = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';
    $btnEliminar = '<a class="dropdown-item grayscale"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
    $btnStatus = '<a class="dropdown-item grayscale"><i class="fa-solid fa-rotate"></i> Actualizar Status</a>';
    $nameStatus = '<span class="badge rounded-pill bg-success">Finalizado</span>';

  }
 

  echo '<tr '.$bgTable.'>';
  echo '<tH class="align-middle text-center">00'.$row_lista['folio'].'</tH>';
  echo '<td class="align-middle text-center">'.NombrePersonal($row_lista['id_encargado'],$con).'</td>';
  echo '<td class="align-middle text-center">'.$fechaOpc1.' '.$fechaOpc2.'</td>';
  echo '<td class="align-middle text-center">'.$Descargar.'</td>';

  echo '<td class="align-middle text-center">'.$ClassHerramientasDptoOperativo->nombremes($fechaForMes).'</td>';
  echo '<td class="align-middle text-center">'.$row_lista['observaciones'].'</td>';
  echo '<td class="align-middle text-center">'.$nameStatus.'</td>';
  echo '<td class="align-middle text-center">
  <div class="dropdown">

  <a class="btn btn-sm btn-icon-only text-dropdown-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
  <i class="fas fa-ellipsis-v"></i>
  </a>

  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
  '.$btnStatus.'
  '.$btnEditar.'
  '.$btnEliminar.'
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

