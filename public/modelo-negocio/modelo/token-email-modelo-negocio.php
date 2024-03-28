<?php
require('../../../app/help.php');
require "../../../phpmailer/class.phpmailer.php";

$idReporte = $_POST['idReporte'];

$sql_lista = "SELECT * FROM op_modelo_negocio WHERE id = '".$idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista); 
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){ 
$Titulo = $row_lista['titulo']; 
$Descripcion = $row_lista['descripcion'];
}

function CorreoE($IDUsuarioBD,$con){
$sql = "SELECT email FROM tb_usuarios WHERE id = '".$IDUsuarioBD."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$email = $row['email'];
}
return $email;
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

$Email = CorreoE($Session_IDUsuarioBD,$con);

$subject = 'Token web';
$msg = "AdmonGas: Usa el siguiente token para firmar el Modelo de Negocio: ".$Titulo.". Token: ".$aleatorio." Web: portal.admongas.com.mx";
$from = $Email;

// El from DEBE corresponder a una cuenta de correo real creada en el servidor
$headers = "From: portal@admongas.com.mx\r\n"; 
$headers .= "Reply-To: $from\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=utf-8\r\n"; 
  
if(mail($from, $subject, $msg,$headers)){
  echo 1;
  }else{
  echo 0;
}

/*
try {
  
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
*/

}else{
echo 0;
}
}else{
echo 0;
}




//------------------
mysqli_close($con);
//------------------


