<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

$sql_dia = "SELECT id_estacion, year FROM op_corte_year WHERE id = '".$GET_reporte."' LIMIT 1 ";
   $result_dia = mysqli_query($con, $sql_dia);
   while($row_dia = mysqli_fetch_array($result_dia, MYSQLI_ASSOC)){
   $idestacion = $row_dia['id_estacion'];
   $GET_year = $row_dia['year'];
   }

$sql_est = "SELECT nombre FROM tb_estaciones WHERE id = '".$idestacion."' LIMIT 1 ";
   $result_est = mysqli_query($con, $sql_est);
   while($row_est = mysqli_fetch_array($result_est, MYSQLI_ASSOC)){
   $NomEstacion = $row_est['nombre'];
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

  IngresosFacturacion(<?=$GET_reporte;?>);
  
  });

  function Regresar(){
  window.history.back();
  } 

  function IngresosFacturacion(idReporte){
  $('#DivContenido').load('../../public/admin/vistas/resumen-ingresos-facturacion.php?idReporte=' + idReporte);
  } 
  function EditIF(idReporte,id,mes,posicion){

  var valor = $('#D' + posicion + mes + id).val();

      var D1 = 0;
      var D2 = 0;
      var D3 = 0;
      var D4 = 0;
      var D5 = 0;
      var D6 = 0;
      var D7 = 0;
      var D8 = 0;
      var D9 = 0;
      var D10 = 0;
      var D11 = 0;
      var D12 = 0;

  var parametros = {
    "id" : id,
    "mes" : mes,
    "valor" : valor
    };

    $.ajax({
     data:  parametros,
     url:   '../../public/corte-diario/modelo/editar-ingreso-facturacion.php',
     type:  'post',
     beforeSend: function() {
     },
     complete: function(){
    
     },
     success:  function (response) {

      if(response == 1){

        if(posicion == 1){

      D1 = $('#D11' + id).val();
      D2 = $('#D12' + id).val();
      D3 = $('#D13' + id).val();
      D4 = $('#D14' + id).val();
      D5 = $('#D15' + id).val();
      D6 = $('#D16' + id).val();
      D7 = $('#D17' + id).val();
      D8 = $('#D18' + id).val();
      D9 = $('#D19' + id).val();
      D10 = $('#D110' + id).val();
      D11 = $('#D111' + id).val();
      D12 = $('#D112' + id).val();

      if(D1 == ""){D1 = 0;}else{D1 = D1;}
      if(D2 == ""){D2 = 0;}else{D2 = D2;}
      if(D3 == ""){D3 = 0;}else{D3 = D3;}
      if(D4 == ""){D4 = 0;}else{D4 = D4;}
      if(D5 == ""){D5 = 0;}else{D5 = D5;}
      if(D6 == ""){D6 = 0;}else{D6 = D6;}
      if(D7 == ""){D7 = 0;}else{D7 = D7;}
      if(D8 == ""){D8 = 0;}else{D8 = D8;}
      if(D9 == ""){D9 = 0;}else{D9 = D9;}
      if(D10 == ""){D10 = 0;}else{D10 = D10;}
      if(D11 == ""){D11 = 0;}else{D11 = D11;}
      if(D12 == ""){D12 = 0;}else{D12 = D12;}

  Total = parseInt(D1) + parseInt(D2) + parseInt(D3) + parseInt(D4) + parseInt(D5) + parseInt(D6) + parseInt(D7) + parseInt(D8) + parseInt(D9) + parseInt(D10) + parseInt(D11) + parseInt(D12);

  $('#TE1' + id).text('$ ' + number_format(Total, 2, '.', ''));

  Totales(idReporte,id,mes,posicion);

        }else if(posicion == 2){

      D1 = $('#D21' + id).val();
      D2 = $('#D22' + id).val();
      D3 = $('#D23' + id).val();
      D4 = $('#D24' + id).val();
      D5 = $('#D25' + id).val();
      D6 = $('#D26' + id).val();
      D7 = $('#D27' + id).val();
      D8 = $('#D28' + id).val();
      D9 = $('#D29' + id).val();
      D10 = $('#D210' + id).val();
      D11 = $('#D211' + id).val();
      D12 = $('#D212' + id).val();

      if(D1 == ""){D1 = 0;}else{D1 = D1;}
      if(D2 == ""){D2 = 0;}else{D2 = D2;}
      if(D3 == ""){D3 = 0;}else{D3 = D3;}
      if(D4 == ""){D4 = 0;}else{D4 = D4;}
      if(D5 == ""){D5 = 0;}else{D5 = D5;}
      if(D6 == ""){D6 = 0;}else{D6 = D6;}
      if(D7 == ""){D7 = 0;}else{D7 = D7;}
      if(D8 == ""){D8 = 0;}else{D8 = D8;}
      if(D9 == ""){D9 = 0;}else{D9 = D9;}
      if(D10 == ""){D10 = 0;}else{D10 = D10;}
      if(D11 == ""){D11 = 0;}else{D11 = D11;}
      if(D12 == ""){D12 = 0;}else{D12 = D12;}


  Total2 = parseInt(D1) + parseInt(D2) + parseInt(D3) + parseInt(D4) + parseInt(D5) + parseInt(D6) + parseInt(D7) + parseInt(D8) + parseInt(D9) + parseInt(D10) + parseInt(D11) + parseInt(D12);

  $('#TE2' + id).text('$ ' + number_format(Total2, 2, '.', ''));

  Totales(idReporte,id,mes,posicion);

        }

      }else{
      alertify.error('Error al agregar')
      }

     }
     });

    }

    function number_format(amount, decimals) {

    amount += ''; // por si pasan un numero en vez de un string
    amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

    decimals = decimals || 0; // por si la variable no fue fue pasada

    // si no es un numero o es igual a cero retorno el mismo cero
    if (isNaN(amount) || amount === 0) 
        return parseFloat(0).toFixed(decimals);

    // si es mayor o menor que cero retorno el valor formateado como numero
    amount = '' + amount.toFixed(decimals);

    var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;

    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

    return amount_parts.join('.');
}

function Totales(idReporte,id,mes,posicion){

  var parametros = {
    "idReporte" : idReporte,
    "id" : id,
    "mes" : mes,
    "posicion" : posicion
    };

 $.ajax({
     data:  parametros,
     url:   '../../public/corte-diario/vistas/total-ingreso-facturacion.php',
     type:  'GET',
     dataType : 'json',
     beforeSend: function() {
     },
     complete: function(){
    
     },
     success:  function (response) {

$('#T11').text(response.TCE1);
$('#T12').text(response.TCF1);
$('#T13').text(response.TCM1);
$('#T14').text(response.TCA1);
$('#T15').text(response.TCMY1);
$('#T16').text(response.TCJN1);
$('#T17').text(response.TCJL1);
$('#T18').text(response.TCAS1);
$('#T19').text(response.TCS1);
$('#T110').text(response.TCO1);
$('#T111').text(response.TCN1);
$('#T112').text(response.TCD1);
$('#TF1').text(response.TCTEJ1);

$('#T21').text(response.TCE2);
$('#T22').text(response.TCF2);
$('#T23').text(response.TCM2);
$('#T24').text(response.TCA2);
$('#T25').text(response.TCMY2);
$('#T26').text(response.TCJN2);
$('#T27').text(response.TCJL2);
$('#T28').text(response.TCAS2);
$('#T29').text(response.TCS2);
$('#T210').text(response.TCO2);
$('#T211').text(response.TCN2);
$('#T212').text(response.TCD2);
$('#TF2').text(response.TCTEJ2);


    $('#TD1').text(response.TD1);
    $('#TD2').text(response.TD2);
    $('#TD3').text(response.TD3);
    $('#TD4').text(response.TD4);
    $('#TD5').text(response.TD5);
    $('#TD6').text(response.TD6);
    $('#TD7').text(response.TD7);
    $('#TD8').text(response.TD8);
    $('#TD9').text(response.TD9);
    $('#TD10').text(response.TD10);
    $('#TD11').text(response.TD11);
    $('#TD12').text(response.TD12);
    $('#TDTE').text(response.TDTE);


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

  <div class="col-12 mb-3">
  <div class="cardAG">
  <div class="border-0 p-3">

    <div class="row">
    <div class="col-12">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    
    <div class="row">
    <div class="col-12">

     <h5>Ingresos VS Facturación <?=$GET_year;?> (<?=$NomEstacion;?>)</h5>
    
    </div>
    </div>

    </div>
    </div>

  <hr>

 <div id="DivContenido"></div>

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
