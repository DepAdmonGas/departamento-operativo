<?php
require "../../bd/inc.conexion.php";
require_once '../../modelo/HerramientasDptoOperativo.php';

class CorteDiario extends Exception
{
    private $classConexionBD;
    private $con;
    private $formato;


    public function __construct()
    {

        $this->classConexionBD = Database::getInstance();
        $this->con = $this->classConexionBD->getConnection();
        $this->formato = new herramientasDptoOperativo($this->con);
    }
    /**--------------------------------------------------------------------------------------------
     * 
     *                                      Funciones Ventas
     * 
     * 
     * ---------------------------------------------------------------------------------------------
     */
    public function nuevoConcentrado(int $idReporte, int $sessionIdEstacion): void
    {
        $conceptos = $this->getConceptos();
        // Se iteran para mostrar tabla concentrado ventas 
        foreach ($conceptos as $concepto):
            $this->nuevoConcentradoVentasOtros($idReporte, $concepto);
        endforeach;
        if ($sessionIdEstacion == 2):
            $concepto5 = "7 G BENEFICIOS";
            $this->nuevoConcentradoVentasOtros($idReporte, $concepto5);
        endif;
    }
    private function getConceptos(): array
    {
        $concepto1 = "OTROS";
        $concepto2 = "4 ACEITES Y LUBRICANTES";
        $concepto3 = "5 AUTOLAVADO";
        $concepto4 = "6 ADITIVO PARA DIESEL";
        $conceptos = [$concepto1, $concepto2, $concepto3, $concepto4];
        return $conceptos;
    }
    private function nuevoConcentradoVentasOtros(int $idReporte, string $concepto): void
    {
        $piezas = "";
        $importe = 0;
        $numero_reporte = 0;
        $sql_reporte = "SELECT idreporte_dia FROM op_ventas_dia_otros WHERE idreporte_dia =? AND concepto =? ";
        $result_reporte = $this->con->prepare($sql_reporte);
        if (!$result_reporte):
            throw new Exception("Error en la preparacion de la consulta" . $this->con->error);
        endif;
        $result_reporte->bind_param('is', $idReporte, $concepto);
        $result_reporte->execute();
        $result_reporte->bind_result($numero_reporte);
        $result_reporte->fetch();
        $result_reporte->close();
        if ($numero_reporte == 0):
            $sql_insert = "INSERT INTO op_ventas_dia_otros(idreporte_dia,concepto,piezas,importe)
            VALUES (?,?,?,?)";
            $stmt = $this->con->prepare($sql_insert);
            if (!$stmt):
                throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
            endif;
            $stmt->bind_param("issi", $idReporte, $concepto, $piezas, $importe);
            if (!$stmt->execute()):
                throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
            endif;
            $stmt->close();
        endif;
    }
    public function nuevoProsegur(int $idReporte): void
    {
        $denominaciones = $this->getDenominaciones();
        foreach ($denominaciones as $denominacion):
            $this->nuevoRegistroProsegur($idReporte, $denominacion);
        endforeach;
    }
    private function getDenominaciones(): array
    {
        $denominacion1 = "BILLETE MATUTINO";
        $denominacion2 = "BILLETE VESPERTINO";
        $denominacion3 = "BILLETE NOCTURNO";
        $denominacion4 = "MORRALLA";
        $denominacion5 = "DEPOSITO BANCARIO";
        $denominacion6 = "CHEQUE 1";
        $denominacion7 = "TRANSFERENCIA 1";
        $denominacion8 = "CHEQUE 2";
        $denominacion9 = "TRANSFERENCIA 2";
        $denominaciones = [
            $denominacion1,
            $denominacion2,
            $denominacion3,
            $denominacion4,
            $denominacion5,
            $denominacion6,
            $denominacion7,
            $denominacion8,
            $denominacion9
        ];
        return $denominaciones;
    }
    private function nuevoRegistroProsegur(int $idReporte, string $denominacion): void
    {
        $recibo = "";
        $importe = 0;
        $numero_reporte = 0;
        $sql_reporte = "SELECT idreporte_dia FROM op_prosegur WHERE idreporte_dia = ? AND denominacion = ? ";
        $result_reporte = $this->con->prepare($sql_reporte);
        if (!$result_reporte):
            throw new Exception("Error en la preparacion de la consulta" . $this->con->error);
        endif;
        $result_reporte->bind_param('is', $idReporte, $denominacion);
        $result_reporte->execute();
        $result_reporte->bind_result($numero_reporte);
        $result_reporte->fetch();
        $result_reporte->close();
        if ($numero_reporte == 0):
            $sql_insert = "INSERT INTO op_prosegur (
            idreporte_dia,
            denominacion,
            recibo,
            importe 
            )
            VALUES(?,?,?,?)";
            $stmt = $this->con->prepare($sql_insert);
            if (!$stmt):
                throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
            endif;
            $stmt->bind_param("issi", $idReporte, $denominacion, $recibo, $importe);
            if (!$stmt->execute()):
                throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
            endif;
            $stmt->close();
        endif;
    }
    public function nuevoTarjetas(int $idReporte, int $IdEstacion): void
    {
        switch ($IdEstacion):
            // Interlomas
            case 1:
                $num = $this->getNumero($IdEstacion);
                $tarjetas = $this->getTarjetas($IdEstacion);
                // combina dos array de la misma longitud para llenar campos 
                foreach (array_combine($num, $tarjetas) as $num => $bancos):
                    $this->nuevoRegistroTarjetasBancarias($idReporte, $num, $bancos);
                endforeach;
                break;
            // Palo Solo
            case 2:
                $num = $this->getNumero($IdEstacion);
                $tarjetas = $this->getTarjetas($IdEstacion);
                foreach (array_combine($num, $tarjetas) as $num => $bancos):
                    $this->nuevoRegistroTarjetasBancarias($idReporte, $num, $bancos);
                endforeach;
                break;
            // San Agustin    
            case 3:
                $num = $this->getNumero($IdEstacion);
                $tarjetas = $this->getTarjetas($IdEstacion);
                foreach (array_combine($num, $tarjetas) as $num => $bancos):
                    $this->nuevoRegistroTarjetasBancarias($idReporte, $num, $bancos);
                endforeach;
                break;
            //Gasomira
            case 4:
                $num = $this->getNumero($IdEstacion);
                $tarjetas = $this->getTarjetas($IdEstacion);
                foreach (array_combine($num, $tarjetas) as $num => $bancos):
                    $this->nuevoRegistroTarjetasBancarias($idReporte, $num, $bancos);
                endforeach;
                break;
            // Valle de Guadalupe
            case 5:
                $num = $this->getNumero($IdEstacion);
                $tarjetas = $this->getTarjetas($IdEstacion);
                foreach (array_combine($num, $tarjetas) as $num => $bancos):
                    $this->nuevoRegistroTarjetasBancarias($idReporte, $num, $bancos);
                endforeach;
                break;
            // Esmegas
            case 6:
                $num = $this->getNumero($IdEstacion);
                $tarjetas = $this->getTarjetas($IdEstacion);
                foreach (array_combine($num, $tarjetas) as $num => $bancos):
                    $this->nuevoRegistroTarjetasBancarias($idReporte, $num, $bancos);
                endforeach;
                break;
            // Xochimilco
            case 7:
                $num = $this->getNumero($IdEstacion);
                $tarjetas = $this->getTarjetas($IdEstacion);
                foreach (array_combine($num, $tarjetas) as $num => $bancos):
                    $this->nuevoRegistroTarjetasBancarias($idReporte, $num, $bancos);
                endforeach;
                break;
            case 14:
                $num = $this->getNumero($IdEstacion);
                $tarjetas = $this->getTarjetas($IdEstacion);
                foreach (array_combine($num, $tarjetas) as $num => $bancos):
                    $this->nuevoRegistroTarjetasBancarias($idReporte, $num, $bancos);
                endforeach;
                break;
        endswitch;
        $monederos = $this->getTarjetas(15);
        foreach ($monederos as $monedero):
            $this->monederosBancos($idReporte, $monedero);
        endforeach;
    }
    private function getTarjetas(int $estacion): array
    {
        $ticketcard = "TICKETCARD";
        $g500 = "G500 FLETT";
        $accord = "VALE ACCORD";
        $efecticard = "EFECTICARD";
        $efectivale = "VALE EFECTIVALE";
        $sodexo = "SODEXO";
        $valeSodexo = "VALE SODEXO";
        $inburgas = "INBURGAS";
        $america = "AMERICAN EXPRESS";
        $bbva = "BBVA BANCOMER SA";
        $inbursa = "INBURSA";
        $vale = "SI VALE";
        $otros = "OTROS";
        $ultragas = "ULTRAGAS";
        $energex = "ENERGEX";
        $shell = "SHELL FLEET NAVIGATOR";

        switch ($estacion):
            case 1:
                $interlomas = [
                    $ticketcard,
                    $g500,
                    $accord,
                    $efecticard,
                    $efectivale,
                    $sodexo,
                    $valeSodexo,
                    $inburgas,
                    $america,
                    $bbva,
                    $inbursa,
                    $vale,
                    $otros
                ];
                return $interlomas;
            case 2:
                $paloSolo = [$ticketcard, $g500, $efecticard, $sodexo, $inburgas, $america, $bbva, $shell, $inbursa, $otros];
                return $paloSolo;
            case 3:
                $sanAgustin = [
                    $ticketcard,
                    $g500,
                    $efecticard,
                    $sodexo,
                    $inburgas,
                    $america,
                    $bbva,
                    $inbursa,
                    $vale,
                    $ultragas,
                    $energex,
                    $otros
                ];
                return $sanAgustin;
            case 4:
                $gasomira = [$ticketcard, $g500, $efecticard, $sodexo, $inburgas, $america, $bbva, $inbursa, $otros];
                return $gasomira;
            case 5:
                $valle = [$ticketcard, $g500, $efecticard, $sodexo, $inburgas, $america, $bbva, $inbursa, $otros];
                return $valle;
            case 6:
                $esmegas = [
                    $ticketcard,
                    $g500,
                    $efecticard,
                    $efectivale,
                    $sodexo,
                    $valeSodexo,
                    $inburgas,
                    $america,
                    $bbva,
                    $inbursa,
                    $otros
                ];
                return $esmegas;
            case 7:
                $xochimilco = [
                    $ticketcard,
                    $g500,
                    $accord,
                    $efecticard,
                    $efectivale,
                    $sodexo,
                    $inburgas,
                    $america,
                    $bbva,
                    $inbursa,
                    $otros
                ];
                return $xochimilco;
            case 14:
                $bosqueReal = [$ticketcard, $g500, $efecticard, $sodexo, $inburgas, $america,$shell, $bbva, $otros];
                return $bosqueReal;
            // monederos y bancos
            case 15:
                $monederos = [$ticketcard, $g500, $efecticard, $sodexo, $inburgas, $america, $bbva, $inbursa, $ultragas, $energex];
                return $monederos;
            default:
                // Devuelve un array vacío en caso de que no se cumpla ningún caso
                return [];
        endswitch;
    }
    public function getNumero(int $estacion): array
    {
        $num1 = "1";
        $num1_1 = "1.1";
        $num2 = "2";
        $num3 = "3";
        $num4 = "4";
        $num5 = "5";
        $num6 = "6";
        $num7 = "7";
        $num8 = "8";
        $num9 = "9";
        $num10 = "10";
        $numA = "A";
        $numB = "B";
        $numC = "C";
        $numE = "E";
        switch ($estacion):
            case 1:
                $numInter = [$num1, $num1_1, $numA, $num2, $numB, $num3, $numC, $num4, $num5, $num6, $numE, $num7, $num10];
                return $numInter;
            case 2:
                $numPalo = [$num1, $num1_1, $num2, $num3, $num4, $num5, $num6, $num7, $numE, $num10];
                return $numPalo;
            case 3:
                $numAgus = [$num1, $num1_1, $num2, $num3, $num4, $num5, $num6, $numE, $num7, $num8, $num9, $num10];
                return $numAgus;
            case 4:
                $numGaso = [$num1, $num1_1, $num2, $num3, $num4, $num5, $num6, $numE, $num10];
                return $numGaso;
            case 5:
                $numValle = [$num1, $num1_1, $num2, $num3, $num4, $num5, $num6, $numE, $num10];
                return $numValle;
            case 6:
                $numEsme = [$num1, $num1_1, $num2, $numB, $num3, $numC, $num4, $num5, $num6, $numE, $num10];
                return $numEsme;
            case 7:
                $numXochi = [$num1, $num1_1, $numA, $num2, $numB, $num3, $num4, $num5, $num6, $numE, $num10];
                return $numXochi;
            case 14:
                $numBosque = [$num1, $num1_1, $num2, $num3, $num4, $num5,$num7, $num6, $num10];
                return $numBosque;
            default:
                // Devuelve un array vacío en caso de que no se cumpla ningún caso
                return [];
        endswitch;
    }
    public function editarProsegur($tipo, $valor, $idProsegur): bool
    {
        $result = true;
        $value = "";
        $bind = "si";
        if ($tipo == "recibo"):
            $value = "recibo=?";
        else:
            $value = "importe=?";
            $bind = "di";
        endif;
        $sql_insert = "UPDATE op_prosegur SET $value WHERE id=? ";
        $stmt = $this->con->prepare($sql_insert);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        endif;
        $stmt->bind_param($bind, $valor, $idProsegur);
        if (!$stmt->execute()):
            $result = false;
            throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
        endif;
        $stmt->close();
        return $result;
    }
    public function nuevoRegistroTarjetasBancarias(int $idReporte, string $num, string $concepto): void
    {
        $baucher = 0;
        $numero_reporte = 0;
        $sql_reporte = "SELECT idreporte_dia FROM op_tarjetas_c_b WHERE idreporte_dia =? AND concepto = ? ";
        $result_reporte = $this->con->prepare($sql_reporte);
        if (!$result_reporte):
            throw new Exception("Error en la preparacion de la consulta" . $this->con->error);
        endif;
        $result_reporte->bind_param('is', $idReporte, $concepto);
        $result_reporte->execute();
        $result_reporte->bind_result($numero_reporte);
        $result_reporte->fetch();
        $result_reporte->close();

        if ($numero_reporte == 0):
            $sql_insert = "INSERT INTO op_tarjetas_c_b (
            idreporte_dia,
            num,
            concepto,
            baucher
            )
            VALUES (?,?,?,?)";
            $stmt = $this->con->prepare($sql_insert);
            if (!$stmt):
                throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
            endif;
            $stmt->bind_param("issi", $idReporte, $num, $concepto, $baucher);
            if (!$stmt->execute()):
                throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
            endif;
            $stmt->close();
        endif;
    }
    public function monederosBancos(int $idReporte, string $empresa): void
    {
        $sql_listacierre = "SELECT * FROM op_cierre_lote WHERE idreporte_dia = '" . $idReporte . "' AND empresa = '" . $empresa . "' ";
        $result_listacierre = mysqli_query($this->con, $sql_listacierre);
        $TotalImporte = 0;
        while ($row_listacierre = mysqli_fetch_array($result_listacierre, MYSQLI_ASSOC)):
            $TotalImporte = $TotalImporte + $row_listacierre['importe'];
        endwhile;
        $sql_insert = "UPDATE op_tarjetas_c_b SET baucher=? WHERE concepto=? AND idreporte_dia =?";
        $stmt = $this->con->prepare($sql_insert);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        endif;
        $stmt->bind_param("dsi", $TotalImporte, $empresa, $idReporte);
        if (!$stmt->execute()):
            throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
        endif;
        $stmt->close();
    }
    public function editarTarjetasCB(float $baucher, int $idTarjeta): bool
    {
        $result = true;
        $sql_insert = "UPDATE op_tarjetas_c_b SET baucher=? WHERE id=? ";
        $stmt = $this->con->prepare($sql_insert);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        endif;
        $stmt->bind_param("di", $baucher, $idTarjeta);
        if (!$stmt->execute()):
            $result = false;
            throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
        endif;
        $stmt->close();
        return $result;
    }
    public function nuevoRegistroControlGas(int $idReporte, string $concepto): void
    {
        $pago = 0;
        $consumo = 0;
        $numero_reporte = 0;
        $sql_reporte = "SELECT idreporte_dia FROM op_clientes_controlgas WHERE idreporte_dia = ? AND concepto = ? ";
        $result_reporte = $this->con->prepare($sql_reporte);
        if (!$result_reporte):
            throw new Exception("Error en la preparacion de la consulta" . $this->con->error);
        endif;
        $result_reporte->bind_param('is', $idReporte, $concepto);
        $result_reporte->execute();
        $result_reporte->bind_result($numero_reporte);
        $result_reporte->fetch();
        $result_reporte->close();

        if ($numero_reporte == 0):
            $sql_insert = "INSERT INTO op_clientes_controlgas (
            idreporte_dia,
            concepto,
            pago,
            consumo 
            )
            VALUES (?,?,?,?)";
            $stmt = $this->con->prepare($sql_insert);
            if (!$stmt):
                throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
            endif;
            $stmt->bind_param("isdd", $idReporte, $concepto, $pago, $consumo);
            if (!$stmt->execute()):
                throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
            endif;
            $stmt->close();
        endif;
    }
    public function editarControlGas($tipo, $valor, $idControl): bool
    {
        $result = true;
        $value = "";
        if ($tipo == "pago"):
            $value = "pago=?";
        else:
            $value = "consumo=?";
        endif;
        $sql_insert = "UPDATE op_clientes_controlgas SET $value WHERE id=? ";
        $stmt = $this->con->prepare($sql_insert);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        endif;
        $stmt->bind_param("di", $valor, $idControl);
        if (!$stmt->execute()):
            $result = false;
            throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
        endif;
        $stmt->close();
        return $result;
    }
    public function nuevoRegistroPago(int $idReporte): void
    {
        $conceptos = $this->pagoConcepto();
        foreach ($conceptos as $concepto):
            $this->nuevoRegistroPagoClientes($idReporte, $concepto);
        endforeach;
    }
    private function pagoConcepto(): array
    {
        $concepto1 = "EFECTIVO";
        $concepto2 = "CHEQUE";
        $concepto3 = "TRANSFERENCIA (SPEI)";
        $concepto4 = "TARJETA DE CREDITO";
        $concepto5 = "DEPOSITO BANCARIO";
        return $conceptos = [$concepto1, $concepto2, $concepto3, $concepto4, $concepto5];
    }
    private function nuevoRegistroPagoClientes(int $idReporte, string $concepto): void
    {
        $importe = 0;
        $nota = "";
        $numero_reporte =0;
        $sql_reporte = "SELECT idreporte_dia FROM op_pago_clientes WHERE idreporte_dia = ? AND concepto = ? ";
        $result_reporte = $this->con->prepare($sql_reporte);
        if (!$result_reporte):
            throw new Exception("Error en la preparacion de la consulta" . $this->con->error);
        endif;
        $result_reporte->bind_param('is', $idReporte, $concepto);
        $result_reporte->execute();
        $result_reporte->bind_result($numero_reporte);
        $result_reporte->fetch();
        $result_reporte->close();

        if ($numero_reporte == 0):
            $sql_insert = "INSERT INTO op_pago_clientes (
            idreporte_dia,
            concepto,
            importe,
            nota 
            )
            VALUES (?,?,?,?)";
            $stmt = $this->con->prepare($sql_insert);
            if (!$stmt):
                throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
            endif;
            $stmt->bind_param("isds", $idReporte, $concepto, $importe, $nota);
            if (!$stmt->execute()):
                throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
            endif;
            $stmt->close();
        endif;
    }
    public function editarPagoClientes($tipo, $valor, $idPagoCliente): bool
    {
        $result = true;
        $bind = "di";
        $value = "";
        if ($tipo == "importe"):
            $value = "importe=?";
        else:
            $value = "nota=?";
            $bind = "si";
        endif;
        $sql_insert = "UPDATE op_pago_clientes SET $value WHERE id=? ";
        $stmt = $this->con->prepare($sql_insert);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        endif;
        $stmt->bind_param($bind, $valor, $idPagoCliente);
        if (!$stmt->execute()):
            $result = false;
            throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
        endif;
        $stmt->close();
        return $result;
    }
    public function nuevoRegistroVentas(int $idReporte): void
    {

        $producto = "";
        $litros = 0;
        $jarras = 0;
        $precio = 0;
        $ieps = 0;
        $sql_insert = "INSERT INTO op_ventas_dia (
            idreporte_dia,
            producto,
            litros,
            jarras,
            precio_litro,
            ieps
            )
            VALUES (?,?,?,?,?,?)";
        $stmt = $this->con->prepare($sql_insert);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        endif;
        $stmt->bind_param("isdddd", $idReporte, $producto, $litros, $jarras, $precio, $ieps);
        if (!$stmt->execute()):
            throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
        endif;
        $stmt->close();
    }
    public function editarVentas($tipo, $valor, $idVentas): bool
    {
        $result = true;
        $valida = "";
        $var = "";
        $sql = "";
        switch ($tipo):
            case 'litros':
                $valida = "dia";
                $var = "litros=?";
                break;
            case 'jarras':
                $valida = "dia";
                $var = "jarras=?";
                break;
            case 'preciolitro':
                $valida = "dia";
                $var = "precio_litro=?";
                break;
            case 'otros':
                $valida = "otros";
                $var = "importe=?";
                break;
            case 'piezas':
                $valida = "otros";
                $var = "piezas=?";
                break;
        endswitch;
        if ($valida == "dia"):
            $sql = "UPDATE op_ventas_dia SET $var WHERE id=? ";
        elseif ($valida == "otros"):
            $sql = "UPDATE op_ventas_dia_otros SET $var WHERE id=? ";
        endif;
        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        endif;
        $stmt->bind_param("di", $valor, $idVentas);
        if (!$stmt->execute()):
            $result = false;
            throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
        endif;
        return $result;
    }
    public function editarVentasProducto($producto, $idVentas)
    {
        $result = true;
        $ieps = 0;

        switch ($producto):
            case 'G Super':
                $ieps = 0.4369;
                break;
            case 'G PREMIUM':
                $ieps = 0.5331;
                break;
            case 'G DIESEL':
                $ieps = 0.3626;
                break;
        endswitch;
        $sql = "UPDATE op_ventas_dia SET producto=?, ieps =? WHERE id=? ";
        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        endif;
        $stmt->bind_param("sdi", $producto, $ieps, $idVentas);
        if (!$stmt->execute()):
            $result = false;
            throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
        endif;
        return $result;
    }
    public function editarVentasPiezas($idReporte): bool
    {
        $result = true;
        $cantidad = 0;
        $precio = 0;
        $sql_listaaceites = "SELECT cantidad,precio_unitario FROM op_aceites_lubricantes WHERE idreporte_dia =?";
        $result_reporte = $this->con->prepare($sql_listaaceites);
        if (!$result_reporte):
            throw new Exception("Error en la preparacion de la consulta" . $this->con->error);
        endif;
        $result_reporte->bind_param('i', $idReporte);
        $result_reporte->execute();
        $result_reporte->bind_result($cantidad, $precio);
        $totalCantidad = 0;
        $totalPrecio = 0;
        while ($result_reporte->fetch()):
            $importe = $cantidad * $precio;
            $totalCantidad += $cantidad;
            $totalPrecio += $importe;
        endwhile;
        $result_reporte->close();
        $concepto = '4 ACEITES Y LUBRICANTES';
        $sql = "UPDATE op_ventas_dia_otros SET piezas=?, importe =? WHERE idreporte_dia =? AND concepto =? ";
        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        endif;
        $stmt->bind_param("sdis", $totalCantidad, $totalPrecio, $idReporte, $concepto);
        if (!$stmt->execute()):
            $result = false;
            throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
        endif;
        $stmt->close();
        return $result;
    }
    public function editarObservaciones(int $idReporte, string $observaciones): bool
    {
        $result = true;
        $sql_reporte = "SELECT idreporte_dia FROM op_observaciones WHERE idreporte_dia = '" . $idReporte . "' ";
        $result_reporte = mysqli_query($this->con, $sql_reporte);
        $numero_reporte = mysqli_num_rows($result_reporte);
        $sql = "";
        if ($numero_reporte == 0):
            $sql = "INSERT INTO op_observaciones (observaciones,idreporte_dia) VALUES(?,?) ";
        else:
            $sql = "UPDATE op_observaciones SET observaciones=? WHERE idreporte_dia =? ";
        endif;
        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        endif;
        $stmt->bind_param("si", $observaciones, $idReporte);
        if (!$stmt->execute()):
            $result = false;
            throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
        endif;
        $stmt->close();
        return $result;

    }
    public function idReporte(int $sessionIdEstacion, int $year, int $mes): int
    {
        // Obtiene el año 
        $idyear = 0;
        $idmes = 0;
        $sql_year = "SELECT id FROM op_corte_year WHERE id_estacion = ? AND year = ?";
        $stmt_year = $this->con->prepare($sql_year);
        if (!$stmt_year):
            // Manejo de error
            throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
        endif;
        $stmt_year->bind_param('ii', $sessionIdEstacion, $year);
        $stmt_year->execute();
        $stmt_year->bind_result($idyear);
        $stmt_year->fetch();
        $stmt_year->close();
        // Obtiene el mes 
        $sql_mes = "SELECT id FROM op_corte_mes WHERE id_year = ? AND mes = ?";
        $stmt_mes = $this->con->prepare($sql_mes);
        if (!$stmt_mes):
            // Manejo de error
            throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
        endif;
        $stmt_mes->bind_param('ii', $idyear, $mes);
        $stmt_mes->execute();
        $stmt_mes->bind_result($idmes);
        $stmt_mes->fetch();
        $stmt_mes->close();
        return $idmes;
    }

    public function nuevoRegistroAceites(int $idReporte, int $IdMes, int $sessionIdEstacion): void
    {
        $noAceite=0;
        $concepto = 0;
        $precio=0;
        $sql_listaaceite = "SELECT
        op_aceites.id_aceite,
        op_aceites.concepto,
        op_aceites.precio
        FROM op_inventario_aceites
        INNER JOIN op_aceites
        ON op_inventario_aceites.id_aceite = op_aceites.id WHERE op_inventario_aceites.id_estacion =? AND id_mes =? ";

        $result_listaAceite = $this->con->prepare($sql_listaaceite);
        if (!$result_listaAceite):
            // Manejo de error
            throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
        endif;
        $result_listaAceite->bind_param('ii', $sessionIdEstacion, $IdMes);
        $result_listaAceite->execute();
        $result_listaAceite->bind_result($noAceite, $concepto, $precio);

        $aceites = []; // Array para almacenar los resultados

        while ($result_listaAceite->fetch()) {
            $aceites[] = [
                'id_aceite' => $noAceite,
                'concepto' => $concepto,
                'precio' => $precio
            ];
        }

        $result_listaAceite->free_result(); // Libera resultados
        $result_listaAceite->close(); // Cierra la conexión

        // Procesa los resultados almacenados
        foreach ($aceites as $aceite) {
            $this->validaAceites($idReporte, $aceite['id_aceite'], $aceite['concepto'], $aceite['precio']);
        }
    }
    public function validaAceites(int $idReporte, int $noAceite, string $concepto, float $precio): void
    {
        $numero_reporte = 0;
        $sql_reporte = "SELECT idreporte_dia FROM op_aceites_lubricantes WHERE idreporte_dia = ? AND concepto = ? ";
        $result_reporte = $this->con->prepare($sql_reporte);
        if (!$result_reporte):
            // Manejo de error
            throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
        endif;
        $result_reporte->bind_param('is', $idReporte, $concepto);
        $result_reporte->execute();
        $result_reporte->bind_result($numero_reporte);
        $result_reporte->fetch();
        $result_reporte->close();
        if ($numero_reporte == 0):
            $cantidad = 0;
            $sql_insert = "INSERT INTO op_aceites_lubricantes(idreporte_dia,id_aceite,concepto,cantidad,precio_unitario)
                            VALUES (?,?,?,?,?)";
            $stmt = $this->con->prepare($sql_insert);
            if (!$stmt):
                throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
            endif;
            $stmt->bind_param("iisid", $idReporte, $noAceite, $concepto, $cantidad, $precio);
            if (!$stmt->execute()):
                throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
            endif;
            $stmt->close();
        endif;
    }
    public function editarAceitesLubricantes($tipo, $valor, $idAceite): bool
    {
        $result = true;
        $sql_insert = "";
        $value = "";
        $bind = "";
        if ($tipo == "cantidad"):
            $value = "cantidad=?";
            $bind = "ii";
        else:
            $value = "precio_unitario=?";
            $bind = "di";
        endif;
        $sql_insert = "UPDATE op_aceites_lubricantes SET $value WHERE id=? ";
        $stmt = $this->con->prepare($sql_insert);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        endif;
        $stmt->bind_param($bind, $valor, $idAceite);
        if (!$stmt->execute()):
            $result = false;
            throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
        endif;
        $stmt->close();
        return $result;
    }
    public function agregarFirma($idReporte, $img, $sessionIdUsuario, $nombreEstacion): bool
    {
        $dia = 0;
        $result = true;
        $detalle = 'Elaboró';
        $sql_dia = "SELECT fecha FROM op_corte_dia WHERE id =? ";
        $result_dia = $this->con->prepare($sql_dia);
        if (!$result_dia):
            // Manejo de error
            throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
        endif;
        $result_dia->bind_param('i', $idReporte);
        $result_dia->execute();
        $result_dia->bind_result($dia);
        $result_dia->fetch();
        $result_dia->close();
        // mover imagen al servidor 
        $img = str_replace('data:image/png;base64,', '', $img);
        $fileData = base64_decode($img);
        $fileName = uniqid() . '.png';
        $hoy = date("Y-m-d H:i:s");
        $num19 = 19;
        $num2 = 2;
        $superviso = "Superviso";
        $vitstoB = "VoBo";
        $corte = 1;
        $accion = "";
        if (file_put_contents('../../../imgs/firma/' . $fileName, $fileData)):
            $sql_insert = "INSERT INTO op_corte_dia_firmas (
                id_reportedia,
                id_usuario,
                firma,
                detalle
                )
                VALUES (?,?,?,?)";
            $stmt = $this->con->prepare($sql_insert);
            if (!$stmt):
                throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
            endif;
            $stmt->bind_param("iiss", $idReporte, $sessionIdUsuario, $fileName, $detalle);
            if (!$stmt->execute()):
                $result = false;
                throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
            endif;
            $this->firmar($idReporte, $num19, $superviso, $hoy);
            $this->firmar($idReporte, $num2, $vitstoB, $hoy);
            $sql = "UPDATE op_corte_dia SET ventas = ?, tpv = ?, monedero = ? WHERE id = ? ";
            $consulta = $this->con->prepare($sql);
            $consulta->bind_param('iiii', $corte, $corte, $corte, $idReporte);
            $consulta->execute();
            $consulta->close();
            //$token = $this->toquenUser($num19);
            $token = $this->formato->toquenUser($num19);

            $detalle = 'Se finalizo el corte del día ' . $dia . ' de la estación ' . $nombreEstacion;

            $result = true;
            //$this->sendNotification($token, $detalle,$accion);
            $this->formato->sendNotification($token, $detalle, $accion);

            $stmt->close();
        endif;
        return $result;
    }
    public function firmar($idReporte, $idUsuario, $tipoFirma, $Fecha): void
    {
        $NuevaFecha = "";
        $firma = "Firma: " . bin2hex(random_bytes(64)) . "." . uniqid();

        $sql_firma = "SELECT * FROM op_corte_dia_firmas WHERE id_reportedia = ? AND detalle = ? ORDER BY id DESC LIMIT 1 ";
        $result_firma = $this->con->prepare($sql_firma);
        if (!$result_firma):
            // Manejo de error
            throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
        endif;
        $result_firma->bind_param('is', $idReporte, $tipoFirma);
        $result_firma->execute();
        $result_firma->store_result();

        if ($result_firma->num_rows === 0):

            if ($tipoFirma == 'Superviso'):
                $NuevaFecha = strtotime('+1 hour', strtotime($Fecha));
                $NuevaFecha = date('Y-m-d H:i:s', $NuevaFecha);
            elseif ($tipoFirma == 'VoBo'):
                $Fecha1 = strtotime('+2 hour', strtotime($Fecha));
                $Fecha1 = date('Y-m-d H:i:s', $Fecha1);
                $NuevaFecha = strtotime('+22 minute', strtotime($Fecha1));
                $NuevaFecha = date('Y-m-d H:i:s', $NuevaFecha);
            endif;

            $sql_insert2 = "INSERT INTO op_corte_dia_firmas (
            id_reportedia,
            id_usuario,
            fecha,
            firma,
            detalle
            )
            VALUES (?,?,?,?,?)";
            $sql = $this->con->prepare($sql_insert2);
            if (!$sql):
                // Manejo de error
                throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
            endif;
            $sql->bind_param('iisss', $idReporte, $idUsuario, $NuevaFecha, $firma, $tipoFirma);
            $sql->execute();
            $sql->close();
        endif;
    }


    public function agregarDocumento(int $idReporte, string $nombreDocumento, array $file): void
    {
        $aleatorio = uniqid();
        $archivo = $file['name'];
        $upload_folder = "../../../archivos/" . $aleatorio . "-" . $archivo;
        $PDFNombre = $aleatorio . "-" . $archivo;
        move_uploaded_file($file['tmp_name'], $upload_folder);
        $sql_insert = "INSERT INTO op_corte_dia_archivo (
            id_reportedia,
            detalle,
            documento
            )
        VALUES (?,?,?)";
        $stmt = $this->con->prepare($sql_insert);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        endif;
        $stmt->bind_param("iss", $idReporte, $nombreDocumento, $PDFNombre);
        $stmt->execute();
        $stmt->close();

    }
    public function eliminarDocumentoCorte(int $id): bool
    {
        $result = true;
        $sql = "DELETE FROM op_corte_dia_archivo WHERE id=? ";
        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        endif;
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()):
            $result = false;
            throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
        endif;
        $stmt->close();
        return $result;
    }
    /***
     * ----------------------------------------------------------------------------------------------
     * 
     *                                      Funciones TPV
     * 
     * 
     * ----------------------------------------------------------------------------------------------
     */

    public function nuevoCierreLote(int $idReporte, string $empresa): string
    {
        $noCierre = '';
        $importe = 0;
        $tickets = 0;
        $sql_insert = "INSERT INTO op_cierre_lote (
            idreporte_dia,
            empresa,
            no_cierre_lote,
            importe,
            ticktes
            )
            VALUES (?,?,?,?,?)";

        $stmt = $this->con->prepare($sql_insert);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        endif;
        $stmt->bind_param("issdi", $idReporte, $empresa, $noCierre, $importe, $tickets);
        $stmt->execute();
        $stmt->close();
        return $empresa;
    }

    public function editarCierreLote(string $tipo, string $cierre, int $idCierre, int $idReporte, string $empresa): bool
    {
        $result = true;
        $valor = "";
        switch ($tipo):
            case 'nocierre':
                $valor = "no_cierre_lote=?";
                break;
            case 'importe':
                $valor = "importe=?";
                break;
            case 'noticket':
                $valor = "ticktes=?";
                break;
        endswitch;
        $sql = "UPDATE op_cierre_lote SET $valor WHERE id=? ";
        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        endif;
        $stmt->bind_param("si", $cierre, $idCierre);
        $stmt->execute();
        $this->monederosBancos($idReporte, $empresa);
        $stmt->close();
        return $result;
    }
    public function editarPendienteCierreLote(int $estado, int $idCierre): bool
    {
        $result = true;
        $sql = "UPDATE op_cierre_lote SET estado =? WHERE id=? ";
        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        endif;
        $stmt->bind_param("ii", $estado, $idCierre);
        $stmt->execute();
        $stmt->close();
        return $result;
    }
    /***
     * ------------------------------------------------------------------------------------------
     *                              
     *                      CLIENTES
     * 
     * ------------------------------------------------------------------------------------------
     */
    public function agregarPagosClientes(array $file, int $idReporte, int $cliente, float $total, string $tipo, string $formaPago): bool
    {
        $result = true;
        $pdfNombre = "";

        if (!empty($file) && isset($file['name'])):
            $archivo = $file['name'];
            $aleatorio = uniqid();
            $upload_folder = "../../../archivos/" . $aleatorio . "-" . $archivo;
            $pdfNombre = $aleatorio . "-" . $archivo;
            move_uploaded_file($file['tmp_name'], $upload_folder);
        endif;
        $sql_insert = "INSERT INTO op_consumos_pagos (
            id_reportedia,
            id_cliente,
            total,
            tipo,
            pago,
            comprobante)
            VALUES (?,?,?,?,?,?)";
        $stmt = $this->con->prepare($sql_insert);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        endif;
        $stmt->bind_param("iidsss", $idReporte, $cliente, $total, $tipo, $formaPago, $pdfNombre);
        $stmt->execute();
        $stmt->close();
        return $result;
    }
    public function agregarConsumos(int $idReporte, int $cliente, float $total, string $tipo): bool
    {
        $result = true;
        $pago = "";
        $comprobante = "";
        $sql_insert = "INSERT INTO op_consumos_pagos (
            id_reportedia,
            id_cliente,
            total,
            tipo,
            pago,
            comprobante
            )
            VALUES (?,?,?,?,?,?)";
        $stmt = $this->con->prepare($sql_insert);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        endif;
        $stmt->bind_param("iidsss", $idReporte, $cliente, $total, $tipo, $pago, $comprobante);
        if (!$stmt->execute()):
            $result = false;
            throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
        endif;
        $stmt->close();
        return $result;
    }
    public function elimarConsumosPagos(int $id): bool
    {
        $result = true;
        $sql = "DELETE FROM op_consumos_pagos WHERE id=?";
        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        endif;
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()):
            $result = false;
            throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
        endif;
        $stmt->close();
        return $result;
    }
    public function agregarCliente(int $idEstacion, string $cuenta, string $cliente, string $tipo, string $rfc, array $doc): bool
    {
        $result = true;
        $estado = 1;
        $sql_insert = "INSERT INTO op_cliente (
            id_estacion,
            cuenta,
            cliente,
            tipo,
            rfc,
            estado
            )
            VALUES(?,?,?,?,?,?)";
        $stmt = $this->con->prepare($sql_insert);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        endif;
        $stmt->bind_param("issssi", $idEstacion, $cuenta, $cliente, $tipo, $rfc, $estado);
        if (!$stmt->execute()):
            $result = false;
            throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
        endif;
        $stmt->close();

        if ($doc[0] != ''):
            $indice = 0;
            $campo = "doc_cc = ?";
            $this->agregarDocumentoCliente($doc, $indice, $campo, $idEstacion);
        endif;
        if ($doc[1] != ''):
            $indice = 1;
            $campo = "doc_ac = ?";
            $this->agregarDocumentoCliente($doc, $indice, $campo, $idEstacion);
        endif;
        if ($doc[2] != ''):
            $indice = 2;
            $campo = "doc_cd = ?";
            $this->agregarDocumentoCliente($doc, $indice, $campo, $idEstacion);
        endif;
        if ($doc[3] != ''):
            $indice = 3;
            $campo = "doc_io = ?";
            $this->agregarDocumentoCliente($doc, $indice, $campo, $idEstacion);
        endif;
        return $result;
    }
    public function agregarDocumentoCliente(array $doc, int $indice, string $campo, int $idEstacion): void
    {
        $aleatorio = uniqid();
        if (isset($doc[$indice]['name']) && isset($doc[$indice]['tmp_name'])):
            $documentoNombre = $doc[$indice]['name'];
            $folder = "../../../archivos/" . $aleatorio . "-" . $documentoNombre;
            $nombre = $aleatorio . "-" . $documentoNombre;
            move_uploaded_file($doc[$indice]['tmp_name'], $folder);
            $sql = "UPDATE op_cliente SET $campo WHERE id_estacion=?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("si", $nombre, $idEstacion);
            $stmt->execute();
            $stmt->close();
        endif;
    }

    public function editarClienteCredito(int $idCliente, string $cuenta, string $cliente, string $tipo, string $rfc, array $doc): bool
    {
        $result = true;
        $sql = "UPDATE op_cliente SET 
            cuenta = ?,
            cliente = ?,
            tipo = ?,
            rfc = ?
            WHERE id= ? ";
        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        endif;
        $stmt->bind_param("ssssi", $cuenta, $cliente, $tipo, $rfc, $idCliente);
        if (!$stmt->execute()):
            $result = false;
            throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
        endif;
        $stmt->close();
        if ($doc[0] != ''):
            $indice = 0;
            $campo = "doc_cc = ?";
            $this->actualizaDocumento($doc, $indice, $campo, $idCliente);
        endif;
        if ($doc[1] != ''):
            $indice = 1;
            $campo = "doc_ac = ?";
            $this->actualizaDocumento($doc, $indice, $campo, $idCliente);
        endif;
        if ($doc[2] != ''):
            $indice = 2;
            $campo = "doc_cd = ?";
            $this->actualizaDocumento($doc, $indice, $campo, $idCliente);
        endif;
        if ($doc[3] != ''):
            $indice = 3;
            $campo = "doc_io = ?";
            $this->actualizaDocumento($doc, $indice, $campo, $idCliente);
        endif;
        return $result;
    }
    public function actualizaDocumento(array $doc, int $indice, string $campo, int $idCliente): void
    {
        $aleatorio = uniqid();
        if (isset($doc[$indice]['name']) && isset($doc[$indice]['tmp_name'])):
            $documentoNombre = $doc[$indice]['name'];
            $folder = "../../../archivos/" . $aleatorio . "-" . $documentoNombre;
            $nombre = $aleatorio . "-" . $documentoNombre;
            move_uploaded_file($doc[$indice]['tmp_name'], $folder);
            $sql = "UPDATE op_cliente SET $campo WHERE id=?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("si", $nombre, $idCliente);
            $stmt->execute();
            $stmt->close();
        endif;
    }
    public function editarClienteDebito(string $cuenta, string $cliente, string $tipo, int $id): bool
    {
        $result = true;
        $sql = "UPDATE op_cliente SET cuenta = ?,cliente = ?,tipo = ? WHERE id=? ";
        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        endif;
        $stmt->bind_param("sssi", $cuenta, $cliente, $tipo, $id);
        if (!$stmt->execute()):
            $result = false;
            throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
        endif;
        $stmt->close();
        return $result;
    }
    public function editarSaldoInicial(int $id, float $total): int
    {
        $saldo_inicial=0;
        $consumos=0;
        $pagos=0;
        $result = 0;
        $sql = "UPDATE op_consumos_pagos_resumen SET saldo_inicial=? WHERE id=? ";
        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("Erros al preparar la consulta" . $this->con->error);
        endif;
        $stmt->bind_param("di", $total, $id);
        if (!$stmt->execute()):
            throw new Exception("Erros al preparar la consulta" . $this->con->error);
        endif;
        $stmt->close();
        $sql_credito = "SELECT 
            op_consumos_pagos_resumen.saldo_inicial,
            op_consumos_pagos_resumen.consumos,
            op_consumos_pagos_resumen.pagos
            FROM op_consumos_pagos_resumen
            INNER JOIN op_cliente 
            ON op_consumos_pagos_resumen.id_cliente = op_cliente.id
            WHERE op_consumos_pagos_resumen.id = ? ";
        $stmt2 = $this->con->prepare($sql_credito);
        if (!$stmt2):
            throw new Exception("Erros al preparar la consulta" . $this->con->error);
        endif;
        $stmt2->bind_param("i", $id);
        $stmt2->execute();
        $stmt2->bind_result($saldo_inicial, $consumos, $pagos);
        while ($stmt2->fetch()):
            $saldofinalC = $saldo_inicial + $consumos - $pagos;
        endwhile;
        $stmt2->close();
        $sql1 = "UPDATE op_consumos_pagos_resumen SET saldo_final=? WHERE id=? ";
        $stmt3 = $this->con->prepare($sql1);
        if (!$stmt3):
            throw new Exception("Error al preparar la consulta " . $this->con->error);
        endif;
        $stmt3->bind_param("di", $saldofinalC, $id);
        if ($stmt3->execute()):
            $result = $saldofinalC;
        endif;
        $stmt3->close();
        return $result;
    }
    public function finalizaResumenClientesMes(int $id): bool
    {
        $resultado = true;
        $sql = "INSERT INTO op_consumos_pagos_resumen_finalizar (id_mes) VALUES(?)";
        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        endif;
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()):
            $resultado = false;
            throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
        endif;
        $stmt->close();
        return $resultado;
    }
    /**
     * 
     * 
     * ACEITES
     *  
     * 
     */
    public function finalizarAceite(int $idEstacion, int $idReporte, string $nombreEstacion): bool
    {
        $result = true;
        $accion = "https://asuntoslegales.tmfsmexico.com/asuntos-legales/";
        $sql_insert = "INSERT INTO op_aceites_lubricantes_reporte_finalizar (id_mes) VALUES (?)";
        $stmt = $this->con->prepare($sql_insert);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        endif;
        $stmt->bind_param("i", $idReporte);
        if (!$stmt->execute()):
            $result = false;
            throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
        endif;
        $stmt->close();
        $nomMes = $this->mes($idReporte);
        $this->newAlmacen($idEstacion, $idReporte);
        //$token = $this->toquenUser(19);
        $token = $this->formato->toquenUser(19);

        $detalle = 'Se finalizo el inventario de ' . $this->formato->nombremes($nomMes['mes']) . ', de la estación ' . $nombreEstacion;
        //$this->sendNotification($token,$detalle,$accion);
        $this->formato->sendNotification($token, $detalle, $accion);


        return $result;
    }
    private function mes(int $id): array
    {
        $sql_mes = "SELECT id_year, mes FROM op_corte_mes WHERE id = '" . $id . "' LIMIT 1 ";
        $result_mes = mysqli_query($this->con, $sql_mes);
        while ($row_mes = mysqli_fetch_array($result_mes, MYSQLI_ASSOC)) {
            $mes = $row_mes['mes'];
            $idyear = $row_mes['id_year'];
        }
        $array = array("mes" => $mes, "idyear" => $idyear);
        return $array;
    }
    private function newAlmacen(int $IDEstacion, int $idreporte): void
    {
        date_default_timezone_set('America/Mexico_City');
        $year = date("Y");

        $mes = $this->mes($idreporte);
        if ($mes['mes'] == 12) {

            $newmes = 1;
            $newyear = $year;
            $IdYear = $this->validaYearReporte($IDEstacion, $newyear);
            $IdMes = $this->validaMesReporte($IdYear, $newmes);
            $this->agregarAlmacen($IDEstacion, $IdMes, $idreporte);

        } else {

            $newmes = $mes['mes'] + 1;
            $idyear = $mes['idyear'];
            $IdMes = $this->validaMesReporte($idyear, $newmes);
            $this->agregarAlmacen($IDEstacion, $IdMes, $idreporte);
        }
    }
    private function validaYearReporte(int $Session_IDEstacion, int $fecha_year): int
    {
        $sql_reporte = "SELECT id, id_estacion, year FROM op_corte_year WHERE id_estacion = '" . $Session_IDEstacion . "' AND year = '" . $fecha_year . "' ";
        $result_reporte = mysqli_query($this->con, $sql_reporte);
        $numero_reporte = mysqli_num_rows($result_reporte);

        if ($numero_reporte == 0) {
            $IdYear = $this->idYear();
            $sql_insert = "INSERT INTO op_corte_year (
                id,
                id_estacion,
                year
                )
                VALUES 
                (
                '" . $IdYear . "',
                '" . $Session_IDEstacion . "',
                '" . $fecha_year . "'
                )";
            mysqli_query($this->con, $sql_insert);
        } else {
            while ($row_mes = mysqli_fetch_array($result_reporte, MYSQLI_ASSOC)) {
                $IdYear = $row_mes['id'];
            }
        }

        return $IdYear;
    }

    private function idYear(): int
    {
        $sql_reporte = "SELECT id FROM op_corte_year ORDER BY id desc LIMIT 1 ";
        $result_reporte = mysqli_query($this->con, $sql_reporte);
        $numero_reporte = mysqli_num_rows($result_reporte);
        while ($row_mes = mysqli_fetch_array($result_reporte, MYSQLI_ASSOC)) {
            $id = $row_mes['id'] + 1;
        }
        return $id;
    }
    private function validaMesReporte(int $IdReporte, int $fecha_mes): int
    {
        $sql_reporte = "SELECT id, id_year, mes FROM op_corte_mes WHERE id_year = '" . $IdReporte . "' AND mes = '" . $fecha_mes . "' ";
        $result_reporte = mysqli_query($this->con, $sql_reporte);
        $numero_reporte = mysqli_num_rows($result_reporte);

        if ($numero_reporte == 0) {

            $IdMes = $this->idMes();

            $sql_insert = "INSERT INTO op_corte_mes (
                id,
                id_year,
                mes
                )
                VALUES 
                (
                '" . $IdMes . "',
                '" . $IdReporte . "',
                '" . $fecha_mes . "'
                )";
            mysqli_query($this->con, $sql_insert);
        } else {
            while ($row_mes = mysqli_fetch_array($result_reporte, MYSQLI_ASSOC)) {
                $IdMes = $row_mes['id'];
            }

        }

        return $IdMes;
    }
    private function idMes(): int
    {
        $sql_reporte = "SELECT id FROM op_corte_mes ORDER BY id desc LIMIT 1 ";
        $result_reporte = mysqli_query($this->con, $sql_reporte);
        $numero_reporte = mysqli_num_rows($result_reporte);
        while ($row_mes = mysqli_fetch_array($result_reporte, MYSQLI_ASSOC)) {
            $id = $row_mes['id'] + 1;
        }
        return $id;
    }
    private function agregarAlmacen(int $IDEstacion, int $IdMes, int $idreporte): void
    {
        $sql1 = "DELETE FROM op_inventario_aceites WHERE id_mes = '" . $IdMes . "' AND id_estacion = '" . $IDEstacion . "' ";
        if (mysqli_query($this->con, $sql1)) {


            $sql_reporte = "SELECT id_aceite, inventario_exibidores, inventario_bodega FROM op_aceites_lubricantes_reporte WHERE id_mes = '" . $idreporte . "' ";
            $result_reporte = mysqli_query($this->con, $sql_reporte);
            $numero_reporte = mysqli_num_rows($result_reporte);
            while ($row_mes = mysqli_fetch_array($result_reporte, MYSQLI_ASSOC)) {
                $idAeite = $this->idAceite($row_mes['id_aceite']);
                $sql_insert = "INSERT INTO op_inventario_aceites (
                    id_mes,
                    id_estacion,
                    id_aceite,
                    exhibidores,
                    bodega
                    )
                    VALUES 
                    (
                    '" . $IdMes . "',
                    '" . $IDEstacion . "',
                    '" . $idAeite . "',
                    '" . $row_mes['inventario_exibidores'] . "',
                    '" . $row_mes['inventario_bodega'] . "'
                    )";

                mysqli_query($this->con, $sql_insert);



            }

        }
    }
    public function idAceite(int $idaceite)
    {
        $sql_reporte = "SELECT id FROM op_aceites WHERE id_aceite = '" . $idaceite . "' LIMIT 1 ";
        $result_reporte = mysqli_query($this->con, $sql_reporte);
        $numero_reporte = mysqli_num_rows($result_reporte);
        while ($row_mes = mysqli_fetch_array($result_reporte, MYSQLI_ASSOC)) {
            $return = $row_mes['id'];
        }

        return $return;
    }
    public function editarReporteAceite($tipo, $valor, int $id): bool
    {
        if ($valor == "producto_facturado" || $valor == "factura_venta_mostrador"):
            $bind = "di";
        endif;
        $bind = "ii";
        $result = true;
        $value = "";
        switch ($tipo):
            case 'pedido':
                $value = "pedido =?";
                break;
            case 'fisicobodega':
                $value = "inventario_bodega =?";
                break;
            case 'fisicoexhibidor':
                $value = "inventario_exibidores =?";
                break;
            case 'facturado':
                $value = "producto_facturado =?";
                break;
            case 'mostrador':
                $value = "factura_venta_mostrador =?";
                break;
        endswitch;
        $sql = "UPDATE op_aceites_lubricantes_reporte SET $value WHERE id=?";
        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("" . $this->con->error);
        endif;
        $stmt->bind_param($bind, $valor, $id);
        if (!$stmt->execute()):
            $result = false;
            throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
        endif;
        $stmt->close();
        return $result;
    }
    public function agregarDocumentoAceite(array $doc, int $idReporte, int $year, int $mes): bool
    {
        $result = false;
        $aleatorio = uniqid();
        $mes_formateado = sprintf("%02d", $mes);
        $fecha_actual = date("Y-m-d");

        //---------- FECHAS FACTURA----------
        $fecha_02 = date("$year-$mes_formateado-02");
        $fecha_03 = date("$year-$mes_formateado-03");
        $fecha_04 = date("$year-$mes_formateado-04");

        $puntajeFactura = 0;
        if ($fecha_actual <= $fecha_02):
            $puntajeFactura = 3;

        elseif ($fecha_actual > $fecha_02 && $fecha_actual <= $fecha_03):
            $puntajeFactura = 2;

        elseif ($fecha_actual > $fecha_03 && $fecha_actual <= $fecha_04):
            $puntajeFactura = 1;

        endif;
        //---------- FECHAS FICHA----------
        $fecha_10 = date("$year-$mes_formateado-10");
        $fecha_20 = date("$year-$mes_formateado-20");
        $puntajeFicha = 0;
        if ($fecha_actual <= $fecha_02):
            $puntajeFicha = 3;

        elseif ($fecha_actual > $fecha_02 && $fecha_actual <= $fecha_10):
            $puntajeFicha = 2;

        elseif ($fecha_actual > $fecha_10 && $fecha_actual <= $fecha_20):
            $puntajeFicha = 1;
        endif;
        //---------- FICHA DE DEPOSITO FALTANTE ----------
        $upload_Ficha = "";
        $documentoFicha = "";
        $fechaFicha = "";

        if (!empty($doc[0]) && isset($doc[0]['name'])):
            $ficha = $doc[0]['name'];
            $upload_Ficha = "../../../archivos/" . $aleatorio . "-" . $ficha;
            $documentoFicha = $aleatorio . "-" . $ficha;
            move_uploaded_file($doc[0]['tmp_name'], $upload_Ficha);
            $fechaFicha = $fecha_actual;
        endif;

        //---------- IMAGEN DE BODEGA ----------
        $upload_Imagen = "";
        $documentoImagen = "";
        if (!empty($doc[1]) && isset($doc[1]['name'])):
            $imagen = $doc[1]['name'];
            $upload_Imagen = "../../../archivos/" . $aleatorio . "-" . $imagen;
            $documentoImagen = $aleatorio . "-" . $imagen;
            move_uploaded_file($doc[1]['tmp_name'], $upload_Imagen);
        endif;

        //---------- FACTURA ----------
        $upload_Factura = "";
        $documentoFactura = "";
        $fechaFactura = "";
        if (!empty($doc[2]) && isset($doc[2]['name'])):
            $factura = $doc[2]['name'];
            $upload_Factura = "../../../archivos/" . $aleatorio . "-" . $factura;
            $documentoFactura = $aleatorio . "-" . $factura;
            move_uploaded_file($doc[2]['tmp_name'], $upload_Factura);
            $fechaFactura = $fecha_actual;
        endif;
        $fechaDia = date("Y-m-d");

        $sql_insert = "INSERT INTO op_aceites_documento (
            id_mes,
            fecha,
            ficha_deposito,
            fecha_evaluacion_ficha,
            puntaje_ficha,
            imagen_bodega,
            factura_venta,
            fecha_evaluacion_factura,
            puntaje_factura
            )
            VALUES(?,?,?,?,?,?,?,?,?)";
        $stmt = $this->con->prepare($sql_insert);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        endif;
        $stmt->bind_param(
            "isssisssi",
            $idReporte,
            $fechaDia,
            $documentoFicha,
            $fechaFicha,
            $puntajeFicha
            ,
            $documentoImagen,
            $documentoFactura,
            $fechaFactura,
            $puntajeFactura
        );
        if (!$stmt->execute()):
            $result = true;
            throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
        endif;
        $stmt->close();
        return $result;
    }
    public function editarDocumentoAceite(array $doc, int $id, int $year, int $mes): void
    {
        $mes_formateado = sprintf("%02d", $mes);
        $fecha_actual = date("Y-m-d");
        //---------- FECHAS FACTURA----------
        $fecha_02 = date("$year-$mes_formateado-02");
        $fecha_03 = date("$year-$mes_formateado-03");
        $fecha_04 = date("$year-$mes_formateado-04");
        $puntaje_facturas = 0;
        if ($fecha_actual <= $fecha_02):
            $puntaje_facturas = 3;
        elseif ($fecha_actual > $fecha_02 && $fecha_actual <= $fecha_03):
            $puntaje_facturas = 2;
        elseif ($fecha_actual > $fecha_03 && $fecha_actual <= $fecha_04):
            $puntaje_facturas = 1;
        endif;
        //---------- FECHAS FICHA----------
        $fecha_10 = date("$year-$mes_formateado-10");
        $fecha_20 = date("$year-$mes_formateado-20");
        $puntaje_fichas = 0;
        if ($fecha_actual <= $fecha_02):
            $puntaje_fichas = 3;
        elseif ($fecha_actual > $fecha_02 && $fecha_actual <= $fecha_10):
            $puntaje_fichas = 2;
        elseif ($fecha_actual > $fecha_10 && $fecha_actual <= $fecha_20):
            $puntaje_fichas = 1;
        endif;

        $aleatorio = uniqid();
        $campo = "";
        $valor = "ssii";
        if (!empty($doc[0]) && isset($doc[0]['name'])):
            $ficha = $doc[0]['name'];
            $upload_Ficha = "../../../archivos/" . $aleatorio . "-" . $ficha;
            $DocumentoFicha = $aleatorio . "-" . $ficha;
            $campo = "ficha_deposito = ?,fecha_evaluacion_ficha = ?,puntaje_ficha = ?";
            if (move_uploaded_file($doc[0]['tmp_name'], $upload_Ficha)):
                $this->actualizaDocumentoAceite($id, $campo, $valor, $DocumentoFicha, $fecha_actual, $puntaje_fichas);
            endif;
        elseif (!empty($doc[1]) && isset($doc[1]['name'])):
            $imagen = $doc[1]['name'];
            $upload_Imagen = "../../../archivos/" . $aleatorio . "-" . $imagen;
            $DocumentoImagen = $aleatorio . "-" . $imagen;
            $fecha = "";
            $puntaje = 0;
            $campo = "imagen_bodega = ?";
            $valor = "si";
            if (move_uploaded_file($doc[1]['tmp_name'], $upload_Imagen)):
                $this->actualizaDocumentoAceite($id, $campo, $valor, $DocumentoImagen, $fecha, $puntaje);
            endif;

        elseif (!empty($doc[2]) && isset($doc[2]['name'])):
            $factura = $doc[2]['name'];
            $upload_Factura = "../../../archivos/" . $aleatorio . "-" . $factura;
            $DocumentoFactura = $aleatorio . "-" . $factura;
            $campo = "factura_venta = ?,fecha_evaluacion_factura = ?, puntaje_factura = ?";
            if (move_uploaded_file($doc[2]['tmp_name'], $upload_Factura)) {
                $this->actualizaDocumentoAceite($id, $campo, $valor, $DocumentoFactura, $fecha_actual, $puntaje_facturas);
            }
        endif;
    }
    private function actualizaDocumentoAceite(int $id, string $campo, string $valor, string $archivo, string $fecha, int $puntaje): void
    {

        $sql = "UPDATE op_aceites_documento SET $campo WHERE id=?";
        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta " . $stmt->error);
        endif;

        if ($fecha == "" && $puntaje == 0):
            $stmt->bind_param($valor, $archivo, $id);
        elseif ($fecha != ""):
            $stmt->bind_param($valor, $archivo, $fecha, $puntaje, $id);
        endif;

        if (!$stmt->execute()):
            throw new Exception("Error al ejecutar la consulta" . $this->con->error);
        endif;
        $stmt->close();
    }
    public function eliminarDocumentoAceite(int $id): bool
    {
        $result = true;
        $sql = "DELETE FROM op_aceites_documento WHERE id= ? ";
        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta " . $stmt->error);
        endif;
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()):
            $result = false;
            throw new Exception("Error al ejecutar la consulta" . $this->con->error);
        endif;
        $stmt->close();
        return $result;
    }
    public function agregarFacturaArchivoAceite(int $id, string $fechaAceite, string $conceptoAceite, array $archivo, int $mes, int $year): bool
    {
        $result = true;
        $aleatorio = uniqid();
        $upload_Factura = "";
        $documentoFactura = "";
        if (!empty($archivo) && isset($archivo['name'])):
            $factura = $archivo['name'];
            $upload_Factura = "../../../archivos/aceites-facturas/" . $aleatorio . "-" . $factura;
            $documentoFactura = $aleatorio . "-" . $factura;
            move_uploaded_file($archivo['tmp_name'], $upload_Factura);
        endif;

        $mes_formateado = sprintf("%02d", $mes);

        $fecha_20 = date("$year-$mes_formateado-20");
        $fecha_25 = date("$year-$mes_formateado-25");
        $fecha_28 = date("$year-$mes_formateado-28");

        $fecha_actual = date("Y-m-d");
        $puntaje = 0;
        if ($fecha_actual <= $fecha_20):
            $puntaje = 3;
        elseif ($fecha_actual > $fecha_20 && $fecha_actual <= $fecha_25):
            $puntaje = 2;
        elseif ($fecha_actual > $fecha_25 && $fecha_actual <= $fecha_28):
            $puntaje = 1;
        endif;

        $sql_insert = "INSERT INTO op_aceites_factura (
            id_mes,
            fecha,
            nombre_anexo,
            archivo,
            fecha_evaluacion,
            puntaje
            ) VALUES (?,?,?,?,?,?)";
        $stmt = $this->con->prepare($sql_insert);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta " . $stmt->error);
        endif;
        $stmt->bind_param("issssi", $id, $fechaAceite, $conceptoAceite, $documentoFactura, $fecha_actual, $puntaje);
        if (!$stmt->execute()):
            $result = false;
            throw new Exception("Error al ejecutar la consulta" . $this->con->error);
        endif;
        $stmt->close();
        return $result;
    }
    public function eliminarFacturaArchivoAceite($id): bool
    {
        $result = true;
        $sql = "DELETE FROM op_aceites_factura WHERE id = ? ";
        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta " . $this->con->error);
        endif;
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()):
            $result = false;
            throw new Exception("Error al ejecutar la consulta" . $stmt->error);
        endif;
        $stmt->close();
        return $result;
    }

    /**
     * 
     * 
     * 
     * MONEDEROS
     * 
     * 
     */
    public function agregarDocumentoMonedero(array $doc, int $id, string $fecha, string $monedero, float $diferencia): void
    {
        $aleatorio = uniqid();
        $valor = "";
        if (!empty($doc[0]) && isset($doc[0]['name'])):
            $valor = "pdf = ?";
            $pdf = $doc[0]['name'];
            $upload_PDF = "../../../archivos/" . $aleatorio . "-" . $pdf;
            $documentoPDF = $aleatorio . "-" . $pdf;
            if (move_uploaded_file($doc[0]['tmp_name'], $upload_PDF)):
                $this->actualizaDocumentoMonedero($documentoPDF, $id, $valor);
            endif;
        endif;
        if (!empty($doc[1]) && isset($doc[1]['name'])):
            $valor = "xml = ?";
            $xml = $doc[1]['name'];
            $upload_XML = "../../../archivos/" . $aleatorio . "-" . $xml;
            $documentoXML = $aleatorio . "-" . $xml;
            if (move_uploaded_file($doc[1]['tmp_name'], $upload_XML)):
                $this->actualizaDocumentoMonedero($documentoXML, $id, $valor);
            endif;
        endif;

        if (!empty($doc[2]) && isset($doc[2]['name'])):
            $valor = "excel = ?";
            $excel = $doc[2]['name'];
            $upload_EXCEL = "../../../archivos/" . $aleatorio . "-" . $excel;
            $documentoEXCEL = $aleatorio . "-" . $excel;
            if (move_uploaded_file($doc[2]['tmp_name'], $upload_EXCEL)):
                $this->actualizaDocumentoMonedero($documentoEXCEL, $id, $valor);
            endif;
        endif;

        $sql = "UPDATE op_monedero_documento SET fecha = ?, monedero = ?, diferencia = ? WHERE id=? ";
        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta" . $this->con->error);
        endif;
        $stmt->bind_param("ssdi", $fecha, $monedero, $diferencia, $id);
        if (!$stmt->execute()):
            throw new Exception("Erro al ejecutar la consulta", $stmt->error);
        endif;
        $stmt->close();
    }
    private function actualizaDocumentoMonedero(string $documento, int $id, string $valor): void
    {
        $sql = "UPDATE op_monedero_documento SET $valor WHERE id=?";
        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta" . $this->con->error);
        endif;
        $stmt->bind_param("si", $documento, $id);
        if (!$stmt->execute()):
            throw new Exception("Erro al ejecutar la consulta", $stmt->error);
        endif;
        $stmt->close();
    }
    public function agregarDocumentoEdi(array $doc, int $id, string $complemento): void
    {

        $aleatorio = uniqid();
        $archivoPdf = "";
        $archivoXml = "";
        if (!empty($doc[0]) && isset($doc[0]['name'])):
            $pdf = $doc[0]['name'];
            $upload_PDF = "../../../archivos/" . $aleatorio . "-" . $pdf;
            $documentoPDF = $aleatorio . "-" . $pdf;
            if (move_uploaded_file($doc[0]['tmp_name'], $upload_PDF)):
                $archivoPdf = $documentoPDF;
            endif;
        endif;
        if (!empty($doc[1]) && isset($doc[1]['name'])):
            $xml = $doc[1]['name'];
            $upload_XML = "../../../archivos/" . $aleatorio . "-" . $xml;
            $documentoXML = $aleatorio . "-" . $xml;
            if (move_uploaded_file($doc[1]['tmp_name'], $upload_XML)):
                $archivoXml = $documentoXML;
            endif;
        endif;
        $sql = "INSERT INTO op_monedero_edi (id_documento,complemento,pdf,xml) VALUES (?,?,?,?)";
        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta" . $this->con->error);
        endif;
        $stmt->bind_param("isss", $id, $complemento, $archivoPdf, $archivoXml);
        if (!$stmt->execute()):
            throw new Exception("Erro al ejecutar la consulta", $stmt->error);
        endif;
        $stmt->close();

    }
    public function eliminarDocumentoEdi(int $id): bool
    {
        $result = true;
        $sql = "DELETE FROM op_monedero_edi WHERE id= ? ";
        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta" . $this->con->error);
        endif;
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()):
            $result = false;
            throw new Exception("Error al ejecutar la consulta" . $stmt->error);
        endif;
        return $result;
    }
    public function agregarPagoDiferencia(int $repAceite, int $year, int $mes, array $doc, int $idEstacion, string $comentario): void
    {
        $inventario_bodega=0;
        $inventario_exibidores=0;
        $bodega=0;
        $exibidores=0;
        $pedido=0;
        $noaceite=0;
        $idmes=0;
        $sql_reporte =
            "SELECT inventario_bodega,inventario_exibidores,bodega,exibidores,pedido,id_aceite,id_mes
         FROM op_aceites_lubricantes_reporte WHERE id = ?";
        $result_reporte = $this->con->prepare($sql_reporte);
        if (!$result_reporte):
            throw new Exception("Error al preparar la consulta" . $this->con->error);
        endif;
        $result_reporte->bind_param("i", $repAceite); // "i" indica que $repAceite es un entero (si es otro tipo, ajusta la letra correspondiente)
        if (!$result_reporte->execute()):
            throw new Exception("Error al ejectuar la consulta" . $result_reporte->error);
        endif;
        $result_reporte->store_result();
        $numero_reporte = $result_reporte->num_rows;
        if ($numero_reporte > 0):
            $result_reporte->bind_result($inventario_bodega, $inventario_exibidores, $bodega, $exibidores, $pedido, $noaceite, $idmes);
            while ($result_reporte->fetch()):
                $inventario_bodega = $this->valRow($inventario_bodega);
                $inventario_exibidores = $this->valRow($inventario_exibidores);
                $bodega = $this->valRow($bodega);
                $exibidores = $this->valRow($exibidores);
                $pedido = $this->valRow($pedido);
                $totalaceites = $this->totalAceite($idmes, $noaceite);
                $idAceite = $this->idAceite($noaceite);
                $inventarioI = $bodega + $exibidores;
                $inventarioF = $inventarioI + $pedido - $totalaceites;
                $inventario_final = $inventario_bodega + $inventario_exibidores;
                $diferencia = $inventario_final - $inventarioF;
            endwhile;
        endif;
        if ($mes == 12):
            $nwyear = $year + 1;
            $nwmes = 1;
            $IdReporte = $this->idReportePago($idEstacion, $nwyear, $nwmes);
        else:
            $nwyear = $year;
            $nwmes = $mes + 1;
            $IdReporte = $this->idReportePago($idEstacion, $nwyear, $nwmes);
        endif;

        $aleatorio = uniqid();
        if (!empty($doc) && isset($doc['name'])):
            $pdf = $doc['name'];
            $upload_PDF = "../../../archivos/" . $aleatorio . "-" . $pdf;
            $documentoPDF = $aleatorio . "-" . $pdf;
            if (move_uploaded_file($doc['tmp_name'], $upload_PDF)):
                $status = 0;
                $dif = abs($diferencia);
                $sql_insert = "INSERT INTO op_aceites_lubricantes_reporte_pagodiferencia (
                    id_aceite,
                    id_reporte,
                    nomaceite,
                    diferencia,
                    documento,
                    comentario,
                    estado
                    )
                    VALUES 
                    (?,?,?,?,?,?,?)";
                $stmt = $this->con->prepare($sql_insert);
                if (!$stmt):
                    throw new Exception("Error al preparar la consulta" . $this->con->error);
                endif;
                $stmt->bind_param("iiiissi", $repAceite, $IdReporte, $noaceite, $dif, $documentoPDF, $comentario, $status);
                $this->actualizarAlmacen($IdReporte, $idAceite, $dif);
            endif;
        endif;
    }
    private function valRow(int $valor): int
    {
        $resultado = 0;
        if ($valor != 0):
            $resultado = number_format($valor, 2, '.', '');
        endif;
        return $resultado;
    }
    private function idReportePago($Session_IDEstacion, $GET_year, $GET_mes)
    {
        $idmes = 0;
        $sql_mes = "SELECT id FROM op_corte_mes WHERE id_year = (SELECT id FROM op_corte_year WHERE id_estacion = ? AND year = ?) AND mes = ?";
        $stmt_mes = $this->con->prepare($sql_mes);
        if (!$stmt_mes):
            throw new Exception("Error al preparar la consulta" . $this->con->error);
        endif;
        $stmt_mes->bind_param("iss", $Session_IDEstacion, $GET_year, $GET_mes);
        $stmt_mes->execute();
        $stmt_mes->bind_result($idmes);
        $stmt_mes->fetch();
        $stmt_mes->close();
        return $idmes;
    }
    private function totalAceite(int $idmes, int $noaceite): int
    {
        $id = 0;
        $can = 0;
        $sql = "SELECT id FROM op_corte_dia WHERE id_mes = ? ";
        $result = $this->con->prepare($sql);
        if (!$result):
            throw new Exception("Error al preparar la consulta" . $this->con->error);
        endif;
        $result->bind_param("i", $idmes);
        if (!$result->execute()):
            throw new Exception("Error al ejecutar la consulta" . $result->error);
        endif;
        $result->bind_result($id);
        $result->fetch();
        $result->close();
        $sql_lista = "SELECT cantidad FROM op_aceites_lubricantes WHERE idreporte_dia = ? AND id_aceite = ? LIMIT 1 ";
        $result2 = $this->con->prepare($sql_lista);
        if (!$result2):
            throw new Exception("Error al preparas la segunda consulta" . $this->con->error);
        endif;
        $result2->bind_param("ii", $id, $noaceite);
        if (!$result2->execute()):
            throw new Exception("Error al ejecutar la segunda consulta " . $result2->error);
        endif;
        $result2->bind_result($can);
        $cantidad = $result2->fetch();
        $result2->close();
        return $cantidad;
    }
    private function actualizarAlmacen($IdReporte, $idAceite, $diferencia)
    {
        $id = 0;
        $bod = 0;
        $sql_reporte = "SELECT id, bodega FROM op_inventario_aceites WHERE id_mes = ? AND id_aceite = ? ";
        $result_reporte = $this->con->prepare($sql_reporte);
        if (!$result_reporte):
            throw new Exception("Error al preparar la consulta" . $this->con->error);
        endif;
        $result_reporte->bind_param("ii", $IdReporte, $idAceite);
        if (!$result_reporte->execute()):
            throw new Exception("" . $result_reporte->error);
        endif;
        $result_reporte->bind_result($id, $bod);
        $result_reporte->close();
        $bodega = $bod + $diferencia;
        $sql = "UPDATE op_inventario_aceites SET bodega =? WHERE id =?";
        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta" . $this->con->error);
        endif;
        $stmt->bind_param("ii", $bodega, $id);
        if (!$stmt->execute()):
            throw new Exception("Error al ejecutar la consulta" . $stmt->error);
        endif;
        $stmt->close();
    }
    /***
     * 
     * 
     * 
     *          EMBARQUES
     * 
     * 
     * 
     * 
     * 
     */

    public function agregarComentarioEmbarques(int $idEmbarque, int $idEstacion, string $comentario): bool
    {
        $result = true;
        $sql = "INSERT INTO op_embarques_comentario (
            id_embarques,
            id_usuario,
            comentario
            ) VALUES (?,?,?)";
        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta" . $this->con->error);
        endif;
        $stmt->bind_Param("iis", $idEmbarque, $idEstacion, $comentario);
        if (!$stmt->execute()):
            throw new Exception("Erro al ejecutar la consulta", $stmt->error);
        endif;
        $stmt->close();
        return $result;
    }
    public function agregarEmbarques(array $doc, array $val): void
    {
        $sql = "INSERT INTO op_embarques (
            id_mes,
            fecha,
            embarque,
            documentocv,
            importef,
            merma,
            nom_transporte,
            producto,
            chofer,
            unidad,
            precio_litro,
            tad
            )
            VALUES 
            (?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta" . $this->con->error);
        endif;
        $stmt->bind_Param(
            "isssddssssds",
            $val[0],
            $val[1],
            $val[2],
            $val[3],
            $val[4],
            $val[5]
            ,
            $val[6],
            $val[7],
            $val[8],
            $val[9],
            $val[10],
            $val[11]
        );
        if (!$stmt->execute()):
            throw new Exception("Erro al ejecutar la consulta", $stmt->error);
        endif;
        $stmt->close();
        // Agrega los formatos en caso de requerrilos
        $id_mes = $val[0];
        $aleatorio = uniqid();
        $valor = "";
        $consulta = "id_mes = ?";
        if (!empty($doc[0]) && isset($doc[0]['name'])):
            $valor = "documento = ?";
            $docu = $doc[0]['name'];
            $documento = "../../../archivos/" . $aleatorio . "-" . $docu;
            $documentoPDF = $aleatorio . "-" . $docu;
            if (move_uploaded_file($doc[0]['tmp_name'], $documento)):
                $this->actualizaDocumentoEmbarques($documentoPDF, $id_mes, $valor, $consulta);
            endif;
        endif;
        if (!empty($doc[1]) && isset($doc[1]['name'])):
            $valor = "pdf = ?";
            $pdf = $doc[1]['name'];
            $uploadPdf = "../../../archivos/" . $aleatorio . "-" . $pdf;
            $documentoPdf = $aleatorio . "-" . $pdf;
            if (move_uploaded_file($doc[1]['tmp_name'], $uploadPdf)):
                $this->actualizaDocumentoEmbarques($documentoPdf, $id_mes, $valor, $consulta);
            endif;
        endif;

        if (!empty($doc[2]) && isset($doc[2]['name'])):
            $valor = "xml = ?";
            $xml = $doc[2]['name'];
            $uploadXml = "../../../archivos/" . $aleatorio . "-" . $xml;
            $documentoXml = $aleatorio . "-" . $xml;
            if (move_uploaded_file($doc[2]['tmp_name'], $uploadXml)):
                $this->actualizaDocumentoEmbarques($documentoXml, $id_mes, $valor, $consulta);
            endif;
        endif;
        if (!empty($doc[3]) && isset($doc[3]['name'])):
            $valor = "comprobante_p = ?";
            $comprobante = $doc[3]['name'];
            $upload_comprobante = "../../../archivos/" . $aleatorio . "-" . $comprobante;
            $documentoComprobante = $aleatorio . "-" . $comprobante;
            if (move_uploaded_file($doc[3]['tmp_name'], $upload_comprobante)):
                $this->actualizaDocumentoEmbarques($documentoComprobante, $id_mes, $valor, $consulta);
            endif;
        endif;
        if (!empty($doc[4]) && isset($doc[4]['name'])):
            $valor = "nc_pdf = ?";
            $nc_pdf = $doc[4]['name'];
            $uploadNc = "../../../archivos/" . $aleatorio . "-" . $nc_pdf;
            $documentoNc = $aleatorio . "-" . $nc_pdf;
            if (move_uploaded_file($doc[4]['tmp_name'], $uploadNc)):
                $this->actualizaDocumentoEmbarques($documentoNc, $id_mes, $valor, $consulta);
            endif;
        endif;

        if (!empty($doc[5]) && isset($doc[5]['name'])):
            $valor = "nc_xml = ?";
            $nc_xml = $doc[5]['name'];
            $uploadNc = "../../../archivos/" . $aleatorio . "-" . $nc_xml;
            $documentoNc = $aleatorio . "-" . $nc_xml;
            if (move_uploaded_file($doc[5]['tmp_name'], $uploadNc)):
                $this->actualizaDocumentoEmbarques($documentoNc, $id_mes, $valor, $consulta);
            endif;
        endif;
        if (!empty($doc[6]) && isset($doc[6]['name'])):
            $valor = "comPDF = ?";
            $comPDf = $doc[6]['name'];
            $uploadComPdf = "../../../archivos/" . $aleatorio . "-" . $comPDf;
            $documentoComPdf = $aleatorio . "-" . $comPDf;
            if (move_uploaded_file($doc[6]['tmp_name'], $uploadComPdf)):
                $this->actualizaDocumentoEmbarques($documentoComPdf, $id_mes, $valor, $consulta);
            endif;
        endif;
        if (!empty($doc[7]) && isset($doc[7]['name'])):
            $valor = "comXML = ?";
            $comXml = $doc[7]['name'];
            $uploadComXml = "../../../archivos/" . $aleatorio . "-" . $comXml;
            $documentoXML = $aleatorio . "-" . $comXml;
            if (move_uploaded_file($doc[7]['tmp_name'], $uploadComXml)):
                $this->actualizaDocumentoEmbarques($documentoXML, $id_mes, $valor, $consulta);
            endif;
        endif;
    }
    private function actualizaDocumentoEmbarques(string $documento, int $id, string $valor, string $consulta): void
    {
        $sql = "UPDATE op_embarques SET $valor WHERE $consulta";
        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta" . $this->con->error);
        endif;
        $stmt->bind_Param("si", $documento, $id);
        if (!$stmt->execute()):
            throw new Exception("Erro al ejecutar la consulta", $stmt->error);
        endif;
        $stmt->close();
    }
    public function eliminaEmbarque(int $id): bool
    {
        $result = true;
        $sql = "DELETE FROM op_embarques WHERE id = ? ";
        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta" . $this->con->error);
        endif;
        $stmt->bind_Param("i", $id);
        if (!$stmt->execute()):
            $result = false;
            throw new Exception("Erro al ejecutar la consulta", $stmt->error);
        endif;
        $stmt->close();
        return $result;
    }
    public function actualizaEmbarque(array $doc, array $val): void
    {
        $sql = "UPDATE op_embarques SET
            fecha = ?,
            embarque = ?,
            documentocv = ?,
            importef = ?,
            merma = ?,
            nom_transporte = ?,
            producto = ?,
            chofer = ?,
            unidad = ?,
            precio_litro = ?,
            tad = ?
            WHERE id = ?";
        $stmt = $this->con->prepare($sql);
        if (!$stmt):
            throw new Exception("Error al preparar la consulta" . $this->con->error);
        endif;
        $stmt->bind_Param(
            "sssddssssdsi",
            $val[0],
            $val[1],
            $val[2],
            $val[3],
            $val[4],
            $val[5]
            ,
            $val[6],
            $val[7],
            $val[8],
            $val[9],
            $val[10],
            $val[11]
        );
        if (!$stmt->execute()):
            throw new Exception("Erro al ejecutar la consulta", $stmt->error);
        endif;
        $stmt->close();
        // Agrega los formatos en caso de requerrilos
        // toma el valor del id del array
        $id = $val[11];
        $aleatorio = uniqid();
        $valor = "";
        $consulta = "id = ?";
        if (!empty($doc[0]) && isset($doc[0]['name'])):
            $valor = "documento = ?";
            $docu = $doc[0]['name'];
            $documento = "../../../archivos/" . $aleatorio . "-" . $docu;
            $documentoPDF = $aleatorio . "-" . $docu;
            if (move_uploaded_file($doc[0]['tmp_name'], $documento)):
                $this->actualizaDocumentoEmbarques($documentoPDF, $id, $valor, $consulta);
            endif;
        endif;
        if (!empty($doc[1]) && isset($doc[1]['name'])):
            $valor = "pdf = ?";
            $pdf = $doc[1]['name'];
            $uploadPdf = "../../../archivos/" . $aleatorio . "-" . $pdf;
            $documentoPdf = $aleatorio . "-" . $pdf;
            if (move_uploaded_file($doc[1]['tmp_name'], $uploadPdf)):
                $this->actualizaDocumentoEmbarques($documentoPdf, $id, $valor, $consulta);
            endif;
        endif;

        if (!empty($doc[2]) && isset($doc[2]['name'])):
            $valor = "xml = ?";
            $xml = $doc[2]['name'];
            $uploadXml = "../../../archivos/" . $aleatorio . "-" . $xml;
            $documentoXml = $aleatorio . "-" . $xml;
            if (move_uploaded_file($doc[2]['tmp_name'], $uploadXml)):
                $this->actualizaDocumentoEmbarques($documentoXml, $id, $valor, $consulta);
            endif;
        endif;
        if (!empty($doc[3]) && isset($doc[3]['name'])):
            $valor = "comprobante_p = ?";
            $comprobante = $doc[3]['name'];
            $upload_comprobante = "../../../archivos/" . $aleatorio . "-" . $comprobante;
            $documentoComprobante = $aleatorio . "-" . $comprobante;
            if (move_uploaded_file($doc[3]['tmp_name'], $upload_comprobante)):
                $this->actualizaDocumentoEmbarques($documentoComprobante, $id, $valor, $consulta);
            endif;
        endif;
        if (!empty($doc[4]) && isset($doc[4]['name'])):
            $valor = "nc_pdf = ?";
            $nc_pdf = $doc[4]['name'];
            $uploadNc = "../../../archivos/" . $aleatorio . "-" . $nc_pdf;
            $documentoNc = $aleatorio . "-" . $nc_pdf;
            if (move_uploaded_file($doc[4]['tmp_name'], $uploadNc)):
                $this->actualizaDocumentoEmbarques($documentoNc, $id, $valor, $consulta);
            endif;
        endif;

        if (!empty($doc[5]) && isset($doc[5]['name'])):
            $valor = "nc_xml = ?";
            $nc_xml = $doc[5]['name'];
            $uploadNc = "../../../archivos/" . $aleatorio . "-" . $nc_xml;
            $documentoNc = $aleatorio . "-" . $nc_xml;
            if (move_uploaded_file($doc[5]['tmp_name'], $uploadNc)):
                $this->actualizaDocumentoEmbarques($documentoNc, $id, $valor, $consulta);
            endif;
        endif;
        if (!empty($doc[6]) && isset($doc[6]['name'])):
            $valor = "comPDF = ?";
            $comPDf = $doc[6]['name'];
            $uploadComPdf = "../../../archivos/" . $aleatorio . "-" . $comPDf;
            $documentoComPdf = $aleatorio . "-" . $comPDf;
            if (move_uploaded_file($doc[6]['tmp_name'], $uploadComPdf)):
                $this->actualizaDocumentoEmbarques($documentoComPdf, $id, $valor, $consulta);
            endif;
        endif;
        if (!empty($doc[7]) && isset($doc[7]['name'])):
            $valor = "comXML = ?";
            $comXml = $doc[7]['name'];
            $uploadComXml = "../../../archivos/" . $aleatorio . "-" . $comXml;
            $documentoXML = $aleatorio . "-" . $comXml;
            if (move_uploaded_file($doc[7]['tmp_name'], $uploadComXml)):
                $this->actualizaDocumentoEmbarques($documentoXML, $id, $valor, $consulta);
            endif;
        endif;
    }
}