<?php
class CorteDiarioGeneral extends Exception
{
    private $con;
    public function __construct($con)
    {
        $this->con = $con;
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
        $nombre = "";
        $firma = "";
        $fecha = "";
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
        $result_firma->close();
        return $numero_lista;
    }
    public function getEstado( int $idReporte):string{
        $ventas = 0;
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
        return $ventas;
    }
    public function getDia(int $idReporte) : string {
        $dia = "";
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
        return $dia;
    }
    public function getObsevaciones(int $idReporte): string {
        $observaciones = "";
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
        $result_observaciones->close();
        return $observaciones;
    }
    /**
     * 
     * 
     *  MONEDERO
     * 
     * 
     */    
    public function tarjetasCB(int $idReporte, string $concepto) : float
    {
        $baucher = 0;
        $sql_cb = "SELECT baucher FROM op_tarjetas_c_b WHERE idreporte_dia = ? AND concepto = ? LIMIT 1 ";
        $result_cb = $this->con->prepare($sql_cb);
        if (!$result_cb) :
            throw new Exception("Error al preparar la consulta". $this->con->error);
        endif;
        $result_cb->bind_param("is",$idReporte,$concepto);
        if (!$result_cb->execute()) :
            throw new Exception("Error al ejecutar la consulta". $result_cb->error);
        endif;
        $result_cb->bind_result($baucher);
        $result_cb->fetch();
        if($baucher == null):
            $baucher = 0;
        endif;
        $result_cb->close();
        return $baucher;
    }
    public function clientesControlgas(string $nombre, int $idReporte,string $concepto) : float {
        $valor = 0;
        $sql = "SELECT $nombre FROM op_clientes_controlgas WHERE idreporte_dia = ? AND concepto = ? ";
        $stmt = $this->con->prepare($sql);
        if( !$stmt ) :
            throw new Exception("Error al preparar la consulta".$this->con->error);
        endif;
        $stmt->bind_param("is",$idReporte, $concepto);
        if (!$stmt->execute()) :
            throw new Exception("Error al ejecutar la consulta". $stmt->error);
        endif;
        $stmt->bind_result($valor);
        $stmt->fetch();
        if($valor == null):
            $valor = 0;
        endif;
        $stmt->close();
        return $valor;
    }
    /**
     * 
     * CIERRE LOTE
     * 
     * 
     */
    public function getTpv(int $idReporte) : int {
        $tpv = 0;
        $sql_dia = "SELECT tpv FROM op_corte_dia WHERE id = ? ";
        $stmt = $this->con->prepare($sql_dia);
        if (!$stmt) :
            throw new Exception("Error al preparar la consulta". $this->con->error);
        endif;
        $stmt->bind_param("i", $idReporte,);
        $stmt->execute();
        $stmt->bind_result($tpv);
        $stmt->fetch();
        if($tpv == null):
            $tpv = 0;
        endif;
        $stmt->close();
        return $tpv;
    }

    /**
     * 
     *  Resumen Impuestos
     * 
     * 
     */
    public function idReporte($Session_IDEstacion,$GET_year,$GET_mes)
    {
        $idmes = 0;
        $sql_mes = "SELECT id FROM op_corte_mes WHERE id_year = (SELECT id FROM op_corte_year WHERE id_estacion = ? AND year = ?) AND mes = ?";
        $stmt_mes = $this->con->prepare($sql_mes);
        if (!$stmt_mes) :
            throw new Exception("Error al preparar la consulta". $this->con->error);
        endif;
        $stmt_mes->bind_param("iss", $Session_IDEstacion, $GET_year, $GET_mes);
        $stmt_mes->execute();
        $stmt_mes->bind_result($idmes);
        $stmt_mes->fetch();
        $stmt_mes->close();
        return $idmes;
    }
    function obtenerListaDias(int $Session_IDEstacion, int $GET_year, int $GET_mes) : array{
        $sql_listadia = "
            SELECT
                op_corte_year.id_estacion,
                op_corte_year.year,
                op_corte_mes.mes,
                op_corte_dia.id AS idDia,
                op_corte_dia.fecha
            FROM op_corte_year
            INNER JOIN op_corte_mes ON op_corte_year.id = op_corte_mes.id_year
            INNER JOIN op_corte_dia ON op_corte_mes.id = op_corte_dia.id_mes 
            WHERE op_corte_year.id_estacion = ? AND op_corte_year.year = ? AND op_corte_mes.mes = ?";
        $stmt = $this->con->prepare($sql_listadia);
        if (!$stmt) :
            throw new Exception("Error al preparar la consulta". $this->con->error);
        endif;
        $stmt->bind_param("iss", $Session_IDEstacion, $GET_year, $GET_mes);
        $stmt->execute();
        $result_listadia = $stmt->get_result();
        $stmt->close();
        // Crear un array para almacenar los resultados
        $listaDias = array();
        // Recorrer los resultados y almacenarlos en el array
        while ($row_listadia = mysqli_fetch_assoc($result_listadia)) :
            $listaDias[] = $row_listadia;
        endwhile;
        // Retornar la lista de días
        return $listaDias;
    }
    public function inventarioFin($IdReporte) : int {
        // Consulta SQL preparada
        $sql_reporte = "SELECT id FROM op_aceites_lubricantes_reporte_finalizar WHERE id_mes = ? LIMIT 1";
        $stmt = $this->con->prepare($sql_reporte);
        if ($stmt === false) :
            throw new Exception("Error al preparar la consulta". $this->con->error);
        endif;
        // Vincular parámetros
        $stmt->bind_param("i", $IdReporte);
        $stmt->execute();
        // Obtener el resultado
        $stmt->store_result();
        $numero_reporte = $stmt->num_rows();
        $stmt->close();
        if ($numero_reporte == null) :
            $numero_reporte = 0;
        endif;
        // Retornar el número de filas encontradas
        return $numero_reporte;
    }
    
}
