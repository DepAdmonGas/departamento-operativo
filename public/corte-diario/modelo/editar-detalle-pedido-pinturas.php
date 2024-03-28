<?php
require('../../../app/help.php');


$sql_edit = "UPDATE op_pedido_pinturas_detalle SET detalle = '".$_POST['detalle']."' WHERE id = '".$_POST['id']."' ";
if(mysqli_query($con, $sql_edit)){
echo 1;
}else{
echo 0;   
}


//------------------
mysqli_close($con);
//------------------