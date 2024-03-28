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

   function ResumenMonedero($idEstacion,$Year,$Mes,$FechaInicio,$FechaTermino,$con){

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
          WHERE op_corte_year.id_estacion = '".$idEstacion."' AND 
          op_corte_year.year = '".$Year."' AND 
          op_corte_mes.mes = '".$Mes."' AND op_corte_dia.fecha BETWEEN '".$FechaInicio."' AND '".$FechaTermino."' ";
          $result_listadia = mysqli_query($con, $sql_listadia);
          $numero_listadia = mysqli_num_rows($result_listadia);

          while($row_listadia = mysqli_fetch_array($result_listadia, MYSQLI_ASSOC)){
          $idDias = $row_listadia['idDia'];
          $fecha = $row_listadia['fecha'];

          $inburgas = TarjetasCB($idDias,"INBURGAS",$con);
          $ticketcard = TarjetasCB($idDias,"TICKETCARD",$con);
          $g500fleet = TarjetasCB($idDias,"G500 FLETT",$con);
          $efecticard = TarjetasCB($idDias,"EFECTICARD",$con);
          $sodexo = TarjetasCB($idDias,"SODEXO",$con);
          $ultragas = TarjetasCB($idDias,"ULTRAGAS",$con);
          $energex = TarjetasCB($idDias,"ENERGEX",$con);

          $valaccord = TarjetasCB($idDias,"VALE ACCORD",$con);
          $valefectivale = TarjetasCB($idDias,"VALE EFECTIVALE",$con);
          $valsodexo = TarjetasCB($idDias,"VALE SODEXO",$con);
          $valvale = TarjetasCB($idDias,"SI VALE",$con);

          $Toinburgas = $Toinburgas + $inburgas;
          $Toticketcard = $Toticketcard + $ticketcard;
          $Tog500fleet = $Tog500fleet + $g500fleet;
          $Toefecticard = $Toefecticard + $efecticard;
          $Tosodexo = $Tosodexo + $sodexo;
          $Toultragas = $Toultragas + $ultragas;
          $Toenergex = $Toenergex + $energex;
          $Tovalaccord = $Tovalaccord + $valaccord;
          $Tovalefectivale = $Tovalefectivale + $valefectivale;
          $Tovalsodexo = $Tovalsodexo + $valsodexo;
          $Tovalvale = $Tovalvale + $valvale;

          $PrimerTotal = $Toinburgas + $Toticketcard + $Tog500fleet + $Toefecticard + $Tosodexo + $Toultragas + $Toenergex;
          $SegundoTotal = $Tovalaccord + $Tovalefectivale + $Tovalsodexo + $Tovalvale;


   }

   return array(
    'Toinburgas' => $Toinburgas,
    'Toticketcard' => $Toticketcard,
    'Tog500fleet' => $Tog500fleet,
    'Toefecticard' => $Toefecticard,
    'Tosodexo' => $Tosodexo,
    'Toultragas' => $Toultragas,
    'Toenergex' => $Toenergex,
    'PrimerTotal' => $PrimerTotal,
    'Tovalaccord' => $Tovalaccord,
    'Tovalefectivale' => $Tovalefectivale,
    'Tovalsodexo' => $Tovalsodexo,
    'Tovalvale' => $Tovalvale,
    'SegundoTotal' => $SegundoTotal
 );

   }

    $Periodo1 = ResumenMonedero(
    $GET_idEstacion,
    $GET_year,
    $GET_mes,
    $GET_year.'-'.$GET_mes.'-01',
    $GET_year.'-'.$GET_mes.'-08',
    $con);

    $Periodo2 = ResumenMonedero(
    $GET_idEstacion,
    $GET_year,
    $GET_mes,
    $GET_year.'-'.$GET_mes.'-09',
    $GET_year.'-'.$GET_mes.'-15',
    $con);

    $Periodo3 = ResumenMonedero(
    $GET_idEstacion,
    $GET_year,
    $GET_mes,
    $GET_year.'-'.$GET_mes.'-16',
    $GET_year.'-'.$GET_mes.'-22',
    $con);

    $Periodo4 = ResumenMonedero(
    $GET_idEstacion,
    $GET_year,
    $GET_mes,
    $GET_year.'-'.$GET_mes.'-23',
    $GET_year.'-'.$GET_mes.'-29',
    $con);

    $Periodo5 = ResumenMonedero(
    $GET_idEstacion,
    $GET_year,
    $GET_mes,
    $GET_year.'-'.$GET_mes.'-30',
    $GET_year.'-'.$GET_mes.'-31',
    $con);

$Toinburgas = $Periodo1['Toinburgas'] + $Periodo2['Toinburgas'] + $Periodo3['Toinburgas'] + $Periodo4['Toinburgas'] + $Periodo5['Toinburgas'];
$Toticketcard = $Periodo1['Toticketcard'] + $Periodo2['Toticketcard'] + $Periodo3['Toticketcard'] + $Periodo4['Toticketcard'] + $Periodo5['Toticketcard'];
$Tog500fleet = $Periodo1['Tog500fleet'] + $Periodo2['Tog500fleet'] + $Periodo3['Tog500fleet'] + $Periodo4['Tog500fleet'] + $Periodo5['Tog500fleet'];
$Toefecticard = $Periodo1['Toefecticard'] + $Periodo2['Toefecticard'] + $Periodo3['Toefecticard'] + $Periodo4['Toefecticard'] + $Periodo5['Toefecticard'];
$Tosodexo = $Periodo1['Tosodexo'] + $Periodo2['Tosodexo'] + $Periodo3['Tosodexo'] + $Periodo4['Tosodexo'] + $Periodo5['Tosodexo'];
$Toultragas = $Periodo1['Toultragas'] + $Periodo2['Toultragas'] + $Periodo3['Toultragas'] + $Periodo4['Toultragas'] + $Periodo5['Toultragas'];
$Toenergex = $Periodo1['Toenergex'] + $Periodo2['Toenergex'] + $Periodo3['Toenergex'] + $Periodo4['Toenergex'] + $Periodo5['Toenergex'];
$PrimerTotal = $Periodo1['PrimerTotal'] + $Periodo2['PrimerTotal'] + $Periodo3['PrimerTotal'] + $Periodo4['PrimerTotal'] + $Periodo5['PrimerTotal'];
$Tovalaccord = $Periodo1['Tovalaccord'] + $Periodo2['Tovalaccord'] + $Periodo3['Tovalaccord'] + $Periodo4['Tovalaccord'] + $Periodo5['Tovalaccord'];
$Tovalefectivale = $Periodo1['Tovalefectivale'] + $Periodo2['Tovalefectivale'] + $Periodo3['Tovalefectivale'] + $Periodo4['Tovalefectivale'] + $Periodo5['Tovalefectivale'];
$Tovalsodexo = $Periodo1['Tovalsodexo'] + $Periodo2['Tovalsodexo'] + $Periodo3['Tovalsodexo'] + $Periodo4['Tovalsodexo'] + $Periodo5['Tovalsodexo'];
$Tovalvale = $Periodo1['Tovalvale'] + $Periodo2['Tovalvale'] + $Periodo3['Tovalvale'] + $Periodo4['Tovalvale'] + $Periodo5['Tovalvale'];
$SegundoTotal = $Periodo1['SegundoTotal'] + $Periodo2['SegundoTotal'] + $Periodo3['SegundoTotal'] + $Periodo4['SegundoTotal'] + $Periodo5['SegundoTotal'];
?>


<div class="table-responsive">
<table class="table table-sm table-bordered table-hover" style="font-size: .9em;">
<thead class="tables-bg">
<tr>
<td class="text-center align-middle tableStyle font-weight-bold"></td>
<td class="text-center align-middle tableStyle font-weight-bold"></td>
<td class="text-center align-middle tableStyle font-weight-bold"><b>INBURGAS</b></td>
<td class="text-center align-middle tableStyle font-weight-bold"><b>TICKETCARD</b></td>
<td class="text-center align-middle tableStyle font-weight-bold"><b>G500 FLETT</b></td>
<td class="text-center align-middle tableStyle font-weight-bold"><b>EFECTICARD</b></td>
<td class="text-center align-middle tableStyle font-weight-bold"><b>SODEXO</b></td>
<td class="text-center align-middle tableStyle font-weight-bold"><b>ULTRAGAS</b></td>
<td class="text-center align-middle tableStyle font-weight-bold"><b>ENERGEX</b></td>
<td class="text-center align-middle tableStyle font-weight-bold"><b>TOTAL</b></td>
<td class="text-center align-middle tableStyle font-weight-bold"><b>VALE ACCORD</b></td>
<td class="text-center align-middle tableStyle font-weight-bold"><b>VALE EFECTIVALE</b></td>
<td class="text-center align-middle tableStyle font-weight-bold"><b>VALE SODEXO</b></td>
<td class="text-center align-middle tableStyle font-weight-bold"><b>SI VALE</b></td>
<td class="text-center align-middle tableStyle font-weight-bold"><b>TOTAL</b></td>
</tr>
</thead> 
<tbody>
<tr>
  <td>1er periodo</td>
  <td>8</td>
  <td class="align-middle text-end">$<?=number_format($Periodo1['Toinburgas'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo1['Toticketcard'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo1['Tog500fleet'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo1['Toefecticard'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo1['Tosodexo'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo1['Toultragas'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo1['Toenergex'],2);?></td>
  <td class="align-middle text-end font-weight-bold bg-light">$<?=number_format($Periodo1['PrimerTotal'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo1['Tovalaccord'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo1['Tovalefectivale'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo1['Tovalsodexo'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo1['Tovalvale'],2);?></td>
  <td class="align-middle text-end font-weight-bold bg-light">$<?=number_format($Periodo1['SegundoTotal'],2);?></td>  
</tr>

<tr>
  <td>2do periodo</td>
  <td>15</td>
  <td class="align-middle text-end">$<?=number_format($Periodo2['Toinburgas'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo2['Toticketcard'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo2['Tog500fleet'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo2['Toefecticard'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo2['Tosodexo'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo2['Toultragas'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo2['Toenergex'],2);?></td>
  <td class="align-middle text-end font-weight-bold bg-light">$<?=number_format($Periodo2['PrimerTotal'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo2['Tovalaccord'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo2['Tovalefectivale'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo2['Tovalsodexo'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo2['Tovalvale'],2);?></td>
  <td class="align-middle text-end font-weight-bold bg-light">$<?=number_format($Periodo2['SegundoTotal'],2);?></td>
</tr>

<tr>
  <td>3er periodo</td>
  <td>22</td>
  <td class="align-middle text-end">$<?=number_format($Periodo3['Toinburgas'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo3['Toticketcard'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo3['Tog500fleet'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo3['Toefecticard'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo3['Tosodexo'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo3['Toultragas'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo3['Toenergex'],2);?></td>
  <td class="align-middle text-end font-weight-bold bg-light">$<?=number_format($Periodo3['PrimerTotal'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo3['Tovalaccord'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo3['Tovalefectivale'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo3['Tovalsodexo'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo3['Tovalvale'],2);?></td>
  <td class="align-middle text-end font-weight-bold bg-light">$<?=number_format($Periodo3['SegundoTotal'],2);?></td>
</tr>

<tr>
  <td>4to periodo</td>
  <td>29</td>
  <td class="align-middle text-end">$<?=number_format($Periodo4['Toinburgas'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo4['Toticketcard'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo4['Tog500fleet'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo4['Toefecticard'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo4['Tosodexo'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo4['Toultragas'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo4['Toenergex'],2);?></td>
  <td class="align-middle text-end font-weight-bold bg-light">$<?=number_format($Periodo4['PrimerTotal'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo4['Tovalaccord'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo4['Tovalefectivale'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo4['Tovalsodexo'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo4['Tovalvale'],2);?></td>
  <td class="align-middle text-end font-weight-bold bg-light">$<?=number_format($Periodo4['SegundoTotal'],2);?></td>
</tr>

<tr>
  <td>5to periodo</td>
  <td>30/31</td>
  <td class="align-middle text-end">$<?=number_format($Periodo5['Toinburgas'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo5['Toticketcard'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo5['Tog500fleet'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo5['Toefecticard'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo5['Tosodexo'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo5['Toultragas'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo5['Toenergex'],2);?></td>
  <td class="align-middle text-end font-weight-bold bg-light">$<?=number_format($Periodo5['PrimerTotal'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo5['Tovalaccord'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo5['Tovalefectivale'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo5['Tovalsodexo'],2);?></td>
  <td class="align-middle text-end">$<?=number_format($Periodo5['Tovalvale'],2);?></td>
  <td class="align-middle text-end font-weight-bold bg-light">$<?=number_format($Periodo5['SegundoTotal'],2);?></td>
</tr>

<tr class="bg-light">
  <td colspan="2"></td>
  <td class="align-middle text-end font-weight-bold">$<?=number_format($Toinburgas,2);?></td>
  <td class="align-middle text-end font-weight-bold">$<?=number_format($Toticketcard,2);?></td>
  <td class="align-middle text-end font-weight-bold">$<?=number_format($Tog500fleet,2);?></td>
  <td class="align-middle text-end font-weight-bold">$<?=number_format($Toefecticard,2);?></td>
  <td class="align-middle text-end font-weight-bold">$<?=number_format($Tosodexo,2);?></td>
  <td class="align-middle text-end font-weight-bold">$<?=number_format($Toultragas,2);?></td>
  <td class="align-middle text-end font-weight-bold">$<?=number_format($Toenergex,2);?></td>
  <td class="align-middle text-end font-weight-bold">$<?=number_format($PrimerTotal,2);?></td>
  <td class="align-middle text-end font-weight-bold">$<?=number_format($Tovalaccord,2);?></td>
  <td class="align-middle text-end font-weight-bold">$<?=number_format($Tovalefectivale,2);?></td>
  <td class="align-middle text-end font-weight-bold">$<?=number_format($Tovalsodexo,2);?></td>
  <td class="align-middle text-end font-weight-bold">$<?=number_format($Tovalvale,2);?></td>
  <td class="align-middle text-end font-weight-bold">$<?=number_format($SegundoTotal,2);?></td>
</tr>

</tbody>
</table>
</div>