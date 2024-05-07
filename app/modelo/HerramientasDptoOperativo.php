<?php
include_once 'httpPHPAltiria.php';

class HerramientasDptoOperativo extends Exception
{
 
    private $con;
    private $AltiriaSMS;

    public function __construct($con)
    {
    $this->con = $con;
 
    parent::__construct("Error en AltiriaSMS");
    $this->AltiriaSMS  = new AltiriaSMS();
    }
 
    /* ---------- CONSULTAS GENERALES ----------*/
    public function obtenerNombreUsuario(int $id): string
    {
    $nombreUsuario = "";
    $sql = "SELECT nombre FROM tb_usuarios WHERE id = ?";
    $consulta = $this->con->prepare($sql);
        
    if (!$consulta) {
    throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
    }
        
    $consulta->bind_param('i', $id);
    $consulta->execute();
    $consulta->bind_result($nombreUsuario);
    $consulta->fetch();
    $consulta->close();
        
    return $nombreUsuario;
    }

    public function obtenerTelefonoUsuario(int $id): string
    {
    $telefonoUser = "";
    $sql = "SELECT telefono FROM tb_usuarios WHERE id = ?";
    $consulta = $this->con->prepare($sql);
        
    if (!$consulta) {
    throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
    }
        
    $consulta->bind_param('i', $id);
    $consulta->execute();
    $consulta->bind_result($telefonoUser);
    $consulta->fetch();
    $consulta->close();
        
    return $telefonoUser;
    }

    function obtenerEstacion($idEstacion)
    {
    $nombreEstacion = "";
    $sql = "SELECT razonsocial FROM tb_estaciones WHERE id = ?";
    $consulta = $this->con->prepare($sql);
    
    if (!$consulta) {
    throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
    }
    
    $consulta->bind_param('i', $idEstacion);
    $consulta->execute();
    $consulta->bind_result($nombreEstacion);
    $consulta->fetch();
    $consulta->close();
    
    return $nombreEstacion;
    }
    
    /* ---------- CONVERTIR UNIDADES  ----------*/
    private static $UNIDADES = [
        '',
        'UN ',
        'DOS ',
        'TRES ',
        'CUATRO ',
        'CINCO ',
        'SEIS ',
        'SIETE ',
        'OCHO ',
        'NUEVE ',
        'DIEZ ',
        'ONCE ',
        'DOCE ',
        'TRECE ',
        'CATORCE ',
        'QUINCE ',
        'DIECISEIS ',
        'DIECISIETE ',
        'DIECIOCHO ',
        'DIECINUEVE ',
        'VEINTE '
        ];
        
        public static $DECENAS = [
        'VENTI',
        'TREINTA ',
        'CUARENTA ',
        'CINCUENTA ',
        'SESENTA ',
        'SETENTA ',
        'OCHENTA ',
        'NOVENTA ',
        'CIEN '
        ];
        public static $CENTENAS = [
        'CIENTO ',
        'DOSCIENTOS ',
        'TRESCIENTOS ',
        'CUATROCIENTOS ',
        'QUINIENTOS ',
        'SEISCIENTOS ',
        'SETECIENTOS ',
        'OCHOCIENTOS ',
        'NOVECIENTOS '
        ];
        public static function convertir($number, $moneda, $centimos = '', $forzarCentimos = false)
        {
        
        if($moneda == "MXN"){
        $tipoMoneda = "pesos";
        $divisa = "M.N";
        }else if($moneda == "USD"){
        $tipoMoneda = "dolares";
        $divisa = "USD";
        }
         
        $converted = '';
        $decimales = '';
        if (($number < 0) || ($number > 999999999)) {
        return 'No es posible convertir el numero a letras';
        }
        
        $div_decimales = explode('.',$number);
        $decimalesNumero = $div_decimales[0];
        if(count($div_decimales) > 1){
        $number = $div_decimales[0];
        $decNumberStr = (string) $div_decimales[1];
        if(strlen($decNumberStr) == 2){
        $decNumberStrFill = str_pad($decNumberStr, 9, '0', STR_PAD_LEFT);
        $decCientos = substr($decNumberStrFill, 6);
        $decimales = self::convertGroup($decCientos);
        }
        
        }else if (count($div_decimales) == 1 && $forzarCentimos){
        $decimales = 'CERO ';
        }
        
        $numberStr = (string) $number;
        $numberStrFill = str_pad($numberStr, 9, '0', STR_PAD_LEFT);
        $millones = substr($numberStrFill, 0, 3);
        $miles = substr($numberStrFill, 3, 3);
        $cientos = substr($numberStrFill, 6);
        
        if (intval($millones) > 0) {
        if ($millones == '001') {
        $converted .= 'UN MILLON ';
        } else if (intval($millones) > 0) {
        $converted .= sprintf('%sMILLONES ', self::convertGroup($millones));
        }
        }
        
        if (intval($miles) > 0) {
        if ($miles == '001') {
        $converted .= 'MIL ';
        } else if (intval($miles) > 0) {
        $converted .= sprintf('%sMIL ', self::convertGroup($miles));
        }
        }
        
        if (intval($cientos) > 0) {
        if ($cientos == '001') {
        $converted .= 'UN ';
        } else if (intval($cientos) > 0) {
        $converted .= sprintf('%s ', self::convertGroup($cientos));
        }
        }
        
        if(empty($decimales)){
        $valor_convertido = $converted . strtoupper($tipoMoneda) .' 00/100 '.$divisa;
        } else {
        $valor_convertido = $converted . strtoupper($tipoMoneda) . ' ' . $decimalesNumero.'/100 '.$divisa;
        }
        return $valor_convertido;
        }
        private static function convertGroup($n)
        {
        $output = '';
        if ($n == '100') {
        $output = "CIEN ";
        } else if ($n[0] !== '0') {
        $output = self::$CENTENAS[$n[0] - 1];
        }
        $k = intval(substr($n,1));
        if ($k <= 20) {
        $output .= self::$UNIDADES[$k];
        } else {
        if(($k > 30) && ($n[2] !== '0')) {
        $output .= sprintf('%sY %s', self::$DECENAS[intval($n[1]) - 2], self::$UNIDADES[intval($n[2])]);
        } else {
        $output .= sprintf('%s%s', self::$DECENAS[intval($n[1]) - 2], self::$UNIDADES[intval($n[2])]);
        }
        }
        return $output;
        }



    /* ---------- ENVIAR TOKEN SMS - USUARIOS   ----------*/

    public function destinatarioToken($telefonoUser,$aleatorio): void
    {

    $this->AltiriaSMS->setLogin('sistemas.admongas@gmail.com');
    $this->AltiriaSMS->setPassword('hy8q4c7y');
    $this->AltiriaSMS->setSenderId('AdmonGas');
    $sDestination = '52'.$telefonoUser;
    $this->AltiriaSMS->sendSMS($sDestination, "AdmonGas: Usa el siguiente token para firmar la solicitud de cheque solicitada. Token: ".$aleatorio." Web: portal.admongas.com.mx");  

    }



    /* ---------- NOTIFICACIONES  ----------*/
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