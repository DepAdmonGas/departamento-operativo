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

$idFormato = $_POST['idFormato'];

$sql_lista = "SELECT * FROM op_rh_formatos WHERE id = '".$idFormato."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

if($row_lista['formato'] == 1){
$Formato = "Alta personal";
}else if($row_lista['formato'] == 2){
$Formato = "Restructuración personal";
}else if($row_lista['formato'] == 3){
$Formato = "Falta personal";
}else if($row_lista['formato'] == 4){
$Formato = "Baja personal";
}else if($row_lista['formato'] == 5){
$Formato = "Vacaciones personal";
}else if($row_lista['formato'] == 6){
$Formato = "Ajuste salarial";
}

}

$sql = "DELETE FROM op_rh_formatos_token WHERE id_formato = '".$idFormato."' AND id_usuario = '".$Session_IDUsuarioBD."' ";

if (mysqli_query($con, $sql)) {

$aleatorio = rand(100000, 999999);

$sql_insert = "INSERT INTO op_rh_formatos_token (
id_formato,
id_usuario,
token
    )
    VALUES 
    (
    '".$idFormato."',
    '".$Session_IDUsuarioBD."',
    '".$aleatorio."'
    )";

if(mysqli_query($con, $sql_insert)){


$Numero = Numero($Session_IDUsuarioBD,$con);

$altiriaSMS->setLogin('sistemas.admongas@gmail.com');
$altiriaSMS->setPassword('hy8q4c7y');
$altiriaSMS->setSenderId('AdmonGas');
$sDestination = '52'.$Numero;
$response = $altiriaSMS->sendSMS($sDestination, "AdmonGas: Usa el siguiente token para firmar el formato ".$Formato." solicitado. Token: ".$aleatorio." Web: portal.admongas.com.mx");

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


