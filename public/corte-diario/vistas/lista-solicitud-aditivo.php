<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];

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


<div style="overflow-y: hidden;">
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
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-comentario-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
  </tr>
</thead> 

<tbody>
<?php
if ($numero_lista > 0) {
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$ordencompra = $row_lista['orden_compra'];

$pago = Pago($id,$con);

if($row_lista['status'] == 0){
$trColor = "table-warning";
$PDF = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Descargar PDF">';
$Editar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="Editar('.$id.')" data-toggle="tooltip" data-placement="top" title="Editar">';
$Eliminar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$idEstacion.','.$id.')" data-toggle="tooltip" data-placement="top" title="Eliminar">';
$Pago = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'pago-tb.png" data-toggle="tooltip" data-placement="top" title="Pago">';
$Firmar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" onclick="Firmar('.$GET_year.','.$GET_mes.','.$id.')" data-toggle="tooltip" data-placement="top" title="Firmar solicitud">';

}else if($row_lista['status'] == 1){
$trColor = "table-warning";
$PDF = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Descargar PDF">';
$Editar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'editar-tb.png" data-toggle="tooltip" data-placement="top" title="Editar">';
$Eliminar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Eliminar">';
$Pago = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'pago-tb.png" data-toggle="tooltip" data-placement="top" title="Pago">';
}else if($row_lista['status'] == 2){

  if($pago > 0){
    $trColor = "table-success";
    }else{
    $trColor = "";
    }

$PDF = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" onclick="DescargarPDF('.$id.')" data-toggle="tooltip" data-placement="top" title="Descargar PDF">';
$Editar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'editar-tb.png" data-toggle="tooltip" data-placement="top" title="Editar">';
$Eliminar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Eliminar">';
$Pago = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'pago-tb.png" onclick="Pago('.$idEstacion.','.$id.')" data-toggle="tooltip" data-placement="top" title="Pago">';
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
echo '<td class="align-middle text-center">'.$Editar.'</td>';
echo '<td class="align-middle text-center">'.$Nuevo.'<img width="20" class="pointer" src="'.RUTA_IMG_ICONOS.'icon-comentario-tb.png" onclick="ModalComentario('.$idEstacion.','.$id.')" data-toggle="tooltip" data-placement="top" title="Comentarios"></td>';
echo '<td class="align-middle text-center">'.$Eliminar.'</td>';
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


