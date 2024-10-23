<?php
require('../../../app/help.php');


if ($_POST['type'] == "producto") {
	$ieps = 0.0;
	if ($_POST['producto'] == "G SUPER") {
	$ieps = 0.4369;
	}
	else if ($_POST['producto'] == "G PREMIUM") {
	$ieps = 0.5331;
	}
	else if ($_POST['producto'] == "G DIESEL") {
	$ieps = 0.3626;
	}
	
	$sql = "UPDATE op_ventas_dia SET producto='".$_POST['producto']."', ieps ='".$ieps."' WHERE id='".$_POST['idVentas']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}

}else if ($_POST['type'] == "litros") {
	
	$sql = "UPDATE op_ventas_dia SET litros='".$_POST['litros']."' WHERE id='".$_POST['idVentas']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}

}else if ($_POST['type'] == "jarras") {

	$sql = "UPDATE op_ventas_dia SET jarras='".$_POST['jarras']."' WHERE id='".$_POST['idVentas']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}

}else if ($_POST['type'] == "preciolitro") {

	$sql = "UPDATE op_ventas_dia SET precio_litro='".$_POST['preciolitro']."' WHERE id='".$_POST['idVentas']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}

}else if ($_POST['type'] == "otros") {

	$sql = "UPDATE op_ventas_dia_otros SET importe='".$_POST['otros']."' WHERE id='".$_POST['idOtros']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}

}else if ($_POST['type'] == "piezas") {

	$sql_listaaceites = "SELECT * FROM op_aceites_lubricantes WHERE idreporte_dia = '".$_POST['idReporte']."' ";
    $result_listaaceites = mysqli_query($con, $sql_listaaceites);
    while($row_listaaceites = mysqli_fetch_array($result_listaaceites, MYSQLI_ASSOC)){

    $importe = $row_listaaceites['cantidad'] * $row_listaaceites['precio_unitario'];

    $totalCantidad = $totalCantidad + $row_listaaceites['cantidad'];
    $totalPrecio = $totalPrecio + $importe;
    }

	$sql = "UPDATE op_ventas_dia_otros SET piezas='".$totalCantidad."', importe = '".$totalPrecio."' WHERE idreporte_dia ='".$_POST['idReporte']."' AND concepto = '4 ACEITES Y LUBRICANTES' ";

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