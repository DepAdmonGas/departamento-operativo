<?php
require('../../../app/help.php');
include_once '../../../app/modelo/httpPHPAltiria.php';
$altiriaSMS = new AltiriaSMS();

function Numero($IDUsuarioBD,$con){

$sql = "SELECT telefono FROM tb_usuarios WHERE id = '".$IDUsuarioBD."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$telefono = $row['telefono'];
}

return $telefono;
}

$idReporte = $_POST['idReporte'];
$sql = "DELETE FROM op_solicitud_cheque_token WHERE id_solicitud = '".$idReporte."' AND id_usuario = '".$Session_IDUsuarioBD."' ";

if (mysqli_query($con, $sql)) {

$aleatorio = rand(100000, 999999);

$sql_insert = "INSERT INTO op_solicitud_cheque_token (
id_solicitud,
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

$Numero = Numero($Session_IDUsuarioBD,$con);

$altiriaSMS->setLogin('sistemas.admongas@gmail.com');
$altiriaSMS->setPassword('hy8q4c7y');
$altiriaSMS->setSenderId('AdmonGas');
$sDestination = '52'.$Numero;
$response = $altiriaSMS->sendSMS($sDestination, "AdmonGas: Usa el siguiente token para firmar la solicitud de cheque solicitada. Token: ".$aleatorio." Web: portal.admongas.com.mx");

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


