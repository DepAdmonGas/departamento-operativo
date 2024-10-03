<?php
require "../../bd/inc.conexion.php";
require "../../modelo/httpPHPAltiria.php";
require_once '../../modelo/HerramientasDptoOperativo.php';
require '../../../phpmailer/vendor/autoload.php';
require '../../modelo/tokenTelegram.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Formatos extends Exception{
    private $classConexionBD;
    private $con;
    private $altiriaSMS;
    private $formato;
    private $telegram;

    public function __construct()
    {
    $this->classConexionBD = Database::getInstance();
    $this->con = $this->classConexionBD->getConnection();
    $this->altiriaSMS = new AltiriaSMS();
    $this->formato = new herramientasDptoOperativo($this->con);
    $this->telegram = new Telegram($this->con);
    }
    public function formatos(int $idEstacion,int $formato): int{
        $status = 0;
        $idReporte = $this->idReporte();
        $sql_insert = "INSERT INTO op_rh_formatos  (id,id_localidad,formato,status) VALUES (?,?,?,?)";
        $result = $this->con->prepare($sql_insert);
        if(!$result):
            throw new Exception("Error al preparar la consulta \n".$this->con->error);
        endif;
        $result->bind_param("iiii", $idReporte, $idEstacion, $formato, $status);
        if(!$result->execute()):
            throw new Exception("Error al ejecutar la consulta \n".$result->error);
        endif;
        $result->close();
        return $idReporte;
    }
    private function idReporte(): int {
        $id = 0;
        $sql = "SELECT id FROM op_rh_formatos ORDER BY id DESC LIMIT 1";
        $result = $this->con->prepare($sql);
        if (!$result) :
            throw new Exception("Error al preparar la consulta: " . $this->con->error);
        endif;
        
        if (!$result->execute()) :
            throw new Exception("Error al ejecutar la consulta: " . $result->error);
        endif;
        $result->bind_result($id);
        $result->fetch();
        
        if ($id === null) :
            $id = 1;
        else :
            $id += 1; 
        endif;
        $result->close();
        return $id;
    }


    //---------- 1. FORMULARIO ALTA DE PERSONAL ----------//
    public function guardarAltaPersonal(int $idReporte, int $idEstacion, string $NombreCompleto, int $Puesto, string $FechaIngreso, float $sd): bool{
    $resultado = true;
    $sql = "INSERT INTO op_rh_formatos_alta (
    id_formulario, id_estacion, fecha_ingreso, nombre, puesto, sd) VALUES (?,?,?,?,?,?)";
        
    $result = $this->con->prepare($sql);
    if (!$result) :
    throw new Exception("Error al preparar la consulta \n". $this->con->error);
    endif;
        
    $result->bind_param("iissid", $idReporte, $idEstacion, $FechaIngreso, $NombreCompleto, $Puesto, $sd);
    if (!$result->execute()) :
    $resultado = false;
    throw new Exception("Error al ejecutar la consulta". $result->error);
    endif;

    $result->close();
    return $resultado;
    }


    public function eliminarAltaPersonal(int $idUsuario) : bool {
    $resultado = true;
    $sql = "DELETE FROM op_rh_formatos_alta WHERE id = ? ";
    $result = $this->con->prepare($sql);
    $result->bind_param("i",$idUsuario);
    $result->execute();
    $result->close();
    return $resultado;
    }  

    private function altaPersonal($estacion, $fecha, $nombre, $puesto, $salario) : bool
    {
        $resultado = true;
        $estado = 1;
        $sql_insert = "INSERT INTO op_rh_personal (id_estacion,fecha_ingreso,nombre_completo,puesto,sd,estado)
        VALUES  (?,?,?,?,?,?)";
        $result = $this->con->prepare($sql_insert);
        if (!$result):
            throw new Exception("Error al preparar la consulta \n" . $this->con->error);
        endif;
        $result->bind_param("issidi", $estacion,$fecha,$nombre,$puesto,$salario,$estado);
        if (!$result->execute()):
            $resultado = false;
            throw new Exception("Error al ejecutar la consulta \n" . $result->error);
        endif;
        $result->close();
        return $resultado;
    }

    //---------- 2. FORMULARIO BAJA DE PERSONAL ----------//
    public function guardarBajaPersonal(int $idReporte, int $idEstacion, string $NombreCompleto, string $FechaBaja, string $Motivo, string $Detalle): bool{
        $resultado = true;
        $sql = "INSERT INTO op_rh_formatos_baja (
        id_formulario, id_personal, id_estacion, fecha_baja, motivo, detalle) VALUES (?,?,?,?,?,?)";
            
        $result = $this->con->prepare($sql);
        if (!$result) :
        throw new Exception("Error al preparar la consulta \n". $this->con->error);
        endif;

        if($Detalle == ""){
        $Detalle2 = "Sin Información";
        }else{
        $Detalle2 = $Detalle;
        }
            
        $result->bind_param("iiisss", $idReporte, $NombreCompleto, $idEstacion, $FechaBaja, $Motivo, $Detalle2);
        if (!$result->execute()) :
        $resultado = false;
        throw new Exception("Error al ejecutar la consulta". $result->error);
        endif;
    
        $result->close();
        return $resultado;
    }

    public function eliminarBajaPersonal(int $idUsuario) : bool {
    $resultado = true;
        $sql = "DELETE FROM op_rh_formatos_baja WHERE id = ? ";
        $result = $this->con->prepare($sql);
        $result->bind_param("i",$idUsuario);
        $result->execute();
        $result->close();
        return $resultado;
    }  


    private function editarStatusPersonal($idEstacion, $idPersonal, $fecha_baja, $motivo, $detalle)
    {
    
    $sql = "UPDATE op_rh_personal SET estado = 0 WHERE id = '".$idPersonal."' ";
    
    if(mysqli_query($this->con, $sql)){
    $resultado = $this->BajaPersonal($idEstacion, $idPersonal, $fecha_baja, $motivo, $detalle);
    
    }else{
    $resultado = false;
    }
            
    return $resultado;
    }
        


    private function BajaPersonal($idEstacion, $idPersonal, $fecha_baja, $motivo, $detalle) : bool
    {
        $resultado = true;
        $estado = 0;
        $sql_insert = "INSERT INTO op_rh_personal_baja (id_personal,fecha_baja,motivo,detalle,estado_proceso)
        VALUES  (?,?,?,?,?)";
        $result = $this->con->prepare($sql_insert);
        if (!$result):
            throw new Exception("Error al preparar la consulta \n" . $this->con->error);
        endif;
        $result->bind_param("isssi", $idPersonal,$fecha_baja, $motivo, $detalle, $estado);
        if (!$result->execute()):
            $resultado = false;
            throw new Exception("Error al ejecutar la consulta \n" . $result->error);
        endif;
        $result->close();
        return $resultado;
    }



    
    //---------- 3. FALTA DEL PERSONAL ----------//
    public function guardarFaltaPersonal(int $idReporte, int $idEstacion, string $NombreCompleto, string $FechaFalta): bool{
    
        $resultado = true;
        $sql = "INSERT INTO op_rh_formatos_falta (
        id_formulario, id_personal, id_estacion, dias_falta) VALUES (?,?,?,?)";
                
        $result = $this->con->prepare($sql);
        if (!$result) :
        throw new Exception("Error al preparar la consulta \n". $this->con->error);
        endif;
    
        $result->bind_param("iiis", $idReporte, $idEstacion, $idEstacion, $FechaFalta);
        if (!$result->execute()) :
        $resultado = false;
        throw new Exception("Error al ejecutar la consulta". $result->error);
        endif;
        
        $result->close();
        return $resultado;
        }

 

        public function eliminarFaltaPersonal(int $idUsuario) : bool {
            $resultado = true;
                $sql = "DELETE FROM op_rh_formatos_falta WHERE id = ? ";
                $result = $this->con->prepare($sql);
                $result->bind_param("i",$idUsuario);
                $result->execute();
                $result->close();
                return $resultado;
            }  


    //---------- 4. REESTRUCTURACIÓN DE PERSONAL ----------//
    public function guardarReestructuracionPersonal(int $idReporte, int $idEstacion, string $NombreCompleto, string $NombreEstacion, string $FechaAplicacion): bool{
        $resultado = true;
        $sql = "INSERT INTO op_rh_formatos_restructuracion (
        id_formulario, id_personal, id_estacion, id_estacion_cambio, fecha) VALUES (?,?,?,?,?)";
            
        $result = $this->con->prepare($sql);
        if (!$result) :
        throw new Exception("Error al preparar la consulta \n". $this->con->error);
        endif;

        $result->bind_param("iiiis", $idReporte, $NombreCompleto, $idEstacion, $NombreEstacion, $FechaAplicacion);
        if (!$result->execute()) :
        $resultado = false;
        throw new Exception("Error al ejecutar la consulta". $result->error);
        endif;
    
        $result->close();
        return $resultado;
    }


    public function eliminarReestructuracionPersonal(int $idUsuario) : bool {
        $resultado = true;
            $sql = "DELETE FROM op_rh_formatos_restructuracion WHERE id = ? ";
            $result = $this->con->prepare($sql);
            $result->bind_param("i",$idUsuario);
            $result->execute();
            $result->close();
            return $resultado;
        }  


    private function finalizarReestructuracionPersonal($idPersonal, $idEstacionCambio)
    {
    
    $sql = "UPDATE op_rh_personal SET id_estacion = '".$idEstacionCambio."' WHERE id = '".$idPersonal."' ";
    if(mysqli_query($this->con, $sql)){
    $resultado = true;

    }else{
    $resultado = false;
    }
            
    return $resultado;
    }



    //---------- 5. AJUSTE SALARIAL ----------//
    public function guardarAjusteSalarial(int $idReporte, int $idEstacion, string $NombreCompleto, string $AjusteSalario, string $FechaAplicacion): bool{
    
    $datosPersonal = $this->formato->obtenerDatosPersonal($NombreCompleto);
    $salario_actual = $datosPersonal['salario']; 

    $resultado = true;
    $sql = "INSERT INTO op_rh_formatos_ajuste_salarial (
    id_formulario, id_personal, id_estacion, salario_actual, salario_ajustado, fecha_aplicacion) VALUES (?,?,?,?,?,?)";
            
    $result = $this->con->prepare($sql);
    if (!$result) :
    throw new Exception("Error al preparar la consulta \n". $this->con->error);
    endif;

    $result->bind_param("iiidds", $idReporte, $NombreCompleto, $idEstacion, $salario_actual, $AjusteSalario, $FechaAplicacion);
    if (!$result->execute()) :
    $resultado = false;
    throw new Exception("Error al ejecutar la consulta". $result->error);
    endif;
    
    $result->close();
    return $resultado;
    }

    public function eliminarAjusteSalarial(int $idUsuario) : bool {
    $resultado = true;
    $sql = "DELETE FROM op_rh_formatos_ajuste_salarial WHERE id = ? ";
    $result = $this->con->prepare($sql);
    $result->bind_param("i",$idUsuario);
    $result->execute();
    $result->close();
    return $resultado;
    }  


    private function finalizarAjusteSalarial($idPersonal, $salario_ajustado){
    
    $sql = "UPDATE op_rh_personal SET sd = '".$salario_ajustado."' WHERE id = '".$idPersonal."' ";
    if(mysqli_query($this->con, $sql)){
    $resultado = true;

    }else{
    $resultado = false;
    }
    
    return $resultado;
    }


    //---------- 6. VACACIONES DE PERSONAL ----------//
    public function guardarVacacionesPersonal(int $idReporte, int $Personal, int $NumDias, string $FechaInicio, string $FechaTermino, string $FechaRegreso, string $Observaciones): bool{
    
        $resultado = true;
        $sql = "INSERT INTO op_rh_formatos_vacaciones (
        id_formulario, id_usuario, num_dias, fecha_inicio, fecha_termino, fecha_regreso, observaciones) VALUES (?,?,?,?,?,?,?)";
                
        $result = $this->con->prepare($sql);
        if (!$result) :
        throw new Exception("Error al preparar la consulta \n". $this->con->error);
        endif;
    
        $result->bind_param("iiissss", $idReporte,$Personal, $NumDias, $FechaInicio, $FechaTermino, $FechaRegreso, $Observaciones);
        if (!$result->execute()) :
        $resultado = false;
        throw new Exception("Error al ejecutar la consulta". $result->error);
        endif;
        
        $result->close();
        return $resultado;
        }


    public function eliminarVacacionesPersonal(int $idUsuario) : bool {
    $resultado = true;
    $sql = "DELETE FROM op_rh_formatos_vacaciones WHERE id = ? ";
    $result = $this->con->prepare($sql);
    $result->bind_param("i",$idUsuario);
    $result->execute();
    $result->close();
    return $resultado;
    }  

    //---------- 7. PRIMA VACACIONAL ----------//
    public function guardarPrimaVacacional($idReporte, $idEstacion, $NombresCompleto, $Periodo): bool{
    $resultado = true;
    $sql = "INSERT INTO op_rh_formatos_prima_vacacional (
    id_formulario, id_personal, id_estacion, periodo) VALUES (?,?,?,?)";
                
    $result = $this->con->prepare($sql);
    if (!$result) :
    throw new Exception("Error al preparar la consulta \n". $this->con->error);
    endif;

                
    $result->bind_param("iiii", $idReporte, $NombresCompleto, $idEstacion, $Periodo);
    if (!$result->execute()) :
    $resultado = false;
    throw new Exception("Error al ejecutar la consulta". $result->error);
    endif;
        
    $result->close();
    return $resultado;
    }



    public function eliminarPrimaVacacional(int $idUsuario) : bool {
        $resultado = true;
        $sql = "DELETE FROM op_rh_formatos_prima_vacacional WHERE id = ? ";
        $result = $this->con->prepare($sql);
        $result->bind_param("i",$idUsuario);
        $result->execute();
        $result->close();
        return $resultado;
        }  


    //---------- fIRMA DE FORMATOS ----------//
    public function firmaFormatos($idReporte, $idUsuario, $tipoFirma, $img): bool
    {
    $resultado = true;
    $status = 3;
    if ($tipoFirma == "A") {
    $status = 1;
    }

    $aleatorio = uniqid();
    $imagenGuardar = str_replace('data:image/png;base64,', '', $img);
    $fileData = base64_decode($imagenGuardar);
    $fileName = $aleatorio . '.png';
    
    if (file_put_contents('../../../imgs/firma/' . $fileName, $fileData)) {
    $sql = "INSERT INTO op_rh_formatos_firma (id_formato, id_usuario, tipo_firma, firma) VALUES (?,?,?,?)";
        $result = $this->con->prepare($sql);
        if (!$result):
          throw new Exception("Error al preparar la consulta \n" . $this->con->error);
        endif;
        $result->bind_param("iiss", $idReporte, $idUsuario, $tipoFirma, $fileName);
        if (!$result->execute()):
          $resultado = false;
          throw new Exception("Error al ejecutar la consulta" . $result->error);
        endif;
        $result->close();
  
        $sql2 = "UPDATE op_rh_formatos SET status = ? WHERE id = ? ";
        $result2 = $this->con->prepare($sql2);
        if (!$result2):
          throw new Exception("Error al preparar la consulta \n" . $this->con->error);
        endif;
        $result2->bind_param("ii", $status, $idReporte);
        if (!$result2->execute()):
          $resultado = true;
          throw new Exception("Error al ejecutar la consulta" . $result2->error);
        endif;
        $result2->close();
      }
  
      return $resultado;
    }


    public function firmaFormatosToken($idFormato, $idVal, $idUsuario, $tokenWhats, $idTipo): bool
    {
        $resultado = true;
        $sql = "DELETE FROM op_rh_formatos_token WHERE id_formato = ? AND id_usuario = ? ";
        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta\n" . $this->con->error);
        endif;
        $stmt->bind_param("ii", $idFormato, $idUsuario);
        if (!$stmt->execute()):
            $resultado = false;
            throw new Exception("Error al ejecutar la consulta\n" . $stmt->error);
        endif;
        $stmt->close();
        $aleatorio = rand(100000, 999999);
        $sql2 = "INSERT INTO op_rh_formatos_token (
                id_formato,
                id_usuario,
                token)
                VALUES 
                (?,?,?)";
        $stmt2 = $this->con->prepare($sql2);
        if (!$stmt2):
            throw new Exception("Error al preparar la consulta\n" . $this->con->error);
        endif;
        $stmt2->bind_param("iii", $idFormato, $idUsuario, $aleatorio);
        if (!$stmt2->execute()):
            $resultado = false;
            throw new Exception("Error al ejecutar la consulta\n" . $stmt2->error);
        endif;
        $stmt2->close();
        $numero = $this->numero($idUsuario);
        if ($idVal == 1) {
            $this->altiriaSMS->setLogin('sistemas.admongas@gmail.com');
            $this->altiriaSMS->setPassword('hy8q4c7y');
            $this->altiriaSMS->setSenderId('AdmonGas');
            $sDestination = '52' . $numero;
            $response = $this->altiriaSMS->sendSMS($sDestination, "AdmonGas: Usa el siguiente token para firmar el formato " . $idTipo . " solicitado. Token: " . $aleatorio . " Web: portal.admongas.com.mx");

        } elseif ($idVal == 2) {
            $this->notificacionesWA($numero, $aleatorio, $tokenWhats);
        } elseif ($idVal == 3) {
            $mensaje = "Usa el siguiente token para firmar la solicitud de cheque: " . $aleatorio;
            $this->telegram->enviarToken($idUsuario, $mensaje);
        }
        return $resultado;
    }



    function CorreoE($IDUsuarioBD){
        $sql = "SELECT email FROM tb_usuarios WHERE id = '".$IDUsuarioBD."' ";
        $result = mysqli_query($this->con, $sql);
        $numero = mysqli_num_rows($result);
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $email = $row['email'];
        }
        return $email;
        }


    public function firmaFormatosTokenEmail($idFormato, $idUsuario)
    {

    $sql = "DELETE FROM op_rh_formatos_token WHERE id_formato = '" . $idFormato . "' AND id_usuario = '" . $idUsuario . "' ";
    
    if (mysqli_query($this->con, $sql)) {
        $aleatorio = rand(100000, 999999);
    
        $sql_insert = "INSERT INTO op_rh_formatos_token (
            id_formato,
            id_usuario,
            token 
        ) VALUES ( 
            '" . $idFormato . "',
            '" . $idUsuario . "',
            '" . $aleatorio . "'
        )";
    
        if (mysqli_query($this->con, $sql_insert)) {
            try {
                $Email = $this->CorreoE($idUsuario);
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
                $mail->Body = 'AdmonGas: Usa el siguiente token para firmar el formato solicitado. Token: <b>' . $aleatorio . '</b>';
    
                // Envío del correo
                if ($mail->send()) { 
                    return true;
                } else {
                    return false;
                } 
            } catch (Exception $e) {
                echo "Error en el envío de correo: {$e->getMessage()}";
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
    
    }

    function numero($idUsuario): string
    {
        $tel = '';
        $sql = "SELECT telefono FROM tb_usuarios WHERE id = ? ";
        $stmt2 = $this->con->prepare($sql);
        if (!$stmt2):
            throw new Exception("Error al preparar la consulta\n" . $this->con->error);
        endif;
        $stmt2->bind_param("i", $idUsuario);
        if (!$stmt2->execute()):
            throw new Exception("Error al ejecutar la consulta\n" . $stmt2->error);
        endif;
        $stmt2->bind_result($tel);
        $stmt2->fetch();
        $stmt2->close();
        return $tel;
    }
    function notificacionesWA($Numero, $aleatorio, $token)
    {
        $telefono = '52'.$Numero;

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


  public function firmarMartin($tipoFirma, $idFormato, $idUsuario, $token): bool
  {
      $resultado = true;
      $localidad = 0;
      $formato = 0;
      $estado = 3;
      if ($tipoFirma == "B") {
      $estado = 2;
      }

      $sql = "SELECT id_localidad, formato FROM op_rh_formatos WHERE id = ?";
      $result = $this->con->prepare($sql);
      if (!$result):
          throw new Exception("Error al preparar la consulta: " . $this->con->error);
      endif;
      $result->bind_param("i", $idFormato);
      if (!$result->execute()):
          $resultado = false;
          throw new Exception("Error al ejecutar la consulta: " . $result->error);
      endif;
      $result->bind_result($localidad, $formato);
      $result->fetch();
      $result->close();
      // Preparar la consulta
      $sql2 = "SELECT * FROM op_rh_formatos_token WHERE id_formato = ? AND id_usuario = ? AND token = ? ORDER BY id ASC LIMIT 1";
      $stmt2 = $this->con->prepare($sql2);

      if (!$stmt2) {
        $resultado = false;
          throw new Exception("Error al ejecutar la consulta: " . $stmt2->error);
      }
      $stmt2->bind_param("iii", $idFormato, $idUsuario, $token);

      $stmt2->execute();
      $result2 = $stmt2->get_result();
      $numero = $result2->num_rows;
      $stmt2->close();

    if ($numero == 1):
    
    if ($formato == 1 && $tipoFirma == "B") {
    $sql_lista = "SELECT * FROM op_rh_formatos_alta WHERE id_formulario = ?";
    $stmt_lista =  $this->con->prepare($sql_lista);
    $stmt_lista->bind_param("i", $idFormato);
    $stmt_lista->execute();
    $result_lista = $stmt_lista->get_result();
    
    while ($row_lista = $result_lista->fetch_assoc()) {
    $idEstacion = $row_lista['id_estacion'];
    $fecha = $row_lista['fecha_ingreso'];
    $nombre = $row_lista['nombre'];
    $puesto = $row_lista['puesto'];
    $salario = $row_lista['sd'];

    $this->altaPersonal($idEstacion, $fecha, $nombre, $puesto, $salario);
    }

 
    }else if ($formato == 2 && $tipoFirma == "B") {
    $sql_lista = "SELECT * FROM op_rh_formatos_baja WHERE id_formulario = ?";
    $stmt_lista =  $this->con->prepare(query: $sql_lista);
    $stmt_lista->bind_param("i", $idFormato);
    $stmt_lista->execute();
    $result_lista = $stmt_lista->get_result();

    while ($row_lista = $result_lista->fetch_assoc()) {
    $idEstacion = $row_lista['id_estacion'];
    $idPersonal = $row_lista['id_personal'];
    $fecha_baja = $row_lista['fecha_baja'];
    $motivo = $row_lista['motivo'];
    $detalle = $row_lista['detalle'];

    $this->editarStatusPersonal($idEstacion, $idPersonal, $fecha_baja, $motivo, $detalle);
    }

    }else if ($formato == 4 && $tipoFirma == "B") {
    $sql_lista = "SELECT id_personal, id_estacion_cambio FROM op_rh_formatos_restructuracion WHERE id_formulario = ?";
    $stmt_lista =  $this->con->prepare(query: $sql_lista);
    $stmt_lista->bind_param("i", $idFormato);
    $stmt_lista->execute();
    $result_lista = $stmt_lista->get_result();

    while ($row_lista = $result_lista->fetch_assoc()) {
    $idPersonal = $row_lista['id_personal'];
    $idEstacionCambio = $row_lista['id_estacion_cambio'];

    $this->finalizarReestructuracionPersonal($idPersonal, $idEstacionCambio);
    }

        
    }else if ($formato == 5 && $tipoFirma == "B") {
    $sql_lista = "SELECT id_personal, salario_ajustado FROM op_rh_formatos_ajuste_salarial WHERE id_formulario = ?";
    $stmt_lista =  $this->con->prepare(query: $sql_lista);
    $stmt_lista->bind_param("i", $idFormato);
    $stmt_lista->execute();
    $result_lista = $stmt_lista->get_result();
    
    while ($row_lista = $result_lista->fetch_assoc()) {
    $idPersonal = $row_lista['id_personal'];
    $salario_ajustado = $row_lista['salario_ajustado'];
    
    $this->finalizarAjusteSalarial($idPersonal, $salario_ajustado);
    }

    }

    $this->actualizaEstatus($estado,$idFormato,$tipoFirma,$idUsuario);

    else:
    $resultado = false;
    endif;
    return $resultado;
  }


  private function actualizaEstatus($estado,$idFormato,$tipoFirma,$idUsuario): bool{
      $resultado = true;
      $firma = "Firma: " . bin2hex(random_bytes(64)) . "." . uniqid();
      $sql = "UPDATE op_rh_formatos SET status = ? WHERE id = ? ";
      $result = $this->con->prepare($sql);
      if(!$result):
          throw new Exception("Error al preparar la consulta \n" . $this->con->error);
      endif;
      $result->bind_param("ii",$estado,$idFormato);
      if (!$result->execute()):
          $resultado = false;
          throw new Exception("Error al ejecutar la consulta \n" . $result->error);
      endif;
      $result->close();

      $sql2 = "INSERT INTO op_rh_formatos_firma (id_formato,id_usuario,tipo_firma,firma) VALUES (?,?,?,?)";
      $result2 = $this->con->prepare($sql2);
      if(!$result2):
          throw new Exception("Error al preparar la consulta \n" . $this->con->error);
      endif;
      $result2->bind_param("iiss",$idFormato,$idUsuario,$tipoFirma,$firma);
      if (!$result2->execute()):
          $resultado = false;
          throw new Exception("Error al ejecutar la consulta \n" . $result2->error);
      endif;

      $result2->close();
      return $resultado;
  }


    public function agregarComentarioFormato(int $idFormato, int $idUsuario, string $Comentario): bool
    {
    $result = true;
    $sql_insert = "INSERT INTO op_recibo_formatos_comentarios (id_formato,id_usuario,comentario) VALUES (?,?,?)";
    $stmt = $this->con->prepare($sql_insert);
    if(!$stmt) :
    $result = false;
    throw new Exception("Error al preparar la consulta ". $stmt->error);
    endif;

    $stmt->bind_param("iis", $idFormato,$idUsuario,$Comentario);
    if(!$stmt->execute()) :
    $result = false;
    throw new Exception("Error al ejecutar la consulta". $this->con->error);
    endif;

    $stmt->close();
    return $result;
    }
    



    
    public function eliminarFormato(int $idReporte) : bool {
        $resultado = true;
        $sql = "DELETE FROM op_rh_formatos WHERE id = ? ";
        $result = $this->con->prepare($sql);
        $result->bind_param("i",$idReporte);
        $result->execute();
        $result->close();
        return $resultado;
        }  



  }