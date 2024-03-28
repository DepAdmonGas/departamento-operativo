<?php
require('../../../app/help.php');

$idReporte = $_POST['idReporte'];

$sql_edit = "UPDATE op_pinturas_complementos_reporte SET 
status = 2
WHERE id = '".$idReporte."' ";

if(mysqli_query($con, $sql_edit)){
echo 1;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------