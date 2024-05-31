<?php
require "../../bd/inc.conexion.php";
class Pivoteo extends Exception
{
    private $classConexionBD;
    private $con;
    public function __construct()
    {
        $this->classConexionBD = Database::getInstance();
        $this->con = $this->classConexionBD->getConnection();
    }
    public function agregarPivote(int $idEstacion): int
    {
        $idPivoteo = $this->idPivoteo();
        $noControl = $this->noControl($idEstacion);
        $result = $idPivoteo;
        $sql = "INSERT INTO op_pivoteo (id,id_estacion,nocontrol) VALUES(?,?,?)";
        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta" . $this->con->error);
        endif;
        $stmt->bind_param("iii", $idPivoteo, $idEstacion, $noControl);
        if (!$stmt->execute()):
            $result = false;
            throw new Exception("Error al ejecutar la consulta" . $stmt->error);
        endif;
        $stmt->close();
        return $result;
    }
    private function idPivoteo(): int
    {
        $sql = "SELECT id FROM op_pivoteo ORDER BY id DESC LIMIT 1";
        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta: " . $this->con->error);
        endif;
        if (!$stmt->execute()):
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        endif;
        $stmt->store_result();
        $stmt->bind_result($id);
        $num = $stmt->num_rows;
        if ($num > 0):
            $stmt->fetch();
            $id += 1;
        else:
            $id = 1;
        endif;
        $stmt->close();
        return $id;
    }

    private function noControl(int $estacion): int
    {
        $sql = "SELECT nocontrol FROM op_pivoteo WHERE id_estacion = ? ORDER BY nocontrol DESC LIMIT 1";
        $stmt = $this->con->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $this->con->error);
        }

        $stmt->bind_param('i', $estacion);
        $stmt->execute();
        $stmt->bind_result($nocontrol);
        $stmt->fetch();

        $Result = isset($nocontrol) ? $nocontrol + 1 : 1;

        $stmt->close();
        return $Result;
    }
    public function eliminaPivote(int $id): bool
    {
        $result = true;
        $sql = "DELETE FROM op_pivoteo WHERE id =? ";
        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("error al preparar la consulta" . $this->con->error);
        endif;
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()):
            $result = false;
            throw new Exception("Error el ejecutar la consulta" . $stmt->error);
        endif;
        $stmt->close();
        return $result;
    }
    public function detallePivoteo(int $idEstacion,int $idReporte,string $producto,string $tanque,float $litros,string $tad,string $unidad,string $chofer): bool {
        $result = true;
        $factura ="emitir nueva factura";
        $vacio = "";
        $cero = 0;
        $razonsocial = $this->razonSocial($idEstacion);
        $estacionfn = $this->validaEstacion($razonsocial);
        $sql = "INSERT INTO op_pivoteo_detalle (
            id_pivoteo,
            estacion_fc,
            destino_fc,
            producto_fc,
            tanque_fc,
            factura_fc,
            litros,
            tad,
            unidad,
            chofer,
            estacion_fn,
            destino_fn,
            tanque_fn,
            factura_fn
            )
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt=$this->con->prepare($sql);
        if(!$stmt):
            throw new Exception("Error al preparar la consulta".$this->con->error);
        endif;
        $stmt->bind_param("isssssdsssssss",$idReporte,$vacio,$cero,$producto,$tanque,$vacio,$litros,$tad,$unidad,$chofer,
                    $razonsocial,$estacionfn,$tanque,$factura);
        if(!$stmt->execute()):
            $result = false;
            throw new Exception("Error al ejecutar la consulta".$stmt->error);
        endif;
        $stmt->close();
        return $result;
    }
    private function validaEstacion(string $estacion): int
    {
        $result = 0;
        switch ($estacion):
            case "ADMINISTRADORA DE GASOLINERAS S.A. DE C.V.":
                $result = 19;
                break;
            case "ADMINISTRADORA DE GASOLINERAS INTERLOMAS":
                $result = 21;
                break;
            case "ADMINISTRADORA DE GASOLINERAS SAN AGUSTÍN S.A. DE C.V.":
                $result = 20;
                break;
            case "GASOMIRA S.A. DE C.V.":
                $result = 23;
                break;
            case "GASOLINERA VALLE DE GUADALUPE S.A. DE C.V.":
                $result = 22;
                break;
            case "ADMINISTRADORA DE GASOLINERAS ESMEGAS S.A. DE C.V.":
                $result = 24;
                break;
            case "ADMINISTRADORA DE GASOLINERAS XOCHIMILCO S.A. DE C.V.":
                $result = 38;
                break;
            case "Administradora de Gasolinerias Bosque Real, S. A. de C. V.":
                $result = 0;
                break;
            case "SERVICIO MENA, S.A. DE C.V.":
                $result = 127;
                break;
            case "SUPER SERVICIO VALLEJO, S.A. DE C.V.":
                $result = 182;
                break;
            case "SUPER SERVICIO PERIFERICO, S.A. DE C.V.":
                $result = 192;
                break;
            default:
                $result; // O algún valor por defecto si es necesario
                break;
        endswitch;
        return $result;
    }
    private function razonSocial($idEstacion): string {
        $result = "";
        $sql = "SELECT razonsocial FROM tb_estaciones WHERE id = ? ";
        $stmt =$this->con->prepare($sql);
        if(!$stmt):
            throw new Exception("Error al preparar la consulta".$this->con->error);
        endif;
        $stmt->bind_param("i",$idEstacion);
        if(!$stmt->execute()):
            throw new Exception("Error al ejecutar la consulta".$stmt->error);
        endif;
        $stmt->bind_result($razonsocial);

        if($stmt->fetch() && !empty($razonsocial)):
            $result = $razonsocial;
        endif;
        $stmt->close();
        return $result;
    }
    public function eliminaFactura(int $id):bool {
        $result = true;
        $sql = "DELETE FROM op_pivoteo_detalle WHERE id = ? ";
        $stmt = $this->con->prepare($sql);
        if(!$stmt):
            throw new Exception("error el preparar la consulta".$this->con->error);
        endif;
        $stmt->bind_param("i",$id);
        if(!$stmt->execute()):
            $result = false;
            throw new Exception("Error al prerar la consulta".$stmt->error);
        endif;
        $stmt->close();
        return $result;
    }
    public function finalizardetalleReporte(int $id): bool {
        $result = true;
        $sql = "UPDATE op_pivoteo SET estatus = 1 WHERE id = ? ";
        $stmt = $this->con->prepare($sql);
        if(!$stmt):
            throw new Exception("error el preparar la consulta".$this->con->error);
        endif;
        $stmt->bind_param("i",$id);
        if(!$stmt->execute()):
            $result = false;
            throw new Exception("Error al prerar la consulta".$stmt->error);
        endif;
        $stmt->close();
        return $result;
    }
}