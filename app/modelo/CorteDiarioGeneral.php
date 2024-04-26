<?php
include_once "app/bd/inc.conexion.php";
class CorteDiarioGeneral extends Exception
{
    private $classConexionBD;
    private $con;
    private $formato;
    public function __construct()
    {

        $this->classConexionBD = new Database();
        $this->con = $this->classConexionBD->getInstance()->getConnection();
    }
    /***
     * 
     * 
     * 
     *      CORTE VENTAS
     * 
     * 
     */
    public function firma(int $idReporte, string $detalle, string $rutafirma): string
    {
        $sql_firma = "SELECT
            tb_usuarios.nombre,
            op_corte_dia_firmas.firma,
            op_corte_dia_firmas.fecha
            FROM op_corte_dia_firmas
            INNER JOIN tb_usuarios
            ON op_corte_dia_firmas.id_usuario = tb_usuarios.id WHERE id_reportedia  = ? AND detalle = ? ORDER BY op_corte_dia_firmas.id DESC LIMIT 1 ";
        $result_firma = $this->con->prepare($sql_firma);
        if (!$result_firma):
            throw new Exception("Error al preparar la consulta" . $this->con->error);
        endif;
        $result_firma->bind_param("is", $idReporte, $detalle);
        if (!$result_firma->execute()):
            throw new Exception("" . $result_firma->error);
        endif;
        $result_firma->bind_result($nombre, $firma, $fecha);
        while ($result_firma->fetch()):
            $explode = explode(' ', $fecha);
        endwhile;
        $result_firma->close();
        $contenido = '';
        if ($detalle == "Elaboró") :
            $contenido .= '<div class="text-center mt-1">';
            $contenido .= '<img src="' . $rutafirma . $firma . '" width="150px" height="70px">';
            $contenido .= '<div class="text-center mt-1 border-top pt-2"><b>' . $nombre . '</b></div>';
            $contenido .= '</div>';
        elseif ($detalle == "Superviso" || $detalle == "VoBo") :
            $NewFecha = date("Y-m-d", strtotime($explode[0] . "+ 2 days"));
            $timestamp1 = strtotime(date("Y-m-d"));
            $timestamp2 = strtotime($NewFecha);
            if ($timestamp1 >= $timestamp2) :
                $Detalle = '<div class="border-bottom text-center p-3" style="font-size: 0.95em;"><small>El formato se firmó por un medio electrónico.</br> <b>Fecha: ' . FormatoFecha($explode[0]) . ', ' . date("g:i a", strtotime($explode[1])) . '</b></small></div>';
                $contenido .= '<div class="">';
                $contenido .= $Detalle;
                $contenido .= '<div class="mb-1 text-center pt-2"><b>' . $nombre . '</b></div>';
                $contenido .= '</div>';
            else :
                $contenido .= '<div class="text-center mt-1">';
                $contenido .= '<div class="p-2"><small>No se encontró firma del corte diario</small></div>';
                $contenido .= '<div class="text-center mt-1 border-top pt-2"></div>';
                $contenido .= '</div>';
            endif;
        endif;
        $this->classConexionBD->disconnect();
        return $contenido;
    }
    public function validaFirma($idReporte, $detalle) : string
    {

        $sql_firma = "SELECT
            op_corte_dia_firmas.id_usuario, 
            op_corte_dia_firmas.firma,
            tb_usuarios.nombre
            FROM op_corte_dia_firmas
            INNER JOIN tb_usuarios
            ON op_corte_dia_firmas.id_usuario = tb_usuarios.id WHERE id_reportedia = ? AND detalle = ?";
        $result_firma = $this->con->prepare($sql_firma);
        if (!$result_firma) :
            throw new Exception("Error al preparar la consulta: " . $this->con->error);
        endif;
        $result_firma->bind_param("is", $idReporte, $detalle);
        if (!$result_firma->execute()) :
            throw new Exception("Error al ejecutar la consulta: " . $result_firma->error);
        endif;
        $result_firma->store_result();
        $numero_lista = $result_firma->num_rows;
        $this->classConexionBD->disconnect();
        return $numero_lista;
    }
    public function getEstado( int $idReporte):string{
        $sql_dia = "SELECT ventas FROM op_corte_dia WHERE id = ?";
        $result_dia = $this->con->prepare($sql_dia);
        if (!$result_dia) :
            throw new Exception("Error al preparar la consulta: " . $this->con->error);
        endif;
        $result_dia->bind_param("i", $idReporte);
        if (!$result_dia->execute()) :
            throw new Exception("Error al ejecutar la consulta: " . $result_dia->error);
        endif;
        $result_dia->bind_result($ventas);
        $result_dia->fetch();
        $result_dia->close();
        $this->classConexionBD->disconnect();
        return $ventas;
    }
    public function getDia(int $idReporte) : string {
        $sql_dia = "SELECT fecha FROM op_corte_dia WHERE id = ? ";
        $result_dia = $this->con->prepare($sql_dia);
        if (!$result_dia) :
            throw new Exception("Error al preparar la consulta: " . $this->con->error);
        endif;
        $result_dia->bind_param("i", $idReporte);
        if (!$result_dia->execute()) :
            throw new Exception("Error al ejecutar la consulta: " . $result_dia->error);
        endif;
        $result_dia->bind_result($dia);
        $result_dia->fetch();
        $result_dia->close();
        $this->classConexionBD->disconnect();
        return $dia;
    }
    public function getObsevaciones(int $idReporte): string {
        $sql_observaciones = "SELECT observaciones FROM op_observaciones WHERE idreporte_dia = ?";
        $result_observaciones = $this->con->prepare($sql_observaciones);
        if (!$result_observaciones) :
            throw new Exception("Error al preparar la consulta: " . $this->con->error);
        endif;
        $result_observaciones->bind_param("i", $idReporte);
        if (!$result_observaciones->execute()) :
            throw new Exception("Error al ejecutar la consulta: " . $result_observaciones->error);
        endif;
        $result_observaciones->bind_result($observaciones);
        $result_observaciones->fetch();
        if($observaciones == null):
            $observaciones = "";
        endif;
        return $observaciones;
    }
    /**
     * 
     * 
     *  CIRRE LOTE
     * 
     * 
     */
}