<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$GET_year = $_GET['year'];
$GET_mes = $_GET['mes'];
$depu = $_GET['depu'];
$TotalMonto = 0;

$sql_lista = "SELECT * FROM op_solicitud_vale WHERE id_year = '".$GET_year."' AND id_mes = '".$GET_mes."' ORDER BY folio";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

function ToComentarios($IdReporte,$con){
$sql_lista = "SELECT id FROM op_solicitud_vale_comentario WHERE id_solicitud = '".$IdReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);
}

function Estacion($idestacion,$con){
$sql_listaestacion = "SELECT id, nombre, razonsocial FROM tb_estaciones WHERE id = '".$idestacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$id = $row_listaestacion['id'];
$estacion = $row_listaestacion['razonsocial'];
$nombre = $row_listaestacion['nombre'];
}
return $nombre;
}

?>
<script type="text/javascript">
$(document).ready(function($){
$('[data-toggle="tooltip"]').tooltip();
});
</script>


<div class="col-12">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.go(-3)"  class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> Corporativo</a></li>
<li class="breadcrumb-item"><a onclick="history.go(-2)"  class="text-uppercase text-primary pointer"> Solicitud de Vales</a></li>
<li class="breadcrumb-item"><a onclick="history.go(-1)"  class="text-uppercase text-primary pointer"> <?=$GET_year;?></a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase"> <?=$ClassHerramientasDptoOperativo->nombremes($GET_mes);?></li>
</ol>
</div>
 
<div class="row"> 
<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 mb-1"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Solicitud de Vales, <?=$ClassHerramientasDptoOperativo->nombremes($GET_mes);?> <?=$GET_year;?></h3> </div>

<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 mt-1"> 
<div class="text-end">
 <div class="dropdown d-inline ms-2 <?=$ocultarbtnEn?>">
 <button type="button" class="btn dropdown-toggle btn-primary" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
 <i class="fa-solid fa-screwdriver-wrench"></i></span>
 </button>

<ul class="dropdown-menu">
<li onclick="Mas(<?=$idEstacion;?>,<?=$depu;?>,<?=$GET_year;?>,<?=$GET_mes;?>)"><a class="dropdown-item pointer"><i class="fa-solid fa-plus text-dark"></i> Agregar</a></li>
<!-- <li onclick="ModalBuscar(<?=$idEstacion;?>,<?=$depu;?>,<?=$GET_year;?>,<?=$GET_mes;?>)"><a class="dropdown-item pointer"><i class="fa-solid fa-magnifying-glass"></i> Buscar</a></li> -->
<li><a class="dropdown-item pointer" href="../../public/solicitud-vales/vistas/reporte-excel-solicitud-vales-admin.php?Year=<?=$GET_year;?>&Mes=<?=$GET_mes;?>"><i class="fa-regular fa-file-excel"></i> Descargar Reporte </a></li>

</ul>
</div>
</div>
 
</div>
</div>
<hr>
</div>


<div class="table-responsive">
<table id="tabla_vales_<?=$idEstacion?>" class="custom-table" style="font-size: .9em;" width="100%">

<thead class="tables-bg">
<tr>
<th class="text-center align-middle tableStyle font-weight-bold">Folio </th>
<th class="text-center align-middle tableStyle font-weight-bold">Fecha</th>
<th class="text-center align-middle tableStyle font-weight-bold">Cargo a cuenta</th>
<th class="text-center align-middle tableStyle font-weight-bold">Monto</th>
<th class="text-center align-middle tableStyle font-weight-bold">Concepto</th>
<th class="text-center align-middle tableStyle font-weight-bold">Nombre del solicitante</th>
<th class="text-center align-middle tableStyle font-weight-bold">Autorizado por</th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-comentario-tb.png"></th>
<th class="align-middle text-center" width="20"><i class="fas fa-ellipsis-v"></i></th>
</tr>
</thead>

<tbody class="bg-white">
<?php 
if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];

if($row_lista['id_estacion'] == 0){
$CargoCuenta = $row_lista['cuenta'];
}else{
$CargoCuenta = Estacion($row_lista['id_estacion'],$con);
}
	  
$ToComentarios = ToComentarios($id,$con);

if($ToComentarios > 0){
$Nuevo = '<div class="position-absolute" style="margin-bottom: -15px; right: 2px;"><span class="badge bg-danger text-white rounded-circle"><span class="fw-bold" style="font-size: 10px;">'.$ToComentarios.' </span></span></div>';
}else{ 
$Nuevo = ''; 
}

	if($row_lista['status'] == 0){
	$trColor = 'style="background-color: #ffb6af"'; 
 	$Detalle = '<a class="dropdown-item" onclick="ModalDetalle('.$id.')"><i class="fa-regular fa-eye"></i> Detalle</a>';
	$PDF = '<a class="dropdown-item" onclick="DescargarPDF('.$id.')"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
	$Archivos = '<a class="dropdown-item" onclick="ModalArchivos('.$GET_year.','.$GET_mes.','.$idEstacion.','.$depu.','.$id.')"><i class="fa-regular fa-file"></i> Documentación</a>';		
	$Editar = '<a class="dropdown-item" onclick="Editar('.$GET_year.','.$GET_mes.','.$idEstacion.','.$id.')"><i class="fa-solid fa-pencil"></i> Editar</a>';
	$Eliminar = '<a class="dropdown-item" onclick="Eliminar('.$GET_year.','.$GET_mes.','.$idEstacion.','.$depu.','.$id.')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
	$Firma = '<img src="'.RUTA_IMG_ICONOS.'icon-firmar.png" onclick="Firmar('.$GET_year.','.$GET_mes.','.$idEstacion.','.$id.')">';

	}else if($row_lista['status'] == 1){
	$trColor = 'style="background-color: #ffffff"';
	$Detalle = '<a class="dropdown-item" onclick="ModalDetalle('.$id.')"><i class="fa-regular fa-eye"></i> Detalle</a>';
	$PDF = '<a class="dropdown-item" onclick="DescargarPDF('.$id.')"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
	$Archivos = '<a class="dropdown-item" onclick="ModalArchivos('.$GET_year.','.$GET_mes.','.$idEstacion.','.$depu.','.$id.')"><i class="fa-regular fa-file"></i> Documentación</a>';
	$Eliminar = '<a class="dropdown-item grayscale"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
	$Firma = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'icon-firmar.png">';

	if($Session_IDUsuarioBD == 292){
	$Editar = '<a class="dropdown-item" onclick="Editar('.$GET_year.','.$GET_mes.','.$idEstacion.','.$id.')"><i class="fa-solid fa-pencil"></i> Editar</a>';
	}else{
	$Editar = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';
	}

	} 

	echo '<tr '.$trColor.'>
	<th class="align-middle text-center">00'.$row_lista['folio'].'</th>
	<td class="align-middle text-center">'.$ClassHerramientasDptoOperativo->FormatoFecha($row_lista['fecha']).', '.date("g:i a",strtotime($row_lista['hora'])).'</td>
	<td class="align-middle text-center">'.$CargoCuenta.'</td>
	<td class="align-middle text-center">$'.number_format($row_lista['monto'],2).'</td>
	<td class="align-middle text-center">'.$row_lista['concepto'].'</td>
	<td class="align-middle text-center">'.$row_lista['solicitante'].'</td>
	<td class="align-middle text-center">'.$row_lista['autorizado_por'].'</td>
	<td class="align-middle text-center position-relative" onclick="ModalComentario('.$GET_year.','.$GET_mes.','.$idEstacion.','.$depu.','.$id.')">'.$Nuevo.'<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-comentario-tb.png"></td>
	<td class="align-middle text-center">
	
	<div class="dropdown-container">
	<a class="btn btn-sm btn-icon-only text-dropdown-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
	<i class="fas fa-ellipsis-v"></i>
	</a>
 
	<div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow">
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

