<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];

$GET_year = $_GET['year'];
$GET_mes = $_GET['mes'];

if($_GET['depu'] == 0){
$depu = $session_idpuesto;
}else{
$depu = $_GET['depu'];
}

if($idEstacion == 8){
$sql_puesto = "SELECT tipo_puesto FROM tb_puestos WHERE id = '".$depu."' ";
$result_puesto = mysqli_query($con, $sql_puesto);
while($row_puesto = mysqli_fetch_array($result_puesto, MYSQLI_ASSOC)){
$estacion = $row_puesto['tipo_puesto'];
} 
  
$busqueda = 'depto = '.$depu;
}else{
$sql_listaestacion = "SELECT razonsocial FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['razonsocial'];
} 
$busqueda = 'id_estacion = '.$idEstacion; 
} 

$sql_lista = "SELECT * FROM op_solicitud_vale WHERE id_year = '".$GET_year."' AND id_mes = '".$GET_mes."' AND $busqueda ORDER BY fecha DESC, status ASC ";
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



  <div class="col-12 mb-3">
  <div class="cardAG">
  <div class="border-0 p-3">

    <div class="row">
    <div class="col-12">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    
    <div class="row">
    
    <div class="col-11">
    <h5>Solicitud de vales, <?=nombremes($GET_mes);?> <?=$GET_year;?></h5>
    </div>


    <div class="col-1">
		<img class="float-end pointer" onclick="Mas(<?=$idEstacion;?>,<?=$depu;?>,<?=$GET_year;?>,<?=$GET_mes;?>)" src="<?=RUTA_IMG_ICONOS;?>agregar.png">
		</div>


    </div>

    </div>
    </div>

  <hr>

<div class="table-responsive">

<table class="table table-sm table-bordered table-hover mb-0" style="font-size: .9em;">

<thead class="bg-light" >
<tr>
<th class="text-center align-middle tableStyle font-weight-bold" colspan="14"><?=$estacion;?></th>
</tr>
</thead>

	<thead class="tables-bg">
		<tr>
			<th class="text-center align-middle tableStyle font-weight-bold">Folio</th>
			<th class="text-center align-middle tableStyle font-weight-bold">Fecha</th>
			<?php if($idEstacion == 8){ ?>
			<th class="text-center align-middle tableStyle font-weight-bold">Cargo a cuenta</th>
			<?php } ?>
			<th class="text-center align-middle tableStyle font-weight-bold">Monto</th>
			<th class="text-center align-middle tableStyle font-weight-bold">Concepto</th>
			<th class="text-center align-middle tableStyle font-weight-bold">Nombre del solicitante</th>
			<th class="text-center align-middle tableStyle font-weight-bold">Autorizado por</th>
			<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>ver-tb.png"></th>
		   	<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
		   	<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>archivo-tb.png"></th>
		   <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-comentario-tb.png"></th>
		   <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
		   <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
		</tr>
	</thead>
	<tbody>
	<?php 
	if ($numero_lista > 0) {
	while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
	$id = $row_lista['id'];

	  $ToComentarios = ToComentarios($id,$con);

  if($ToComentarios > 0){
    $Nuevo = '<div class="float-end" style="margin-bottom: -4px"><span class="badge bg-danger text-white rounded-circle" style="font-size: .5em;"><small>'.$ToComentarios.'</small></span></div>';
  }else{
   $Nuevo = ''; 
  }

	if($row_lista['status'] == 0){
	$trColor = "table-warning";	
	$Detalle = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="ModalDetalle('.$id.')">';
	$PDF = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" onclick="DescargarPDF('.$id.')">';
	$Archivos = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'archivo-tb.png" onclick="ModalArchivos('.$GET_year.','.$GET_mes.','.$idEstacion.','.$depu.','.$id.')">';
	$Editar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="Editar('.$GET_year.','.$GET_mes.','.$idEstacion.','.$id.')">';
	$Firma = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" onclick="Firmar('.$GET_year.','.$GET_mes.','.$idEstacion.','.$id.')">';
	$Eliminar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$GET_year.','.$GET_mes.','.$idEstacion.','.$depu.','.$id.')">';

	}else if($row_lista['status'] == 1){
	$trColor = "";
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
	$CargoCuenta = Estacion($row_lista['id_estacion'],$con);
	}

	}

	echo '<tr class="'.$trColor.'">
	<td class="align-middle text-center"><b>00'.$row_lista['folio'].'</b></td>
	<td class="align-middle text-center">'.FormatoFecha($row_lista['fecha']).', '.date("g:i a",strtotime($row_lista['hora'])).'</td>';

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
	}else{
	echo "<tr><td colspan='14' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
	}

	?>		
	</tbody>
	</table>

</div>

<hr>
	<div class="text-end"><?='<h5>Monto total: $'.number_format($TotalMonto,2).'</h5>';?></div>
