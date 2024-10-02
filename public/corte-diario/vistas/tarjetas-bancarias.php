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

  TarjetasTotal(<?=$idReporte;?>);  
   
  });

	 function TarjetasTotal(idReporte){
    $('#TrTCBTotales').load('../../../public/corte-diario/vistas/tarjetas-bancarias-totales.php?idReporte=' + idReporte);
  }
  
</script>

<div class="table-responsive">
<table class="table table-sm table-bordered mb-0" style="font-size: .9em;">
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

      $baucher = 0;
    	if ($row_listatarjetas['baucher'] != 0) {
    		$baucher =  number_format($row_listatarjetas['baucher'], 2, '.', '');
    	}
    ?>

    <tr>
      <td class="align-middle text-center"><b><?=$num;?></b></td>
    	<td class="align-middle"><?=$conceptoTarjeta;?></td>
        
        <?php

        if ($conceptoTarjeta == "TICKETCARD" || 
            $conceptoTarjeta == "G500 FLETT" ||
            $conceptoTarjeta == "G500 FLETT" ||
            $conceptoTarjeta == "EFECTICARD" ||
            $conceptoTarjeta == "SODEXO" || 
            $conceptoTarjeta == "AMERICAN EXPRESS" ||
            $conceptoTarjeta == "BBVA BANCOMER SA" ||
            $conceptoTarjeta == "INBURGAS" ||
            $conceptoTarjeta == "ULTRAGAS" ||
            $conceptoTarjeta == "ENERGEX" ||
            $conceptoTarjeta == "INBURSA") {
            echo "<td class='p-0 align-middle text-end bg-light'>".number_format($baucher,2)."</td>";
        }else{
           ?>
           <td class="p-0 align-middle text-end">
            <input id="baucher-<?=$idTarjeta;?>" type="number" min="0" step="any" style="border: 0px;width: 100%;padding: 3px;height: 100%; text-align: right;" onkeyup="EditTBaucher(this,<?=$idReporte;?>,<?=$idTarjeta;?>)" value="<?=$baucher;?>" <?=$estado;?>>
           </td>
            <?php    
            }
        ?>
    
    </tr>

    <?php
    }

	?>
	<tr id="TrTCBTotales"></tr>
</tbody>
</table>
</div>