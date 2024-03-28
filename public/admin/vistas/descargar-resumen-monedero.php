<?php
require ('../../../app/help.php');

  function TarjetasCB($idReporte,$concepto,$con){
    $sql_cb = "SELECT * FROM op_tarjetas_c_b WHERE idreporte_dia = '".$idReporte."' AND concepto = '".$concepto."' LIMIT 1 ";
    $result_cb = mysqli_query($con, $sql_cb);
    while($row_cb = mysqli_fetch_array($result_cb, MYSQLI_ASSOC)){
    $baucher = $row_cb['baucher'];
    }

    return $baucher;
   }

$GET_idEstacion = $_GET['idEstacion'];
$GET_year = $_GET['year'];
$GET_mes = $_GET['mes'];

header('Content-Encoding: UTF-8');
header('Content-Type:text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="ResumenMonedero.csv"');

$sql_listaestacion = "SELECT razonsocial FROM tb_estaciones WHERE id = '".$GET_idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['razonsocial'];
}

$salida = fopen('php://output', 'w');

$Head1 = array(
$estacion.' '.nombremes($GET_mes).' del '.$GET_year
);

$array1 = array_map("utf8_decode", $Head1);
fputcsv($salida, $array1);

$Head2 = array(
'',
'', 
'',
'TARJETAS BANCARIAS',
'',
'',
'',
'',
'',
'TARJETAS',
'',
'',
'',
'',
'',
'',
'VALES',
'',
'',
'',
'Cartera de Clientes ATIO',
'',
'',
'');

$array2 = array_map("utf8_decode", $Head2);
fputcsv($salida, $array2);

$Head3 = array(
'Fecha',
'BANCOMER', 
'AMEX',
'INBURSA',
'TOTAL',
'TICKETCARD',
'G500 FLETT',
'EFECTICARD',
'INBURGAS',
'SODEXO',
'ULTRAGAS',
'ENERGEX',
'TOTAL',
'VALE ACCORD',
'VALE EFECTIVALE',
'VALE SODEXO',
'SI VALE',
'TOTAL',
'Pagos',
'Consumos',
'Pagos',
'Consumos',
'TOTAL',
'TOTAL');

$array3 = array_map("utf8_decode", $Head3);
fputcsv($salida, $array3);

$pagoC = 0;
$consumoC = 0;
$pagoD = 0;
$consumoD = 0;

$totalPago = 0;
$totalConsumo = 0;
$Tobancomer = 0;
$Toamex = 0;
$Toinburgas = 0;
$Toinbursa = 0;
$TototalTB = 0;

$Toticketcard = 0;
$Tog500fleet = 0;
$Toefecticard = 0;
$Tosodexo = 0;
$TototalTarjetas = 0;

$TopagoC = 0;
$ToconsumoC = 0;
$TopagoD = 0;
$ToconsumoD = 0;
$TototalPago = 0;
$TototalConsumo  = 0;
$GTVales = 0;

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
          WHERE op_corte_year.id_estacion = '".$GET_idEstacion."' AND 
          op_corte_year.year = '".$GET_year."' AND 
          op_corte_mes.mes = '".$GET_mes."'";
          $result_listadia = mysqli_query($con, $sql_listadia);
          $numero_listadia = mysqli_num_rows($result_listadia);

          while($row_listadia = mysqli_fetch_array($result_listadia, MYSQLI_ASSOC)){
          $idDias = $row_listadia['idDia'];
          $fecha = $row_listadia['fecha'];

    $bancomer = TarjetasCB($idDias,"BBVA BANCOMER SA",$con);
    $amex = TarjetasCB($idDias,"AMERICAN EXPRESS",$con);
    $inburgas = TarjetasCB($idDias,"INBURGAS",$con);
    $inbursa = TarjetasCB($idDias,"INBURSA",$con);

    $totalTB = $bancomer + $amex + $inbursa;

    $ticketcard = TarjetasCB($idDias,"TICKETCARD",$con);
    $g500fleet = TarjetasCB($idDias,"G500 FLETT",$con);
    $efecticard = TarjetasCB($idDias,"EFECTICARD",$con);
    $sodexo = TarjetasCB($idDias,"SODEXO",$con);
    $ultragas = TarjetasCB($idDias,"ULTRAGAS",$con);
    $energex = TarjetasCB($idDias,"ENERGEX",$con);

    $totalTarjetas = $ticketcard + $g500fleet + $efecticard + $inburgas + $sodexo + $ultragas + $energex;

    $valaccord = TarjetasCB($idDias,"VALE ACCORD",$con);
    $valefectivale = TarjetasCB($idDias,"VALE EFECTIVALE",$con);
    $valsodexo = TarjetasCB($idDias,"VALE SODEXO",$con);
    $valvale = TarjetasCB($idDias,"SI VALE",$con);

    $totalVales = $valaccord + $valefectivale + $valsodexo + $valvale;

    $sql_CCPC = "SELECT * FROM op_clientes_controlgas WHERE idreporte_dia = '".$idDias."' AND concepto = 'CRÉDITO (ANEXO)' LIMIT 1 ";
    $result_CCPC = mysqli_query($con, $sql_CCPC);
    $numero_CCPC = mysqli_num_rows($result_CCPC);
    if ($numero_CCPC == 1) {
    while($row_CCPC = mysqli_fetch_array($result_CCPC, MYSQLI_ASSOC)){
    $pagoC = $row_CCPC['pago'];
    $consumoC = $row_CCPC['consumo'];
    }
    }else{
    $pagoC = 0;
    $consumoC = 0; 
    }
    
    $sql_CDPC = "SELECT * FROM op_clientes_controlgas WHERE idreporte_dia = '".$idDias."' AND concepto = 'DEBITO (ANEXO)' LIMIT 1 ";
    $result_CDPC = mysqli_query($con, $sql_CDPC);
    $numero_CDPC = mysqli_num_rows($result_CDPC);
    if ($numero_CDPC == 1) {
    while($row_CDPC = mysqli_fetch_array($result_CDPC, MYSQLI_ASSOC)){
    $pagoD = $row_CDPC['pago'];
    $consumoD = $row_CDPC['consumo'];
    }
    }else{
    $pagoD = 0;
    $consumoD = 0;
    }
    

$totalPago = $pagoC + $pagoD;
$totalConsumo = $consumoC + $consumoD;

$Tobancomer = $Tobancomer + $bancomer;
$Toamex = $Toamex + $amex;
$Toinburgas = $Toinburgas + $inburgas;
$Toinbursa = $Toinbursa + $inbursa;
$TototalTB = $TototalTB + $totalTB;

$Toticketcard = $Toticketcard + $ticketcard;
$Tog500fleet = $Tog500fleet + $g500fleet;
$Toefecticard = $Toefecticard + $efecticard;
$Tosodexo = $Tosodexo + $sodexo;
$Toultragas = $Toultragas + $ultragas;
$Toenergex = $Toenergex + $energex;
$TototalTarjetas = $TototalTarjetas + $totalTarjetas;

$TopagoC = $TopagoC + $pagoC;
$ToconsumoC = $ToconsumoC + $consumoC;
$TopagoD = $TopagoD + $pagoD;
$ToconsumoD = $ToconsumoD + $consumoD;
$TototalPago = $TototalPago + $totalPago;
$TototalConsumo = $TototalConsumo + $totalConsumo;

$Tovalaccord = $Tovalaccord + $valaccord;
$Tovalefectivale = $Tovalefectivale + $valefectivale;
$Tovalsodexo = $Tovalsodexo + $valsodexo;
$Tovalvale = $Tovalvale + $valvale;

$GTVales = $GTVales + $totalVales;

$body = array(
FormatoFecha($fecha),
'$'.number_format($bancomer,2),
'$'.number_format($amex,2),
'$'.number_format($inbursa,2),
'$'.number_format($totalTB,2),
'$'.number_format($ticketcard,2),
'$'.number_format($g500fleet,2),
'$'.number_format($efecticard,2),
'$'.number_format($inburgas,2),
'$'.number_format($sodexo,2),
'$'.number_format($ultragas,2),
'$'.number_format($energex,2),
'$'.number_format($totalTarjetas,2),
'$'.number_format($valaccord,2),
'$'.number_format($valefectivale,2),
'$'.number_format($valsodexo,2),
'$'.number_format($valvale,2),
'$'.number_format($totalVales,2),
'$'.number_format($pagoC,2),
'$'.number_format($consumoC,2),
'$'.number_format($pagoD,2),
'$'.number_format($consumoD,2),
'$'.number_format($totalPago,2),
'$'.number_format($totalConsumo,2)
);

$contenido = array_map("utf8_decode", $body);
fputcsv($salida, $contenido);

}

$Totales = array(
'',
'$'.number_format($Tobancomer,2),
'$'.number_format($Toamex,2),
'$'.number_format($Toinbursa,2),
'$'.number_format($TototalTB,2),
'$'.number_format($Toticketcard,2),
'$'.number_format($Tog500fleet,2),
'$'.number_format($Toefecticard,2),
'$'.number_format($Toinburgas,2),
'$'.number_format($Tosodexo,2),
'$'.number_format($Toultragas,2),
'$'.number_format($Toenergex,2),
'$'.number_format($TototalTarjetas,2),
'$'.number_format($Tovalaccord,2),
'$'.number_format($Tovalefectivale,2),
'$'.number_format($Tovalsodexo,2),
'$'.number_format($Tovalvale,2),
'$'.number_format($GTVales,2),
'$'.number_format($TopagoC,2),
'$'.number_format($ToconsumoC,2),
'$'.number_format($TopagoD,2),
'$'.number_format($ToconsumoD,2),
'$'.number_format($TototalPago,2),
'$'.number_format($TototalConsumo,2)
);

$contenidoTotales = array_map("utf8_decode", $Totales);
fputcsv($salida, $contenidoTotales);