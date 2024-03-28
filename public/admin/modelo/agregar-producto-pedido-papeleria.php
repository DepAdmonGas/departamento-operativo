<?php
require('../../../app/help.php');

$idEstacion = $_POST['idEstacion'];
$idReporte = $_POST['idReporte'];

$Piezas = $_POST['Piezas'];



if($_POST['Producto'] == ""){
$Producto = $_POST['OtroProducto'];
}else{
$Producto = $_POST['Producto'];    
}

$sql_lista = "SELECT * FROM op_pedido_papeleria_detalle WHERE id_pedido = '".$idReporte."' AND producto = '".$Producto."' LIMIT 1 ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);


if($numero_lista == 0){

    $sql_insert = "INSERT INTO op_pedido_papeleria_detalle (
    id_pedido,
    producto,
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
$id = $row_lista['id'];
}

$totalPiezas = $PiezasInv + $Piezas;

$sql_edit = "UPDATE op_pedido_papeleria_detalle SET piezas = '".$totalPiezas."' WHERE id = '".$id."' ";
if(mysqli_query($con, $sql_edit)){
echo 1;
}else{
echo 0;   
}


}

//------------------
mysqli_close($con);
//------------------