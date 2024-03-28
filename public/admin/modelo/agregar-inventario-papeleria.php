<?php
require('../../../app/help.php');

$idEstacion = $_POST['idEstacion'];
$Producto = $_POST['Producto'];
$Piezas = $_POST['Piezas'];

$sql_lista = "SELECT * FROM op_inventario_papeleria WHERE id_estacion = '".$idEstacion."' AND id_producto = '".$Producto."' LIMIT 1 ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if($numero_lista == 0){

    $sql_insert = "INSERT INTO op_inventario_papeleria (
    id_estacion,
    id_producto,
    piezas,
    status
    )
    VALUES 
    (
    '".$idEstacion."',
    '".$Producto."',
    '".$Piezas."',
    1
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

$sql_edit = "UPDATE op_inventario_papeleria SET piezas = '".$totalPiezas."', status=1 WHERE id_producto = '".$Producto."' ";
if(mysqli_query($con, $sql_edit)){
echo 1;
}else{
echo 0;   
}


}

//------------------
mysqli_close($con);
//------------------