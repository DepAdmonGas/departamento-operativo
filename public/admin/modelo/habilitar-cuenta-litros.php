<?php
require('../../../app/help.php');


$sql = "UPDATE op_cuenta_litros SET estatus = 0
WHERE id_cuenta_litros = '".$_POST['idCuentaLitros']."' ";
if(mysqli_query($con, $sql)){
echo 1;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------
?> 