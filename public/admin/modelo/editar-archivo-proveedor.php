<?php
require('../../../app/help.php');

$aleatorio = uniqid();

$NoDoc1  =   $_FILES['Archivo_file']['name'];
$UpDoc1 = "../../../archivos/proveedores/".$aleatorio."-".$NoDoc1;
$NomDoc1 = $aleatorio."-".$NoDoc1;


if(move_uploaded_file($_FILES['Archivo_file']['tmp_name'], $UpDoc1)){

$sql_update = "UPDATE op_almacen_proveedores_documentos SET
fecha = '".$_POST['FechaDocumentacion']."',
archivo = '".$NomDoc1."' 
WHERE id_proveedor = '".$_POST['idProveedor']."' AND nombre = '".$_POST['TipoArchivo']."' ";

	if(mysqli_query($con, $sql_update)){
	echo 1;
	}else{
	echo 0;
	}

}


?> 