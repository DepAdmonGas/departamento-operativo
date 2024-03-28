<?php
require('../../../app/help.php');


if ($_POST['Despacho'] == 1) {

	$sql = "UPDATE op_despacho_factura SET litros_producto_uno='".$_POST['input']."' WHERE id_dia='".$_POST['idDias']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}

}else if ($_POST['Despacho'] == 2) {

	$sql = "UPDATE op_despacho_factura SET litros_producto_dos='".$_POST['input']."' WHERE id_dia='".$_POST['idDias']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}

}else if ($_POST['Despacho'] == 3) {

	$sql = "UPDATE op_despacho_factura SET litros_producto_tres='".$_POST['input']."' WHERE id_dia='".$_POST['idDias']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}

}else if ($_POST['Despacho'] == 4) {

	$sql = "UPDATE op_despacho_factura SET pesos_producto_uno='".$_POST['input']."' WHERE id_dia='".$_POST['idDias']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}

}else if ($_POST['Despacho'] == 5) {

	$sql = "UPDATE op_despacho_factura SET pesos_producto_dos='".$_POST['input']."' WHERE id_dia='".$_POST['idDias']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}

}else if ($_POST['Despacho'] == 6) {

	$sql = "UPDATE op_despacho_factura SET pesos_producto_tres='".$_POST['input']."' WHERE id_dia='".$_POST['idDias']."' ";

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