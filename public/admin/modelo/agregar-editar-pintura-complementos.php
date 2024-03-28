<?php
require('../../../app/help.php');

if($_POST['idProducto'] == 0){

    $sql_insert = "INSERT INTO op_pinturas_lista (
    unidad,
    producto,
    estatus
    )
    VALUES 
    (    
    '".$_POST['Unidad']."',
    '".$_POST['Producto']."',
    1
    )";
    
    if(mysqli_query($con, $sql_insert)){

	echo 1;
    }else{
    echo 0;
    }

}else{

$sql_edit = "UPDATE op_pinturas_lista SET 
    unidad = '".$_POST['Unidad']."',
    producto = '".$_POST['Producto']."'
    WHERE id='".$_POST['idProducto']."' ";

if(mysqli_query($con, $sql_edit)){

    echo 1;
    }else{
    echo 0;
    }
}



//------------------
mysqli_close($con);
//------------------