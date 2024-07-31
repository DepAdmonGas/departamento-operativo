<?php
error_reporting(0);
require 'app/lib/dompdf/vendor/autoload.php';
require 'app/help.php';
 
$sql = "SELECT * 
FROM op_orden_compra WHERE id = '".$GET_idReporte."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
  $estatus = $row['estatus'];
  $iva_tb = $row['iva'];

$no_control = $row['no_control'];
$porcentaje_total = $row['porcentaje_total'];
$cargo = $row['cargo'];

$explode = explode(" ", $row['fecha']);
$Fecha = $explode[0];
$estatus = $row['estatus'];
}


function Personal($idusuario,$con){
$sql = "SELECT nombre FROM tb_usuarios WHERE id = '".$idusuario."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$nombre = $row['nombre'];
}
return $nombre;
} 


function Estacion($idEstacion, $con){
$sql_listaestacion = "SELECT nombre, direccioncompleta FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$nombre = $row_listaestacion['nombre'];
$direccioncompleta = $row_listaestacion['direccioncompleta'];
}

return $arrayName = array('nombre' => $nombre, 'direccioncompleta' => $direccioncompleta);
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
   line-height: 1.15;
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
  font-size: .9rem;
  font-weight: 400;
  line-height: 1.15;
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
}

.border-bottom {
  border-bottom: 1px solid #dee2e6 !important;
}

.col-6 {
  -webkit-box-flex: 0;
  -ms-flex: 0 0 50%;
  flex: 0 0 50%;
  max-width: 50%;
}
.text-secondary {
  color: #6c757d !important;
}
.mb-1,
.my-1 {
  margin-bottom: 0.25rem !important;
}
.mt-1,
.my-1 {
  margin-top: 0.25rem !important;
}
.pb-1,
.py-1 {
  padding-bottom: 0.25rem !important;
}
.text-white {
  color: #fff !important;
}
.bg-primary { 
  background-color: #007bff !important;
}

.tables-bg {
    background: #5d84c3;
    color: white;
}

.table-info {
    background-color: #cff4fc;
}';

$contenido .= '</style>';
$contenido .= '<body>';

$RutaLogo = RUTA_IMG_ICONOS.'Logo.png';
$DataLogo = file_get_contents($RutaLogo);
$baseLogo = 'data:image/' . $type . ';base64,' . base64_encode($DataLogo);

$contenido .= '<div style="text-align: right"><img src="'.$baseLogo.'" style="width: 180px;"></div>';


     $contenido .= '
    <table class="table table-sm table-bordered" style="font-size: .9em;">
    <tr>
      <td colspan="2" class="align-middle">Dep. Almacén</td>

      <td rowspan="3" class="text-center align-middle"><h5>ORDEN DE COMPRA</h5></td>
      <td class="align-middle">Cargo:</td>
      <td ><b>'.$cargo.' </b></td>
    </tr>
    <tr>
      <td colspan="2" class="align-middle">Ref. Operativa</td>
      <td class="align-middle">Fecha:</td>
      <td><b>'.FormatoFecha($Fecha).'</b></td>
    </tr>
    <tr>
      <td class="align-middle"><b>Refacturación</b></td>
      <td class="text-end">'.$porcentaje_total.'</b></td>

      <td class="align-middle">No. De control:</td>
      <td class="align-middle"><b>00'.$no_control.'</b></td>
    </tr>     
   </table>';

  //------------------------------------------------------------------

  $sql_lista = "SELECT op_rh_localidades.localidad 
  FROM op_orden_compra_razon_social 
  INNER JOIN op_rh_localidades ON op_rh_localidades.id = op_orden_compra_razon_social.id_estacion WHERE op_orden_compra_razon_social.id_ordencompra = '".$GET_idReporte."' ";   

  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);
 
  while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
    $nombreES = $row_lista['localidad'];
  }


    //---------- ESTACIONES DE SERVICIO ----------//
  if($nombreES == "Quitarga"){
    $nombreRS = "COMERCIAL GASOLINERA QUITARGA";
    $rfc = "CGQ120525C15";
    $contacto = "Calle Plaza Tajin No. 433, Col. CTM Culhuacan Secc. V, C.P. 04480";
  }else if($nombreES == "Comercializadora"){
    $nombreRS = "COMERCIALIZALIZADORA DE ARTICULOS GASOLINEROS";
    $rfc = "CAG05052557A";
    $contacto = "Carretera Rio Hondo Huixquilucan No. 401, San Bartolomé Coatepec, C.P. 52770";
  
  }else{

  $sql_lista_es = "SELECT razonsocial, rfc, direccioncompleta
  FROM tb_estaciones WHERE nombre = '".$nombreES."' ";

  $result_lista_es = mysqli_query($con, $sql_lista_es);
  $numero_lista_es = mysqli_num_rows($result_lista_es);

  while($row_lista_es = mysqli_fetch_array($result_lista_es, MYSQLI_ASSOC)){
  $nombreRS = $row_lista_es['razonsocial'];
  $rfc = $row_lista_es['rfc'];
  $contacto = $row_lista_es['direccioncompleta'];
  }


  }


 $contenido .= '<table class="table table-sm table-bordered mb-0" style="font-size: .9em;">
      <tr class="tables-bg">
      <th colspan="2" class=" text-center">DATOS DE LA ESTACION</th>
      </tr>

      <tr>
      <td class="align-middle"><b>Razón Social:</b></td>
      <td class="align-middle">'.$nombreRS.'</td>
      </tr>

      <tr>
      <td class="align-middle"><b>RFC:</b></td>
      <td class="align-middle">'.$rfc.'</td>
      </tr>
        
      <tr>
      <td class="align-middle"><b>Dirección:</b></td>
      <td class="align-middle">'.$contacto.'</td>
      </tr>
      </table>';

//------------------------------------------------------------------

    $contenido .= '<table class="table table-sm table-bordered mt-2" style="font-size: .9em;">
          <tr>
            <td colspan="4" class="text-center align-middle text-white tables-bg"><b>DATOS DEL PROVEEDOR</b></td>
          </tr>
          <tr>
            <td><b>Razón Social</b></td>
            <td><b>Dirección</b></td>
            <td><b>Contacto</b></td>
            <td><b>Email</b></td>
          </tr>
          <tbody>';


        $sqlP = "SELECT * FROM op_orden_compra_proveedor WHERE id_ordencompra = '".$GET_idReporte."' ";
        $resultP = mysqli_query($con, $sqlP);
        $numeroP = mysqli_num_rows($resultP);
        if ($numeroP > 0) {
        while($rowP = mysqli_fetch_array($resultP, MYSQLI_ASSOC)){
        $contenido .= '<tr>
        <td>'.$rowP['razon_social'].'</td>
        <td>'.$rowP['direccion'].'</td>
        <td>'.$rowP['contacto'].'</td>
        <td>'.$rowP['email'].'</td>
        </tr>';
        }
        }else{
        $contenido .= "<tr><td colspan='6' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
        }

            
      $contenido .= '</tbody></table>';


  //------------------------------------------------------------------

    $contenido .= '<div class="table-responsive">
       <table class="table table-sm table-bordered mb-3" style="font-size: .9em;">
        <thead>
          <tr class="tables-bg">
            <th colspan="9" class="text-center">CUADRO COMPARATIVO DE PROVEEDORES</th>
          </tr>
          <tr class="bg-light align-middle">
             <th class="text-center" width="80px"> Mejor Oferta</th>
            <th class="text-center">Concepto</th>
            <th class="text-center">Unidades</th>
            <th class="text-center">Estatus</th>
            <th class="text-end">Precio Unitario</th>
            <th class="text-end">Subtotal</th>   

            <th class="text-end" width="40px">IVA</th>
            <th class="text-end" >Total (Subtotal * IVA)</th>

            <th class="text-end">Total</th>
          </tr>
        </thead>
        <tbody>';

  $sqlP = "SELECT * FROM op_orden_compra_proveedor WHERE id_ordencompra = '".$GET_idReporte."' ";
  $resultP = mysqli_query($con, $sqlP);
  $numeroP = mysqli_num_rows($resultP);

  if ($numeroP > 0) {
  $num = 1;

  while($rowP = mysqli_fetch_array($resultP, MYSQLI_ASSOC)){
  $idProveedor = $rowP['id'];
  $razonsocialP = $rowP['razon_social'];

  $descuento = $rowP['descuento'];
  $envio_cp = $rowP['envio_cp'];

  $CheckProveedor = $rowP['check_p'];

  $totalUnidades = 0;
  $totalPrecioU = 0;
  $totalSubTotal = 0;
  $totalIVA = 0;
  $totalGeneral = 0;
  $numerolista = 0;

 $contenido .= '<tr>';
 $contenido .= '<td class="table-info"> 
 
  <div class="form-check form-check-inline d-flex justify-content-center">
  <input class="form-check-input  p-2" type="radio" name="TipoServicio" id="Proveedor'.$idProveedor.'" value="'.$num.'" onChange="SelProveedor('.$idReporte.','.$idProveedor.', 1,'.$num.')" disabled ';

  if($CheckProveedor == 1){
  $contenido .= 'checked';
  } 

 $contenido .= '> </div>
 </td>';

 $contenido .= '<td colspan="8" class="text-center table-info"><b>Proveedor: '.$razonsocialP.'</b></td>';
 $contenido .= '</tr>';


  $sql_lista = "SELECT * FROM op_orden_compra_articulo WHERE id_ordencompra = '".$GET_idReporte."' AND id_proveedor = '".$idProveedor."' ORDER BY id ASC";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);

    if ($numero_lista > 0) {
    while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
    $id = $row_lista['id'];
    $GET_idProveedor = $row_lista['id_proveedor'];

    $unidades = $row_lista['unidades'];
    $precio_unitario = $row_lista['precio_unitario'];
    $subtotal_tb = $unidades * $precio_unitario;
    $subtotalPU_IVA = ($subtotal_tb - $descuento + $envio_cp) * $iva_tb;
    $Total = $subtotal_tb + $subtotalPU_IVA;   

    $contenido .= '<tr>';
    $contenido .= '<td class="align-middle text-center"></td>';

    $contenido .= '<td class="align-middle text-center">'.$row_lista['concepto'].' </td>';
    $contenido .= '<td class="align-middle text-center">'.$row_lista['unidades'].'</td>';
    $contenido .= '<td class="align-middle text-center">'.$row_lista['estatus_r'].'</td>';
    $contenido .= '<td class="align-middle text-end">$ '.number_format($row_lista['precio_unitario'],2).'</td>';
    $contenido .= '<td class="align-middle text-end">$ '.number_format($subtotal_tb,2).'</td>';

    $contenido .= '<td class="align-middle text-end">16%</td>';
    $contenido .= '<td class="align-middle text-end">$ '.number_format($subtotalPU_IVA,2).'</td>';

 
    $contenido .= '<td class="align-middle text-end">$ '.number_format($Total,2).'</td>';
    $contenido .= '</tr>';

    $totalUnidades = $totalUnidades + $row_lista['unidades'];
    $totalPrecioU = $totalPrecioU + $row_lista['precio_unitario'];
    $totalSubTotal = $totalSubTotal + $subtotal_tb;
    $totalIVA = $totalIVA + $subtotalPU_IVA;
    $totalGeneral = $totalGeneral + $Total;
    
    }

    $subtotal3 = $totalSubTotal - $descuento + $envio_cp;
    $totalFinal = $totalIVA + $subtotal3;


    $contenido .= '<tr class="bg-light">
    <td colspan="5" class="align-middle text-end"></td>
    <th class="align-middle text-center">SUMA</th>
    <th colspan="3" class="align-middle text-start">$ '.number_format($totalSubTotal,2).'</th>
    </tr>';

    $contenido .= '<tr class="bg-light">
    <td colspan="5" class="align-middle text-end"></td>
    <th class="align-middle text-center">DESCUENTO</th>
    <th colspan="3" class="align-middle text-start">$ '.number_format($descuento,2).'</th>
    </tr>';


    $contenido .= '<tr class="bg-light">
    <td colspan="5" class="align-middle text-end"></td>
    <th class="align-middle text-center">ENVIO</th>
    <th colspan="3" class="align-middle text-start">$ '.number_format($envio_cp,2).'</th>
    </tr>';


    $contenido .= '<tr class="bg-light">
    <td colspan="5" class="align-middle text-end"></td>
    <th class="align-middle text-center">SUBTOTAL</th>
    <th colspan="3" class="align-middle text-start">$ '.number_format($subtotal3,2).'</th>
    </tr>';


    $contenido .= '<tr class="bg-light">
    <td colspan="5" class="align-middle text-end"></td>
    <th class="align-middle text-center">IVA</th>
    <th colspan="3" class="align-middle text-start">$ '.number_format($totalIVA,2).'</th>
    </tr>';

    $contenido .= '<tr class="bg-light">
    <td colspan="5" class="align-middle text-end"></td>
    <th class="align-middle text-center">TOTAL A PAGAR</th>
    <th colspan="3" class="align-middle text-start">$ '.number_format($totalFinal,2).'</th>
    </tr>';

   }

    $numerolista = $numerolista + $numero_lista;

    if ($numerolista == 0) {
    $contenido .=  "<tr><td colspan='9' class='text-center text-secondary'><small>No se encontró información para mostrar</small></td></tr>";
    }else{

    }
  $num++;
  }
  }

  $contenido .= '  </tbody>
    </table>';

  //------------------------------------------------------------------


 

  $contenido .= '<div class="table-responsive">
        <table class="table table-sm table-bordered mb-0" style="font-size: .9em;">
          <tr class="tables-bg">
            <th colspan="8" class="text-center align-middle">DATOS DE REFACTURACIÓN Y PRORROTEO</th>
          </tr>
          <tr class="bg-light">
            <td><b>Prorroteo (Estación)</b></td>
            <td><b>Descripción</b></td>
            <td><b>Cantidad</b></td>
            <td><b>Importe</b></td>
            <td><b>Porcentaje</b></td>
            <td><b>Estacion</b></td>
            <td><b>Almacén</b></td>
            <td><b>Total</b></td>
          </tr>
          <tbody>';

  $totalGeneral = 0;

    $sql_DatosProveedor = "SELECT descuento, envio_cp FROM op_orden_compra_proveedor WHERE id_ordencompra = '".$GET_idReporte."' AND check_p = 1";
    $result_DatosProveedor = mysqli_query($con, $sql_DatosProveedor);
    $numero_DatosProveedor = mysqli_num_rows($result_DatosProveedor);

    if ($numero_DatosProveedor > 0) {
    while($row_DatosProveedor = mysqli_fetch_array($result_DatosProveedor, MYSQLI_ASSOC)){ 
    $descuento = $row_DatosProveedor['descuento'];
    $envio_cp = $row_DatosProveedor['envio_cp'];
    }

    }else{
    $descuento = 0;
    $envio_cp = 0;
    }


  $sql = "SELECT * FROM op_orden_compra_refacturacion WHERE id_ordencompra = '".$GET_idReporte."' ";
  $result = mysqli_query($con, $sql);
  $numero = mysqli_num_rows($result);
  if ($numero > 0) {
  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

  $id = $row['id'];
  $Estacion = Estacion($row['id_estacion'], $con);
  $descripcion = $row['descripcion'];

  $cantidad = $row['cantidad'];
  $importe = $row['importe'];
  $porcentaje = $row['porcentaje'];

  $cantidadES = $row['cantidadES'];
  $cantidadAL = $row['cantidadAl'];

  $total = $cantidad * $importe;

  $subTotalGeneral = $subTotalGeneral + $total;
  $totalIVA = ($subTotalGeneral - $descuento + $envio_cp) * 0.16;
  $totalGrnlIva = $subTotalGeneral + $totalIVA;

  $contenido .= '<tr>
  <td class="align-middle">'.$Estacion['nombre'].'</td>
  <td class="align-middle">'.$descripcion.'</td>
  <td class="align-middle">'.$cantidad.'</td>
  <td class="align-middle">'.$importe.'</td>
  <td class="align-middle">'.number_format($porcentaje).' %</td>
  <td class="align-middle">'.$cantidadES.'</td>
  <td class="align-middle">'.$cantidadAL.'</td>
  <td class="align-middle">'.number_format($total,2).'</td>
  </tr>';

}

    $contenido .= '<tr class="bg-light">
    <td colspan="3" class="align-middle text-end"></td>
    <th colspan="2" class="align-middle text-center">SUMA</th>
    <th colspan="5" class="align-middle text-start">$ '.number_format($subTotalGeneral,2).'</th>
    </tr>';

    $subtotal3 = $subTotalGeneral - $descuento + $envio_cp;
    $totalFinal = $totalIVA + $subtotal3;

        $contenido .= '<tr class="bg-light">
    <td colspan="3" class="align-middle text-end"></td>
    <th colspan="2" class="align-middle text-center">DESCUENTO</th> 
    <th colspan="5" class="align-middle text-start">$ '.number_format($descuento,2).'</th>
    </tr>';


        $contenido .= '<tr class="bg-light">
    <td colspan="3" class="align-middle text-end"></td>
    <th colspan="2" class="align-middle text-center">ENVIO</th> 
    <th colspan="5" class="align-middle text-start">$ '.number_format($envio_cp,2).'</th>
    </tr>';

        $contenido .= '<tr class="bg-light">
    <td colspan="3" class="align-middle text-end"></td>
    <th colspan="2" class="align-middle text-center">SUBTOTAL</th> 
    <th colspan="5" class="align-middle text-start">$ '.number_format($subtotal3,2).'</th>
    </tr>';

    $contenido .= '<tr class="bg-light">
    <td colspan="3" class="align-middle text-end"></td>
    <th colspan="2" class="align-middle text-center">IVA</th> 
    <th colspan="5" class="align-middle text-start">$ '.number_format($totalIVA,2).'</th>
    </tr>';

    $contenido .= '<tr class="bg-light">
    <td colspan="3" class="align-middle text-end"></td>
    <th colspan="2" class="align-middle text-center">TOTAL</th>
    <th colspan="5" class="align-middle text-start">$ '.number_format($totalFinal,2).'</th>
    </tr>';


  }else{
  echo "<tr><td colspan='9' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
  }


    $contenido .= '</tbody>
    </table>';

      //--------------------------------------------------------------

$contenido .= '<table class="table table-sm table-bordered " style="margin-top: 50px;" width="50%">';
$contenido .= '<tbody>';
$contenido .= '<tr>';
$sql_firma = "SELECT * FROM op_orden_compra_firma WHERE id_ordencompra = '".$GET_idReporte."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){

$explode = explode(' ', $row_firma['fecha']);

if($row_firma['tipo_firma'] == "A"){
$TipoFirma = "<b>Elaboró</b>";

$RutaFirma = "imgs/firma/".$row_firma['firma'];
$DataFirma = file_get_contents($RutaFirma);
$baseFirma = 'data:image/' . $type . ';base64,' . base64_encode($DataFirma);

$Detalle = '<div class=""><img src="'.$baseFirma.'" style="width: 200px;"></div>';
}else if($row_firma['tipo_firma'] == "B"){
$TipoFirma = "<b>VO.BO</b>";
$Detalle = '<div class="border-top text-center" style="padding: 10px;"><small>La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).'</b></small></div>';
}

$contenido .= '<td>
<div class="border-bottom" style="padding: 10px;text-align: center;">'.$TipoFirma.'</div>
<div class="text-secondary text-center border-bottom" style="padding: 7px;text-align: center;">'.$Detalle.'</div>
<div style="margin-top: 10px;text-align: center;">'.Personal($row_firma['id_usuario'],$con).'</div></td>';
}

$contenido .= '</tr>';
$contenido .= '</tbody>';
$contenido .= '</table>';




$contenido .= '</body>';

$dompdf->loadHtml($contenido);
$dompdf->setPaper("A4", "portrait");
$dompdf->render();
$dompdf->get_canvas()->page_text(540,820,"Pagina: {PAGE_NUM} de {PAGE_COUNT}", $font, 6, array(0,0,0));
$dompdf->stream("Orden de compra.pdf");  