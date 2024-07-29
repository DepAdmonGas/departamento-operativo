<?php
require('../../../app/help.php');

	$GET_year = $_GET['year'];
	$GET_mes = $_GET['mes'];

   //---------- REPORTES DE LAS ESTACIONES ----------
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

   $IdReporteInterlomas = IdReporte(1,$GET_year,$GET_mes,$con); 
   $IdReportePaloSolo = IdReporte(2,$GET_year,$GET_mes,$con); 
   $IdReporteSanAgustin = IdReporte(3,$GET_year,$GET_mes,$con);
   $IdReporteGasomira = IdReporte(4,$GET_year,$GET_mes,$con); 
   $IdReporteValleGpe = IdReporte(5,$GET_year,$GET_mes,$con); 
   $IdReporteEsmegas = IdReporte(6,$GET_year,$GET_mes,$con); 
   $IdReporteXochimilco = IdReporte(7,$GET_year,$GET_mes,$con); 
   $IdReporteBosqueReal = IdReporte(14,$GET_year,$GET_mes,$con); 


   //---------- REPORTES DE LAS ESTACIONES ----------

	function Detalle($IdReporte,$producto,$embarque,$con){
	$Total = 0;
	$sql_lista = "SELECT * FROM op_embarques WHERE id_mes = '".$IdReporte."' AND embarque = '".$embarque."' AND producto = '".$producto."' ORDER BY fecha ASC";
	$result_lista = mysqli_query($con, $sql_lista);
	$numero_lista = mysqli_num_rows($result_lista);
	while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
	$Total = $Total + $row_lista['importef'];
	}

	return $Total;
	}

	//---------- PEMEX - GSUPER ----------
	$GSuperPemex1 = Detalle($IdReporteInterlomas,'G SUPER','Pemex',$con);
	$GSuperPemex2 = Detalle($IdReportePaloSolo,'G SUPER','Pemex',$con);
	$GSuperPemex3 = Detalle($IdReporteSanAgustin,'G SUPER','Pemex',$con);
	$GSuperPemex4 = Detalle($IdReporteGasomira,'G SUPER','Pemex',$con);
	$GSuperPemex5 = Detalle($IdReporteValleGpe,'G SUPER','Pemex',$con);
	$GSuperPemex6 = Detalle($IdReporteEsmegas,'G SUPER','Pemex',$con);
	$GSuperPemex7 = Detalle($IdReporteXochimilco,'G SUPER','Pemex',$con);
	$GSuperPemex8 = Detalle($IdReporteBosqueReal,'G SUPER','Pemex',$con);
	$GSuperPemexTotal = $GSuperPemex1 + $GSuperPemex2 + $GSuperPemex3 + $GSuperPemex4 + $GSuperPemex5 + $GSuperPemex6 + $GSuperPemex7 + $GSuperPemex8;

	//---------- DELIVERY - GSUPER ----------
	$GSuperDelivery1 = Detalle($IdReporteInterlomas,'G SUPER','Delivery',$con);
	$GSuperDelivery2 = Detalle($IdReportePaloSolo,'G SUPER','Delivery',$con);
	$GSuperDelivery3 = Detalle($IdReporteSanAgustin,'G SUPER','Delivery',$con);
	$GSuperDelivery4 = Detalle($IdReporteGasomira,'G SUPER','Delivery',$con);
	$GSuperDelivery5 = Detalle($IdReporteValleGpe,'G SUPER','Delivery',$con);
	$GSuperDelivery6 = Detalle($IdReporteEsmegas,'G SUPER','Delivery',$con);
	$GSuperDelivery7 = Detalle($IdReporteXochimilco,'G SUPER','Delivery',$con);
	$GSuperDelivery8 = Detalle($IdReporteBosqueReal,'G SUPER','Delivery',$con);
	$GSuperDeliveryTotal = $GSuperDelivery1 + $GSuperDelivery2 + $GSuperDelivery3 + $GSuperDelivery4 + $GSuperDelivery5 + $GSuperDelivery6 + $GSuperDelivery7 + 
						   $GSuperDelivery8;

	//---------- PICK UP - GSUPER ----------
	$GSuperPickUp1 = Detalle($IdReporteInterlomas,'G SUPER','Pick Up',$con);
	$GSuperPickUp2 = Detalle($IdReportePaloSolo,'G SUPER','Pick Up',$con);
	$GSuperPickUp3 = Detalle($IdReporteSanAgustin,'G SUPER','Pick Up',$con);
	$GSuperPickUp4 = Detalle($IdReporteGasomira,'G SUPER','Pick Up',$con);
	$GSuperPickUp5 = Detalle($IdReporteValleGpe,'G SUPER','Pick Up',$con);
	$GSuperPickUp6 = Detalle($IdReporteEsmegas,'G SUPER','Pick Up',$con);
	$GSuperPickUp7 = Detalle($IdReporteXochimilco,'G SUPER','Pick Up',$con);
	$GSuperPickUp8 = Detalle($IdReporteBosqueReal,'G SUPER','Pick Up',$con);
	$GSuperPickUpTotal = $GSuperPickUp1 + $GSuperPickUp2 + $GSuperPickUp3 + $GSuperPickUp4 + $GSuperPickUp5 + $GSuperPickUp6 + $GSuperPickUp7 + 
						   $GSuperPickUp8;

	$TotalGSuper = $GSuperPemexTotal + $GSuperDeliveryTotal + $GSuperPickUpTotal;

	//----------------------------------------------------------------------------
	//---------- PEMEX - GPREMIUM ----------
	$GPremiumPemex1 = Detalle($IdReporteInterlomas,'G PREMIUM','Pemex',$con);
	$GPremiumPemex2 = Detalle($IdReportePaloSolo,'G PREMIUM','Pemex',$con);
	$GPremiumPemex3 = Detalle($IdReporteSanAgustin,'G PREMIUM','Pemex',$con);
	$GPremiumPemex4 = Detalle($IdReporteGasomira,'G PREMIUM','Pemex',$con);
	$GPremiumPemex5 = Detalle($IdReporteValleGpe,'G PREMIUM','Pemex',$con);
	$GPremiumPemex6 = Detalle($IdReporteEsmegas,'G PREMIUM','Pemex',$con);
	$GPremiumPemex7 = Detalle($IdReporteXochimilco,'G PREMIUM','Pemex',$con);
	$GPremiumPemex8 = Detalle($IdReporteBosqueReal,'G PREMIUM','Pemex',$con);
	$GPremiumPemexTotal = $GPremiumPemex1 + $GPremiumPemex2 + $GPremiumPemex3 + $GPremiumPemex4 + $GPremiumPemex5 + $GPremiumPemex6 + $GPremiumPemex7 + $GPremiumPemex8;

	//---------- DELIVERY - GPREMIUM ----------
	$GPremiumDelivery1 = Detalle($IdReporteInterlomas,'G PREMIUM','Delivery',$con);
	$GPremiumDelivery2 = Detalle($IdReportePaloSolo,'G PREMIUM','Delivery',$con);
	$GPremiumDelivery3 = Detalle($IdReporteSanAgustin,'G PREMIUM','Delivery',$con);
	$GPremiumDelivery4 = Detalle($IdReporteGasomira,'G PREMIUM','Delivery',$con);
	$GPremiumDelivery5 = Detalle($IdReporteValleGpe,'G PREMIUM','Delivery',$con);
	$GPremiumDelivery6 = Detalle($IdReporteEsmegas,'G PREMIUM','Delivery',$con);
	$GPremiumDelivery7 = Detalle($IdReporteXochimilco,'G PREMIUM','Delivery',$con);
	$GPremiumDelivery8 = Detalle($IdReporteBosqueReal,'G PREMIUM','Delivery',$con);
	$GPremiumDeliveryTotal = $GPremiumDelivery1 + $GPremiumDelivery2 + $GPremiumDelivery3 + $GPremiumDelivery4 + $GPremiumDelivery5 + $GPremiumDelivery6 + $GPremiumDelivery7 
					       + $GPremiumDelivery8;

	//---------- PICK UP - GPREMIUM ----------
	$GPremiumPickUp1 = Detalle($IdReporteInterlomas,'G PREMIUM','Pick Up',$con);
	$GPremiumPickUp2 = Detalle($IdReportePaloSolo,'G PREMIUM','Pick Up',$con);
	$GPremiumPickUp3 = Detalle($IdReporteSanAgustin,'G PREMIUM','Pick Up',$con);
	$GPremiumPickUp4 = Detalle($IdReporteGasomira,'G PREMIUM','Pick Up',$con);
	$GPremiumPickUp5 = Detalle($IdReporteValleGpe,'G PREMIUM','Pick Up',$con);
	$GPremiumPickUp6 = Detalle($IdReporteEsmegas,'G PREMIUM','Pick Up',$con);
	$GPremiumPickUp7 = Detalle($IdReporteXochimilco,'G PREMIUM','Pick Up',$con);
	$GPremiumPickUp8 = Detalle($IdReporteBosqueReal,'G PREMIUM','Pick Up',$con);
	$GPremiumPickUpTotal = $GPremiumPickUp1 + $GPremiumPickUp2 + $GPremiumPickUp3 + $GPremiumPickUp4 + $GPremiumPickUp5 + $GPremiumPickUp6 + $GPremiumPickUp7 + 
						   $GPremiumPickUp8;

	$TotalGPremium = $GPremiumPemexTotal + $GPremiumDeliveryTotal + $GPremiumPickUpTotal;

	//----------------------------------------------------------------------------
	//---------- PEMEX - GDIESEL ----------
	$GDieselPemex1 = Detalle($IdReporteInterlomas,'G DIESEL','Pemex',$con);
	$GDieselPemex2 = Detalle($IdReportePaloSolo,'G DIESEL','Pemex',$con);
	$GDieselPemex3 = Detalle($IdReporteSanAgustin,'G DIESEL','Pemex',$con);
	$GDieselPemex4 = Detalle($IdReporteGasomira,'G DIESEL','Pemex',$con);
	$GDieselPemex5 = Detalle($IdReporteValleGpe,'G DIESEL','Pemex',$con);
	$GDieselPemex6 = Detalle($IdReporteEsmegas,'G DIESEL','Pemex',$con);
	$GDieselPemex7 = Detalle($IdReporteXochimilco,'G DIESEL','Pemex',$con);
	$GDieselPemex8 = Detalle($IdReporteBosqueReal,'G DIESEL','Pemex',$con);
	$GDieselPemexTotal = $GDieselPemex1 + $GDieselPemex2 + $GDieselPemex3 + $GDieselPemex4 + $GDieselPemex5 + $GDieselPemex6 + $GDieselPemex7 + $GDieselPemex8;

	//---------- DELIVERY - GDIESEL ----------
	$GDieselDelivery1 = Detalle($IdReporteInterlomas,'G DIESEL','Delivery',$con);
	$GDieselDelivery2 = Detalle($IdReportePaloSolo,'G DIESEL','Delivery',$con);
	$GDieselDelivery3 = Detalle($IdReporteSanAgustin,'G DIESEL','Delivery',$con);
	$GDieselDelivery4 = Detalle($IdReporteGasomira,'G DIESEL','Delivery',$con);
	$GDieselDelivery5 = Detalle($IdReporteValleGpe,'G DIESEL','Delivery',$con);
	$GDieselDelivery6 = Detalle($IdReporteEsmegas,'G DIESEL','Delivery',$con);
	$GDieselDelivery7 = Detalle($IdReporteXochimilco,'G DIESEL','Delivery',$con);
	$GDieselDelivery8 = Detalle($IdReporteBosqueReal,'G DIESEL','Delivery',$con);
	$GDieselDeliveryTotal = $GDieselDelivery1 + $GDieselDelivery2 + $GDieselDelivery3 + $GDieselDelivery4 + $GDieselDelivery5 + $GDieselDelivery6 + $GDieselDelivery7 
					      + $GDieselDelivery8;

	//---------- PICK UP - GPREMIUM ----------
	$GDieselPickUp1 = Detalle($IdReporteInterlomas,'G DIESEL','Pick Up',$con);
	$GDieselPickUp2 = Detalle($IdReportePaloSolo,'G DIESEL','Pick Up',$con);
	$GDieselPickUp3 = Detalle($IdReporteSanAgustin,'G DIESEL','Pick Up',$con);
	$GDieselPickUp4 = Detalle($IdReporteGasomira,'G DIESEL','Pick Up',$con);
	$GDieselPickUp5 = Detalle($IdReporteValleGpe,'G DIESEL','Pick Up',$con);
	$GDieselPickUp6 = Detalle($IdReporteEsmegas,'G DIESEL','Pick Up',$con);
	$GDieselPickUp7 = Detalle($IdReporteXochimilco,'G DIESEL','Pick Up',$con);
	$GDieselPickUp8 = Detalle($IdReporteBosqueReal,'G DIESEL','Pick Up',$con);
	$GDieselPickUpTotal = $GDieselPickUp1 + $GDieselPickUp2 + $GDieselPickUp3 + $GDieselPickUp4 + $GDieselPickUp5 + $GDieselPickUp6 + $GDieselPickUp7 + 
						   $GDieselPickUp8;

	$TotalGDiesel = $GDieselPemexTotal + $GDieselDeliveryTotal + $GDieselPickUpTotal;

	//----------------------------------------------------------------------------
	
	$GTPemex = $GSuperPemexTotal + $GPremiumPemexTotal + $GDieselPemexTotal;
	$GTDelivery = $GSuperDeliveryTotal + $GPremiumDeliveryTotal + $GDieselDeliveryTotal;
	$GTPickUp = $GSuperPickUpTotal + $GPremiumPickUpTotal + $GDieselPickUpTotal;

	$GT = $GTPemex + $GTDelivery + $GTPickUp;

	$Porcentaje1 = ($TotalGSuper/$GT) * 100;
	$Porcentaje2 = ($TotalGPremium/$GT) * 100;
	$Porcentaje3 = ($TotalGDiesel/$GT) * 100;

	$Porcentaje4 = ($GTPemex/$GT) * 100;
	$Porcentaje5 = ($GTDelivery/$GT) * 100;
	$Porcentaje6 = ($GTPickUp/$GT) * 100;
?>


<div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Importación</a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Total General</li>
  </ol>
  </div>

  <div class="row">
  <div class="col-12">
  <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Total General</h3>
  </div>
  </div>

  <hr>
  </div>







<div class="row">

<div class="col-12"> 

<div class="table-responsive">
<table class="custom-table" style="font-size: 0.70em;" width="100%">

<thead class="bg-white">
<tr>
		<th></th>
		<th style="background: #CEEDFB;color: black;">PEMEX</th>
		<th style="background: #FAFBCE;color: black;">DELIVERY</th>
		<th style="background: #DEDEDE;">PICK UP</th>
		<th class="text-dark">TOTAL</th>
		<th>%</th>
	</tr>
</thead>


<tbody class="bg-white">

	<tr>
		<th class="font-weight-bold" style="background: #76bd1d;color: white;">G SUPER</th>
		<td><?=number_format($GSuperPemexTotal);?></td>
		<td><?=number_format($GSuperDeliveryTotal);?></td>
		<td><?=number_format($GSuperPickUpTotal);?></td>
		<td><?=number_format($TotalGSuper);?></td>
		<td style="background: #76bd1d;color: white;"><?=number_format($Porcentaje1);?>%</td>
	</tr>

	<tr>
		<th class="font-weight-bold" style="background: #e21683;color: white;">G PREMIUM</th>
		<td><?=number_format($GPremiumPemexTotal);?></td>
		<td><?=number_format($GPremiumDeliveryTotal);?></td>
		<td><?=number_format($GPremiumPickUpTotal);?></td>
		<td><?=number_format($TotalGPremium);?></td>
		<td style="background: #e21683;color: white;"><?=number_format($Porcentaje2);?>%</td>
	</tr>

	<tr>
		<th class="font-weight-bold" style="background: #5e0f8e;color: white;">G DIESEL</th>
		<td><?=number_format($GDieselPemexTotal);?></td>
		<td><?=number_format($GDieselDeliveryTotal);?></td>
		<td><?=number_format($GDieselPickUpTotal);?></td>
		<td><?=number_format($TotalGDiesel);?></td>
		<td style="background: #5e0f8e;color: white;"><?=number_format($Porcentaje3);?>%</td>
	</tr>

		<tr>
		<th class="font-weight-bold">TOTAL</th>
		<td class="font-weight-bold"><?=number_format($GTPemex);?></td>
		<td class="font-weight-bold"><?=number_format($GTDelivery);?></td>
		<td class="font-weight-bold"><?=number_format($GTPickUp);?></td>
		<td class="font-weight-bold"><?=number_format($GT);?></td>				
		<td></td>
	</tr>
		<tr>
		<th class="font-weight-bold">%</th>
		<td style="background: #CEEDFB;color: black;"><?=number_format($Porcentaje4);?>%</td>
		<td style="background: #FAFBCE;color: black;"><?=number_format($Porcentaje5);?>%</td>
		<td style="background: #DEDEDE;"><?=number_format($Porcentaje6);?>%</td>
		<td class="fw-bold text-dark">100%</td>				
		<td></td>
	</tr>
</tbody>
</table>
</div>

	</div>

</div>


