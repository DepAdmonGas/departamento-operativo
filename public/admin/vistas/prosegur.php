<?php
require('../../../app/help.php');
$idReporte = $_GET['idReporte'];
?>

<div class="table-responsive">

<table class="table table-sm table-bordered pb-0 mb-0" style="font-size: .8em;">

<thead class="tables-bg">
	<th class="text-center">DENOMINACION</th>
	<th class="text-center">RECIBO</th>
	<th class="text-center">IMPORTE</th>
</thead>

<tbody>
	<?php

	$sql_listaprosegur = "SELECT * FROM op_prosegur WHERE idreporte_dia = '".$idReporte."' ";
    $result_listaprosegur = mysqli_query($con, $sql_listaprosegur);
    while($row_listaprosegur = mysqli_fetch_array($result_listaprosegur, MYSQLI_ASSOC)){

		$idProsegur = $row_listaprosegur['id'];
		$denominacion = $row_listaprosegur['denominacion'];
		$recibo = $row_listaprosegur['recibo'];

		$valimporte =  $row_listaprosegur['importe'];

        $importe = $row_listaprosegur['importe'];

    $totalImporte = $totalImporte + $importe;

    ?>

    <tr>
    	<td class="align-middle"><?=$denominacion;?></td>
    	<td class="p-0 align-middle">
    		<?=$recibo;?>
    	</td>
    	<td class="p-0 align-middle text-end">
    		<?=number_format($valimporte,2);?>
    	</td>
    </tr>

    <?php
    }

	?>
	<tr>
    <th class="bg-light text-center" colspan="2">TOTAL 1</th>
    <td class="bg-light align-middle text-end"><strong><?=number_format($totalImporte,2);?></strong></td>
    </tr>
</tbody>

</table>
</div>