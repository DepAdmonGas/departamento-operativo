<?php
require "../../bd/inc.conexion.php";
class Formatos{
    private $classConexionBD;
    private $con;
    public function __construct()
    {
        $this->classConexionBD = Database::getInstance();
        $this->con = $this->classConexionBD->getConnection();
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
    public function guardarPersonal(array $doc,int $idReporte,string $fechaIngreso,string $nombres, string $apellidoP,string $apellidoM,int $puesto, float $salario, string $detalle): bool{
        $resultado = true;
        $sql = "INSERT INTO op_rh_formatos_alta (
            id_formulario, fecha_ingreso, nombres, apellido_p, apellido_m, puesto,sd, detalle)
                VALUES 
                (?,?,?,?,?,?,?,?)";
        $result = $this->con->prepare($sql);
        if (!$result) :
            throw new Exception("Error al preparar la consulta \n". $this->con->error);
        endif;
        $result->bind_param("issssids", $idReporte,$fechaIngreso,$nombres,$apellidoP,$apellidoM,$puesto,$salario,$detalle);
        if (!$result->execute()) :
            $resultado = false;
            throw new Exception("Error al ejecutar la consulta". $result->error);
        endif;
        $result->close();
        // se actualiza la consulta en caso de que contenga algun alchivo
        $aleatorio = uniqid();
        $campo = "";
        if(!empty($doc[0]) && isset($doc[0]['name'])):
            $campo = "documento = ?";
            $doc1 = $doc[0]['name'];
            $UpDoc1 = "../../../archivos/".$aleatorio."-".$doc1;
            move_uploaded_file($doc[0]['tmp_name'], $UpDoc1);
            $NomDoc1 = $aleatorio."-".$doc1;
            $this->guardarPersonalDocumento($idReporte,$campo,$NomDoc1);
        elseif(!empty($doc[1]) && isset($doc[1]['name'])):
            $campo = "curp = ?";
            $doc1 = $doc[1]['name'];
            $UpDoc1 = "../../../archivos/documentos-personal/curp/".$aleatorio."-".$doc1;
            move_uploaded_file($doc[1]['tmp_name'], $UpDoc1);
            $NomDoc1 = $aleatorio."-".$doc1;
            $this->guardarPersonalDocumento($idReporte,$campo,$NomDoc1);
        elseif(!empty($doc[2]) && isset($doc[2]['name'])):
            $campo = "rfc = ?";
            $doc1 = $doc[2]['name'];
            $UpDoc1 = "../../../archivos/documentos-personal/rfc/".$aleatorio."-".$doc1;
            move_uploaded_file($doc[2]['tmp_name'], $UpDoc1);
            $NomDoc1 = $aleatorio."-".$doc1;
            $this->guardarPersonalDocumento($idReporte,$campo,$NomDoc1);
        elseif(!empty($doc[3]) && isset($doc[3]['name'])):
            $campo = "nss = ?";
            $doc1 = $doc[3]['name'];
            $UpDoc1 = "../../../archivos/documentos-personal/nss/".$aleatorio."-".$doc1;
            move_uploaded_file($doc[3]['tmp_name'], $UpDoc1);
            $NomDoc1 = $aleatorio."-".$doc1;
            $this->guardarPersonalDocumento($idReporte,$campo,$NomDoc1);
        elseif(!empty($doc[4]) && isset($doc[4]['name'])):
            $campo = "ine = ?";
            $doc1 = $doc[4]['name'];
            $UpDoc1 = "../../../archivos/documentos-personal/ine/".$aleatorio."-".$doc1;
            move_uploaded_file($doc[4]['tmp_name'], $UpDoc1);
            $NomDoc1 = $aleatorio."-".$doc1;
            $this->guardarPersonalDocumento($idReporte,$campo,$NomDoc1);
        endif;
        return $resultado;
    }
    private function guardarPersonalDocumento(int $id,string $campo,string $nombre): void {
        $sql = "UPDATE op_rh_formatos_alta SET $campo WHERE id_formulario = ?";
        $stmt = $this->con->prepare($sql);
        if(!$stmt):
            throw new Exception("Error al preparar la consulta\n".$this->con->error);
        endif;
        $stmt->bind_param("si",$nombre,$id);
        if(!$stmt->execute()):
            throw new Exception("Error al ejecutar la consulta\n".$stmt->error);
        endif;
        $stmt->close();
    }
}