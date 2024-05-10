<?php
require "../../bd/inc.conexion.php";
class Ingresos extends Exception
{
    private $classConexionBD;
    private $con;
    public function __construct()
    {
        $this->classConexionBD = Database::getInstance();
        $this->con = $this->classConexionBD->getConnection();
    }
    public function editarIngreso(int $id, int $valor, int $mes):bool
    {
        $result = true;
        $val = "";
        switch ($mes):
            case 1:
                $val = "enero = ?";
                break;
            case 2:
                $val = "febrero = ?";
                break;
            case 3:
                $val = "marzo = ?";
                break;
            case 4:
                $val = "abril = ?";
                break;
            case 5:
                $val = "mayo = ?";
                break;
            case 6:
                $val = "junio = ?";
                break;
            case 7:
                $val = "julio = ?";
                break;
            case 8:
                $val = "agosto = ?";
                break;
            case 9:
                $val = "septiembre = ?";
                break;
            case 10:
                $val = "octubre = ?";
                break;
            case 11:
                $val = "noviembre = ?";
                break;
            case 12:
                $val = "diciembre = ?";
                break;
        endswitch;
        $sql = "UPDATE op_ingresos_facturacion_contabilidad SET $val WHERE id=? ";
        $stmt = $this->con->prepare($sql);
        if(!$stmt):
            throw new Exception("Error al preparar la consulta". $this->con->error);
        endif;
        $stmt->bind_param("di", $valor, $id);
        if(!$stmt->execute()):
            $result = false;
            throw new Exception("Error al ejecutar la consulta". $stmt->error);
        endif;
        $stmt->close();
        return $result;
    }
    public function agregarArchivoIngreso(int $id, array $file): bool{
        $pdf = "";
        $result = true;
        $aleatorio = uniqid();
        $filePdf = $file['name'];
        $folderPDF = "../../../archivos/".$aleatorio."-".$filePdf;
        if(move_uploaded_file($file['tmp_name'], $folderPDF)) :
            $pdf = $aleatorio."-".$filePdf;
        endif;
        $sql = "INSERT INTO op_ingresos_facturacion_archivo (id_year, archivo) VALUES (?,?)";
        $stmt = $this->con->prepare($sql);
        if(!$stmt):
            throw new Exception("Error al preparar la consulta". $this->con->error);
        endif;
        $stmt->bind_param("is", $id,$pdf);
        if(!$stmt->execute()):
            $result = false;
            throw new Exception("Error al ejecutar la consulta". $stmt->error);
        endif;
        $stmt->close();
        return $result;
    }
    public function eliminarArchivoIngresos(int $id):bool{
        $result = true;
        $sql = "DELETE FROM op_ingresos_facturacion_archivo WHERE id = ? ";
        $stmt = $this->con->prepare($sql);
        if(!$stmt):
            throw new Exception("Error al preparar la consulta". $this->con->error);
        endif;
        $stmt->bind_param("i", $id);
        if(!$stmt->execute()):
            $result = false;
            throw new Exception("Error al ejecutar la consulta". $stmt->error);
        endif;
        $stmt->close();
        return $result;
    }
}