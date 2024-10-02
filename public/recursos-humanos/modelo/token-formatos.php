<?php
require ('../../../app/help.php');
include_once '../../../app/modelo/httpPHPAltiria.php';
$altiriaSMS = new AltiriaSMS();
function notificacionesWA($Numero, $aleatorio,$token)
{
    $telefono = '52' . $Numero;

    //URL A DONDE SE MANDARA EL MENSAJE
    $url = 'https://graph.facebook.com/v19.0/343131472217554/messages';

    //CONFIGURACION DEL MENSAJE
    $mensaje = '{
        "messaging_product": "whatsapp",
        "recipient_type": "individual",
        "to": "' . $telefono . '",
        "type": "text",
        "text": {
        "preview_url": "false",
        "body": "AdmonGas: Usa el siguiente token para firmar el formato solicitado . Token: ' . $aleatorio . ' Web: portal.admongas.com.mx"
      }
    }';

    //DECLARAMOS LAS CABECERAS
    $header = array("Authorization: Bearer " . $token, "Content-Type: application/json", );
    //INICIAMOS EL CURL
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $mensaje);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //OBTENEMOS LA RESPUESTA DEL ENVIO DE INFORMACION
    $response = json_decode(curl_exec($curl), true);
    //IMPRIMIMOS LA RESPUESTA 
    //print_r($response);
    //OBTENEMOS EL CODIGO DE LA RESPUESTA
    $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    //CERRAMOS EL CURL
    curl_close($curl);

}
function Numero($IDUsuarioBD, $con)
{

    $sql = "SELECT telefono FROM tb_usuarios WHERE id = '" . $IDUsuarioBD . "' ";
    $result = mysqli_query($con, $sql);
    $numero = mysqli_num_rows($result);
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $telefono = $row['telefono'];
    }

    return $telefono;
}

$idFormato = $_POST['idFormato'];
$idVal = $_POST['idVal'];
$sql_lista = "SELECT * FROM op_rh_formatos WHERE id = '" . $idFormato . "' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {

    if ($row_lista['formato'] == 1) {
        $Formato = "Alta personal";
    } else if ($row_lista['formato'] == 2) {
        $Formato = "Restructuración personal";
    } else if ($row_lista['formato'] == 3) {
        $Formato = "Falta personal";
    } else if ($row_lista['formato'] == 4) {
        $Formato = "Baja personal";
    } else if ($row_lista['formato'] == 5) {
        $Formato = "Vacaciones personal";
    } else if ($row_lista['formato'] == 6) {
        $Formato = "Ajuste salarial";
    }

}

$sql = "DELETE FROM op_rh_formatos_token WHERE id_formato = '" . $idFormato . "' AND id_usuario = '" . $Session_IDUsuarioBD . "' ";

if (mysqli_query($con, $sql)) {

    $aleatorio = rand(100000, 999999);

    $sql_insert = "INSERT INTO op_rh_formatos_token (
id_formato,
id_usuario,
token
    )
    VALUES 
    (
    '" . $idFormato . "',
    '" . $Session_IDUsuarioBD . "',
    '" . $aleatorio . "'
    )";

    if (mysqli_query($con, $sql_insert)) {


        $Numero = Numero($Session_IDUsuarioBD, $con);
        if ($idVal == 1) {
            $altiriaSMS->setLogin('sistemas.admongas@gmail.com');
            $altiriaSMS->setPassword('hy8q4c7y');
            $altiriaSMS->setSenderId('AdmonGas');
            $sDestination = '52' . $Numero;
            $response = $altiriaSMS->sendSMS($sDestination, "AdmonGas: Usa el siguiente token para firmar el formato " . $Formato . " solicitado. Token: " . $aleatorio . " Web: portal.admongas.com.mx");

            echo 1;
        } elseif ($idVal == 2) {
            notificacionesWA($Numero, $aleatorio,$tokenWhats);
            echo 1;
        }
    } else {
        echo 0;
    }
} else {
    echo 0;
}

//------------------
mysqli_close($con);
//------------------


