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

    /* ---------- AGREGAR ----------*/
    function agregararchivoSolicitudVale(int $idReporte, string $nameDocumento, array $documento): bool
    {
    $result = true;
    $aleatorio = uniqid();
    
    $UpDoc1 = "";
    $NomDoc1 = "";

    if (!empty($documento[0]) && isset($documento[0]['name'])):
    $NoDoc1 = $documento[0]['name'];
    $UpDoc1 = "../../../archivos/vales/".$aleatorio."-".$NoDoc1;
    $NomDoc1 = $aleatorio."-".$NoDoc1;

    move_uploaded_file($documento[0]['tmp_name'], $UpDoc1);

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