<?php
require('../../../app/help.php');

$idReporte = $_POST['idReporte'];
$tipoFirma = $_POST['tipoFirma'];
$TokenValidacion = $_POST['TokenValidacion'];

$Firma = "Firma: ".bin2hex(random_bytes(64)).".".uniqid();

if($tipoFirma == "B"){
$estado = 1;
}else if($tipoFirma == "C"){
$estado = 2;
}
 
$sql = "SELECT * FROM op_solicitud_cheque_token WHERE id_solicitud = '".$idReporte."' and id_usuario = '".$Session_IDUsuarioBD."' and token = '".$TokenValidacion."' ORDER BY id ASC LIMIT 1 ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);

if($numero == 1){

$sql = "UPDATE op_solicitud_cheque SET 
status = '".$estado."'
WHERE id = '".$idReporte."' ";

if(mysqli_query($con, $sql)){

$sql_insert2 = "INSERT INTO op_solicitud_cheque_firma (
id_solicitud,
id_usuario,
tipo_firma,
firma
    ) 
    VALUES 
    (
    '".$idReporte."',
    '".$Session_IDUsuarioBD."',
    '".$tipoFirma."',
    '".$Firma."'
    )";

if(mysqli_query($con, $sql_insert2)){

if($tipoFirma == "B"){
$token = toquenUser(2,$con);
$detalle = 'Se firmo con visto bueno una solicitud de cheques de la estación '.$session_nomestacion;
sendNotification($token,$detalle);
}

echo 1;	
}else{
echo 0;
}

}else{
echo 0;
}

}else{
echo 0;	
}

function toquenUser($id,$con){

$sql_firma = "SELECT * FROM tb_usuarios_token WHERE id_usuario = '".$id."' AND herramienta = 'token-web' ORDER BY id DESC LIMIT 1 ";
$result_firma = mysqli_query($con, $sql_firma);
while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){
$token = $row_firma['token'];
}

return $token;
}


function sendNotification($token,$detalle){
    $url ="https://fcm.googleapis.com/fcm/send";

    $fields=array(

        "to"=>$token,

        "notification"=>array(

            "body"=> $detalle,
            "title"=> "Portal AdmonGas",
            "icon"=> "",
            "click_action"=> ""
        )
    );

    $headers=array(
        'Authorization: key=AAAAccs8Ry4:APA91bFc3rlPHpHHyABA01dZPc4J9ZChulB2nmBZp0VW5ODR-uDq2Lnz0YvlpROjZrFgIl2UBFHqOPhPM8c5ho-8IR6XuFpwv8_WT_Y-av9vXav4_6eGsZrUdtrMl9GwDWDNZee0Ppli',
        'Content-Type:application/json'
    );

    $ch=curl_init();
    // Set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Disabling SSL Certificate support temporarily
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result=curl_exec($ch);
 
    curl_close($ch);
}

//------------------
mysqli_close($con);
//------------------



