<?php
require('../../../app/help.php');


$sql_edit1 = "UPDATE op_solicitud_cheque SET 
    status = '".$_POST['estado']."'
    WHERE id = '".$_POST['idReporte']."' ";
if(mysqli_query($con, $sql_edit1)){
echo 1;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------