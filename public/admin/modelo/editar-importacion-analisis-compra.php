<?php
require('../../../app/help.php');

if($_POST['opcion'] == 1){

$sql_edit1 = "UPDATE op_embarques SET 
    bruto = '".$_POST['valor']."'
    WHERE id='".$_POST['id']."' ";
mysqli_query($con, $sql_edit1);

echo 1;

}else if($_POST['opcion'] == 2){

$sql_edit1 = "UPDATE op_embarques SET 
    neto = '".$_POST['valor']."'
    WHERE id='".$_POST['id']."' ";
mysqli_query($con, $sql_edit1);

echo 1;

}

//------------------
mysqli_close($con);
//------------------