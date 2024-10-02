<?php
require('../../../app/help.php');

$aleatorio = uniqid();

$Doc1  =   $_FILES['CartaCredito_file']['name'];
$Folder1 = "../../../archivos/".$aleatorio."-".$Doc1;
$Nombre1 = $aleatorio."-".$Doc1;

$Doc2  =   $_FILES['ActaConstitutiva_file']['name'];
$Folder2 = "../../../archivos/".$aleatorio."-".$Doc2;
$Nombre2 = $aleatorio."-".$Doc2;

$Doc3  =   $_FILES['ComprobanteDom_file']['name'];
$Folder3 = "../../../archivos/".$aleatorio."-".$Doc3;
$Nombre3 = $aleatorio."-".$Doc3;

$Doc4  =   $_FILES['Identificacion_file']['name'];
$Folder4 = "../../../archivos/".$aleatorio."-".$Doc4;
$Nombre4 = $aleatorio."-".$Doc4;


$sql = "UPDATE op_cliente SET 
cuenta = '".$_POST['Cuenta']."',
cliente = '".$_POST['Cliente']."',
tipo = '".$_POST['Tipo']."',
rfc = '".$_POST['RFC']."'
WHERE id='".$_POST['idCliente']."' ";

	if (mysqli_query($con, $sql)) {

	if(move_uploaded_file($_FILES['CartaCredito_file']['tmp_name'], $Folder1)) {

		$sql2 = "UPDATE op_cliente SET 
		doc_cc = '".$Nombre1."'
		WHERE id='".$_POST['idCliente']."' ";
		mysqli_query($con, $sql2);

	}

	if(move_uploaded_file($_FILES['ActaConstitutiva_file']['tmp_name'], $Folder2)) {

		$sql3 = "UPDATE op_cliente SET 
		doc_ac = '".$Nombre2."'
		WHERE id='".$_POST['idCliente']."' ";
		mysqli_query($con, $sql3);

	}
	if(move_uploaded_file($_FILES['ComprobanteDom_file']['tmp_name'], $Folder3)) {

		$sql4 = "UPDATE op_cliente SET 
		doc_cd = '".$Nombre3."'
		WHERE id='".$_POST['idCliente']."' ";
		mysqli_query($con, $sql4);

	}
	if(move_uploaded_file($_FILES['Identificacion_file']['tmp_name'], $Folder4)) {

		$sql5 = "UPDATE op_cliente SET 
		doc_io = '".$Nombre4."'
		WHERE id='".$_POST['idCliente']."' ";
		mysqli_query($con, $sql5);
	}
	
	echo 1;
	} else {
	  echo 0;
	}

//------------------
mysqli_close($con);
//------------------
?>