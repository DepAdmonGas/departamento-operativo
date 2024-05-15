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
    public function obtenerDatosUsuario($id)
    {
    $nombreUsuario = $telefono = null;
    $sql = "SELECT nombre, telefono FROM tb_usuarios WHERE id = ?";
    $consulta = $this->con->prepare($sql);

    if (!$consulta) {
    throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
    } 

    $consulta->bind_param('i', $id);
    $consulta->execute();
    $consulta->bind_result($nombreUsuario, $telefono);
    if ($consulta->fetch()) {
    // Procesamiento de los datos obtenidos
    $datosUsuario = array(
    'nombre' => $nombreUsuario,
    'telefono' => $telefono
    );

    } else {
    // Manejo de caso cuando no se encuentra el registro
    $datosUsuario = null;
    }    
    $consulta->bind_result($nombreUsuario);
    $consulta->fetch();
    $consulta->close();

    return $datosUsuario;
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

    function obtenerDatosEstacion($idEstacion)
    {
    $nombreEstacion = $razonEstacion = null;
    $sql = "SELECT nombre, razonsocial FROM tb_estaciones WHERE id = ?";
    $consulta = $this->con->prepare($sql);

        
    if (!$consulta) {
    throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
    }

    $consulta->bind_param('i', $idEstacion);
    $consulta->execute();
    $consulta->bind_result($nombreEstacion,$razonEstacion);

    if ($consulta->fetch()) {
    // Procesamiento de los datos obtenidos
    $datosEstacion = array(
    'nombre' => $nombreEstacion,
    'razonsocial' => $razonEstacion
    );

    } else {
    // Manejo de caso cuando no se encuentra el registro
    $datosEstacion = null;
    }  

    return $datosEstacion;
    } 

    function obtenerPuesto($idPuesto)
    {
    $tipo_puesto = "";
    $sql = "SELECT tipo_puesto FROM tb_puestos WHERE id = ?";
    $consulta = $this->con->prepare($sql);

    if (!$consulta) {
    throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
    }

    $consulta->bind_param('i', $idPuesto);
    $consulta->execute();
    $consulta->bind_result($tipo_puesto);
    $consulta->fetch();
    $consulta->close();

    return $tipo_puesto;
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

    $this->AltiriaSMS->setApikey('sistemas.admongas@gmail.com');
    $this->AltiriaSMS->setApisecret('hy8q4c7y');
    $this->AltiriaSMS->setSenderId('AdmonGas');
    $sDestination = '525527314824';
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


    /* ---------- FORMATOS DE FECHAS  ----------*/

    public function nombremes(int $mes): string {
        switch ($mes) :
        case "01": $mes = "Enero"; return $mes;
        case "02": $mes = "Febrero"; return $mes;
        case "03": $mes = "Marzo"; return $mes;
        case "04": $mes = "Abril"; return $mes;
        case "05": $mes = "Mayo"; return $mes;
        case "06": $mes = "Junio"; return $mes;
        case "07": $mes = "Julio"; return $mes;
        case "08": $mes = "Agosto"; return $mes;
        case "09": $mes = "Septiembre"; return $mes;
        case "10": $mes = "Octubre"; return $mes;
        case "11": $mes = "Noviembre";  return $mes;
        case "12": $mes = "Diciembre"; return $mes;
        default:
        $mes = "Mes inválido"; return $mes;
        endswitch;
    
        }
    
        public function get_nombre_dia(string $fecha): string {
        $fechats = strtotime($fecha);
        switch (date('w', $fechats)) :
        case 0: $dia = "Domingo"; return $dia;
        case 1: $dia = "Lunes"; return $dia;
        case 2: $dia = "Martes"; return $dia;
        case 3: $dia = "Miercoles"; return $dia;
        case 4: $dia = "Jueves"; return $dia;
        case 5: $dia = "Viernes"; return $dia;
        case 6: $dia = "Sabado"; return $dia;
        default:
        $dia = "Dia inválido"; return $dia;
        endswitch;
    
        }
    
        public function FormatoFecha(string $fechaFormato): string 
        {
        $formato_fecha = explode("-", $fechaFormato);
        $resultado = get_nombre_dia($fechaFormato) . " " . $formato_fecha[2] . " de " . nombremes($formato_fecha[1]) . " del " . $formato_fecha[0];
        return $resultado;
    
        }
    
}