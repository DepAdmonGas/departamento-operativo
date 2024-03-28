<?php
require('../../../app/help.php');

    $sql_dia = "SELECT fecha, ventas FROM op_corte_dia WHERE id = '".$_POST['idReporte']."' ";
   $result_dia = mysqli_query($con, $sql_dia);
   while($row_dia = mysqli_fetch_array($result_dia, MYSQLI_ASSOC)){
   $dia = FormatoFecha($row_dia['fecha']);
   }

function toquenUser($id,$con){

     $sql_firma = "SELECT * FROM tb_usuarios_token WHERE id_usuario = '".$id."' AND herramienta = 'token-web' ";
   $result_firma = mysqli_query($con, $sql_firma);
   while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){
   $token = $row_firma['token'];
   }

return $token;
}

function estacion($idReporte, $con){


$sql_estacion = "SELECT 
op_corte_year.id,
op_corte_year.id_estacion,
op_corte_mes.mes,
op_corte_dia.id,
tb_estaciones.nombre
FROM op_corte_year
INNER JOIN op_corte_mes
ON op_corte_year.id = op_corte_mes.id_year
INNER JOIN op_corte_dia
ON op_corte_mes.id = op_corte_dia.id_mes
INNER JOIN tb_estaciones
ON op_corte_year.id_estacion = tb_estaciones.id WHERE op_corte_dia.id = '".$idReporte."' ";
   $result_estacion = mysqli_query($con, $sql_estacion);
   while($row_estacion = mysqli_fetch_array($result_estacion, MYSQLI_ASSOC)){
   $nombre = $row_estacion['nombre'];
   }

return $nombre;
  

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
    'Superviso'
    )";
    
    if(mysqli_query($con, $sql_insert)){

$estacion = estacion($_POST['idReporte'], $con);
   
    $token = toquenUser(2,$con);
       $detalle = 'Se superviso el corte del día '.$dia.' de la estación '.$estacion;

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
            "click_action"=>"https://asuntoslegales.tmfsmexico.com/asuntos-legales/"
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
