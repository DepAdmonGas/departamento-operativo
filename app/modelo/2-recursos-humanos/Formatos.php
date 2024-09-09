<?php
require "../../bd/inc.conexion.php";
require "../../modelo/httpPHPAltiria.php";

class Formatos extends Exception{
    private $classConexionBD;
    private $con;
    private $altiriaSMS;
    public function __construct()
    {
    $this->classConexionBD = Database::getInstance();
    $this->con = $this->classConexionBD->getConnection();
    $this->altiriaSMS = new AltiriaSMS();
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
    function notificacionesWA($Numero, $aleatorio, $token)
    {
        $telefono = '525527314824';

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
    }

    $this->actualizaEstatus($estado,$idFormato,$tipoFirma,$idUsuario);

    else:
    $resultado = false;
    endif;
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






  }