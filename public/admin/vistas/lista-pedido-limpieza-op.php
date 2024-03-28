<?php
require('../../../app/help.php');
$idEstacion = $_GET['idEstacion'];

$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
}


function Personal($idpersonal, $con){

$sql = "SELECT nombre, id_puesto FROM tb_usuarios WHERE id = '".$idpersonal."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$nombre = $row['nombre'];
$idpuesto = $row['id_puesto'];
}

$sql = "SELECT tipo_puesto FROM tb_puestos WHERE id = '".$idpuesto."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$puesto = $row['tipo_puesto'];
}
 
$result = array('nombre' => $nombre, 'puesto' => $puesto);

return $result;
}

$sql_lista = "SELECT * FROM op_pedido_limpieza WHERE id_estacion = '".$idEstacion."' AND status >= 1 ORDER BY id DESC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
?>

<div class="border-0 p-3">

<div class="row">

<div class="col-12">
<h5>Pedido de articulos de limpieza <?=$estacion;?></h5>
</div>

</div>

<hr> 


<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0" style="">
<thead class="tables-bg">
 <tr>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>#</b></td>
  <td class="align-middle tableStyle font-weight-bold"><b>Depto</b></td>
  <td class="align-middle tableStyle font-weight-bold"><b>Personal</b></td>
  <td class="align-middle tableStyle font-weight-bold"><b>Fecha y hora</b></td> 
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>ver-tb.png"></th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-firmar-w.png"></th>

  </tr>
</thead> 
<tbody>
<?php
if ($numero_lista > 0) {

while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$idpersonal = $row_lista['id_personal'];
$status = $row_lista['status'];
$explode = explode(' ', $row_lista['fecha']);

$personal = Personal($idpersonal, $con);

if($status == 0){
$tableColor = "table-danger";
$PDF = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'pdf.png" >';
$Firmar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'icon-firmar.png">';
}else if($status == 1){
$tableColor = "table-warning";
$PDF = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'pdf.png" >';
$Firmar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" onclick="FirmarPedido('.$idEstacion.','.$id.')">';
}else if($status == 2){
$tableColor = "table-success";
$PDF = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" onclick="PedidoPDF('.$id.')">';
$Firmar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'icon-firmar.png">';
}else if($status == 3){
$tableColor = "";
$PDF = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" onclick="PedidoPDF('.$id.')">';
$Firmar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'icon-firmar.png">';
}

echo '<tr class="'.$tableColor.'">';
echo '<td class="align-middle text-center"><b>'.$id.'</b></td>';
echo '<td class="align-middle">'.$personal['puesto'].'</td>';
echo '<td class="align-middle">'.$personal['nombre'].'</td>';
echo '<td class="align-middle">'.FormatoFecha($explode[0]).', '.date('g:i a', strtotime($explode[1])).'</td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="VerPedido('.$idEstacion.','.$id.')"></td>';
echo '<td class="align-middle text-center">'.$PDF.'</td>';
echo '<td class="align-middle text-center">'.$Firmar.'</td>';

echo '</tr>';

}
}else{
echo "<tr><td colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>


</div>