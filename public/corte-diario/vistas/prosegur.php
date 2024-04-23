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

  ProsegurTotal(<?=$idReporte;?>);  
   
  });

	function ProsegurTotal(idReporte){
  $('#TrProTotales').load('../../../public/corte-diario/vistas/prosegur-totales.php?idReporte=' + idReporte);
  }
 
</script>

<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0" style="font-size: .9em;">
<thead class="tables-bg">
	<th class="text-center">DENOMINACION</th>
	<th class="text-center">RECIBO</th>
	<th class="text-center">IMPORTE</th>
</thead>
<tbody>
	<?php

	$sql_listaprosegur = "SELECT * FROM op_prosegur WHERE idreporte_dia = '".$idReporte."' ";
    $result_listaprosegur = mysqli_query($con, $sql_listaprosegur);
    $totalImporte = 0;
    while($row_listaprosegur = mysqli_fetch_array($result_listaprosegur, MYSQLI_ASSOC)){

		$idProsegur = $row_listaprosegur['id'];
		$denominacion = $row_listaprosegur['denominacion'];
		$recibo = $row_listaprosegur['recibo'];

		if ($row_listaprosegur['importe'] == 0) {
    		$valimporte = "";
    	}else{
    		$valimporte =  number_format($row_listaprosegur['importe'], 2, '.', '');
    	}

        $importe = $row_listaprosegur['importe'];

    $totalImporte = $totalImporte + $importe;

    ?>

    <tr>
    	<td class="align-middle"><?=$denominacion;?></td>
    	<td class="p-0 align-middle">
    		<input id="recibo-<?=$idProsegur;?>" type="text" style="border: 0px;width: 100%;padding: 3px;height: 100%; text-align: left;" onkeyup="EditPRecibo(this,<?=$idReporte;?>,<?=$idProsegur;?>)" value="<?=$recibo;?>" <?=$estado;?>>
    	</td>
    	<td class="p-0 align-middle">
    		<input id="importe-<?=$idProsegur;?>" type="number" min="0" step="any" style="border: 0px;width: 100%;padding: 3px;height: 100%; text-align: right;" onkeyup="EditPImporte(this,<?=$idReporte;?>,<?=$idProsegur;?>)" value="<?=$valimporte;?>" <?=$estado;?>>
    	</td>
    </tr>

    <?php
    }

	?>
	<tr id="TrProTotales">
    </tr>
</tbody>
</table>
</div>