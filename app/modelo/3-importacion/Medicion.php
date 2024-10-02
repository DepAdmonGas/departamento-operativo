<?php
require "../../bd/inc.conexion.php";
class Medicion extends Exception{
    private $classConexionBD;
    private $con;
    public function __construct()
    {
        $this->classConexionBD = Database::getInstance();
        $this->con = $this->classConexionBD->getConnection();
    }
    public function guardarMedicion(int $idEstacion,string $fecha,string $factura,float $neto,float $bruto,float $cuentaLitros,string $provedor):bool{
        $result = true;
        $sql = "INSERT INTO op_mediciones (
            id_estacion,
            fecha,
            factura,
            neto,
            bruto,
            cuenta_litros,
            proveedor
            )VALUES (?,?,?,?,?,?,?)";
        $stmt = $this->con->prepare($sql);
        if(!$stmt):
            throw new Exception("Error al preparar la consulta".$this->con->error);
        endif;
        $stmt->bind_param("issddds",$idEstacion,$fecha,$factura,$neto,$bruto,$cuentaLitros,$provedor);
        if(!$stmt->execute()):
            $result = false;
            throw new Exception("Error al ejecutar la consulta".$stmt->error);
        endif;
        $stmt->close();
        return $result;
    }
    public function eliminarMedicion(int $id): bool{
        $result = true;
        $sql = "DELETE FROM op_mediciones WHERE id =?";
        $stmt = $this->con->prepare($sql);
        if(!$stmt):
            throw new Exception("Error al preparar la consulta".$this->con->error);
        endif;
        $stmt->bind_param("i",$id);
        if(!$stmt->execute()):
            $result =  false;
            throw new Exception("Error al ejecutar la consulta".$stmt->error);
        endif;
        $stmt->close();
        return $result;
    }
}