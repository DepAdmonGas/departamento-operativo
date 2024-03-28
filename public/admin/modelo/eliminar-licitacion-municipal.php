 <?php
require('../../../app/help.php');

$sql = "DELETE FROM op_licitacion_municipal WHERE id = '".$_POST['idLicitacion']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}



//------------------
mysqli_close($con);
//------------------
?>