 <?php
require('../../../app/help.php');

$aleatorio = uniqid();

$NoDoc1  =   $_FILES['Documento_file']['name'];
$UpDoc1 = "../../../archivos/licitacion-municipal/".$aleatorio."-".$NoDoc1;
$NomDoc1 = $aleatorio."-".$NoDoc1;

if(move_uploaded_file($_FILES['Documento_file']['tmp_name'], $UpDoc1)){

$sql_insert2 = "INSERT INTO op_licitacion_municipal 
(year, fecha, nombre_formato, archivo)

VALUES ('".$_POST['idYear']."','".$_POST['Fecha']."','".$_POST['Formato']."','".$NomDoc1."')";

mysqli_query($con, $sql_insert2);
echo 1;
}else{
echo 0;
}
 

//------------------
mysqli_close($con);
//------------------