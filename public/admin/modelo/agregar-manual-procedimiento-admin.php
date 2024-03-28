  <?php
require('../../../app/help.php');

$aleatorio = uniqid();

$NoDoc1  =   $_FILES['Documento_file']['name'];
$UpDoc1 = "../../../archivos/manual-procedimiento/".$aleatorio."-".$NoDoc1;
$NomDoc1 = $aleatorio."-".$NoDoc1;

if(move_uploaded_file($_FILES['Documento_file']['tmp_name'], $UpDoc1)){


$sql_insert2 = "INSERT INTO tb_manuales_do (descripcion,documento)

VALUES ('".$_POST['Descripcion']."','".$NomDoc1."')";

mysqli_query($con, $sql_insert2);
echo 1;
}else{
echo 0;
}


//------------------
mysqli_close($con);
//------------------