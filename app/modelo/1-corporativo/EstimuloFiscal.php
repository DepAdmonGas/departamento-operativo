<?php
require "../../bd/inc.conexion.php";
require_once '../../modelo/HerramientasDptoOperativo.php';

class EstimuloFiscal extends Exception
{

    private $classConexionBD;
    private $con;
    private $herramientasDptoOperativo;

    public function __construct()
    {
    $this->classConexionBD = Database::getInstance();
    $this->con = $this->classConexionBD->getConnection();
    
    parent::__construct("Error en la solicitud de estimulo fiscal");
    $this->herramientasDptoOperativo  = new herramientasDptoOperativo($this->con);
    }


    /* ---------- AGREGAR ----------*/
    public function agregarEstimuloFiscal(int $idEstacion, string $MFInicio, string $MFTermino, array $Documentos):bool
    {

    $result = true;
    $aleatorio = uniqid();

    // -- DOCUMENTO PDF --
    $FilePDF = "";
    $folderPDF = "";
    $PDF = "";
    
    if (!empty($Documentos[0]) && isset($Documentos[0]['name'])):
    $FilePDF = $Documentos[0]['name'];
    $folderPDF = "../../../archivos/" . $aleatorio . "-" . $FilePDF;
    $PDF = $aleatorio . "-" . $FilePDF;
    move_uploaded_file($Documentos[0]['tmp_name'], $folderPDF);
    endif;

    //-- DOCUMENTO XML --
    $FileXML = "";
    $folderXML = "";
    $XML = "";
    
    if (!empty($Documentos[1]) && isset($Documentos[1]['name'])):
    $FileXML = $Documentos[1]['name'];
    $folderXML = "../../../archivos/" . $aleatorio . "-" . $FileXML;
    $XML = $aleatorio . "-" . $FileXML;
    move_uploaded_file($Documentos[1]['tmp_name'], $folderXML);
    endif;

    $sql_insert = "INSERT INTO op_estimulo_fiscal_pago (id_estacion,fecha_inicio,fecha_termino,pdf,xml) VALUES (?,?,?,?,?)";
    $stmt = $this->con->prepare($sql_insert);
    if(!$stmt) :
    $result = false;
    throw new Exception("Error al preparar la consulta ". $stmt->error);
    endif;

    $stmt->bind_param("issss", $idEstacion, $MFInicio, $MFTermino, $PDF, $XML);
    if(!$stmt->execute()) :
    $result = false;
    throw new Exception("Error al ejecutar la consulta". $this->con->error);
    endif;
    
    $stmt->close();


    return $result;
    }

 
    /* ---------- EDITAR ----------*/
    public function editarEstimuloFiscal(int $IdReporte, int $idEstacion, string $EFInicio, string $EFTermino, array $Documentos):bool
    {
    $result = true;

    $sql_update = "UPDATE op_estimulo_fiscal_pago SET fecha_inicio = ?, fecha_termino = ? WHERE id = ?"; 
    $stmt_update = $this->con->prepare($sql_update);
    if (!$stmt_update) {
    $result = false;
    throw new Exception("Error al preparar la consulta ".$this->con->error); // Corrección en la obtención del error
    }

    $stmt_update->bind_param("ssi",$EFInicio, $EFTermino,$IdReporte);
    if (!$stmt_update->execute()) {
    $result = false;
    throw new Exception("Error al ejecutar la consulta SQL: " . $stmt_update->error);
    }
    $stmt_update->close();

    $aleatorio = uniqid();
    $valor = "";
    $consulta = "";

    if (!empty($Documentos[0]) && isset($Documentos[0]['name'])) :
    $consulta = "pdf = ?";
    $FilePDF = $Documentos[0]['name'];
    $folderPDF = "../../../archivos/".$aleatorio."-".$FilePDF;
    $PDF = $aleatorio."-".$FilePDF;

    if(move_uploaded_file($Documentos[0]['tmp_name'], $folderPDF)) :
    $this->actualizarDocumentoEstimulo($IdReporte,$PDF,$consulta);
    endif;
    endif;

    if (!empty($Documentos[1]) && isset($Documentos[1]['name'])) :
    $consulta = "xml = ?";
    $FileXML = $Documentos[1]['name'];
    $folderXML = "../../../archivos/".$aleatorio."-".$FileXML;
    $XML = $aleatorio."-".$FileXML;
    
    if(move_uploaded_file($Documentos[1]['tmp_name'], $folderXML)) :
    $this->actualizarDocumentoEstimulo($IdReporte,$XML,$consulta);
    endif;
    endif;

    if (!empty($Documentos[2]) && isset($Documentos[2]['name'])) :
    $consulta = "co_pdf = ?";
    $FileCo_PDF = $Documentos[2]['name'];
    $folderCo_PDF = "../../../archivos/".$aleatorio."-".$FileCo_PDF;
    $Co_PDF = $aleatorio."-".$FileCo_PDF;
        
    if(move_uploaded_file($Documentos[2]['tmp_name'], $folderCo_PDF)) :
    $this->actualizarDocumentoEstimulo($IdReporte,$Co_PDF,$consulta);
    endif;
    endif;

    if (!empty($Documentos[3]) && isset($Documentos[3]['name'])) :
    $consulta = "co_xml = ?";
    $FileCo_XML = $Documentos[3]['name'];
    $folderCo_XML = "../../../archivos/".$aleatorio."-".$FileCo_XML;
    $Co_XML = $aleatorio."-".$FileCo_XML;
            
    if(move_uploaded_file($Documentos[3]['tmp_name'], $folderCo_XML)) :
    $this->actualizarDocumentoEstimulo($IdReporte,$Co_XML,$consulta);
    endif;
    endif;
        
    return $result;
    }


    public function actualizarDocumentoEstimulo(int $IdReporte, string $Documento, string $consulta): bool 
    {
    $result = true;

    $sql_update = "UPDATE op_estimulo_fiscal_pago SET $consulta WHERE id = ?"; 
    $stmt_update = $this->con->prepare($sql_update);
    if (!$stmt_update) {
    $result = false;
    throw new Exception("Error al preparar la consulta ".$this->con->error); // Corrección en la obtención del error
    }

    $stmt_update->bind_param("si", $Documento, $IdReporte);
    if (!$stmt_update->execute()) {
    $result = false;
    throw new Exception("Error al ejecutar la consulta SQL: " . $stmt_update->error);
    }
    $stmt_update->close();
    
    return $result;
    }


    /* ---------- ELIMINAR ---------- */
    public function eliminarEstimuloFiscal(int $idReporte): bool
    {
    $result = true;
    $sql = "DELETE FROM op_estimulo_fiscal_pago WHERE id = ?";
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