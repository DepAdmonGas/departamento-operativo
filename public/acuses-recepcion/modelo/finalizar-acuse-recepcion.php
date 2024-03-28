<?php
require('../../../app/help.php');

if($_POST['dato'] == 1){

$sql = "UPDATE op_acuse_recepcion SET 
empresa = '".$_POST['DataEmpresa']."',
estado = 1
WHERE id='".$_POST['id']."' ";

	if (mysqli_query($con, $sql)) {
	echo 1;
	}else{
	echo 0;
	}

}else if($_POST['dato'] == 2){

$sql = "UPDATE op_acuse_recepcion SET 
personal_entrega = '".$Session_IDUsuarioBD."',
nombre_recibe = '".$_POST['QuienRecibe']."',
fecha = '".$hoy."',
estado = 2
WHERE id='".$_POST['id']."' ";

	if (mysqli_query($con, $sql)) {
	echo 1;
	}else{
	echo 0;
	}

}


//------------------
mysqli_close($con);
//------------------