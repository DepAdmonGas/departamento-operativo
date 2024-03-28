<?php
require('../../../app/help.php');

$sql_edit = "UPDATE op_inventario_pinturas SET status = 0 WHERE id = '".$_POST['id']."' ";
if(mysqli_query($con, $sql_edit)){
echo 1;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------