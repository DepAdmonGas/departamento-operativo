<?php
require "../../bd/inc.conexion.php";
class Despacho extends Exception
{
    private $classConexionBD;
    private $con;
    public function __construct()
    {
        $this->classConexionBD = Database::getInstance();
        $this->con = $this->classConexionBD->getConnection();
    }
    public function editarDespacho($input,int $dia, int $despacho): bool
    {
        $result =  true;
        $val = "";
        $bind = "di";
        if($despacho == 5 || $despacho == 6):
            $bind = "ii";
        endif;
        switch ($despacho):
            case 1:
                $val = "litros_producto_uno=?";
                break;
            case 2:
                $val = "litros_producto_dos=?";
                break;
            case 3:
                $val = "litros_producto_tres=?";
                break;
            case 4:
                $val = "pesos_producto_uno=?";
                break;
            case 5:
                $val = "pesos_producto_dos=?";
                break;
            case 6:
                $val = "pesos_producto_tres=?";
                break;
        endswitch;
        $sql = "UPDATE op_despacho_factura SET $val WHERE id_dia=? ";
        $stmt = $this->con->prepare($sql);
        if(!$stmt):
            throw new Exception("Error al preparar la consulta".$this->con->error);
        endif;
        $stmt->bind_param($bind, $input, $dia);
        if(!$stmt->execute()):
            $result = false;
            throw new Exception("Error al ejecutar la consulta".$stmt->error);
        endif;
        $stmt->close();
        return $result;
    }
}