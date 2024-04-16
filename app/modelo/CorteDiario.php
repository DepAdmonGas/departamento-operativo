<?php
require "../bd/DataBase.php";
class CorteDiario{
    private $classConexionBD;
    private  $con;
    public function __construct(){

        $this->classConexionBD = new Database();
        $this->con = $this->classConexionBD->getInstance()->getConnection();
    
    }
    /**--------------------------------------------------------------------------------------------
     * 
     *                                      Funciones Ventas
     * 
     * 
     * ---------------------------------------------------------------------------------------------
     */
    public function nuevoConcentradoVentasOtros(int $idReporte,string $concepto, string $piezas,int $importe): void{
        $sql_reporte = "SELECT idreporte_dia FROM op_ventas_dia_otros WHERE idreporte_dia =? AND concepto =? ";
        $result_reporte = $this->con->prepare($sql_reporte);
        if(!$result_reporte):
            throw new Exception("Error en la preparacion de la consulta" . $this->con->error); 
        endif;
        $result_reporte->bind_param('is',$idReporte,$concepto);
        $result_reporte->execute();
        $result_reporte->bind_result($numero_reporte);
        $result_reporte->fetch();
        $result_reporte->close();
        if($numero_reporte == 0):
            $sql_insert = "INSERT INTO op_ventas_dia_otros(idreporte_dia,concepto,piezas,importe)
            VALUES (?,?,?,?)";
            $stmt = $this->con->prepare($sql_insert);
            if ($stmt) {
                $stmt->bind_param("issi",$idReporte,$concepto,$piezas,$importe);
                if ($stmt->execute()) {
                } else {
                    throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
                }
            }else{
                throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
            }
            $stmt->close();
        endif;
        $this->classConexionBD->disconnect();
    }
    public function getConceptos():array{
        $concepto1= "OTROS";
        $concepto2= "4 ACEITES Y LUBRICANTES";
        $concepto3= "5 AUTOLAVADO";
        $concepto4= "6 ADITIVO PARA DIESEL";
        return $conceptos =[$concepto1,$concepto2,$concepto3,$concepto4];
    }
    public function getDenominaciones():array{
        $denominacion1 = "BILLETE MATUTINO";
        $denominacion2 = "BILLETE VESPERTINO";
        $denominacion3 = "BILLETE NOCTURNO";
        $denominacion4 = "MORRALLA";
        $denominacion5 = "DEPOSITO BANCARIO";
        $denominacion6 = "CHEQUE 1";
        $denominacion7 = "TRANSFERENCIA 1";
        $denominacion8 = "CHEQUE 2";
        $denominacion9 = "TRANSFERENCIA 2";
        $denominaciones = [$denominacion1,$denominacion2,$denominacion3,$denominacion4,$denominacion5
                        ,$denominacion6,$denominacion7,$denominacion8,$denominacion9];
        return $denominaciones;
    }
    public function getTarjetas(int $estacion):array{
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
        switch($estacion):
            case 1:
                return $interlomas = [$ticketcard,$g500,$accord,$efecticard,$efectivale,$sodexo,$valeSodexo,
                                $inburgas,$america,$bbva,$inbursa,$vale,$otros];
                break;
            case 2:
                return $paloSolo = [$ticketcard,$g500,$efecticard,$sodexo,$inburgas,$america,$bbva,$inbursa,$otros];
                break;
            case 3:
                return $sanAgustin = [$ticketcard,$g500,$efecticard,$sodexo,$inburgas,$america,$bbva,$inbursa,$vale,$ultragas,
                $energex,$otros];
                break;
            case 4:
                return $gasomira = [$ticketcard,$g500,$efecticard,$sodexo,$inburgas,$america,$bbva,$inbursa,$otros];
                break;
            case 5:
                return $valle = [$ticketcard,$g500,$efecticard,$sodexo,$inburgas,$america,$bbva,$inbursa,$otros];
                break;
            case 6:
                return $esmegas = [$ticketcard,$g500,$efecticard,$efectivale,$sodexo,$valeSodexo,$inburgas,$america,$bbva,
                $inbursa,$otros];
                break;
            case 7:
                return $xochimilco = [$ticketcard,$g500,$accord,$efecticard,$efectivale,$sodexo,$inburgas,$america,$bbva,
                $inbursa,$otros];
                break;
            case 14:
                return $bosqueReal = [$ticketcard,$g500,$efecticard,$sodexo,$inburgas,$america,$bbva,$otros]; 
                break;
        endswitch;
    }
    public function getNumero(int $estacion):array{
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
        switch($estacion):
            case 1:
                return $numInter = [$num1,$num1_1,$numA,$num2,$numB,$num3,$numC,$num4,$num5,$num6,$numE,$num7,$num10];
                break;
            case 2:
                return $numPalo = [$num1,$num1_1,$num2,$num3,$num4,$num5,$num6,$numE,$num10];
                break;
            case 3:
                return $numAgus = [$num1,$num1_1,$num2,$num3,$num4,$num5,$num6,$numE,$num7,$num8,$num9,$num10];
                break;
            case 4:
                return $numGaso = [$num1,$num1_1,$num2,$num3,$num4,$num5,$num6,$numE,$num10]; 
                break;
            case 5:
                return $numValle = [$num1,$num1_1,$num2,$num3,$num4,$num5,$num6,$numE,$num10];
                break;
            case 6:
                return $numEsme = [$num1,$num1_1,$num2,$numB,$num3,$numC,$num4,$num5,$num6,$numE,$num10];
                break;
            case 7:
                return $numXochi = [$num1,$num1_1,$numA,$num2,$numB,$num3,$num4,$num5,$num6,$numE,$num10];
                break;
            case 14:
                return $numBosque = [$num1,$num1_1,$num2,$num3,$num4,$num5,$num6,$num10];
                break;
        endswitch;
    }
    public function nuevoRegistroProsegur(int $idReporte,string $denominacion,string $recibo,int $importe):void{
        $sql_reporte = "SELECT idreporte_dia FROM op_prosegur WHERE idreporte_dia = ? AND denominacion = ? ";
        $result_reporte = $this->con->prepare($sql_reporte);
        if(!$result_reporte):
            throw new Exception("Error en la preparacion de la consulta" . $this->con->error); 
        endif;
        $result_reporte->bind_param('is',$idReporte,$denominacion);
        $result_reporte->execute();
        $result_reporte->bind_result($numero_reporte);
        $result_reporte->fetch();
        $result_reporte->close();
        if($numero_reporte == 0){
            $sql_insert = "INSERT INTO op_prosegur (
            idreporte_dia,
            denominacion,
            recibo,
            importe 
            )
            VALUES(?,?,?,?)";
            $stmt = $this->con->prepare($sql_insert);
            if ($stmt) {
                $stmt->bind_param("issi",$idReporte,$denominacion,$recibo,$importe);
                if ($stmt->execute()) {
                } else {
                    throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
                }
            }else{
                throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
            }
                $stmt->close();
        }
        $this->classConexionBD->disconnect();
    }
    public function editarProsegur($tipo,$valor,$idProsegur):bool{
        $result = false;
        $value = "";
        $bind ="si";
        if($tipo == "recibo"){
            $value = "recibo=?";
        }else{
            $value = "importe=?";
            $bind ="di";
        }
        $sql_insert = "UPDATE op_prosegur SET $value WHERE id=? ";
        $stmt = $this->con->prepare($sql_insert);
        if ($stmt) {
            $stmt->bind_param($bind,$valor,$idProsegur);
            if ($stmt->execute()) {
                $result = true;
            } else {
                throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
            }
            $stmt->close();
        }else{
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        }
        $this->classConexionBD->disconnect();
        return $result;
    }
    public function nuevoRegistroTarjetasBancarias(int $idReporte,string $num, string $concepto,int $baucher):void{
        $sql_reporte = "SELECT idreporte_dia FROM op_tarjetas_c_b WHERE idreporte_dia =? AND concepto = ? ";
        $result_reporte = $this->con->prepare($sql_reporte);
        if(!$result_reporte):
            throw new Exception("Error en la preparacion de la consulta" . $this->con->error); 
        endif;
        $result_reporte->bind_param('is',$idReporte,$concepto);
        $result_reporte->execute();
        $result_reporte->bind_result($numero_reporte);
        $result_reporte->fetch();
        $result_reporte->close();

        if($numero_reporte == 0){
            $sql_insert = "INSERT INTO op_tarjetas_c_b (
            idreporte_dia,
            num,
            concepto,
            baucher 
            )
            VALUES (?,?,?,?)";
            $stmt = $this->con->prepare($sql_insert);
            if ($stmt) {
                $stmt->bind_param("issi",$idReporte,$num,$concepto,$baucher);
                if ($stmt->execute()) {
                } else {
                    throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
                }
                $stmt->close();
            }else{
                throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
            }
        }
        $this->classConexionBD->disconnect();
    }
    public function monederosBancos(int $idReporte,string $empresa):void{    
        $sql_listacierre = "SELECT * FROM op_cierre_lote WHERE idreporte_dia = '".$idReporte."' AND empresa = '".$empresa."' ";
        $result_listacierre = mysqli_query($this->con, $sql_listacierre);
        while($row_listacierre = mysqli_fetch_array($result_listacierre, MYSQLI_ASSOC)):
            $TotalImporte = $TotalImporte + $row_listacierre['importe'];
        endwhile;
        $sql_insert = "UPDATE op_tarjetas_c_b SET baucher=? WHERE concepto=? AND idreporte_dia =?";
        $stmt = $this->con->prepare($sql_insert);
        if ($stmt) {
            $stmt->bind_param("dsi",$TotalImporte,$empresa,$idReporte);
            if ($stmt->execute()) {
            } else {
                throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
            }
            $stmt->close();
        }else{
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        }
        $this->classConexionBD->disconnect();
    }
    public function editarTarjetasCB(float $baucher,int $idTarjeta):bool{
        $result = false;
        $sql_insert = "UPDATE op_tarjetas_c_b SET baucher=? WHERE id=? ";
        $stmt = $this->con->prepare($sql_insert);
        if ($stmt) {
            $stmt->bind_param("di",$baucher,$idTarjeta);
            if ($stmt->execute()) {
                $result = true;
            } else {
                throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
            }
            $stmt->close();
        }else{
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        }
        $this->classConexionBD->disconnect();
        return $result;
    }
    public function nuevoRegistroControlGas(int $idReporte,string $concepto,float $pago,float $consumo):void{
        $sql_reporte = "SELECT idreporte_dia FROM op_clientes_controlgas WHERE idreporte_dia = ? AND concepto = ? ";
        $result_reporte = $this->con->prepare($sql_reporte);
        if(!$result_reporte):
            throw new Exception("Error en la preparacion de la consulta" . $this->con->error); 
        endif;
        $result_reporte->bind_param('is',$idReporte,$concepto);
        $result_reporte->execute();
        $result_reporte->bind_result($numero_reporte);
        $result_reporte->fetch();
        $result_reporte->close();
     
        if($numero_reporte == 0){
            $sql_insert = "INSERT INTO op_clientes_controlgas (
            idreporte_dia,
            concepto,
            pago,
            consumo 
            )
            VALUES (?,?,?,?)";
            $stmt = $this->con->prepare($sql_insert);
            if ($stmt) {
                $stmt->bind_param("isdd",$idReporte,$concepto,$pago,$consumo);
                if ($stmt->execute()) {
                } else {
                    throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
                }
                $stmt->close();
            }else{
                throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
            }
        }
        $this->classConexionBD->disconnect();
    }
    public function editarControlGas($tipo,$valor,$idControl):bool{
        $result = false;
        $value = "";
        if($tipo == "pago"){
            $value = "pago=?";
        }else{
            $value = "consumo=?";
        }
        $sql_insert = "UPDATE op_clientes_controlgas SET $value WHERE id=? ";
        $stmt = $this->con->prepare($sql_insert);
        if ($stmt) {
            $stmt->bind_param("di",$valor,$idControl);
            if ($stmt->execute()) {
                $result = true;
            } else {
                throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
            }
            $stmt->close();
        }else{
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        }
        $this->classConexionBD->disconnect();
        return $result;
    }
    public function pagoConcepto():array{
        $concepto1 = "EFECTIVO";
        $concepto2 = "CHEQUE";
        $concepto3 = "TRANSFERENCIA (SPEI)";
        $concepto4 = "TARJETA DE CREDITO";
        $concepto5 = "DEPOSITO BANCARIO";
        return $conceptos = [$concepto1,$concepto2,$concepto3,$concepto4,$concepto5];
    }
    public function nuevoRegistroPagoClientes(int $idReporte,string $concepto,float $importe,string $nota):void{
        $sql_reporte = "SELECT idreporte_dia FROM op_pago_clientes WHERE idreporte_dia = ? AND concepto = ? ";
        $result_reporte = $this->con->prepare($sql_reporte);
        if(!$result_reporte):
            throw new Exception("Error en la preparacion de la consulta" . $this->con->error); 
        endif;
        $result_reporte->bind_param('is',$idReporte,$concepto);
        $result_reporte->execute();
        $result_reporte->bind_result($numero_reporte);
        $result_reporte->fetch();
        $result_reporte->close();
     
        if($numero_reporte == 0){
            $sql_insert = "INSERT INTO op_pago_clientes (
            idreporte_dia,
            concepto,
            importe,
            nota 
            )
            VALUES (?,?,?,?)";
            $stmt = $this->con->prepare($sql_insert);
            if ($stmt) {
                $stmt->bind_param("isds",$idReporte,$concepto,$importe,$nota);
                if ($stmt->execute()) {
                } else {
                    throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
                }
                $stmt->close();
            }else{
                throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
            }
        }
        $this->classConexionBD->disconnect();
    }
    public function editarPagoClientes($tipo,$valor,$idPagoCliente):bool{
        $result = false;
        $bind = "di";
        $value = "";
        if($tipo == "importe"){
            $value ="importe=?";
        }else{
            $value ="nota=?";
            $bind = "si";
        }
        $sql_insert = "UPDATE op_pago_clientes SET $value WHERE id=? ";
        $stmt = $this->con->prepare($sql_insert);
        if ($stmt) {
            $stmt->bind_param($bind,$valor,$idPagoCliente);
            if ($stmt->execute()) {
                $result = true;
            } else {
                throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
            }
            $stmt->close();
        }else{
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        }
        $this->classConexionBD->disconnect();
        return $result;
    }
    public function nuevoRegistroVentas(int $idReporte):void{

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
        if ($stmt) {
            $stmt->bind_param("isdddd",$idReporte,$producto,$litros,$jarras,$precio,$ieps);
            if ($stmt->execute()) {
            } else {
                throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
            }
        }else{
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        }
        $this->classConexionBD->disconnect();
    }
    public function editarVentas($tipo,$valor,$idVentas):bool{
        $result = false;
        $valida = "";
        $var = "";
        $sql = "";
        switch($tipo):
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
        if($valida=="dia"):
            $sql = "UPDATE op_ventas_dia SET $var WHERE id=? ";
        elseif($valida=="otros"):
            $sql = "UPDATE op_ventas_dia_otros SET $var WHERE id=? ";
        endif;
        $stmt = $this->con->prepare($sql);
        if ($stmt):
            $stmt->bind_param("di",$valor,$idVentas);
            if ($stmt->execute()):
                $result = true;
            else:
                throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
            endif;
        else:
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        endif;
        $this->classConexionBD->disconnect();
        return $result;
    }
    public function editarVentasProducto($valor,$idVentas,$ieps){
        $valor;
        $result = false;
        $sql = "UPDATE op_ventas_dia SET producto=?, ieps =? WHERE id=? ";
        $stmt = $this->con->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("sdi",$valor,$ieps,$idVentas);
            if ($stmt->execute()) {
                $result = true;
            } else {
                throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
            }
        }else{
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        }
        $this->classConexionBD->disconnect();
        return $result;
    }
    public function editarVentasPiezas($idReporte):bool{
        $result = false;
        $sql_listaaceites = "SELECT cantidad,precio_unitario FROM op_aceites_lubricantes WHERE idreporte_dia =?";
        $result_reporte = $this->con->prepare($sql_listaaceites);
        if(!$result_reporte):
            throw new Exception("Error en la preparacion de la consulta" . $this->con->error); 
        endif;
        $result_reporte->bind_param('i',$idReporte);
        $result_reporte->execute();
        $result_reporte->bind_result($cantidad,$precio);
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
        if ($stmt) {
            $stmt->bind_param("sdis",$totalCantidad,$totalPrecio,$idReporte,$concepto);
            if ($stmt->execute()) {
                $result = true;
            } else {
                throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
            }
            $stmt->close();
        }else{
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        }
        $this->classConexionBD->disconnect();
        return $result;
    }
    public function editarObservaciones(int $idReporte,string $observaciones):bool{
        $sql_reporte = "SELECT idreporte_dia FROM op_observaciones WHERE idreporte_dia = '".$idReporte."' ";
        $result_reporte = mysqli_query($this->con, $sql_reporte);
        $numero_reporte = mysqli_num_rows($result_reporte);
        $sql="";
        if($numero_reporte == 0){
            $sql = "INSERT INTO op_observaciones (observaciones,idreporte_dia) VALUES(?,?) ";
        }else{
            $sql = "UPDATE op_observaciones SET observaciones=? WHERE idreporte_dia =? " ;
        }
        $stmt = $this->con->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("si",$observaciones,$idReporte);
            if ($stmt->execute()) {
                $result = true;
            } else {
                throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
            }
            $stmt->close();
        }else{
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        }
        $this->classConexionBD->disconnect();
        return $result;

    }
    public function idReporte(int $sessionIdEstacion,int $year,int $mes):int{
        // Obtiene el año 
        $sql_year = "SELECT id FROM op_corte_year WHERE id_estacion = ? AND year = ?";
        $stmt_year = $this->con->prepare($sql_year);
        if (!$stmt_year) {
            // Manejo de error
            throw new Exception("Error en la preparación de la consulta: " . $mysqli->error);
        }
        $stmt_year->bind_param('ii', $sessionIdEstacion, $year);
        $stmt_year->execute();
        $stmt_year->bind_result($idyear);
        $stmt_year->fetch();
        $stmt_year->close();
        // Obtiene el mes 
        $sql_mes = "SELECT id FROM op_corte_mes WHERE id_year = ? AND mes = ?";
        $stmt_mes = $this->con->prepare($sql_mes);
        if (!$stmt_mes) {
            // Manejo de error
            throw new Exception("Error en la preparación de la consulta: " . $mysqli->error);
        }
        $stmt_mes->bind_param('ii', $idyear, $mes);
        $stmt_mes->execute();
        $stmt_mes->bind_result($idmes);
        $stmt_mes->fetch();
        $stmt_mes->close();
        return $idmes;
    }
    public function nuevoRegistroAceites(int $idReporte,int $IdMes,int $sessionIdEstacion):void{
        $sql_listaaceite = "SELECT
        op_aceites.id_aceite,
        op_aceites.concepto,
        op_aceites.precio
        FROM op_inventario_aceites
        INNER JOIN op_aceites
        ON op_inventario_aceites.id_aceite = op_aceites.id WHERE op_inventario_aceites.id_estacion =? AND id_mes =? ";
    
        $result_listaAceite = $this->con->prepare($sql_listaaceite);
        if (!$result_listaAceite) {
            // Manejo de error
            throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
        }
        $result_listaAceite->bind_param('ii', $sessionIdEstacion, $IdMes);
        $result_listaAceite->execute();
        $result_listaAceite->bind_result($noAceite,$concepto,$precio);
        $result_listaAceite->fetch();
        $result_listaAceite->close();
        $this->validaAceites($idReporte,$noAceite,$concepto,$precio);
    }
    public function validaAceites(int $idReporte,int $noAceite,string $concepto,float $precio): void{
        $sql_reporte = "SELECT idreporte_dia FROM op_aceites_lubricantes WHERE idreporte_dia = ? AND concepto = ? ";
        $result_reporte = $this->con->prepare($sql_reporte);
        if (!$result_reporte) {
            // Manejo de error
            throw new Exception("Error en la preparación de la consulta: " . $mysqli->error);
        }
        $result_reporte->bind_param('is', $idReporte, $concepto);
        $result_reporte->execute();
        $result_reporte->bind_result($numero_reporte);
        $result_reporte->fetch();
        $result_reporte->close();
        if($numero_reporte == 0){
            $cantidad = 0;
            $sql_insert = "INSERT INTO op_aceites_lubricantes(idreporte_dia,id_aceite,concepto,cantidad,precio_unitario)
                            VALUES (?,?,?,?,?)";
        $stmt = $this->con->prepare($sql_insert);
        if ($stmt) {
            $stmt->bind_param("iisid",$idReporte,$noAceite,$concepto,$cantidad,$precio);
            if ($stmt->execute()) {
                $result = true;
            } else {
                throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
            }
            $stmt->close();
        }else{
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        }
        }
        $this->classConexionBD->disconnect();
    }
    public function editarAceitesLubricantes($tipo,$valor,$idAceite):bool{
        $result = false;
        $sql_insert = "";
        $value ="";
        $bind="";
        if($tipo == "cantidad"):
            $value ="cantidad=?";
            $bind = "ii";
        else:
            $value ="precio_unitario=?";
            $bind = "di";
        endif;
        $sql_insert = "UPDATE op_aceites_lubricantes SET $value WHERE id=? ";
        $stmt = $this->con->prepare($sql_insert);
        if ($stmt) {
            $stmt->bind_param($bind,$valor,$idAceite);
            if ($stmt->execute()) {
                $result = true;
            } else {
                throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
            }
            $stmt->close();
        }else{
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        }
        $this->classConexionBD->disconnect();
        return $result;
    }
    public function agregarFirma($idReporte,$img,$sessionIdUsuario,$nombreEstacion):bool{
        $result = false;
        $detalle = 'Elaboró';
        $sql_dia = "SELECT fecha FROM op_corte_dia WHERE id =? ";
        $result_dia = $this->con->prepare($sql_dia);
        if (!$result_dia) {
            // Manejo de error
            throw new Exception("Error en la preparación de la consulta: " . $mysqli->error);
        }
        $result_dia->bind_param('i', $idReporte);
        $result_dia->execute();
        $result_dia->bind_result($dia);
        $result_dia->fetch();
        $result_dia->close();
        // mover imagen al servidor 
        $img = str_replace('data:image/png;base64,', '', $img);
        $fileData = base64_decode($img);
        $fileName = uniqid().'.png';
        $hoy = date("Y-m-d H:i:s");
        $num19 = 19;
        $num2 = 2;
        $superviso = "Superviso";
        $vitstoB = "VoBo";
        $corte = 1;
        if(file_put_contents('../../imgs/firma/'.$fileName, $fileData)):
            $sql_insert = "INSERT INTO op_corte_dia_firmas (
                id_reportedia,
                id_usuario,
                firma,
                detalle
                )
                VALUES (?,?,?,?)";
                $stmt = $this->con->prepare($sql_insert);
                if ($stmt) {
                    $stmt->bind_param("iiss",$idReporte,$sessionIdUsuario,$fileName,$detalle);
                    if ($stmt->execute()) {
                        $this->firmar($idReporte,$num19,$superviso,$hoy);
                        $this->firmar($idReporte,$num2,$vitstoB,$hoy);
                        $sql = "UPDATE op_corte_dia SET ventas = ?, tpv = ?, monedero = ? WHERE id = ? ";
                        $consulta = $this->con->prepare($sql);
                        $consulta->bind_param('iiii',$corte,$corte,$corte, $idReporte);
                        $consulta->execute();
                        $consulta->close();
                        $token = $this->toquenUser($num19);
                        $detalle = 'Se finalizo el corte del día '.$dia.' de la estación '.$nombreEstacion;
                        $result = true;
                        $this->sendNotification($token,$detalle);
                    } else {
                        throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
                    }
                    $stmt->close();
                }else{
                    throw new Exception("Error al preparar la consulta SQL: " . self::$con->error);
                }
            endif;
        $this->classConexionBD->disconnect();
        return $result;
    }
    public function firmar($idReporte,$idUsuario,$tipoFirma,$Fecha):void{
        $NuevaFecha = "";
        $firma = "Firma: ".bin2hex(random_bytes(64)).".".uniqid();

        $sql_firma = "SELECT * FROM op_corte_dia_firmas WHERE id_reportedia = ? AND detalle = ? ORDER BY id DESC LIMIT 1 ";
        $result_firma = $this->con->prepare($sql_firma);
        if (!$result_firma):
            // Manejo de error
            throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
        endif;
        $result_firma->bind_param('is', $idReporte,$tipoFirma);
        $result_firma->execute();
        $result_firma->store_result();
        
        if ($result_firma->num_rows === 0):

            if($tipoFirma == 'Superviso'):
                $NuevaFecha = strtotime ('+1 hour' , strtotime($Fecha)); 
                $NuevaFecha = date ('Y-m-d H:i:s' , $NuevaFecha); 
            elseif($tipoFirma == 'VoBo'):
                $Fecha1 = strtotime ('+2 hour' , strtotime($Fecha));
                $Fecha1 = date ('Y-m-d H:i:s' , $Fecha1); 
                $NuevaFecha = strtotime ('+22 minute' , strtotime($Fecha1));
                $NuevaFecha = date ('Y-m-d H:i:s' , $NuevaFecha); 
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
            $sql->bind_param('iisss', $idReporte,$idUsuario,$NuevaFecha,$firma,$tipoFirma);
            $sql->execute();
            $sql->close();
        endif;
    }
    public function sendNotification($token,$detalle):void{
        $url ="https://fcm.googleapis.com/fcm/send";

        $fields=array(
            "to"=>$token,
            "notification"=>array(
                "body"=> $detalle,
                "title"=>"Portal AdmonGas",
                "icon"=>"",
                "click_action"=>""
            )
        );
        $headers=array(
            'Authorization: key=AAAAccs8Ry4:APA91bFc3rlPHpHHyABA01dZPc4J9ZChulB2nmBZp0VW5ODR-uDq2Lnz0YvlpROjZrFgIl2UBFHqOPhPM8c5ho-8IR6XuFpwv8_WT_Y-av9vXav4_6eGsZrUdtrMl9GwDWDNZee0Ppli',
            'Content-Type:application/json'
        );
        $ch=curl_init();
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Disabling SSL Certificate support temporarily
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result=curl_exec($ch);
        curl_close($ch);
    }
    public function toquenUser(int $id):string{
        $herramienta = "token-web";
        $sql_firma = "SELECT token FROM tb_usuarios_token WHERE id_usuario = ? AND herramienta = ? ORDER BY id DESC LIMIT 1 ";
        $result_firma = $this->con->prepare($sql_firma);
        if (!$result_firma):
            // Manejo de error
            throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
        endif;
        $result_firma->bind_param('is', $id,$herramienta);
        $result_firma->execute();
        $result_firma->bind_result($token);
        $result_firma->fetch();
        $result_firma->close();
        return $token;
    }
    public function agregarDocumento(int $idReporte,string $nombreDocumento,string $PDFNombre):bool{
        $result = false;
        $sql_insert = "INSERT INTO op_corte_dia_archivo (
            id_reportedia,
            detalle,
            documento
            )
            VALUES (?,?,?)";
        $stmt = $this->con->prepare($sql_insert);
        if ($stmt) {
            $stmt->bind_param("iss",$idReporte,$nombreDocumento,$PDFNombre);
            if ($stmt->execute()) {
                $result = true;
            } else {
                throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
            }
            $stmt->close();
        }else{
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        }
        $this->classConexionBD->disconnect();
        return $result;
    }
    public function eliminarDocumentoCorte(int $id):bool{
        $result = false;
        $sql = "DELETE FROM op_corte_dia_archivo WHERE id=? ";
        $stmt = $this->con->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i",$id);
            if ($stmt->execute()) {
                $result = true;
            } else {
                throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
            }
            $stmt->close();
        }else{
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        }
        $this->classConexionBD->disconnect();
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


    public function agregarCliente(int $sessionIdEstacion,string $cuenta,string $cliente,string $tipo,string $rfc) : bool{
        $result = false;
        $aleatorio = uniqid();
        $Doc1  =   $_FILES['CartaCredito_file']['name'];
        $Folder1 = "../../archivos/".$aleatorio."-".$Doc1;
        $Nombre1 = $aleatorio."-".$Doc1;

        $Doc2  =   $_FILES['ActaConstitutiva_file']['name'];
        $Folder2 = "../../archivos/".$aleatorio."-".$Doc2;
        $Nombre2 = $aleatorio."-".$Doc2;

        $Doc3  =   $_FILES['ComprobanteDom_file']['name'];
        $Folder3 = "../../archivos/".$aleatorio."-".$Doc3;
        $Nombre3 = $aleatorio."-".$Doc3;

        $Doc4  =   $_FILES['Identificacion_file']['name'];
        $Folder4 = "../../archivos/".$aleatorio."-".$Doc4;
        $Nombre4 = $aleatorio."-".$Doc4;

        $sql_insert = "INSERT INTO op_cliente (
            id_estacion,
            cuenta,
            cliente,
            tipo,
            rfc,
            doc_cc,
            doc_ac,
            doc_cd,
            doc_io,
            estado
            )
            VALUES(?,?,?,?,?,?,?,?,?,?)";
        $stmt = $this->con->prepare($sql_insert);
        if($stmt){
            $stmt->bind_param("issssssssi",$sessionIdEstacion,$cuenta,$cliente,$tipo,$rfc,$Nombre1,$Nombre2,$Nombre3,$Nombre4,1);
            if($stmt->execute()){
                if(move_uploaded_file($_FILES['CartaCredito_file']['tmp_name'], $Folder1)) {}
                if(move_uploaded_file($_FILES['ActaConstitutiva_file']['tmp_name'], $Folder2)) {}
                if(move_uploaded_file($_FILES['ComprobanteDom_file']['tmp_name'], $Folder3)) {}
                if(move_uploaded_file($_FILES['Identificacion_file']['tmp_name'], $Folder4)) {}
                $result = true;
            }else{
                throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
            }
            $stmt->close();
        }else{
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        }
        $this->classConexionBD->disconnect();
        return $result;
    }
    public function agregarComentarioEmbarques(int $sessionIdUsuario,int $id, string $comentario): bool{
        $result = false;
        $sql_insert = "INSERT INTO op_embarques_comentario (
            id_embarques,
            id_usuario,
            comentario
            )
            VALUES 
            (
            '".$id."',
            '".$sessionIdUsuario."',
            '".$comentario."'
            )";
        $stmt = $this->con->prepare($sql_insert);
        if($stmt->execute()){
            $result = true;
        }else{
            echo "Error en la consulta SQL: " .$this->con->error;
        }
        $this->classConexionBD->disconnect();
        return $result;
    }
    public function agregarComentarioSolicitudAditivo(int $sessionIdUsuario,int $idReporte, string $comentario): bool{
        $result = false;
        $sql_insert = "INSERT INTO op_solicitud_aditivo_comentario (
            id_reporte,
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
            echo "Error en la consulta SQL: " .$this->con->error;
        }
        $this->classConexionBD->disconnect();
        return $result;
    }
    public function agregarConsumos(int $idReporte, int $cliente, float $total, string $tipo): bool {
        $result = false;
        
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
    
        // Verificar si la preparación de la consulta SQL fue exitosa
        if ($stmt) {
            $pago = ""; 
            $comprobante = ""; 
            $stmt->bind_param("iifsss", $idReporte, $cliente, $total, $tipo, $pago, $comprobante);
            if ($stmt->execute()) {
                $result = true;
            } else {
                // Manejo de errores más adecuado
                throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
            }
            $stmt->close();
        } else {
            // Manejo de errores más adecuado
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        }
        $this->classConexionBD->disconnect();
        return $result;
    }
    public function agregarControlDespacho(): bool{
        $aleatorio = uniqid();
        $File  =   $_FILES['Documento_file']['name'];
        $upload_folder = "../../../archivos/".$aleatorio."-".$File;
        $PDFNombre = $aleatorio."-".$File;

        if(move_uploaded_file($_FILES['Documento_file']['tmp_name'], $upload_folder)) {

            $sql_insert = "INSERT INTO op_control_despacho (id_mes,documento) VALUES (?,?)";
            $stmt = $this->con->prepare($sql_insert);
            if ($stmt) {
                $stmt->bind_param("iifsss", $idReporte, $cliente, $total, $tipo, $pago, $comprobante);
                if ($stmt->execute()) {
                        $result = true;
                    } else {
                        throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
                    }
                    $stmt->close();
                } else {
                    throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
            }
            $this->classConexionBD->disconnect();
            return $result;
        }    
    }
    public function agregarDocumentoAceite(): bool{
        $result  = false;
        $aleatorio = uniqid();
        $Ficha  =   $_FILES['Ficha_file']['name'];
        $Imagen  =   $_FILES['Imagen_file']['name'];
        $Factura  =   $_FILES['Factura_file']['name'];
        
        $year = $_POST['year'];
        $mes = $_POST['mes'];
        $mes_formateado = sprintf("%02d", $mes);
        $fecha_actual = date("Y-m-d"); 
        
        //---------- FECHAS FACTURA----------
        $fecha_02 = date("$year-$mes_formateado-02");
        $fecha_03 = date("$year-$mes_formateado-03");
        $fecha_04 = date("$year-$mes_formateado-04");
        
        if($fecha_actual <= $fecha_02){
        $puntaje_facturas = 3;
        
        }else if($fecha_actual > $fecha_02 && $fecha_actual <= $fecha_03){
        $puntaje_facturas = 2;
        
        }else if($fecha_actual > $fecha_03 && $fecha_actual <= $fecha_04){
        $puntaje_facturas = 1;  
        
        }else{
        $puntaje_facturas = 0;   
        
        }
        //---------- FECHAS FICHA----------
        $fecha_10 = date("$year-$mes_formateado-10");
        $fecha_20 = date("$year-$mes_formateado-20");
        
        if($fecha_actual <= $fecha_02){
        $puntaje_fichas = 3;
            
        }else if($fecha_actual > $fecha_02 && $fecha_actual <= $fecha_10){
        $puntaje_fichas = 2;
            
        }else if($fecha_actual > $fecha_10 && $fecha_actual <= $fecha_20){
        $puntaje_fichas = 1;  
            
        }else{
        $puntaje_fichas = 0;   
            
        }
        //---------- FICHA DE DEPOSITO FALTANTE ----------
        if ($Ficha != "") {
        $upload_Ficha = "../../archivos/".$aleatorio."-".$Ficha;
        $DocumentoFicha = $aleatorio."-".$Ficha;
        move_uploaded_file($_FILES['Ficha_file']['tmp_name'], $upload_Ficha);
        $fecha_ficha = $fecha_actual;
        $puntaje_ficha = $puntaje_fichas;
        
        }else{
        $upload_Ficha = "";
        $DocumentoFicha = "";
        $fecha_ficha = "";
        $puntaje_ficha = "";
        
        }    
        
        //---------- IMAGEN DE BODEGA ----------
        if ($Imagen != "") {
        $upload_Imagen = "../../../archivos/".$aleatorio."-".$Imagen;
        $DocumentoImagen = $aleatorio."-".$Imagen;
        move_uploaded_file($_FILES['Imagen_file']['tmp_name'], $upload_Imagen);
        
        }else{
        $upload_Imagen = "";
        $DocumentoImagen = "";
        
        }
        
        //---------- FACTURA ----------
        
        if ($Factura != "") {
        $upload_Factura = "../../archivos/".$aleatorio."-".$Factura;
        $DocumentoFactura = $aleatorio."-".$Factura;
        move_uploaded_file($_FILES['Factura_file']['tmp_name'], $upload_Factura);
        $fecha_factura = $fecha_actual;
        $puntaje_factura = $puntaje_facturas;
        
        }else{
        $upload_Factura = "";
        $DocumentoFactura = "";
        $fecha_factura = "";
        $puntaje_factura = "";
        
        }
        
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
            VALUES(?,?,?,?,?,?,?,?,?)
            (
            '".$_POST['IdReporte']."',
            '".$fecha_del_dia."',
            '".$DocumentoFicha."',
            '".$fecha_ficha."',
            '".$puntaje_ficha."',
            '".$DocumentoImagen."',
            '".$DocumentoFactura."',
            '".$fecha_factura."',
            '".$puntaje_factura."'
            )";
        $stmt = $this->con->prepare($sql_insert);
        if ($stmt) {
            $stmt->bind_param("i",);
            if ($stmt->execute()) {
                $result = true;
            } else {
                throw new Exception("Error al ejecutar la consulta SQL: " . $stmt->error);
            }
            $stmt->close();
        }else{
            throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
        }
        $this->classConexionBD->disconnect();
        return $result;
    }
}   

?>