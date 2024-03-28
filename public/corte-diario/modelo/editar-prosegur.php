<?php
require('../../../app/help.php');


if ($_POST['type'] == "recibo") {

	$sql = "UPDATE op_prosegur SET recibo='".$_POST['recibo']."' WHERE id='".$_POST['idProsegur']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}

}else if ($_POST['type'] == "importe") {

	$sql = "UPDATE op_prosegur SET importe='".$_POST['importe']."' WHERE id='".$_POST['idProsegur']."' ";

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