<?php
require "../../bd/inc.conexion.php";
require_once '../../modelo/HerramientasDptoOperativo.php';

class SolicitudVale extends Exception
{
    private $classConexionBD;
    private $con;
    private $herramientasDptoOperativo;
   
    public function __construct()
    {
    $this->classConexionBD = Database::getInstance();
    $this->con = $this->classConexionBD->getConnection();
    
    parent::__construct("Error en la solicitud de vales");
    $this->herramientasDptoOperativo  = new herramientasDptoOperativo($this->con);
    }


    /* ---------- CONSULTAS ----------*/
    function obtenerUltimaSolicitudVale()
    {
        
    $numid = 1; // Valor por defecto si no se encuentra ninguna solicitud
    $numfolio = 1; // Valor por defecto si no se encuentra ninguna solicitud
        
    $sql = "SELECT id, folio FROM op_solicitud_vale ORDER BY id DESC LIMIT 1";
    $consulta = $this->con->prepare($sql);
        
    if (!$consulta) {
    throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
    }
        
    if (!$consulta->execute()) {
    throw new Exception("Error al ejecutar la consulta: " . $consulta->error);
    }
        
    $consulta->store_result();
        
    if ($consulta->num_rows > 0) {
    $consulta->bind_result($id, $folio);
    $consulta->fetch();
    $numid = $id + 1;
    $numfolio = $folio + 1;
    }
        
    $consulta->close();
    return array('id' => $numid, 'folio' => $folio);
    }
    

    /* ---------- AGREGAR ----------*/
    public function agregarArchivoSolicitudVale(int $idReporte, string $nameDocumento, array $documento, int $indice): bool
    {
    $result = true;
    $aleatorio = uniqid();
    
    $UpDoc1 = "";
    $NomDoc1 = "";
 
    if (!empty($documento[$indice]) && isset($documento[$indice]['name'])):
    $NoDoc1 = $documento[$indice]['name'];
    $UpDoc1 = "../../../archivos/vales/".$aleatorio."-".$NoDoc1;
    $NomDoc1 = $aleatorio."-".$NoDoc1;

    move_uploaded_file($documento[$indice]['tmp_name'], $UpDoc1);

    $sql_insert = "INSERT INTO op_solicitud_vale_documento (id_solicitud,nombre,documento) VALUES (?,?,?)";
    $stmt = $this->con->prepare($sql_insert);
    if(!$stmt) :
    $result = false;
    throw new Exception("Error al preparar la consulta ". $stmt->error);
    endif;

    $stmt->bind_param("iss", $idReporte, $nameDocumento, $NomDoc1);
    if(!$stmt->execute()) :
    $result = false;
    throw new Exception("Error al ejecutar la consulta". $this->con->error);
    endif;
    
    $stmt->close();
    endif;

    return $result;
    }
 
    public function agregarComentarioSolicitudVale(int $idReporte, int $idUsuario, string $Comentario): bool
    {
    $result = true;
    $sql_insert = "INSERT INTO op_solicitud_vale_comentario (id_solicitud,id_usuario,comentario) VALUES (?,?,?)";
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
    

    public function agregarSolicitudVale(array $infoSolicitud, array $documentos): bool
    {
    $result = true;

    $sql_insert = "INSERT INTO op_solicitud_vale (id, id_year, id_mes, id_estacion, cuenta, id_usuario, folio, fecha, hora, monto,
    moneda, concepto, solicitante, autorizado_por, metodo_autorizacion, observaciones, depto, status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt_insert = $this->con->prepare($sql_insert);
    if(!$stmt_insert):
    $result = false;
    throw new Exception("Error al preparar la consulta ".$stmt_insert->error);
    endif;   

    $ultimaSolicitudVale = $this->obtenerUltimaSolicitudVale();
    $idReporte = $ultimaSolicitudVale['id'];
    $Folio = $ultimaSolicitudVale['folio'];
    $hora_del_dia = date("H:i:s");
    $status = 1;

    if ($infoSolicitud[0] == 8) {
    $Estacion = $infoSolicitud[14];
    $Cuentas = $infoSolicitud[15];
    }else{
    $Estacion = $infoSolicitud[0];
    $Cuentas = '';    
    }

    if($infoSolicitud[13] == ''){
    $Departamento = $infoSolicitud[1];
    }else{                                                                
    $Departamento = $infoSolicitud[13]; 
    }

    $stmt_insert->bind_param("iiiisiissdssssssii", $idReporte, $infoSolicitud[2], $infoSolicitud[3], $Estacion, $Cuentas, $infoSolicitud[4], $Folio, $infoSolicitud[5], $hora_del_dia, $infoSolicitud[6],
    $infoSolicitud[7], $infoSolicitud[8], $infoSolicitud[9], $infoSolicitud[11], $infoSolicitud[12], $infoSolicitud[10], $infoSolicitud[1], $status);
    if (!$stmt_insert->execute()):
    $result = false;
    throw new Exception("Error al ejecutar la consulta SQL: " . $stmt_insert->error);
    endif;   
    $stmt_insert->close();

    if ($documentos[0] != ''):
    $indice = 0;
    $descripcion = "VALE";
    $this->agregarArchivoSolicitudVale($idReporte, $descripcion, $documentos, $indice);
    endif;
    
    if ($documentos[1] != ''):
    $indice = 1;
    $descripcion = "RECIBO";
    $this->agregarArchivoSolicitudVale($idReporte, $descripcion, $documentos, $indice);
    endif;

    if ($documentos[2] != ''):
    $indice = 2;
    $descripcion = "FACTURA";
    $this->agregarArchivoSolicitudVale($idReporte, $descripcion, $documentos, $indice);
    endif;

    if ($documentos[3] != ''):
    $indice = 3;
    $descripcion = "PDF";
    $this->agregarArchivoSolicitudVale($idReporte, $descripcion, $documentos, $indice);
    endif;

    if ($documentos[3] != ''):
    $indice = 3;
    $descripcion = "XML";
    $this->agregarArchivoSolicitudVale($idReporte, $descripcion, $documentos, $indice);
    endif;

    return $result;
    }

    /* ---------- ELIMINAR ----------*/
    public function eliminarSolicitudVale(int $idReporte): bool
    {
    $result = true;
    $sql_delete = "DELETE FROM op_solicitud_vale WHERE id = ?";
    $stmt_delete = $this->con->prepare($sql_delete);
    if (!$stmt_delete):
    $result = false;
    throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
    endif;
        
    $stmt_delete->bind_param("i", $idReporte);
        
    if (!$stmt_delete->execute()):
    $result = false;
    throw new Exception("Error al ejecutar la consulta SQL: " . $stmt_delete->error);
    endif;

    $stmt_delete->close();
    return $result;
    }


    public function eliminarDocumentoSolicitudVale(int $idDocumento): bool
    {
    $result = true;
    $sql_delete = "DELETE FROM op_solicitud_vale_documento WHERE id = ?";
    $stmt_delete = $this->con->prepare($sql_delete);
    if (!$stmt_delete):
    $result = false;
    throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
    endif;
        
    $stmt_delete->bind_param("i", $idDocumento);
        
    if (!$stmt_delete->execute()):
    $result = false;
    throw new Exception("Error al ejecutar la consulta SQL: " . $stmt_delete->error);
    endif;

    $stmt_delete->close();
    return $result;
    }



}