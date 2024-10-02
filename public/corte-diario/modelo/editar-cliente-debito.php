<?php
require('../../../app/help.php');


$sql = "UPDATE op_cliente SET 
cuenta = '".$_POST['Cuenta']."',
cliente = '".$_POST['Cliente']."',
tipo = '".$_POST['Tipo']."'
WHERE id='".$_POST['idCliente']."' ";

	if (mysqli_query($con, $sql)) {
	echo 1;
	}else{
	echo 0;
	}

//------------------
mysqli_close($con);
//------------------
?>