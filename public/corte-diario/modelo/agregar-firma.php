<?php
require('../../../app/help.php');

    $sql_dia = "SELECT fecha, ventas FROM op_corte_dia WHERE id = '".$_POST['idReporte']."' ";
   $result_dia = mysqli_query($con, $sql_dia);
   while($row_dia = mysqli_fetch_array($result_dia, MYSQLI_ASSOC)){
   $dia = FormatoFecha($row_dia['fecha']);
   }

function toquenUser($id,$con){

$sql_firma = "SELECT * FROM tb_usuarios_token WHERE id_usuario = '".$id."' AND herramienta = 'token-web' ORDER BY id DESC LIMIT 1 ";
   $result_firma = mysqli_query($con, $sql_firma);
   while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){
   $token = $row_firma['token'];
   }

return $token;
}


function Firmar($idReporte,$idUsuario,$tipoFirma,$Fecha,$con){
$Firma = "Firma: ".bin2hex(random_bytes(64)).".".uniqid();

$sql_firma = "SELECT * FROM op_corte_dia_firmas WHERE id_reportedia = '".$idReporte."' AND detalle = '".$tipoFirma."' ORDER BY id DESC LIMIT 1 ";
$result_firma = mysqli_query($con, $sql_firma);
$numero = mysqli_num_rows($result_firma);

if($numero == 0){

if($tipoFirma == 'Superviso'){ 
$NuevaFecha = strtotime ('+1 hour' , strtotime($Fecha)); 
$NuevaFecha = date ('Y-m-d H:i:s' , $NuevaFecha); 
}else if($tipoFirma == 'VoBo'){
$Fecha1 = strtotime ('+2 hour' , strtotime($Fecha));
$Fecha1 = date ('Y-m-d H:i:s' , $Fecha1); 
$NuevaFecha = strtotime ('+22 minute' , strtotime($Fecha1));
$NuevaFecha = date ('Y-m-d H:i:s' , $NuevaFecha); 
}

$sql_insert2 = "INSERT INTO op_corte_dia_firmas (
id_reportedia,
id_usuario,
fecha,
firma,
detalle
    )
    VALUES 
    (
    '".$idReporte."',
    '".$idUsuario."',
    '".$NuevaFecha."',
    '".$Firma."',
    '".$tipoFirma."'
    )";

mysqli_query($con, $sql_insert2);

}

}

$img = $_POST['base64'];
$img = str_replace('data:image/png;base64,', '', $img);
$fileData = base64_decode($img);
$fileName = uniqid().'.png';

if(file_put_contents('../../../imgs/firma/'.$fileName, $fileData)){

$sql_insert = "INSERT INTO op_corte_dia_firmas (
    id_reportedia,
    id_usuario,
    firma,
    detalle
    )
    VALUES 
    (
    '".$_POST['idReporte']."',
    '".$Session_IDUsuarioBD."',
    '".$fileName."',
    'Elaboró'
    )";
    
    if(mysqli_query($con, $sql_insert)){

    Firmar($_POST['idReporte'],19,'Superviso',$hoy,$con);
    Firmar($_POST['idReporte'],2,'VoBo',$hoy,$con);

    $sql = "UPDATE op_corte_dia SET ventas = 1, tpv = 1, monedero = 1 WHERE id = '".$_POST['idReporte']."' ";
    mysqli_query($con, $sql);

    $token = toquenUser(19,$con);
    $detalle = 'Se finalizo el corte del día '.$dia.' de la estación '.$session_nomestacion;

    sendNotification($token,$detalle);


	echo 1;
    }else{
    echo 0;
    }

}else{
echo 0;
}

function sendNotification($token,$detalle){
    $url ="https://fcm.googleapis.com/fcm/send";

    $fields=array(

        "to"=>$token,

        "notification"=>array(

            "body"=> $detalle,
            "title"=>"Portal AdmonGas",
            "icon"=>"",
            "click_action"=>""
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
