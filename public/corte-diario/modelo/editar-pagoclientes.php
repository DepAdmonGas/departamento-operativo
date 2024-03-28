<?php
require('../../../app/help.php');


if ($_POST['type'] == "importe") {

	$sql = "UPDATE op_pago_clientes SET importe='".$_POST['importe']."' WHERE id='".$_POST['idPagoCliente']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}

}else if ($_POST['type'] == "nota") {

	$sql = "UPDATE op_pago_clientes SET nota='".$_POST['nota']."' WHERE id='".$_POST['idPagoCliente']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}

}
//------------------
mysqli_close($con);
//------------------
?>