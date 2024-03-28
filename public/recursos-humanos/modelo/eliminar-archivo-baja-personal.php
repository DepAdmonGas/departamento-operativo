 <?php
require('../../../app/help.php');


$sql = "DELETE FROM op_rh_personal_baja_archivos WHERE id = '".$_POST['idArchivo']."' ";

	if (mysqli_query($con, $sql)) {
	echo 1;
	} else {
	echo 0;
	}

//------------------
mysqli_close($con);
//------------------
?>