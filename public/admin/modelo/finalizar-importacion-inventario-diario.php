<?php
require('../../../app/help.php');

$sql_edit = "UPDATE op_inventarios_diarios SET 
    fecha = '".$_POST['Fecha']."',
    estatus = 1
    WHERE id='".$_POST['idReporte']."' ";

if(mysqli_query($con, $sql_edit)){
echo 1;
}else{
echo 0;
}



//------------------
mysqli_close($con);
//------------------