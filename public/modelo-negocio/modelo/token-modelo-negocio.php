<?php
require ('../../../app/help.php');
include_once '../../../app/modelo/httpPHPAltiria.php';
$altiriaSMS = new AltiriaSMS();

$idReporte = $_POST['idReporte'];
$idVal = $_POST['idVal'];

$sql_lista = "SELECT * FROM op_modelo_negocio WHERE id = '" . $idReporte . "' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
    $Titulo = $row_lista['titulo'];
    $Descripcion = $row_lista['descripcion'];
}
function notificacionesWA($Numero, $aleatorio)
{
    //TOKEN QUE NOS DA FACEBOOK
    $token = 'EAA06AwwBmgcBO55i0gFeGOxZAAKWQIsd89aw8J0NCGDIisqmfHDk7tkhhgSzi5pSH1Bib5RYajmvckNmPJLZBzqLm901Fb5ZBqdeH3iv2PeNl90cuBKj4Qr63tZC3j7CdyZCfVoZCar6BLZC1c34vxUq3OWT2FwH65qwme7ytT3LnqglsPZA4ZCUqqkWW92iwirRukF34Dk3m0QDzra3Cn6vW0QnFe6X4PGY7xU0ZD';
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
        "body": "AdmonGas: Usa el siguiente token para firmar el Modelo de Negocio: ' . $aleatorio . ' Web: portal.admongas.com.mx"
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


$sql = "DELETE FROM op_modelo_negocio_token WHERE id_modelo_negocio = '" . $idReporte . "' AND id_usuario = '" . $Session_IDUsuarioBD . "' ";

if (mysqli_query($con, $sql)) {

    $aleatorio = rand(100000, 999999);

    $sql_insert = "INSERT INTO op_modelo_negocio_token (
id_modelo_negocio,
id_usuario,
token
    )
    VALUES 
    (
    '" . $idReporte . "',
    '" . $Session_IDUsuarioBD . "',
    '" . $aleatorio . "'
    )";

    if (mysqli_query($con, $sql_insert)) {

        echo $Numero = Numero($Session_IDUsuarioBD, $con);
        if ($idVal == 1) {
            $altiriaSMS->setLogin('sistemas.admongas@gmail.com');
            $altiriaSMS->setPassword('hy8q4c7y');
            $altiriaSMS->setSenderId('AdmonGas');
            $sDestination = '52' . $Numero;
            $response = $altiriaSMS->sendSMS($sDestination, "AdmonGas: Usa el siguiente token para firmar el Modelo de Negocio: " . $Titulo . ". Token: " . $aleatorio . " Web: portal.admongas.com.mx");

            echo 1;
        } elseif ($idVal == 2) {
            notificacionesWA($Numero, $aleatorio);
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


