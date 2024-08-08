<?php
require ('../../../app/help.php');

$sql_lista = "SELECT * FROM op_refacciones WHERE id_estacion = '" . $Session_IDEstacion . "' AND status = 1 ORDER BY id ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '" . $Session_IDEstacion . "' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while ($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)) {
  $estacion = $row_listaestacion['nombre'];
}

?>
<div class="table-responsive">
<table id="tabla_refacciones_a" class="custom-table mt-2" style="font-size: 12.5px;" width="100%">

<thead class="tables-bg">
  <tr>
  <th class="text-center align-middle tableStyle font-weight-bold">#</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Nombre Refacción</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Unidades</th>
   <th class="text-center align-middle tableStyle font-weight-bold">Estado</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Costo por unidad</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Total</th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>ver-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>mas-tb.png"></th>
  </tr>
</thead> 

<tbody class="bg-white"> 
<?php
if ($numero_lista > 0) {
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];


          $total = $row_lista['unidad'] * $row_lista['costo'];


          if ($row_lista['estado_r'] == "") {
            $estatusR = "S/I";
          } else {
            $estatusR = $row_lista['estado_r'];
          }
echo '<tr>';
echo '<th class="align-middle text-center">'.$num.'</th>';
echo '<td class="align-middle text-center"><b>'.$row_lista['nombre'].'</b></td>';
echo '<td class="align-middle text-center">'.$row_lista['unidad'].'</td>';
echo '<td class="align-middle text-center">'.$estatusR.'</td>';
echo '<td class="align-middle text-center">$ '.number_format($row_lista['costo'],2).'</td>';
echo '<td class="align-middle text-center"><b>$ '.number_format($total,2).'</b></td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="ModalDetalle('.$id.')"></td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'mas-tb.png" onclick="ModalMas('.$id.')"></td>';
echo '</tr>';

$num++;
}
}
?>
</tbody>
</table>
</div>

