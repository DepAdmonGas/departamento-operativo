 <?php
require('../../../app/help.php');

    $sql = "DELETE FROM op_cuenta_litros_detalle WHERE id_detalle = '".$_POST['idDetalle']."' ";

	if (mysqli_query($con, $sql)) {	
	echo 1;
	}else{
	echo 0;
	}

//------------------
mysqli_close($con);
//------------------
?> 