<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

  function IdReporte($Session_IDEstacion,$GET_year,$GET_mes,$con){
   $sql_year = "SELECT id, id_estacion, year FROM op_corte_year WHERE id_estacion = '".$Session_IDEstacion."' AND year = '".$GET_year."' ";
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

   function TarjetasCB($idReporte,$concepto,$con){
    $sql_cb = "SELECT * FROM op_tarjetas_c_b WHERE idreporte_dia = '".$idReporte."' AND concepto = '".$concepto."' LIMIT 1 ";
    $result_cb = mysqli_query($con, $sql_cb);
    while($row_cb = mysqli_fetch_array($result_cb, MYSQLI_ASSOC)){
    $baucher = $row_cb['baucher'];
    }

    return $baucher;
   }

  $IdReporte = IdReporte($GET_idEstacion,$GET_year,$GET_mes,$con); 

   $sql_dia = "SELECT id FROM op_corte_dia WHERE id_mes = '".$IdReporte."' ";
   $result_dia = mysqli_query($con, $sql_dia);
   while($row_dia = mysqli_fetch_array($result_dia, MYSQLI_ASSOC)){
   $id = $row_dia['id'];

   $bancomer = TarjetasCB($id,"BBVA BANCOMER SA",$con);
   $tobancomer = $tobancomer + $bancomer;
   $amex = TarjetasCB($id,"AMERICAN EXPRESS",$con);
   $toamex = $toamex + $amex;
   $inburgas = TarjetasCB($id,"INBURSA",$con);
   $toinburgas = $toinburgas + $inburgas;

   $ticketcard = TarjetasCB($id,"TICKETCARD",$con);
   $toticketcard = $toticketcard + $ticketcard;
   $g500fleet = TarjetasCB($id,"G500 FLETT",$con);
   $tog500fleet = $tog500fleet + $g500fleet;
   $efecticard = TarjetasCB($id,"EFECTICARD",$con);
   $toefecticard = $toefecticard + $efecticard;
   $sodexo = TarjetasCB($id,"SODEXO",$con);
   $tosodexo = $tosodexo + $sodexo;

   $sql_CCPC = "SELECT * FROM op_clientes_controlgas WHERE idreporte_dia = '".$id."' AND concepto = 'CRÉDITO (ANEXO)' LIMIT 1 ";
    $result_CCPC = mysqli_query($con, $sql_CCPC);
    while($row_CCPC = mysqli_fetch_array($result_CCPC, MYSQLI_ASSOC)){
    $pagoC = $pagoC + $row_CCPC['pago'];
    $consumoC = $consumoC + $row_CCPC['consumo'];
    }

    $sql_CDPC = "SELECT * FROM op_clientes_controlgas WHERE idreporte_dia = '".$id."' AND concepto = 'DEBITO (ANEXO)' LIMIT 1 ";
    $result_CDPC = mysqli_query($con, $sql_CDPC);
    while($row_CDPC = mysqli_fetch_array($result_CDPC, MYSQLI_ASSOC)){
    $pagoD = $pagoD + $row_CDPC['pago'];
    $consumoD = $consumoD + $row_CDPC['consumo'];
    }


   }

   $totalTB = $tobancomer + $toamex + $toinburgas;
   $totalTarjetas = $toticketcard + $tog500fleet + $toefecticard + $tosodexo;
   $totalPago = $pagoC + $pagoD;
   $totalConsumo = $consumoC + $consumoD;


function ProductoResultado($IdReporte,$producto,$con){

$sql_dia = "SELECT id FROM op_corte_dia WHERE id_mes = '".$IdReporte."' ";
$result_dia = mysqli_query($con, $sql_dia);
while($row_dia = mysqli_fetch_array($result_dia, MYSQLI_ASSOC)){
$id = $row_dia['id'];

$sql_listayear = "SELECT * FROM op_ventas_dia WHERE idreporte_dia = '".$id."' AND producto = '".$producto."' ";
$result_listayear = mysqli_query($con, $sql_listayear);
$numero_reporte = mysqli_num_rows($result_listayear);
while($row_listayear = mysqli_fetch_array($result_listayear, MYSQLI_ASSOC)){

$litros = $row_listayear['litros'];
$jarras = $row_listayear['jarras'];
$precio = $row_listayear['precio_litro'];

$tolitros = $tolitros + $litros;
$tojarras = $tojarras + $jarras;

$toprecio = ($toprecio + $precio) / 2;
$precioP = $toprecio / 30.5;

}

}

$array = array(
  'Litros' => $tolitros,
  'Jarras' => $tojarras,
  'PrecioPublico' => $precioP, 
);

return $array;
}

function TotalAceites($IdReporte,$con){

$sql_dia = "SELECT id FROM op_corte_dia WHERE id_mes = '".$IdReporte."' ";
$result_dia = mysqli_query($con, $sql_dia);
while($row_dia = mysqli_fetch_array($result_dia, MYSQLI_ASSOC)){
$id = $row_dia['id'];

$sql_listatotal = "SELECT cantidad, precio_unitario FROM op_aceites_lubricantes WHERE idreporte_dia = '".$id."' ";
$result_listatotal = mysqli_query($con, $sql_listatotal);
while($row_listatotal = mysqli_fetch_array($result_listatotal, MYSQLI_ASSOC)){
$cantidad = $row_listatotal['cantidad'];
$precio = $row_listatotal['precio_unitario'];

$total = $cantidad * $precio;
$totalimporte = $totalimporte + $total;

}

}

$array = array(
  'Totalimporte' => $totalimporte
);

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
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");

  });

  function Regresar(){
   window.history.back();
  }

 
  </script>
  </head>

<body > 
<div class="LoaderPage"></div>


    <!---------- DIV - CONTENIDO ----------> 
  <div id="content">
  <!---------- NAV BAR - PRINCIPAL (TOP) ---------->  
  <?php include_once "public/navbar/navbar-perfil.php";?>
  <!---------- CONTENIDO PAGINA WEB----------> 
  <div class="contendAG">
  <div class="row">

  <div class="col-12 mb-3">
  <div class="cardAG">
  <div class="border-0 p-3">

    <div class="row">

    <div class="col-12">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()"> 
    <div class="row">

     <div class="col-12">

    <h5>Resumen, <?=nombremes($GET_mes);?> <?=$GET_year;?></h5>

    </div>

    </div>

    </div>

    </div>

  <hr>
 
<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-3" style="font-size: .9em;">
<thead>
 <tr>
    <th colspan="10" class="align-middle text-center bg-light p-2" style="font-size: 1.02em;"><strong>Resumen Impuestos</strong></th>
  </tr>
</thead>

<thead class="tables-bg">
  <tr>
    <th class="align-middle text-center">Producto</th>
    <th class="align-middle text-center">Precio al Público</th>
    <th class="align-middle text-center">IEPS</th>
    <th class="align-middle text-center">PRECIO SIN IVA</th>
    <th class="align-middle text-center">IVA</th>
    <th class="align-middle text-center">VOLUMEN VENDIDO</th>
    <th class="align-middle text-center">IMPORTE SIN IVA</th>
    <th class="align-middle text-center">IVA</th>
    <th class="align-middle text-center">IEPS</th>
    <th class="align-middle text-center">TOTAL</th>
  </tr>
</thead>
<tbody>
<?php

$sql_listayear = "SELECT
op_ventas_dia.id,
op_ventas_dia.producto,
op_ventas_dia.ieps,
op_corte_dia.id_mes
FROM op_ventas_dia
INNER JOIN op_corte_dia
ON op_ventas_dia.idreporte_dia = op_corte_dia.id WHERE op_corte_dia.id_mes =  '".$IdReporte."' GROUP BY op_ventas_dia.producto ORDER BY op_ventas_dia.id asc";
    $result_listayear = mysqli_query($con, $sql_listayear);
    $numero_reporte = mysqli_num_rows($result_listayear);
if($numero_reporte > 0){

while($row_listayear = mysqli_fetch_array($result_listayear, MYSQLI_ASSOC)){

$producto = $row_listayear['producto'];
$ieps = $row_listayear['ieps'];

$ProductoR = ProductoResultado($IdReporte,$producto,$con);



$preciosiniva = ($ProductoR['PrecioPublico'] - $ieps) / 1.16;
$iva1 = $preciosiniva * 0.16;

$volumenv = $ProductoR['Litros'] - $ProductoR['Jarras'];
$importesiniva = $volumenv * $preciosiniva;
$iva2 = $importesiniva * 0.16;
$ieps2 = $volumenv * $ieps;
$total = $importesiniva + $iva2 + $ieps2;

$totalVV = $totalVV + $volumenv;
$totalISI = $totalISI + $importesiniva;
$totalIV2 = $totalIV2 + $iva2;
$totalIEPS2 = $totalIEPS2 + $ieps2;
$totalneto = $totalneto + $total;
?>

    <tr>
      <td><?=$producto;?></td>
      <td class="align-middle text-end">$<?=number_format($ProductoR['PrecioPublico'],4);?></td>
      <td class="align-middle text-end"><?=$ieps;?></td>
      <td class="align-middle text-end"><?=number_format($preciosiniva,4);?></td>
      <td class="align-middle text-end"><?=number_format($iva1,4);?></td>
      <td class="align-middle text-end"><?=number_format($volumenv,2);?></td>
      <td class="align-middle text-end"><?=number_format($importesiniva,2);?></td>
      <td class="align-middle text-end"><?=number_format($iva2,2);?></td>
      <td class="align-middle text-end"><?=number_format($ieps2,2);?></td>
      <td class="align-middle text-end"><?=number_format($total,2);?></td>
    </tr>
    <?php
    }

    $Totalaceites = TotalAceites($IdReporte,$con);
    $totalPrecio = $Totalaceites['Totalimporte'];
    $aceitessiniva = $totalPrecio / 1.16;
    $aceitesiva = $aceitessiniva * 0.16;
    ?>
      <tr>
    <td colspan="5" class="align-middle text-end">SUBTOTAL COMBUSTIBLES</td>
    <td class="align-middle text-end"><strong><?=number_format($totalVV,2);?></strong></td>
    <td class="align-middle text-end"><strong><?=number_format($totalISI,2);?></strong></td>
    <td class="align-middle text-end"><strong><?=number_format($totalIV2,2);?></strong></td>
    <td class="align-middle text-end"><strong><?=number_format($totalIEPS2,2);?></strong></td>
      <td class="align-middle text-end"><strong><?=number_format($totalneto,2);?></strong></td>
  </tr>
  <tr>
    <td colspan="6" class="align-middle text-end">ACEITES</td>
    <td class="align-middle text-end"><?=number_format($aceitessiniva,2);?></td>
    <td class="align-middle text-end"><?=number_format($aceitesiva,2);?></td>
    <td></td>
    <td class="align-middle text-end"><?=number_format($totalPrecio,2);?></td>
  </tr>
  <tr>
    <?php
    $totaldiasi = $totalISI + $aceitessiniva;
    $totaldiaiva = $totalIV2 + $aceitesiva;
    $totaldia = $totalneto + $totalPrecio;
    ?>
    <td colspan="6" class="align-middle text-end">TOTAL DEL DÍA</td>
    <td class="align-middle text-end"><strong><?=number_format($totaldiasi,2);?></strong></td>
    <td class="align-middle text-end"><strong><?=number_format($totaldiaiva,2);?></strong></td>
    <td class="align-middle text-end"><strong><?=number_format($totalIEPS2,2);?></strong></td>
      <td class="align-middle text-end"><strong><?=number_format($totaldia,2);?></strong></td>
  </tr>
  <?php
  }else{
    echo "<tr><td colspan='10' class='align-middle text-center p-3'>No se encontró información para mostrar </td></tr>";
  }
  ?>
</tbody>
</table>
</div>



<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0" style="font-size: .9em;">
<thead>
 <tr>
    <th colspan="15" class="align-middle text-center bg-light p-2" style="font-size: 1.02em;"><strong>Resumen Monederos</strong></th>
  </tr>
</thead>

<thead >
  <tr>
  <td class="text-center align-middle" colspan="9"></td>
  <td class="text-center align-middle" colspan="2">CRÉDITO</td>
  <td class="text-center align-middle" colspan="2">DÉBITO</td>
  <td class="text-center align-middle" >PAGOS</td>
  <td class="text-center align-middle" >CONSUMOS</td>
  </tr>
  <tr>
    <td  class="text-center align-middle" colspan="4"><b>TARJETAS BANCARIAS</b></td>
    <td  class="text-center align-middle" colspan="5"><b>TARJETAS</b></td>
    <td  class="text-center align-middle" colspan="6"><b>Cartera de Clientes ATIO</b></td>
  </tr>
  <tr class="tables-bg">
    <td class="text-center align-middle" ><b>BANCOMER</b></td>
    <td class="text-center align-middle" ><b>AMEX</b></td>
    <td class="text-center align-middle" ><b>INBURSA</b></td>
    <td class="text-center align-middle" ><b>TOTAL</b></td>

    <td class="text-center align-middle" ><b>TICKETCARD</b></td>
    <td class="text-center align-middle" ><b>G500 FLETT</b></td>
    <td class="text-center align-middle" ><b>EFECTICARD</b></td>
    <td class="text-center align-middle" ><b>SODEXO</b></td>
    <td class="text-center align-middle" ><b>TOTAL</b></td>
    <td class="text-center align-middle" ><b>Pagos</b></td>
    <td class="text-center align-middle" ><b>Consumos</b></td>
    <td class="text-center align-middle" ><b>Pagos</b></td>
    <td class="text-center align-middle" ><b>Consumos</b></td>
    <td class="text-center align-middle" ><b>TOTAL</b></td>
    <td class="text-center align-middle" ><b>TOTAL</b></td>
  </tr>
</thead>
<tbody>
<tr class="bg-light">
  <td class="align-middle text-end">
    $<?=number_format($tobancomer,2);?>
  </td>
  <td class="align-middle text-end">
    $<?=number_format($toamex,2);?>
  </td>
  <td class="align-middle text-end">
    $<?=number_format($toinburgas,2);?>
  </td>
  <td class="align-middle text-end">
   <strong>$<?=number_format($totalTB,2);?></strong>
  </td>
  <td class="align-middle text-end">
    $<?=number_format($toticketcard,2);?>
  </td>
  <td class="align-middle text-end">
   $<?=number_format($tog500fleet,2);?>
  </td>
  <td class="align-middle text-end">
   $<?=number_format($toefecticard,2);?>
  </td>
   <td class="align-middle text-end">
   $<?=number_format($tosodexo,2);?>
  </td>
  <td class="align-middle text-end">
    <strong>$<?=number_format($totalTarjetas,2);?></strong>
  </td>
  <td class="align-middle text-end">
    $<?=number_format($pagoC,2);?>
  </td>
  <td class="align-middle text-end">
    $<?=number_format($consumoC,2);?>
  </td>
  <td class="align-middle text-end">
   $<?=number_format($pagoD,2);?>
  </td>
  <td class="align-middle text-end">
    $<?=number_format($consumoD,2);?>
  </td>
  <td class="align-middle text-end">
    <strong>$<?=number_format($totalPago,2);?></strong>
  </td>
  <td class="align-middle text-end">
    <strong>$<?=number_format($totalConsumo,2);?></strong>
  </td>
</tr>
</tbody>
</table>
</div>


  </div>
  </div>
  </div>

  </div>
  </div>

  </div>









  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="<?=RUTA_JS2 ?>navbar-functions.js"></script>
  
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>

