<?php
include_once 'lib/jwt/vendor/autoload.php';
include_once "config/inc.configuracion.php";
include_once "config/ConfiguracionSesiones.php";
include_once "bd/inc.conexion.php";
include_once "modelo/Encriptar.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$ClassEncriptar = new Encriptar();

// Crea una instancia de la clase Database
$database = new Database();

// Obtén una instancia y obtiene la  conexión a la base de datos
$con = $database->getInstance()->getConnection();

// Instancia la clase configuracion-sesiones
$configuracionSesiones = new ConfiguracionSesiones();

// Obtiene keyJWT
$keyJWT = $configuracionSesiones->obtenerKey();

date_default_timezone_set('America/Mexico_City');
$fecha_del_dia = date("Y-m-d");
$hora_del_dia = date("H:i:s");
$hoy = date("Y-m-d H:i:s");

$fecha_year = date("Y");
$fecha_mes = date("m");
$fecha_dia = date("d");
// Valida si esta activa la sesion por medio de la cookie
if (isset($_COOKIE['COOKIEADMONGAS']) && !empty($_COOKIE['COOKIEADMONGAS'])) {
    $token = $_COOKIE['COOKIEADMONGAS'];
    try{
        $decoded = JWT::decode($token, new Key($keyJWT, 'HS256'));
        $Session_IDUsuarioBD   =   $decoded->id_usuario;
        $session_nomusuario    =   $decoded->nombre_usuario;
        $Session_IDEstacion    =   $decoded->id_gas_usuario;
        $session_idpuesto      =   $decoded->id_puesto_usuario;
        $session_nomestacion   =   $decoded->nombre_gas_usuario;
        $session_nompuesto     =   $decoded->tipo_puesto_usuario;
    }catch(Exception $e){
        echo 'Error: ', $e->getMessage();
    }
}else{
    $database->disconnect();
    header("Location:".PORTAL."");
    die();    
}

//--------------------------------------------------------------------------------
//---------------------------------Formato Fechas---------------------------------
function nombremes($mes){

if ($mes=="01") $mes="Enero";
if ($mes=="02") $mes="Febrero";
if ($mes=="03") $mes="Marzo";
if ($mes=="04") $mes="Abril";
if ($mes=="05") $mes="Mayo";
if ($mes=="06") $mes="Junio";
if ($mes=="07") $mes="Julio";
if ($mes=="08") $mes="Agosto";
if ($mes=="09") $mes="Septiembre";
if ($mes=="10") $mes="Octubre";
if ($mes=="11") $mes="Noviembre";
if ($mes=="12") $mes="Diciembre";

return $mes;
}

function get_nombre_dia($fecha){
   $fechats = strtotime($fecha);
switch (date('w', $fechats)){
    case 0: return "Domingo"; break;
    case 1: return "Lunes"; break;
    case 2: return "Martes"; break;
    case 3: return "Miercoles"; break;
    case 4: return "Jueves"; break;
    case 5: return "Viernes"; break;
    case 6: return "Sabado"; break;
}
}

     function nombreDia($fecha){

        $fechaTS = strtotime($fecha);
        switch(date('w', $fechaTS)){
            case 0: return "Domingo"; break;
            case 1: return "Lunes"; break;
            case 2: return "Martes"; break;
            case 3: return "Miércoles"; break;
            case 4: return "Jueves"; break;
            case 5: return "Viernes"; break;
            case 6: return "Sábado"; break;           

        }
    }

function FormatoFecha($fechaFormato){
  $formato_fecha = explode("-",$fechaFormato);
  $resultado = get_nombre_dia($fechaFormato)." ".$formato_fecha[2]." de ".nombremes($formato_fecha[1])." del ".$formato_fecha[0];
  return $resultado;
}

//--------------------------------------------------------------------------------