<?php
require('../../../app/help.php');
$idReporte = $_GET['idReporte'];
?>


<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0" style="font-size: .8em;">
<thead class="tables-bg">
	<th class="text-center">CONCEPTO</th>
	<th class="text-center">IMPORTE</th>
	<th class="text-center">NOTA</th>
</thead>
<tbody>
	<?php

	$sql_listaclientes = "SELECT * FROM op_pago_clientes WHERE idreporte_dia = '".$idReporte."' ";
    $result_listaclientes = mysqli_query($con, $sql_listaclientes);
    while($row_listaclientes = mysqli_fetch_array($result_listaclientes, MYSQLI_ASSOC)){

		$idPagoCliente = $row_listaclientes['id'];
		$concepto = $row_listaclientes['concepto'];
		$nota = $row_listaclientes['nota'];

		
    	$importe = $row_listaclientes['importe'];

        $totalImporte = $totalImporte + $importe;

    ?>

    <tr>
    	<td class="align-middle"><?=$concepto;?></td>
    	<td class="p-1 align-middle text-end">
    		<?=number_format($importe,2);?>
    	</td>
    	<td class="p-1 align-middle">
    		<?=$nota;?>
    	</td>
    </tr>

    <?php
    }

	?>
	<tr>
      <th class="bg-light text-center">TOTAL 4</th>
    <td class="bg-light align-middle text-end"><strong><?=number_format($totalImporte,2);?></strong></td>
    <td class="bg-light align-middle text-end"></td>   
    </tr>
</tbody>
</table>
</div>