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
<script type="text/javascript">
$(document).ready(function($){
$('[data-toggle="tooltip"]').tooltip();
});
</script>



<div class="table-responsive">
<table id="tabla_solicitud_cheque" class="custom-table mt-2" style="font-size: 12.5px;" width="100%">

  <thead class="navbar-bg">

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
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>ver-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>archivo-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pago-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
  <?php if($Session_IDUsuarioBD == 30){ ?>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-firmar-w.png"></th>
  <?php } ?>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-comentario-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
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
$PDF = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Descargar PDF">';
$Editar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="Editar('.$id.')" data-toggle="tooltip" data-placement="top" title="Editar">';
$Eliminar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$GET_year.','.$GET_mes.','.$id.')" data-toggle="tooltip" data-placement="top" title="Eliminar">';
$Pago = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'pago-tb.png" data-toggle="tooltip" data-placement="top" title="Pago">';
$Firmar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" onclick="Firmar('.$GET_year.','.$GET_mes.','.$id.')" data-toggle="tooltip" data-placement="top" title="Firmar solicitud">';

}else if($row_lista['status'] == 1){
$trColor = 'style="background-color: #fcfcda"';
$PDF = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" onclick="DescargarPDF('.$id.')" data-toggle="tooltip" data-placement="top" title="Descargar PDF">';
$Editar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'editar-tb.png" data-toggle="tooltip" data-placement="top" title="Editar">';
$Eliminar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Eliminar">';
$Pago = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'pago-tb.png" onclick="Pago('.$GET_year.','.$GET_mes.','.$id.')" data-toggle="tooltip" data-placement="top" title="Pago">';
$Firmar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" data-toggle="tooltip" data-placement="top" title="Firmar solicitud">';

}else if($row_lista['status'] == 2){

if($pago > 0){
$trColor = 'style="background-color: #b0f2c2"';
}else{
$trColor = 'style="background-color: #fff"';
}

$PDF = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" onclick="DescargarPDF('.$id.')" data-toggle="tooltip" data-placement="top" title="Descargar PDF">';
$Editar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'editar-tb.png" data-toggle="tooltip" data-placement="top" title="Editar">';
$Eliminar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Eliminar">';
$Pago = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'pago-tb.png" onclick="Pago('.$GET_year.','.$GET_mes.','.$id.')" data-toggle="tooltip" data-placement="top" title="Pago">';
$Firmar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" data-toggle="tooltip" data-placement="top" title="Firmar solicitud">';

}else if($row_lista['status'] == 3){
$trColor = 'style="background-color: #cfe2ff"';
$PDF = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Descargar PDF">';
$Pago = '<img class="grayscale" class="grayscale" src="'.RUTA_IMG_ICONOS.'pago-tb.png" data-toggle="tooltip" data-placement="top" title="Agregar pago">';
$Editar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="Editar('.$GET_year.','.$GET_mes.','.$idEstacion.','.$id.')" data-toggle="tooltip" data-placement="top" title="Editar">';
$Firmar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" onclick="Firmar('.$GET_year.','.$GET_mes.','.$idEstacion.','.$id.')" data-toggle="tooltip" data-placement="top" title="Firmar solicitud">';
$Eliminar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$GET_year.','.$GET_mes.','.$idEstacion.','.$depu.','.$id.')" data-toggle="tooltip" data-placement="top" title="Eliminar">';
}

$ToComentarios = ToComentarios($id,$con);

if($ToComentarios > 0){
$Nuevo = '<div class="float-end" style="margin-bottom: -5px"><span class="badge bg-danger text-white rounded-circle"><span class="fw-bold" style="font-size: 11px;">'.$ToComentarios.'</span></span></div>';
}else{

$Nuevo = ''; 
}


echo '<tr '.$trColor.'>';
echo '<th class="align-middle text-center">'.$num.'</th>';
if($session_nompuesto == "Gestoria"){
echo '<td class="align-middle text-center">'.$row_lista['razonsocial'].'</td>'; 
}
echo '<td class="align-middle text-center"><b>'.FormatoFecha($row_lista['fecha']).'</b></td>';
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
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="ModalDetalle('.$id.')" data-toggle="tooltip" data-placement="top" title="Detalle"></td>';
echo '<td class="align-middle text-center">'.$PDF.'</td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'archivo-tb.png" onclick="ModalArchivos('.$GET_year.','.$GET_mes.','.$id.')" data-toggle="tooltip" data-placement="top" title="Archivos"></td>';
echo '<td class="align-middle text-center">'.$Pago.'</td>';
echo '<td class="align-middle text-center">'.$Editar.'</td>';

if($Session_IDUsuarioBD == 30){
echo '<td class="align-middle text-center">'.$Firmar.'</td>';
}

echo '<td class="align-middle text-center">'.$Nuevo.'<img width="20" class="pointer" src="'.RUTA_IMG_ICONOS.'icon-comentario-tb.png" onclick="ModalComentario('.$GET_year.','.$GET_mes.','.$id.')" data-toggle="tooltip" data-placement="top" title="Comentarios"></td>';
echo '<td class="align-middle text-center">'.$Eliminar.'</td>';
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


