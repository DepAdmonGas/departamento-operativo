<?php
require_once '../../../dompdf/autoload.inc.php';
require('../../../app/help.php');

$idReporte = $_GET['dia_reporte'];

function ConcentradoVentas($idReporte,$con){

$sql_listayear = "SELECT * FROM op_ventas_dia WHERE idreporte_dia = '".$idReporte."' ";
$result_listayear = mysqli_query($con, $sql_listayear);
$numero_reporte = mysqli_num_rows($result_listayear);
$resultado = '';
$resultado .= '<table class="table table-sm table-bordered pb-0 mb-0">
<thead>
	<tr>
	<th class="text-center align-middle">PRODUCTO</th>
	<th class="text-center align-middle">LITROS</th>
	<th class="text-center align-middle">JARRAS</th>
	<th class="text-center align-middle">TOTAL LITROS</th>
	<th class="text-center align-middle">PRECIO POR LITRO</th>
	<th class="text-center align-middle">IMPORTE TOTAL</th>
	</tr>
</thead>
<tbody>';
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

$resultado .= '<tr>';
$resultado .= '<td class="p-1 align-middle">'.$producto.'</td>';
$resultado .= '<td class="p-1 align-middle text-right">'.number_format($litros,2).'</td>';
$resultado .= '<td class="p-1 align-middle text-right">'.number_format($jarras,2).'</td>';
$resultado .= '<td class="p-1  align-middle text-right"><strong>'.number_format($totalLitros, 2).'</strong></td>';
$resultado .= '<td class="p-1 align-middle text-right">'.number_format($preciolitro,2).'</td>';
$resultado .= '<td class="align-middle text-right"><strong>'.number_format($importeTotal, 2).'</strong></td>';
$resultado .= '</tr>';
}

$resultado .= '<tr class="bg-light">
<td>A SUB-TOTAL (1+2+3)</td>
<td class=" align-middle text-right"><strong>'.number_format($SubTLitros, 2).'</strong></td>
<td class=" align-middle text-right"><strong>'.number_format($SubJarras, 2).'</strong></td>
<td class=" align-middle text-right"><strong>'.number_format($SubTotalLitros, 2).'</strong></td>
<td class=""></td>
<td class=" align-middle text-right"><strong>'.number_format($SubImporteTotal, 2).'</strong></td></tr>';

$sql_listaotros = "SELECT * FROM op_ventas_dia_otros WHERE idreporte_dia = '".$idReporte."' ";
    $result_listaotros = mysqli_query($con, $sql_listaotros);
    while($row_listaotros = mysqli_fetch_array($result_listaotros, MYSQLI_ASSOC)){

    	$idOtros = $row_listaotros['id'];
    	$concepto = $row_listaotros['concepto'];
    	$piezas = $row_listaotros['piezas'];

    	$importe = $row_listaotros['importe'];

    	if ($concepto == "4 ACEITES Y LUBRICANTES") {
    		$disabled = "disabled";
            $cssaceite = "bg-light text-right";
            
    	}else{
    		$disabled = "";
            $cssaceite = "p-0";
    	}

        $sumImporte = $sumImporte + $importe;

$resultado .= '<tr>
		<td>'.$concepto.'</td>
		<td class="align-middle text-right">'.$piezas.'</td>
		<td class="align-middle text-right"></td>
		<td class="align-middle text-right"></td>
		<td class="align-middle text-right"></td>
		<td class="align-middle text-right">
           '.number_format($importe,2).'
    	</td>
	</tr>';

        }

$totalNeto = $SubImporteTotal + $sumImporte;

$resultado .= '<tr class="bg-light">
<td class="">B TOTAL (A+4+5+6)</td>
<td class="align-middle text-right" ></td>
<td class="align-middle text-right" ></td>
<td class="align-middle text-right" ></td>
<td class="bg-light"></td>
<td class="align-middle text-right" ><strong>'.number_format($totalNeto, 2).'</strong></td>   
    </tr>';

$resultado .= '</tbody>
</table>';

	return $resultado;
}

//-------------------------------------------------------------------------

function VentaAceitesLubricantes($idReporte,$con){

$resultado .= '<table class="table table-sm table-bordered table-striped pb-0 mb-0" style="font-size: .8em;">
<thead>
<tr>
	<th colspan="2" class="align-middle text-center">CONCEPTO</th>
	<th class="align-middle text-center">CANTDAD</th>
	<th class="align-middle text-center">PRECIO UNITARIO</th>
	<th class="align-middle text-center">IMPORTE</th>
</tr>
</thead>
<tbody>';

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

 $resultado .= '<tr>
    	<td class="align-middle">'.$numAceite.'</td>
    	<td class="align-middle">'.$concepto.'</td>
    	<td class="p-0 align-middle text-center">
    		'.$cantidad.'
    	</td>
    	<td class="align-middle text-right">
    		'.$precio.'
    	</td>
    	<td class="align-middle text-right">'.number_format($importe,2).'</td>
    </tr>';

    }

$resultado .= '<tr>
      <td class="bg-light text-center"></td>
    <td class="bg-light text-center"></td>
    <td class="bg-light align-middle text-center"><strong>'.$totalCantidad.'</strong></td>
    <td class="bg-light align-middle text-right"></td>
    <td class="bg-light align-middle text-right"><strong>'.number_format($totalPrecio,2).'</strong></td>   
    </tr>';


$resultado .= '</tbody>
</table>';

return $resultado;	
}
//-------------------------------------------------------------------------

function Prosegur($idReporte,$con){

$resultado .= '<table class="table table-sm table-bordered pb-0 mb-0">
<thead>
<tr>
	<th class="text-center">DENOMINACION</th>
	<th class="text-center">RECIBO</th>
	<th class="text-center">IMPORTE</th>
</tr>
</thead>
<tbody>';

	$sql_listaprosegur = "SELECT * FROM op_prosegur WHERE idreporte_dia = '".$idReporte."' ";
    $result_listaprosegur = mysqli_query($con, $sql_listaprosegur);
    while($row_listaprosegur = mysqli_fetch_array($result_listaprosegur, MYSQLI_ASSOC)){

		$idProsegur = $row_listaprosegur['id'];
		$denominacion = $row_listaprosegur['denominacion'];
		$recibo = $row_listaprosegur['recibo'];

		$valimporte =  $row_listaprosegur['importe'];

        $importe = $row_listaprosegur['importe'];

    $totalImporte = $totalImporte + $importe;

$resultado .= '<tr>
    	<td class="align-middle">'.$denominacion.'</td>
    	<td class="p-0 align-middle">
    	'.$recibo.'
    	</td>
    	<td class="p-0 align-middle text-right">
    	'.number_format($valimporte,2).'
    	</td>
    </tr>';

   
    }


$resultado .= '<tr>
    <td class="bg-light text-center" colspan="2">TOTAL 1</td>
    <td class="bg-light align-middle text-right"><strong>'.number_format($totalImporte,2).'</strong></td>
    </tr>
</tbody>
</table>';

return $resultado;	
}

//---------------------------------------------------

function MonederosBancos($idReporte,$con){

$resultado .= '<table class="table table-sm table-bordered pb-0 mb-0">
<thead>
<tr>
	<th class="text-center" colspan="2">CONCEPTO / BANCO</th>
	<th class="text-center">IMPORTE</th>
</tr>
</thead>
<tbody>';


	$sql_listatarjetas = "SELECT * FROM op_tarjetas_c_b WHERE idreporte_dia = '".$idReporte."' ";
    $result_listatarjetas = mysqli_query($con, $sql_listatarjetas);
    while($row_listatarjetas = mysqli_fetch_array($result_listatarjetas, MYSQLI_ASSOC)){

		$idTarjeta = $row_listatarjetas['id'];
        $num = $row_listatarjetas['num'];
		$conceptoTarjeta = $row_listatarjetas['concepto'];
    	$baucher =  $row_listatarjetas['baucher'];
        $baucherTotal = $baucherTotal + $baucher;


$resultado .= '<tr>
        <td class="align-middle"><b>'.$num.'</b></td>
    	<td class="align-middle">'.$conceptoTarjeta.'</td>        
           <td class="p-1 align-middle text-right">
           '.number_format($baucher,2).'
           </td> 
    </tr>';
    }
$resultado .= '<tr>
    <td class="bg-light text-center" colspan="2">TOTAL 2</td>
    <td class="bg-light align-middle text-right"><strong>'.number_format($baucherTotal,2).'</strong></td>   
    </tr>
</tbody>
</table>';

return $resultado;	
}
//-------------------------------------------

function ClientesAtio($idReporte,$con){

$resultado .= '<table class="table table-sm table-bordered pb-0 mb-0">
<thead>
<tr>
	<th class="text-center">CONCEPTO</th>
	<th class="text-center">PAGOS</th>
	<th class="text-center">CONSUMOS</th>
	</tr>
</thead>
<tbody>';


	$sql_listacontrol = "SELECT * FROM op_clientes_controlgas WHERE idreporte_dia = '".$idReporte."' ";
    $result_listacontrol = mysqli_query($con, $sql_listacontrol);
    while($row_listacontrol = mysqli_fetch_array($result_listacontrol, MYSQLI_ASSOC)){

	$idControl = $row_listacontrol['id'];
	$concepto = $row_listacontrol['concepto'];
    $pago =  $row_listacontrol['pago'];
    $consumo =  $row_listacontrol['consumo'];

    $Topago = $Topago + $pago;
    $Toconsumo = $Toconsumo + $consumo;

$resultado .= '<tr>
    	<td class="align-middle">'.$concepto.'</td>
    	<td class="p-1 align-middle text-right">
    	'.number_format($pago,2).'
    	</td>
    	<td class="p-1 align-middle text-right">
    	'.number_format($consumo,2).'
    	</td>
    </tr>';

    }

$resultado .= '<tr>
    <td class="bg-light text-center">TOTAL 3</td>
    <td class="bg-light align-middle text-right"><strong>'.number_format($Topago,2).'</strong></td>
    <td class="bg-light align-middle text-right"><strong>'.number_format($Toconsumo,2).'</strong></td>   
    </tr>
</tbody>
</table>';

return $resultado;	
}

//-----------------------------------------------------------

function Total1234($idReporte,$con){


    $sql_listaprosegur = "SELECT importe FROM op_prosegur WHERE idreporte_dia = '".$idReporte."' ";
    $result_listaprosegur = mysqli_query($con, $sql_listaprosegur);
    while($row_listaprosegur = mysqli_fetch_array($result_listaprosegur, MYSQLI_ASSOC)){
    $importe = $row_listaprosegur['importe'];

    $totalImporte = $totalImporte + $importe;
    }

    $sql_listatarjetas = "SELECT baucher FROM op_tarjetas_c_b WHERE idreporte_dia = '".$idReporte."' ";
    $result_listatarjetas = mysqli_query($con, $sql_listatarjetas);
    while($row_listatarjetas = mysqli_fetch_array($result_listatarjetas, MYSQLI_ASSOC)){
    
    $baucherTotal = $baucherTotal + $row_listatarjetas['baucher'];
    }

    $sql_listacontrol = "SELECT consumo FROM op_clientes_controlgas WHERE idreporte_dia = '".$idReporte."' ";
    $result_listacontrol = mysqli_query($con, $sql_listacontrol);
    while($row_listacontrol = mysqli_fetch_array($result_listacontrol, MYSQLI_ASSOC)){

    $consumo = $consumo + $row_listacontrol['consumo'];
    
    }

    $resultado = "<strong>".number_format($totalImporte + $baucherTotal + $consumo,2)."</strong>";

	return $resultado;
}

//------------------------------------------------------------

function DiferenciaTotal($idReporte,$con){

	$sql_listaprosegur = "SELECT importe FROM op_prosegur WHERE idreporte_dia = '".$idReporte."' ";
    $result_listaprosegur = mysqli_query($con, $sql_listaprosegur);
    while($row_listaprosegur = mysqli_fetch_array($result_listaprosegur, MYSQLI_ASSOC)){
    $importe = $row_listaprosegur['importe'];

    $totalImporte = $totalImporte + $importe;
    }

    $sql_listatarjetas = "SELECT baucher FROM op_tarjetas_c_b WHERE idreporte_dia = '".$idReporte."' ";
    $result_listatarjetas = mysqli_query($con, $sql_listatarjetas);
    while($row_listatarjetas = mysqli_fetch_array($result_listatarjetas, MYSQLI_ASSOC)){
    
    $baucherTotal = $baucherTotal + $row_listatarjetas['baucher'];
    }

    $sql_listacontrol = "SELECT pago,consumo FROM op_clientes_controlgas WHERE idreporte_dia = '".$idReporte."' ";
    $result_listacontrol = mysqli_query($con, $sql_listacontrol);
    while($row_listacontrol = mysqli_fetch_array($result_listacontrol, MYSQLI_ASSOC)){

    $pagos = $pagos + $row_listacontrol['pago'];
    $consumo = $consumo + $row_listacontrol['consumo'];
    
    }

    $sql_listayear = "SELECT id,producto,litros,jarras,precio_litro FROM op_ventas_dia WHERE idreporte_dia = '".$idReporte."' ";
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

    $sql_listaotros = "SELECT importe FROM op_ventas_dia_otros WHERE idreporte_dia = '".$idReporte."' ";
    $result_listaotros = mysqli_query($con, $sql_listaotros);
    while($row_listaotros = mysqli_fetch_array($result_listaotros, MYSQLI_ASSOC)){

   $importe = $row_listaotros['importe'];

    $sumImporte = $sumImporte + $importe;

    }

 

    $totalNeto = $SubImporteTotal + $sumImporte;

    $CTotal = $totalImporte + $baucherTotal + $consumo;

    $resultado = "<strong>".number_format($CTotal - $totalNeto,2)."</strong>";

    return $resultado;
}
//-------------------------------------------------------

function PagoClientes($idReporte,$con){

$resultado .= '<table class="table table-sm table-bordered pb-0 mb-0">
<thead>
<tr>
	<th class="text-center">CONCEPTO</th>
	<th class="text-center">IMPORTE</th>
	<th class="text-center">NOTA</th>
	</tr>
</thead>
<tbody>';

	$sql_listaclientes = "SELECT id,concepto,nota,importe FROM op_pago_clientes WHERE idreporte_dia = '".$idReporte."' ";
    $result_listaclientes = mysqli_query($con, $sql_listaclientes);
    while($row_listaclientes = mysqli_fetch_array($result_listaclientes, MYSQLI_ASSOC)){

		$idPagoCliente = $row_listaclientes['id'];
		$concepto = $row_listaclientes['concepto'];
		$nota = $row_listaclientes['nota'];

		
    	$importe = $row_listaclientes['importe'];

        $totalImporte = $totalImporte + $importe;



$resultado .= '<tr>
    	<td class="align-middle">'.$concepto.'</td>
    	<td class="p-1 align-middle text-right">
    	'.number_format($importe,2).'
    	</td>
    	<td class="p-1 align-middle">
    	'.$nota.'
    	</td>
    </tr>';

    }


$resultado .= '<tr>
      <td class="bg-light text-center">TOTAL 4</td>
    <td class="bg-light align-middle text-right"><strong>'.number_format($totalImporte,2).'</strong></td>
    <td class="bg-light align-middle text-right"></td>   
    </tr>
</tbody>
</table>';

	return $resultado;
}
//-----------------------------------------------------
function DiferenciaPC($idReporte,$con){


     $sql_listaclientes = "SELECT * FROM op_pago_clientes WHERE idreporte_dia = '".$idReporte."' ";
    $result_listaclientes = mysqli_query($con, $sql_listaclientes);
    while($row_listaclientes = mysqli_fetch_array($result_listaclientes, MYSQLI_ASSOC)){
    $importe = $row_listaclientes['importe'];

    $totalImporte = $totalImporte + $importe;
    }

    $sql_listacontrol = "SELECT * FROM op_clientes_controlgas WHERE idreporte_dia = '".$idReporte."' ";
    $result_listacontrol = mysqli_query($con, $sql_listacontrol);
    while($row_listacontrol = mysqli_fetch_array($result_listacontrol, MYSQLI_ASSOC)){

    $pago = $pago + $row_listacontrol['pago'];
    
    }

$resultado = number_format($pago - $totalImporte,2);

return $resultado;
}

function Firma($idReporte,$detalle,$rutafirma,$con){

  $sql_firma = "SELECT 
op_corte_dia_firmas.id_usuario, 
op_corte_dia_firmas.firma,
tb_usuarios.nombre
FROM op_corte_dia_firmas
INNER JOIN tb_usuarios
ON op_corte_dia_firmas.id_usuario = tb_usuarios.id WHERE id_reportedia  = '".$idReporte."' AND detalle = '".$detalle."' ";
   $result_firma = mysqli_query($con, $sql_firma);
   while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){
   $nombre = $row_firma['nombre'];
   $firma = $rutafirma.$row_firma['firma'];
   }

   $DataImagen = file_get_contents($firma);
   $baseImagen = 'data:image/' . $type . ';base64,' . base64_encode($DataImagen); 

   if ($firma != "") {
    
   $contenido .= '<div class="text-center mt-1">';
   $contenido .= '<img src="'.$baseImagen.'" width="140px" height="60px">';
   $contenido .= '<div class="text-center mt-1 border-top pt-2"><b>'.$nombre.'</b></div>';
   $contenido .= '</div>';

   }
   return $contenido;

}


use Dompdf\Dompdf;
$dompdf = new Dompdf();

$contenido .= '<html lang="es">';
$contenido .= '<head>';
$contenido .= '<style type="text/css">';
$contenido .= '
@page {margin: 0.5cm 0.5cm;}
*,
*::before,
*::after {
  box-sizing: border-box;
}
html {
  font-family: sans-serif;
  line-height: 1;
  -webkit-text-size-adjust: 100%;
  -ms-text-size-adjust: 100%;
  -ms-overflow-style: scrollbar;
  -webkit-tap-highlight-color: transparent;
}

@-ms-viewport {
  width: device-width;
}

article, aside, dialog, figcaption, figure, footer, header, hgroup, main, nav, section {
  display: block;
}

body {
  margin: 0;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
  font-size: .52rem;
  font-weight: 400;
  line-height: 1;
  color: #212529;
  text-align: left;
  background-color: #fff;
}
  .row {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -ms-flex-wrap: wrap;
  flex-wrap: wrap;
  margin-right: -15px;
  margin-left: -15px;
}
.no-gutters {
  margin-right: 0;
  margin-left: 0;
}

.no-gutters > .col,
.no-gutters > [class*="col-"] {
  padding-right: 0;
  padding-left: 0;
}

.col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12, .col,
.col-auto, .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm,
.col-sm-auto, .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, .col-md,
.col-md-auto, .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg,
.col-lg-auto, .col-xl-1, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl,
.col-xl-auto {
  position: relative;
  width: 100%;
  min-height: 1px;
  padding-right: 15px;
  padding-left: 15px;
}
.col-5 {
  -webkit-box-flex: 0;
  -ms-flex: 0 0 41.666667%;
  flex: 0 0 41.666667%;
  max-width: 41.666667%;
}
.col-7 {
  -webkit-box-flex: 0;
  -ms-flex: 0 0 58.333333%;
  flex: 0 0 58.333333%;
  max-width: 58.333333%;
}

.mt-2,
.my-2 {
  margin-top: 0.5rem !important;
}
.bg-light {
  background-color: #f8f9fa !important;
}
.p-1 {
  padding: 0.25rem !important;
}
.text-center {
  text-align: center !important;
}
.border {
  border: 1px solid #dee2e6 !important;
}
table {
  border-collapse: collapse;
}
th {
  text-align: inherit;
}
.table {
  width: 100%;
  max-width: 100%;
  margin-bottom: 1rem;
  background-color: transparent;
}

.table th,
.table td {
  padding: 0.75rem;
  vertical-align: top;
  border-top: 1px solid #dee2e6;
}

.table thead th {
  vertical-align: bottom;
  border-bottom: 2px solid #dee2e6;
}

.table tbody + tbody {
  border-top: 2px solid #dee2e6;
}

.table .table {
  background-color: #fff;
}

.table-sm th,
.table-sm td {
  padding: 0.3rem;
}

.table-bordered {
  border: 1px solid #dee2e6;
}

.table-bordered th,
.table-bordered td {
  border: 1px solid #dee2e6;
}

.table-bordered thead th,
.table-bordered thead td {
  border-bottom-width: 2px;
}

.table-striped tbody tr:nth-of-type(odd) {
  background-color: rgba(0, 0, 0, 0.05);
}
.pb-0,
.py-0 {
  padding-bottom: 0 !important;
}
.mb-0,
.my-0 {
  margin-bottom: 0 !important;
}
.align-middle {
  vertical-align: middle !important;
}
.text-right {
  text-align: right !important;
}
.p-1 {
  padding: 0.25rem !important;
}
.border-0 {
  border: 0 !important;
}
.p-2 {
  padding: 0.5rem !important;
}';
$contenido .= '</style>';
$contenido .= '<body>';

   $sql_dia = "SELECT fecha FROM op_corte_dia WHERE id = '".$idReporte."' ";
   $result_dia = mysqli_query($con, $sql_dia);
   while($row_dia = mysqli_fetch_array($result_dia, MYSQLI_ASSOC)){
   $dia = $row_dia['fecha'];
   }

$contenido .= '<h3>'.FormatoFecha($dia).'</h3>';

$contenido .= '<table class="table table-sm border-0">';
$contenido .= '<tbody>';
$contenido .= '<tr>';

$contenido .= '<td>';
//---------------------------------------------------
//-------------- Concentrado ventas y aceites--------

$contenido .= '<div class="">';
$contenido .= '<div class="bg-light p-1 text-center">
<strong>CONCENTRADO DE VENTAS</strong> 
</div>';
$contenido .= ConcentradoVentas($idReporte,$con);  
$contenido .= '</div>';

$contenido .= '<div class=" mt-2">';
$contenido .= '<div class="bg-light p-1 text-center">
            <strong>RELACION DE VENTA DE ACEITES Y LUBRICANTES</strong>
            </div>';
$contenido .= VentaAceitesLubricantes($idReporte,$con);  
$contenido .= '</div>';


//-------------- Concentrado ventas y aceites-----------
//------------------------------------------------------
$contenido .= '</td>';

$contenido .= '<td>';
//------------------------------------------------------

//...
$contenido .= '<div class="">
          <div class="bg-light p-1 text-center">
            <strong>PROSEGUR</strong>
            </div>';
$contenido .= Prosegur($idReporte,$con);            
$contenido .= '</div>';
//...

//...
$contenido .= '<div class="mt-2">
          <div class="bg-light p-1 text-center">
            <strong>MONEDEROS Y BANCOS</strong>
            </div>';
$contenido .= MonederosBancos($idReporte,$con);            
$contenido .= '</div>';
//...

//...
$contenido .= '<div class="mt-2">
          <div class="bg-light p-1 text-center">
            <strong>CLIENTES (ATIO)</strong>
            </div>';
$contenido .= ClientesAtio($idReporte,$con);            
$contenido .= '</div>';
//...

$contenido .= '<table class="table table-sm table-bordered pb-0 mb-0 mt-2">
          <tr>
            <td>C TOTAL (1+2+3)</td>
            <td class="bg-light align-middle text-right">'.Total1234($idReporte,$con).'</td>
          </tr>
        </table>';

$contenido .= '<table class="table table-sm table-bordered pb-0 mb-0 mt-2">
          <tr>
            <td><strong>DIFERENCIA (B-C)</strong></td>
            <td class="bg-light align-middle text-right">'.DiferenciaTotal($idReporte,$con).'</td>
          </tr>
        </table>';

$contenido .= '<div class="mt-2">
          <div class="bg-light p-1 text-center">
            <strong>PAGO DE CLIENTES</strong>
            </div>';
$contenido .= PagoClientes($idReporte,$con);          
$contenido .= '</div>';

$contenido .= '<table class="table table-sm table-bordered pb-0 mb-0 mt-2">
          <tr>
            <td>DIF PAGO DE CLIENTES</td>
            <td class="bg-light align-middle text-right"><strong>'.DiferenciaPC($idReporte,$con).'</strong></td>
            <td>(4-5)</td>
          </tr>
        </table>';

$contenido .= '<div class="border mt-2">
         <div class="bg-light p-1">
            <strong>OBSERVACIONES:</strong>            
            </div>';


            $sql_observaciones = "SELECT observaciones FROM op_observaciones WHERE idreporte_dia = '".$idReporte."' ";
            $result_observaciones = mysqli_query($con, $sql_observaciones);
            while($row_observaciones = mysqli_fetch_array($result_observaciones, MYSQLI_ASSOC)){

            $observaciones = $row_observaciones['observaciones'];

             }


$contenido .= '<div class="p-2">'.$observaciones.'</div></div>';


//-------------------------------------------------------
$contenido .= '</td>';

$contenido .= '</tbody>';
$contenido .= '</tr>';
$contenido .= '</table>';

$contenido .= '
<table class="table table-bordered table-sm pb-0 mb-0">
<tr>
<td class="text-center" width="200px">
<div class="text-center">ELABORÓ / SUPERVISO</div>
'.Firma($idReporte,'Elaboró',RUTA_IMG_Firma,$con).'
</td>
<td class="text-center" width="200px">
<div class="text-center">ELABORÓ / SUPERVISO</div>
'.Firma($idReporte,'Superviso',RUTA_IMG_Firma,$con).'
</td>
<td class="text-center" width="200px">
<div class="text-center">Vo. Bo.</div>
'.Firma($idReporte,'VoBo',RUTA_IMG_Firma,$con).'
</td>
</tr>
</table>
';

$contenido .= '</body>';
$contenido .= '</head>';
$contenido .= '</html>';

$dompdf->loadHtml($contenido);
$dompdf->setPaper("A4", "portrait");
$dompdf->render();
$dompdf->get_canvas()->page_text(540,820,"Pagina: {PAGE_NUM} de {PAGE_COUNT}", $font, 6, array(0,0,0));
$dompdf->stream("Corte ".FormatoFecha($dia).".pdf");
