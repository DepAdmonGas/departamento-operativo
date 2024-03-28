<?php
require('../../../app/help.php');
require "../../../phpmailer/class.phpmailer.php";


function CorreoE($IDUsuarioBD,$con){
$sql = "SELECT email FROM tb_usuarios WHERE id = '".$IDUsuarioBD."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$email = $row['email'];
}
return $email;
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

try {
  $Email = CorreoE($Session_IDUsuarioBD,$con);

  $mail = new phpmailer();
  $mail->PluginDir = "phpmailer/";
  $mail->Mailer = "admongas.com.mx";
  $mail->Host = "admongas.com.mx";
  $mail->SMTPAuth = true;
  $mail->Username = "portal@admongas.com.mx";
  $mail->Password = "92Tov8&l5";
  $mail->Timeout=30;
  $mail->setFrom('portal@admongas.com.mx', 'Portal AdmonGas');
  $mail->AddAddress($Email);

  $mail->isHTML(true);
  $mail->Subject = 'Token web';
  $mail->Body    = 'AdmonGas: Usa el siguiente token para firmar la solicitud de cheque solicitada. Token: <b>'. $aleatorio.'</b>';

  $mail->Send();
  echo 1;
} catch (Exception $e) {
   echo 0;
}

}else{
echo 0;
}
}else{
echo 0;
}




//------------------
mysqli_close($con);
//------------------


