<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$GET_year = $_GET['year'];
$GET_mes = $_GET['mes'];

function IdReporte($idEstacion,$GET_year,$GET_mes,$con){
   $sql_year = "SELECT id, id_estacion, year FROM op_corte_year WHERE id_estacion = '".$idEstacion."' AND year = '".$GET_year."' ";
   $result_year = mysqli_query($con, $sql_year);
   while($row_year = mysqli_fetch_array($result_year, MYSQLI_ASSOC)){
   $idyear = $row_year['id'];
   }

   $sql_mes = "SELECT id, id_year, mes FROM op_corte_mes WHERE id_year = '".$idyear."' AND mes = '".$GET_mes."' ";
   $result_mes = mysqli_query($con, $sql_mes);
   while($row_mes = mysqli_fetch_array($result_mes, MYSQLI_ASSOC)){
   $idmes = $row_mes['id'];
   }
   return $idmes;
   }

   $IdReporte = IdReporte($idEstacion,$GET_year,$GET_mes,$con); 

function Detalle($IdReporte,$producto,$embarque,$con){
$sql_lista = "SELECT * FROM op_embarques WHERE id_mes = '".$IdReporte."' AND embarque = '".$embarque."' AND producto = '".$producto."' ORDER BY fecha ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$Total = $Total + $row_lista['importef'];
}

return $Total;
}
 
$GSuperPemex = Detalle($IdReporte,'G SUPER','Pemex',$con);
$GSuperDelivery = Detalle($IdReporte,'G SUPER','Delivery',$con);
$GSuperPickUp = Detalle($IdReporte,'G SUPER','Pick Up',$con);

$Total1 = $GSuperPemex + $GSuperDelivery + $GSuperPickUp;

$GPremiumPemex = Detalle($IdReporte,'G PREMIUM','Pemex',$con);
$GPremiumDelivery = Detalle($IdReporte,'G PREMIUM','Delivery',$con);
$GPremiumPickUp = Detalle($IdReporte,'G PREMIUM','Pick Up',$con);

$Total2 = $GPremiumPemex + $GPremiumDelivery + $GPremiumPickUp; 

$GDieselPemex = Detalle($IdReporte,'G DIESEL','Pemex',$con);
$GDieselDelivery = Detalle($IdReporte,'G DIESEL','Delivery',$con);
$GDieselPickUp = Detalle($IdReporte,'G DIESEL','Pick Up',$con);

$Total3 = $GDieselPemex + $GDieselDelivery + $GDieselPickUp;

$GTPemex = $GSuperPemex + $GPremiumPemex + $GDieselPemex;
$GTDelivery = $GSuperDelivery + $GPremiumDelivery + $GDieselDelivery;
$GTPickUp = $GSuperPickUp + $GPremiumPickUp + $GDieselPickUp;

$GT = $GTPemex + $GTDelivery + $GTPickUp;

$Porcentaje1 = ($Total1/$GT)*100;
$Porcentaje2 = ($Total2/$GT)*100;
$Porcentaje3 = ($Total3/$GT)*100;

$Porcentaje4 = ($GTPemex/$GT)*100;
$Porcentaje5 = ($GTDelivery/$GT)*100;
$Porcentaje6 = ($GTPickUp/$GT)*100;
?>


<div class="cardAG p-3">

<div class="row justify-content-md-center">

<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12"> 

	<div class="table-responsive">
		<table class="table table-bordered table-sm mb-0 text-center" style="font-size: 0.8em;">
<tbody>
	<tr>
		<td></td>
		<td class="font-weight-bold" style="background: #CEEDFB;color: black;">PEMEX</td>
		<td class="font-weight-bold" style="background: #FAFBCE;color: black;">DELIVERY</td>
		<td class="font-weight-bold" style="background: #DEDEDE;">PICK UP</td>
		<td class="font-weight-bold" style="background: #F3F3F3;">TOTAL</td>
		<td class="font-weight-bold">%</td>
	</tr>
	<tr>
		<td class="font-weight-bold" style="background: #76bd1d;color: white;">G SUPER</td>
		<td><?=number_format($GSuperPemex);?></td>
		<td><?=number_format($GSuperDelivery);?></td>
		<td><?=number_format($GSuperPickUp);?></td>
		<td><?=number_format($Total1);?></td>
		<td style="background: #76bd1d;color: white;"><?=number_format($Porcentaje1);?>%</td>
	</tr>

	<tr>
		<td class="font-weight-bold" style="background: #e21683;color: white;">G PREMIUM</td>
		<td><?=number_format($GPremiumPemex);?></td>
		<td><?=number_format($GPremiumDelivery);?></td>
		<td><?=number_format($GPremiumPickUp);?></td>
		<td><?=number_format($Total2);?></td>
		<td style="background: #e21683;color: white;"><?=number_format($Porcentaje2);?>%</td>
	</tr>

	<tr>
		<td class="font-weight-bold" style="background: #5e0f8e;color: white;">G DIESEL</td>
		<td><?=number_format($GDieselPemex);?></td>
		<td><?=number_format($GDieselDelivery);?></td>
		<td><?=number_format($GDieselPickUp);?></td>
		<td><?=number_format($Total3);?></td>
		<td style="background: #5e0f8e;color: white;"><?=number_format($Porcentaje3);?>%</td>
	</tr>

		<tr>
		<td class="font-weight-bold">TOTAL</td>
		<td class="font-weight-bold"><?=number_format($GTPemex);?></td>
		<td class="font-weight-bold"><?=number_format($GTDelivery);?></td>
		<td class="font-weight-bold"><?=number_format($GTPickUp);?></td>
		<td class="font-weight-bold"><?=number_format($GT);?></td>				
		<td></td>
	</tr>
		<tr>
		<td class="font-weight-bold">%</td>
		<td style="background: #CEEDFB;color: black;"><?=number_format($Porcentaje4);?>%</td>
		<td style="background: #FAFBCE;color: black;"><?=number_format($Porcentaje5);?>%</td>
		<td style="background: #DEDEDE;"><?=number_format($Porcentaje6);?>%</td>
		<td class="font-weight-bold" style="background: #F3F3F3;">100%</td>				
		<td></td>
	</tr>
</tbody>
</table>
</div>

	</div>

</div>


</div>
					
