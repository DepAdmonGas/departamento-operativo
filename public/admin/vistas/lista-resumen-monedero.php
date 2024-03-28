<?php
require('../../../app/help.php');

$GET_idEstacion = $_GET['idEstacion'];
$GET_year = $_GET['year'];
$GET_mes = $_GET['mes'];

  function TarjetasCB($idReporte,$concepto,$con){
    $sql_cb = "SELECT * FROM op_tarjetas_c_b WHERE idreporte_dia = '".$idReporte."' AND concepto = '".$concepto."' LIMIT 1 ";
    $result_cb = mysqli_query($con, $sql_cb);
    while($row_cb = mysqli_fetch_array($result_cb, MYSQLI_ASSOC)){
    $baucher = $row_cb['baucher'];
    }

    return $baucher;
   }

 
  function ProsegurImporte($idReporte,$denominacion,$con){

    $sql_listaprosegur2 = "SELECT importe FROM op_prosegur WHERE idreporte_dia = '".$idReporte."' AND denominacion = '".$denominacion."' LIMIT 1 ";
    $result_listaprosegur2 = mysqli_query($con, $sql_listaprosegur2);
    $numero_listaprosegur2 = mysqli_num_rows($result_listaprosegur2);
    
    while($row_listaprosegur2 = mysqli_fetch_array($result_listaprosegur2, MYSQLI_ASSOC)){
    $importe2 = $row_listaprosegur2['importe'];

    } 

    return $importe2;
  }


  if($Session_IDUsuarioBD == 19 || $Session_IDUsuarioBD == 318){
  $ocultarProsegur = "";
  
  }else{
  $ocultarProsegur = "d-none"; 
  
  }

?> 
  
<table class="table table-sm table-bordered table-hover" style="font-size: .8em;">
<thead>
  <tr>
  <td class="text-center align-middle tableStyle font-weight-bold" colspan="17">MONEDEROS</td>
  <td class="text-center align-middle tableStyle font-weight-bold" colspan="2">CRÉDITO</td>
  <td class="text-center align-middle tableStyle font-weight-bold" colspan="2">DÉBITO</td>
  <td class="text-center align-middle tableStyle font-weight-bold" >PAGOS</td>
  <td class="text-center align-middle tableStyle font-weight-bold" >CONSUMOS</td>
  </tr>
 
    <tr>
      <td></td>
    <td  class="text-center align-middle tableStyle font-weight-bold" colspan="4">TARJETAS BANCARIAS</td>
    <td  class="text-center align-middle tableStyle font-weight-bold" colspan="7">TARJETAS</td>
    <td  class="text-center align-middle tableStyle font-weight-bold" colspan="5">VALES</td>
    <td  class="text-center align-middle tableStyle font-weight-bold" colspan="6">Cartera de Clientes ATIO </td>

    <td  class="text-center align-middle tableStyle font-weight-bold <?=$ocultarProsegur?>" colspan="10">PROSEGUR </td>

  </tr>
     
    <tr>    
    <th class="text-center align-middle bg-white" >Fecha</th>

    <th class="text-center align-middle bg-white" >BANCOMER</th>
    <th class="text-center align-middle bg-white" >AMEX</th>
    <th class="text-center align-middle bg-white" >INBURSA</th>
    <th class="text-center align-middle bg-white" >TOTAL</th>

    <th class="text-center align-middle bg-white" >INBURGAS</th>

    <!----- <th class="text-center align-middle bg-white" >TICKETCARD</th> -->
    <th class="text-center align-middle bg-white" >EDENRED</th>

    <!-- <th class="text-center align-middle bg-white" >G500 FLETT</th> -->

    <!----- <th class="text-center align-middle bg-white" >EFECTICARD</th> -->
    <th class="text-center align-middle bg-white" >EFECTIVALE</th>


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


    <th class="text-center align-middle bg-white <?=$ocultarProsegur?>">Billete Matutino</th>
    <th class="text-center align-middle bg-white <?=$ocultarProsegur?>">Billete Vespertino</th>
    <th class="text-center align-middle bg-white <?=$ocultarProsegur?>">Billete Nocturno</th>
    <th class="text-center align-middle bg-white <?=$ocultarProsegur?>">Morralla</th>
    <th class="text-center align-middle bg-white <?=$ocultarProsegur?>">Deposito Bancario</th>
    <th class="text-center align-middle bg-white <?=$ocultarProsegur?>">Cheque 1</th>
    <th class="text-center align-middle bg-white <?=$ocultarProsegur?>">Transferencia 1</th>
    <th class="text-center align-middle bg-white <?=$ocultarProsegur?>">Cheque 2</th>
    <th class="text-center align-middle bg-white <?=$ocultarProsegur?>">Transferencia 2</th>
    <th class="text-center align-middle bg-white <?=$ocultarProsegur?>">TOTAL</th>


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



//---------- PROSEGUR ----------
$BilleteMatutino = ProsegurImporte($idDias,"BILLETE MATUTINO",$con);
$BilleteVespertino = ProsegurImporte($idDias,"BILLETE VESPERTINO",$con);
$BilleteNocturno = ProsegurImporte($idDias,"BILLETE NOCTURNO",$con);
$Morralla = ProsegurImporte($idDias,"MORRALLA",$con);
$DespositoBancario = ProsegurImporte($idDias,"DEPOSITO BANCARIO",$con);
$Cheque1 = ProsegurImporte($idDias,"CHEQUE 1",$con);
$Transferencia1 = ProsegurImporte($idDias,"TRANSFERENCIA 1",$con);
$Cheque2 = ProsegurImporte($idDias,"CHEQUE 2",$con);
$Transferencia2 = ProsegurImporte($idDias,"TRANSFERENCIA 2",$con);

$ToBilleteM = $ToBilleteM + $BilleteMatutino;
$ToBilleteV = $ToBilleteV + $BilleteVespertino;
$ToBilleteN = $ToBilleteN + $BilleteNocturno;
$ToMorralla = $ToMorralla + $Morralla;
$ToDesposito = $ToDesposito + $DespositoBancario;
$ToCheque1 = $ToCheque1 + $Cheque1;
$ToTransferencia1 = $ToTransferencia1 + $Transferencia1;
$ToCheque2 = $ToCheque2 + $Cheque2;
$ToTransferencia2 = $ToTransferencia2 + $Transferencia2;


$totalImporte = $BilleteMatutino + $BilleteVespertino + $BilleteNocturno + $Morralla + $DespositoBancario + $Cheque1 + $Transferencia1 + $Cheque2 + $Transferencia2;
$Toprosegur = $Toprosegur + $totalImporte;


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
    $<?=number_format($inbursa,2);?>
  </td>
  <td class="align-middle text-end bg-light">
   <strong>$<?=number_format($totalTB,2);?></strong>
  </td>


    <td class="align-middle text-right">
    $<?=number_format($inburgas,2);?>
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


  <!----------------------------------------------------->

  <td class="align-middle text-end <?=$ocultarProsegur?>">
   $<?=number_format($BilleteMatutino,2);?>
  </td>

  <td class="align-middle text-end <?=$ocultarProsegur?>">
   $<?=number_format($BilleteVespertino,2);?>
  </td>

    <td class="align-middle text-end <?=$ocultarProsegur?>">
   $<?=number_format($BilleteNocturno,2);?>
  </td>

    <td class="align-middle text-end <?=$ocultarProsegur?>">
  $<?=number_format($Morralla,2);?>
  </td>

    <td class="align-middle text-end <?=$ocultarProsegur?>">
  $<?=number_format($DespositoBancario,2);?>
  </td>

    <td class="align-middle text-end <?=$ocultarProsegur?>">
  $<?=number_format($Cheque1,2);?>
  </td>

    <td class="align-middle text-end <?=$ocultarProsegur?>">
  $<?=number_format($Transferencia1,2);?>
  </td>

    <td class="align-middle text-end <?=$ocultarProsegur?>">
  $<?=number_format($Cheque2,2);?>
  </td>

    <td class="align-middle text-end <?=$ocultarProsegur?>">
  $<?=number_format($Transferencia2,2);?>
  </td>

  <td class="align-middle text-end <?=$ocultarProsegur?>">
   $<?=number_format($totalImporte,2);?>
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
    <strong>$<?=number_format($Toinbursa,2);?></strong>
  </td>
  <td class="align-middle text-end">
   <strong>$<?=number_format($TototalTB,2);?></strong>
  </td>

    <td class="align-middle text-right">
    <strong>$<?=number_format($Toinburgas,2);?></strong>
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


  <!----------------------------------------------------->

  <td class="align-middle text-end <?=$ocultarProsegur?>">
  <strong>$<?=number_format($ToBilleteM,2);?></strong>
  </td>

  <td class="align-middle text-end <?=$ocultarProsegur?>">
  <strong>$<?=number_format($ToBilleteV,2);?></strong>
  </td>

  <td class="align-middle text-end <?=$ocultarProsegur?>">
  <strong>$<?=number_format($ToBilleteN,2);?></strong>
  </td>

  <td class="align-middle text-end <?=$ocultarProsegur?>">
  <strong>$<?=number_format($ToMorralla,2);?></strong>
  </td>

  <td class="align-middle text-end <?=$ocultarProsegur?>">
  <strong>$<?=number_format($ToDesposito,2);?></strong>
  </td>

  <td class="align-middle text-end <?=$ocultarProsegur?>">
  <strong>$<?=number_format($ToCheque1,2);?></strong>
  </td>

  <td class="align-middle text-end <?=$ocultarProsegur?>">
  <strong>$<?=number_format($ToTransferencia1,2);?></strong>
  </td>

  <td class="align-middle text-end <?=$ocultarProsegur?>">
  <strong>$<?=number_format($ToCheque2,2);?></strong>
  </td>

  <td class="align-middle text-end <?=$ocultarProsegur?>">
  <strong>$<?=number_format($ToTransferencia2,2);?></strong>
  </td>

  <td class="align-middle text-end <?=$ocultarProsegur?>">
  <strong>$<?=number_format($Toprosegur,2);?></strong>
  </td>

</tr>

</tbody>
</table>