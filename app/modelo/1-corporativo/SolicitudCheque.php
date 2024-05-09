<?php
require "../../bd/inc.conexion.php";
require_once '../../modelo/HerramientasDptoOperativo.php';

class SolicitudCheque extends Exception
{
 
    private $classConexionBD;
    private $con;
    private $herramientasDptoOperativo;

    public function __construct()
    {
    $this->classConexionBD = Database::getInstance();
    $this->con = $this->classConexionBD->getConnection();
    
    parent::__construct("Error en la solicitud de cheque");
    $this->herramientasDptoOperativo  = new herramientasDptoOperativo($this->con);
    }

    /* ---------- CONSULTAS ---------- */
    public function idReporte(): int
    {
    $id = "";
    $sql_reporte = "SELECT id FROM op_solicitud_cheque ORDER BY id DESC LIMIT 1";
    $stmt_reporte  = $this->con->prepare($sql_reporte);
    
    if (!$stmt_reporte) {
    $result = false;
    throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
    }

    $stmt_reporte->execute();
    $stmt_reporte->bind_result($id);
    $stmt_reporte->fetch();
    $stmt_reporte->close();

    if (!$id) {
    return 1;
    } 
    
    return $id + 1;
    }
    

    /* ---------- AGREGAR ----------*/
    public function agregarFirmaSolicitudCheque(int $idSolicitud, int $idUsuario, string $tipo_firma, string $firma):bool
    {
        
    $img = str_replace('data:image/png;base64,', '', $firma);
    $fileData = base64_decode($img);
    $fileName = uniqid() . '.png';

    if (file_put_contents('../../../imgs/firma/' . $fileName, $fileData)):
    $result = true;
    $sql_insert = "INSERT INTO op_solicitud_cheque_firma (id_solicitud, id_usuario, tipo_firma, firma)
    VALUES (?,?,?,?)";
    $stmt_insert = $this->con->prepare($sql_insert);
    if (!$stmt_insert):
    $result = false;
    throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
    endif;

    $stmt_insert->bind_param("iiss", $idSolicitud, $idUsuario, $tipo_firma, $fileName);
    if (!$stmt_insert->execute()):
    $result = false;
    throw new Exception("Error al ejecutar la consulta SQL: " . $stmt_insert->error);
    endif;

    endif;

    return $result;

    }


    public function agregarComentarioSolicitudCheque(int $idReporte, int $idUsuario, string $Comentario): bool
    {
    $result = true;
    $sql_insert = "INSERT INTO op_solicitud_cheque_comentario (id_solicitud,id_usuario,comentario) VALUES (?,?,?)";
    $stmt = $this->con->prepare($sql_insert);
    if(!$stmt) :
    $result = false;
    throw new Exception("Error al preparar la consulta ". $stmt->error);
    endif;

    $stmt->bind_param("iis", $idReporte,$idUsuario,$Comentario);
    if(!$stmt->execute()) :
    $result = false;
    throw new Exception("Error al ejecutar la consulta". $this->con->error);
    endif;

    $stmt->close();
    return $result;
    }

    function agregarArchivosSolicitudCheque(int $idReporte, int $idUsuario, string $descripcion, array $documento, int $indice): bool
    {
    $result = true; 
    $aleatorio = uniqid();
    
    $UpDoc1 = "";
    $NomDoc1 = "";
    
    if (!empty($documento[$indice]) && isset($documento[$indice]['name'])):
    $NoDoc1 = $documento[$indice]['name'];
    $UpDoc1 = "../../../archivos/".$aleatorio."-".$NoDoc1;
    $NomDoc1 = $aleatorio."-".$NoDoc1;
    move_uploaded_file($documento[$indice]['tmp_name'], $UpDoc1);

    $sql_insert = "INSERT INTO op_solicitud_cheque_documento (id_solicitud,nombre,documento) VALUES (?,?,?)";
    $stmt = $this->con->prepare($sql_insert);
    if(!$stmt) :
    $result = false;
    throw new Exception("Error al preparar la consulta ". $stmt->error);
    endif;
    
    $stmt->bind_param("iss", $idReporte, $descripcion, $NomDoc1);
    if(!$stmt->execute()) :
    $result = false;
    throw new Exception("Error al ejecutar la consulta". $this->con->error);
    endif;
    
    $stmt->close();
    
    // Consulta adicional si la descripción es "COTIZACIÓN"
    if ($descripcion === "COTIZACIÓN"):
    $comentario = "Factura contra entrega";
    $this->agregarComentarioSolicitudCheque($idReporte, $idUsuario, $comentario);
    endif;

    endif;
    
    return $result;
    }

    function agregarSolicitudCheque(array $infoSolicitudCheque, array $documentos, int $idEstacion, int $idPuesto, int $idUsuario, string $nameEstacion): bool
    {
    $result = true; 
    $valIdEstacion = "";
    $valIPuesto = "";

    if ($infoSolicitudCheque[20] == 23):
    $valIdEstacion = 8;
    $valIPuesto = $infoSolicitudCheque[20];
    else:
    $valIdEstacion = $idEstacion;
    $valIPuesto = $idPuesto;
    endif;
  
    $sql_insert = "INSERT INTO op_solicitud_cheque
    (id, id_year, id_mes, id_estacion, fecha, hora, beneficiario, monto, moneda, no_factura,
    email, concepto, solicitante, telefono, cfdi, metodo_pago, forma_pago, banco, no_cuenta, cuenta_clabe,
    referencia, observaciones, depto, razonsocial, status)
    VALUES
    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
     ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
     ?, ?, ?, ?, ?)";
    $stmt_insert = $this->con->prepare($sql_insert);
    if(!$stmt_insert):
    $result = false;
    throw new Exception("Error al preparar la consulta ".$stmt_insert->error);
    endif;   

    $idReporte = $this->idReporte();
    $hora_actual = date("H:i:s");
    $valorConcepto = mysqli_real_escape_string($this->con, $infoSolicitudCheque[9]);
    $status = 0;

    $stmt_insert->bind_param("iiiisssdssssssssssssssisi", $idReporte, $infoSolicitudCheque[0], $infoSolicitudCheque[1], $valIdEstacion, $infoSolicitudCheque[2],
    $hora_actual, $infoSolicitudCheque[4], $infoSolicitudCheque[5], $infoSolicitudCheque[6], $infoSolicitudCheque[7], $infoSolicitudCheque[8], $valorConcepto, 
    $infoSolicitudCheque[10], $infoSolicitudCheque[11], $infoSolicitudCheque[12], $infoSolicitudCheque[13], $infoSolicitudCheque[14], $infoSolicitudCheque[15],
    $infoSolicitudCheque[16], $infoSolicitudCheque[17], $infoSolicitudCheque[18], $infoSolicitudCheque[19], $valIPuesto, $infoSolicitudCheque[3], $status);
    if (!$stmt_insert->execute()):
    $result = false;
    throw new Exception("Error al ejecutar la consulta SQL: " . $stmt_insert->error);
    endif;   
    $stmt_insert->close();

    $this->agregarFirmaSolicitudCheque($idReporte, $idUsuario, "A", $infoSolicitudCheque[21]);

    if ($documentos[0] != ''):
    $indice = 0;
    $descripcion = "PRESUPUESTO";
    $this->agregarArchivosSolicitudCheque($idReporte, $idUsuario, $descripcion, $documentos, $indice);
    endif;

    if ($documentos[1] != ''):
    $indice = 1;
    $descripcion = "FACTURA PDF";
    $this->agregarArchivosSolicitudCheque($idReporte, $idUsuario, $descripcion, $documentos, $indice);
    endif;

    if ($documentos[2] != ''):
    $indice = 2;
    $descripcion = "FACTURA XML";
    $this->agregarArchivosSolicitudCheque($idReporte, $idUsuario, $descripcion, $documentos, $indice);
    endif;

    if ($documentos[3] != ''):
    $indice = 3;
    $descripcion = "CARATULA BANCARIA";
    $this->agregarArchivosSolicitudCheque($idReporte, $idUsuario, $descripcion, $documentos, $indice);
    endif;

    if ($documentos[4] != ''):
    $indice = 4;
    $descripcion = "CONSTANCIA DE SITUACION";
    $this->agregarArchivosSolicitudCheque($idReporte, $idUsuario, $descripcion, $documentos, $indice);
    endif;

    if ($documentos[5] != ''):
    $indice = 5;
    $descripcion = "PREFACTURA";
    $this->agregarArchivosSolicitudCheque($idReporte, $idUsuario, $descripcion, $documentos, $indice);
    endif;

    if ($documentos[6] != ''):
    $indice = 6;
    $descripcion = "ORDEN DE SERVICIO";
    $this->agregarArchivosSolicitudCheque($idReporte, $idUsuario, $descripcion, $documentos, $indice);
    endif;

    if ($documentos[7] != ''):
    $indice = 7;
    $descripcion = "ORDEN DE COMPRA";
    $this->agregarArchivosSolicitudCheque($idReporte, $idUsuario, $descripcion, $documentos, $indice);
    endif;

    if ($documentos[8] != ''):
    $indice = 8;
    $descripcion = "ORDEN DE MANTENIMIENTO";
    $this->agregarArchivosSolicitudCheque($idReporte, $idUsuario, $descripcion, $documentos, $indice);
    endif;

    if ($documentos[9] != ''):
    $indice = 9;
    $descripcion = "PÓLIZA DE GARANTÍA";
    $this->agregarArchivosSolicitudCheque($idReporte, $idUsuario, $descripcion, $documentos, $indice);
    endif;

    if ($documentos[10] != ''):
    $indice = 10;
    $descripcion = "PRORRATEO";
    $this->agregarArchivosSolicitudCheque($idReporte, $idUsuario, $descripcion, $documentos, $indice);
    endif;
    
    if ($documentos[11] != ''):
    $indice = 11;
    $descripcion = "REEMBOLSO CAJA CHICA";
    $this->agregarArchivosSolicitudCheque($idReporte, $idUsuario, $descripcion, $documentos, $indice);
    endif;   

    if ($documentos[12] != ''):
    $indice = 12;
    $descripcion = "COTIZACIÓN";
    $this->agregarArchivosSolicitudCheque($idReporte, $idUsuario, $descripcion, $documentos, $indice);
    endif;  

    if ($documentos[13] != ''):
    $indice = 13;
    $descripcion = "NOTA DE CREDITO PDF";
    $this->agregarArchivosSolicitudCheque($idReporte, $idUsuario, $descripcion, $documentos, $indice);
    endif; 

    if ($documentos[14] != ''):
    $indice = 14;
    $descripcion = "NOTA DE CREDITO XML";
    $this->agregarArchivosSolicitudCheque($idReporte, $idUsuario, $descripcion, $documentos, $indice);
    endif; 

    if ($documentos[15] != ''):
    $indice = 15;
    $descripcion = "CONTRATO";
    $this->agregarArchivosSolicitudCheque($idReporte, $idUsuario, $descripcion, $documentos, $indice);
    endif; 

    if ($documentos[16] != ''):
    $indice = 16;
    $descripcion = "COMPLEMENTO DE PAGO PDF";
    $this->agregarArchivosSolicitudCheque($idReporte, $idUsuario, $descripcion, $documentos, $indice);
    endif; 
      
    if ($documentos[17] != ''):
    $indice = 17;
    $descripcion = "COMPLEMENTO DE PAGO XML";
    $this->agregarArchivosSolicitudCheque($idReporte, $idUsuario, $descripcion, $documentos, $indice);
    endif; 
    
    $accion = "";
    $detalle = 'Se creo una solicitud de cheques de la estación '.$nameEstacion;
    $token = $this->herramientasDptoOperativo->toquenUser(19);
    $this->herramientasDptoOperativo->sendNotification($token, $detalle, $accion);

    return $result;

    }

    public function crearTokenSolicitudCheque(int $idReporte, int $idUsuario): bool
    {
    $result = true; 
    
    $this->eliminarTokenSolicitudCheque($idReporte);

    $sql_insert = "INSERT INTO op_solicitud_cheque_token (id_solicitud, id_usuario, token) VALUES (?, ?, ?)";
    $stmt_insert = $this->con->prepare($sql_insert);
    if(!$stmt_insert):
    $result = false;
    throw new Exception("Error al preparar la consulta ".$stmt_insert->error);
    endif; 

    $aleatorio = rand(100000, 999999);
    $stmt_insert->bind_param("iii", $idReporte, $idUsuario, $aleatorio);
    if (!$stmt_insert->execute()):
    $result = false;
    throw new Exception("Error al ejecutar la consulta SQL: " . $stmt_insert->error);
    endif;   
    $stmt_insert->close();

    $telefonoUser = $this->herramientasDptoOperativo->obtenerTelefonoUsuario($idUsuario);
    $this->herramientasDptoOperativo->destinatarioToken($telefonoUser,$aleatorio);
 

    return $result;
    }


    public function firmarSolicitudCheque(int $idReporte, string $tipoFirma, int $TokenValidacion, int $idUsuario, string $nameEstacion): bool
    {
    $result = true;
    
    switch ($tipoFirma) { // Corrección en la sintaxis del switch-case
    case 'B':
    $estado = 1;
    break;
    
    case 'C':
    $estado = 2;
    break;
    }
    
    $sql_token = "SELECT id FROM op_solicitud_cheque_token WHERE id_solicitud = '".$idReporte."' and id_usuario = '".$idUsuario."' and token = '".$TokenValidacion."' ORDER BY id ASC LIMIT 1 ";
    $result_token = mysqli_query($this->con, $sql_token);
    $numero_token = mysqli_num_rows($result_token);
    
    if ($numero_token > 0) {
    $sql_update = "UPDATE op_solicitud_cheque SET status = ? WHERE id = ?"; 
    $stmt_update = $this->con->prepare($sql_update);
    if (!$stmt_update) {
    $result = false;
    throw new Exception("Error al preparar la consulta ".$this->con->error); // Corrección en la obtención del error
    }
    
    $stmt_update->bind_param("ii", $estado, $idReporte);
    if (!$stmt_update->execute()) {
    $result = false;
    throw new Exception("Error al ejecutar la consulta SQL: " . $stmt_update->error);
    }
    $stmt_update->close();
            
    $Firma = "Firma: ".bin2hex(random_bytes(64)).".".uniqid();
    $this->agregarFirmaSolicitudCheque($idReporte, $idUsuario, $tipoFirma, $Firma);
    
    if ($tipoFirma == "B") {
    $accion = "";
    $token = $this->herramientasDptoOperativo->toquenUser(2); // Corrección en el nombre del método
    $detalle = 'Se firmo con visto bueno una solicitud de cheques de la estación '.$nameEstacion;
    $this->herramientasDptoOperativo->sendNotification($token, $detalle, $accion); // Corrección en el nombre del método
    }

    } else {
    $result = false;
    }
    
    return $result;
    }
    

    /* ---------- EDITAR ---------- */
    function editarArchivosSolicitudCheque(int $idReporte, int $idUsuario, string $descripcion, array $documento, int $indice): bool
    {
    $result = true; 
    $aleatorio = uniqid();
        
    $UpDoc1 = "";
    $NomDoc1 = "";

    if (!empty($documento[$indice]) && isset($documento[$indice]['name'])):
    $NoDoc1 = $documento[$indice]['name'];
    $UpDoc1 = "../../../archivos/".$aleatorio."-".$NoDoc1;
    $NomDoc1 = $aleatorio."-".$NoDoc1;
    move_uploaded_file($documento[$indice]['tmp_name'], $UpDoc1);
    
    $sql_edit = "UPDATE op_solicitud_cheque_documento SET 
    documento = ? WHERE id_solicitud = ? AND nombre = ?";

    $stmt_edit = $this->con->prepare($sql_edit);
    if(!$stmt_edit) :
    $result = false;
    throw new Exception("Error al preparar la consulta ". $stmt_edit->error);
    endif;
        
    $stmt_edit->bind_param("sis", $idReporte, $descripcion, $NomDoc1);
    if(!$stmt_edit->execute()) :
    $result = false;
    throw new Exception("Error al ejecutar la consulta". $this->con->error);
    endif;
        
    $stmt_edit->close();

    // Consulta adicional si la descripción es "COTIZACIÓN"
    if ($descripcion === "COTIZACIÓN"):
    
    $idComentario = "";
    $comentario = "Factura contra entrega";
    $sql = "SELECT id FROM op_solicitud_cheque WHERE id_solicitud = ? AND comentario = ?";
    $consulta = $this->con->prepare($sql);

    if (!$consulta) {
    $result = false;
    throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
    }
        
    $consulta->bind_param('i', $idReporte);
    $consulta->execute();
    $consulta->bind_result($idComentario);

    if (!$consulta->fetch()) {
    $this->agregarComentarioSolicitudCheque($idReporte, $idUsuario, $comentario);
    }

    endif;

    endif;
    return $result;
    }

    public function editarFirmaSolicitudCheque(int $idSolicitud, int $idUsuario, string $tipo_firma, string $firma):bool
    {
    
    $result = false;
    $img = str_replace('data:image/png;base64,', '', $firma);
    $fileData = base64_decode($img);
    $fileName = uniqid() . '.png';

    if (file_put_contents('../../../imgs/firma/' . $fileName, $fileData)):
    $result = true;
    $sql_edit = "UPDATE op_solicitud_cheque_firma SET 
    id_usuario = ?, firma = ? WHERE id_solicitud = ? AND tipo_firma = ?";

    $stmt_sql_edit = $this->con->prepare($sql_edit);
    if (!$stmt_sql_edit):
    $result = false;
    throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
    endif;

    $stmt_sql_edit->bind_param("isis", $idUsuario, $fileName, $idSolicitud, $tipo_firma);
    if (!$stmt_sql_edit->execute()):
    $result = false;
    throw new Exception("Error al ejecutar la consulta SQL: " . $stmt_sql_edit->error);
    endif;

    endif;

    return $result;

    }
    
    public function editarFacturaTelcelSolicitudCheque(int $idFactura, array $documento): bool
    {
    $result = true; 
    $aleatorio = uniqid();
        
    $UpDoc1 = "";
    $NomDoc1 = "";
        
    if (!empty($documento) && isset($documento['name'])):
    $NoDoc1 = $documento['name'];
    $UpDoc1 = "../../../archivos/".$aleatorio."-".$NoDoc1;
    $NomDoc1 = $aleatorio."-".$NoDoc1;
    move_uploaded_file($documento['tmp_name'], $UpDoc1);
    endif;
    
    $sql_edit = "UPDATE op_solicitud_cheque_telcel SET c_pago = ? WHERE id = ?";
    $stmt_edit = $this->con->prepare($sql_edit);
    if(!$stmt_edit):
    $result = false;
    throw new Exception("Error al preparar la consulta ".$stmt_edit->error);
    endif;

    $stmt_edit->bind_param("si", $NomDoc1, $idFactura);
    if (!$stmt_edit->execute()):
    $result = false;
    throw new Exception("Error al ejecutar la consulta SQL: " . $stmt_edit->error);
    endif;

    $stmt_edit->close();
    return $result;

    }
 

    function editarSolicitudCheque(array $infoSolicitudCheque, array $documentos, int $idEstacion, int $idPuesto, int $idUsuario, string $nameEstacion): bool
    {

    $result = true; 
    $sql_edit = "UPDATE op_solicitud_cheque SET 
    fecha = ?, hora = ?, beneficiario = ?, monto = ?, moneda = ?, no_factura = ?, 
    email = ?, concepto = ?, solicitante = ?, telefono = ?, cfdi = ?, metodo_pago = ?, forma_pago = ?, banco = ?, no_cuenta = ?, cuenta_clabe = ?, 
    referencia = ?, observaciones = ?, razonsocial = ? WHERE id = ? ";

    $stmt_edit = $this->con->prepare($sql_edit);
    if (!$stmt_edit):
    $result = false; 
    throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
    endif;

    $hora_actual = date("H:i:s");
    $valorConcepto = mysqli_real_escape_string($this->con, $infoSolicitudCheque[8]);
    $stmt_edit->bind_param("sssdsssssssssssssssi", $infoSolicitudCheque[1], $hora_actual, $infoSolicitudCheque[3], $infoSolicitudCheque[4], $infoSolicitudCheque[5], $infoSolicitudCheque[6],
    $infoSolicitudCheque[7], $valorConcepto, $infoSolicitudCheque[9], $infoSolicitudCheque[10], $infoSolicitudCheque[11], $infoSolicitudCheque[12], $infoSolicitudCheque[13], $infoSolicitudCheque[14], $infoSolicitudCheque[15], $infoSolicitudCheque[16],
    $infoSolicitudCheque[17], $infoSolicitudCheque[18], $infoSolicitudCheque[2], $infoSolicitudCheque[0]);
    if (!$stmt_edit->execute()):
    $result = false;
    throw new Exception("Error al ejecutar la consulta SQL: " . $stmt_edit->error);
    endif;
    $stmt_edit->close();

    $this->editarFirmaSolicitudCheque($infoSolicitudCheque[0], $idUsuario, "A", $infoSolicitudCheque[19]);

    if ($documentos[0] != ''):
    $indice = 0;
    $descripcion = "PRESUPUESTO";
    $this->editarArchivosSolicitudCheque($infoSolicitudCheque[0], $idUsuario, $descripcion, $documentos, $indice);
    endif;
    
    if ($documentos[1] != ''):
    $indice = 1;
    $descripcion = "FACTURA PDF";
    $this->editarArchivosSolicitudCheque($infoSolicitudCheque[0], $idUsuario, $descripcion, $documentos, $indice);
    endif;
    
    if ($documentos[2] != ''):
    $indice = 2;
    $descripcion = "FACTURA XML";
    $this->editarArchivosSolicitudCheque($infoSolicitudCheque[0], $idUsuario, $descripcion, $documentos, $indice);
    endif;
    
    if ($documentos[3] != ''):
    $indice = 3;
    $descripcion = "CARATULA BANCARIA";
    $this->editarArchivosSolicitudCheque($infoSolicitudCheque[0], $idUsuario, $descripcion, $documentos, $indice);
    endif;
    
    if ($documentos[4] != ''):
    $indice = 4;
    $descripcion = "CONSTANCIA DE SITUACION";
    $this->editarArchivosSolicitudCheque($infoSolicitudCheque[0], $idUsuario, $descripcion, $documentos, $indice);
    endif;
    
    if ($documentos[5] != ''):
    $indice = 5;
    $descripcion = "PREFACTURA";
    $this->editarArchivosSolicitudCheque($infoSolicitudCheque[0], $idUsuario, $descripcion, $documentos, $indice);
    endif;
    
    if ($documentos[6] != ''):
    $indice = 6;
    $descripcion = "ORDEN DE SERVICIO";
    $this->editarArchivosSolicitudCheque($infoSolicitudCheque[0], $idUsuario, $descripcion, $documentos, $indice);
    endif;
    
    if ($documentos[7] != ''):
    $indice = 7;
    $descripcion = "ORDEN DE COMPRA";
    $this->editarArchivosSolicitudCheque($infoSolicitudCheque[0], $idUsuario, $descripcion, $documentos, $indice);
    endif;
    
    if ($documentos[8] != ''):
    $indice = 8;
    $descripcion = "ORDEN DE MANTENIMIENTO";
    $this->editarArchivosSolicitudCheque($infoSolicitudCheque[0], $idUsuario, $descripcion, $documentos, $indice);
    endif;
    
    if ($documentos[9] != ''):
    $indice = 9;
    $descripcion = "PÓLIZA DE GARANTÍA";
    $this->editarArchivosSolicitudCheque($infoSolicitudCheque[0], $idUsuario, $descripcion, $documentos, $indice);
    endif;
    
    if ($documentos[10] != ''):
    $indice = 10;
    $descripcion = "PRORRATEO";
    $this->editarArchivosSolicitudCheque($infoSolicitudCheque[0], $idUsuario, $descripcion, $documentos, $indice);
    endif;
        
    if ($documentos[11] != ''):
    $indice = 11;
    $descripcion = "REEMBOLSO CAJA CHICA";
    $this->editarArchivosSolicitudCheque($infoSolicitudCheque[0], $idUsuario, $descripcion, $documentos, $indice);
    endif;   
    
    if ($documentos[12] != ''):
    $indice = 12;
    $descripcion = "COTIZACIÓN";
    $this->editarArchivosSolicitudCheque($infoSolicitudCheque[0], $idUsuario, $descripcion, $documentos, $indice);
    endif;  
    
    if ($documentos[13] != ''):
    $indice = 13;
    $descripcion = "NOTA DE CREDITO PDF";
    $this->editarArchivosSolicitudCheque($infoSolicitudCheque[0], $idUsuario, $descripcion, $documentos, $indice);
    endif; 
    
    if ($documentos[14] != ''):
    $indice = 14;
    $descripcion = "NOTA DE CREDITO XML";
    $this->editarArchivosSolicitudCheque($infoSolicitudCheque[0], $idUsuario, $descripcion, $documentos, $indice);
    endif; 
    
    if ($documentos[15] != ''):
    $indice = 15;
    $descripcion = "CONTRATO";
    $this->editarArchivosSolicitudCheque($infoSolicitudCheque[0], $idUsuario, $descripcion, $documentos, $indice);
    endif; 
    
    if ($documentos[16] != ''):
    $indice = 16;
    $descripcion = "COMPLEMENTO DE PAGO PDF";
    $this->editarArchivosSolicitudCheque($infoSolicitudCheque[0], $idUsuario, $descripcion, $documentos, $indice);
    endif; 
          
    if ($documentos[17] != ''):
    $indice = 17;
    $descripcion = "COMPLEMENTO DE PAGO XML";
    $this->editarArchivosSolicitudCheque($infoSolicitudCheque[0], $idUsuario, $descripcion, $documentos, $indice);
    endif; 
    
    return $result;

    }


    /* ---------- ELIMINAR ---------- */ 
    public function eliminarSolicitudCheque(int $idReporte): bool
    {
    $result = true;
    $sql = "DELETE FROM op_solicitud_cheque WHERE id = ?";
    $stmt = $this->con->prepare($sql);
    if (!$stmt):
    $result = false;
    throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
    endif;
        
    $stmt->bind_param("i", $idReporte);
        
    if (!$stmt->execute()):
    $result = false;
    throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
    endif;

    $stmt->close();
    return $result;
    }
 
    public function eliminarArchivosSolicitudCheque(int $idDocumento): bool
    {
    $result = true;
    $sql = "DELETE FROM op_solicitud_cheque_documento WHERE id = ?";
    $stmt = $this->con->prepare($sql);
    if (!$stmt):
    $result = false;
    throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
    endif;
        
    $stmt->bind_param("i", $idDocumento);
        
    if (!$stmt->execute()):
    $result = false;
    throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
    endif;

    $stmt->close();
    return $result;
    }

    public function eliminarTokenSolicitudCheque(int $idReporte): bool
    {
    $result = true;
    $sql = "DELETE FROM op_solicitud_cheque_token WHERE id_solicitud = ?";
    $stmt = $this->con->prepare($sql);
    if (!$stmt):
    $result = false;
    throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
    endif;
        
    $stmt->bind_param("i", $idReporte);
        
    if (!$stmt->execute()):
    $result = false;
    throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
    endif;

    $stmt->close();
    return $result;
    }



}


