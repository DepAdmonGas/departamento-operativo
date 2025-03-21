<?php
require ('../../../app/help.php');

$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$_GET['idEstacion']."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
} 

header('Content-Encoding: UTF-8');
header('Content-Type:text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="Analisis de compras '.$estacion.'.csv"');

$salida = fopen('php://output', 'w');

$arrayHead = array(
'TAD',
'Fecha',
'No. Factura',
'Litros factura',
'Cuenta litros', 
'Merma con cuenta litros',
'Tolerancia de Merma .55%',
'Producto',
'Transporte',
'Unidad',
'Chofer',
'Importe G500 Facturado	', 
'Importe Transporte',
'Precio Pickup facturado',
'Precio Pemex',
'Diferencia',
'Diferencial $ vs Pemex',
'Importe merma total $',
'Merma', 
'Importe Merma',
'NOTA C',
'Importe Nota',
'Factura Transporte no.',
'Monto factura',
'Total a pagar transporte',
'Status', 
'PICKUP',
'PEMEX');

$map1 = array_map("utf8_decode", $arrayHead);
fputcsv($salida, $map1);

$sql_recepcion = "SELECT
re_reporte_cre_pipas.id,
re_reporte_cre_pipas.id_re_producto,
re_reporte_cre_pipas.volumen,
re_reporte_cre_pipas.precio_litro,
re_reporte_cre_pipas.no_factura,
re_reporte_cre_pipas.nombre_razonsocial,
re_reporte_cre_pipas.importe_total,
re_reporte_cre_producto.id_re_mes,
re_reporte_cre_producto.fecha,
re_reporte_cre_producto.producto,
re_reporte_cre_mes.id_estacion
FROM re_reporte_cre_pipas 
INNER JOIN 
re_reporte_cre_producto ON 
re_reporte_cre_pipas.id_re_producto = re_reporte_cre_producto.id 
INNER JOIN
re_reporte_cre_mes ON 
re_reporte_cre_producto.id_re_mes = re_reporte_cre_mes.id
WHERE re_reporte_cre_mes.id_estacion = '".$_GET['idEstacion']."' 
AND YEAR(re_reporte_cre_producto.fecha) = '".$_GET['Year']."' AND MONTH (re_reporte_cre_producto.fecha) = '".$_GET['Month']."' ORDER BY re_reporte_cre_producto.fecha ASC";
$result_recepcion = mysqli_query($con, $sql_recepcion);
$numero_recepcion = mysqli_num_rows($result_recepcion);

$TotalDiferenciaPemex = 0;
$TotalImporteMerma = 0;
$TotalImporteNota = 0;
$TotalPickup = 0;
$TotalPemex = 0;
$CuentaLitros = 0;

while($row_recepcion = mysqli_fetch_array($result_recepcion, MYSQLI_ASSOC)){

$Embarques = Embarques($row_recepcion['fecha'],$row_recepcion['producto'],$row_recepcion['volumen'],$row_recepcion['precio_litro'],$_GET['idEstacion'],$con);

    $Tuxpan = Tuxpan($row_recepcion['fecha'],$row_recepcion['producto'],$row_recepcion['volumen'],$_GET['idEstacion'],$con);

    $Precios = Precios($row_recepcion['fecha'],$row_recepcion['producto'],$con);

    $TAD = $Embarques['Tad'];
    $LitrosFacturados = $row_recepcion['volumen']; 
    $CuentaLitros = $Tuxpan['CuentaLitros'];
    $MermaCuentaLitros = $row_recepcion['volumen'] - $CuentaLitros;
    $Tolerancia = intval(($row_recepcion['volumen'] * .55) / 100);

    if($row_recepcion['producto'] == 'G SUPER'){
    $Producto = "87 Oct";
    }else if($row_recepcion['producto'] == 'G PREMIUM'){
    $Producto = "91 Oct"; 
    }else if($row_recepcion['producto'] == 'G DIESEL'){
    $Producto = "DIESEL"; 
    }
    
    $Unidad = $Embarques['Unidad'];
    $Chofer = $Embarques['Chofer'];
    $ImporteFacturado = $row_recepcion['precio_litro'];
    $ImporteTransporte = $row_recepcion['importe_total'] / $LitrosFacturados;
    $PrecioPickup = $ImporteFacturado + $ImporteTransporte;

    $PrecioPemex = $Precios['Pemex'];
    $Diferencia = $PrecioPickup - $PrecioPemex;
    
    $ImporteMermaTotal = $MermaCuentaLitros * $PrecioPickup;
    $Merma = $LitrosFacturados - $CuentaLitros - $Tolerancia;
    $ImporteMerma = $Merma * $ImporteFacturado;
    $ImporteNota = ($MermaCuentaLitros - $Tolerancia) * $ImporteFacturado;
    $FacturaTransporte = $Tuxpan['FacturaTransporte'];
    $MontoFactura = $row_recepcion['importe_total'];
    $TotalPagarTransporte = $MontoFactura - $ImporteNota;
    $Pickup = $LitrosFacturados - $PrecioPickup;
    $Pemex = $LitrosFacturados - $PrecioPemex;

    $DiferenciaPemex = $Pickup - $Pemex;

    $NotaCredito = NotaCredito($row_recepcion['fecha'],$row_recepcion['no_factura'],$con);

$arrayContenido1 = array(
$TAD,
$row_recepcion['fecha'],
$row_recepcion['no_factura'],
number_format($LitrosFacturados),
$CuentaLitros,
$MermaCuentaLitros,
$Tolerancia,
$Producto,
$row_recepcion['nombre_razonsocial'],
$Unidad,
$Chofer,
number_format($ImporteFacturado,4),
number_format($ImporteTransporte,4),
number_format($PrecioPickup,4),
number_format($PrecioPemex,4),
number_format($Diferencia,4),
number_format($DiferenciaPemex,2),
number_format($ImporteMermaTotal,2),
$Merma,
number_format($ImporteMerma,2),
$NotaCredito['NotaC'],
number_format($ImporteNota,2),
$FacturaTransporte,
number_format($MontoFactura,2),
number_format($TotalPagarTransporte,2),
$NotaCredito['Status'],
number_format($Pickup,2),
number_format($Pemex,2)
);

$contenidoPQDecode = array_map("utf8_decode", $arrayContenido1);
fputcsv($salida, $contenidoPQDecode);


$TotalDiferenciaPemex = $TotalDiferenciaPemex + $DiferenciaPemex;
    $TotalImporteMerma = $TotalImporteMerma + $ImporteMerma;
    $TotalImporteNota = $TotalImporteNota + $ImporteNota;
    $TotalPickup = $TotalPickup + $Pickup;
    $TotalPemex = $TotalPemex + $Pemex;
}

$arrayContenido2 = array(
'','','','','','','','','','','','','','','','',	
number_format($TotalDiferenciaPemex,2),
'','',
number_format($TotalImporteMerma,2),
'',
number_format($TotalImporteNota,2),
'','','','',
number_format($TotalPickup,2),
number_format($TotalPemex,2)
);

$contenidoPQDecode2 = array_map("utf8_decode", $arrayContenido2);
fputcsv($salida, $contenidoPQDecode2);


function Embarques($fecha,$producto,$volumen,$preciolitro,$IdEstacion,$con){

$sql = "SELECT
op_embarques.id,
op_embarques.tad,
op_embarques.chofer,
op_embarques.unidad,
op_corte_mes.mes,
op_corte_year.id_estacion
FROM op_embarques 
INNER JOIN 
op_corte_mes ON 
op_embarques.id_mes = op_corte_mes.id
INNER JOIN 
op_corte_year ON 
op_corte_mes.id_year = op_corte_year.id
WHERE op_embarques.fecha = '".$fecha."' AND op_embarques.producto = '".$producto."' 
AND op_embarques.importef = '".$volumen."'
AND op_corte_year.id_estacion = '".$IdEstacion."' ";
$result = mysqli_query($con, $sql);
$Tad = "";
$Unidad = "";
$Chofer = "";
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$Tad = $row['tad'];
$Unidad = $row['unidad'];
$Chofer = $row['chofer'];
}

$array = array('Tad' => $Tad, 'Unidad' => $Unidad, 'Chofer' => $Chofer);

return $array;
}

function Tuxpan($fecha,$producto,$volumen,$IdEstacion,$con){

  if($producto == 'G SUPER'){

    $ValProducto = '87 oct';

  }else if($producto == 'G PREMIUM'){

    $ValProducto = '91 oct';

  }else if($producto == 'G DIESEL'){

    $ValProducto = 'Diesel';

  }

$sql = "SELECT cuenta_litros, no_factura_remision FROM op_descarga_tuxpa WHERE id_estacion = '".$IdEstacion."' AND fecha_llegada = '".$fecha."' AND producto = '".$ValProducto."' ";
   $result = mysqli_query($con, $sql);
   $CuentaLitros = 0;
   $FacturaTransporte = 0;

   while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $CuentaLitros = $row['cuenta_litros'];
    $FacturaTransporte = $row['no_factura_remision'];
   }

$array = array('CuentaLitros' => $CuentaLitros, 'FacturaTransporte' => $FacturaTransporte);

return $array;
}

function Precios($fecha,$producto,$con){

if($producto == 'G SUPER'){
$ValProducto = 'Super';
}else if($producto == 'G PREMIUM'){
$ValProducto = 'Premium';
}else if($producto == 'G DIESEL'){
$ValProducto = 'Diesel';
}


$sql = "SELECT  
op_formato_precios_detalle_c.id,
op_formato_precios_detalle_c.producto,
op_formato_precios_detalle_c.pemex,
op_formato_precios.fecha
FROM op_formato_precios_detalle_c 
INNER JOIN
op_formato_precios ON 
op_formato_precios_detalle_c.id_precio = op_formato_precios.id
WHERE op_formato_precios.fecha = '".$fecha."' AND op_formato_precios_detalle_c.producto = '".$ValProducto."' ";
$result = mysqli_query($con, $sql);
$Pemex = 0;
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$Pemex = $row['pemex'];
}

$array = array('Pemex' => $Pemex);

return $array;
}


function NotaCredito($fecha,$nofactura,$con){
  $NotaC = "";
  $Status = "";  

$sql = "SELECT * FROM tb_analisis_compra WHERE fecha = '".$fecha."' AND factura = '".$nofactura."' ";
   $result = mysqli_query($con, $sql);
   while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
   $NotaC = $row['notac'];
   $Status = $row['status'];
   }

$array = array('NotaC' => $NotaC, 'Status' => $Status);
return $array;
}