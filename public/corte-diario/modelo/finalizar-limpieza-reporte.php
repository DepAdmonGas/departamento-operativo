<?php
require('../../../app/help.php');

$idReporte = $_POST['idReporte'];

$sql_edit = "UPDATE op_limpieza_reporte SET 
fecha = '".$_POST['Fecha']."',
hora = '".$_POST['Hora']."',
detalle = '".$_POST['Detalle']."',
status = 1
WHERE id = '".$idReporte."' ";

if(mysqli_query($con, $sql_edit)){
echo 1;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------