<?php 
error_reporting(0);
include_once "../bd/inc.conexion.php";

date_default_timezone_set('America/Mexico_City');
$fechaHoy = date("Y-m-d");

ValidaEstacion(1,$fechaHoy,$con);
ValidaEstacion(2,$fechaHoy,$con);
ValidaEstacion(3,$fechaHoy,$con);
ValidaEstacion(4,$fechaHoy,$con);
ValidaEstacion(5,$fechaHoy,$con);
ValidaEstacion(6,$fechaHoy,$con);
ValidaEstacion(7,$fechaHoy,$con);
ValidaEstacion(9,$fechaHoy,$con);

function ValidaEstacion($idEstacion,$fechaHoy,$con){
$sql_personal = "SELECT
op_rh_personal.id,
op_rh_personal.id_estacion,
op_rh_personal.nombre_completo,
op_rh_personal.puesto AS idPuesto,
op_rh_personal.curp,
op_rh_personal.sd,
op_rh_puestos.puesto,
op_rh_personal.documentos,
op_rh_personal.estado
FROM op_rh_personal
INNER JOIN op_rh_puestos 
ON op_rh_personal.puesto = op_rh_puestos.id
WHERE op_rh_personal.id_estacion = '".$idEstacion."' AND op_rh_personal.estado = 1 ORDER BY op_rh_personal.id ASC ";
$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);

while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){

$idPersonal = $row_personal['id'];
$nombreDias = nombreDia($fechaHoy);
$BuscarHorario = BuscarHorario($idPersonal,$nombreDias,$con);

AgregarAsistencia($idEstacion,$idPersonal,$fechaHoy,$BuscarHorario['horaentrada'],$BuscarHorario['horasalida'],$con);


}
}

function BuscarHorario($idPersonal,$nombreDias,$con){

$sql = "SELECT * FROM op_rh_personal_horario WHERE id_personal = '".$idPersonal."' AND dia = '".$nombreDias."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$horaentrada = $row['hora_entrada'];
$horasalida = $row['hora_salida'];
}

$array = array('horaentrada' => $horaentrada, 'horasalida' => $horasalida);

return $array;
}

function AgregarAsistencia($idEstacion,$idPersonal,$fecha,$horaentrada,$horasalida,$con){

$sql = "SELECT * FROM op_rh_personal_asistencia WHERE id_personal = '".$idPersonal."' AND fecha = '".$fecha."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);

if($numero == 0){

$Salario = Salario($idPersonal,$con);
$Retardo = Retardo($idEstacion,$con);
$Incidencias = Incidencias($idEstacion,$con);

$sql_insert = "INSERT INTO op_rh_personal_asistencia (
                    id_estacion,
                    id_personal,
                    fecha,
                    hora_entrada,
                    hora_salida,
                    hora_entrada_sensor,
                    hora_salida_sensor,
                    retardo_minutos,
                    incidencia_dias,
                    incidencia,
                    sd) 
                    VALUES (                    
                    '".$idEstacion."',
                    '".$idPersonal."', 
                    '".$fecha."', 
                    '".$horaentrada."', 
                    '".$horasalida."',
                    '', 
                    '',
                    '".$Retardo."',
                    '".$Incidencias."',
                    0,
                    '".$Salario."')";                                    
                    
                    mysqli_query($con, $sql_insert);


}
}

    function Retardo($idEmpresa,$con){

        $sql = "SELECT retardo FROM op_rh_localidades_retardo_incidencia WHERE id_estacion = '".$idEmpresa."' LIMIT 1 ";
        $result = mysqli_query($con, $sql);
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $return = $row['retardo'];
        }

        return $return;
    }

    function Incidencias($idEmpresa,$con){


        $sql = "SELECT incidencia FROM op_rh_localidades_retardo_incidencia WHERE id_estacion = '".$idEmpresa."' LIMIT 1 ";
        $result = mysqli_query($con, $sql);
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $return = $row['incidencia'];
        }

        return $return;
    }

function Salario($id,$con){

$sql_incidencia = "SELECT id, sd FROM op_rh_personal WHERE id = '".$id."' ORDER BY id DESC LIMIT 1 ";
            $result_incidencia = mysqli_query($con, $sql_incidencia);
            $numero_incidencia = mysqli_num_rows($result_incidencia);  
            while($row_incidencia = mysqli_fetch_array($result_incidencia, MYSQLI_ASSOC)){
            $salario = $row_incidencia['sd'];
            }

            return $salario;  
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

//------------------
mysqli_close($con);
//------------------

