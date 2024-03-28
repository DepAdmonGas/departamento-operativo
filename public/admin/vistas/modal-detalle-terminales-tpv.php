<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$idTPV = $_GET['idTPV'];

$sql_lista = "SELECT * FROM op_terminales_tpv WHERE id = '".$idTPV."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$tpv = $row_lista['tpv'];
$noserie = $row_lista['no_serie'];
$modelo = $row_lista['modelo'];
$lote = $row_lista['no_lote'];
$tipoconexion = $row_lista['tipo_conexion'];
$noafiliacion = $row_lista['no_afiliacion'];
$telefono = $row_lista['telefono'];
$estado = $row_lista['estado'];
$rollos = $row_lista['rollos'];
$cargadores = $row_lista['cargadores'];
$pedestales = $row_lista['pedestales'];
}


?>
<div class="modal-header">
<h5 class="modal-title">Terminal punto de venta</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">


<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0 mt-3" style="font-size: .9em;">
<thead class="tables-bg">
<th class="align-middle text-center">TPV´S</th>
<th class="align-middle text-center">No DE SERIE</th>
<th class="align-middle text-center">MODELO/MARCA</th>
</thead>
<tbody>
<tr>
  <td class="align-middle text-center"><?=$tpv;?></td>
  <td class="align-middle text-center"><?=$noserie;?></td>
  <td class="align-middle text-center"><?=$modelo;?></td>
</tr>
</tbody>
</table> 
</div>  


<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0 mt-3" style="font-size: .9em;">


<thead class="tables-bg">
<th class="align-middle text-center">No LOTE</th>
<th class="align-middle text-center">TIPO DE CONEXIÓN</th>
<th class="align-middle text-center">NUMERO DE AFILIACION</th>
</thead>
<tbody>
<tr>
  <td class="align-middle text-center"><?=$lote;?></td>
  <td class="align-middle text-center"><?=$tipoconexion;?></td>
  <td class="align-middle text-center"><?=$noafiliacion;?></td>
</tr>
</tbody>
</table> 
</div>


<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0 mt-3" style="font-size: .9em;">
<thead class="tables-bg">
<th class="align-middle text-center">TELEFONO ATENCION A CLIENTES</th>
</thead>
<tbody>
<tr>
  <td class="align-middle text-center"><?=$telefono;?></td>
</tr>
</tbody>
</table> 
</div>

<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0 mt-3" style="font-size: .9em;">
<thead class="tables-bg">
<th class="align-middle text-center">ACTIVAS</th>
<th class="align-middle text-center">ROLLOS</th>
<th class="align-middle text-center">CARGADORES</th>
<th class="align-middle text-center">PEDESTALES EN BUEN ESTADO</th>
</thead>
<tbody>
<tr>
  <td class="align-middle text-center"><?=$estado;?></td>
  <td class="align-middle text-center"><?=$rollos;?></td>
  <td class="align-middle text-center"><?=$cargadores;?></td>
  <td class="align-middle text-center"><?=$pedestales;?></td>
</tr>
</tbody>
</table> 
</div>


<?php

$sql = "SELECT id_tpv FROM op_terminales_tpv_reporte WHERE serie = '".$noserie."' AND modelo = '".$modelo."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if ($numero > 0) {
echo '<hr>';
echo '<div class="font-weight-bold">TPV anterior</div>';
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$idtpv = $row['id_tpv'];
}

$sql_ant = "SELECT * FROM op_terminales_tpv WHERE id = '".$idtpv."' ";
$result_ant = mysqli_query($con, $sql_ant);
while($row_ant = mysqli_fetch_array($result_ant, MYSQLI_ASSOC)){

?>
<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0 mt-3" style="font-size: .8em;">
<thead class="bg-light">
<th class="align-middle text-center">TPV´S</th>
<th class="align-middle text-center">No DE SERIE</th>
<th class="align-middle text-center">MODELO/MARCA</th>
<th class="align-middle text-center">No LOTE</th>
<th class="align-middle text-center">TIPO DE CONEXIÓN</th>
<th class="align-middle text-center">NUMERO DE AFILIACION</th>
<th class="align-middle text-center"></th>
</thead>
<tbody>
<?php 

echo '<tr>';
echo '<td class="align-middle text-center">'.$row_ant['tpv'].'</td>';
echo '<td class="align-middle text-center"><b>'.$row_ant['no_serie'].'</b></td>';
echo '<td class="align-middle text-center">'.$row_ant['modelo'].'</td>';
echo '<td class="align-middle text-center">'.$row_ant['no_lote'].'</td>';
echo '<td class="align-middle text-center">'.$row_ant['tipo_conexion'].'</td>';
echo '<td class="align-middle text-center">'.$row_ant['no_afiliacion'].'</td>';
echo '<td class="align-middle text-center"><img src="'.RUTA_IMG_ICONOS.'falla-icon.png" onclick="ModalFalla('.$idEstacion.','.$row_ant['id'].')"></td>';
echo '</tr>';

?>
</tbody> 
</table>
</div>
<?php
}
}
?>

</div>
