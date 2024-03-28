<?php
require('../../../app/help.php');
$idReporte = $_GET['idReporte'];

$sql_dia = "SELECT ventas FROM op_corte_dia WHERE id = '".$idReporte."' LIMIT 1 ";
   $result_dia = mysqli_query($con, $sql_dia);
   while($row_dia = mysqli_fetch_array($result_dia, MYSQLI_ASSOC)){
   $ventas = $row_dia['ventas'];

   if ($ventas == 1) {
   $estado = "disabled";
   }else{
    $estado = "";
   }
   }
?>
<script type="text/javascript">

$(document).ready(function($){

  PagoCTotal(<?=$idReporte;?>);  
   
  });

	 function PagoCTotal(idReporte){
    $('#TrClientesTotales').load('../../../public/corte-diario/vistas/pagoclientes-totales.php?idReporte=' + idReporte);
  }
</script>

<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0" style="font-size: .9em;">
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

		if ($row_listaclientes['importe'] == 0) {
    		$importe = "";
    	}else{
    		$importe =  number_format($row_listaclientes['importe'], 2, '.', '');
    	}

    ?>

    <tr>
    	<td class="align-middle"><?=$concepto;?></td>
    	<td class="p-0 align-middle">
    		<input id="importe-<?=$idPagoCliente;?>" type="number" min="0" step="any" style="border: 0px;width: 100%;padding: 3px;height: 100%; text-align: right;" onkeyup="EditPCimporte(this,<?=$idReporte;?>,<?=$idPagoCliente;?>)" value="<?=$importe;?>" <?=$estado;?>>
    	</td>
    	<td class="p-0 align-middle">
    		<input id="nota-<?=$idPagoCliente;?>" type="text" style="border: 0px;width: 100%;padding: 3px;height: 100%; text-align: left;" onkeyup="EditPCnota(this,<?=$idReporte;?>,<?=$idPagoCliente;?>)" value="<?=$nota;?>" <?=$estado;?>>
    	</td>
    </tr>

    <?php
    }

	?>
	<tr id="TrClientesTotales"></tr>
</tbody>
</table>
</div>