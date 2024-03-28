 <?php
require('../../../app/help.php');

    $sql1 = "DELETE FROM op_recibo_nomina_acuse WHERE id = '".$_POST['idArchivo']."' ";
	mysqli_query($con, $sql1);

		

echo 1;
//------------------
mysqli_close($con);
//------------------
?>