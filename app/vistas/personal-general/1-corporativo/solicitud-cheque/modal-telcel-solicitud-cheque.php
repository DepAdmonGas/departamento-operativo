<?php
require('../../../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$year = $_GET['year'];
$mes = $_GET['mes'];
 
$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosEstacion($idEstacion);
$estacion = $datosEstacion['razonsocial'];

$sql_lista = "SELECT * FROM op_solicitud_cheque_telcel WHERE id_year = '".$year."' AND id_mes = '".$mes."' AND id_estacion = '".$idEstacion."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>

<div class="modal-header">
<h5 class="modal-title">Facturas telcel, <?=$ClassHerramientasDptoOperativo->nombremes($mes)?> del <?=$year;?></h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
<b><?=$estacion;?></b>

<div class="table-responsive">
<table class="custom-table mt-2" style="font-size: 14px;" width="100%">
<thead>
    
<tr class="navbar-bg align-middle text-center">
<td class="text-center align-middle"><b>Factura telcel</b></td>
<td class="text-center align-middle"><b>Comprobante de pago</b></td>
<td class="text-center" width="24px"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></td>
</tr>
</thead> 

<tbody class="bg-light">

<?php
if ($numero_lista > 0) {
  while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
  $id = $row_lista['id'];

  if($row_lista['factura'] == ""){
  $Factura = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png">';
  }else{
  $Factura = '<a href="../../archivos/'.$row_lista['factura'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png"></a>';
  }

  if($row_lista['c_pago'] == ""){
  $Pago = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png">';
  }else{
  $Pago = '<a href="../../archivos/'.$row_lista['c_pago'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png"></a>';
  }


  echo '<tr>';
  echo '<th class="text-center">'.$Factura.'</th>';
  echo '<td class="text-center">'.$Pago.'</td>';
  echo '<td class="text-center" width="24px"><img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="EditarTelcel('.$idEstacion.','.$year.','.$mes.','.$id.')"></td>';
  echo '</tr>';

  }
  }else{
  echo "<tr><th colspan='4' class='text-center text-secondary'><small>No se encontró información para mostrar </small></tdh</tr>";
  }
  ?>

</tbody>
</table>
</div>

</div>



