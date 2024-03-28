<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
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

    <?php 

   $sql_dia = "SELECT fecha FROM op_corte_dia WHERE id = '".$GET_idReporte."' ";
   $result_dia = mysqli_query($con, $sql_dia);
   while($row_dia = mysqli_fetch_array($result_dia, MYSQLI_ASSOC)){
   $dia = $row_dia['fecha'];
   }

   function TarjetasCB($idReporte,$concepto,$con){
    $sql_cb = "SELECT * FROM op_tarjetas_c_b WHERE idreporte_dia = '".$idReporte."' AND concepto = '".$concepto."' LIMIT 1 ";
    $result_cb = mysqli_query($con, $sql_cb);
    while($row_cb = mysqli_fetch_array($result_cb, MYSQLI_ASSOC)){
    $baucher = $row_cb['baucher'];
    }

    return $baucher;
   }


    $bancomer = TarjetasCB($GET_idReporte,"BBVA BANCOMER SA",$con);
    $amex = TarjetasCB($GET_idReporte,"AMERICAN EXPRESS",$con);
    $inburgas = TarjetasCB($GET_idReporte,"INBURGAS",$con);
    $inbursa = TarjetasCB($GET_idReporte,"INBURSA",$con);

    $totalTB = $bancomer + $amex + $inburgas + $inbursa;

    $ticketcard = TarjetasCB($GET_idReporte,"TICKETCARD",$con);
    $g500fleet = TarjetasCB($GET_idReporte,"G500 FLETT",$con);
    $efecticard = TarjetasCB($GET_idReporte,"EFECTICARD",$con);
    $sodexo = TarjetasCB($GET_idReporte,"SODEXO",$con);

    $totalTarjetas = $ticketcard + $g500fleet + $efecticard + $sodexo;

    $valaccord = TarjetasCB($GET_idReporte,"VALE ACCORD",$con);
    $valefectivale = TarjetasCB($GET_idReporte,"VALE EFECTIVALE",$con);
    $valsodexo = TarjetasCB($GET_idReporte,"VALE SODEXO",$con);
    $valvale = TarjetasCB($GET_idReporte,"SI VALE",$con);
    
    $totalVales = $valaccord + $valefectivale + $valsodexo + $valvale;

    $sql_CCPC = "SELECT * FROM op_clientes_controlgas WHERE idreporte_dia = '".$GET_idReporte."' AND concepto = 'CRÉDITO (ANEXO)' LIMIT 1 ";
    $result_CCPC = mysqli_query($con, $sql_CCPC);
    while($row_CCPC = mysqli_fetch_array($result_CCPC, MYSQLI_ASSOC)){
    $pagoC = $row_CCPC['pago'];
    $consumoC = $row_CCPC['consumo'];
    }

    $sql_CDPC = "SELECT * FROM op_clientes_controlgas WHERE idreporte_dia = '".$GET_idReporte."' AND concepto = 'DEBITO (ANEXO)' LIMIT 1 ";
    $result_CDPC = mysqli_query($con, $sql_CDPC);
    while($row_CDPC = mysqli_fetch_array($result_CDPC, MYSQLI_ASSOC)){
    $pagoD = $row_CDPC['pago'];
    $consumoD = $row_CDPC['consumo'];
    }


    function fechaReporte($GET_idReporte,$con){

      $sql_corte = "SELECT fecha FROM op_corte_dia WHERE id = '".$GET_idReporte."' ";
      $result_corte = mysqli_query($con, $sql_corte);
      
      while($row_corte = mysqli_fetch_array($result_corte, MYSQLI_ASSOC)){
      $fecha_reporte = $row_corte['fecha'];
      }
      
      return $fecha_reporte;
      }
      
      
      function aperturaReporte($GET_idReporte,$con){
        $sql_corte_activado = "SELECT id FROM op_corte_dia_hist WHERE id_corte = '".$GET_idReporte."' ";
        $result_corte_activado = mysqli_query($con, $sql_corte_activado );
        return $numero_corte_activado  = mysqli_num_rows($result_corte_activado );
      
      }
      
      

      
    ?>

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

     <h5>Monedero, <?=FormatoFecha($dia);?></h5>
    
    </div>
    </div>

    </div>
    </div>

  <hr>

  <div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0" style="font-size: .9em;">
<thead >
  <tr>
  <th class="text-center align-middle" colspan="14"></th>
  <th class="text-center align-middle" colspan="2">CRÉDITO</th>
  <th class="text-center align-middle" colspan="2">DÉBITO</th>
  <th class="text-center align-middle" >PAGOS</th>
  <th class="text-center align-middle" >CONSUMOS</th>
  </tr>

  <tr>
    <th  class="text-center align-middle" colspan="5">TARJETAS BANCARIAS</th>
    <th  class="text-center align-middle" colspan="4">TARJETAS</th>
    <th  class="text-center align-middle" colspan="5">VALES</th>
    <th  class="text-center align-middle" colspan="6">Cartera de Clientes ATIO </th>
  </tr>

  <tr class="tables-bg">
    <th class="text-center align-middle" >BANCOMER</th>
    <th class="text-center align-middle" >AMEX</th>
    <th class="text-center align-middle" >INBURGAS</th>
    <th class="text-center align-middle" >INBURSA</th>
    <th class="text-center align-middle" >TOTAL</th>

    <th class="text-center align-middle" >TICKETCARD</th>
    <!-- <th class="text-center align-middle" >G500 FLETT</th> -->
    <th class="text-center align-middle" >EFECTICARD</th>
    <th class="text-center align-middle" >SODEXO</th>
    <th class="text-center align-middle" >TOTAL</th>

    <th class="text-center align-middle">VALE ACCORD</th>
    <th class="text-center align-middle">VALE EFECTIVALE</th>
    <th class="text-center align-middle">VALE SODEXO</th>
    <th class="text-center align-middle">SI VALE</th>
    <th class="text-center align-middle" >TOTAL</th>

    <th class="text-center align-middle" >Pagos</th>
    <th class="text-center align-middle" >Consumos</th>
    <th class="text-center align-middle" >Pagos</th>
    <th class="text-center align-middle" >Consumos</th>
    <th class="text-center align-middle" >TOTAL</th>
    <th class="text-center align-middle" >TOTAL</th>
  </tr>
</thead>
<tbody>
<tr class="bg-light">
 <td class="align-middle text-end">
    $<?=number_format($bancomer,2);?>
  </td>
  <td class="align-middle text-end">
    $<?=number_format($amex,2);?>
  </td>
  <td class="align-middle text-end">
    $<?=number_format($inburgas,2);?>
  </td>
  <td class="align-middle text-end">
    $<?=number_format($inbursa,2);?>
  </td>
  <td class="align-middle text-end">
   <strong>$<?=number_format($totalTB,2);?></strong>
  </td>
  <td class="align-middle text-end">
    $<?=number_format($ticketcard,2);?>
  </td>

  <!--
  <td class="align-middle text-end">
   $<?=number_format($g500fleet,2);?>
  </td>
  -->
  
  <td class="align-middle text-end">
   $<?=number_format($efecticard,2);?>
  </td>
   <td class="align-middle text-end">
   $<?=number_format($sodexo,2);?>
  </td>
  <td class="align-middle text-end">
    <strong>$<?=number_format($totalTarjetas,2);?></strong>
  </td>

   <!----------------------------------------------------->
  <td class="align-middle text-end">
    $<?=number_format($valaccord,2);?>
  </td>
  <td class="align-middle text-end">
    $<?=number_format($valefectivale,2);?>
  </td>
  <td class="align-middle text-end">
    $<?=number_format($valsodexo,2);?>
  </td>
  <td class="align-middle text-end">
    $<?=number_format($valvale,2);?>
  </td>
  <td class="align-middle text-end">
    <strong>$<?=number_format($totalVales,2);?></strong>
  </td>

  <!----------------------------------------------------->
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
  
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>
    </body>
  </html>

