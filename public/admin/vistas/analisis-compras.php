<?php
require('app/help.php');

$TotalDiferenciaPemex = 0;
$TotalImporteMerma = 0;
$TotalImporteNota = 0;
$TotalPickup = 0;
$TotalPemex = 0;

$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosEstacion($GET_idEstacion);
$Estacion = ' ('.$datosEstacion['nombre'].')';


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
WHERE re_reporte_cre_mes.id_estacion = '".$GET_idEstacion."' 
AND YEAR(re_reporte_cre_producto.fecha) = '".$GET_year."' AND MONTH (re_reporte_cre_producto.fecha) = '".$GET_mes."' ORDER BY re_reporte_cre_producto.fecha ASC";
$result_recepcion = mysqli_query($con, $sql_recepcion);
$numero_recepcion = mysqli_num_rows($result_recepcion);

$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$GET_idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
}


function Embarques($fecha,$producto,$volumen,$preciolitro,$IdEstacion,$con){
  $Tad = "";
  $Transporte = "";
  $Unidad = "";
  $Chofer = "";

$sql = "SELECT
op_embarques.id,
op_embarques.tad,
op_embarques.nom_transporte,
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

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$Tad = $row['tad'];
$Transporte = $row['nom_transporte'];
$Unidad = $row['unidad'];
$Chofer = $row['chofer'];
}

$array = array('Tad' => $Tad, 'Transporte' => $Transporte,'Unidad' => $Unidad, 'Chofer' => $Chofer);

return $array;
}

function Tuxpan($fecha,$producto,$volumen,$IdEstacion,$con){
$CuentaLitros = 0;
$FacturaTransporte = 0;

if($producto == 'G SUPER'){
$ValProducto = '87 oct';

}else if($producto == 'G PREMIUM'){
$ValProducto = '91 oct';
}else if($producto == 'G DIESEL'){
$ValProducto = 'Diesel';

}

$sql = "SELECT cuenta_litros, no_factura_remision FROM op_descarga_tuxpa WHERE id_estacion = '".$IdEstacion."' AND fecha_llegada = '".$fecha."' AND producto = '".$ValProducto."' ";
$result = mysqli_query($con, $sql);

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
?>

<html lang="es">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Dirección de operaciones</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <link rel="shortcut icon" href="<?=RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="apple-touch-icon" href="<?=RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="stylesheet" href="<?=RUTA_CSS2 ?>alertify.css">
  <link rel="stylesheet" href="<?=RUTA_CSS2 ?>themes/default.rtl.css">
  <link href="<?=RUTA_CSS2;?>bootstrap.min.css" rel="stylesheet" />
  <link href="<?=RUTA_CSS2;?>navbar-general.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script> 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  
  <script type="text/javascript">
  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  $('[data-toggle="tooltip"]').tooltip();
  
  });

  function Regresar(){
  window.history.back();
  }

  function NotaC(e,factura,fecha,estado){
    
    var valor = e.value; 

    var parametros = {
    "valor" : valor,
    "factura" : factura,
    "fecha" : fecha,
    "estado" : estado
    };

     $.ajax({
     data:  parametros,
     url:   '../../../../public/admin/modelo/agregar-nota-credito.php',
     type:  'post',
     beforeSend: function() {
     },
     complete: function(){
    
     },
     success:  function (response) {


     }
     });

  }

    function Status(e,factura,fecha,estado){
    
    var valor = e.value; 

    var parametros = {
    "valor" : valor,
    "factura" : factura,
    "fecha" : fecha,
    "estado" : estado
    };

     $.ajax({
     data:  parametros,
     url:   '../../../../public/admin/modelo/agregar-nota-credito.php',
     type:  'post',
     beforeSend: function() {
     },
     complete: function(){
    
     },
     success:  function (response) {


     }
     });

  }

  </script>
  </head>
 
  <body> 
  <div class="LoaderPage"></div>

  <!---------- DIV - CONTENIDO ----------> 
  <div id="content">
  <!---------- NAV BAR - PRINCIPAL (TOP) ---------->  
  <?php include_once "public/navbar/navbar-perfil.php";?>
  <!---------- CONTENIDO PAGINA WEB----------> 
  <div class="contendAG">
  <div class="row">

  <div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.go(-1)" class="text-uppercase text-primary pointer"> <i class="fa-solid fa-chevron-left"></i> Resumen  Embarques <?=$Estacion?></a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Pick up G500 Network, <?=$ClassHerramientasDptoOperativo->nombremes($GET_mes)?> <?=$GET_year?></li>
  </ol>
  </div>
  
  <div class="row"> 
  <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 mb-1"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Pick up G500 Network, <?=$ClassHerramientasDptoOperativo->nombremes($GET_mes)?> <?=$GET_year?></h3> </div>
  <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 mt-1"> 
  <a href="../../../../public/admin/vistas/descargar-analisis-compra.php?idEstacion=<?=$GET_idEstacion;?>&Year=<?=$GET_year;?>&Month=<?=$GET_mes;?>">
  <button type="button" class="btn btn-labeled2 btn-success float-end"> 
  <span class="btn-label2"><i class="fa-solid fa-file-excel"></i></span>Descargar analisis</button>
  </div>
  </a>
  </div>

  <hr>
  </div>

  <div class="col-12">

  <div class="table-responsive">
  <table id="tabla_embarques" class="custom-table" style="font-size: .75em;" width="150%">
      
  <thead class="tables-bg">
      <tr>
        <th class="align-middle text-center">TAD</th>
        <th class="align-middle text-center" width="120">Fecha</th>
        <th class="align-middle text-center">No. Factura</th>
        <th class="align-middle text-center">Litros factura</th>
        <th class="align-middle text-center">Cuenta litros</th>
        <th class="align-middle text-center">Merma con cuenta litros</th>
        <th class="align-middle text-center">Tolerancia de Merma .55%</th>
        <th class="align-middle text-center">Producto</th>
        <th class="align-middle text-center">Transporte</th>
        <th class="align-middle text-center">Unidad</th>
        <th class="align-middle text-center">Chofer</th>
        <th class="align-middle text-center">Importe G500 Facturado</th>
        <th class="align-middle text-center">Importe Transporte</th>
        <th class="align-middle text-center">Precio Pickup facturado</th>
        <th class="align-middle text-center">Precio Pemex</th>
        <th class="align-middle text-center">Diferencia</th>
        <th class="align-middle text-center">Diferencial $ vs Pemex</th>
        <th class="align-middle text-center">Importe merma total $</th>
        <th class="align-middle text-center">Merma</th>
        <th class="align-middle text-center">Importe Merma</th>
        <th class="align-middle text-center">NOTA C</th>
        <th class="align-middle text-center">Importe Nota</th>
        <th class="align-middle text-center">Factura Transporte no.</th>
        <th class="align-middle text-center">Monto factura</th>
        <th class="align-middle text-center">Total a pagar transporte</th>
        <th class="align-middle text-center">Status</th>
        <th class="align-middle text-center" width="100">PICKUP</th>
        <th class="align-middle text-center" width="100">PEMEX</th>
      </tr>
    </thead>

    <tbody class="bg-white">

    <?php 

    while($row_recepcion = mysqli_fetch_array($result_recepcion, MYSQLI_ASSOC)){

    $Embarques = Embarques($row_recepcion['fecha'],$row_recepcion['producto'],$row_recepcion['volumen'],$row_recepcion['precio_litro'],$GET_idEstacion,$con);
    $Tuxpan = Tuxpan($row_recepcion['fecha'],$row_recepcion['producto'],$row_recepcion['volumen'],$GET_idEstacion,$con);
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

    echo '<tr>';
    echo '<th>'.$TAD.'</th>';
    echo '<td>'.$row_recepcion['fecha'].'</td>';
    echo '<td>'.$row_recepcion['no_factura'].'</td>';
    echo '<td>'.number_format($LitrosFacturados).'</td>';
    echo '<td>'.$CuentaLitros.'</td>';
    echo '<td>'.$MermaCuentaLitros.'</td>';
    echo '<td>'.$Tolerancia.'</td>';
    echo '<td>'.$Producto.'</td>';
    echo '<td>'.$Embarques['Transporte'].'</td>';
    echo '<td>'.$Unidad.'</td>';
    echo '<td>'.$Chofer.'</td>';
    echo '<td>$ '.number_format($ImporteFacturado,4).'</td>';
    echo '<td>$ '.number_format($ImporteTransporte,4).'</td>';
    echo '<td>$ '.number_format($PrecioPickup,4).'</td>';
    echo '<td>$ '.number_format($PrecioPemex,4).'</td>';
    echo '<td>$ '.number_format($Diferencia,4).'</td>';
    echo '<td>$ '.number_format($DiferenciaPemex,2).'</td>';
    echo '<td>$ '.number_format($ImporteMermaTotal,2).'</td>';
    echo '<td>'.$Merma.'</td>';
    echo '<td>$ '.number_format($ImporteMerma,2).'</td>';
    echo '<td class="p-0"><input type="text" class="border-0 p-2" value="'.$NotaCredito['NotaC'].'" onkeyup="NotaC(this,\''.$row_recepcion['no_factura'].'\',\''.$row_recepcion['fecha'].'\',1)"></td>';
    echo '<td>$ '.number_format($ImporteNota,2).'</td>';
    echo '<td>'.$FacturaTransporte.'</td>';
    echo '<td>$ '.number_format($MontoFactura,2).'</td>';
    echo '<td>$ '.number_format($TotalPagarTransporte,2).'</td>';
    echo '<td class="p-0"><select class="border-0 p-2" onchange="Status(this,\''.$row_recepcion['no_factura'].'\',\''.$row_recepcion['fecha'].'\',2)">
    <option>'.$NotaCredito['Status'].'</option>
    <option>Pendiente</option>
    <option>Pagada</option>
    </select></td>';
    echo '<td>$ '.number_format($Pickup,2).'</td>';
    echo '<td>$ '.number_format($Pemex,2).'</td>';
    echo '</tr>';

    $TotalDiferenciaPemex = $TotalDiferenciaPemex + $DiferenciaPemex;
    $TotalImporteMerma = $TotalImporteMerma + $ImporteMerma;
    $TotalImporteNota = $TotalImporteNota + $ImporteNota;
    $TotalPickup = $TotalPickup + $Pickup;
    $TotalPemex = $TotalPemex+ $Pemex;

    }
    ?>

    <tr>
      <th class="tables-bg" colspan="16"></th>
      <td class="tables-bg"><b>$ <?=number_format($TotalDiferenciaPemex,2);?></b></td>
      <td class="tables-bg" colspan="2"></td>
      <td class="tables-bg"><b>$ <?=number_format($TotalImporteMerma,2);?></b></td>
      <td class="tables-bg"></td>
      <td class="tables-bg"><b>$ <?=number_format($TotalImporteNota,2);?></b></td>
      <td class="tables-bg" colspan="4"></td>
      <td class="tables-bg"><b>$ <?=number_format($TotalPickup,2);?></b></td>
      <td class="tables-bg"><b>$ <?=number_format($TotalPemex,2);?></b></td>
    </tr>

  </tbody>
  </table>
  </div>


  </div>

  </div>
  </div>

  </div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

</body>
</html>