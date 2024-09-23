<?php 
require('../../../app/help.php');
require '../../../phpmailer/vendor/autoload.php';  // Cargar PHPMailer con Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$idReporte = $_POST['idReporte'];

// Obtener los datos del modelo de negocio
$sql_lista = "SELECT * FROM op_modelo_negocio WHERE id = '".$idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista); 
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) { 
    $Titulo = $row_lista['titulo']; 
    $Descripcion = $row_lista['descripcion'];
}

// Función para obtener el correo del usuario
function CorreoE($IDUsuarioBD, $con) {
    $sql = "SELECT email FROM tb_usuarios WHERE id = '".$IDUsuarioBD."' ";
    $result = mysqli_query($con, $sql);
    $email = '';
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $email = $row['email'];
    }
    return $email;
}

// Borrar token antiguo
$sql = "DELETE FROM op_modelo_negocio_token WHERE id_modelo_negocio = '".$idReporte."' AND id_usuario = '".$Session_IDUsuarioBD."' ";

if (mysqli_query($con, $sql)) {
    // Generar nuevo token
    $aleatorio = rand(100000, 999999);

    // Insertar el nuevo token en la base de datos
    $sql_insert = "INSERT INTO op_modelo_negocio_token (
        id_modelo_negocio,
        id_usuario,
        token
    ) VALUES (
        '".$idReporte."',
        '".$Session_IDUsuarioBD."',
        '".$aleatorio."'
    )";

    if (mysqli_query($con, $sql_insert)) {
        // Preparar los datos del correo
        $Email = CorreoE($Session_IDUsuarioBD, $con);
        $subject = 'Token web';
        $msg = "AdmonGas: Usa el siguiente token para firmar el Modelo de Negocio: " . $Titulo . ". Token: <b>" . $aleatorio . "</b>. Web: portal.admongas.com.mx";

        try {
            // Configurar PHPMailer
            $mail = new PHPMailer(true);  // Habilitar excepciones
            
            // Configuración del servidor SMTP
            $mail->isSMTP();  // Envío mediante SMTP
            $mail->Host = "admongas.com.mx";  // Servidor SMTP
            $mail->SMTPAuth = true;  // Activar autenticación SMTP
            $mail->Username = "portal@admongas.com.mx";  // Usuario SMTP
            $mail->Password = "92Tov8&l5";  // Contraseña SMTP
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // TLS
            $mail->Port = 587;  // Puerto TLS (puede ser 465 para SSL)
            
            // Configuración del remitente y destinatario
            $mail->setFrom('portal@admongas.com.mx', 'Portal AdmonGas');
            $mail->addAddress($Email);  // Destinatario
            
            // Configuración del contenido del correo
            $mail->isHTML(true);  // Enviar en formato HTML
            $mail->Subject = $subject;
            $mail->Body = $msg;  // Contenido del cuerpo del correo

            // Enviar correo
            if ($mail->send()) {
                echo 1;  // Correo enviado correctamente
            } else {
                echo "Error al enviar el correo: " . $mail->ErrorInfo;
            }
        } catch (Exception $e) {
            echo "Error en el envío del correo: {$e->getMessage()}";
        }
    } else {
        echo 0;  // Error al insertar el token en la base de datos
    }
} else {
    echo 0;  // Error al borrar el token antiguo
}

// Cerrar la conexión
mysqli_close($con);
