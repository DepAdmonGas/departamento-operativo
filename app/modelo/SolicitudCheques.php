<?php
require "../bd/DataBase.php";
class solicitudCheque{
    private $classConexionBD;
    private $con;
    public function __construct(){

        $this->classConexionBD = new Database();
        $this->con = $this->classConexionBD->getInstance()->getConnection();

    }
    public function agregarArchivoSolicitudCheque(int $sessionIdUsuario,int $idReporte,String $documento): bool{
        $aleatorio = uniqid();
        $factura = "Factura contra entrega";
        $NoDoc1  =   $_FILES['Archivo_file']['name'];
        $UpDoc1 = "../../archivos/".$aleatorio."-".$NoDoc1;
        $NomDoc1 = $aleatorio."-".$NoDoc1;
        $result = false;
        if(move_uploaded_file($_FILES['Archivo_file']['tmp_name'], $UpDoc1)){
            $sql_insert = "INSERT INTO op_solicitud_cheque_documento (
            id_solicitud,
            nombre,
            documento
            )
            VALUES(?,?,?)";
            $stmt = $this->con->prepare($sql_insert);
            if($stmt){
                $stmt->bind_param("iss",$idReporte, $documento, $NomDoc1);
                if ($stmt->execute()) {
                    $result = true;
                } else {
                    throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
                }
                if($documento == 'COTIZACIÓN'){
                    $sqlComent = "INSERT INTO op_solicitud_cheque_comentario (
                        id_solicitud,
                        id_usuario,
                        comentario
                        )
                        VALUES(?,?,?)";
                    $stmt=$this->con->prepare($sqlComent);
                    $stmt->bind_param("iis",$idReporte, $sessionIdUsuario, $factura);
                    $stmt->execute();
                }
                $stmt->close();
            }else {
                throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
            }
        }
        $this->classConexionBD->disconnect();
        return $result;
    }
    public function agregarComentarioSolicitudCheque(int $sessionIdUsuario,int $idReporte, string $comentario): bool{
        $result = false;
        $sql_insert = "INSERT INTO op_solicitud_cheque_comentario (
            id_solicitud,
            id_usuario,
            comentario
            )
            VALUES 
            (
            '".$idReporte."',
            '".$sessionIdUsuario."',
            '".$comentario."'
            )";
        $stmt = $this->con->prepare($sql_insert);
        if($stmt->execute()){
            $result = true;
        }else{
            echo "Error en la consulta SQL: " . mysqli_error($this->con);
        }
        $this->classConexionBD->disconnect();
        return $result;
    }
}
?>