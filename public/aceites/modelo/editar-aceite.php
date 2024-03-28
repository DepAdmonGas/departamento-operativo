<?php
require('../../../app/help.php');


if ($_POST['type'] == "noaceite") {

	$sql = "UPDATE op_aceites SET id_aceite='".$_POST['noaceite']."' WHERE id='".$_POST['idAceite']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}

}else if ($_POST['type'] == "concepto") {

	$sql = "UPDATE op_aceites SET concepto='".$_POST['concepto']."' WHERE id='".$_POST['idAceite']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}

}else if ($_POST['type'] == "precio") {

	$sql = "UPDATE op_aceites SET precio='".$_POST['precio']."' WHERE id='".$_POST['idAceite']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}

}else if ($_POST['type'] == "piezas") {

	$sql = "UPDATE op_aceites SET piezas='".$_POST['piezas']."' WHERE id='".$_POST['idAceite']."' ";

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