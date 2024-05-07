<?php
require('../../../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$FInicio = $_GET['FechaInicio'];
$FTermino = $_GET['FechaTermino'];

$PSUPER = $corteDiarioGeneral->TotalProducto($idEstacion,$FInicio,$FTermino,'G SUPER');
$PPREMIUM = $corteDiarioGeneral->TotalProducto($idEstacion,$FInicio,$FTermino,'G PREMIUM');
$PDIESEL = $corteDiarioGeneral->TotalProducto($idEstacion,$FInicio,$FTermino,'G DIESEL');

$Total = $PSUPER + $PPREMIUM + $PDIESEL;
$totalPesos = $Total * 0.02;
?>


<div class="table-responsive">
<table class="custom-table mb-3" style="font-size: 14px;" width="100%">

<thead> 
<tr class="tables-bg">
<th colspan="3"> Fecha de reporte: <br> <?=FormatoFecha($FInicio);?> al día <?=FormatoFecha($FTermino);?> </th>
</tr>	

<tr>
<td class="align-middle text-center text-white fw-bold" style="background: #78bd24">G SUPER</td>
<td class="align-middle text-center text-white fw-bold" style="background: #e01483">G PREMIUM</td>
<td class="align-middle text-center text-white fw-bold" style="background: #5e0f8e">G DIESEL</td>
</tr>	

</thead>

<tbody class="bg-white">
<tr>
<th class="fw-bold"><?=number_format($PSUPER);?></th>
<td class="fw-bold"><?=number_format($PPREMIUM);?></td>
<td class="fw-bold"><?=number_format($PDIESEL);?></td>
</tr>
<tr>
<th colspan="2" class="text-end fw-normal">TOTAL DE LITROS COMPRADOS</th>
<td class="text-end "><b><?=number_format($Total);?></b></td>
</tr>
<tr>
<th colspan="2" class="text-end fw-normal">TOTAL A PAGAR</th>
<td class="text-end"><b>$ <?=number_format($totalPesos,2);?></b></td>
</tr>
</tbody>
</table>
</div>










