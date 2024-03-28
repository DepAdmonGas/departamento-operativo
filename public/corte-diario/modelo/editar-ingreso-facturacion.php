<?php
require('../../../app/help.php');

if ($_POST['mes'] == 1) {
	$sql = "UPDATE op_ingresos_facturacion_contabilidad SET enero='".$_POST['valor']."' WHERE id='".$_POST['id']."' ";
	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}
}else if ($_POST['mes'] == 2) {
	$sql = "UPDATE op_ingresos_facturacion_contabilidad SET febrero='".$_POST['valor']."' WHERE id='".$_POST['id']."' ";
	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}
}else if ($_POST['mes'] == 3) {
	$sql = "UPDATE op_ingresos_facturacion_contabilidad SET marzo='".$_POST['valor']."' WHERE id='".$_POST['id']."' ";
	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}
}else if ($_POST['mes'] == 4) {
	$sql = "UPDATE op_ingresos_facturacion_contabilidad SET abril='".$_POST['valor']."' WHERE id='".$_POST['id']."' ";
	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}
}else if ($_POST['mes'] == 5) {
	$sql = "UPDATE op_ingresos_facturacion_contabilidad SET mayo='".$_POST['valor']."' WHERE id='".$_POST['id']."' ";
	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}
}else if ($_POST['mes'] == 6) {
	$sql = "UPDATE op_ingresos_facturacion_contabilidad SET junio='".$_POST['valor']."' WHERE id='".$_POST['id']."' ";
	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}
}else if ($_POST['mes'] == 7) {
	$sql = "UPDATE op_ingresos_facturacion_contabilidad SET julio='".$_POST['valor']."' WHERE id='".$_POST['id']."' ";
	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}
}else if ($_POST['mes'] == 8) {
	$sql = "UPDATE op_ingresos_facturacion_contabilidad SET agosto='".$_POST['valor']."' WHERE id='".$_POST['id']."' ";
	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}
}else if ($_POST['mes'] == 9) {
	$sql = "UPDATE op_ingresos_facturacion_contabilidad SET septiembre='".$_POST['valor']."' WHERE id='".$_POST['id']."' ";
	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}
}else if ($_POST['mes'] == 10) {
	$sql = "UPDATE op_ingresos_facturacion_contabilidad SET octubre='".$_POST['valor']."' WHERE id='".$_POST['id']."' ";
	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}
}else if ($_POST['mes'] == 11) {
	$sql = "UPDATE op_ingresos_facturacion_contabilidad SET noviembre='".$_POST['valor']."' WHERE id='".$_POST['id']."' ";
	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}
}else if ($_POST['mes'] == 12) {
	$sql = "UPDATE op_ingresos_facturacion_contabilidad SET diciembre='".$_POST['valor']."' WHERE id='".$_POST['id']."' ";
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