<?php
require('../../../app/help.php');

    $idReporte = $_GET['idReporte'];

	$sql_listayear = "SELECT * FROM op_ventas_dia WHERE idreporte_dia = '".$idReporte."' ";
    $result_listayear = mysqli_query($con, $sql_listayear);
	$SubImporteTotal = 0;
	$SubTLitros = 0;
	$SubJarras = 0;
	$SubTotalLitros = 0;
    while($row_listayear = mysqli_fetch_array($result_listayear, MYSQLI_ASSOC)){

    	$idventas = $row_listayear['id'];
    	$producto = $row_listayear['producto'];
    	$litrosventas = $row_listayear['litros'];
    	$jarrasventas = $row_listayear['jarras'];
    	$precio_litroventas = $row_listayear['precio_litro'];

		$litros = 0;
		$jarras = 0;
		$preciolitro = 0;

    	if ($litrosventas != 0) {
    		$litros =  $litrosventas;
    	}

    	if ($jarrasventas != 0) {
    		$jarras = $jarrasventas;
    	}

    	if ($precio_litroventas != 0) {
    		$preciolitro = $precio_litroventas;
    	}

    	$totalLitros = $litrosventas - $jarrasventas;
    	$importeTotal = $totalLitros * $precio_litroventas;

		$SubTLitros = $SubTLitros + $litros;
		$SubJarras = $SubJarras + $jarras;
		$SubTotalLitros = $SubTotalLitros + $totalLitros;
		$SubImporteTotal = $SubImporteTotal + $importeTotal;
    }

    $sql_listaotros = "SELECT * FROM op_ventas_dia_otros WHERE idreporte_dia = '".$idReporte."' ";
    $result_listaotros = mysqli_query($con, $sql_listaotros);
    $sumImporte = 0;
	while($row_listaotros = mysqli_fetch_array($result_listaotros, MYSQLI_ASSOC)){

   	$importe = $row_listaotros['importe'];

    $sumImporte = $sumImporte + $importe;

    }

 

    $totalNeto = $SubImporteTotal + $sumImporte;
?>
<td class="">B TOTAL (A+4+5+6)</td>
<td class="align-middle text-end bg-light" ></td>
<td class="align-middle text-end bg-light" ></td>
<td class="align-middle text-end bg-light" ></td>
<td class="bg-light"></td>
<td class="align-middle text-end bg-light" ><strong><?=number_format($totalNeto, 2);?></strong></td>
