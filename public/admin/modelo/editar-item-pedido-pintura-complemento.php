<?php
require('../../../app/help.php');


$totalPiezas = $_POST['Piezas'];

$sql_edit = "UPDATE op_pedido_pinturas_detalle SET piezas = '".$totalPiezas."' WHERE id = '".$_POST['id']."' ";
if(mysqli_query($con, $sql_edit)){
echo 1;
}else{
echo 0;   
}


//------------------
mysqli_close($con);
//------------------