<?php
require('../../../app/help.php');

	$sql = "DELETE FROM op_pedido_papeleria_detalle WHERE id = '".$_POST['idItem']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}

//------------------
mysqli_close($con);
//------------------
?>