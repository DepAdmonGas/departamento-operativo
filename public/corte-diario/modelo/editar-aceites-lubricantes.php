<?php
require('../../../app/help.php');


if ($_POST['type'] == "cantidad") {

	$sql = "UPDATE op_aceites_lubricantes SET cantidad='".$_POST['cantidad']."' WHERE id='".$_POST['idAceite']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}

}else if ($_POST['type'] == "precio") {

	$sql = "UPDATE op_aceites_lubricantes SET precio_unitario='".$_POST['precio']."' WHERE id='".$_POST['idAceite']."' ";

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