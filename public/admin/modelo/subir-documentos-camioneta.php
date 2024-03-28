<?php
require('../../../app/help.php');

//$aleatorio = uniqid();
$numeroAleatorio = rand(1, 1000000);
  
//$aleatorio = uniqid();
$numeroAleatorio2 = rand(1000, 9999);

$tipo = $_POST['tipo'];
$fecha = $_POST['Fecha'];
$descripcion = $_POST['Descripcion'];

$NoDoc1  =   $_FILES['Archivo_file']['name'];
$UpDoc1 = "../../../archivos/camioneta-saveiro/".$numeroAleatorio."-Archivo-".$tipo.$numeroAleatorio2;
 
if(move_uploaded_file($_FILES['Archivo_file']['tmp_name'], $UpDoc1)){
$NomDoc1 = $numeroAleatorio."-Archivo-".$tipo.$numeroAleatorio2;
}


$sql_insert1 = "INSERT INTO op_camioneta_saveiro_documentacion  
(tipo,
fecha,
descripcion,
archivo
) 
VALUES
('".$tipo."',
'".$fecha."',
'".$descripcion."',
'".$NomDoc1."'
)";

if(mysqli_query($con, $sql_insert1)){
    echo 1;

}else{
    echo 0;

} 


//------------------
mysqli_close($con);
//------------------  