<?php
require "FormatoFechas.php";
require "../../bd/inc.conexion.php";

class SolicitudCheque extends Exception
{


    private $classConexionBD;
    private $con;
    private $formato;


    public function __construct()
    {
    $this->classConexionBD = Database::getInstance();
    $this->con = $this->classConexionBD->getConnection();
    $this->formato = new FormatoFechas();
    }

    /* ---------- AGREGAR ----------*/
    public function agregarComentarioSolicitudCheque(int $idReporte, int $idUsuario, string $Comentario): bool
    {
    $result = true;
    $sql_insert = "INSERT INTO op_solicitud_cheque_comentario (id_solicitud,id_usuario,comentario) VALUES (?,?,?)";
    $stmt = $this->con->prepare($sql_insert);
    if(!$stmt) :
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

    function agregarArchivosSolicitudCheque(int $idReporte, int $idUsuario, string $descripcion, array $documento): bool
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
    
    $sql_insert = "INSERT INTO op_solicitud_cheque_documento (id_solicitud,nombre,documento) VALUES (?,?,?)";
    $stmt = $this->con->prepare($sql_insert);
    if(!$stmt) :
    throw new Exception("Error al preparar la consulta ". $stmt->error);
    endif;
    
    $stmt->bind_param("iss", $idReporte, $descripcion, $NomDoc1);
    if(!$stmt->execute()) :
    $result = false;
    throw new Exception("Error al ejecutar la consulta". $this->con->error);
    endif;
    
    $stmt->close();
    
    // Consulta adicional si la descripción es "COTIZACIÓN"
    if ($descripcion === "COTIZACIÓN") {
    $sqlComent = "INSERT INTO op_solicitud_cheque_comentario (id_solicitud, id_usuario, comentario) VALUES (?,?,?)";
    
    $stmtComent = $this->con->prepare($sqlComent);
    if(!$stmtComent) :
    throw new Exception("Error al preparar la consulta ". $stmt->error);
    endif;
    
    $comentario = "Factura contra entrega";
    $stmtComent->bind_param("iis", $idReporte, $idUsuario, $comentario);
    if(!$stmtComent->execute()) :
    $result = false;
    throw new Exception("Error al ejecutar la consulta". $this->con->error);
    endif;
            
    $stmtComent->close();
    }
    
    // Devuelve true solo si no se ha encontrado ningún error.
    return $result;
    }
    
 
    /* ---------- EDITAR ---------- */
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




    /* ---------- ELIMINAR ---------- */
    public function eliminarSolicitudCheque(int $idReporte): bool
    {
    $result = true;
    $sql = "DELETE FROM op_solicitud_cheque WHERE id = ?";
    $stmt = $this->con->prepare($sql);
    if (!$stmt):
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



}


