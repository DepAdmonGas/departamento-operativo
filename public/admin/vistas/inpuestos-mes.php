<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

$sql_dia = "SELECT fecha FROM op_corte_dia WHERE id = '".$GET_idReporte."' ";
   $result_dia = mysqli_query($con, $sql_dia);
   while($row_dia = mysqli_fetch_array($result_dia, MYSQLI_ASSOC)){
   $dia = $row_dia['fecha'];
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
  
  <body>
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

     <h5>Impuestos, <?=FormatoFecha($dia);?></h5>
    
    </div>
    </div>

    </div>
    </div>

  <hr>

 <div style="overflow: auto;width: 100%;">
<table class="table table-sm table-bordered pb-0 mb-0 mt-1" style="font-size: .9em;">
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
    $sql_listayear = "SELECT * FROM op_ventas_dia WHERE idreporte_dia = '".$GET_idReporte."' ";
    $result_listayear = mysqli_query($con, $sql_listayear);
    $numero_reporte = mysqli_num_rows($result_listayear);

    if($numero_reporte > 0){


    while($row_listayear = mysqli_fetch_array($result_listayear, MYSQLI_ASSOC)){

      $idventas = $row_listayear['id'];
      $producto = $row_listayear['producto'];
      $litrosventas = $row_listayear['litros'];
      $jarrasventas = $row_listayear['jarras'];
      $precio_litroventas = $row_listayear['precio_litro'];
      $ieps = $row_listayear['ieps'];

      $preciosiniva = ($precio_litroventas - $ieps)  / 1.16;
      $iva1 = $preciosiniva * 0.16;

      $volumenv = $litrosventas - $jarrasventas;
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
      <td class="align-middle text-end">$<?=number_format($precio_litroventas,2);?></td>
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

    $sql_listaaceites = "SELECT * FROM op_aceites_lubricantes WHERE idreporte_dia = '".$GET_idReporte."' ";
    $result_listaaceites = mysqli_query($con, $sql_listaaceites);
    while($row_listaaceites = mysqli_fetch_array($result_listaaceites, MYSQLI_ASSOC)){

    $importe = $row_listaaceites['cantidad'] * $row_listaaceites['precio_unitario'];
    $totalPrecio = $totalPrecio + $importe;
    }

    $aceitessiniva = $totalPrecio / 1.16;
    $aceitesiva = $aceitessiniva * 0.16;
  ?>

  
  <tr>
    <th colspan="5" class="align-middle text-end">SUBTOTAL COMBUSTIBLES</th>
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
  <tr class="bg-light">
    <?php
    $totaldiasi = $totalISI + $aceitessiniva;
    $totaldiaiva = $totalIV2 + $aceitesiva;
    $totaldia = $totalneto + $totalPrecio;
    ?>
    <th colspan="6" class="align-middle text-end">TOTAL DEL DÍA</th>
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


  </div>
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

