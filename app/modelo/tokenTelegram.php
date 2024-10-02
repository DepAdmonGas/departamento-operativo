<?php 
class Telegram extends Exception{
    private $apiToken = "bot7819301219:AAHBn9Z8qO9E7G0OWrQ2JtY3xTfIlu8QV0o";
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }
    public function enviarToken($idUsuario,$mensaje): bool{

        $result = true;
        //$chatId = 5429996294;
        $chatId = $this->getChatId($idUsuario);

        $data = [
            'chat_id' => $chatId,
            'text' => $mensaje
        ];
        
        // URL de la API para enviar el mensaje
        $url = "https://api.telegram.org/$this->apiToken/sendMessage";
        
        // Inicia una solicitud cURL para enviar el mensaje
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // Ejecuta la solicitud y obtiene la respuesta
        curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    // Se obtiene el chat id que esta dado de alta en BD
    private function getChatID(int $idUsuario): int{
        $result = 0;
        $sql = "SELECT chat_id FROM op_token_telegram where id_usuario = ?";
        $stmt = $this->con->prepare($sql);
        if(!$stmt){
            throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
        }
        $stmt->bind_param("i",$idUsuario);
        $stmt->execute();
        $stmt->bind_result($result);
        $stmt->fetch();
        $stmt->close();
        return $result;
    }
}