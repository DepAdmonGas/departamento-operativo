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
    $nombreUsuario = $telefono = $email = $status = $idPuesto = $tipo_puesto = $idEstacion = $nombreES = null;
    $sql = "SELECT
    tb_usuarios.nombre,
    tb_usuarios.telefono,
    tb_usuarios.email,
    tb_usuarios.estatus,
    
    tb_puestos.id,
    tb_puestos.tipo_puesto,

	tb_estaciones.id,
    tb_estaciones.nombre AS nombreES
    
    FROM tb_usuarios
    INNER JOIN tb_puestos ON tb_usuarios.id_puesto = tb_puestos.id
    INNER JOIN tb_estaciones ON tb_usuarios.id_gas = tb_estaciones.id
    WHERE tb_usuarios.id = ?";
    $consulta = $this->con->prepare($sql);

    if (!$consulta) {
    throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
    } 

    $consulta->bind_param('i', $id);
    $consulta->execute();
    $consulta->bind_result($nombreUsuario, $telefono, $email, $status, $idPuesto, $tipo_puesto, $idEstacion, $nombreES);
    if ($consulta->fetch()) {
    // Procesamiento de los datos obtenidos
    $datosUsuario = array(
    'nombre' => $nombreUsuario,
    'telefono' => $telefono,
    'email' => $email,
    'status' => $status,
    'idPuesto' => $idPuesto,
    'tipo_puesto' => $tipo_puesto,
    'idEstacion' => $idEstacion,
    'nombreES' => $nombreES
    );
 
    } else {
    // Manejo de caso cuando no se encuentra el registro
    $datosUsuario = null;
    }    

    return $datosUsuario;
    }

    public function obtenerDatosPersonal($id)
    {
        $fecha_ingreso ='';
    $idPersonal = $idEstacion = $no_colaborador = $nombrePersonal = $idPuesto = $salario = $puesto = $estado = null;

    $sql = "SELECT
    op_rh_personal.id,
    op_rh_personal.id_estacion,
    op_rh_personal.fecha_ingreso,
    op_rh_personal.no_colaborador,
    op_rh_personal.nombre_completo,
    op_rh_personal.puesto AS idPuesto,
    op_rh_personal.sd,
    op_rh_puestos.puesto,
    op_rh_personal.estado
    FROM op_rh_personal
    INNER JOIN op_rh_puestos 
    ON op_rh_personal.puesto = op_rh_puestos.id
    WHERE op_rh_personal.id = ?";
    $consulta = $this->con->prepare($sql);

    if (!$consulta) {
    throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
    } 

    $consulta->bind_param('i', $id);
    $consulta->execute();
    $consulta->bind_result($idPersonal, $idEstacion, $fecha_ingreso, $no_colaborador, $nombrePersonal, $idPuesto, $salario, $puesto, $estado);
    if ($consulta->fetch()) {
    // Procesamiento de los datos obtenidos
    $datosUsuario = array(
    'idPersonal' => $idPersonal,
    'idEstacion' => $idEstacion,
    'fecha_ingreso' => $fecha_ingreso,
    'no_colaborador' => $no_colaborador,
    'nombre_personal' => $nombrePersonal,
    'idPuesto' => $idPuesto,
    'salario' => $salario,
    'puesto' => $puesto,
    'estado' => $estado
    );
 
    } else {
    // Manejo de caso cuando no se encuentra el registro
    $datosUsuario = null;
    }    

    return $datosUsuario;
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
    $datosEstacion = array(
    'nombre' => '',
    'razonsocial' => ''
    );
    }  

    return $datosEstacion;
    } 
 
 
    function obtenerDatosLocalidades($idEstacion)
    {
    $numlista = $nombreLocalidad = $recuperacionV = null;
    $sql = "SELECT numlista, localidad, recuperacion_vapores FROM op_rh_localidades WHERE id = ?";
    $consulta = $this->con->prepare($sql);

        
    if (!$consulta) {
    throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
    }

    $consulta->bind_param('i', $idEstacion);
    $consulta->execute();
    $consulta->bind_result($numlista,$nombreLocalidad,$recuperacionV);

    if ($consulta->fetch()) {
    // Procesamiento de los datos obtenidos
    $datosEstacion = array(
    'numlista' => $numlista,
    'localidad' => $nombreLocalidad,
    'recuperacion_vapores' => $recuperacionV
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


    function obtenerPuestoPersonal($idPuesto)
    {
    $puesto = "";
    $sql = "SELECT puesto FROM op_rh_puestos WHERE id = ?";
    $consulta = $this->con->prepare($sql);

    if (!$consulta) {
    throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
    }

    $consulta->bind_param('i', $idPuesto);
    $consulta->execute();
    $consulta->bind_result($puesto);
    $consulta->fetch();
    $consulta->close();

    return $puesto;
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

    function notificacionesWA($Numero, $aleatorio, $textoN){
    //TOKEN QUE NOS DA FACEBOOK
    $token = 'EAA06AwwBmgcBO2JtMSSEbdGU54Yl2rNm1dV1ZBFlvjQnXZAZAomvt6qPIYUZAmsRYkvmlQaCdwot1SZBKwvJ6jak9ERQz1D2TGKZBqhSURRG1UfTYSDZAM7mxyu7jZCQOoPBQjtSBvLHZCSJtt9uvH2jpEmmhEmuBonZAjHZCbgZBRhvaIkc8AZCNMxOPT13AYRwhrYSZAJXWiZAEfO58KtTemwTiHnnxqhNOzyPDld21ZBJ';
    $telefono = '52'.$Numero;
        
    //URL A DONDE SE MANDARA EL MENSAJE
    $url = 'https://graph.facebook.com/v19.0/343131472217554/messages';
        
    //CONFIGURACION DEL MENSAJE
    $mensaje = '{
    "messaging_product": "whatsapp",
    "recipient_type": "individual",
    "to": "'.$telefono.'",
    "type": "text",
    "text": {
    "preview_url": "false",
    "body": "AdmonGas: Usa el siguiente token para firmar '.$textoN.'. Token: '.$aleatorio.' Web: portal.admongas.com.mx"
    }
    }';
           
    //DECLARAMOS LAS CABECERAS
    $header = array("Authorization: Bearer " . $token, "Content-Type: application/json",);
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

    function notificacionesSMS($Numero, $aleatorio, $textoN){
    
    $this->AltiriaSMS->setDomainId('sistemas.admongas@gmail.com');
    $this->AltiriaSMS->setEncoding('hy8q4c7y');
    $this->AltiriaSMS->setSenderId('AdmonGas');
    $sDestination = '52'.$Numero;
    $this->AltiriaSMS->sendSMS($sDestination, "AdmonGas: Usa el siguiente token para firmar ".$textoN.". Token: ".$aleatorio." Web: portal.admongas.com.mx");  
           
    }

    public function destinatarioToken($telefonoUser,$aleatorio,$idVal,$textoN): void
    {

    if($idVal == 1){
    $this->notificacionesSMS($telefonoUser,$aleatorio,$textoN);
        
    }else if($idVal == 2){
    $this->notificacionesWA($telefonoUser,$aleatorio,$textoN);

    }

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

    public function nombremes(string $mes): string {
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
    
    public function get_nombre_dia2(int $dia): string {
    if ($dia == "1")
     $dia = "Lunes";
    if ($dia == "2")
     $dia = "Martes";
    if ($dia == "3")
     $dia = "Miércoles";
    if ($dia == "4")
     $dia = "Jueves";
    if ($dia == "5")
     $dia = "Viernes";
    if ($dia == "6")
    $dia = "Sábado";
    if ($dia == "7")
    $dia = "Domingo";
    return $dia;
    }

    public function FormatoFecha(string $fechaFormato): string 
    {
    $formato_fecha = explode("-", $fechaFormato);
    $resultado = $this->get_nombre_dia($fechaFormato) . " " . $formato_fecha[2] . " de " . $this->nombremes($formato_fecha[1]) . " del " . $formato_fecha[0];

    return $resultado;
    
    }

    /* ---------- EXTENCION DE ARCHIVOS  ----------*/
    function obtenerExtensionArchivo($archivo) {
    return pathinfo($archivo, PATHINFO_EXTENSION);
    }


    /* ---------- DIAS DE LA SEMANA NOMINA  ----------*/
    function fechasNominaSemana($year, $semana){
    // Obtener la fecha del primer día de la semana
    $inicioDay = new DateTime();
    $inicioDay->setISODate($year, $semana, 1);
    $inicioDay->modify('last thursday');
      
    // Calcular la fecha de fin de la semana (6 días después del inicio)
    $finDay = clone $inicioDay;
    $finDay->modify('+6 days');
      
    // Formatear las fechas para mostrarlas
    $inicioDayFormateada = $inicioDay->format('Y-m-d');
    $finDayFormateada = $finDay->format('Y-m-d');
      
    $array = array(
    'inicioSemanaDay' => $inicioDayFormateada, 
    'finSemanaDay' => $finDayFormateada
    );
      
    return $array; 
      
    } 
    

  //---------- OBTENER NUMERO DEL MES DE LA QUINCENA SELECCIONADA ---------- 
  function obtenerMesPorQuincena($numeroQuincena) {
    // Validar que el número de quincena esté en el rango correcto (1-24)
    if ($numeroQuincena < 1 || $numeroQuincena > 24) {
    return 0;
    }
    // Calcular el número de mes
    $mes = ceil($numeroQuincena / 2);
  
    return $mes;
    }
 
    
    function fechasNominaQuincenas($year, $mes, $quincena){
        // Calcular el primer día del mes
        $primer_dia = mktime(0, 0, 0, $mes, 1, $year);
      
        if ($quincena % 2 == 1) {
        $inicio = date('Y-m-01', $primer_dia);
        $fin = date('Y-m-15', $primer_dia);
        }else{
        $inicio = date('Y-m-16', $primer_dia);
        $fin = date('Y-m-t', $primer_dia);
        }
      
        $array = array(
        'inicioQuincenaDay' => $inicio, 
        'finQuincenaDay' => $fin
        );
      
        return $array; 
        }

}