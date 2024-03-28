<?php
require('../../../app/help.php');

if($_POST['num'] == 1){
$edit = "UPDATE op_orden_compra SET cargo = '".$_POST['valor']."'";

}else if($_POST['num'] == 2){
$edit = "UPDATE op_orden_compra SET fecha = '".$_POST['valor']."'";

}else if($_POST['num'] == 3){
$edit = "UPDATE op_orden_compra SET porcentaje_total = '".$_POST['valor']."'";

}


$sql = "$edit
WHERE id = '".$_POST['id']."' ";

if(mysqli_query($con, $sql)){
echo 1;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------
?> 