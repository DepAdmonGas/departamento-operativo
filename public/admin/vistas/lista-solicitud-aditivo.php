<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$sql_listaestacion = "SELECT razonsocial FROM tb_estaciones WHERE id = '".$idEstacion."'";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['razonsocial'];
} 

$sql_lista = "SELECT * FROM op_solicitud_aditivo WHERE id_estacion = '".$idEstacion."' ORDER BY orden_compra DESC ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

function ToComentarios($IdReporte,$con){
$sql_lista = "SELECT id FROM op_solicitud_aditivo_comentario WHERE id_reporte = '".$IdReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);
}

function Pago($id,$con){
$sql_lista = "SELECT id FROM op_solicitud_aditivo_documento WHERE id_reporte = '".$id."' AND nombre = 'PAGO' ";
$result_lista = mysqli_query($con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);  
}

function Personal($idusuario,$con){
$sql = "SELECT nombre FROM tb_usuarios WHERE id = '".$idusuario."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$nombre = $row['nombre'];
}
return $nombre;
}
 
?>
<script type="text/javascript">
$(document).ready(function($){
$('[data-toggle="tooltip"]').tooltip();
});
</script>


<div class="border-0 p-3">

<div class="row">
<div class="col-12"><h5><?=$estacion;?></h5><hr></div>

</div>



<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0" style="font-size: .9em;">
<thead class="tables-bg">
  <tr>
  <th class="text-center align-middle tableStyle font-weight-bold">No. Orden</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Fecha</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Solicitado por</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Para</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Fecha entrega</th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>ver-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pago-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-firmar-w.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-comentario-tb.png"></th>
</tr>
</thead> 
<tbody>
<?php
$Y = date("Y");
$M = date("m");

if ($numero_lista > 0) {
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$ordencompra = $row_lista['orden_compra'];

$explode = explode("-", $row_lista['fecha']);

$pago = Pago($id,$con);

$fechaMas = date("Y-m-d",strtotime($row_lista['fecha']."+ 15 days"));

$fecha_actual = strtotime($fecha_del_dia);
$fecha_entrada = strtotime($fechaMas);

if($fecha_actual >= $fecha_entrada && $row_lista['status'] == 1){

$trColor = "table-success";
$PDF = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" onclick="DescargarPDF('.$id.')" data-toggle="tooltip" data-placement="top" title="Descargar PDF">';
$Pago = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'pago-tb.png" onclick="Pago('.$idEstacion.','.$id.')" data-toggle="tooltip" data-placement="top" title="Pago">';
$Firmar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" onclick="Firmar('.$id.')" data-toggle="tooltip" data-placement="top" title="Firmar solicitud">';

}else{

if($row_lista['status'] == 0){
$trColor = "table-warning";
$PDF = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Descargar PDF">';
$Pago = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'pago-tb.png" data-toggle="tooltip" data-placement="top" title="Pago">';
$Firmar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" onclick="Firmar('.$id.')" data-toggle="tooltip" data-placement="top" title="Firmar solicitud">';

}else if($row_lista['status'] == 1){
$trColor = "table-primary";
$PDF = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" onclick="DescargarPDF('.$id.')" data-toggle="tooltip" data-placement="top" title="Descargar PDF">';
$Pago = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'pago-tb.png" onclick="Pago('.$idEstacion.','.$id.')" data-toggle="tooltip" data-placement="top" title="Pago">';
$Firmar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" onclick="Firmar('.$id.')" data-toggle="tooltip" data-placement="top" title="Firmar solicitud">';

}else if($row_lista['status'] == 2){
$trColor = "table-success";
$PDF = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" onclick="DescargarPDF('.$id.')" data-toggle="tooltip" data-placement="top" title="Descargar PDF">';
$Pago = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'pago-tb.png" onclick="Pago('.$idEstacion.','.$id.')" data-toggle="tooltip" data-placement="top" title="Pago">';
$Firmar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" onclick="Firmar('.$id.')" data-toggle="tooltip" data-placement="top" title="Firmar solicitud">';

}

}

  $ToComentarios = ToComentarios($id,$con);

  if($ToComentarios > 0){
  $Nuevo = '<div class="float-end" style="margin-bottom: -5px"><span class="badge bg-danger text-white rounded-circle"><small>'.$ToComentarios.'</small></span></div>';
  }else{
   $Nuevo = ''; 
  }


echo '<tr class="'.$trColor.'">';
echo '<td class="align-middle text-center">'.$ordencompra.'</td>';
echo '<td class="align-middle text-center"><b>'.FormatoFecha($row_lista['fecha']).'</b></td>';
echo '<td class="align-middle text-center">'.Personal($row_lista['id_personal'],$con).'</td>';
echo '<td class="align-middle text-center">'.$row_lista['para'].'</td>';
echo '<td class="align-middle text-center">'.FormatoFecha($row_lista['fecha_entrega']).'</td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="ModalDetalle('.$id.')" data-toggle="tooltip" data-placement="top" title="Detalle"></td>';
echo '<td class="align-middle text-center">'.$PDF.'</td>';
echo '<td class="align-middle text-center">'.$Pago.'</td>';
echo '<td class="align-middle text-center">'.$Firmar.'</td>';
echo '<td class="align-middle text-center">'.$Nuevo.'<img class="pointer" width="20" src="'.RUTA_IMG_ICONOS.'icon-comentario-tb.png" onclick="ModalComentario('.$idEstacion.','.$id.')" data-toggle="tooltip" data-placement="top" title="Comentarios"></td>';
echo '</tr>';

$num++;
}
}else{
echo "<tr><td colspan='18' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>

</div>

