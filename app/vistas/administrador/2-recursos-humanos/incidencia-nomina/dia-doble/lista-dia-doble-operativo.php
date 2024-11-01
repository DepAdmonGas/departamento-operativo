<?php 
require('../../../../../../app/help.php');
$year = $_GET['year'];
$quincena = $_GET['quincena'];

$sql_personal = "SELECT * FROM op_rh_dia_doble_registro WHERE year = '".$year."' ORDER BY quincena ASC";
$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);


function ToComentarios($idReporte,$con){
  $sql_lista = "SELECT id FROM op_rh_dia_doble_comentarios WHERE id_reporte = '".$idReporte."' ";
  $result_lista = mysqli_query($con, $sql_lista);   
  return $numero_lista = mysqli_num_rows($result_lista);      
  }

?> 

  <div class="row">

  <div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-home"></i> Incidencia de Nomina </a></li>
  <li class="breadcrumb-item text-uppercase text-primary pointer" >Dias dobles (Dirección de Operaciones), <?=$year?></li>
  </ol>
  </div>
    
  <div class="row"> 
  <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Dias dobles (Dirección de Operaciones), <?=$year?></h3> </div>
  <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
  <button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="FormularioDiaDoble(<?=$year?>, <?=$quincena?>)">
  <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
  </div>
  </div>

  <hr>
  </div> 


  <div class="col-12">
  <div class="table-responsive*">

  <table id="tabla_operativo_<?=$year?>" class="custom-table" style="font-size: .8em;" width="100%">
  
  <thead class="tables-bg">
  <tr>
  <th class="text-center align-middle" width="48px">No.</th>
  <th class="text-center align-middle">Fecha de creación</th>
  <th class="text-center align-middle"  width="96">No. Quincena</th>
  <th class="text-center align-middle">Del</th>
  <th class="text-center align-middle">Al</th>
  <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>icon-firmar-w.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>comentario-tb.png"></th>
  <th class="align-middle text-center" width="20"><i class="fas fa-ellipsis-v"></i></th>
  </tr>
  </thead>
 
  <tbody class="bg-white">
  <?php 
  if ($numero_personal > 0) {
  $num = 1;
  while ($row_personal  = mysqli_fetch_array($result_personal , MYSQLI_ASSOC)) {
  $idReporte = $row_personal['id'];
  $explode = explode(" ", $row_personal['fecha_creacion']);
  $HoraFormato = date("g:i a", strtotime($explode[1]));

  $quincenatb = $row_personal['quincena'];
  $mes = $ClassHerramientasDptoOperativo->obtenerMesPorQuincena(numeroQuincena: $quincenatb);
  //---------- FECHA DE INICIO Y FIN DE LA QUINCENA ----------
  $fechaNomiaQuincena = $ClassHerramientasDptoOperativo->fechasNominaQuincenas($year,$mes,$quincenatb);
  $inicioQuincenaDay = $fechaNomiaQuincena['inicioQuincenaDay'];
  $finQuincenaDay = $fechaNomiaQuincena['finQuincenaDay'];
  $status = $row_personal['status'];

 
  $ToComentarios = ToComentarios($idReporte,$con);
  if($ToComentarios > 0){
  $Nuevo = '<div class="position-absolute" style="margin-bottom: -15px; right: 3px;"><span class="badge bg-danger text-white rounded-circle"><span class="fw-bold" style="font-size: 10px;">'.$ToComentarios.' </span></span></div>';
  }else{
  $Nuevo = ''; 
  } 

  if($status == 0){
  $trColor = 'style="background-color: #ffb6af"';
  $Detalle = '<a class="dropdown-item grayscale"><i class="fa-regular fa-eye"></i> Detalle</a>';
  $Editar = '<a class="dropdown-item" onclick="EditFormulario('.$idReporte.')"><i class="fa-solid fa-pencil"></i> Editar</a>';
  $Eliminar = '<a class="dropdown-item" onclick="DeleteFormulario('.$idReporte.','.$year.','.$quincena.')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
  $Firmar = '<img class="grayscale" src="' . RUTA_IMG_ICONOS . 'icon-firmar.png" data-toggle="tooltip" data-placement="top" title="Firmar formato">';
  $PDF = '<a class="dropdown-item grayscale"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';

  }else if($status == 1){
  $trColor = 'style="background-color: #fcfcda"';
  $Detalle = '<a class="dropdown-item" onclick="DetalleFormulario('.$idReporte.')"><i class="fa-regular fa-eye"></i> Detalle</a>';
  $Editar = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';
  $Eliminar = '<a class="dropdown-item grayscale"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
  $Firmar = '<img onclick="Firmar('.$idReporte.')" src="' . RUTA_IMG_ICONOS . 'icon-firmar.png" data-toggle="tooltip" data-placement="top" title="Firmar formato">';
  $PDF = '<a class="dropdown-item grayscale"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';

  }else if($status == 2){
  $trColor = 'style="background-color: #fcfcda"';
  $Detalle = '<a class="dropdown-item" onclick="DetalleFormulario('.$idReporte.')"><i class="fa-regular fa-eye"></i> Detalle</a>';
  $Editar = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';
  $Eliminar = '<a class="dropdown-item grayscale"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
  $Firmar = '<img onclick="Firmar('.$idReporte.')" src="' . RUTA_IMG_ICONOS . 'icon-firmar-vb.png" data-toggle="tooltip" data-placement="top" title="Firmar formato">';
  $PDF = '<a class="dropdown-item grayscale"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';

  }else if($status == 3){
  $trColor = 'style="background-color: #b0f2c2"';
  $Detalle = '<a class="dropdown-item" onclick="DetalleFormulario('.$idReporte.')"><i class="fa-regular fa-eye"></i> Detalle</a>';
  $Editar = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';
  $Eliminar = '<a class="dropdown-item grayscale"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
  $Firmar = '<img class="grayscale" src="' . RUTA_IMG_ICONOS . 'icon-firmar-ao.png" data-toggle="tooltip" data-placement="top" title="Firmar formato">';
  $PDF = '<a class="dropdown-item" onclick="DescargarPDF('.$idReporte.')"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';

  }

  echo '<tr ' . $trColor . '>';
  echo '<th class="align-middle text-center">'.$num.'</th>';
  echo '<td class="align-middle">' . $ClassHerramientasDptoOperativo->FormatoFecha($explode[0]) . ', ' . $HoraFormato . '</td>';
  echo '<td class="align-middle text-center">'.$quincena.'</td>';
  echo '<td class="align-middle">'.$ClassHerramientasDptoOperativo->FormatoFecha($inicioQuincenaDay).'</b></td>';
  echo '<td class="align-middle">'.$ClassHerramientasDptoOperativo->FormatoFecha($finQuincenaDay).'</b></td>';
  echo '<td class="align-middle text-center position-relative" onclick="ModalComentario('.$idReporte.','.$year.','.$quincena.')">'.$Nuevo.'<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-comentario-tb.png" data-toggle="tooltip" data-placement="top" title="Comentarios"></td>';
  echo '<td class="align-middle text-center">'.$Firmar.'</td>';
  echo '<td class="align-middle text-center"> 
  <div class="dropdown">
  <a class="btn btn-sm btn-icon-only text-dropdown-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
  <i class="fas fa-ellipsis-v"></i>
  </a>
  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
  ' . $Detalle . '
  ' . $PDF . '
  ' . $Editar . '
  ' . $Eliminar . '
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
  </div> 

  </div>