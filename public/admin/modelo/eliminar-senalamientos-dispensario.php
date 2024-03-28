<?php
require('../../../app/help.php');

if($_POST['dato'] == 1){

$sql = "DELETE FROM op_senalamientos_dispensarios WHERE id = '".$_POST['id']."' ";
	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}

}else if($_POST['dato'] == 2){

$sql = "DELETE FROM op_senalamientos_dispensarios_especificaciones WHERE id = '".$_POST['id']."' ";

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