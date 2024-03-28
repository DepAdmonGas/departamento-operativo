<?php
require('../../../app/help.php');

$sql_lista = "SELECT * FROM tb_usuario_firma_electronica WHERE id_usuario = '".$Session_IDUsuarioBD."' ORDER BY id DESC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);


?>

<table class="table table-sm table-bordered table-hover mt-3" style="font-size: .8em;">
<thead>
  <tr>
  <td class="text-center align-middle tableStyle font-weight-bold">#</td>
  <td class="align-middle tableStyle font-weight-bold">Firma electrónica</td>
  <td class="align-middle tableStyle font-weight-bold">Fecha de creación</td>
  <td class="align-middle tableStyle font-weight-bold">Fecha de vencimiento</td>
  <td class="align-middle tableStyle font-weight-bold">Estado de firma</td>
  </tr>
</thead> 
<tbody>
<?php
if ($numero_lista > 0) {
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];

$total = $row_lista['unidad'] * $row_lista['costo'];

if($row_lista['estatus'] == 0){
$colorStatus = "bg-light";
$status = "Cancelada";
$textStatus = "text-secondary";
}else{
$colorStatus = "";	
$status = "Activa";
$textStatus = "text-success";
}

echo '<tr class="'.$colorStatus.'">';
echo '<td class="align-middle text-center"><b>'.$num.'</b></td>';
echo '<td class="align-middle"><b>'.$row_lista['nombre'].'</b></td>';
echo '<td class="align-middle">'.FormatoFecha($row_lista['fecha_creacion']).'</td>';
echo '<td class="align-middle">'.FormatoFecha($row_lista['fecha_vencimiento']).'</td>';
echo '<td class="align-middle '.$textStatus.'">'.$status.'</td>';
echo '</tr>';

$num++;
}
}else{
echo "<tr><td colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>