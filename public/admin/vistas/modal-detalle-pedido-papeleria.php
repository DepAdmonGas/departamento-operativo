<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$idReporte = $_GET['idReporte'];

$sql_pedido = "SELECT * FROM op_pedido_papeleria WHERE id = '".$idReporte."' ";
$result_pedido = mysqli_query($con, $sql_pedido);
$numero_pedido = mysqli_num_rows($result_pedido);
while($row_pedido = mysqli_fetch_array($result_pedido, MYSQLI_ASSOC)){
$estatus = $row_pedido['status'];
}

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

<div class="modal-header">
<h5 class="modal-title">Detalle pedido papeleria</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

    <input type="hidden" value="<?=$idEstacion;?>" id="idEstacion">
    <input type="hidden" value="<?=$idReporte;?>" id="idReporte">

<div class="table-responsive">
      <table class="table table-sm table-striped table-bordered table-hover mb-0" style="font-size: .9em;">
       <thead class="tables-bg">
      <tr>
      <th class="text-center align-middle tableStyle font-weight-bold">#</th>
      <th class="align-middle tableStyle font-weight-bold">Producto</th>
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
    echo '<td class="align-middle"><b>'.$Producto.'</b></td>';
    echo '<td class="align-middle text-center">'.$row_lista['piezas'].'</td>';
    echo '</tr>';

    $num++;
    }
    echo '<tr>
    <td colspan="2" class="text-right">Total piezas:</td>
    <td class="text-center"><b>'.$ToPiezas.'</b></td>
    </tr>';

    }else{
    echo "<tr><td colspan='3' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
    }
    ?>
    </tbody>
    </table>
</div>


<div class="mt-2"><b>Firmas:</b></div>

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
$Detalle = '<div class="border-bottom text-center p-2" style="font-size: 0.9em;"><small>El pedido de papeleria se firmó por un medio electrónico</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';

}

echo '<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">';
echo '<div class="border p-3">';
echo '<div class="mt-2 mb-2 text-center">'.Personal($row_firma['id_usuario'],$con).'</div>';
echo $Detalle;
echo '<h6 class="mt-2 text-secondary text-center">'.$TipoFirma.'</h6>';
echo '</div>';
echo '</div>';

}

?> 
</div>


      </div>

 