<?php
require('../../../app/help.php');
$idReporte = $_GET['idReporte'];
$empresa = $_GET['empresa'];

$empresatotal = str_replace(' ', '', $empresa);

 $sql_dia = "SELECT tpv FROM op_corte_dia WHERE id = '".$idReporte."' ";
   $result_dia = mysqli_query($con, $sql_dia);
   while($row_dia = mysqli_fetch_array($result_dia, MYSQLI_ASSOC)){
   $tpv = $row_dia['tpv'];  

    if ($tpv == 1) {
   $disabled = "disabled";
   }else{
    $disabled = "";
   } 

   }

?>
<script type="text/javascript">


	 function TotalCierre(idReporte,empresa){ 

      var empresatotal = empresa.replace(/ /g, "");

         var parametros = {
    "idReporte" : idReporte,
    "empresa" : empresa
    };

   $.ajax({
     data:  parametros,
     url:   '../../../public/corte-diario/vistas/cierre-lotes-totales.php',
     type:  'get',
     beforeSend: function() {
     },
     complete: function(){

     },
     success:  function (response) {

      $('#Total' + empresatotal).html(response);

     }
     });
  }
</script>

<div class="table-responsive">

<table class="table table-sm table-bordered pb-0 mb-0" style="font-size: .9em;">
<thead class="tables-bg">
	<th class="text-center align-middle">No. Cierre de lote</th>
	<th class="text-center align-middle">Importe</th>
	<th class="text-center align-middle">No. De ticktes</th>
    <th class="text-center"></th>
</thead>
<tbody>
<?php
$sql_listacierre = "SELECT * FROM op_cierre_lote WHERE idreporte_dia = '".$idReporte."' AND empresa = '".$empresa."' ";
    $result_listacierre = mysqli_query($con, $sql_listacierre);
    $TotalImporte = 0;
    $TotalTicket = 0;
    while($row_listacierre = mysqli_fetch_array($result_listacierre, MYSQLI_ASSOC)){

    	$idCierre = $row_listacierre['id'];
    	$nocierre = $row_listacierre['no_cierre_lote'];

        $estado = $row_listacierre['estado'];

    	if ($row_listacierre['importe'] == 0) {
    		$valimporte = "";
    	}else{
    		$valimporte =  number_format($row_listacierre['importe'], 2, '.', '');
    	}

    	if ($row_listacierre['ticktes'] == 0) {
    		$noticket = "";
    	}else{
    		$noticket =  $row_listacierre['ticktes'];
    	}

    	$TotalImporte = $TotalImporte + $row_listacierre['importe'];
    	$TotalTicket = $TotalTicket + $row_listacierre['ticktes'];

       
?>
<tr>
	<td class="p-0 align-middle">
    		<input id="nocierre-<?=$idCierre;?>" type="text" style="border: 0px;width: 100%;padding: 3px;height: 100%; text-align: left;" onkeyup="EditNoCierre(this,<?=$idReporte;?>,<?=$idCierre;?>,'<?=$empresa;?>')" value="<?=$nocierre;?>" <?=$disabled;?>>
    	</td>
	<td class="p-0 align-middle">
    		<input id="importe-<?=$idCierre;?>" type="number" min="0" step="any" style="border: 0px;width: 100%;padding: 3px;height: 100%; text-align: right;" onkeyup="EditImporte(this,<?=$idReporte;?>,<?=$idCierre;?>,'<?=$empresa;?>')" value="<?=$valimporte;?>" <?=$disabled;?>>
    	</td>
	<td class="p-0 align-middle">
    		<input id="noticket-<?=$idCierre;?>" type="number" min="0" style="border: 0px;width: 100%;padding: 3px;height: 100%; text-align: center;" onkeyup="EditNoTicket(this,<?=$idReporte;?>,<?=$idCierre;?>,'<?=$empresa;?>')" value="<?=$noticket;?>" <?=$disabled;?> >
    	</td>
        <td class="p-0 align-middle text-center">
        <?php
        if ($estado == 0) {
        ?>

        <img class="pointer" src="<?=RUTA_IMG_ICONOS;?>info-24-tb.png" onclick="Pendiente('<?=$idReporte;?>','<?=$idCierre;?>','<?=$empresa;?>',1)">
        <?php
        }else{
        ?>
         <img class="pointer" src="<?=RUTA_IMG_ICONOS;?>info-24-red-tb.png" onclick="Pendiente('<?=$idReporte;?>','<?=$idCierre;?>','<?=$empresa;?>',0)">
        <?php
        }
        ?>
        </td>
</tr>
<?php
    }
?>
<tr id="Total<?=$empresatotal;?>">
	<td class="align-middle text-center">Total</td>
	<td class="align-middle text-end"><b><?=number_format($TotalImporte,2);?></b></td>
	<td class="align-middle text-center"><b><?=$TotalTicket;?></b></td>
    <td></td>
</tr>
</tbody>
</table>

</div>