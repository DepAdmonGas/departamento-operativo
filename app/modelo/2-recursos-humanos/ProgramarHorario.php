<?php
require "../../bd/inc.conexion.php";
class Horarios extends Exception
{
    private $classConexionBD;
    private $con;
    public function __construct()
    {
        $this->classConexionBD = Database::getInstance();
        $this->con = $this->classConexionBD->getConnection();
    }
    public function agregarHorario(int $idEstacion): int
    {
        $id = $this->id();
        $estado = 0;
        $sql = "INSERT INTO op_rh_personal_horario_programar (id,id_estacion,estado)
            VALUES (?,?,?)";
        $stmt = $this->con->prepare($sql);
        if(!$stmt):
            throw new Exception("Error al preparar la consulta".$this->con->error);
        endif;
        $stmt->bind_param("iii",$id,$idEstacion,$estado);
        if (!$stmt->execute()) :
            $id = 0;
            throw new Exception("Error al ejecutar la consulta".$stmt->error);
        endif;
        return $id;
    }
    private function id() : int{
        $numid = 1;
        $sql = "SELECT id FROM op_rh_personal_horario_programar ORDER BY id DESC LIMIT 1";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $numero = $result->num_rows;
        if ($numero != 0) :
            $row = $result->fetch_assoc();
            $numid = $row['id'] + 1;
        endif;
        $stmt->close();
        return $numid;
    }
    public function eliminaHorario(int $idReporte): bool {
        $result = true;
        $sql = "DELETE FROM op_rh_personal_horario_programar WHERE id = ? ";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i",$idReporte);
        if(!$stmt->execute()):
            $result = false;
            throw new Exception("Error al ejecutar la consulta".$stmt->error);
        endif;
        $stmt->close();
        return $result;
    }
    public function guardarHorario(string $fecha, int $idReporte) : bool {
        $result = true;
        $estado = 1;
        $sql = "UPDATE op_rh_personal_horario_programar SET fecha = ?,estado = ? WHERE id = ? ";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("sii",$fecha,$estado,$idReporte);
        if(!$stmt->execute()):
            $result = false;
            throw new Exception("Error al ejecuar la consulta",$stmt->error);
        endif;
        return $result;
    }
    public function editarEstacion(string $hora,int $dia,int $idPersonal,int $idReporte,int $idEstacion):bool{
        $resultado = true;
        $sql = "SELECT id_estacion FROM op_rh_personal WHERE id = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param("i",$idPersonal);
        $result->execute();
        $result->bind_result($idEstacionConsulta);
        $result->fetch();
        $result->close();
        $idEstacionHorario = $idEstacionConsulta;
        if ($idEstacionConsulta == 9) :
            $idEstacionHorario = 2;
        endif;

        $NomDia = $this->nombreDia($dia);
        $HoraEntrada = "00:00:00";
        $HoraSalida = "00:00:00";
        if ($hora != "Descanso") :
            $sql = "SELECT hora_entrada,hora_salida FROM op_rh_localidades_horario WHERE id_estacion = ? AND titulo = ? ";
            $result = $this->con->prepare($sql);
            $result->bind_param("is",$idEstacionHorario,$hora);
            $result->execute();
            $result->bind_result($HoraEntrada,$HoraSalida);
            $result->fetch();
            $result->close();
        endif;
        $sql1 = "SELECT * FROM op_rh_personal_horario_programar_detalle WHERE id_reporte = ? AND id_personal = ? AND dia = ? ";
        $stmt = $this->con->prepare($sql1);
        $stmt->bind_param("iis",$idReporte,$idPersonal,$NomDia);
        $stmt->execute();
        $stmt->store_result();
        $stmt->fetch();
        $numero1 = $stmt->num_rows;
        $stmt->close();
        if ($numero1 > 0) :
            $sql2 = "UPDATE op_rh_personal_horario_programar_detalle SET 
            horario = ?,
            hora_entrada = ?,
            hora_salida = ? WHERE id_reporte = ? AND id_personal =? AND dia = ? ";
            $stmt = $this->con->prepare($sql2);
            $stmt->bind_param("sssiis",$hora,$HoraEntrada,$HoraSalida,$idReporte,$idPersonal,$NomDia);
            if(!$stmt->execute()):
                $resultado =  false;
                throw new Exception("Error al ejecutar la consulta de actualizacion".$stmt->error);
            endif;
            $stmt->close();
        else :
            $sql_insert = "INSERT INTO op_rh_personal_horario_programar_detalle  (
                id_reporte,
                id_estacion,
                id_personal,
                horario,
                dia,
                hora_entrada,
                hora_salida
                )VALUES (?,?,?,?,?,?,?)";
            $stmt = $this->con->prepare($sql_insert);
            $stmt->bind_param("iiissss",$idReporte,$idEstacion,$idPersonal,$hora,$NomDia,$HoraEntrada,$HoraSalida);
            if(!$stmt->execute()):
                $resultado = false;
                throw new Exception("Error al insertar la consulta".$stmt->error);
            endif;
            $stmt->close();
        endif;
        return $resultado;
    }
    private function nombreDia($dia): string{
        $result = "";
        switch($dia):
            case 1:
                $result = "Lunes";
                break;
            case 2:
                $result = "Martes";
                break;
            case 3:
                $result = "Miércoles";
                break;
            case 4:
                $result = "Jueves";
                break;
            case 5:
                $result = "Viernes";
                break;
            case 6:
                $result = "Sábado";
                break;
            case 7:
                $result = "Domingo";
                break;
        endswitch;
        return $result;
    }
}