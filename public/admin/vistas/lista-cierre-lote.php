<?php
require('../../../app/help.php');
$idReporte = $_GET['idReporte'];
$empresa = $_GET['empresa'];

if ($empresa != "INBURSA") {
?>

<table class="table table-sm table-bordered pb-0 mb-0" style="font-size: .8em;">
<thead class="tables-bg">
	<th class="text-center">No. Cierre de lote</th>
	<th class="text-center">Importe</th>
	<th class="text-center">No. De ticktes</th>
    <th class="text-center"></th>
</thead>
<tbody>
<?php
$sql_listacierre = "SELECT * FROM op_cierre_lote WHERE idreporte_dia = '".$idReporte."' AND empresa = '".$empresa."' ";
    $result_listacierre = mysqli_query($con, $sql_listacierre);
    while($row_listacierre = mysqli_fetch_array($result_listacierre, MYSQLI_ASSOC)){

    	$idCierre = $row_listacierre['id'];
    	$nocierre = $row_listacierre['no_cierre_lote'];

        $estado = $row_listacierre['estado'];

    	$valimporte =  $row_listacierre['importe'];

    	if ($row_listacierre['ticktes'] == 0) {
    		$noticket = "";
    	}else{
    		$noticket =  $row_listacierre['ticktes'];
    	}

    	$TotalImporte = $TotalImporte + $row_listacierre['importe'];
    	$TotalTicket = $TotalTicket + $row_listacierre['ticktes'];

       
?>
<tr>
	<td class="p-1 align-middle">
    		<?=$nocierre;?>
    	</td>
	<td class="p-1 align-middle text-end">
    		<?=number_format($valimporte,2);?>
    	</td>
	<td class="p-1 align-middle text-center">
    		<?=$noticket;?>
    	</td>
        <td class="p-0 align-middle text-center">
        <?php
        if ($estado == 0) {
        ?>

        <img class="pointer" src="<?=RUTA_IMG_ICONOS;?>info-24-tb.png" onclick="Pendiente('<?=$idReporte;?>','<?=$idCierre;?>','<?=$empresa;?>')">
        <?php
        }else{
        ?>
         <img class="pointer" src="<?=RUTA_IMG_ICONOS;?>info-24-red-tb.png" onclick="Activar('<?=$idReporte;?>','<?=$idCierre;?>','<?=$empresa;?>')">
        <?php
        }
        ?>
        </td>
</tr>
<?php
    }
?>
<tr class="bg-light" id="Total<?=$empresatotal;?>">
	<th class="align-middle text-center">Total</th>
	<td class="align-middle text-end"><b><?=number_format($TotalImporte,2);?></b></td>
	<td class="align-middle text-center"><b><?=$TotalTicket;?></b></td>
    <td></td>
</tr>
</tbody>
</table>
<?php
}else{

$sql_listacierre = "SELECT * FROM op_cierre_lote WHERE idreporte_dia = '".$idReporte."' AND empresa = '".$empresa."' ";
$result_listacierre = mysqli_query($con, $sql_listacierre);
$numero_listacierre = mysqli_num_rows($result_listacierre); 
if ($numero_listacierre > 0) {
?>
<div class="border mt-3">
      <div class="bg-light p-1">
        <strong>INBURSA</strong>
      </div>

<table class="table table-sm table-bordered pb-0 mb-0" style="font-size: .8em;">
<thead class="tables-bg">
    <th class="text-center">No. Cierre de lote</th>
    <th class="text-center">Importe</th>
    <th class="text-center">No. De ticktes</th>
    <th class="text-center"></th>
</thead>
<tbody>
<?php
$sql_listacierre = "SELECT * FROM op_cierre_lote WHERE idreporte_dia = '".$idReporte."' AND empresa = '".$empresa."' ";
    $result_listacierre = mysqli_query($con, $sql_listacierre);
    while($row_listacierre = mysqli_fetch_array($result_listacierre, MYSQLI_ASSOC)){

        $idCierre = $row_listacierre['id'];
        $nocierre = $row_listacierre['no_cierre_lote'];

        $estado = $row_listacierre['estado'];

        $valimporte =  $row_listacierre['importe'];

        if ($row_listacierre['ticktes'] == 0) {
            $noticket = "";
        }else{
            $noticket =  $row_listacierre['ticktes'];
        }

        $TotalImporte = $TotalImporte + $row_listacierre['importe'];
        $TotalTicket = $TotalTicket + $row_listacierre['ticktes'];

       
?>
<tr>
    <td class="p-1 align-middle">
            <?=$nocierre;?>
        </td>
    <td class="p-1 align-middle text-end">
            <?=number_format($valimporte,2);?>
        </td>
    <td class="p-1 align-middle text-center">
            <?=$noticket;?>
        </td>
        <td class="p-0 align-middle text-center">
        <?php
        if ($estado == 0) {
        ?>

        <img class="pointer" src="<?=RUTA_IMG_ICONOS;?>info-24-tb.png" onclick="Pendiente('<?=$idReporte;?>','<?=$idCierre;?>','<?=$empresa;?>')">
        <?php
        }else{
        ?>
         <img class="pointer" src="<?=RUTA_IMG_ICONOS;?>info-24-red-tb.png" onclick="Activar('<?=$idReporte;?>','<?=$idCierre;?>','<?=$empresa;?>')">
        <?php
        }
        ?>
        </td>
</tr>
<?php
    }
?>
<tr class="bg-light" id="Total<?=$empresatotal;?>">
    <th class="align-middle text-center">Total</th>
    <td class="align-middle text-end"><b><?=number_format($TotalImporte,2);?></b></td>
    <td class="align-middle text-center"><b><?=$TotalTicket;?></b></td>
    <td></td>
</tr>
</tbody>
</table>

    </div>
<?php
}

}
?>