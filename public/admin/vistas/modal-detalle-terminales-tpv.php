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
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<div class="table-responsive">
<table class="custom-table mb-3" style="font-size: .9em;" width="100%">

<thead class="tables-bg">
<th class="align-middle text-center">TPV'S</th>
<th class="align-middle text-center">No DE SERIE</th>
<th class="align-middle text-center">MODELO/MARCA</th>
</thead>
<tbody class="bg-light">
<tr>
  <th class="align-middle text-center no-hover2 fw-normal"><?=$tpv;?></th>
  <td class="align-middle text-center no-hover2"><?=$noserie;?></td>
  <td class="align-middle text-center no-hover2"><?=$modelo;?></td>
</tr>
</tbody>
</table> 
</div>  


<div class="table-responsive">
<table class="custom-table mb-3" style="font-size: .9em;" width="100%">

<thead class="tables-bg">
<th class="align-middle text-center">No LOTE</th>
<th class="align-middle text-center">TIPO DE CONEXIÓN</th>
<th class="align-middle text-center">NUMERO DE AFILIACION</th>
</thead>
<tbody class="bg-light">
<tr>
  <th class="align-middle text-center no-hover2 fw-normal"><?=$lote;?></th>
  <td class="align-middle text-center no-hover2"><?=$tipoconexion;?></td>
  <td class="align-middle text-center no-hover2"><?=$noafiliacion;?></td>
</tr>
</tbody>
</table> 
</div>


<div class="table-responsive">
<table class="custom-table mb-3" style="font-size: .9em;" width="100%">
<thead class="tables-bg">
<th class="align-middle text-center">TELEFONO ATENCION A CLIENTES</th>
</thead>
<tbody class="bg-light">
<tr>
  <th class="align-middle text-center no-hover2 fw-normal"><?=$telefono;?></th>
</tr>
</tbody>
</table> 
</div>

<div class="table-responsive">
<table class="custom-table mb-3" style="font-size: .9em;" width="100%">
<thead class="tables-bg">
<th class="align-middle text-center">ACTIVAS</th>
<th class="align-middle text-center">ROLLOS</th>
<th class="align-middle text-center">CARGADORES</th>
<th class="align-middle text-center">PEDESTALES EN BUEN ESTADO</th>
</thead>
<tbody class="bg-light">
<tr>
  <th class="align-middle text-center no-hover2 fw-normal"><?=$estado;?></th>
  <td class="align-middle text-center no-hover2 "><?=$rollos;?></td>
  <td class="align-middle text-center no-hover2 "><?=$cargadores;?></td>
  <td class="align-middle text-center no-hover2 "><?=$pedestales;?></td>
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
<table class="custom-table" style="font-size: .9em;" width="100%">
<thead class="tables-bg">
<th class="align-middle text-center">TPV'S</th>
<th class="align-middle text-center">No DE SERIE</th>
<th class="align-middle text-center">MODELO/MARCA</th>
<th class="align-middle text-center">No LOTE</th>
<th class="align-middle text-center">TIPO DE CONEXIÓN</th>
<th class="align-middle text-center">NUMERO DE AFILIACION</th>
<th class="align-middle text-center"></th>
</thead>
<tbody class="bg-light">
<?php 

echo '<tr>';
echo '<th class="align-middle text-center no-hover2 fw-normal">'.$row_ant['tpv'].'</th>';
echo '<td class="align-middle text-center no-hover2"><b>'.$row_ant['no_serie'].'</b></td>';
echo '<td class="align-middle text-center no-hover2">'.$row_ant['modelo'].'</td>';
echo '<td class="align-middle text-center no-hover2">'.$row_ant['no_lote'].'</td>';
echo '<td class="align-middle text-center no-hover2">'.$row_ant['tipo_conexion'].'</td>';
echo '<td class="align-middle text-center no-hover2">'.$row_ant['no_afiliacion'].'</td>';
echo '<td class="align-middle text-center no-hover2"><img src="'.RUTA_IMG_ICONOS.'falla-icon.png" onclick="ModalFalla('.$idEstacion.','.$row_ant['id'].')"></td>';
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
