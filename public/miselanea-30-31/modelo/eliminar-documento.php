<?php
require('../../../app/help.php');

    $sql1 = "DELETE FROM op_miselanea_documentos_archivo WHERE id = '".$_POST['id']."' ";
	mysqli_query($con, $sql1);

		

echo 1;
//------------------
mysqli_close($con);
//------------------
?>