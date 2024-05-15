<?php
require_once 'FormatoFechas.php';
class CorteDiarioGeneral extends Exception
{
    private $con;
    private $formato;
    public function __construct($con)
    {
        $this->con = $con;
        $this->formato = new FormatoFechas();
    }

    /* ------------------------------ PUNTO 1. CORTE DIARIO ------------------------------ */

    /* ---------- Corte Diario - Mes ---------- */
    public function validaFechaReporte($IdReporte, $GET_year, $GET_mes, $Pdia)
    {
        $fecha = $GET_year . "-" . $GET_mes . "-" . $Pdia;
        $sql_reporte = "SELECT id, id_mes, fecha FROM op_corte_dia WHERE id_mes = ? AND fecha = ?";
        $stmt_reporte = $this->con->prepare($sql_reporte);

        if (!$stmt_reporte):
            throw new Exception("Error al preparar la consulta" . $this->con->error);
        endif;

        $stmt_reporte->bind_param("is", $IdReporte, $fecha);
        if (!$stmt_reporte->execute()):
            throw new Exception("Error al ejecutar la consulta" . $stmt_reporte->error);
        endif;

        $result_reporte = $stmt_reporte->get_result();
        $numero_reporte = $result_reporte->num_rows;

        if ($numero_reporte == 0):
            $sql_insert = "INSERT INTO op_corte_dia (id_mes,fecha,ventas,tpv,monedero) VALUES (?,?,0,0,0)";
            $stmt_insert = $this->con->prepare($sql_insert);

            if (!$stmt_insert):
                throw new Exception("Error al preparar la consulta" . $this->con->error);
            endif;

            $stmt_insert->bind_param("is", $IdReporte, $fecha);
            if (!$stmt_insert->execute()):
                throw new Exception("Error al ejecutar la consulta" . $stmt_insert->error);
            endif;

            $stmt_insert->close();
        endif;
        $stmt_reporte->close();
    }
    public function ultimoDia($GET_year, $GET_mes)
    {
        $month = $GET_mes;
        $year = $GET_year;
        $day = date("d", mktime(0, 0, 0, $month + 1, 0, $year));
        return date('d', mktime(0, 0, 0, $month, $day, $year));
    }

    public function primerDia($GET_year, $GET_mes)
    {
        $month = $GET_mes;
        $year = $GET_year;
        return date('d', mktime(0, 0, 0, $month, 1, $year));
    }


    /* ---------- Corte Ventas ---------- */
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
ON op_corte_dia_firmas.id_usuario = tb_usuarios.id 
WHERE id_reportedia  = ? AND detalle = ? ORDER BY op_corte_dia_firmas.id DESC LIMIT 1 ";

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

        if ($detalle == "Elaboró"):
            $contenido .= '<div class="text-center mt-1">';
            $contenido .= '<img src="' . $rutafirma . $firma . '" width="150px" height="70px">';
            $contenido .= '<div class="text-center mt-1 border-top pt-2"><b>' . $nombre . '</b></div>';
            $contenido .= '</div>';

        elseif ($detalle == "Superviso" || $detalle == "VoBo"):
            $NewFecha = date("Y-m-d", strtotime($explode[0] . "+ 2 days"));
            $timestamp1 = strtotime(date("Y-m-d"));
            $timestamp2 = strtotime($NewFecha);

            if ($timestamp1 >= $timestamp2):
                $Detalle = '<div class="border-bottom text-center p-3" style="font-size: 0.95em;"><small>El formato se firmó por un medio electrónico.</br> <b>Fecha: ' . FormatoFecha($explode[0]) . ', ' . date("g:i a", strtotime($explode[1])) . '</b></small></div>';
                $contenido .= '<div class="">';
                $contenido .= $Detalle;
                $contenido .= '<div class="mb-1 text-center pt-2"><b>' . $nombre . '</b></div>';
                $contenido .= '</div>';

            else:
                $contenido .= '<div class="text-center mt-1">';
                $contenido .= '<div class="p-2"><small>No se encontró firma del corte diario</small></div>';
                $contenido .= '<div class="text-center mt-1 border-top pt-2"></div>';
                $contenido .= '</div>';
            endif;

        endif;

        return $contenido;
    }

    public function validaFirma($idReporte, $detalle): string
    {

        $sql_firma = "SELECT
op_corte_dia_firmas.id_usuario, 
op_corte_dia_firmas.firma,
tb_usuarios.nombre
FROM op_corte_dia_firmas
INNER JOIN tb_usuarios
ON op_corte_dia_firmas.id_usuario = tb_usuarios.id 
WHERE id_reportedia = ? AND detalle = ?";
        $result_firma = $this->con->prepare($sql_firma);

        if (!$result_firma):
            throw new Exception("Error al preparar la consulta: " . $this->con->error);
        endif;

        $result_firma->bind_param("is", $idReporte, $detalle);
        if (!$result_firma->execute()):
            throw new Exception("Error al ejecutar la consulta: " . $result_firma->error);
        endif;

        $result_firma->store_result();
        $numero_lista = $result_firma->num_rows;
        $result_firma->close();

        return $numero_lista;
    }

    public function getEstado(int $idReporte): string
    {
        $ventas = 0;
        $sql_dia = "SELECT ventas FROM op_corte_dia WHERE id = ?";
        $result_dia = $this->con->prepare($sql_dia);

        if (!$result_dia):
            throw new Exception("Error al preparar la consulta: " . $this->con->error);
        endif;

        $result_dia->bind_param("i", $idReporte);
        if (!$result_dia->execute()):
            throw new Exception("Error al ejecutar la consulta: " . $result_dia->error);
        endif;

        $result_dia->bind_result($ventas);
        $result_dia->fetch();
        $result_dia->close();

        return $ventas;
    }
    public function getDia(int $idReporte): string
    {
        $dia = "";
        $sql_dia = "SELECT fecha FROM op_corte_dia WHERE id = ? ";
        $result_dia = $this->con->prepare($sql_dia);

        if (!$result_dia):
            throw new Exception("Error al preparar la consulta: " . $this->con->error);
        endif;

        $result_dia->bind_param("i", $idReporte);
        if (!$result_dia->execute()):
            throw new Exception("Error al ejecutar la consulta: " . $result_dia->error);
        endif;

        $result_dia->bind_result($dia);
        $result_dia->fetch();
        $result_dia->close();
        return $dia;
    }

    public function getObsevaciones(int $idReporte): string
    {
        $observaciones = "";
        $sql_observaciones = "SELECT observaciones FROM op_observaciones WHERE idreporte_dia = ?";
        $result_observaciones = $this->con->prepare($sql_observaciones);

        if (!$result_observaciones):
            throw new Exception("Error al preparar la consulta: " . $this->con->error);
        endif;

        $result_observaciones->bind_param("i", $idReporte);
        if (!$result_observaciones->execute()):
            throw new Exception("Error al ejecutar la consulta: " . $result_observaciones->error);
        endif;

        $result_observaciones->bind_result($observaciones);
        $result_observaciones->fetch();
        if ($observaciones == null):
            $observaciones = "";
        endif;

        $result_observaciones->close();
        return $observaciones;
    }


    /* ---------- Monedero ---------- */
    public function tarjetasCB(int $idReporte, string $concepto): float
    {
        $baucher = 0;
        $sql_cb = "SELECT baucher FROM op_tarjetas_c_b WHERE idreporte_dia = ? AND concepto = ? LIMIT 1 ";
        $result_cb = $this->con->prepare($sql_cb);
        if (!$result_cb):
            throw new Exception("Error al preparar la consulta" . $this->con->error);
        endif;
        $result_cb->bind_param("is", $idReporte, $concepto);

        if (!$result_cb->execute()):
            throw new Exception("Error al ejecutar la consulta" . $result_cb->error);
        endif;

        $result_cb->bind_result($baucher);
        $result_cb->fetch();

        if ($baucher == null):
            $baucher = 0;
        endif;

        $result_cb->close();
        return $baucher;
    }
    public function clientesControlgas(string $nombre, int $idReporte, string $concepto): float
    {
        $valor = 0;
        $sql = "SELECT $nombre FROM op_clientes_controlgas WHERE idreporte_dia = ? AND concepto = ? ";
        $stmt = $this->con->prepare($sql);

        if (!$stmt):
            throw new Exception("Error al preparar la consulta" . $this->con->error);
        endif;

        $stmt->bind_param("is", $idReporte, $concepto);
        if (!$stmt->execute()):
            throw new Exception("Error al ejecutar la consulta" . $stmt->error);
        endif;

        $stmt->bind_result($valor);
        $stmt->fetch();

        if ($valor == null):
            $valor = 0;
        endif;

        $stmt->close();
        return $valor;
    }

    /* ---------- Cierre Lote ---------- */
    public function getTpv(int $idReporte): int
    {
        $tpv = 0;
        $sql_dia = "SELECT tpv FROM op_corte_dia WHERE id = ? ";
        $stmt = $this->con->prepare($sql_dia);

        if (!$stmt):
            throw new Exception("Error al preparar la consulta" . $this->con->error);
        endif;
        $stmt->bind_param("i", $idReporte, );
        $stmt->execute();
        $stmt->bind_result($tpv);
        $stmt->fetch();

        if ($tpv == null):
            $tpv = 0;
        endif;
        $stmt->close();
        return $tpv;
    }

    /* ---------- Resumen Impuestos ---------- */
    public function idReporte($Session_IDEstacion, $GET_year, $GET_mes): int
    {
        $idmes = 0;
        $sql_mes = "SELECT id FROM op_corte_mes WHERE id_year = (SELECT id FROM op_corte_year WHERE id_estacion = ? AND year = ?) AND mes = ?";

        $stmt_mes = $this->con->prepare($sql_mes);
        if (!$stmt_mes):
            throw new Exception("Error al preparar la consulta" . $this->con->error);
        endif;

        $stmt_mes->bind_param("iss", $Session_IDEstacion, $GET_year, $GET_mes);
        if ($stmt_mes->execute()):
            $stmt_mes->bind_result($idmes);
            $stmt_mes->fetch();
            $stmt_mes->close();
        endif;

        return $idmes;
    }
    function obtenerListaDias(int $Session_IDEstacion, int $GET_year, int $GET_mes): array
    {
        $sql_listadia = "SELECT
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
        if (!$stmt):
            throw new Exception("Error al preparar la consulta" . $this->con->error);
        endif;

        $stmt->bind_param("iss", $Session_IDEstacion, $GET_year, $GET_mes);
        $stmt->execute();
        $result_listadia = $stmt->get_result();
        $stmt->close();

        // Crear un array para almacenar los resultados
        $listaDias = array();
        // Recorrer los resultados y almacenarlos en el array
        while ($row_listadia = mysqli_fetch_assoc($result_listadia)):
            $listaDias[] = $row_listadia;
        endwhile;
        // Retornar la lista de días
        return $listaDias;
    }
    public function inventarioFin($IdReporte): int
    {
        // Consulta SQL preparada
        $sql_reporte = "SELECT id FROM op_aceites_lubricantes_reporte_finalizar WHERE id_mes = ? LIMIT 1";

        $stmt = $this->con->prepare($sql_reporte);
        if ($stmt === false):
            throw new Exception("Error al preparar la consulta" . $this->con->error);
        endif;
        // Vincular parámetros
        $stmt->bind_param("i", $IdReporte);
        $stmt->execute();
        // Obtener el resultado
        $stmt->store_result();
        $numero_reporte = $stmt->num_rows();
        $stmt->close();

        if ($numero_reporte == null):
            $numero_reporte = 0;
        endif;
        // Retornar el número de filas encontradas
        return $numero_reporte;
    }

    /* ---------- Clientes ---------- */
    function generarOpcionesClientes($Session_IDEstacion)
    {
        $sql_cliente = "SELECT id, cliente FROM op_cliente WHERE id_estacion = ?";

        $stmt_cliente = $this->con->prepare($sql_cliente);
        if (!$stmt_cliente):
            throw new Exception("Error al preparar la consulta: " . $this->con->error);
        endif;

        $stmt_cliente->bind_param("s", $Session_IDEstacion);
        if (!$stmt_cliente->execute()):
            throw new Exception("Error al ejecutar la consulta: " . $stmt_cliente->error);
        endif;

        $result_cliente = $stmt_cliente->get_result();
        $ocultar = "d-none"; // Por defecto, no se oculta

        while ($row_cliente = $result_cliente->fetch_assoc()):
            if (empty($row_cliente['cliente'])):
                $ocultar = "d-none"; // Si algún cliente está vacío, se oculta
            endif;
            echo '<option value="' . $row_cliente['id'] . '">' . $row_cliente['cliente'] . '</option>';
        endwhile;
    }

    public function resumenFinalizar(int $idReporte): int
    {
        $id = 0;
        $sql = "SELECT id FROM op_consumos_pagos_resumen_finalizar WHERE id_mes =? LIMIT 1 ";

        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("Error al preparar la consula" . $this->con->error);
        endif;

        $stmt->bind_param("i", $idReporte);
        if (!$stmt->execute()):
            throw new Exception("Error al ejecutar la consulta" . $stmt->error);
        endif;

        $stmt->bind_result($id);
        $stmt->fetch();
        $stmt->close();
        return $id;
    }
    public function resumen(int $IdReporte, int $idEstacion)
    {
        $id = 0;
        $sql = "SELECT id FROM op_cliente WHERE id_estacion = ? AND estado = 1 ";

        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta" . $this->con->error);
        endif;

        $stmt->bind_param("i", $idEstacion);
        if (!$stmt->execute()):
            throw new Exception("Error al ejecutar la consulta" . $stmt->error);
        endif;

        $stmt->bind_result($id);
        $stmt->fetch();
        $stmt->close();
        $this->validaResumen($IdReporte, $id);
    }

    private function validaResumen(int $IdReporte, int $id)
    {
        $sql = "SELECT * FROM op_consumos_pagos_resumen WHERE id_mes = ? AND id_cliente = ?";

        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta: " . $this->con->error);
        endif;

        $stmt->bind_param("ii", $IdReporte, $id);
        if (!$stmt->execute()):
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        endif;

        $result = $stmt->get_result();
        $numero = $result->num_rows;
        $val = 0;

        if ($numero == 0):
            $sql_insert = "INSERT INTO op_consumos_pagos_resumen (id_mes,id_cliente,saldo_inicial,consumos,pagos,saldo_final)VALUES(?,?,?,?,?,?)";

            $stmt_insert = $this->con->prepare($sql_insert);
            if (!$stmt_insert):
                throw new Exception("Error al preparar la inserción: " . $this->con->error);
            endif;

            $stmt_insert->bind_param("iiiiii", $IdReporte, $id, $val, $val, $val, $val);
            if (!$stmt_insert->execute()):
                throw new Exception("Error al ejecutar la inserción: " . $stmt_insert->error);
            endif;

            $stmt_insert->close();
        endif;

        $result->close();
    }

    public function actSaldoInicial(int $idReporte, int $idReporteA): void
    {
        $idResumen = 0;
        $idcliente = 0;
        $sql = "SELECT id,id_cliente FROM op_consumos_pagos_resumen WHERE id_mes = ? ";

        $result = $this->con->prepare($sql);
        if (!$result):
            throw new Exception("Error al preparar la consulta" . $this->con->error);
        endif;

        $result->bind_param("i", $idReporte);
        if (!$result->execute()):
            throw new Exception("Error al ejecutar la consulta" . $result->error);
        endif;

        $result->bind_result($idResumen, $idcliente);
        $result->close();

        $this->saldoInicial($idReporteA, $idResumen, $idcliente);
        $this->consumoPago($idResumen, $idReporte, $idcliente);
    }

    private function saldoInicial(int $idReporteA, int $idResumen, int $idcliente): void
    {
        $saldoFinal = "";
        $sql = "SELECT saldo_final FROM op_consumos_pagos_resumen WHERE id_mes = ? AND id_cliente = ? LIMIT 1";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("ii", $idReporteA, $idcliente);
        $stmt->execute();
        $stmt->store_result();
        $numero = $stmt->num_rows;

        if ($numero == 1):
            $stmt->bind_result($saldoFinal);
            $stmt->fetch();
            $stmt->close();

            if ($saldoFinal != 0):
                $sql_edit = "UPDATE op_consumos_pagos_resumen SET saldo_inicial = ? WHERE id = ?";
                $stmt_edit = $this->con->prepare($sql_edit);
                $stmt_edit->bind_param("di", $saldoFinal, $idResumen);
                $stmt_edit->execute();
                $stmt_edit->close();
            endif;

        endif;
    }

    private function consumoPago(int $idResumen, int $idReporte, int $idcliente): void
    {
        $reportedia = "";
        $sql = "SELECT id FROM op_corte_dia WHERE id_mes = ? ";

        $result = $this->con->prepare($sql);
        if (!$result):
            throw new Exception("Error al preparar la consulta" . $this->con->error);
        endif;

        $result->bind_param("i", $idReporte);
        if (!$result->execute()):
            throw new Exception("Error al ejecutar la consulta" . $result->error);
        endif;

        $result->bind_result($reportedia);
        $result->fetch();
        $result->close();
        $totalCo = 0;
        $totalPa = 0;
        $Consumo = $this->totalCP($reportedia, $idcliente, 'Consumo');
        $totalCo = $totalCo + $Consumo;
        $Pago = $this->totalCP($reportedia, $idcliente, 'Pago');
        $totalPa = $totalPa + $Pago;
        $sql_edit1 = "UPDATE op_consumos_pagos_resumen SET consumos = ?, pagos = ? WHERE id=? ";
        $query = $this->con->prepare($sql_edit1);
        $query->bind_param("ddi", $totalCo, $totalPa, $idResumen);
        $query->execute();
        $query->close();
    }
    private function totalCP(int $reportedia, int $idCliente, string $tipo): float
    {
        $sql_c = "SELECT total FROM op_consumos_pagos WHERE id_reportedia = ? AND id_cliente = ? AND tipo = ?";
        $stmt_c = $this->con->prepare($sql_c);
        $stmt_c->bind_param("iis", $reportedia, $idCliente, $tipo);
        $stmt_c->execute();
        $stmt_c->store_result();
        $numero_c = $stmt_c->num_rows;

        $total = 0;
        $total_row = 0;
        if ($numero_c > 0):
            $stmt_c->bind_result($total_row);
            while ($stmt_c->fetch()):
                $total += $total_row;
            endwhile;
        endif;

        $stmt_c->close();
        return $total;
    }
    public function actPagosConsumos(int $idReporte): void
    {
        $idResumen = 0;
        $idcliente = 0;
        $sql = "SELECT id,id_cliente FROM op_consumos_pagos_resumen WHERE id_mes = ? ";

        $result = $this->con->prepare($sql);
        $result->bind_param("i", $idReporte);
        $result->execute();
        $result->bind_result($idResumen, $idcliente);
        $result->fetch();
        $result->close();
        $this->consumoPago($idResumen, $idReporte, $idcliente);
    }

    public function actSaldoFinal($idReporte): void
    {
        $saldoFinal = 0;
        $idResumen = 0;
        $saldo = 0;
        $consumo = 0;
        $pago = 0;
        $sql = "SELECT id, saldo_inicial,consumos,pagos FROM op_consumos_pagos_resumen WHERE id_mes = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param("i", $idReporte);
        $result->execute();
        $result->bind_result($idResumen, $saldo, $consumo, $pago);
        $result->fetch();
        $result->close();
        $saldoFinal = $saldo + $consumo - $pago;
        $this->saldoFinal($idResumen, $saldoFinal);
    }

    private function saldoFinal($idResumen, $saldoFinal): void
    {
        $sql_edit1 = "UPDATE op_consumos_pagos_resumen SET saldo_final = ? WHERE id=? ";
        $stmt = $this->con->prepare($sql_edit1);
        $stmt->bind_param("di", $saldoFinal, $idResumen);
        $stmt->execute();
        $stmt->close();
    }

    public function getNumeroClientesPorTipo(int $idEstacion, string $tipo): int
    {
        $estado = 1;
        $sql = "SELECT * FROM op_cliente WHERE id_estacion = ? AND tipo = ? AND estado = ?";
        $numeroClientes = 0;
        if ($stmt = $this->con->prepare($sql)) {
            $stmt->bind_param("isi", $idEstacion, $tipo, $estado);
            $stmt->execute();
            $stmt->store_result();
            $numeroClientes = $stmt->num_rows();
            $stmt->close();
        }
        // Devuelve el número de clientes
        return $numeroClientes;
    }
    /**
     * 
     * 
     *  ACEITES
     * 
     * 
     * 
     */
    public function listaAceite(int $idEstacion, int $idReporte, int $InventarioFin): void
    {
        if ($InventarioFin == 0):
            $noAceite = 0;
            $concepto = "";
            $precio = 0;
            $exhibidores = 0;
            $bodega = 0;
            $sql = "SELECT
            op_aceites.id_aceite,
            op_aceites.concepto,
            op_aceites.precio,
            op_inventario_aceites.exhibidores,
            op_inventario_aceites.bodega
            FROM op_inventario_aceites
            INNER JOIN op_aceites
            ON op_inventario_aceites.id_aceite = op_aceites.id WHERE op_inventario_aceites.id_estacion = ? AND op_inventario_aceites.id_mes = ? ";
            $stmt = $this->con->prepare($sql);
            if (!$stmt):
                throw new Exception("Error al preparar la consulta" . $this->con->error);
            endif;
            $stmt->bind_param("ii", $idEstacion, $idReporte);
            if (!$stmt->execute()):
                throw new Exception("Error al ejecutar la consulta" . $stmt->error);
            endif;
            $stmt->bind_result($noAceite, $concepto, $precio, $exhibidores, $bodega);
            $stmt->close();
            $this->validAceites($idReporte, $noAceite, $concepto, $precio, $exhibidores, $bodega);

        endif;
    }
    private function validAceites(int $idReporte, int $noAceite, string $concepto, float $precio, int $exhibidores, int $bodega): void
    {
        $sql_reporte = "SELECT id_mes, concepto FROM op_aceites_lubricantes_reporte WHERE id_mes = ? AND concepto = ? ";
        $stmt = $this->con->prepare($sql_reporte);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta" . $this->con->error);
        endif;
        $stmt->bind_param("is", $idReporte, $concepto);
        if (!$stmt->execute()):
            throw new Exception("Error al ejecutar la consulta" . $stmt->error);
        endif;
        $numero_reporte = $stmt->num_rows;
        $stmt->close();
        if ($numero_reporte == 0) {
            $sql_insert = "INSERT INTO op_aceites_lubricantes_reporte (
            id_mes,
            id_aceite,
            concepto,
            precio,
            bodega,
            exibidores
            )
            VALUES (?,?,?,?,?,?)";
            $stmt1 = $this->con->prepare($sql_insert);
            $stmt1->bind_param("iisdii", $idReporte, $noAceite, $concepto, $precio, $bodega, $exhibidores);
            $stmt1->execute();
            $stmt1->close();
        }
    }
    public function pagoDiferencias(int $idReporte): void
    {
        $id = 0;
        $estado = 0;
        $nomaceite = 0;
        $diferencia = 0;
        $sql = "SELECT id,nomaceite,diferencia FROM op_aceites_lubricantes_reporte_pagodiferencia WHERE id_reporte = ? AND estado = ? ";
        $result = $this->con->prepare($sql);
        if (!$result):
            throw new Exception("Error al preparar la consulta" . $this->con->error);
        endif;
        $result->bind_param("ii", $idReporte, $estado);
        if (!$result->execute()):
            throw new Exception("Error al ejecutar la consulta" . $result->error);
        endif;
        $result->bind_result($id, $nomaceite, $diferencia);
        $result->close();
        $this->actualizarAlmacen($id, $idReporte, $nomaceite, $diferencia);
    }

    function actualizarAlmacen(int $id, int $idReporte, int $idAceite, int $diferencia)
    {
        $idLubricante = 0;
        $bodega = 0;
        $estado = 1;
        $sql1 = "SELECT id, bodega FROM op_aceites_lubricantes_reporte WHERE id_mes = ? AND id_aceite = ? ";
        $result = $this->con->prepare($sql1);
        if (!$result):
            throw new Exception("Error al preparar la consulta" . $this->con->error);
        endif;
        $result->bind_param("ii", $idReporte, $idAceite);
        if (!$result->execute()):
            throw new Exception("Error al ejecutar la consulta" . $result->error);
        endif;
        $result->bind_result($idLubricante, $bodega);
        $result->fetch();
        $result->close();
        $bode = $bodega + $diferencia;
        $sql2 = "UPDATE op_aceites_lubricantes_reporte SET bodega =? WHERE id =? ";
        $stmt = $this->con->prepare($sql2);
        $stmt->bind_param("ii", $bode, $idLubricante);
        $stmt->execute();
        $stmt->close();
        $sql3 = "UPDATE op_aceites_lubricantes_reporte_pagodiferencia SET estado = ? WHERE id =? ";
        $stmt1 = $this->con->prepare($sql3);
        $stmt1->bind_param("ii", $estado, $id);
        $stmt1->execute();
        $stmt1->close();
    }
    public function cantidadAceites(int $idReporte, string $fecha, int $noaceite): int
    {
        $cantidad = 0;
        $sql = "SELECT cantidad FROM op_aceites_lubricantes WHERE idreporte_dia = (SELECT id FROM op_corte_dia WHERE id_mes = ? AND fecha = ? LIMIT 1 ) AND id_aceite = ? LIMIT 1 ";
        $result = $this->con->prepare($sql);
        if (!$result):
            throw new Exception("Error al preparar la consulta" . $this->con->error);
        endif;
        $result->bind_param("isi", $idReporte, $fecha, $noaceite);
        if (!$result->execute()):
            throw new Exception("Error al ejecutar la consulta" . $result->error);
        endif;
        $result->bind_result($cantidad);
        $result->close();
        return $cantidad;
    }
    public function totalAceites(int $IdReporte, int $noaceite): int
    {
        $cantidad = 0;
        // Consulta preparada para obtener la suma de la cantidad de aceites lubricantes
        $sql = "SELECT SUM(ol.cantidad) AS total_cantidad
                FROM op_corte_dia cd
                INNER JOIN op_aceites_lubricantes ol ON cd.id = ol.idreporte_dia
                WHERE cd.id_mes = ?
                AND ol.id_aceite = ?";
        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta" . $this->con->error);
        endif;
        $stmt->bind_param("ii", $IdReporte, $noaceite);
        if (!$stmt->execute()):
            throw new Exception("Error al ejecutar la consulta" . $stmt->error);
        endif;
        $stmt->bind_result($cantidad);
        $stmt->fetch();
        $stmt->close();
        if ($cantidad == null):
            $cantidad = 0;
        endif;
        return $cantidad;
    }
    function precioAceite(int $IdReporte, string $fecha, int $noaceite): int
    {
        $total_precio = 0;
        // Consulta para obtener el precio total del aceite lubricante utilizando subconsultas
        $sql = "SELECT SUM(ol.cantidad * ol.precio_unitario) AS total_precio
                FROM op_corte_dia cd
                INNER JOIN op_aceites_lubricantes ol ON cd.id = ol.idreporte_dia
                WHERE cd.id_mes = ?
                AND cd.fecha = ?
                AND ol.id_aceite = ?
                LIMIT 1";

        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta" . $this->con->error);
        endif;
        $stmt->bind_param("isi", $IdReporte, $fecha, $noaceite);
        if (!$stmt->execute()):
            throw new Exception("Error al ejecutar la consulta" . $stmt->error);
        endif;
        $stmt->bind_result($total_precio);
        $stmt->fetch();
        $stmt->close();
        if ($total_precio == null):
            $total_precio = 0;
        endif;
        return $total_precio;
    }
    public function validaPagoD(int $idaceite): int
    {
        $sql_reporte = "SELECT id FROM op_aceites_lubricantes_reporte_pagodiferencia WHERE id_aceite = ?";
        $result_reporte = $this->con->prepare($sql_reporte);
        if (!$result_reporte):
            throw new Exception("Error al preparar la consulta" . $this->con->error);
        endif;
        $result_reporte->bind_param("i", $idaceite);
        if (!$result_reporte->execute()):
            throw new Exception("Error al ejecutar la consulta" . $result_reporte->error);
        endif;
        $numero_reporte = $result_reporte->num_rows;
        return $numero_reporte;
    }
    public function valRow($valor): int
    {
        $resultado = 0;
        if ($valor != 0):
            $resultado = number_format($valor, 2, '.', '.');
        endif;
        return $resultado;
    }
    public function modalPagoAceite(int $idAceite): array
    {
        $concepto = "";
        $inventario_bodega = 0;
        $inventario_exibidores = 0;
        $bodega = 0;
        $exibidores = 0;
        $pedido = 0;
        $noaceite = 0;
        $IdReporte = 0;
        $sql_reporte = "SELECT concepto, inventario_bodega, inventario_exibidores, bodega, exibidores, pedido, id_aceite, id_mes 
                FROM op_aceites_lubricantes_reporte 
                WHERE id = ?";
        $stmt = $this->con->prepare($sql_reporte);
        $stmt->bind_param("i", $idAceite);
        $stmt->execute();
        $stmt->bind_result($concepto, $inventario_bodega, $inventario_exibidores, $bodega, $exibidores, $pedido, $noaceite, $IdReporte);
        $stmt->fetch();
        $stmt->close();
        $inventarioI = $bodega + $exibidores;
        $totalaceites = $this->totalAceites($IdReporte, $noaceite);
        $inventarioF = $inventarioI + $pedido - $totalaceites;
        $inventario_final = $inventario_bodega + $inventario_exibidores;
        $diferencia = $inventario_final - $inventarioF;
        $resultado = [$diferencia, $concepto];
        return $resultado;
    }
    public function modalDetallePagoAceite(int $idAceite): array
    {
        $fecha = "";
        $comentario = "";
        $documento = "";
        $sql_reporte_pago = "SELECT fecha, comentario, documento 
                     FROM op_aceites_lubricantes_reporte_pagodiferencia 
                     WHERE id_aceite = ?";
        $stmt = $this->con->prepare($sql_reporte_pago);
        $stmt->bind_param("i", $idAceite);
        $stmt->execute();
        $stmt->bind_result($fecha, $comentario, $documento);
        $stmt->fetch();
        $fechaHora = explode(' ', $fecha);
        $resultado_pago = [$fechaHora[0], $comentario, $documento];
        $stmt->close();
        return $resultado_pago;
    }
    /**
     * 
     * 
     *  CORTE VENTAS
     * 
     * 
     * 
     */ 

    public function ventas(int $idReporte): int
    {
        $ventas = 0;
        $sql_dia = "SELECT ventas FROM op_corte_dia WHERE id = ? ";
        $result = $this->con->prepare($sql_dia);

        if (!$result):
        // Manejo de error
        throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
        endif;

        $result->bind_param('i', $idReporte);
        $result->execute();
        $result->bind_result($ventas);
        $result->fetch();
        $result->close();
        return $ventas;
    }


    public function getTotalImporte(int $idReporte): int
    {
        $sql = "SELECT importe FROM op_prosegur WHERE idreporte_dia = ?";
        $importe = 0;
        $totalImporte = 0;
        if ($stmt = $this->con->prepare($sql)):
            $stmt->bind_param("i", $idReporte);
            $stmt->execute();
            $stmt->bind_result($importe);
            while ($stmt->fetch()):
                $totalImporte += $importe;
            endwhile;
            $stmt->close();
        endif;
        return $totalImporte;
    }

    public function getBaucherTotal(int $idReporte): int
    {
        $sql = "SELECT baucher FROM op_tarjetas_c_b WHERE idreporte_dia = ?";
        $baucher = 0;
        $baucherTotal = 0;
        if ($stmt = $this->con->prepare($sql)):
            $stmt->bind_param("i", $idReporte);
            $stmt->execute();
            $stmt->bind_result($baucher);
            while ($stmt->fetch()):
                $baucherTotal += $baucher;
            endwhile;
            $stmt->close();
        endif;
        return $baucherTotal;
    }

    function getConsumoTotal(int $idReporte)
    {
        $sql = "SELECT consumo FROM op_clientes_controlgas WHERE idreporte_dia = ?";
        $consumo = 0;
        $consumoTotal = 0;
        if ($stmt = $this->con->prepare($sql)):
            $stmt->bind_param("i", $idReporte);
            $stmt->execute();
            $stmt->bind_result($consumo);
            while ($stmt->fetch()):
                $consumoTotal += $consumo;
            endwhile;
            $stmt->close();
        endif;
        return $consumoTotal;
    }
    public function getPagoTotal($idReporte): int
    {
        $sql = "SELECT pago FROM op_clientes_controlgas WHERE idreporte_dia = ?";
        $pago = 0;
        $pagoTotal = 0;
        if ($stmt = $this->con->prepare($sql)):
            $stmt->bind_param("i", $idReporte);
            $stmt->execute();
            $stmt->bind_result($pago);
            while ($stmt->fetch()):
                $pagoTotal += $pago;
            endwhile;
            $stmt->close();
        endif;
        return $pagoTotal;
    }
    /* ------------------------------ PUNTO 2. SOLICITUD DE CHEQUE ------------------------------ */
    function obtenerDatosSolicitudCheque($idReporte)
    {

        // Inicializar variables para evitar "use of assigned variable"
        $fecha = $beneficiario = $monto = $moneda = $nofactura = $email = $concepto = $solicitante = $telefono = $cfdi = $metodo_pago = $forma_pago = $banco = $nocuenta = $cuentaclabe = $referencia = $observaciones = $status = $razonsocial = null;

        $sql = "SELECT fecha, beneficiario, monto, moneda, no_factura, email, concepto, solicitante, telefono, cfdi, metodo_pago, forma_pago, banco, no_cuenta, cuenta_clabe, referencia, observaciones, status, razonsocial FROM op_solicitud_cheque WHERE id = ?";
        $consulta = $this->con->prepare($sql);

        if (!$consulta) {
            $result = false;
            throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
        }

        $consulta->bind_param('i', $idReporte);
        $consulta->execute();
        $consulta->bind_result($fecha, $beneficiario, $monto, $moneda, $nofactura, $email, $concepto, $solicitante, $telefono, $cfdi, $metodo_pago, $forma_pago, $banco, $nocuenta, $cuentaclabe, $referencia, $observaciones, $status, $razonsocial);

        if ($consulta->fetch()) {
            // Procesamiento de los datos obtenidos
            $datosSolicitudCheque = array(
                'fecha' => $fecha,
                'beneficiario' => $beneficiario,
                'monto' => $monto,
                'moneda' => $moneda,
                'no_factura' => $nofactura,
                'email' => $email,
                'concepto' => $concepto,
                'solicitante' => $solicitante,
                'telefono' => $telefono,
                'cfdi' => $cfdi,
                'metodo_pago' => $metodo_pago,
                'forma_pago' => $forma_pago,
                'banco' => $banco,
                'no_cuenta' => $nocuenta,
                'cuenta_clabe' => $cuentaclabe,
                'referencia' => $referencia,
                'observaciones' => $observaciones,
                'status' => $status,
                'razonsocial' => $razonsocial
            );

        } else {
            // Manejo de caso cuando no se encuentra el registro
            $datosSolicitudCheque = null;
        }

        $consulta->close();

        return $datosSolicitudCheque;
    }


    /* ------------------------------ PUNTO 3. INGRESOS VS FACTURACION ------------------------------ */
    public function idReporteFacturacion(int $idEstacion, int $year): int
    {
        $idyear = 0;
        $sql = "SELECT id FROM op_corte_year WHERE id_estacion = ? AND year =? ";
        $result = $this->con->prepare($sql);
        $result->bind_param("ii", $idEstacion, $year);
        $result->execute();
        $result->bind_result($idyear);
        $result->fetch();
        $result->close();
        return $idyear;
    }
    public function getProducto(int $idEstacion, string $nombre): string
    {
        $resultado = "";
        $sql = "SELECT $nombre FROM tb_estaciones WHERE id = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param("i", $idEstacion);
        $result->execute();
        $result->bind_result($resultado);
        $result->fetch();
        $result->close();
        return $resultado;
    }
    public function validaFacturacion(int $idReporte, string $descripcion): void
    {
        $posicion = 1;
        if ($descripcion == "G DIESEL"):
            $this->validaIngresoFacturacion($idReporte, $descripcion, $posicion);
        elseif ($descripcion == "Autolavado"):
            $this->validaIngresoFacturacion($idReporte, $descripcion, $posicion);
        elseif ($descripcion == "general"):
            // se mandan a llamar los conceptos con posicion 1
            $concepto1 = $this->getDescripcion1();
            foreach ($concepto1 as $concepto):
                $this->validaIngresoFacturacion($idReporte, $concepto, $posicion);
            endforeach;
            // cuando termine el foreach se mandan a llamar los conceptos con posicion 2 
            // y la variable $posicion se asigna un valor de 2
            $posicion = 2;
            $concepto2 = $this->getDescripcion2();
            foreach ($concepto2 as $concepto):
                $this->validaIngresoFacturacion($idReporte, $concepto, $posicion);
            endforeach;
        endif;
    }
    private function getDescripcion1(): array
    {
        $concepto1 = "G SUPER";
        $concepto2 = "G PREMIUM";
        $concepto3 = "Aceites y Lubricantes";
        $concepto4 = "Rentas";
        $concepto5 = "IEPS";
        $conceptos = [$concepto1, $concepto2, $concepto3, $concepto4, $concepto5];
        return $conceptos;
    }
    private function getDescripcion2(): array
    {
        $concepto1 = "Público en General";
        $concepto2 = "Clientes crédito";
        $concepto3 = "Monederos electronicos";
        $concepto4 = "Facturas aceites y lubricantes";
        $concepto5 = "Clientes débito";
        $concepto6 = "Ventas mostrador";
        $concepto7 = "TPV";
        $concepto8 = "Página WEB";
        $conceptos = [$concepto1, $concepto2, $concepto3, $concepto4, $concepto5, $concepto6, $concepto7, $concepto8];
        return $conceptos;
    }
    private function validaIngresoFacturacion(int $idReporte, string $detalle, int $posicion)
    {
        $sql = "SELECT * FROM op_ingresos_facturacion_contabilidad WHERE id_year = ? AND detalle = ? AND posicion = ? ";
        $result = $this->con->prepare($sql);
        $result->bind_param("isi", $idReporte, $detalle, $posicion);
        $result->execute();
        $result = $result->get_result();
        $numero = $result->num_rows;
        $result->close();
        if ($numero == 0):
            $sql_insert = "INSERT INTO op_ingresos_facturacion_contabilidad (id_year,detalle,posicion)
          VALUES (?,?,?)";
            $result = $this->con->prepare($sql_insert);
            $result->bind_param("isi", $idReporte, $detalle, $posicion);
            $result->execute();
            $result->close();
        endif;
    }
    public function actualizarIngresoFacturacion(int $idReporte): void
    {
        $meses = range(1, 12);
        foreach ($meses as $mes):
            $this->updateIngresoFacturacion($idReporte, $mes);
        endforeach;
    }
    private function updateIngresoFacturacion($idReporte, $mes)
    {
        $descripcion = "";
        $total = 0;
        $idReporteMes = $this->idReporteMes($idReporte, $mes);
        $sql = "SELECT descripcion, total FROM op_control_volumetrico_prefijos WHERE id_mes = ?";
        $result = $this->con->prepare($sql);
        $result->bind_param("i", $idReporteMes);
        $result->execute();
        $result->bind_result($descripcion, $total);
        $result->fetch();
        $result->close();
        // Mapeo de descripciones
        $descripcionMapeada = "";
        switch ($descripcion):
            case "PUBLICO EN GENERAL":
                $descripcionMapeada = "Público en General";
                break;
            case "CLIENTES DE CREDITO":
            case "Facturas de Crédito":
                $descripcionMapeada = "Clientes crédito";
                break;
            case "MONEDEROS":
                $descripcionMapeada = "Monederos electrónicos";
                break;
            case "FACTURA DE ACEITES":
                $descripcionMapeada = "Facturas aceites y lubricantes";
                break;
            case "RENTAS":
                $descripcionMapeada = "Rentas";
                break;
            case "CLIENTES DE DEBITO":
                $descripcionMapeada = "Clientes débito";
                break;
            case "VENTA MOSTRADOR":
                $descripcionMapeada = "Ventas mostrador";
                break;
            case "TPV":
                $descripcionMapeada = "TPV";
                break;
            case "WEB":
                $descripcionMapeada = "Página WEB";
                break;
            case "CLIENTES ANTICIPO":
                $descripcionMapeada = "Clientes anticipo";
                break;
        endswitch;
        $Mes = strtolower($this->formato->nombremes($mes));
        // Consulta preparada para actualizar
        $sql_edit3 = "UPDATE op_ingresos_facturacion_contabilidad SET $Mes = ? WHERE id_year = ? AND detalle = ?";
        $stmt = $this->con->prepare($sql_edit3);
        $stmt->bind_param("sss", $total, $idReporte, $descripcionMapeada);
        $stmt->execute();
        $stmt->close();
    }
    private function idReporteMes(int $year, int $mes): int
    {
        $idmes = 0;
        $sql_mes = "SELECT id FROM op_corte_mes WHERE id_year = ? AND mes = ? ";
        $result = $this->con->prepare($sql_mes);
        $result->bind_param("ii", $year, $mes);
        $result->execute();
        $result->bind_result($idmes);
        $result->fetch();
        $result->close();
        return $idmes;
    }
    public function actualizarIF(int $idReporte): void
    {

        $meses = range(1, 12);
        foreach ($meses as $mes):
            $this->updateProductoIF($idReporte, $mes);
        endforeach;
    }
    private function updateProductoIF($IdReporte, $mes)
    {
        $IdReporteMes = $this->idReporteMes($IdReporte, $mes);
        $Mes = strtolower(nombremes($mes));

        $sql_lista = "SELECT id, producto, dato10 FROM op_control_volumetrico_resumen WHERE id_mes = ?";
        $stmt_lista = $this->con->prepare($sql_lista);
        $stmt_lista->bind_param("i", $IdReporteMes);
        $stmt_lista->execute();
        $result_lista = $stmt_lista->get_result();

        while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)):
            $id = $row_lista['id'];
            $producto = $row_lista['producto'];
            $dato10 = $row_lista['dato10'];

            $sql_edit1 = "UPDATE op_ingresos_facturacion_contabilidad SET $Mes = ? WHERE id_year = ? AND detalle = ?";
            $stmt_edit1 = $this->con->prepare($sql_edit1);
            $stmt_edit1->bind_param("dss", $dato10, $IdReporte, $producto);
            $stmt_edit1->execute();
        endwhile;

        $TotAceites = 0;
        $Grantotal = 0;
        $sql_listaaceites = "SELECT id_aceite, precio FROM op_aceites_lubricantes_reporte WHERE id_mes = ?";
        $stmt_listaaceites = $this->con->prepare($sql_listaaceites);
        $stmt_listaaceites->bind_param("i", $IdReporteMes);
        $stmt_listaaceites->execute();
        $result_listaaceites = $stmt_listaaceites->get_result();

        while ($row_listaaceites = mysqli_fetch_array($result_listaaceites, MYSQLI_ASSOC)) {
            $noaceite = $row_listaaceites['id_aceite'];
            $preciou = $row_listaaceites['precio'];
            $totalaceites = $this->totalAceites($IdReporteMes, $noaceite);

            $Total = $preciou * $totalaceites;
            $TotAceites = $TotAceites + $totalaceites;
            $Grantotal = $Grantotal + $Total;
        }

        $sql_edit2 = "UPDATE op_ingresos_facturacion_contabilidad SET $Mes = ? WHERE id_year = ? AND detalle = 'Aceites y Lubricantes'";
        $stmt_edit2 = $this->con->prepare($sql_edit2);
        $stmt_edit2->bind_param("di", $Grantotal, $IdReporte);
        $stmt_edit2->execute();
    }



    /* ------------------------------ PUNTO 4. ESTIMULO FISCAL ------------------------------ */

    function TotalProducto($idEstacion, $FInicio, $FTermino, $Producto)
    {

        $TotalProducto = null;

        $sql = "SELECT 
SUM(re_reporte_cre_pipas.volumen) AS TotalProducto
FROM re_reporte_cre_mes 
INNER JOIN re_reporte_cre_producto
ON re_reporte_cre_mes.id = re_reporte_cre_producto.id_re_mes
INNER JOIN re_reporte_cre_pipas 
ON re_reporte_cre_producto.id = re_reporte_cre_pipas.id_re_producto
WHERE re_reporte_cre_mes.id_estacion = ? AND 
re_reporte_cre_producto.producto = ? AND
re_reporte_cre_producto.fecha BETWEEN ? AND ? LIMIT 1";
        $consulta = $this->con->prepare($sql);

        if (!$consulta) {
            $result = false;
            throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
        }

        $consulta->bind_param('isss', $idEstacion, $Producto, $FInicio, $FTermino);
        $consulta->execute();
        $consulta->bind_result($TotalProducto);

        if ($consulta->fetch()) {
            $sumatoriaProducto = $TotalProducto;

        } else {
            // Manejo de caso cuando no se encuentra el registro
            $sumatoriaProducto = 0;
        }

        $consulta->close();

        return $sumatoriaProducto;
    }

    function obtenerDatosEstimuloFiscal($idReporte)
    {

        // Inicializar variables para evitar "use of assigned variable"
        $fechaInicio = $fechaFin = null;

        $sql = "SELECT fecha_inicio, fecha_termino FROM op_estimulo_fiscal_pago WHERE id = ?";
        $consulta = $this->con->prepare($sql);

        if (!$consulta) {
            $result = false;
            throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
        }

        $consulta->bind_param('i', $idReporte);
        $consulta->execute();
        $consulta->bind_result($fechaInicio, $fechaFin);

        if ($consulta->fetch()) {
            // Procesamiento de los datos obtenidos
            $datosEstimuloFiscal = array(
                'fecha_inicio' => $fechaInicio,
                'fecha_termino' => $fechaFin
            );

        } else {
            // Manejo de caso cuando no se encuentra el registro
            $datosEstimuloFiscal = null;
        }

        $consulta->close();
        
        return $datosEstimuloFiscal;
    }
        /* ------------------------------ PUNTO 6. SOLICITUD DE VALES ------------------------------ */

        function obtenerDatosSolicitudVale($idReporte)
        {

            $folio = $fecha = $hora = $monto = $moneda = $concepto = $solicitante = $observaciones = $status = $idEstacion = $cuenta = $autorizadoPor = $metodoAutorizacion = null;
            $sql = "SELECT folio, fecha, hora, monto, moneda, concepto, solicitante, observaciones, status, id_estacion, cuenta, autorizado_por, metodo_autorizacion FROM op_solicitud_vale WHERE id = ? ";
            $consulta = $this->con->prepare($sql);

            if (!$consulta) {
                throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
            }

            $consulta->bind_param('i', $idReporte);
            $consulta->execute();
            $consulta->bind_result($folio, $fecha, $hora, $monto, $moneda, $concepto, $solicitante, $observaciones, $status, $idEstacion, $cuenta, $autorizadoPor, $metodoAutorizacion);

            if ($consulta->fetch()) {
                $datosSolicitudVale = array(
                    'folio' => $folio,
                    'fecha' => $fecha,
                    'hora' => $hora,
                    'monto' => $monto,
                    'moneda' => $moneda,
                    'concepto' => $concepto,
                    'solicitante' => $solicitante,
                    'observaciones' => $observaciones,
                    'status' => $status,
                    'idEstacion' => $idEstacion,
                    'cuenta' => $cuenta,
                    'autorizado_por' => $autorizadoPor,
                    'metodo_autorizacion' => $metodoAutorizacion
                );
            } else {
                $datosSolicitudVale = null;
            }

            $consulta->close();

            return $datosSolicitudVale;
        }
    /**
     * 
     * 
     * 
     * 5 Despacho VS Factura
     * 
     * 
     * 
     */
    public function totalVentas(int $idDias, string $Producto): array
    {
        $TotalLitros = 0;
        $TotalPrecio = 0;
        $sql = "SELECT litros,precio_litro FROM op_ventas_dia WHERE idreporte_dia = ? AND producto = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("is", $idDias, $Producto);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()):
            $litros = $row['litros'];
            $preciolitro = $row['precio_litro'];
            $LitrosPrecio = $litros * $preciolitro;

            $TotalLitros += $litros;
            $TotalPrecio += $LitrosPrecio;
        endwhile;
        $array = array(
            'TotalLitros' => $TotalLitros,
            'TotalPrecio' => $TotalPrecio
        );
        return $array;
    }
    public function totalAtio(int $idDias): array
    {
        $LProductouno = 0;
        $LProductodos = 0;
        $LProductotres = 0;
        $PProducto_uno = 0;
        $PProducto_dos = 0;
        $PProducto_tres = 0;
        $sql = "SELECT 
            litros_producto_uno,litros_producto_dos,litros_producto_tres,
            pesos_producto_uno,pesos_producto_dos,pesos_producto_tres
            FROM op_despacho_factura WHERE id_dia = ? ";
        $result = $this->con->prepare($sql);
        $result->bind_param("i", $idDias);
        $result->execute();
        $result->bind_result($LProductouno, $LProductodos, $LProductotres, $PProducto_uno, $PProducto_dos, $PProducto_tres);
        $result->fetch();
        $array = array(
            'LProductouno' => $LProductouno,
            'LProductodos' => $LProductodos,
            'LProductotres' => $LProductotres,
            'PProductouno' => $PProducto_uno,
            'PProductodos' => $PProducto_dos,
            'PProductotres' => $PProducto_tres
        );
        $result->close();
        return $array;
    }
    public function validaDia(int $idDias)
    {
        $sql_select = "SELECT * FROM op_despacho_factura WHERE id_dia = ? LIMIT 1";
        $stmt_select = $this->con->prepare($sql_select);
        $stmt_select->bind_param("i", $idDias);
        $stmt_select->execute();
        $result = $stmt_select->get_result();
        $numero = $result->num_rows;

        if ($numero == 0):
            $sql_insert = "INSERT INTO op_despacho_factura (
            id_dia,
            litros_producto_uno,
            litros_producto_dos,
            litros_producto_tres,
            pesos_producto_uno,
            pesos_producto_dos,
            pesos_producto_tres
            )
            VALUES 
            (?,0,0,0,0,0,0)";

            $stmt_insert = $this->con->prepare($sql_insert);
            $stmt_insert->bind_param("i", $idDias);
            $stmt_insert->execute();
            $stmt_insert->close();
        endif;
    }
    public function esNegativo(float $num): string
    {
        $result = "style = color:#00000";
        if (is_numeric($num) and $num < 0):
            $result = "style = color:#dc3545";
        endif;
        return $result;
    }
}