<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosEstacion($idEstacion);

$sql_lista = "SELECT * FROM op_nivel_explosividad WHERE id_estacion = '".$idEstacion."' ORDER BY folio DESC ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

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
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Nivel de explosividad <?=$Estacion?></li>
  </ol>
  </div>

  <div class="row">
  <div class="col-xl-9 col-lg-9 col-md-6 col-sm-12"><h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Nivel de explosividad <?=$Estacion?></h3></div>
  <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
  <button type="button" class="btn btn-labeled2 btn-primary float-end <?=$ocultarTB?>" onclick="Agregar(<?=$idEstacion;?>)">
  <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>

  </div>

  </div>
  <hr>
  </div>

  <div class="table-responsive">
  <table class="table table-sm table-bordered table-hover mb-0">

  <div class="table-responsive">
  <table id="tabla_nivel_explosividad_<?=$idEstacion?>" class="custom-table" style="font-size: 12.5px;" width="100%">

  <thead class="title-table-bg">
  <tr>
  <th class="align-middle text-center" width="84px">Folio</th>
  <th class="align-middle text-start">Fecha</th>
  <th class="align-middle text-center" width="24"><img src="<?=RUTA_IMG_ICONOS;?>ver-tb.png"></th>

  <?php if($session_nompuesto != "Encargado" && $session_nompuesto != "Asistente Administrativo"){ ?>
  <th class="align-middle text-center" width="24"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
  <th class="align-middle text-center" width="24"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
  <?php } ?>

  </tr>
  </thead>

  <tbody class="bg-white">
    
  <?php 
  if ($numero_lista > 0) {
  while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
  $estatus = $row_lista['estado'];

  if($estatus == 0){
    $bgTable = 'style="background-color: #ffb6af"'; 
    $btnDetalle = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'ver-tb.png">';
    $btnEditar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="EditarInfo('.$row_lista['id'].')">';
    $btnEliminar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$idEstacion.','.$row_lista['id'].')">';
  }else{
    $bgTable = 'style="background-color: #b0f2c2"';
    $btnDetalle = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="Detalle('.$row_lista['id'].')">';
    $btnEditar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'editar-tb.png">';
    $btnEliminar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'eliminar.png">';
  }

  echo '<tr '.$bgTable.'>';
  echo '<th class="align-middle text-center">00'.$row_lista['folio'].'</th>';
  echo '<td class="align-middle text-start">'.$ClassHerramientasDptoOperativo->FormatoFecha($row_lista['fecha']).'</td>';
  echo '<td class="align-middle text-center">'.$btnDetalle.'</td>';
  
  if($session_nompuesto != "Encargado" && $session_nompuesto != "Asistente Administrativo"){ 
  echo '<td class="align-middle text-center">'.$btnEditar.'</td>';
  echo '<td class="align-middle text-center">'.$btnEliminar.'</td>';
  }
  
  echo '</tr>';

  }
  }
  ?>
  </tbody>

  </table>
  </div>

