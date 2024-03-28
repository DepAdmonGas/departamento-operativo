<?php
require('../../../app/help.php');

    $sql1 = "DELETE FROM op_rh_formatos_alta WHERE id_formulario = '".$_POST['idFormulario']."' ";
	mysqli_query($con, $sql1);

	$sql2 = "DELETE FROM op_rh_formatos_restructuracion WHERE id_formulario = '".$_POST['idFormulario']."' ";
	mysqli_query($con, $sql2);

	$sql3 = "DELETE FROM op_rh_formatos WHERE id = '".$_POST['idFormulario']."' ";
	mysqli_query($con, $sql3);
	

echo 1;
//------------------
mysqli_close($con);
//------------------
?>