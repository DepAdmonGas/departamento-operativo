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
$sql_listaestacion = "SELECT nombre, razonsocial FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
} 
$busqueda = 'id_estacion = '.$idEstacion; 
}   
  
$sql_lista = "SELECT * FROM op_solicitud_cheque WHERE id_year = '".$GET_year."' AND id_mes = '".$GET_mes."' AND $busqueda ORDER BY fecha ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);


function ToComentarios($IdReporte,$con){

$sql_lista = "SELECT id FROM op_solicitud_cheque_comentario WHERE id_solicitud = '".$IdReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);

}

function Pago($id,$con){
$sql_lista = "SELECT id FROM op_solicitud_cheque_documento WHERE id_solicitud = '".$id."' AND nombre = 'PAGO' ";
$result_lista = mysqli_query($con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);  
}

function FirmaSolicitud($idReporte, $con){
$sql_firma = "SELECT * FROM op_solicitud_cheque_firma WHERE id_solicitud = '".$idReporte."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);

return $numero_firma; 
}



function IdReporte($GET_idEstacion,$GET_year,$GET_mes,$con){
$sql_year = "SELECT id, id_estacion, year FROM op_corte_year WHERE id_estacion = '".$GET_idEstacion."' AND year = '".$GET_year."' ";
$result_year = mysqli_query($con, $sql_year);
while($row_year = mysqli_fetch_array($result_year, MYSQLI_ASSOC)){
$idyear = $row_year['id'];
}
$idmes = "";
$sql_mes = "SELECT id, id_year, mes FROM op_corte_mes WHERE id_year = '".$idyear."' AND mes = '".$GET_mes."' ";
$result_mes = mysqli_query($con, $sql_mes);

while($row_mes = mysqli_fetch_array($result_mes, MYSQLI_ASSOC)){
$idmes = $row_mes['id'];
}
return $idmes;
} 
 

$IdReporte = IdReporte($idEstacion,$GET_year,$GET_mes,$con);

function statusDocs($idReporte,$detalle,$con){
$sql_detalleDoc = "SELECT detalle FROM op_factura_telcel WHERE id_mes = '".$idReporte."' AND detalle = '".$detalle."' ";
$result_detalleDoc = mysqli_query($con, $sql_detalleDoc);
return $numero_detalleDoc = mysqli_num_rows($result_detalleDoc);

}
 
$statusFactura = statusDocs($IdReporte,'Factura',$con);
$statusPago = statusDocs($IdReporte,'Pago',$con);
 

if($statusFactura > 0){
if($statusPago > 0){
$alertIcon = 'telefono-verde.png';
$alertBgText = 'text-success';
$alertBg = 'bg-success';
$alertText = "Pagado"; 

}else{
$alertIcon = 'telefono-amarillo.png';
$alertBgText = 'text-warning';
$alertBg = 'bg-warning';
$alertText = "Factura disponible"; 
}

}else{
$alertIcon = 'telefono-red.png';
$alertBgText = 'text-danger';
$alertBg = 'bg-danger';
$alertText = "Sin factura"; 
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
<li class="breadcrumb-item"><a onclick="history.go(-3)"  class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> Importación</a></li>
<li class="breadcrumb-item"><a onclick="history.go(-2)"  class="text-uppercase text-primary pointer"> Solicitud de Cheques </a></li>
<li class="breadcrumb-item"><a onclick="history.go(-1)"  class="text-uppercase text-primary pointer"> <?=$GET_year?></a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase"> <?=$ClassHerramientasDptoOperativo->nombremes($GET_mes)?> </li>
<li aria-current="page" class="breadcrumb-item active text-uppercase"> <span class="badge <?=$alertBg?>"><?=$alertText?></span></li>
</ol>
</div>
 
<div class="row"> 
<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 mb-1"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Solicitud de cheques (<?=$estacion?>), <?=$ClassHerramientasDptoOperativo->nombremes($GET_mes)?> <?=$GET_year?></h3> </div>

<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 mt-1"> 

<div class="text-end">
<div class="dropdown d-inline ms-2">
<button type="button" class="btn dropdown-toggle btn-primary" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-screwdriver-wrench"></i></button>
<ul class="dropdown-menu">
<li onclick="Mas(<?=$idEstacion;?>,<?=$depu;?>,<?=$GET_year;?>,<?=$GET_mes;?>)"> <a class="dropdown-item pointer"><i class="fa-solid fa-plus"></i> Agregar </a> </li>
<li onclick="Telcel(<?=$idEstacion;?>,<?=$GET_year;?>,<?=$GET_mes;?>)"><a class="dropdown-item pointer <?=$alertBgText?>"><i class="fa-solid fa-file-invoice-dollar"></i> Facturas Telcel</a></li>
<?php if($idEstacion == 6 || $idEstacion == 7){ ?>
<li onclick="FacTelcel(<?=$idEstacion;?>,<?=$depu;?>,<?=$GET_year;?>,<?=$GET_mes;?>)"><a class="dropdown-item pointer"><i class="fa-solid fa-money-check-dollar"></i> Comprobante de Pago</a></li>
<?php } ?>
</ul>
</div>
</div>

</div>

</div>

<hr>
</div>


  <div class="table-responsive">
  <table id="tabla_solicitud_cheque_<?=$idEstacion?>" class="custom-table" style="font-size: 12.5px;" width="100%">
  <thead class="tables-bg">

  <tr>
  <th class="text-center align-middle tableStyle font-weight-bold">#</th>
  <?php
  if($estacion == "Gestoria"){
  echo '<th class="text-center align-middle tableStyle font-weight-bold">Razón Social</th>';
  }
  ?>
  <th class="text-center align-middle tableStyle font-weight-bold">Fecha</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Beneficiario</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Monto</th>
  <th class="text-center align-middle tableStyle font-weight-bold">No. Factura</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Concepto</th> 
  <?php
  if($estacion != "Gestoria"){
  echo '<th class="text-center align-middle tableStyle font-weight-bold">Telefono</th>';
  }
  ?> 
  
  <th class="text-center align-middle tableStyle font-weight-bold">Metodo de pago</th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-firmar-w.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-comentario-tb.png"></th>
  <th class="align-middle text-center" width="20"><i class="fas fa-ellipsis-v"></i></th>
  </tr>
  </thead> 

  <tbody>
  <?php
  if ($numero_lista > 0) {
  $TotalMonto = 0;
  $num = 1;
  while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
  $id = $row_lista['id'];
  $pago = Pago($id,$con);
  $Firmas = FirmaSolicitud($id,$con);

  if($Firmas == 1){
  $Firmar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" onclick="Firmar('.$GET_year.','.$GET_mes.','.$idEstacion.','.$id.')" data-toggle="tooltip" data-placement="top" title="Firmar solicitud">';
  }else if($Firmas == 2){
  $Firmar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-firmar-vb.png" onclick="Firmar('.$GET_year.','.$GET_mes.','.$idEstacion.','.$id.')" data-toggle="tooltip" data-placement="top" title="Firmar solicitud">';
  }else if($Firmas == 3 || $row_lista['status'] == 2){
  $Firmar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'icon-firmar-ao.png" data-toggle="tooltip" data-placement="top" title="Firmar solicitud">';
  }


  if($row_lista['status'] == 0){
  $trColor = 'style="background-color: #fcfcda"';
  $PDF = '<a class="dropdown-item grayscale"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
  $Pago = '<a class="dropdown-item grayscale"><i class="fa-solid fa-money-bill"></i> Pagos</a>';
  $Editar = '<a class="dropdown-item" onclick="Editar('.$GET_year.','.$GET_mes.','.$idEstacion.','.$id.')"><i class="fa-solid fa-pencil"></i> Editar</a>';
  $Eliminar = '<a class="dropdown-item" onclick="Eliminar('.$GET_year.','.$GET_mes.','.$idEstacion.','.$depu.','.$id.')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
  
  }else if($row_lista['status'] == 1){
  $trColor = 'style="background-color: #fcfcda"';
  $PDF = '<a class="dropdown-item grayscale"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
  $Pago = '<a class="dropdown-item grayscale"><i class="fa-solid fa-money-bill"></i> Pagos</a>';
  $Editar = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';
  $Eliminar = '<a class="dropdown-item grayscale"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';

  }else if($row_lista['status'] == 2){

  if($pago > 0){
  $trColor = 'style="background-color: #b0f2c2"';
  }else{
  $trColor = 'style="background-color: #ffff"';
  }

  $PDF = '<a class="dropdown-item" onclick="DescargarPDF('.$id.')"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
  $Pago = '<a class="dropdown-item" onclick="Pago('.$GET_year.','.$GET_mes.','.$idEstacion.','.$depu.','.$id.')"><i class="fa-solid fa-money-bill"></i> Pagos</a>';
  $Editar = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';
  $Eliminar = '<a class="dropdown-item grayscale"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';

  }

  $ToComentarios = ToComentarios($id,$con);

  if($ToComentarios > 0){
  $Nuevo = '<div class="position-absolute" style="margin-bottom: -15px; right: 2px;"><span class="badge bg-danger text-white rounded-circle"><span class="fw-bold" style="font-size: 10px;">'.$ToComentarios.' </span></span></div>';
  }else{
  $Nuevo = ''; 
  }
 
  echo '<tr '.$trColor.'>';
  echo '<td class="align-middle text-center">'.$num.'</td>';
  if($estacion == "Gestoria"){
  echo '<td class="align-middle text-center">'.$row_lista['razonsocial'].'</td>'; 
  }

  echo '<td class="align-middle text-center"><b>'.FormatoFecha($row_lista['fecha']).', '.date("g:i a",strtotime($row_lista['hora'])).'</b></td>';
  echo '<td class="align-middle text-center">'.$row_lista['beneficiario'].'</td>'; 
  echo '<td class="align-middle text-center">$ '.number_format($row_lista['monto'],2).'</td>';
  echo '<td class="align-middle text-center">'.$row_lista['no_factura'].'</td>';
  echo '<td class="align-middle text-center">'.$row_lista['concepto'].'</td>';

  if($estacion != "Gestoria"){
  echo '<td class="align-middle text-center">'.$row_lista['telefono'].'</td>';
  }
  echo '<td class="align-middle text-center">'.$row_lista['metodo_pago'].'</td>';
  echo '<td class="align-middle text-center">'.$Firmar.'</td>';
  echo '<td class="align-middle text-center position-relative" onclick="ModalComentario('.$GET_year.','.$GET_mes.','.$idEstacion.','.$depu.','.$id.')">'.$Nuevo.'<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-comentario-tb.png"></td>';

  echo '<td class="align-middle text-center">
  <div class="dropdown">

  <a class="btn btn-sm btn-icon-only text-dropdown-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
  <i class="fas fa-ellipsis-v"></i>
  </a>

  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
  <a class="dropdown-item" onclick="ModalDetalle('.$id.')"><i class="fa-regular fa-eye"></i> Detalle</a>
  '.$PDF.'
  <a class="dropdown-item" onclick="ModalArchivos('.$GET_year.','.$GET_mes.','.$idEstacion.','.$depu.','.$id.')" ><i class="fa-regular fa-file"></i> Agregar archivos</a>
  '.$Pago.'
  '.$Editar.'
  '.$Eliminar.'
  </div>
  </div>
  </td>';

  echo '</tr>';

  $TotalMonto = $TotalMonto + $row_lista['monto'];

  $num++;
  }
  }
  ?>

</tbody>
</table>
</div>

  <hr>

  <div class="text-end mt-3"><?='<h5>Monto total: $'.number_format($TotalMonto,2).'</h5>';?></div>