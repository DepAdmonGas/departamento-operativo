<?php
require "../../bd/inc.conexion.php";
require_once '../../modelo/HerramientasDptoOperativo.php';
class Organigrama{
    private $classConexionBD;
    private $con;
    private $formato;
    private $herramientasDptoOperativo;

    
    public function __construct()
    {
 
        $this->classConexionBD = Database::getInstance();
        $this->con = $this->classConexionBD->getConnection();
        $this->formato = new herramientasDptoOperativo($this->con);
    }
    public function agregarOrganigrama(int $idEstacion,string $observaciones,array $doc) : bool {
        
        $resultado = true;
        $aleatorio = uniqid();
        $file  =   $doc['name'];
        $upload_folder = "../../../archivos/organigrama/".$aleatorio."-".$file;
        $imagen = $aleatorio."-".$file;
        $idVersion = $this->idVersion($idEstacion);
        if(move_uploaded_file($doc['tmp_name'], $upload_folder)) :
            $sql_insert = "INSERT INTO op_rh_organigrama_estacion (
            id_estacion, version, archivo, observaciones
                )VALUES (?,?,?,?)";
            $result = $this->con->prepare($sql_insert);
            if(!$result) :
                throw new Exception ("Error al preparar la consulta",$this->con->error);
            endif;
            $result->bind_param("iiss",$idEstacion,$idVersion,$imagen, $observaciones);
            if(!$result->execute()):
                $resultado = false;
                throw new Exception ("Error al ejecutar la consulta ",$result->error);
            endif;
        endif;
        return $resultado;
    }
    private function idVersion($idEstacion): int{
        $version = 0;
        $numid = 0;
        $sql_usuario = "SELECT version FROM op_rh_organigrama_estacion WHERE id_estacion = ? ORDER BY version desc LIMIT 1";
        $result_usuario = $this->con->prepare($sql_usuario);
        $result_usuario->bind_param("i",$idEstacion);
        $result_usuario->execute();
        $result_usuario->bind_result($version);
        $result_usuario->store_result();
        $num = $result_usuario->num_rows;
        if ($num == 0) :
            $numid = 1;
        else:
            $result_usuario->fetch();
            $numid = $version + 1 ;
        endif;
        $result_usuario->close();
        return $numid;
    }
    public function eliminarOrganigrama(int $id) : bool {
        $resultado = true;
        $sql = "DELETE FROM op_rh_organigrama_estacion WHERE id= ? ";
        $result = $this->con->prepare($sql);
        $result->bind_param("i",$id);
        $result->execute();
        $result->close();
        return $resultado;
    }
}