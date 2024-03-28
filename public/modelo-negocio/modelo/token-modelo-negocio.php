<?php
require('../../../app/help.php');
include_once '../../../app/modelo/httpPHPAltiria.php';
$altiriaSMS = new AltiriaSMS();

$idReporte = $_POST['idReporte'];

$sql_lista = "SELECT * FROM op_modelo_negocio WHERE id = '".$idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista); 
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){ 
$Titulo = $row_lista['titulo']; 
$Descripcion = $row_lista['descripcion'];
}

function Numero($IDUsuarioBD,$con){

$sql = "SELECT telefono FROM tb_usuarios WHERE id = '".$IDUsuarioBD."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$telefono = $row['telefono'];
}

return $telefono;
}


$sql = "DELETE FROM op_modelo_negocio_token WHERE id_modelo_negocio = '".$idReporte."' AND id_usuario = '".$Session_IDUsuarioBD."' ";

if (mysqli_query($con, $sql)) {

$aleatorio = rand(100000, 999999);

$sql_insert = "INSERT INTO op_modelo_negocio_token (
id_modelo_negocio,
id_usuario,
token
    )
    VALUES 
    (
    '".$idReporte."',
    '".$Session_IDUsuarioBD."',
    '".$aleatorio."'
    )";

if(mysqli_query($con, $sql_insert)){

echo $Numero = Numero($Session_IDUsuarioBD,$con);

$altiriaSMS->setLogin('sistemas.admongas@gmail.com');
$altiriaSMS->setPassword('hy8q4c7y');
$altiriaSMS->setSenderId('AdmonGas');
$sDestination = '52'.$Numero;
$response = $altiriaSMS->sendSMS($sDestination, "AdmonGas: Usa el siguiente token para firmar el Modelo de Negocio: ".$Titulo.". Token: ".$aleatorio." Web: portal.admongas.com.mx");

//echo 1;
}else{
echo 0;
}
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------


