<?php
require('../../../../../app/help.php');

$GET_year = $_GET['year']; 
$GET_mes = $_GET['mes'];
 
if($Session_IDEstacion == 8){
$busqueda = 'depto = '.$session_idpuesto;
}else if($Session_IDEstacion == 14){
$busqueda = '(id_estacion = '.$Session_IDEstacion.' OR depto = 23)';
}else{
$busqueda = 'id_estacion = '.$Session_IDEstacion; 
} 
  
$sql_lista = "SELECT * FROM op_solicitud_cheque WHERE id_year = '".$GET_year."' AND id_mes = '".$GET_mes."' AND $busqueda ORDER BY fecha ASC ";
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
 
?>
<div class="table-responsive">
<table id="tabla_solicitud_cheque" class="custom-table mt-2" style="font-size: 12.5px;" width="100%">

  <thead class="tables-bg">
 
  <tr>
  <th class="text-center align-middle tableStyle font-weight-bold">#</th>
  <?php
  if($session_nompuesto == "Gestoria"){
  echo '<th class="text-center align-middle tableStyle font-weight-bold">Razón Social</th>';
  }
  ?>
  <th class="text-center align-middle tableStyle font-weight-bold">Fecha</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Beneficiario</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Monto</th>
  <th class="text-center align-middle tableStyle font-weight-bold">No. Factura</th>
  <?php
  if($session_nompuesto != "Gestoria"){
  echo '<th class="text-center align-middle tableStyle font-weight-bold">Email</th>';
  }
  ?>  
  <th class="text-center align-middle tableStyle font-weight-bold">Concepto</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Solicitante</th>
  <?php
  if($session_nompuesto != "Gestoria"){
  echo '<th class="text-center align-middle tableStyle font-weight-bold">Telefono</th>';
  }
  ?>  
  <th class="text-center align-middle tableStyle font-weight-bold">Metodo de pago</th>

  <?php if($Session_IDUsuarioBD == 30){ ?>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-firmar-w.png"></th>
  <?php } ?>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-comentario-tb.png"></th>
  <th class="align-middle text-center" width="20"><i class="fas fa-ellipsis-v"></i></th>
  </tr>
</thead> 

<tbody> 
<?php  
$TotalMonto = 0;
if ($numero_lista > 0) {
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$pago = Pago($id,$con);
 
if($row_lista['status'] == 0){
$trColor = 'style="background-color: #fcfcda"';
$PDF = '<a class="dropdown-item grayscale"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
$Editar = '<a class="dropdown-item" onclick="Editar('.$id.')"><i class="fa-solid fa-pencil"></i> Editar</a>';
$Eliminar = '<a class="dropdown-item" onclick="Eliminar('.$GET_year.','.$GET_mes.','.$id.')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
$Pago = '<a class="dropdown-item grayscale"><i class="fa-solid fa-money-bill"></i> Pagos</a>';
$Firmar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" onclick="Firmar('.$GET_year.','.$GET_mes.','.$id.')" data-toggle="tooltip" data-placement="top" title="Firmar solicitud">';

}else if($row_lista['status'] == 1){
$trColor = 'style="background-color: #fcfcda"';
$PDF = '<a class="dropdown-item" onclick="DescargarPDF('.$id.')"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
$Editar = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';
$Eliminar = '<a class="dropdown-item grayscale"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
$Pago = '<a class="dropdown-item" onclick="Pago('.$GET_year.','.$GET_mes.','.$id.')"><i class="fa-solid fa-money-bill"></i> Pagos</a>';

$Firmar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" data-toggle="tooltip" data-placement="top" title="Firmar solicitud">';

}else if($row_lista['status'] == 2){

if($pago > 0){
$trColor = 'style="background-color: #b0f2c2"';
}else{
$trColor = 'style="background-color: #ffff"';
}

$PDF = '<a class="dropdown-item" onclick="DescargarPDF('.$id.')"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
$Editar = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';
$Eliminar = '<a class="dropdown-item grayscale"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
$Pago = '<a class="dropdown-item" onclick="Pago('.$GET_year.','.$GET_mes.','.$id.')"><i class="fa-solid fa-money-bill"></i> Pagos</a>';
$Firmar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" data-toggle="tooltip" data-placement="top" title="Firmar solicitud">';

}

$ToComentarios = ToComentarios($id,$con);

if($ToComentarios > 0){
$Nuevo = '<div class="position-absolute" style="margin-bottom: -15px; right: 2px;"><span class="badge bg-danger text-white rounded-circle"><span class="fw-bold" style="font-size: 10px;">'.$ToComentarios.' </span></span></div>';
}else{

$Nuevo = ''; 
}

echo '<tr '.$trColor.'>';
echo '<th class="align-middle text-center">'.$num.'</th>';
if($session_nompuesto == "Gestoria"){
echo '<td class="align-middle text-center">'.$row_lista['razonsocial'].'</td>'; 
}



echo '<td class="align-middle text-center"><b>'.$ClassHerramientasDptoOperativo->FormatoFecha($row_lista['fecha']).'</b></td>';
echo '<td class="align-middle text-center">'.$row_lista['beneficiario'].'</td>';
echo '<td class="align-middle text-center">$ '.number_format($row_lista['monto'],2).'</td>';
echo '<td class="align-middle text-center">'.$row_lista['no_factura'].'</td>';
if($session_nompuesto != "Gestoria"){
echo '<td class="align-middle text-center">'.$row_lista['email'].'</td>';
}
echo '<td class="align-middle text-center">'.$row_lista['concepto'].'</td>';
echo '<td class="align-middle text-center">'.$row_lista['solicitante'].'</td>';
if($session_nompuesto != "Gestoria"){
echo '<td class="align-middle text-center">'.$row_lista['telefono'].'</td>';
}
echo '<td class="align-middle text-center">'.$row_lista['metodo_pago'].'</td>';
if($Session_IDUsuarioBD == 30){
echo '<td class="align-middle text-center">'.$Firmar.'</td>';
}

echo '<td class="align-middle text-center position-relative" onclick="ModalComentario('.$GET_year.','.$GET_mes.','.$id.')">'.$Nuevo.'<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-comentario-tb.png"></td>';

echo '<td class="align-middle text-center">
<div class="dropdown">

<a class="btn btn-sm btn-icon-only text-dropdown-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
<i class="fas fa-ellipsis-v"></i>
</a>

<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
<a class="dropdown-item" onclick="ModalDetalle('.$id.')"><i class="fa-regular fa-eye"></i> Detalle</a>
'.$PDF.'
<a class="dropdown-item" onclick="ModalArchivos('.$GET_year.','.$GET_mes.','.$id.')"><i class="fa-regular fa-file"></i> Agregar archivos</a>
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
}else{
//echo "<tr><td colspan='18' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>

<hr>

<div class="text-end mt-3"><?='<h5>Monto total: $'.number_format($TotalMonto,2).'</h5>';?></div>


