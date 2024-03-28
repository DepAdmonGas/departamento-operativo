<?php
require('../../../app/help.php');



$sql = "SELECT * FROM tb_analisis_compra WHERE fecha = '".$_POST['fecha']."' AND factura = '".$_POST['factura']."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if ($numero == 0) {

if($_POST['estado'] == 1){

 $sql_insert = "INSERT INTO tb_analisis_compra (
    fecha,
    factura,
    notac,
    status
    )
    VALUES 
    (    
    '".$_POST['fecha']."',    
    '".$_POST['factura']."',
    '".$_POST['valor']."',
    ''
    )";
    
mysqli_query($con, $sql_insert);

}else if($_POST['estado'] == 2){

 $sql_insert = "INSERT INTO tb_analisis_compra (
    fecha,
    factura,
    notac,
    status
    )
    VALUES 
    (    
    '".$_POST['fecha']."',    
    '".$_POST['factura']."',
    '',
    '".$_POST['valor']."'
    )";
    
mysqli_query($con, $sql_insert);

}

}else{

if($_POST['estado'] == 1){

$sql_edit = "UPDATE tb_analisis_compra SET 
    notac = '".$_POST['valor']."'
    WHERE fecha = '".$_POST['fecha']."' AND factura = '".$_POST['factura']."' ";
mysqli_query($con, $sql_edit);

}else if($_POST['estado'] == 2){

$sql_edit = "UPDATE tb_analisis_compra SET 
    status = '".$_POST['valor']."'
    WHERE fecha = '".$_POST['fecha']."' AND factura = '".$_POST['factura']."' ";
mysqli_query($con, $sql_edit);

}

}



//------------------
mysqli_close($con);
//------------------