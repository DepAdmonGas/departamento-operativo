   <?php
require('../../../app/help.php');

$aleatorio = uniqid();

$NoDoc1  =   $_FILES['Documento_file']['name'];
$UpDoc1 = "../../../archivos/constancia-situacion-es/".$aleatorio."-".$NoDoc1;
$NomDoc1 = $aleatorio."-".$NoDoc1;

if(move_uploaded_file($_FILES['Documento_file']['tmp_name'], $UpDoc1)){

$sql_insert2 = "INSERT INTO tb_constancia_fiscal_es (id_estacion,fecha,archivo)

VALUES ('".$_POST['idEstacion']."','".$_POST['fechaCSF']."','".$NomDoc1."')";

if(mysqli_query($con, $sql_insert2)){
echo 1;
}else{
echo 0;	
}

}else{
echo 0;
}


//------------------
mysqli_close($con);
//------------------