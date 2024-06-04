<?php
require('../../../app/help.php');



if ($_POST['type'] == "pedido") {
	
	$sql = "UPDATE op_aceites_lubricantes_reporte SET pedido ='".$_POST['pedido']."' WHERE id='".$_POST['idaceite']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}

}
else if ($_POST['type'] == "ventas") {
	
	$sql = "UPDATE op_aceites_lubricantes_reporte SET ventas ='".$_POST['ventas']."' WHERE id='".$_POST['idaceite']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}

}
else if ($_POST['type'] == "fisicobodega") {
	
	$sql = "UPDATE op_aceites_lubricantes_reporte SET inventario_bodega ='".$_POST['fisico']."' WHERE id='".$_POST['idaceite']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}

}
else if ($_POST['type'] == "fisicoexhibidor") {
	
	$sql = "UPDATE op_aceites_lubricantes_reporte SET inventario_exibidores ='".$_POST['fisico']."' WHERE id='".$_POST['idaceite']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}

}
else if ($_POST['type'] == "facturado") {
	
	$sql = "UPDATE op_aceites_lubricantes_reporte SET producto_facturado ='".$_POST['facturado']."' WHERE id='".$_POST['idaceite']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}

}
else if ($_POST['type'] == "mostrador") {
	
	$sql = "UPDATE op_aceites_lubricantes_reporte SET factura_venta_mostrador ='".$_POST['mostrador']."' WHERE id='".$_POST['idaceite']."' ";

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