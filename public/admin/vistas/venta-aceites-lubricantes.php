<?php
require('../../../app/help.php');
$idReporte = $_GET['idReporte'];
?>


<div class="table-responsive">

<table class="table table-sm table-bordered table-striped mb-0" style="font-size: .8em;">
<thead class="tables-bg">
	<th colspan="2" class="align-middle text-center">CONCEPTO</th>
	<th class="align-middle text-center">CANTDAD</th>
	<th class="align-middle text-center">PRECIO UNITARIO</th>
	<th class="align-middle text-center">IMPORTE</th>
</thead>
<tbody>
	<?php

	$sql_listaaceites = "SELECT * FROM op_aceites_lubricantes WHERE idreporte_dia = '".$idReporte."' ";
    $result_listaaceites = mysqli_query($con, $sql_listaaceites);
    while($row_listaaceites = mysqli_fetch_array($result_listaaceites, MYSQLI_ASSOC)){

		$idAceite = $row_listaaceites['id'];
		$numAceite = $row_listaaceites['id_aceite'];
		$concepto = $row_listaaceites['concepto'];
		

		if ($row_listaaceites['cantidad'] == 0) {
    		$cantidad = "";
    	}else{
    		$cantidad =  $row_listaaceites['cantidad'];
    	}

    	if ($row_listaaceites['precio_unitario'] == 0) {
    		$precio = "";
    	}else{
    		$precio =  number_format($row_listaaceites['precio_unitario'], 2, '.', '');
    	}

    $importe = $row_listaaceites['cantidad'] * $row_listaaceites['precio_unitario'];

    $totalCantidad = $totalCantidad + $row_listaaceites['cantidad'];
    $totalPrecio = $totalPrecio + $importe;
    ?>

    <tr>
    	<td class="align-middle"><?=$numAceite;?></td>
    	<td class="align-middle"><?=$concepto;?></td>
    	<td class="p-0 align-middle text-center">
    		<?=$cantidad;?>
    	</td>
    	<td class="align-middle text-end" id="precioAL-<?=$idAceite;?>">
    		<?=$precio;?>
    	</td>
    	<td class="align-middle text-end" id="importeAL-<?=$idAceite;?>"><?=number_format($importe,2);?></td>
    </tr>

    <?php
    }

	?>
	<tr>
      <td class="bg-light text-center"></td>
    <td class="bg-light text-center"></td>
    <td class="bg-light align-middle text-center"><strong><?=$totalCantidad;?></strong></td>
    <td class="bg-light align-middle text-end"></td>
    <td class="bg-light align-middle text-end"><strong><?=number_format($totalPrecio,2);?></strong></td>   
    </tr>
</tbody>
</table>
</div>
