<?php
require('../../../app/help.php');
$idReporte = $_GET['idReporte'];
?>


<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0" style="font-size: .8em;">
<thead class="tables-bg">
	<th class="text-center">CONCEPTO</th>
	<th class="text-center">PAGOS</th>
	<th class="text-center">CONSUMOS</th>
</thead>
<tbody>
	<?php

	$sql_listacontrol = "SELECT * FROM op_clientes_controlgas WHERE idreporte_dia = '".$idReporte."' ";
    $result_listacontrol = mysqli_query($con, $sql_listacontrol);
    while($row_listacontrol = mysqli_fetch_array($result_listacontrol, MYSQLI_ASSOC)){

		$idControl = $row_listacontrol['id'];
		$concepto = $row_listacontrol['concepto'];

    	$pago =  $row_listacontrol['pago'];

    $consumo =  $row_listacontrol['consumo'];

    $topago = $topago + $row_listacontrol['pago'];
    $toconsumo = $toconsumo + $row_listacontrol['consumo'];

    ?>

    <tr>
    	<td class="align-middle"><?=$concepto;?></td>
    	<td class="p-1 align-middle text-end">
    		<?=number_format($pago,2);?>
    	</td>
    	<td class="p-1 align-middle text-end">
    		<?=number_format($consumo,2);?>
    	</td>
    </tr>

    <?php
    }

	?>
	<tr>
     <th class="bg-light text-center">TOTAL 3</th>
    <td class="bg-light align-middle text-end"><strong><?=number_format($topago,2);?></strong></td>
    <td class="bg-light align-middle text-end"><strong><?=number_format($toconsumo,2);?></strong></td>   
    </tr>

</tbody>
</table>
</div>