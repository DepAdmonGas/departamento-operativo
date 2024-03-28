<?php
require('../../../app/help.php');
$idReporte = $_GET['idReporte'];
?>

<div style="overflow-y: hidden;">

<table class="table table-sm table-bordered pb-0 mb-0" style="font-size: .8em;">
<thead class="tables-bg">
	<th class="text-center" colspan="2">CONCEPTO / BANCO</th>
	<th class="text-center">IMPORTE</th>
</thead>

<tbody>
	<?php

	$sql_listatarjetas = "SELECT * FROM op_tarjetas_c_b WHERE idreporte_dia = '".$idReporte."' ";
    $result_listatarjetas = mysqli_query($con, $sql_listatarjetas);
    while($row_listatarjetas = mysqli_fetch_array($result_listatarjetas, MYSQLI_ASSOC)){

		$idTarjeta = $row_listatarjetas['id'];
        $num = $row_listatarjetas['num'];
		$conceptoTarjeta = $row_listatarjetas['concepto'];
    	$baucher =  $row_listatarjetas['baucher'];
        $baucherTotal = $baucherTotal + $baucher;
    ?>

    <tr>
        <td class="align-middle text-center"><b><?=$num;?></b></td>
    	<td class="align-middle"><?=$conceptoTarjeta;?></td>
        
           <td class="p-1 align-middle text-end">
           <?=number_format($baucher,2);?>
           </td>
            
    
    </tr>

    <?php
    }

	?>
	<tr>
    <th class="bg-light text-center" colspan="2">TOTAL 2</th>
    <td class="bg-light align-middle text-end"><strong><?=number_format($baucherTotal,2);?></strong></td>   
    </tr>
</tbody>
</table>

</div>