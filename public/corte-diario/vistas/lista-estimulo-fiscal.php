<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];

$FInicio = $_GET['FechaInicio'];
$FTermino = $_GET['FechaTermino'];

$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
}

function TotalProducto($idEstacion,$FInicio,$FTermino,$Producto,$con){

$sql_listaestacion = "SELECT 
SUM(re_reporte_cre_pipas.volumen) AS TotalProducto
FROM re_reporte_cre_mes 
INNER JOIN re_reporte_cre_producto
ON re_reporte_cre_mes.id = re_reporte_cre_producto.id_re_mes
INNER JOIN re_reporte_cre_pipas 
ON re_reporte_cre_producto.id = re_reporte_cre_pipas.id_re_producto
WHERE re_reporte_cre_mes.id_estacion = '".$idEstacion."' AND 
re_reporte_cre_producto.producto = '".$Producto."' AND
re_reporte_cre_producto.fecha BETWEEN '".$FInicio."' AND '".$FTermino."' LIMIT 1
 ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$TotalProducto = $row_listaestacion['TotalProducto'];
}

return $TotalProducto;

}
 
$PSUPER = TotalProducto($idEstacion,$FInicio,$FTermino,'G SUPER',$con);
$PPREMIUM = TotalProducto($idEstacion,$FInicio,$FTermino,'G PREMIUM',$con);
$PDIESEL = TotalProducto($idEstacion,$FInicio,$FTermino,'G DIESEL',$con);

$Total = $PSUPER + $PPREMIUM + $PDIESEL;
$totalPesos = $Total * 0.02;
?>




<div class="border p-3 mb-3">
<div class="row">

<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
<h6>Fecha inicio</h6>
<input type="date" class="form-control" id="FInicio">
</div>

<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
<h6>Fecha termino</h6>
<input type="date" class="form-control" id="FTermino">
</div>

<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
<button type="button" class="btn btn-primary" style="margin-top: 29px;" onclick="BuscarReporte(<?=$idEstacion;?>)">Buscar Reporte</button>
</div>
</div>
</div> 

<div class="border p-3 mb-3">

<h5>Fecha</h5>
<h6><?=FormatoFecha($FInicio);?> al día <?=FormatoFecha($FTermino);?></h6>
<hr>

<div class="table-responsive">
<table class="table table-sm table-bordered mb-0">
<thead>
<tr>
<th class="align-middle text-center text-white" style="background: #78bd24">G SUPER</th>
<th class="align-middle text-center text-white" style="background: #e01483">G PREMIUM</th>
<th class="align-middle text-center text-white" style="background: #5e0f8e">G DIESEL</th>
</tr>	
</thead>
<tbody>
<tr>
<td class="p-1"><b><?=number_format($PSUPER);?></b></td>
<td class="p-1"><b><?=number_format($PPREMIUM);?></b></td>
<td class="p-1"><b><?=number_format($PDIESEL);?></b></td>
</tr>
<tr>
	<td colspan="3" class="p-2"></td>
</tr>
<tr>
	<td colspan="2" class="text-end">TOTAL DE LITROS COMPRADOS</td>
	<td class="text-end bg-light"><b><?=number_format($Total);?></b></td>
</tr>
<tr>
	<td colspan="2" class="text-end">TOTAL A PAGAR</td>
	<td class="text-end bg-light"><b>$ <?=number_format($totalPesos,2);?></b></td>
</tr>
</tbody>
</table>
</div>

</div>









