<?php
require "../../bd/inc.conexion.php";
require "../../config/ConfiguracionTokenWhats.php";
require "../../modelo/httpPHPAltiria.php";
class Permisos extends Exception{
    private $altiriaSMS;
    private $token;
    private $classConexionBD;
    private $con;
    public function __construct()
    {
        $this->classConexionBD = Database::getInstance();
        $this->con = $this->classConexionBD->getConnection();
        $this->altiriaSMS = new AltiriaSMS();
        $this->token = TokenWhats::get_token();
    }
    public function eliminarPermisos(int $id): bool {
        $resultado = true;
        $sql = "DELETE FROM op_rh_permisos WHERE id= ? ";
        $result =$this->con->prepare($sql);
        if(!$result):
            throw new Exception ("Error al preparar la consulta".$this->con->error);
        endif;
        $result->bind_param("i",$id);
        if(!$result->execute()):
            $resultado = false;
            throw new Exception("Error al ejecutar la consulta".$result->error);
        endif;
        $result->close();
        $this->eliminaFirmaPermiso($id);
        return $resultado;
    }
    private function eliminaFirmaPermiso(int $id): void {
        $sql = "DELETE FROM op_rh_permisos_firma WHERE id_permiso = ? ";
        $result = $this->con->prepare($sql);
        if(!$result):
            throw new Exception("Error al preparar la consulta".$this->con->error);
        endif;
        $result->bind_param("i",$id);
        if(!$result->execute()):
            throw new Exception("Error al ejecutar la consulta". $result->error);
        endif;
        $result->close();
    }
    public function agregarPermiso(string $imgn,int $estacion,int $colaborador,string $fechaInicio,string $fechaFin,string $diasTomados,int $cubre,string $motivo,string $observacion): bool {
        $resultado = true;
        $status = 0;
        $aleatorio = uniqid();
        $img = str_replace('data:image/png;base64,', '', $imgn);
        $fileData = base64_decode($img);
        $fileName = $aleatorio.'.png';
        $idReporte = $this->idReporte();
        $sql_insert = "INSERT INTO op_rh_permisos (
            id,
            id_estacion,
            id_personal,
            fecha_inicio,
            fecha_termino,
            dias_tomados,
            cubre_turno,
            motivo,
            observaciones,
            estado)
            VALUES(?,?,?,?,?,?,?,?,?,?)";
        $result = $this->con->prepare($sql_insert);
        if(!$result):
            throw new Exception("Error al preparar la consulta".$this->con->error);
        endif;
        $result->bind_param("iiisssissi",$idReporte,$estacion,$colaborador,$fechaInicio,$fechaFin,$diasTomados,$cubre,$motivo,$observacion,$status);
        if(!$result->execute()):
            $resultado = false;
            throw new Exception("Error al ejecutar la consulta".$result->error);
        endif;
        $result->close();
        if(file_put_contents('../../../imgs/firma/'.$fileName, $fileData)):
            $this->agregarFirmaPermiso($idReporte,$colaborador,$fileName);
        endif;
        return $resultado;
    }
    private function agregarFirmaPermiso(int $idPermiso,int $idUsuario,$firma): void {
        $tipoFirma = "A";
        $sql = "INSERT INTO op_rh_permisos_firma (
            id_permiso,
            id_usuario,
            tipo_firma,
            firma
                )VALUES(?,?,?,?)";
        $result = $this->con->prepare($sql);
        if(!$result):
            throw new Exception("Error al preparar la consulta".$this->con->error);
        endif;
        $result->bind_param("iiss",$idPermiso,$idUsuario,$tipoFirma,$firma);
        if(!$result->execute()):
            throw new Exception("Error al ejecutar la consulta".$result->error);
        endif;
        $result->close();
    }
    private function idReporte(): int {
        $sql = "SELECT MAX(id) AS max_id FROM op_rh_permisos";
        $stmt = $this->con->prepare($sql);
        
        if (!$stmt) :
            throw new Exception("Error al preparar la consulta: " . $this->con->error);
        endif;
    
        if (!$stmt->execute()) :
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        endif;
    
        $stmt->bind_result($max_id);
        $stmt->fetch();
        $id = ($max_id === null) ? 1 : $max_id + 1;

        $stmt->close();
        return $id;
    }
    public function tokenPermiso(int $idReporte,int $idVal): bool{
        $resultado = true;
        $aleatorio = rand(100000, 999999);
        $idUsuario = 318;
        $sql = "DELETE FROM op_rh_permisos_token WHERE id_permiso = ? AND id_usuario = ? ";
        $result = $this->con->prepare($sql);
        $result->bind_param("ii",$idReporte,$idUsuario);
        $result->execute();
        $result->close();
        $sql_insert = "INSERT INTO op_rh_permisos_token (id_permiso,id_usuario,token) VALUES(?,?,?)";
        $result = $this->con->prepare($sql_insert);
        if(!$result):
            throw new Exception("Error al preparar la consulta".$this->con->error);
        endif;
        $result->bind_param("iii",$idReporte,$idUsuario,$aleatorio);
        if($result->execute()):
            $Numero = $this->numero($idUsuario);
            if ($idVal == 1) {
                $this->altiriaSMS->setApikey('sistemas.admongas@gmail.com');
                $this->altiriaSMS->setApisecret('hy8q4c7y');
                $this->altiriaSMS->setSenderId('AdmonGas');
                $sDestination = '52' . $Numero;
                // se manda por medio de mensaje de texto
                $this->altiriaSMS->sendSMS($sDestination, "AdmonGas: Usa el siguiente token para firmar el permiso solicitado. Token: " . $aleatorio . " Web: portal.admongas.com.mx");
            } else if ($idVal == 2) {
                // se manda por medio de whatsapp
                $this->notificacionesWA($Numero, $aleatorio,$this->token);
            }
        endif;
        $result->close();
        return $resultado;
    }
    private function Numero(int $idUsuario)
    {
        $sql = "SELECT telefono FROM tb_usuarios WHERE id = ? ";
        $result = $this->con->prepare($sql);
        if(!$result):
            throw new Exception("Error al preparar la consulta".$this->con->error);
        endif;
        $result->bind_param("i",$idUsuario);
        if(!$result->execute()):
            throw new Exception("Error al ejecutar la consulta".$result->error);
        endif;
        $result->bind_result($telefono);
        $result->fetch();
        $result->close();
        return $telefono;
    }
    private function notificacionesWA($Numero, $aleatorio,$token)
    {
        $telefono = '52' . $Numero;
        //$telefono = "525527314824";
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
            "body": "AdmonGas: Usa el siguiente token para firmar el permiso solicitado. Token: ' . $aleatorio . ' Web: portal.admongas.com.mx"
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
    public function firmarPermiso(int $idReporte, string $tipoFirma, int $tokenValidacion): bool {
        $idUsuario = 318;
        $resultado = false;
        $firma = "Firma: " . bin2hex(random_bytes(64)) . "." . uniqid();
        
        // Determinar el estado basado en el tipo de firma
        switch ($tipoFirma) :
            case "A":
                $estado = 0;
                break;
            case "B":
                $estado = 1;
                break;
            case "C":
                $estado = 2;
                break;
            default:
                // Tipo de firma no válido
                return false;
        endswitch;
    
        // Preparar y ejecutar la primera consulta
        $sql = "SELECT * FROM op_rh_permisos_token WHERE id_permiso = ? AND id_usuario = ? AND token = ? ORDER BY id ASC LIMIT 1";
        $stmt = $this->con->prepare($sql);
        if ($stmt) :
            $stmt->bind_param("iii", $idReporte, $idUsuario, $tokenValidacion);
            $stmt->execute();
            $stmt->store_result();
    
            if ($stmt->num_rows == 1) :
                // Preparar y ejecutar la actualización
                $sql_update = "UPDATE op_rh_permisos SET estado = ? WHERE id = ?";
                $stmt_update = $this->con->prepare($sql_update);
                if ($stmt_update) :
                    $stmt_update->bind_param("ii", $estado, $idReporte);
                    if ($stmt_update->execute()) :
                        // Preparar y ejecutar la inserción
                        $sql_insert = "INSERT INTO op_rh_permisos_firma (id_permiso, id_usuario, tipo_firma, firma) VALUES (?,?,?,?)";
                        $stmt_insert = $this->con->prepare($sql_insert);
                        if ($stmt_insert) :
                            $stmt_insert->bind_param("iiss", $idReporte, $idUsuario, $tipoFirma, $firma);
                            if ($stmt_insert->execute()) :
                                $resultado = true;
                            endif;
                            $stmt_insert->close();
                        endif;
                    endif;
                    $stmt_update->close();
                endif;
            endif;
            $stmt->close();
        endif;
    
        return $resultado;
    }
    public function firmaQuienCubre(string $imgn,int $idReporte,string $tipoFirma,int $idUsuario): bool {
        $resultado = true;
        $aleatorio = uniqid();
        $img = str_replace('data:image/png;base64,', '', $imgn);
        $fileData = base64_decode($img);
        $fileName = $aleatorio.'.png';
        if(file_put_contents('../../../imgs/firma/'.$fileName, $fileData)):
            $sql_insert = "INSERT INTO op_rh_permisos_firma (
            id_permiso,
            id_usuario,
            tipo_firma,
            firma
            )
            VALUES 
            (?,?,?,?)";
            $result = $this->con->prepare($sql_insert);
            $result->bind_param("iiss",$idReporte,$idUsuario,$tipoFirma,$fileName);
            if(!$result->execute()):
                $resultado = false;
                throw new Exception("Error el ejecutar la consulta".$result->error);
            endif;
            $result->close();
            $estatus = 1;
            $sql = "UPDATE op_rh_permisos SET estado = ? WHERE id = ? ";
            $result2 = $this->con->prepare($sql);
            $result2->bind_param("ii",$estatus,$idReporte);
            if(!$result2->execute()):
                $resultado = false;
                throw new Exception("Error al preparar la consulta 2".$result2->error);
            endif;   
            $result2->close();
        endif;
        return $resultado;
    }
}