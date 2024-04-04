<?php
require "../help.php";
class CorteDiario{
    private $ClassConexionBD;
    private $con;
    public function __construct(){

        $this->ClassConexionBD = Database::getInstance();
        $this->con = $this->ClassConexionBD->getConnection();

    }
    public function agregarArchivoSolicitudCheque(){
        
    }
}
?>