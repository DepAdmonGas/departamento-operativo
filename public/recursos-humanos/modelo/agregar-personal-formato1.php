<?php
require('../../../app/help.php');
  
$aleatorio = uniqid();


$NoDoc1  =   $_FILES['Documento_file']['name'];
$UpDoc1 = "../../../archivos/".$aleatorio."-".$NoDoc1;

$NoDoc2  =   $_FILES['DocumentoCURP_file']['name'];
$UpDoc2 = "../../../archivos/documentos-personal/curp/".$aleatorio."-".$NoDoc2;

$NoDoc3  =   $_FILES['DocumentoRFC_file']['name'];
$UpDoc3 = "../../../archivos/documentos-personal/rfc/".$aleatorio."-".$NoDoc3;

$NoDoc4  =   $_FILES['DocumentoNSS_file']['name'];
$UpDoc4 = "../../../archivos/documentos-personal/nss/".$aleatorio."-".$NoDoc4;

$NoDoc5  =   $_FILES['DocumentoINE_file']['name'];
$UpDoc5 = "../../../archivos/documentos-personal/ine/".$aleatorio."-".$NoDoc5;

if(move_uploaded_file($_FILES['Documento_file']['tmp_name'], $UpDoc1)){
$NomDoc1 = $aleatorio."-".$NoDoc1;
}else{
$NomDoc1 = "";
}
 
if(move_uploaded_file($_FILES['DocumentoCURP_file']['tmp_name'], $UpDoc2)){
$NomDoc2 = $aleatorio."-".$NoDoc2;
}else{
$NomDoc2 = "";
}

if(move_uploaded_file($_FILES['DocumentoRFC_file']['tmp_name'], $UpDoc3)){
$NomDoc3 = $aleatorio."-".$NoDoc3;
}else{
$NomDoc3 = "";
}

if(move_uploaded_file($_FILES['DocumentoNSS_file']['tmp_name'], $UpDoc4)){
$NomDoc4 = $aleatorio."-".$NoDoc4;
}else{
$NomDoc4 = "";
}

if(move_uploaded_file($_FILES['DocumentoINE_file']['tmp_name'], $UpDoc5)){
$NomDoc5 = $aleatorio."-".$NoDoc5;
}else{
$NomDoc5 = "";
}


$sql_insert = "INSERT INTO op_rh_formatos_alta (
id_formulario, fecha_ingreso, nombres, apellido_p, apellido_m, puesto, ine, curp, rfc, nss, sd, documento, detalle
    )
    VALUES 
    (
    '".$_POST['idReporte']."',
    '".$_POST['FechaIngreso']."',
    '".$_POST['Nombres']."',
    '".$_POST['ApellidoP']."',
    '".$_POST['ApellidoM']."',
    '".$_POST['Puesto']."',
    '".$NomDoc5."',
    '".$NomDoc2."',
    '".$NomDoc3."',
    '".$NomDoc4."',
    '".$_POST['SalarioD']."',
    '".$NomDoc1."',
    '".$_POST['Detalle']."'
    )";

if(mysqli_query($con, $sql_insert)){
echo 1;
}else{
echo 0;
} 

//------------------
mysqli_close($con);
//------------------