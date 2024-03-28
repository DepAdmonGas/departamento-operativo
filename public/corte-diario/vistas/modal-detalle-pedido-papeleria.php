<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];

$sql_pedido = "SELECT * FROM op_pedido_papeleria WHERE id = '".$idReporte."' ";
$result_pedido = mysqli_query($con, $sql_pedido);
$numero_pedido = mysqli_num_rows($result_pedido);
while($row_pedido = mysqli_fetch_array($result_pedido, MYSQLI_ASSOC)){
$estatus = $row_pedido['status'];
}

$sql_productos = "SELECT * FROM tb_papeleria_lista ORDER BY producto ASC";
$result_productos = mysqli_query($con, $sql_productos);
$numero_productos = mysqli_num_rows($result_productos);

function Producto($idProducto, $con){

$sql_listaestacion = "SELECT producto FROM op_papeleria_lista WHERE id = '".$idProducto."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$unidad = $row_listaestacion['unidad'];
$producto = $row_listaestacion['producto'];
}
$result = array('producto' => $producto);

return $result;
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
?>

<div class="modal-header">
<h5 class="modal-title">Detalle pedido papelería</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">

<div class="table-responsive">
      <table class="table table-sm table-striped table-bordered table-hover " style="font-size: 1em;">
       <thead class="tables-bg">
      <tr>
      <th class="text-center align-middle tableStyle font-weight-bold">#</th>
      <th class="align-middle tableStyle font-weight-bold">Nombre producto</th>
      <th class="align-middle tableStyle font-weight-bold text-center">Piezas</th>
      </tr>
    </thead>  
    <tbody>
    <?php
    $sql_lista = "SELECT * FROM op_pedido_papeleria_detalle WHERE id_pedido = '".$idReporte."' ";
    $result_lista = mysqli_query($con, $sql_lista);
    $numero_lista = mysqli_num_rows($result_lista);

    if ($numero_lista > 0) {
    $num = 1;
    while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
    $id = $row_lista['id'];

    $Producto = $row_lista['producto'];
    $ToPiezas = $ToPiezas + $row_lista['piezas'];
    
    echo '<tr>';
    echo '<td class="align-middle text-center">'.$num.'</td>';
    echo '<td class="align-middle">'.$Producto.'</td>';
    echo '<td class="align-middle text-center">'.$row_lista['piezas'].'</td>';
    echo '</tr>';

    $num++;
    }
    echo '<tr>
    <td colspan="2" class="text-end"><b>Total piezas:</b></td>
    <td class="text-center"><b>'.$ToPiezas.'</b></td>
    </tr>';

    }else{
    echo "<tr><td colspan='3' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
    }
    ?>
    </tbody>
    </table>
</div>

<div class="mt-1 mb-1"><b>Firmas:</b></div>

<div class="row">

<?php

$sql_firma = "SELECT * FROM op_pedido_papeleria_firma WHERE id_pedido = '".$idReporte."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){

$explode = explode(' ', $row_firma['fecha']);

if($row_firma['tipo_firma'] == "A"){

$TipoFirma = "NOMBRE Y FIRMA DEL ENCARGADO";
$Detalle = '<div class="p-1 text-center border-bottom ">
<img src="../imgs/firma/'.$row_firma['firma'].'" width="70%">
</div>';


}else if($row_firma['tipo_firma'] == "B"){
$TipoFirma = "NOMBRE Y FIRMA DE VOBO";
$Detalle = '<div class="border-bottom text-center p-2" style="font-size: 0.9em;"><small>El pedido de papeleria se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';


}
$idUsuario = $row_firma['id_usuario'];
$Personal = Personal($idUsuario,$con);
echo '<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">';
echo '<div class="border p-3">';
echo '<div class="mt-2 mb-2 text-center">'.$Personal['nombre'].'</div>';
echo $Detalle;
echo '<h6 class="mt-2 text-secondary text-center">'.$TipoFirma.'</h6>';
echo '</div>';
echo '</div>';

}

?> 
</div>

      </div>
      </div>

