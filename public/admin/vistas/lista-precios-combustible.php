 <?php
  require('../../../app/help.php');
  $year = $_GET['year'];
  $mes = $_GET['mes'];
  $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $mes, $year);

  function validacionFechas($fecha,$year,$mes,$con){
  $sql_lista = "SELECT * FROM op_formato_precios WHERE year = '".$year."' AND mes = '".$mes."' AND fecha = '".$fecha."' ORDER BY fecha DESC";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);

  if($numero_lista > 0){
  while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
  $id = $row_lista['id'];
  $estado = $row_lista['estatus'];
  
  if($estado == 0){
  $TrColor = 'style="background-color: #fcfcda"';
  }else{
  $TrColor = 'style="background-color: #b0f2c2"';
  }
  }

  $btnAgregar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="editarFormatoPrecio('.$id.')">';
  $btnDetalle = '  <img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png"  onclick="Detalle('.$id.')">  ';

  }else{
  $TrColor = 'style="background-color: #ffb6af"'; 
  $btnAgregar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="agregarNuevoFormato('.$year.','.$mes.',\''.$fecha.'\')">';
  $btnDetalle = '  <img class="pointer grayscale" src="'.RUTA_IMG_ICONOS.'ver-tb.png">  ';

  }

  $datosUsuario = array(
  'TrColor' => $TrColor,
  'btnAgregar'=> $btnAgregar,
  'btnDetalle'=> $btnDetalle

  );
  
  return $datosUsuario;
  }


  if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"){
  $ocultarOp = "d-none";
  }else{ 
  $ocultarOp = "";         
  } 
  ?>
  
  <div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.go(-3)"  class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> Importación</a></li>
  <li class="breadcrumb-item"><a onclick="history.go(-2)"  class="text-uppercase text-primary pointer"> Precios diarios de combustible</a></li>
  <li class="breadcrumb-item"><a onclick="history.go(-1)"  class="text-uppercase text-primary pointer"> <?=$year?></a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase"><?=$ClassHerramientasDptoOperativo->nombremes($mes)?> </li>
  </ol>
  </div>
 
  <div class="row"> 
  <div class="col-12"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Precios diarios de combustible, <?=$ClassHerramientasDptoOperativo->nombremes($mes)?> <?=$year?></h3> </div>
  </div>

  <hr>
  </div>

  <div class="table-responsive">
  <table id="tabla_precios" class="custom-table" style="font-size: 14px;" width="100%">

  <thead class="tables-bg">
  <th class="text-center align-middle font-weight-bold" width="60">#</th>
  <th class="text-start align-middle font-weight-bold">Fecha</th>
  <th class="text-center align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>ver-tb.png"></th>
  <?php if($session_nompuesto != "Encargado" && $session_nompuesto != "Asistente Administrativo") :?>
    <th class="text-center align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
  <?php endif; ?>
  </thead> 

  <tbody>
  <?php

  $num = 1;
  for ($day = 1; $day <= $daysInMonth; $day++) {
  $date = sprintf("%04d-%02d-%02d", $year, $mes, $day); // Formato YYYY-MM-DD

  $datosPrecios = validacionFechas($date,$year,$mes,$con);
  $TrColor = $datosPrecios['TrColor'];
  $btnDetalle = $datosPrecios['btnDetalle'];
  $btnAgregar = $datosPrecios['btnAgregar'];


  echo '<tr '.$TrColor.'>';
  echo '<th class="align-middle text-center fw-normal">'.$num.'</th>';
  echo '<td class="align-middle text-start">'.$ClassHerramientasDptoOperativo->FormatoFecha($date).'</td>';
  echo '<td class="align-middle text-center">'.$btnDetalle.'</td>';
  if($session_nompuesto != "Encargado" && $session_nompuesto != "Asistente Administrativo"):
    echo '<td class="align-middle text-center '.$ocultarOp.'">'.$btnAgregar.'</td>';
  endif;
  echo '</tr>';

  $num++;
  }

  ?>
  </tbody>
  </table>  
  </div>