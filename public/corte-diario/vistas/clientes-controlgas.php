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
 
/*function Resumen($idReporte,$tipo,$consumo,$con){

$sql_credito = "SELECT
op_consumos_pagos.id,
op_consumos_pagos.id_reportedia,
op_consumos_pagos.id_cliente,
op_consumos_pagos.total,
op_consumos_pagos.tipo AS ConsumoTipo,
op_consumos_pagos.pago,
op_consumos_pagos.comprobante,
op_cliente.cuenta,
op_cliente.cliente,
op_cliente.tipo
FROM op_consumos_pagos 
INNER JOIN op_cliente
ON op_consumos_pagos.id_cliente = op_cliente.id
WHERE op_consumos_pagos.id_reportedia = '".$idReporte."' AND op_cliente.tipo = '".$tipo."' AND op_consumos_pagos.tipo = '".$consumo."' ";
$result_credito = mysqli_query($con, $sql_credito);
$numero_credito = mysqli_num_rows($result_credito);
while($row_credito = mysqli_fetch_array($result_credito, MYSQLI_ASSOC)){
$total = $total + $row_credito['total'];
}

return $total;
}


$DC = Resumen($idReporte,'Débito','Consumo',$con);
$DP = Resumen($idReporte,'Débito','Pago',$con);
$CC = Resumen($idReporte,'Crédito','Consumo',$con);
$CP = Resumen($idReporte,'Crédito','Pago',$con);

$sql1 = "UPDATE op_clientes_controlgas SET pago = '".$DP."', consumo = '".$DC."' WHERE idreporte_dia ='".$idReporte."' AND concepto = 'DEBITO (ANEXO)' ";
mysqli_query($con, $sql1);

$sql2 = "UPDATE op_clientes_controlgas SET pago = '".$CP."', consumo = '".$CC."' WHERE idreporte_dia ='".$idReporte."' AND concepto = 'CRÉDITO (ANEXO)' ";
mysqli_query($con, $sql2);
*/

?>
<script type="text/javascript">

$(document).ready(function($){

  ControlGTotal(<?=$idReporte;?>);  
   
  });

	 function ControlGTotal(idReporte){
    $('#TrControlGTotales').load('../../../public/corte-diario/vistas/controlgas-totales.php?idReporte=' + idReporte);
  }
</script>

<div class="table-responsive">
<table class="table table-sm table-bordered mb-0" style="font-size: .9em;">
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

		if ($row_listacontrol['pago'] == 0) {
    		$pago = "";
    	}else{
    		$pago =  number_format($row_listacontrol['pago'], 2, '.', '');
    	}

    	if ($row_listacontrol['consumo'] == 0) {
    		$consumo = "";
    	}else{
    		$consumo =  number_format($row_listacontrol['consumo'], 2, '.', '');
    	}

    ?>

    <tr>
    	<td class="align-middle"><?=$concepto;?></td>
    	<td class="p-0 align-middle">
    		<input id="pago-<?=$idControl;?>" type="number" min="0" step="any" style="border: 0px;width: 100%;padding: 3px;height: 100%; text-align: right;" onkeyup="EditCGPago(this,<?=$idReporte;?>,<?=$idControl;?>)" value="<?=$pago;?>" <?=$estado;?> >
    	</td>
    	<td class="p-0 align-middle">
    		<input id="consumo-<?=$idControl;?>" type="number" min="0" step="any" style="border: 0px;width: 100%;padding: 3px;height: 100%; text-align: right;" onkeyup="EditCGConsumo(this,<?=$idReporte;?>,<?=$idControl;?>)" value="<?=$consumo;?>" <?=$estado;?> >
    	</td>
    </tr>

    <?php
    }

	?>
	<tr id="TrControlGTotales"></tr>

	<tr>
		<td class="p-2" colspan="3"></td>
	</tr>
</tbody>
</table>
</div>