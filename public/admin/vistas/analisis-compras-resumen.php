<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

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
WHERE YEAR(re_reporte_cre_producto.fecha) = '".$GET_year."' AND MONTH (re_reporte_cre_producto.fecha) = '".$GET_mes."' ORDER BY re_reporte_cre_producto.fecha ASC, re_reporte_cre_mes.id_estacion ASC";
$result_recepcion = mysqli_query($con, $sql_recepcion);
$numero_recepcion = mysqli_num_rows($result_recepcion);


function Estacion($idEstacion,$con){

$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
}

return $estacion;
}



function Embarques($fecha,$producto,$volumen,$preciolitro,$IdEstacion,$con){

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
op_formato_precios_detalle.id,
op_formato_precios_detalle.producto,
op_formato_precios_detalle.pemex,
op_formato_precios.fecha
FROM op_formato_precios_detalle 
INNER JOIN
op_formato_precios ON 
op_formato_precios_detalle.id_precio = op_formato_precios.id
WHERE op_formato_precios.fecha = '".$fecha."' AND op_formato_precios_detalle.producto = '".$ValProducto."' ";
   $result = mysqli_query($con, $sql);
   while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $Pemex = $row['pemex'];
   }

$array = array('Pemex' => $Pemex);

return $array;

}

function NotaCredito($fecha,$nofactura,$con){

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
  <link rel="shortcut icon" href="<?php echo RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="apple-touch-icon" href="<?php echo RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="stylesheet" href="<?php echo RUTA_CSS ?>alertify.css">
  <link rel="stylesheet" href="<?php echo RUTA_CSS ?>themes/default.rtl.css">
  <link href="<?php echo RUTA_CSS ?>bootstrap.css" rel="stylesheet" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?php echo RUTA_JS ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  <style media="screen">
  .LoaderPage {
  position: fixed;
  left: 0px;
  top: 0px;
  width: 100%;
  height: 100%;
  z-index: 9999;
  background: url('../../../imgs/iconos/load-img.gif') 50% 50% no-repeat rgb(249,249,249);
  }
  .grayscale {
  filter: opacity(50%); 
  }
  </style>
  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  $('[data-toggle="tooltip"]').tooltip();


  });

  function Regresar(){
  window.history.back();
  }

  function ModalBuscar(year, mes){

  $('#Modal').modal('show');
  $('#DivEmbarques').load('../../../public/admin/vistas/modal-analisis-compra.php?year=' + year + '&mes=' + mes);
  } 

  function Buscar(year,mes){

var BTad = $('#BTad').val();
var BEstacion = $('#BEstacion').val();
var BProducto = $('#BProducto').val();
var BTransporte = $('#BTransporte').val();
var BUnidad = $('#BUnidad').val();
var BStatus = $('#BStatus').val();


 var parametros = {
    "year" : year,
    "mes" : mes,
    "BTad" : BTad,
    "BEstacion" : BEstacion,
    "BProducto" : BProducto,
    "BTransporte" : BTransporte,
    "BUnidad" : BUnidad,
    "BStatus" : BStatus
    };

       $.ajax({
     data:  parametros,
     url:   '../../../public/admin/vistas/analisis-compras-reporte.php',
     type:  'post',
     beforeSend: function() {
     },
     complete: function(){

     },
     success:  function (response) {

      $('#Modal').modal('hide');
      $('#ResultadoReporte').html(response);

     }
     });



}

function SalirResumen(){
  window.location.reload()
}

  </script>
  <style type="text/css">
    .tableFixHead{
    overflow-x: scroll;
    overflow-y: scroll;
    }

    .tableFixHead thead tr th{
      position: sticky;
      top: -1px;
    }


 </style>
  </head>
  <body>

  <div class="LoaderPage"></div>
  <div class="p-4">
  <div class="card">
  <div class="card-body">
  

    <div class="row">
    <div class="col-12">

    <img class="float-left" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    
    <div class="row">
    <div class="col-12">

    <h5> Pick up  G500 Net work, <?=nombremes($GET_mes);?> <?=$GET_year;?></h5>
    
    </div>
    </div>

    </div>
    </div>

<hr> 


  <div id="ResultadoReporte">


  <div class="text-right mt-2 mb-2">
  <a class="mr-2" onclick="ModalBuscar(<?=$GET_year?>,<?=$GET_mes?>)"><img src="<?=RUTA_IMG_ICONOS;?>buscar.png"></a>

  <a href="../../../public/admin/vistas/descargar-resumen-analisis-compra.php?Year=<?=$GET_year;?>&Month=<?=$GET_mes;?>"><img src="<?=RUTA_IMG_ICONOS;?>excel.png"></a>
  </div>

  <hr>

  <div class="tableFixHead" style="height: 750px">
  <table class="table-bordered table-sm table-hover" style="font-size: .9em;width: 3400px;">
    <thead>
      <tr>
        <th class="align-middle bg-light p-2">TAD</th>
        <th class="align-middle bg-light" width="120">Fecha</th>
        <th class="align-middle bg-light" width="100">Estacion</th>
        <th class="align-middle bg-light">No. Factura</th>
        <th class="align-middle bg-light">Litros factura</th>
        <th class="align-middle bg-light">Cuenta litros</th>
        <th class="align-middle bg-light">Merma con cuenta litros</th>
        <th class="align-middle bg-light">Tolerancia de Merma .55%</th>
        <th class="align-middle bg-light">Producto</th>
        <th class="align-middle bg-light">Transporte</th>
        <th class="align-middle bg-light">Unidad</th>
        <th class="align-middle bg-light">Chofer</th>
        <th class="align-middle bg-light">Importe G500 Facturado</th>
        <th class="align-middle bg-light">Importe Transporte</th>
        <th class="align-middle bg-light">Precio Pickup facturado</th>
        <th class="align-middle bg-light">Precio Pemex</th>
        <th class="align-middle bg-light">Diferencia</th>
        <th class="align-middle bg-light">Diferencial $ vs Pemex</th>
        <th class="align-middle bg-light">Importe merma total $</th>
        <th class="align-middle bg-light">Merma</th>
        <th class="align-middle bg-light">Importe Merma</th>
        <th class="align-middle bg-light">NOTA C</th>
        <th class="align-middle bg-light">Importe Nota</th>
        <th class="align-middle bg-light">Factura Transporte no.</th>
        <th class="align-middle bg-light">Monto factura</th>
        <th class="align-middle bg-light">Total a pagar transporte</th>
        <th class="align-middle bg-light">Status</th>
        <th class="align-middle bg-light" width="100">PICKUP</th>
        <th class="align-middle bg-light" width="100">PEMEX</th>
      </tr>
    </thead>
    <tbody style="font-size: .85em;">

    <?php 

    while($row_recepcion = mysqli_fetch_array($result_recepcion, MYSQLI_ASSOC)){

    $idEstacion = $row_recepcion['id_estacion'];

    $Embarques = Embarques($row_recepcion['fecha'],$row_recepcion['producto'],$row_recepcion['volumen'],$row_recepcion['precio_litro'],$idEstacion,$con);

    $Tuxpan = Tuxpan($row_recepcion['fecha'],$row_recepcion['producto'],$row_recepcion['volumen'],$idEstacion,$con);

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


    $Estacion = Estacion($row_recepcion['id_estacion'],$con);

    echo '<tr>';
    echo '<td>'.$TAD.'</td>';
    echo '<td>'.$row_recepcion['fecha'].'</td>';
    echo '<td><b>'.$Estacion.'</b></td>';
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
    echo '<td>'.$NotaCredito['NotaC'].'</td>';
    echo '<td>$ '.number_format($ImporteNota,2).'</td>';
    echo '<td>'.$FacturaTransporte.'</td>';
    echo '<td>$ '.number_format($MontoFactura,2).'</td>';
    echo '<td>$ '.number_format($TotalPagarTransporte,2).'</td>';
    echo '<td>'.$NotaCredito['Status'].'</td>';
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
      <td colspan="17"></td>
      <td><b>$ <?=number_format($TotalDiferenciaPemex,2);?></b></td>
      <td colspan="2"></td>
      <td><b>$ <?=number_format($TotalImporteMerma,2);?></b></td>
      <td></td>
      <td><b>$ <?=number_format($TotalImporteNota,2);?></b></td>
      <td colspan="4"></td>
      <td><b>$ <?=number_format($TotalPickup,2);?></b></td>
      <td><b>$ <?=number_format($TotalPemex,2);?></b></td>
    </tr>
  </tbody>
  </table>

  </div>
  </div>


  </div>
  </div>
  </div>

  <div class="modal" id="Modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div id="DivEmbarques"></div>
  
    </div>
  </div>
</div>

<script src="<?php echo RUTA_JS ?>bootstrap.min.js"></script>
</body>
</html>