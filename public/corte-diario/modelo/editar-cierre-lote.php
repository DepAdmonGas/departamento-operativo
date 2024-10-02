<?php
require('../../../app/help.php');


if ($_POST['type'] == "nocierre") {

	$sql = "UPDATE op_cierre_lote SET no_cierre_lote='".$_POST['nocierre']."' WHERE id='".$_POST['idCierre']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}

}else if ($_POST['type'] == "importe") {

	$sql = "UPDATE op_cierre_lote SET importe='".$_POST['importe']."' WHERE id='".$_POST['idCierre']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}

	monederosybancos($_POST['idReporte'],$_POST['empresa'],$con);

}else if ($_POST['type'] == "noticket") {

	$sql = "UPDATE op_cierre_lote SET ticktes='".$_POST['noticket']."' WHERE id='".$_POST['idCierre']."' ";

	if (mysqli_query($con, $sql)) {
	  echo 1;
	} else {
	  echo 0;
	}

}

function monederosybancos($idReporte,$empresa,$con){

	 $sql_listacierre = "SELECT * FROM op_cierre_lote WHERE idreporte_dia = '".$idReporte."' AND empresa = '".$empresa."' ";
    $result_listacierre = mysqli_query($con, $sql_listacierre);
    while($row_listacierre = mysqli_fetch_array($result_listacierre, MYSQLI_ASSOC)){

        $TotalImporte = $TotalImporte + $row_listacierre['importe'];
    
    }

    $sql = "UPDATE op_tarjetas_c_b SET baucher='".$TotalImporte."' WHERE concepto='".$empresa."' AND idreporte_dia = ".$idReporte." ";

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