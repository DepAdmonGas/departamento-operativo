<?php

class HerramientasDptoOperativo
{
 

    private $con;
    public function __construct($con)
    {
    $this->con = $con;
    }

    public function sendNotification($token, $detalle, $accion): void
    {
        $url = "https://fcm.googleapis.com/fcm/send";

        $fields = array(
            "to" => $token,
            "notification" => array(
                "body" => $detalle,
                "title" => "Portal AdmonGas",
                "icon" => "",
                "click_action" => $accion
            )
        );
        $headers = array(
            'Authorization: key=AAAAccs8Ry4:APA91bFc3rlPHpHHyABA01dZPc4J9ZChulB2nmBZp0VW5ODR-uDq2Lnz0YvlpROjZrFgIl2UBFHqOPhPM8c5ho-8IR6XuFpwv8_WT_Y-av9vXav4_6eGsZrUdtrMl9GwDWDNZee0Ppli',
            'Content-Type:application/json'
        );
        $ch = curl_init();
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Disabling SSL Certificate support temporarily
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
    }

    public function toquenUser(int $id): string
    {

        $token = "";
        $herramienta = "token-web";
        $sql_firma = "SELECT token FROM tb_usuarios_token WHERE id_usuario = ? AND herramienta = ? ORDER BY id DESC LIMIT 1 ";
        $result_firma = $this->con->prepare($sql_firma);
        if (!$result_firma):
            // Manejo de error
            throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
        endif;
        $result_firma->bind_param('is', $id, $herramienta);
        $result_firma->execute();
        $result_firma->bind_result($token);
        $result_firma->fetch();
        $result_firma->close();
        return $token;
    }
}