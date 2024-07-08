<?php
require "../../bd/inc.conexion.php";
class Refaccion extends Exception{
    private $classConexionBD;
    private $con;
    public function __construct()
    {
        $this->classConexionBD = Database::getInstance();
        $this->con = $this->classConexionBD->getConnection();
    }

}