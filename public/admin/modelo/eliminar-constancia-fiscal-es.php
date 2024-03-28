 <?php
require('../../../app/help.php');

$sql = "DELETE FROM tb_constancia_fiscal_es WHERE id = '".$_POST['idCSF']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}

//------------------
mysqli_close($con);
//------------------
?>