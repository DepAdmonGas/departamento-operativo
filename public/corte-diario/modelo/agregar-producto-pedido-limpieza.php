<?php
require('../../../app/help.php');

$idReporte = $_POST['idReporte'];
$Piezas = $_POST['Piezas'];
$OtroProducto = $_POST['OtroProducto'];
 
function idProductoAgregado($con){    
$sql_lista2 = "SELECT id FROM op_limpieza_lista ORDER BY id DESC LIMIT 1 ";
$result_lista2 = mysqli_query($con, $sql_lista2);
$numero_lista2 = mysqli_num_rows($result_lista2);

while($row_lista2 = mysqli_fetch_array($result_lista2, MYSQLI_ASSOC)){
$id = $row_lista2['id']; 
}

return $id;
}

function agregarPedidoLimpieza($idReporte, $Producto, $Piezas, $con){
 
$sql_lista = "SELECT * FROM op_pedido_limpieza_detalle WHERE id_pedido = '".$idReporte."' AND id_producto = '".$Producto."' LIMIT 1 ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
    
if($numero_lista == 0){
    
$sql_insert = "INSERT INTO op_pedido_limpieza_detalle (id_pedido, id_producto, piezas)
VALUES ('".$idReporte."', '".$Producto."', '".$Piezas."')";
        
if(mysqli_query($con, $sql_insert)){ 
echo 1;
}else{
echo 0;
}
    
}else{
    
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$PiezasInv = $row_lista['piezas'];
}
    
$totalPiezas = $PiezasInv + $Piezas;
    
$sql_edit = "UPDATE op_pedido_limpieza_detalle SET piezas = '".$totalPiezas."' WHERE id_producto = '".$Producto."' ";
if(mysqli_query($con, $sql_edit)){
echo 1;

}else{
echo 0;   
}
      
}   

//------------------
mysqli_close($con);
//------------------

}


if($OtroProducto == 1){

$ProductoNombre = $_POST['ProductoNombre'];
$Unidad = $_POST['Unidad'];

$sql_insert_producto = "INSERT INTO op_limpieza_lista (unidad, producto, estatus) VALUES ('".$Unidad."','".$ProductoNombre."',1)";

if(mysqli_query($con, $sql_insert_producto)){ 

$idProducto = idProductoAgregado($con);
agregarPedidoLimpieza($idReporte, $idProducto, $Piezas, $con);

}else{
echo 0;
}


}else{
$Producto = $_POST['Producto'];
agregarPedidoLimpieza($idReporte, $Producto, $Piezas, $con);

}
