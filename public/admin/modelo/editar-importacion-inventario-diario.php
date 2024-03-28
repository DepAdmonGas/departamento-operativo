<?php
require('../../../app/help.php');

if($_POST['tipo'] == 1){

$sql_edit1 = "UPDATE op_inventarios_diarios_detalle SET 
    destino = '".$_POST['valor']."'
    WHERE id='".$_POST['id']."' ";
mysqli_query($con, $sql_edit1);

echo 1;

}else if($_POST['tipo'] == 2){

$sql_edit1 = "UPDATE op_inventarios_diarios_detalle SET 
    oct87 = '".$_POST['valor']."'
    WHERE id='".$_POST['id']."' ";
mysqli_query($con, $sql_edit1);

echo 1;

}else if($_POST['tipo'] == 3){

$sql_edit1 = "UPDATE op_inventarios_diarios_detalle SET 
    oct91 = '".$_POST['valor']."'
    WHERE id='".$_POST['id']."' ";
mysqli_query($con, $sql_edit1);

echo 1;

}else if($_POST['tipo'] == 4){

$sql_edit1 = "UPDATE op_inventarios_diarios_detalle SET 
    diesel = '".$_POST['valor']."'
    WHERE id='".$_POST['id']."' ";
mysqli_query($con, $sql_edit1);

echo 1;

}

//------------------
mysqli_close($con);
//------------------