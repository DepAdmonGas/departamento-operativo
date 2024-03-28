<?php
require('../../../app/help.php');
$idReporte = $_GET['idReporte'];
$idStatus = $_GET['idStatus'];

if($idStatus == 0){
$ocultarTb = "";  
}else{
$ocultarTb = "d-none";
}

function Estacion($idEstacion, $con){
$sql_listaestacion = "SELECT nombre, direccioncompleta FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$nombre = $row_listaestacion['nombre'];
$direccioncompleta = $row_listaestacion['direccioncompleta'];
}

return $arrayName = array('nombre' => $nombre, 'direccioncompleta' => $direccioncompleta);
}

?>

   
<div class="table-responsive">
        <table class="table table-sm table-bordered mb-0" style="font-size: .9em;">
          <tr class="tables-bg">
            <th colspan="9" class="text-center align-middle">DATOS DE REFACTURACIÓN Y PRORROTEO</th>
          </tr>
          <tr class="bg-light">
            <td><b>Prorroteo (Estación)</b></td>
            <td><b>Descripción</b></td>
            <td><b>Cantidad</b></td>
            <td><b>Importe</b></td>
            <td><b>Porcentaje</b></td>
            <td><b>Estacion</b></td>
            <td><b>Almacén</b></td>
            <td><b>Total</b></td>
            <td width="16px" class="<?=$ocultarTb?>"><img src="<?=RUTA_IMG_ICONOS?>eliminar.png" width="20px"></td>
          </tr>
          <tbody>

<?php 

$totalGeneral = 0;


    $sql_DatosProveedor = "SELECT descuento, envio_cp FROM op_orden_compra_proveedor WHERE id_ordencompra = '".$idReporte."' AND check_p = 1";
    $result_DatosProveedor = mysqli_query($con, $sql_DatosProveedor);
    $numero_DatosProveedor = mysqli_num_rows($result_DatosProveedor);

    if ($numero_DatosProveedor > 0) {
    while($row_DatosProveedor = mysqli_fetch_array($result_DatosProveedor, MYSQLI_ASSOC)){ 
    $descuento = $row_DatosProveedor['descuento'];
    $envio_cp = $row_DatosProveedor['envio_cp'];
    }

    }else{
    $descuento = 0;
    $envio_cp = 0;
    }


$sql = "SELECT * FROM op_orden_compra_refacturacion WHERE id_ordencompra = '".$idReporte."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if ($numero > 0) {
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

$id = $row['id'];
$Estacion = Estacion($row['id_estacion'], $con);
$descripcion = $row['descripcion'];

$cantidad = $row['cantidad'];
$importe = $row['importe'];
$porcentaje = $row['porcentaje'];

$cantidadES = $row['cantidadES'];
$cantidadAL = $row['cantidadAl'];

$total = $cantidad * $importe;

$subTotalGeneral = $subTotalGeneral + $total;
$totalIVA = ($subTotalGeneral - $descuento + $envio_cp) * 0.16;
$totalGrnlIva = $subTotalGeneral + $totalIVA;


echo '<tr>
<td class="align-middle">'.$Estacion['nombre'].'</td>
<td class="align-middle">'.$descripcion.'</td>
<td class="align-middle">'.$cantidad.'</td>
<td class="align-middle">'.number_format($importe,2).'</td>
<td class="align-middle">'.number_format($porcentaje).' %</td>
<td class="align-middle">'.$cantidadES.'</td>
<td class="align-middle">'.$cantidadAL.'</td>
<td class="align-middle">'.number_format($total,2).'</td>
<td class="align-middle text-center '.$ocultarTb .'"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" width="20px" onclick="EliminarRefacturacion('.$id.','.$idReporte.')"></td>
</tr>';
}
 

    echo '<tr class="bg-light">
    <td colspan="3" class="align-middle text-end"></td>
    <th colspan="2" class="align-middle text-center">SUMA</th>
    <th colspan="5" class="align-middle text-start">$ '.number_format($subTotalGeneral,2).'</th>
    </tr>';
 
    $subtotal3 = $subTotalGeneral - $descuento + $envio_cp;
    $totalFinal = $totalIVA + $subtotal3;

    echo '<tr class="bg-light">
    <td colspan="3" class="align-middle text-end"></td>
    <th colspan="2" class="align-middle text-center">DESCUENTO</th>
    <th colspan="5" class="align-middle text-start">$ '.number_format($descuento,2).'</th>
    </tr>';

    echo '<tr class="bg-light">
    <td colspan="3" class="align-middle text-end"></td>
    <th colspan="2" class="align-middle text-center">ENVIO</th>
    <th colspan="5" class="align-middle text-start">$ '.number_format($envio_cp,2).'</th>
    </tr>';


    echo '<tr class="bg-light">
    <td colspan="3" class="align-middle text-end"></td>
    <th colspan="2" class="align-middle text-center">SUBTOTAL</th>
    <th colspan="5" class="align-middle text-start">$ '.number_format($subtotal3,2).'</th>
    </tr>';

    echo '<tr class="bg-light">
    <td colspan="3" class="align-middle text-end"></td>
    <th colspan="2" class="align-middle text-center">IVA</th> 
    <th colspan="5" class="align-middle text-start">$ '.number_format($totalIVA,2).'</th>
    </tr>';

    echo '<tr class="bg-light">
    <td colspan="3" class="align-middle text-end"></td>
    <th colspan="2" class="align-middle text-center">TOTAL</th>
    <th colspan="5" class="align-middle text-start">$ '.number_format($totalFinal,2).'</th>
    </tr>';


}else{
echo "<tr><td colspan='9' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}

          	?>
            
          </tbody>
       </table>
      </div> 