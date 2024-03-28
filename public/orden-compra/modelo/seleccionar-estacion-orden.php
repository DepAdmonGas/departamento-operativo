<?php
require('../../../app/help.php');


$sql = "UPDATE op_orden_compra_proveedor SET check_p = 0 
WHERE id_ordencompra = '".$_POST['idReporte']."' ";

if(mysqli_query($con, $sql)){

$sqledit = "UPDATE op_orden_compra_proveedor SET check_p = '".$_POST['valor']."'
WHERE id = '".$_POST['idProveedor']."' ";

if(mysqli_query($con, $sqledit)){
echo 1;
}else{
echo 0;
}


}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------
?> 