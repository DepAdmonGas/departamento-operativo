<?php
require('../../../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$GET_year = $_GET['year'];
$GET_mes = $_GET['mes'];
$Pagina = $_GET['pagina'];

$breadcrumbYearMes = $ClassHomeCorporativo->tituloMenuCorporativoYearMes($Pagina,$Session_IDUsuarioBD,$session_idpuesto,$GET_year,$GET_mes);

if($_GET['depu'] == 0){
$depu = $session_idpuesto;
}else{
$depu = $_GET['depu'];
}

if($idEstacion == 8){
$estacion = $ClassHerramientasDptoOperativo->obtenerPuesto($depu);
$busqueda = 'depto = '.$depu;
$colspan = "9";
}else{

$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosEstacion($idEstacion);
$estacion = $datosEstacion['razonsocial'];
$busqueda = 'id_estacion = '.$idEstacion; 
$colspan = "8";

} 

$sql_lista = "SELECT * FROM op_solicitud_vale WHERE id_year = '".$GET_year."' AND id_mes = '".$GET_mes."' AND $busqueda ORDER BY fecha DESC, status ASC ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

function ToComentarios($IdReporte,$con){
$sql_lista = "SELECT id FROM op_solicitud_vale_comentario WHERE id_solicitud = '".$IdReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);
}

?>

  <div class="col-12"> 
  <?=$breadcrumbYearMes?>
        
  <div class="row"> 
  <div class="col-lg-9 col-12 mb-1"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Solicitud de Vales, <?=$ClassHerramientasDptoOperativo->nombreMes($GET_mes)?> <?=$GET_year?></h3> </div>
  
  <div class="col-lg-3 col-12 mt-1"> 	 

  <button type="button" class="btn btn-labeled2 btn-primary float-end ms-2" onclick="Mas(<?=$idEstacion;?>,<?=$depu;?>,<?=$GET_year;?>,<?=$GET_mes;?>)">
  <span class="btn-label2"><i class="fa-solid fa-plus"></i></span>Agregar</button> 

  </div>
  </div>
      
  <hr>
  </div>

    
  <div class="table-responsive">
  <table id="tabla_solicitud_vales" class="custom-table" style="font-size: 12.5px;" width="100%">

 
  <thead class="title-table-bg">

  <tr class="tables-bg">
  <th class="text-center align-middle fw-bold" colspan="<?=$colspan?>"><?=$estacion;?></th>
  </tr>
  
  <tr>
  <td class="text-center align-middle fw-bold">Folio</td>
  <th class="text-center align-middle fw-bold">Fecha</th>
  <?php if($idEstacion == 8){ ?>
  <th class="text-center align-middle tableStyle fw-bold">Cargo a cuenta</th>
  <?php } ?>
  <th class="text-center align-middle fw-bold">Monto</th>
  <th class="text-center align-middle fw-bold">Concepto</th>
  <th class="text-center align-middle fw-bold">Nombre del solicitante</th>
  <th class="text-center align-middle fw-bold">Autorizado por</th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-comentario-tb.png"></th>
  <td class="align-middle text-center" width="20"><i class="fas fa-ellipsis-v"></i></td>
 
  </tr>
  </thead>
	
  <tbody>
  <?php 
  $TotalMonto = 0;

  if ($numero_lista > 0) {
  while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
  $id = $row_lista['id'];
  $ToComentarios = ToComentarios($id,$con);

  if($ToComentarios > 0){
  $Nuevo = '<div class="position-absolute" style="margin-bottom: -15px; right: 2px;"><span class="badge bg-danger text-white rounded-circle"><span class="fw-bold" style="font-size: 10px;">'.$ToComentarios.' </span></span></div>';
  }else{
  $Nuevo = ''; 
  }
 
  if($row_lista['status'] == 0){
  $trColor = 'style="background-color: #fcfcda"';
  $Detalle = '<a class="dropdown-item" onclick="ModalDetalle('.$id.')"><i class="fa-regular fa-eye"></i> Detalle</a>';
  $PDF = '<a class="dropdown-item" onclick="DescargarPDF('.$id.')"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
  $Archivos = '<a class="dropdown-item" onclick="ModalArchivos('.$GET_year.','.$GET_mes.','.$idEstacion.','.$depu.','.$id.')"><i class="fa-regular fa-file"></i> Documentación</a>';
  $Editar = '<a class="dropdown-item" onclick="Editar('.$GET_year.','.$GET_mes.','.$idEstacion.','.$id.')"><i class="fa-solid fa-pencil"></i> Editar</a>';
  $Eliminar = '<a class="dropdown-item" onclick="Eliminar('.$GET_year.','.$GET_mes.','.$idEstacion.','.$depu.','.$id.')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
  $Firma = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" onclick="Firmar('.$GET_year.','.$GET_mes.','.$idEstacion.','.$id.')">';

  }else if($row_lista['status'] == 1){
  $trColor = 'style="background-color: #ffffff"';
  $Detalle = '<a class="dropdown-item" onclick="ModalDetalle('.$id.')"><i class="fa-regular fa-eye"></i> Detalle</a>';
  $PDF = '<a class="dropdown-item" onclick="DescargarPDF('.$id.')"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
  $Archivos = '<a class="dropdown-item" onclick="ModalArchivos('.$GET_year.','.$GET_mes.','.$idEstacion.','.$depu.','.$id.')"><i class="fa-regular fa-file"></i> Documentación</a>';
  $Editar = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';
  $Eliminar = '<a class="dropdown-item grayscale"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
  $Firma = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'icon-firmar.png">';
	
  } 

  if($idEstacion == 8){
  if($row_lista['id_estacion'] == 0){
  $CargoCuenta = $row_lista['cuenta'];
  }else{

  $datosEstacionTb = $ClassHerramientasDptoOperativo->obtenerDatosEstacion($row_lista['id_estacion']);
  $CargoCuenta = $datosEstacionTb['nombre'];

  }

  }

  echo '<tr '.$trColor.'>
  <th class="align-middle text-center"><b>00'.$row_lista['folio'].'</b></th>
	<td class="align-middle text-center">'.$ClassHerramientasDptoOperativo->FormatoFecha($row_lista['fecha']).', '.date("g:i a",strtotime($row_lista['hora'])).'</td>';

	if($idEstacion == 8){
	echo '<td class="align-middle text-center"><b>'.$CargoCuenta.'</b></td>';
	}

	echo '<td class="align-middle text-center">$'.number_format($row_lista['monto'],2).'</td>
	<td class="align-middle text-center">'.$row_lista['concepto'].'</td>
	<td class="align-middle text-center">'.$row_lista['solicitante'].'</td>
	<td class="align-middle text-center">'.$row_lista['autorizado_por'].'</td>
  <td class="align-middle text-center position-relative" onclick="ModalComentario('.$GET_year.','.$GET_mes.','.$idEstacion.','.$depu.','.$id.')">'.$Nuevo.'<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-comentario-tb.png" data-toggle="tooltip" data-placement="top" title="Comentarios"></td>
 
  <td class="align-middle text-center">
  <div class="dropdown">
  <a class="btn btn-sm btn-icon-only text-dropdown-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
  <i class="fas fa-ellipsis-v"></i>
  </a>

  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
  '.$Detalle.'
  '.$PDF.'
  '.$Archivos.'
  '.$Editar.'
  '.$Eliminar.'
  </div>
  </div>
  </td>
	</tr>';

	$TotalMonto = $TotalMonto + $row_lista['monto'];

	}	
	}

	?>		
	</tbody>
	</table>

  </div>
  <hr>

	<div class="text-end"><?='<h5>Monto total: $'.number_format($TotalMonto,2).'</h5>';?></div>
