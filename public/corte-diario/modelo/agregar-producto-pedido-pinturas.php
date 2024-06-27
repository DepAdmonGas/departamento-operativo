<?php
require ('../../../app/help.php');

$idReporte = $_POST['idReporte'];
$Producto = $_POST['Producto'];
$Piezas = $_POST['Piezas'];
$ParaQue = $_POST['ParaQue'];
$OtroProducto = $_POST['OtroProducto'];
$ValProducto = "";
$unidad = "";
function Producto($idProducto, $con)
{
    $unidad = '';
    $producto = '';
    $sql_listaestacion = "SELECT unidad, producto FROM op_pinturas_lista WHERE id = '" . $idProducto . "' ";
    $result_listaestacion = mysqli_query($con, $sql_listaestacion);
    while ($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)) {
        $unidad = $row_listaestacion['unidad'];
        $producto = $row_listaestacion['producto'];
    }
    $result = array('unidad' => $unidad, 'producto' => $producto);

    return $result;
}
$DatoProducto = Producto($Producto, $con);
$ValProducto = $DatoProducto['producto'];
$unidad = $DatoProducto['unidad'];
if ($Producto == "") {
    $ValProducto = $OtroProducto;
    $unidad = "S/I";
}

$sql_lista = "SELECT * FROM op_pedido_pinturas_detalle WHERE id_pedido = '" . $idReporte . "' AND producto = '" . $ValProducto . "' LIMIT 1 ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if ($numero_lista == 0) {

    $sql_insert = "INSERT INTO op_pedido_pinturas_detalle (
    id_pedido,
    unidad,
    producto,
    piezas,
    detalle
    )
    VALUES 
    (
    '" . $idReporte . "',
    '" . $unidad . "',
    '" . $ValProducto . "',
    '" . $Piezas . "',
    '" . $ParaQue . "'
    )";

    if (mysqli_query($con, $sql_insert)) {
        echo 1;
    } else {
        echo 0;
    }

} else {

    while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
        $PiezasInv = $row_lista['piezas'];
    }

    $totalPiezas = $PiezasInv + $Piezas;

    $sql_edit = "UPDATE op_pedido_pinturas_detalle SET piezas = '" . $totalPiezas . "' WHERE producto = '" . $ValProducto . "' ";
    if (mysqli_query($con, $sql_edit)) {
        echo 1;
    } else {
        echo 0;
    }


}



//------------------
mysqli_close($con);
//------------------