<?php
require('../../../app/help.php');

    $idReporte = $_GET['idReporte'];

$sql_listaprosegur = "SELECT * FROM op_prosegur WHERE idreporte_dia = '".$idReporte."' ";
    $result_listaprosegur = mysqli_query($con, $sql_listaprosegur);
    while($row_listaprosegur = mysqli_fetch_array($result_listaprosegur, MYSQLI_ASSOC)){
    $importe = $row_listaprosegur['importe'];

    $totalImporte = $totalImporte + $importe;
    }

    $sql_listatarjetas = "SELECT * FROM op_tarjetas_c_b WHERE idreporte_dia = '".$idReporte."' ";
    $result_listatarjetas = mysqli_query($con, $sql_listatarjetas);
    while($row_listatarjetas = mysqli_fetch_array($result_listatarjetas, MYSQLI_ASSOC)){
    
    $baucherTotal = $baucherTotal + $row_listatarjetas['baucher'];
    }

    $sql_listacontrol = "SELECT * FROM op_clientes_controlgas WHERE idreporte_dia = '".$idReporte."' ";
    $result_listacontrol = mysqli_query($con, $sql_listacontrol);
    while($row_listacontrol = mysqli_fetch_array($result_listacontrol, MYSQLI_ASSOC)){

    $pagos = $pagos + $row_listacontrol['pago'];
    $consumo = $consumo + $row_listacontrol['consumo'];
    
    }

    $sql_listayear = "SELECT * FROM op_ventas_dia WHERE idreporte_dia = '".$idReporte."' ";
    $result_listayear = mysqli_query($con, $sql_listayear);
    while($row_listayear = mysqli_fetch_array($result_listayear, MYSQLI_ASSOC)){

    	$idventas = $row_listayear['id'];
    	$producto = $row_listayear['producto'];
    	$litrosventas = $row_listayear['litros'];
    	$jarrasventas = $row_listayear['jarras'];
    	$precio_litroventas = $row_listayear['precio_litro'];

 

    	if ($litrosventas == 0) {
    		$litros = "";
    	}else{
    		$litros =  $litrosventas;
    	}

    	if ($jarrasventas == 0) {
    		$jarras = "";
    	}else{
    		$jarras = $jarrasventas;
    	}

    	if ($precio_litroventas == 0) {
    		$preciolitro = "";
    	}else{
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
    while($row_listaotros = mysqli_fetch_array($result_listaotros, MYSQLI_ASSOC)){

   $importe = $row_listaotros['importe'];

    $sumImporte = $sumImporte + $importe;

    }

 

    $totalNeto = $SubImporteTotal + $sumImporte;

    $CTotal = $totalImporte + $baucherTotal + $consumo;

    echo "<strong>".number_format($CTotal - $totalNeto,2)."</strong>";

//------------------
mysqli_close($con);
//------------------