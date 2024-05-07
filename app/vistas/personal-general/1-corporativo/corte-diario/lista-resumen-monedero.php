<?php
require('../../../../help.php');

$GET_year = $_GET['year'];
$GET_mes = $_GET['mes'];
?>


<table class="table table-sm table-bordered table-hover" style="font-size: .8em;">
<thead>
  <tr>
  <td class="text-center align-middle tableStyle font-weight-bold" colspan="17"></td>

  <td class="text-center align-middle tableStyle font-weight-bold" colspan="2">CRÉDITO</td>
  <td class="text-center align-middle tableStyle font-weight-bold" colspan="2">DÉBITO</td>
  <td class="text-center align-middle tableStyle font-weight-bold" >PAGOS</td>
  <td class="text-center align-middle tableStyle font-weight-bold" >CONSUMOS</td>
  </tr>

    <tr>
    	<td></td>
    <td  class="text-center align-middle tableStyle font-weight-bold" colspan="5">TARJETAS BANCARIAS</td>
    <td  class="text-center align-middle tableStyle font-weight-bold" colspan="6">TARJETAS</td>
    <td  class="text-center align-middle tableStyle font-weight-bold" colspan="5">VALES</td>
    <td  class="text-center align-middle tableStyle font-weight-bold" colspan="6">Cartera de Clientes ATIO </td>
  </tr>
  
    <tr>    
    <th class="text-center align-middle bg-white" >Fecha</th>
    <th class="text-center align-middle bg-white" >BANCOMER</th>
    <th class="text-center align-middle bg-white" >AMEX</th>
    <th class="text-center align-middle bg-white" >INBURGAS</th>
    <th class="text-center align-middle bg-white" >INBURSA</th>
    <th class="text-center align-middle bg-white" >TOTAL</th>

    <th class="text-center align-middle bg-white" >TICKETCARD</th>
    <!-- <th class="text-center align-middle bg-white" >G500 FLETT</th> -->
    <th class="text-center align-middle bg-white" >EFECTICARD</th>
    <th class="text-center align-middle bg-white" >SODEXO</th>
    <th class="text-center align-middle bg-white" >ULTRAGAS</th>
    <th class="text-center align-middle bg-white" >ENERGEX</th>
    <th class="text-center align-middle bg-white" >TOTAL</th>

    <th class="text-center align-middle bg-white">VALE ACCORD</th>
    <th class="text-center align-middle bg-white">VALE EFECTIVALE</th>
    <th class="text-center align-middle bg-white">VALE SODEXO</th>
    <th class="text-center align-middle bg-white">SI VALE</th>
    <th class="text-center align-middle bg-white" >TOTAL</th>

    <th class="text-center align-middle bg-white" >Pagos</th>
    <th class="text-center align-middle bg-white" >Consumos</th>
    <th class="text-center align-middle bg-white" >Pagos</th>
    <th class="text-center align-middle bg-white" >Consumos</th>
    <th class="text-center align-middle bg-white" >TOTAL</th>
    <th class="text-center align-middle bg-white" >TOTAL</th>
  </tr>
</thead>
<tbody>
  <?php
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
$Toultragas = 0;
$Toenergex = 0;
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
          WHERE op_corte_year.id_estacion = '".$Session_IDEstacion."' AND 
          op_corte_year.year = '".$GET_year."' AND 
          op_corte_mes.mes = '".$GET_mes."'";
          $result_listadia = mysqli_query($con, $sql_listadia);
          $numero_listadia = mysqli_num_rows($result_listadia);

          while($row_listadia = mysqli_fetch_array($result_listadia, MYSQLI_ASSOC)){
          $idDias = $row_listadia['idDia'];
          $fecha = $row_listadia['fecha'];

    $bancomer = $corteDiarioGeneral->tarjetasCB($idDias,"BBVA BANCOMER SA");
    $amex = $corteDiarioGeneral->tarjetasCB($idDias,"AMERICAN EXPRESS");
    $inburgas = $corteDiarioGeneral->tarjetasCB($idDias,"INBURGAS");
    $inbursa = $corteDiarioGeneral->tarjetasCB($idDias,"INBURSA");

    $totalTB = $bancomer + $amex + $inburgas + $inbursa;

    $ticketcard = $corteDiarioGeneral->tarjetasCB($idDias,"TICKETCARD");
    $g500fleet = $corteDiarioGeneral->tarjetasCB($idDias,"G500 FLETT");
    $efecticard = $corteDiarioGeneral->tarjetasCB($idDias,"EFECTICARD");
    $sodexo = $corteDiarioGeneral->tarjetasCB($idDias,"SODEXO");
    $ultragas = $corteDiarioGeneral->tarjetasCB($idDias,"ULTRAGAS");
    $energex = $corteDiarioGeneral->tarjetasCB($idDias,"ENERGEX");

    $totalTarjetas = $ticketcard + $g500fleet + $efecticard + $sodexo + $ultragas + $energex;

    $valaccord = $corteDiarioGeneral->tarjetasCB($idDias,"VALE ACCORD");
    $valefectivale = $corteDiarioGeneral->tarjetasCB($idDias,"VALE EFECTIVALE");
    $valsodexo = $corteDiarioGeneral->tarjetasCB($idDias,"VALE SODEXO");
    $valvale = $corteDiarioGeneral->tarjetasCB($idDias,"SI VALE");

    $totalVales = $valaccord + $valefectivale + $valsodexo + $valvale;

    $sql_CCPC = "SELECT * FROM op_clientes_controlgas WHERE idreporte_dia = '".$idDias."' AND concepto = 'CRÉDITO (ANEXO)' LIMIT 1 ";
    $result_CCPC = mysqli_query($con, $sql_CCPC);
    $numero_CCPC = mysqli_num_rows($result_CCPC);
    $Tovalaccord =0;
    $Tovalefectivale =0;
    $Tovalsodexo =0;
    $Tovalvale =0;
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

          ?>
<tr class="">
  <td><?=FormatoFecha($fecha);?></td>
  <td class="align-middle text-end">
    $<?=number_format($bancomer,2);?>
  </td>
  <td class="align-middle text-end">
    $<?=number_format($amex,2);?>
  </td>
  <td class="align-middle text-end">
    $<?=number_format($inburgas,2);?>
  </td>
  <td class="align-middle text-end">
    $<?=number_format($inbursa,2);?>
  </td>
  <td class="align-middle text-end bg-light">
   <strong>$<?=number_format($totalTB,2);?></strong>
  </td>
  <td class="align-middle text-end">
    $<?=number_format($ticketcard,2);?>
  </td>
  <!--
  <td class="align-middle text-end">
   $<?=number_format($g500fleet,2);?>
  </td>
  -->
  <td class="align-middle text-end">
   $<?=number_format($efecticard,2);?>
  </td>
   <td class="align-middle text-end">
   $<?=number_format($sodexo,2);?>
  </td>
  <td class="align-middle text-end">
   $<?=number_format($ultragas,2);?>
  </td>
  <td class="align-middle text-end">
   $<?=number_format($energex,2);?>
  </td>  

  
  <td class="align-middle text-end bg-light">
    <strong>$<?=number_format($totalTarjetas,2);?></strong>
  </td>

   <!----------------------------------------------------->
  <td class="align-middle text-end">
    $<?=number_format($valaccord,2);?>
  </td>
  <td class="align-middle text-end">
    $<?=number_format($valefectivale,2);?>
  </td>
  <td class="align-middle text-end">
    $<?=number_format($valsodexo,2);?>
  </td>
  <td class="align-middle text-end">
    $<?=number_format($valvale,2);?>
  </td>
  <td class="align-middle text-end bg-light">
    <strong>$<?=number_format($totalVales,2);?></strong>
  </td>
 
  <!----------------------------------------------------->

  <td class="align-middle text-end">
    $<?=number_format($pagoC,2);?>
  </td>
  <td class="align-middle text-end">
    $<?=number_format($consumoC,2);?>
  </td>
  <td class="align-middle text-end">
   $<?=number_format($pagoD,2);?>
  </td>
  <td class="align-middle text-end">
    $<?=number_format($consumoD,2);?>
  </td>
  <td class="align-middle text-end bg-light">
    <strong>$<?=number_format($totalPago,2);?></strong>
  </td>
  <td class="align-middle text-end bg-light">
    <strong>$<?=number_format($totalConsumo,2);?></strong>
  </td>
</tr>
<?php  } ?>
<tr class="bg-light">
  <td></td>
  <td class="align-middle text-end">
    <strong>$<?=number_format($Tobancomer,2);?></strong>
  </td>
  <td class="align-middle text-end">
    <strong>$<?=number_format($Toamex,2);?></strong>
  </td>
  <td class="align-middle text-end">
    <strong>$<?=number_format($Toinburgas,2);?></strong>
  </td>
  <td class="align-middle text-end">
    <strong>$<?=number_format($Toinbursa,2);?></strong>
  </td>
  <td class="align-middle text-end">
   <strong>$<?=number_format($TototalTB,2);?></strong>
  </td>
  <td class="align-middle text-end">
    <strong>$<?=number_format($Toticketcard,2);?></strong>
  </td>

  <!--
  <td class="align-middle text-end">
   <strong>$<?=number_format($Tog500fleet,2);?></strong>
  </td>
  -->

  <td class="align-middle text-end">
   <strong>$<?=number_format($Toefecticard,2);?></strong>
  </td>
   <td class="align-middle text-end">
   <strong>$<?=number_format($Tosodexo,2);?></strong>
  </td>
  <td class="align-middle text-end">
    <strong>$<?=number_format($Toultragas,2);?></strong>
  </td>
  <td class="align-middle text-end">
    <strong>$<?=number_format($Toenergex,2);?></strong>
  </td>
  <td class="align-middle text-end">
    <strong>$<?=number_format($TototalTarjetas,2);?></strong>
  </td>

  <td class="align-middle text-end">
    <strong>$<?=number_format($Tovalaccord,2);?></strong>
  </td>

  <td class="align-middle text-end">
  <strong>$<?=number_format($Tovalefectivale,2);?></strong>
  </td>

  <td class="align-middle text-end">
  <strong>$<?=number_format($Tovalsodexo,2);?></strong>
  </td>

  <td class="align-middle text-end">
  <strong>$<?=number_format($Tovalvale,2);?></strong>
  </td>

  <td class="align-middle text-end">
  <strong>$<?=number_format($GTVales,2);?></strong>
  </td>

  <td class="align-middle text-end">
    <strong>$<?=number_format($TopagoC,2);?></strong>
  </td>
  <td class="align-middle text-end">
    <strong>$<?=number_format($ToconsumoC,2);?></strong>
  </td>
  <td class="align-middle text-end">
   <strong>$<?=number_format($TopagoD,2);?></strong>
  </td>
  <td class="align-middle text-end">
    <strong>$<?=number_format($ToconsumoD,2);?></strong>
  </td>
  <td class="align-middle text-end">
    <strong>$<?=number_format($TototalPago,2);?></strong>
  </td>
  <td class="align-middle text-end">
    <strong>$<?=number_format($TototalConsumo,2);?></strong>
  </td>
</tr>

</tbody>
</table>