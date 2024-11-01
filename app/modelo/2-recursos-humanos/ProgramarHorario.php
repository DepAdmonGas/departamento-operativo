<?php
require "../../bd/inc.conexion.php";
require "../../modelo/httpPHPAltiria.php";
require_once '../../modelo/HerramientasDptoOperativo.php';
require '../../../phpmailer/vendor/autoload.php';
require '../../modelo/tokenTelegram.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Horarios extends Exception
{
    private $classConexionBD;
    private $con;
    private $herramientasDptoOperativo;
    private $altiriaSMS;
    private $formato;
    private $telegram;


    public function __construct()
    {
        $this->classConexionBD = Database::getInstance();
        $this->con = $this->classConexionBD->getConnection();
        $this->herramientasDptoOperativo = new herramientasDptoOperativo($this->con);
        $this->con = $this->classConexionBD->getConnection();
        $this->altiriaSMS = new AltiriaSMS();
        $this->formato = new herramientasDptoOperativo($this->con);
        $this->telegram = new Telegram($this->con);

    }
    public function agregarHorario(int $idEstacion): int
    { 
        $id = $this->id();
        $estado = 0;
        $sql = "INSERT INTO op_rh_personal_horario_programar (id,id_estacion,estado)
            VALUES (?,?,?)";
        $stmt = $this->con->prepare($sql);
        if(!$stmt):
            throw new Exception("Error al preparar la consulta".$this->con->error);
        endif;
        $stmt->bind_param("iii",$id,$idEstacion,$estado);
        if (!$stmt->execute()) :
            $id = 0;
            throw new Exception("Error al ejecutar la consulta".$stmt->error);
        endif;
        return $id;
    }
    private function id() : int{
        $numid = 1;
        $sql = "SELECT id FROM op_rh_personal_horario_programar ORDER BY id DESC LIMIT 1";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $numero = $result->num_rows;
        if ($numero != 0) :
            $row = $result->fetch_assoc();
            $numid = $row['id'] + 1;
        endif;
        $stmt->close();
        return $numid;
    }
    public function eliminaHorario(int $idReporte): bool {
        $result = true;
        $sql = "DELETE FROM op_rh_personal_horario_programar WHERE id = ? ";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i",$idReporte);
        if(!$stmt->execute()):
            $result = false;
            throw new Exception("Error al ejecutar la consulta".$stmt->error);
        endif;
        $stmt->close();
        return $result;
    }
    public function guardarHorario(string $fecha, int $idReporte) : bool {
        $result = true;
        $estado = 1;
        $sql = "UPDATE op_rh_personal_horario_programar SET fecha = ?,estado = ? WHERE id = ? ";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("sii",$fecha,$estado,$idReporte);
        if(!$stmt->execute()):
            $result = false;
            throw new Exception("Error al ejecuar la consulta",$stmt->error);
        endif;
        return $result;
    }
    public function editarEstacion(string $hora,int $dia,int $idPersonal,int $idReporte,int $idEstacion):bool{
        $resultado = true;
        $sql = "SELECT id_estacion FROM op_rh_personal WHERE id = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param("i",$idPersonal);
        $result->execute();
        $result->bind_result($idEstacionConsulta);
        $result->fetch();
        $result->close();
        $idEstacionHorario = $idEstacionConsulta;
        if ($idEstacionConsulta == 9) :
            $idEstacionHorario = 2;
        endif;

        $NomDia = $this->nombreDia($dia);
        $HoraEntrada = "00:00:00";
        $HoraSalida = "00:00:00";
        if ($hora != "Descanso") :
            $sql = "SELECT hora_entrada,hora_salida FROM op_rh_localidades_horario WHERE id_estacion = ? AND titulo = ? ";
            $result = $this->con->prepare($sql);
            $result->bind_param("is",$idEstacionHorario,$hora);
            $result->execute();
            $result->bind_result($HoraEntrada,$HoraSalida);
            $result->fetch();
            $result->close();
        endif;
        $sql1 = "SELECT * FROM op_rh_personal_horario_programar_detalle WHERE id_reporte = ? AND id_personal = ? AND dia = ? ";
        $stmt = $this->con->prepare($sql1);
        $stmt->bind_param("iis",$idReporte,$idPersonal,$NomDia);
        $stmt->execute();
        $stmt->store_result();
        $stmt->fetch();
        $numero1 = $stmt->num_rows;
        $stmt->close();
        if ($numero1 > 0) :
            $sql2 = "UPDATE op_rh_personal_horario_programar_detalle SET 
            horario = ?,
            hora_entrada = ?,
            hora_salida = ? WHERE id_reporte = ? AND id_personal =? AND dia = ? ";
            $stmt = $this->con->prepare($sql2);
            $stmt->bind_param("sssiis",$hora,$HoraEntrada,$HoraSalida,$idReporte,$idPersonal,$NomDia);
            if(!$stmt->execute()):
                $resultado =  false;
                throw new Exception("Error al ejecutar la consulta de actualizacion".$stmt->error);
            endif;
            $stmt->close();
        else :
            $sql_insert = "INSERT INTO op_rh_personal_horario_programar_detalle  (
                id_reporte,
                id_estacion,
                id_personal,
                horario,
                dia,
                hora_entrada,
                hora_salida
                )VALUES (?,?,?,?,?,?,?)";
            $stmt = $this->con->prepare($sql_insert);
            $stmt->bind_param("iiissss",$idReporte,$idEstacion,$idPersonal,$hora,$NomDia,$HoraEntrada,$HoraSalida);
            if(!$stmt->execute()):
                $resultado = false;
                throw new Exception("Error al insertar la consulta".$stmt->error);
            endif;
            $stmt->close();
        endif;
        return $resultado;
    }
    private function nombreDia($dia): string{
        $result = "";
        switch($dia):
            case 1:
                $result = "Lunes";
                break;
            case 2:
                $result = "Martes";
                break;
            case 3:
                $result = "Miércoles";
                break;
            case 4:
                $result = "Jueves";
                break;
            case 5:
                $result = "Viernes";
                break;
            case 6:
                $result = "Sábado";
                break;
            case 7:
                $result = "Domingo";
                break;
        endswitch;
        return $result;
    }
    /**
     * 
     * Horario Personal
     * 
     * 
     */
    public function editarHorarioPersonal(string $horario,int $dia,int $idPersonal):bool {
        $resultado = true;
        $sql = "SELECT id_estacion FROM op_rh_personal WHERE id = ? ";
        $stmt1 = $this->con->prepare($sql);
        $stmt1->bind_param("i",$idPersonal);
        if(!$stmt1->execute()):
            throw new Exception("Error al ejecutar la consulta id estacion".$stmt1->error);
        endif;
        $stmt1->bind_result($idEstacion);
        $stmt1->fetch();
        $stmt1->close();
        $idEstacionHorario = $idEstacion;
        if ($idEstacion == 9) :
            $idEstacionHorario = 2;
        endif;
        $NomDia = $this->nombreDia($dia);
        $HoraEntrada = "00:00:00";
        $HoraSalida = "00:00:00";
        if ($horario != "Descanso"):
            $sql = "SELECT hora_entrada,hora_salida FROM op_rh_localidades_horario WHERE id_estacion = ? AND titulo = ? ";
            $result = $this->con->prepare($sql);
            $result->bind_param("is",$idEstacionHorario,$horario);
            if(!$result->execute()):
                throw new Exception("Error al ejecutar la consulta horario".$result->error);
            endif;
            $result->bind_result($HoraEntrada,$HoraSalida);
            $result->fetch();
            $result->close();
        endif;
        $sql1 = "SELECT * FROM op_rh_personal_horario WHERE id_estacion = ? AND id_personal = ? AND dia = ? ";
        $result1 = $this->con->prepare($sql1);
        $result1->bind_param("iis",$idEstacion,$idPersonal,$NomDia);
        $result1->execute();
        $result1->store_result();
        $numero1 = $result1->num_rows;
        $result1->close();
        if ($numero1 > 0) :
            $sql_update= "UPDATE op_rh_personal_horario SET horario = ?,hora_entrada = ?,hora_salida = ?
                        WHERE id_estacion =? AND id_personal =? AND dia = ? ";
            $consulta = $this->con->prepare($sql_update);
            $consulta->bind_param("sssiis",$horario,$HoraEntrada,$HoraSalida,$idEstacion,$idPersonal,$NomDia);
            if(!$consulta->execute()):
                $resultado = false;
                throw new Exception("Error al ejecuar consulta Update".$consulta->error);
            endif;
            $consulta->close();
        else:
            $sql_insert = "INSERT INTO op_rh_personal_horario  (
                id_estacion,
                id_personal,
                horario,
                dia,
                hora_entrada,
                hora_salida
                    )
                    VALUES 
                    (?,?,?,?,?,?)";
            $consulta = $this->con->prepare($sql_insert);
            $consulta->bind_param("iissss",$idEstacion,$idPersonal,$horario,$NomDia,$HoraEntrada,$HoraSalida);
            if(!$consulta->execute()):
                $resultado = false;
                throw new Exception("Error al ejecutar consulta Insert".$consulta->error);
            endif;
            $consulta->close();
        endif;
        return $resultado;
    }

    //---------- ROL DE COMODINES ---------- //
    private function idComodines() : array {
        $numid = 1;
        $status = null;  // Cambiamos a null para identificar si hay registros o no
    
        // Consulta el último registro
        $sql = "SELECT id, status FROM op_rh_rol_comodines ORDER BY id DESC LIMIT 1";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $numero = $result->num_rows;
    
        // Verifica si hay resultados
        if ($numero != 0) {
            $row = $result->fetch_assoc();
            $numid = $row['id'];  // Último id existente
            $status = $row['status'];  // Último status
        }
    
        $stmt->close();
    
        // Devuelve el id y el status como array
        return ['id' => $numid, 'status' => $status];
    }
    
    public function agregarFormularioComodines($idEstacion) {
        // Obtiene el último id y su status
        $datos = $this->idComodines();
        
        // Si no hay registros en la tabla, id será 1
        $id = ($datos['status'] === null) ? 1 : $datos['id'] + 1;
        $estado = 0;
    
        // Si no hay registros, procede a insertar directamente el primer valor
        if ($datos['status'] !== null && $datos['status'] == 0) {
            // Si el status del último registro es 0, no se inserta y se devuelve ese id
            return $datos['id'];
        }
    
        // Si no hay registros o el status es diferente de 0, hace el insert
        $sql = "INSERT INTO op_rh_rol_comodines (id, id_estacion, status) VALUES (?, ?, ?)";
        $stmt = $this->con->prepare($sql);
    
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $this->con->error);
        }
    
        $stmt->bind_param("iii", $id, $idEstacion, $estado);
    
        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }
    
        $stmt->close();
        return $id;  // Devuelve el id del nuevo registro
    }
    
    public function editarEstacionComodines($idReporte, $idUsuario, $idEstacion, $dia){
    $resultado = false;

    $NomDia = $this->herramientasDptoOperativo->get_nombre_dia2($dia);

    $sql_estacion = "SELECT * FROM op_rh_comodines_dia WHERE id_reporte = '" . $idReporte . "' AND id_usuario = '" . $idUsuario . "' AND dia = '".$NomDia."' ";
    $result_estacion = mysqli_query($this->con, $sql_estacion);
    $numero_estacion = mysqli_num_rows($result_estacion);


    if ($numero_estacion > 0) {
    $sql2 = "UPDATE op_rh_comodines_dia SET id_estacion = '".$idEstacion."' 
    WHERE id_reporte = '" . $idReporte . "' AND id_usuario = '".$idUsuario."' AND dia = '".$NomDia."'";

    if(mysqli_query($this->con, $sql2)){
    $resultado = true;
    } 

    }else{

    $sql_insert = "INSERT INTO op_rh_comodines_dia  (
    id_reporte,
    id_usuario,
    id_estacion,
    dia
    )
    VALUES 
    (
    '".$idReporte."',
    '".$idUsuario."',
    '".$idEstacion."',
    '".$NomDia."'
    )";
            
    if(mysqli_query($this->con, $sql_insert)){
    $resultado = true;
    }

    }

    return $resultado;
    }


    public function finalizarRolComodines($idReporte, $fechaInicio, $fechaTermino){
    $resultado = false;
    $status = 1;

    $sql2 = "UPDATE op_rh_rol_comodines SET fecha_inicio = '".$fechaInicio."', fecha_fin = '".$fechaTermino."', status = '".$status."'
    WHERE id = '".$idReporte."' ";

    if(mysqli_query($this->con, $sql2)){
    $resultado = true;
    } 

    return $resultado;

    }


    /** ---------- DIAS DOBLES ---------- **/
    private function idDiaDobleDO() : int {
    $numid = 1;
    $sql = "SELECT id FROM op_rh_dia_doble_registro ORDER BY id DESC LIMIT 1";
    $stmt = $this->con->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $numero = $result->num_rows;
    if ($numero != 0) :
      $row = $result->fetch_assoc();
      $numid = $row['id'] + 1;
    endif;
    $stmt->close();
    return $numid;
    }


    public function agregarDiaDobleOP($year, $quincena){
    $idReporte = $this->idDiaDobleDO();
    $estado = 0;

    $sql = "INSERT INTO op_rh_dia_doble_registro (id,year,quincena,status)
    VALUES (?,?,?,?)";
    $stmt = $this->con->prepare($sql);
    if(!$stmt):
    throw new Exception("Error al preparar la consulta".$this->con->error);
    endif;
    $stmt->bind_param("iiii",$idReporte,$year,$quincena,$estado);
    if (!$stmt->execute()) :
        $idReporte = 0;
        throw new Exception("Error al ejecutar la consulta".$stmt->error);
    endif;
    return $idReporte;
    }



    function editarQuincenaDiaDoble($idReporte, $quincena){
    $result = true;

    $sql = "UPDATE op_rh_dia_doble_registro SET quincena = ? WHERE id = ? ";
    $stmt = $this->con->prepare($sql);
    $stmt->bind_param("ii",$quincena,$idReporte);
    if(!$stmt->execute()):
    $result = false;
    throw new Exception("Error al ejecuar la consulta",$stmt->error);
    endif;
    return $result;

    }

    function agregarDiaDoblePersonal($idReporte, $NombreCompleto, $FechaDiaDoble){
    $result = true;

    $sql = "INSERT INTO op_rh_dia_doble_personal (id_registro,id_usuario,fecha_doble) VALUES (?,?,?)";   
    $stmt = $this->con->prepare($sql);
    $stmt->bind_param("iis",$idReporte,$NombreCompleto, $FechaDiaDoble);
    if(!$stmt->execute()):
    $result = false;
    throw new Exception("Error al ejecuar la consulta",$stmt->error);
    endif;
    return $result;

    }


    function eliminarHorarioPersonal($id){

    $result = true;
    $sql = "DELETE FROM op_rh_dia_doble_personal WHERE id = ? ";
    $stmt = $this->con->prepare($sql);
    $stmt->bind_param("i",$id);
    if(!$stmt->execute()):
    $result = false;
    throw new Exception("Error al ejecutar la consulta".$stmt->error);
    endif;
    $stmt->close();
    return $result; 
    }

    function eliminarHorarioFormato($id){

        $result = true;
        $sql = "DELETE FROM op_rh_dia_doble_registro WHERE id = ? ";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i",$id);
        if(!$stmt->execute()):
        $result = false;
        throw new Exception("Error al ejecutar la consulta".$stmt->error);
        endif;
        $stmt->close();
        return $result; 
    }

    //---------- FIRMA DIA DOBLE ----------//
    public function firmaDiaDoble($idReporte, $idUsuario, $tipoFirma, $img): bool
    {
    $resultado = true;
    $status = 1;

    $aleatorio = uniqid();
    $imagenGuardar = str_replace('data:image/png;base64,', '', $img);
    $fileData = base64_decode($imagenGuardar);
    $fileName = $aleatorio . '.png';
    
    if (file_put_contents('../../../imgs/firma/' . $fileName, $fileData)) {
    $sql = "INSERT INTO op_rh_dias_dobles_firma (id_formato, id_usuario, tipo_firma, firma) VALUES (?,?,?,?)";
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
  
        $sql2 = "UPDATE op_rh_dia_doble_registro SET status = ? WHERE id = ? ";
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


    public function firmaFormatosToken($idFormato,$idVal,$idUsuario,$tokenWhats,$fecha){

        $resultado = true;
        $sql = "DELETE FROM op_rh_dia_doble_token WHERE id_formato = ? AND id_usuario = ? ";
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
        $sql2 = "INSERT INTO op_rh_dia_doble_token (
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
       
        if ($idVal == 3) {
        $mensaje = "Para proceder con la firma del formato de dia doble con fecha: *$fecha*
			
		Usa el siguiente token: *$aleatorio*";      

        $this->telegram->enviarToken($idUsuario, $mensaje);

        }
        return $resultado;
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


    public function firmaFormatosTokenEmail($idFormato, $idUsuario)
    {

    $sql = "DELETE FROM op_rh_dia_doble_token WHERE id_formato = '" . $idFormato . "' AND id_usuario = '" . $idUsuario . "' ";
    
    if (mysqli_query($this->con, $sql)) {
        $aleatorio = rand(100000, 999999);
    
        $sql_insert = "INSERT INTO op_rh_dia_doble_token (
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


    function CorreoE($IDUsuarioBD){
        $sql = "SELECT email FROM tb_usuarios WHERE id = '".$IDUsuarioBD."' ";
        $result = mysqli_query($this->con, $sql);
        $numero = mysqli_num_rows($result);
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $email = $row['email'];
        }
        return $email;
        }


        public function firmarMartin($tipoFirma, $idFormato, $idUsuario, $token): bool
        { 
            $resultado = true;
            
            if ($tipoFirma == "B") {
            $estado = 2;
            }else if($tipoFirma == "C"){
            $estado = 3;
            }
      
            $sql2 = "SELECT * FROM op_rh_dia_doble_token WHERE id_formato = ? AND id_usuario = ? AND token = ? ORDER BY id ASC LIMIT 1";
            $stmt2 = $this->con->prepare($sql2);
      
            if (!$stmt2) {
              $resultado = false;
                throw new Exception("Error al ejecutar la consulta: " . $this->con->error);
            }
            $stmt2->bind_param("iii", $idFormato, $idUsuario, $token);
      
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            $numero = $result2->num_rows;
            $stmt2->close();
      
          if ($numero == 1):
          $this->actualizaEstatus($estado,$idFormato,$tipoFirma,$idUsuario);
      
          else:
          $resultado = false;
          endif;
          return $resultado;
        }


        private function actualizaEstatus($estado,$idFormato,$tipoFirma,$idUsuario): bool{
            $resultado = true;
            $firma = "Firma: " . bin2hex(random_bytes(64)) . "." . uniqid();
            $sql = "UPDATE op_rh_dia_doble_registro SET status = ? WHERE id = ? ";
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
      
            $sql2 = "INSERT INTO op_rh_dias_dobles_firma (id_formato,id_usuario,tipo_firma,firma) VALUES (?,?,?,?)";
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



        public function agregarComentarioDiaDoble($idReporte,$idUsuario,$Comentario){

            $result = true;
            $sql_insert = "INSERT INTO op_rh_dia_doble_comentarios (id_reporte,id_usuario,comentario) VALUES (?,?,?)";
            $stmt = $this->con->prepare($sql_insert);
            if(!$stmt) :
            $result = false;
            throw new Exception("Error al preparar la consulta ". $this->con->error);
            endif;
        
            $stmt->bind_param("iis", $idReporte,$idUsuario,$Comentario);
            if(!$stmt->execute()) :
            $result = false;
            throw new Exception("Error al ejecutar la consulta". $this->con->error);
            endif;
        
            $stmt->close();
            return $result;

        }

}