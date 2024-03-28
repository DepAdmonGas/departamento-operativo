<?php
require('../../../app/help.php');
$idReporte = $_GET['idReporte'];
?>


<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0" style="font-size: .8em;">
<thead class="tables-bg">
	<th class="text-center align-middle">PRODUCTO</th>
	<th class="text-center align-middle">LITROS</th>
	<th class="text-center align-middle">JARRAS</th>
	<th class="text-center align-middle">TOTAL LITROS</th>
	<th class="text-center align-middle">PRECIO POR LITRO</th>
	<th class="text-center align-middle">IMPORTE TOTAL</th>
</thead>
<tbody>
	<?php 

	$sql_listayear = "SELECT * FROM op_ventas_dia WHERE idreporte_dia = '".$idReporte."' ";
    $result_listayear = mysqli_query($con, $sql_listayear);
    $numero_reporte = mysqli_num_rows($result_listayear);

    while($row_listayear = mysqli_fetch_array($result_listayear, MYSQLI_ASSOC)){

    	$idventas = $row_listayear['id'];
    	$producto = $row_listayear['producto'];
    	$litrosventas = $row_listayear['litros'];
    	$jarrasventas = $row_listayear['jarras'];
    	$precio_litroventas = $row_listayear['precio_litro'];

    	$litros =  $litrosventas;
    	$jarras = $jarrasventas;
    	$preciolitro = $precio_litroventas;
    	$totalLitros = $litrosventas - $jarrasventas;
        $importeTotal = $totalLitros * $precio_litroventas;

        $SubTLitros = $SubTLitros + $litros;
        $SubJarras = $SubJarras + $jarras;
        $SubTotalLitros = $SubTotalLitros + $totalLitros;
        $SubImporteTotal = $SubImporteTotal + $importeTotal;
    ?>
    	<tr>

    	<td class="p-1 align-middle"> 
            <?=$producto;?>
    	</td>
    	<td class="p-1 align-middle text-end">
    		<?=number_format($litros,2);?>
    	</td>
    	<td class="p-1 align-middle text-end">
    		<?=number_format($jarras,2);?>
    	</td>
    	<td class="p-1  align-middle text-end"><strong><?=number_format($totalLitros, 2);?></strong></td>
    	<td class="p-1 align-middle text-end">
    		<?=number_format($preciolitro,2);?>
    	</td>
    	<td class=" align-middle text-end"><strong><?=number_format($importeTotal, 2);?></strong></td>

    	
    	</tr>
	<?php
    }
	?>
	<tr class="bg-light">
        <td>A SUB-TOTAL (1+2+3)</td>
<td class=" align-middle text-end" id="importetotal-<?=$idventas;?>"><strong><?=number_format($SubTLitros, 2);?></strong></td>
<td class=" align-middle text-end" id="importetotal-<?=$idventas;?>"><strong><?=number_format($SubJarras, 2);?></strong></td>
<td class=" align-middle text-end" id="importetotal-<?=$idventas;?>"><strong><?=number_format($SubTotalLitros, 2);?></strong></td>
<td class=""></td>
<td class=" align-middle text-end" id="importetotal-<?=$idventas;?>"><strong><?=number_format($SubImporteTotal, 2);?></strong></td></tr>
        
	<?php
	$sql_listaotros = "SELECT * FROM op_ventas_dia_otros WHERE idreporte_dia = '".$idReporte."' ";
    $result_listaotros = mysqli_query($con, $sql_listaotros);
    while($row_listaotros = mysqli_fetch_array($result_listaotros, MYSQLI_ASSOC)){

    	$idOtros = $row_listaotros['id'];
    	$concepto = $row_listaotros['concepto'];
    	$piezas = $row_listaotros['piezas'];

    	$importe = $row_listaotros['importe'];

    	if ($concepto == "4 ACEITES Y LUBRICANTES") {
    		$disabled = "disabled";
            $cssaceite = "bg-light text-end";
            
    	}else{
    		$disabled = "";
            $cssaceite = "p-0";
    	}

        $sumImporte = $sumImporte + $importe;
	?>
	<tr>
		<td><?=$concepto;?></td>
		<td class="align-middle text-end"><?=$piezas;?></td>
		<td class="align-middle text-end"></td>
		<td class="align-middle text-end"></td>
		<td class="align-middle text-end"></td>
		<td class="align-middle text-end">
            <?=number_format($importe,2);?>
    	</td>
	</tr>
	<?php  } $totalNeto = $SubImporteTotal + $sumImporte; ?>

	<tr class="bg-light">
     <td class="">B TOTAL (A+4+5+6)</td>
<td class="align-middle text-end" ></td>
<td class="align-middle text-end" ></td>
<td class="align-middle text-end" ></td>
<td class="bg-light"></td>
<td class="align-middle text-end" ><strong><?=number_format($totalNeto, 2);?></strong></td>   
    </tr>
</tbody>
</table>
</div>