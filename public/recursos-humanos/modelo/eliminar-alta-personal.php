<?php
require('../../../app/help.php');

    $sql1 = "DELETE FROM op_rh_formatos_alta WHERE id = '".$_POST['idPersonal']."' ";
	mysqli_query($con, $sql1);

		

echo 1;
//------------------
mysqli_close($con);
//------------------
?>