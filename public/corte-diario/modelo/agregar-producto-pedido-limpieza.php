<?php
require('../../../app/help.php');

$idReporte = $_POST['idReporte'];
$Producto = $_POST['Producto'];
$Piezas = $_POST['Piezas'];

$sql_lista = "SELECT * FROM op_pedido_limpieza_detalle WHERE id_pedido = '".$idReporte."' AND id_producto = '".$Producto."' LIMIT 1 ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if($numero_lista == 0){

    $sql_insert = "INSERT INTO op_pedido_limpieza_detalle (
    id_pedido,
    id_producto,
    piezas
    )
    VALUES 
    (
    '".$idReporte."',
    '".$Producto."',
    '".$Piezas."'

    )";
    
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