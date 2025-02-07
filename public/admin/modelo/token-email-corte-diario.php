<?php
require '../../../app/help.php';
require '../../../phpmailer/vendor/autoload.php';  // Cargar PHPMailer con Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
$sql = "DELETE FROM op_corte_dia_token WHERE id_reportedia = '" . $idReporte . "' AND id_usuario = '" . $Session_IDUsuarioBD . "' ";

if (mysqli_query($con, $sql)) {
    $aleatorio = rand(100000, 999999);

    $sql_insert = "INSERT INTO op_corte_dia_token (
        id_reportedia,
        id_usuario,
        token 
    ) VALUES (
        '" . $idReporte . "',
        '" . $Session_IDUsuarioBD . "',
        '" . $aleatorio . "'
    )";

    if (mysqli_query($con, $sql_insert)) {
        try {
            $Email = CorreoE($Session_IDUsuarioBD, $con);
            $mail = new PHPMailer(true);  // Usa "true" para habilitar excepciones

            // Configuración del servidor SMTP
            $mail->isSMTP();  // Envío mediante SMTP
            $mail->Host = "admongas.com.mx";  // Servidor SMTP
            $mail->SMTPAuth = true;  // Activar autenticación SMTP
            $mail->Username = "portal@admongas.com.mx";  // Usuario SMTP
            $mail->Password = "92Tov8&l5";  // Contraseña SMTP
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // TLS para encriptación
            $mail->Port = 587;  // Puerto para TLS (o 465 para SSL)

            // Configuración del remitente y destinatario
            $mail->setFrom('portal@admongas.com.mx', 'Portal AdmonGas');
            $mail->addAddress($Email);  // Añade el destinatario

            // Contenido del correo
            $mail->isHTML(true);  // Habilitar HTML en el correo
            $mail->Subject = 'Token web';
            $mail->Body = 'AdmonGas: Usa el siguiente token para firmar la solicitud de corte diario. Token: <b>' . $aleatorio . '</b>';

            // Envío del correo
            if ($mail->send()) {
                echo 1;
            } else {
                echo "Error al enviar el correo: " . $mail->ErrorInfo;
            }
        } catch (Exception $e) {
            echo "Error en el envío de correo: {$e->getMessage()}";
        }
    } else {
        echo 0;
    }
} else {
    echo 0;
}

mysqli_close($con);
