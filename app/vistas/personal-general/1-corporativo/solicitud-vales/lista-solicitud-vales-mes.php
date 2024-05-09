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
$colspan = "13";
}else{

$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosEstacion($idEstacion);
$estacion = $datosEstacion['razonsocial'];
$busqueda = 'id_estacion = '.$idEstacion; 
$colspan = "12";

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
  <div class="col-lg-9 col-12 mb-1"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Solicitud de vales, <?=$ClassHerramientasDptoOperativo->nombreMes($GET_mes)?> <?=$GET_year?></h3> </div>
  
  <div class="col-lg-3 col-12 mt-1"> 	 

  <button type="button" class="btn btn-labeled2 btn-primary float-end ms-2" onclick="Mas(<?=$idEstacion;?>,<?=$depu;?>,<?=$GET_year;?>,<?=$GET_mes;?>)">
  <span class="btn-label2"><i class="fa-solid fa-plus"></i></span>Agregar</button> 

  </div>
  </div>
      
  <hr>
  </div>

  <div class="col-12">
    
  <div class="table-responsive">
  <table id="tabla_solicitud_vales" class="custom-table mt-2" style="font-size: 12.5px;" width="100%">

 
  <thead class="navbar-bg">

  <tr class="tables-bg">
  <th class="text-center align-middlefw-bold" colspan="<?=$colspan?>"><?=$estacion;?></th>
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
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>ver-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>archivo-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-comentario-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
  <td class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></td>
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
  $Nuevo = '<div class="float-end" style="margin-bottom: -5px"><span class="badge bg-danger text-white rounded-circle"><span class="fw-bold" style="font-size: 11px;">'.$ToComentarios.'</span></span></div>';
  }else{
  $Nuevo = ''; 
  }
 
  if($row_lista['status'] == 0){
  $trColor = 'style="background-color: #fcfcda"';
  $Detalle = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="ModalDetalle('.$id.')">';
  $PDF = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" onclick="DescargarPDF('.$id.')">';
  $Archivos = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'archivo-tb.png" onclick="ModalArchivos('.$GET_year.','.$GET_mes.','.$idEstacion.','.$depu.','.$id.')">';
  $Editar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="Editar('.$GET_year.','.$GET_mes.','.$idEstacion.','.$id.')">';
  $Firma = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" onclick="Firmar('.$GET_year.','.$GET_mes.','.$idEstacion.','.$id.')">';
  $Eliminar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$GET_year.','.$GET_mes.','.$idEstacion.','.$depu.','.$id.')">';

  }else if($row_lista['status'] == 1){
  $trColor = 'style="background-color: #ffffff"';
  $Detalle = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="ModalDetalle('.$id.')">';
  $PDF = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" onclick="DescargarPDF('.$id.')">';
  $Archivos = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'archivo-tb.png" onclick="ModalArchivos('.$GET_year.','.$GET_mes.','.$idEstacion.','.$depu.','.$id.')">';
  $Editar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'editar-tb.png">';
  $Firma = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'icon-firmar.png">';
  $Eliminar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'eliminar.png">';
	
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
	<td class="align-middle text-center">'.$Detalle.'</td>
	<td class="align-middle text-center">'.$PDF.'</td>	
	<td class="align-middle text-center">'.$Archivos.'</td>
	<td class="align-middle text-center">'.$Nuevo.'<img src="'.RUTA_IMG_ICONOS.'icon-comentario-tb.png" class="pointer" onclick="ModalComentario('.$GET_year.','.$GET_mes.','.$idEstacion.','.$depu.','.$id.')"></td>
	<td class="align-middle text-center">'.$Editar.'</td>
	<td class="align-middle text-center">'.$Eliminar.'</td>
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
  </div>