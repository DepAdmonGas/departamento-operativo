<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$idReporte = $_GET['idReporte'];

$sql_pedido = "SELECT * FROM op_pedido_pinturas_complementos WHERE id = '".$idReporte."' ";
$result_pedido = mysqli_query($con, $sql_pedido);
$numero_pedido = mysqli_num_rows($result_pedido);
while($row_pedido = mysqli_fetch_array($result_pedido, MYSQLI_ASSOC)){
$estatus = $row_pedido['status'];
$observaciones = $row_pedido['observaciones'];
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
<h5 class="modal-title">Detalle pedido pintura y complemento</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

</div>
      <div class="modal-body">

    <input type="hidden" value="<?=$idEstacion;?>" id="idEstacion">
    <input type="hidden" value="<?=$idReporte;?>" id="idReporte">

<div class="table-responsive">
      <table class="table table-sm table-bordered table-hover">
      <thead class="tables-bg">
      <tr>
      <td class="text-center align-middle tableStyle font-weight-bold"><b>#</b></td>
      <td class="align-middle tableStyle font-weight-bold"><b>Unidad</b></td>
      <td class="align-middle tableStyle font-weight-bold"><b>Producto</b></td>
      <td class="align-middle tableStyle font-weight-bold text-center"><b>Piezas</b></td>
      <td class="align-middle tableStyle font-weight-bold text-center"><b>¿Para que?</b></td>
      </tr>
    </thead>  
    <tbody>
    <?php
    $sql_lista = "SELECT * FROM op_pedido_pinturas_detalle WHERE id_pedido = '".$idReporte."' ";
    $result_lista = mysqli_query($con, $sql_lista);
    $numero_lista = mysqli_num_rows($result_lista);

    if ($numero_lista > 0) {
    $num = 1;
    while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
    $id = $row_lista['id'];

    $ToPiezas = $ToPiezas + $row_lista['piezas'];
    
    echo '<tr>';
    echo '<td class="align-middle text-center">'.$num.'</td>';
    echo '<td class="align-middle">'.$row_lista['unidad'].'</td>';
    echo '<td class="align-middle">'.$row_lista['producto'].'</td>';
    echo '<td class="align-middle text-center">'.$row_lista['piezas'].'</td>';
    echo '<td class="align-middle text-center">'.$row_lista['detalle'].'</td>';
    echo '</tr>';

    $num++;
    }
    echo '<tr>
    <td colspan="3" class="text-right"><b>Total piezas:</b></td>
    <td class="text-center"><b>'.$ToPiezas.'</b></td>
    </tr>';

    }else{
    echo "<tr><td colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
    }
    ?>
    </tbody>
    </table>
</div>

<b>Observaciones:</b>
<div class="p-2 border mt-2"><?=$observaciones;?></div>

<div class="mt-2"><b>Firmas:</b></div>

<div class="row">

<?php

$sql_firma = "SELECT * FROM op_pedido_pinturas_complementos_firma WHERE id_pedido = '".$idReporte."' ";
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
$Detalle = '<div class="border-bottom text-center p-2" style="font-size: 0.9em;"><small>La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';


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


