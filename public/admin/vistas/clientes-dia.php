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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" ></script>

  <style media="screen">

.tableFixHead{
  overflow-y: scroll;
}
.tableFixHead thead th{
  position: sticky;
  top: 0px;
  box-shadow: 2px 2px 7px #ECECEC;
}
  </style>

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  

   $('.select').selectize({
          sortField: 'text'
      });
 
  var margint = -530;
  var ventana_alto = $(document).height();
  ResultAlto = ventana_alto - margint;
  box = document.getElementsByClassName('tableFixHead')[0];
  box.style.height = ResultAlto + 'px';

   ListaConsumoPago(<?=$GET_idReporte;?>);

  });

  function Regresar(){
   window.history.back();
  } 

  function ListaConsumoPago(idReporte){
 $('#ConsumosPagos').load('../../../../public/admin/vistas/lista-consumo-pagos.php?idReporte=' + idReporte);
  }

  function ClientesLista(year, mes, idDias){
   window.location.href = "../../../clientes-lista/" + year + "/" + mes + "/" + idDias;
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

    <div class="col-xl-11 col-lg-11 col-md-11 col-sm-12">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    <div class="row">

     <div class="col-12">

      <h5>
     Clientes, <?=FormatoFecha($dia);?> 
      </h5>

    </div>

    </div>

    </div>


    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12">
    <img class="float-end pointer" src="<?=RUTA_IMG_ICONOS;?>clientes.png" onclick="ClientesLista(<?=$GET_year;?>,<?=$GET_mes;?>,<?=$GET_idReporte;?>)">
    </div>

    </div>

  <hr>

  <div class="tableFixHead mt-2">
  <div id="ConsumosPagos"></div>
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

