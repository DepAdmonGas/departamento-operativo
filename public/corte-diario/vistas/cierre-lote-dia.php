<?php
require('app/help.php');
include_once 'app/modelo/CorteDiarioGeneral.php';
$funcion = new CorteDiarioGeneral();
$tpv = $funcion->getTpv();
 $sql_dia = "SELECT tpv FROM op_corte_dia WHERE id = '".$GET_idReporte."' ";
   $result_dia = mysqli_query($con, $sql_dia);
   while($row_dia = mysqli_fetch_array($result_dia, MYSQLI_ASSOC)){
   $tpv = $row_dia['tpv'];   
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

  Ticketcard(<?=$GET_idReporte;?>,'TICKETCARD');
  Amex(<?=$GET_idReporte;?>,'AMERICAN EXPRESS');
  G500Fleet(<?=$GET_idReporte;?>,'G500 FLETT');
  BANCOMER(<?=$GET_idReporte;?>,'BBVA BANCOMER SA');
  Efecticard(<?=$GET_idReporte;?>,'EFECTICARD');
  Sodexo(<?=$GET_idReporte;?>,'SODEXO');
  Inburgas(<?=$GET_idReporte;?>,'INBURGAS');

  Ultragas(<?=$GET_idReporte;?>,'ULTRAGAS');
  Energex(<?=$GET_idReporte;?>,'ENERGEX');

  Inbursa(<?=$GET_idReporte;?>,'INBURSA');
  
  });

  function Regresar(){
   window.history.back();
  }

 function Ticketcard(idReporte,empresa){

    var parametros = {
    "idReporte" : idReporte,
    "empresa" : empresa
    };

   $.ajax({
     data:  parametros,
     url:   '../../../public/corte-diario/vistas/lista-cierre-lote.php',
     type:  'get',
     beforeSend: function() {
     },
     complete: function(){

     },
     success:  function (response) {

      $('#DivTicketcard').html(response);

     }
     });

  }
 
   function Amex(idReporte,empresa){

  var parametros = {
    "idReporte" : idReporte,
    "empresa" : empresa
    };

   $.ajax({
     data:  parametros,
     url:   '../../../public/corte-diario/vistas/lista-cierre-lote.php',
     type:  'get',
     beforeSend: function() {
     },
     complete: function(){

     },
     success:  function (response) {

      $('#DivAmex').html(response);

     }
     });


  } 

  function G500Fleet(idReporte,empresa){

   var parametros = {
    "idReporte" : idReporte,
    "empresa" : empresa
    };

   $.ajax({
     data:  parametros,
     url:   '../../../public/corte-diario/vistas/lista-cierre-lote.php',
     type:  'get',
     beforeSend: function() {
     },
     complete: function(){

     },
     success:  function (response) {

      $('#DivG500Fleet').html(response);

     }
     });

  }

  function BANCOMER(idReporte,empresa){


    var parametros = {
    "idReporte" : idReporte,
    "empresa" : empresa
    };

   $.ajax({
     data:  parametros,
     url:   '../../../public/corte-diario/vistas/lista-cierre-lote.php',
     type:  'get',
     beforeSend: function() {
     },
     complete: function(){

     },
     success:  function (response) {

      $('#DivBANCOMER').html(response);

     }
     });

  }

  function Efecticard(idReporte,empresa){
    
    var parametros = {
    "idReporte" : idReporte,
    "empresa" : empresa
    };

   $.ajax({
     data:  parametros,
     url:   '../../../public/corte-diario/vistas/lista-cierre-lote.php',
     type:  'get',
     beforeSend: function() {
     },
     complete: function(){

     },
     success:  function (response) {

      $('#DivEfecticard').html(response);

     }
     });
  }

  function Sodexo(idReporte,empresa){
     

         var parametros = {
    "idReporte" : idReporte,
    "empresa" : empresa
    };

   $.ajax({
     data:  parametros,
     url:   '../../../public/corte-diario/vistas/lista-cierre-lote.php',
     type:  'get',
     beforeSend: function() {
     },
     complete: function(){

     },
     success:  function (response) {

      $('#DivSodexo').html(response);

     }
     });
  }

  function Inburgas(idReporte,empresa){


          var parametros = {
    "idReporte" : idReporte,
    "empresa" : empresa
    };

   $.ajax({
     data:  parametros,
     url:   '../../../public/corte-diario/vistas/lista-cierre-lote.php',
     type:  'get',
     beforeSend: function() {
     },
     complete: function(){

     },
     success:  function (response) {

      $('#DivInburgas').html(response);

     }
     });
  
  }

    function Ultragas(idReporte,empresa){


          var parametros = {
    "idReporte" : idReporte,
    "empresa" : empresa
    };

   $.ajax({
     data:  parametros,
     url:   '../../../public/corte-diario/vistas/lista-cierre-lote.php',
     type:  'get',
     beforeSend: function() {
     },
     complete: function(){

     },
     success:  function (response) {

      $('#DivUltragas').html(response);

     }
     });
  
  }

      function Energex(idReporte,empresa){


          var parametros = {
    "idReporte" : idReporte,
    "empresa" : empresa
    };

   $.ajax({
     data:  parametros,
     url:   '../../../public/corte-diario/vistas/lista-cierre-lote.php',
     type:  'get',
     beforeSend: function() {
     },
     complete: function(){

     },
     success:  function (response) {

      $('#DivEnergex').html(response);

     }
     });
  
  }

    function Inbursa(idReporte,empresa){


          var parametros = {
    "idReporte" : idReporte,
    "empresa" : empresa
    };

   $.ajax({
     data:  parametros,
     url:   '../../../public/corte-diario/vistas/lista-cierre-lote.php',
     type:  'get',
     beforeSend: function() {
     },
     complete: function(){

     },
     success:  function (response) {

      $('#DivINBURSA').html(response);

     }
     });
  
  }

  /------------------------------------------------------------------------------------/

function AgregarCierre(idReporte,empresa){

    var parametros = {
    "idReporte" : idReporte,
    "empresa" : empresa,
    "accion": "nuevo-cierre-lote"
    };

   $.ajax({
     data:  parametros,
     url:'../../../app/controlador/1-corporativo/controladorCorteDiario.php',
     //url:   '../../../public/corte-diario/modelo/nuevo-cierre-lote.php',
     type:  'post',
     beforeSend: function() {},
     complete: function(){},
     success:  function (response) {
      switch(response){
      case "TICKETCARD":
        Ticketcard(idReporte,empresa);
        break;
      case "AMERICAN EXPRESS":
        Amex(idReporte,empresa);
        break;
      case "G500 FLETT":
        G500Fleet(idReporte,empresa);
        break;
      case "BBVA BANCOMER SA":
        BANCOMER(idReporte,empresa);
        break;
      case "EFECTICARD":
        Efecticard(idReporte,empresa);
        break;
      case "SODEXO":
        Sodexo(idReporte,empresa);
        break;
      case "INBURGAS":
        Inburgas(idReporte,empresa);
        break;
      case "ULTRAGAS":
        Ultragas(idReporte,empresa);
        break;
      case "ENERGEX":
        Energex(idReporte,empresa);
        break;
      case "INBURSA":
        Inbursa(idReporte,empresa);
        break;
      }
     }
     });

}

function EditNoCierre(val,idReporte,idCierre,empresa){
  var nocierre = val.value;

  var parametros = {
    "type" : "nocierre",
    "idCierre" : idCierre,
    "nocierre" : nocierre,
    "accion" : "editar-cierre-lote"
    };

    $.ajax({
     data:  parametros,
     url:'../../../app/controlador/1-corporativo/controladorCorteDiario.php',
     //url:   '../../../public/corte-diario/modelo/editar-cierre-lote.php',
     type:  'post',
     beforeSend: function() {},
     complete: function(){},
     success:  function (response) {
      if (!response) {
        switch(response){
          case "TICKETCARD":
            Ticketcard(idReporte,empresa);
            break;
          case "AMERICAN EXPRESS":
            Amex(idReporte,empresa);
            break;
          case "G500 FLETT":
            G500Fleet(idReporte,empresa);
            break;
          case "BBVA BANCOMER SA":
            BANCOMER(idReporte,empresa);
            break;
          case "EFECTICARD":
            Efecticard(idReporte,empresa);
            break;
          case "SODEXO":
            Sodexo(idReporte,empresa);
            break;
          case "INBURGAS":
            Inburgas(idReporte,empresa);
            break;
          case "ULTRAGAS":
            Ultragas(idReporte,empresa);
            break;
          case "ENERGEX":
            Energex(idReporte,empresa);
            break;
          case "INBURSA":
            Inbursa(idReporte,empresa);
            break;
        }
      }
     }
     });

}
function EditImporte(val,idReporte,idCierre,empresa){
  var importe = val.value;

   var parametros = {
    "type" : "importe",
    "idCierre" : idCierre,
    "importe" : importe,
    "idReporte" : idReporte,
    "empresa" : empresa,
    "accion" : "editar-cierre-lote"
    };

    $.ajax({
     data:  parametros,
     url:'../../../app/controlador/1-corporativo/controladorCorteDiario.php',
     //url:   '../../../public/corte-diario/modelo/editar-cierre-lote.php',
     type:  'post',
     beforeSend: function() {},
     complete: function(){},
     success:  function (response) {
      if (!response) {
        switch(response){
          case "TICKETCARD":
            Ticketcard(idReporte,empresa);
            break;
          case "AMERICAN EXPRESS":
            Amex(idReporte,empresa);
            break;
          case "G500 FLETT":
            G500Fleet(idReporte,empresa);
            break;
          case "BBVA BANCOMER SA":
            BANCOMER(idReporte,empresa);
            break;
          case "EFECTICARD":
            Efecticard(idReporte,empresa);
            break;
          case "SODEXO":
            Sodexo(idReporte,empresa);
            break;
          case "INBURGAS":
            Inburgas(idReporte,empresa);
            break;
          case "ULTRAGAS":
            Ultragas(idReporte,empresa);
            break;
          case "ENERGEX":
            Energex(idReporte,empresa);
            break;
          case "INBURSA":
            Inbursa(idReporte,empresa);
            break;
        }
      }else{
        TotalCierre(idReporte,empresa);
      }
     }
     });

}
function EditNoTicket(val,idReporte,idCierre,empresa){
  var noticket = val.value;

  var parametros = {
    "type" : "noticket",
    "idCierre" : idCierre,
    "noticket" : noticket,
    "accion" : "editar-cierre-lote"
    };

    $.ajax({
     data:  parametros,
     url:'../../../app/controlador/1-corporativo/controladorCorteDiario.php',
     //url:   '../../../public/corte-diario/modelo/editar-cierre-lote.php',
     type:  'post',
     beforeSend: function(){},
     complete: function(){},
     success:  function (response) {
      if (!response) {
        switch(response){
          case "TICKETCARD":
            Ticketcard(idReporte,empresa);
            break;
          case "AMERICAN EXPRESS":
            Amex(idReporte,empresa);
            break;
          case "G500 FLETT":
            G500Fleet(idReporte,empresa);
            break;
          case "BBVA BANCOMER SA":
            BANCOMER(idReporte,empresa);
            break;
          case "EFECTICARD":
            Efecticard(idReporte,empresa);
            break;
          case "SODEXO":
            Sodexo(idReporte,empresa);
            break;
          case "INBURGAS":
            Inburgas(idReporte,empresa);
            break;
          case "ULTRAGAS":
            Ultragas(idReporte,empresa);
            break;
          case "ENERGEX":
            Energex(idReporte,empresa);
            break;
          case "INBURSA":
            Inbursa(idReporte,empresa);
            break;
        }
      }else{
        TotalCierre(idReporte,empresa);
      }

     }
     });

}

function Pendiente(idReporte,idCierre,empresa,status){
let desc;
  if(status==0){
  desc = "Activo";
}else{
  desc = "Pendiente";
}
alertify.confirm('',
function(){

  var parametros = {
    "estado" : status,
    "idCierre" : idCierre,
    "accion" : "editar-pendiente-cierre-lote"
    };

    $.ajax({
     data:  parametros,
     url:'../../../app/controlador/1-corporativo/controladorCorteDiario.php',
     //url:   '../../../public/corte-diario/modelo/editar-pendiente-cierre-lote.php',
     type:  'post',
     beforeSend: function() {},
     complete: function(){},
     success:  function (response) {
      if(response){
       switch(empresa){
          case "TICKETCARD":
            Ticketcard(idReporte,empresa);
            break;
          case "AMERICAN EXPRESS":
            Amex(idReporte,empresa);
            break;
          case "G500 FLETT":
            G500Fleet(idReporte,empresa);
            break;
          case "BBVA BANCOMER SA":
            BANCOMER(idReporte,empresa);
            break;
          case "EFECTICARD":
            Efecticard(idReporte,empresa);
            break;
          case "SODEXO":
            Sodexo(idReporte,empresa);
            break;
          case "INBURGAS":
            Inburgas(idReporte,empresa);
            break;
          case "ULTRAGAS":
            Ultragas(idReporte,empresa);
            break;
          case "ENERGEX":
            Energex(idReporte,empresa);
            break;
          case "INBURSA":
            Inbursa(idReporte,empresa);
            break;
        }
      }
     }
     });

},
function(){
}).setHeader(''+desc).set({transition:'zoom',message: '¿Desea poner el estado '+desc+' del cierre de lote seleccionado?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();


}

  
  </script>
  </head>
  <body>
 
  <div class="LoaderPage"></div>
  <?php 

  $sql_dia = "SELECT fecha FROM op_corte_dia WHERE id = '".$GET_idReporte."' ";
  $result_dia = mysqli_query($con, $sql_dia);
  while($row_dia = mysqli_fetch_array($result_dia, MYSQLI_ASSOC)){
  $dia = $row_dia['fecha'];
  }

  ?>



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

     <h5>Cierres de Lote, <?=FormatoFecha($dia);?> </h5>
    
    </div>
    </div>

    </div>
    </div>

  <hr>

  <div class="row">
 
  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mt-2">

  <div class="border mb-3">
      <div class="bg-light p-3">
        <strong>TICKETCARD</strong>
        <?php if($tpv == 0){ ?>
        <div class="float-end"><img src="<?=RUTA_IMG_ICONOS;?>agregar.png" class="pointer" onclick="AgregarCierre(<?=$GET_idReporte;?>,'TICKETCARD')"></div> 
        <?php } ?>
      </div>

    <div class="p-2">
    <div class="table-responsive">
    <div id="DivTicketcard"></div>

    </div>
    </div>
    
  </div>


    <div class="border mb-3">
      <div class="bg-light p-3">
        <strong>G500 FLETT</strong>
        <?php if($tpv == 0){ ?>
        <div class="float-end"><img src="<?=RUTA_IMG_ICONOS;?>agregar.png" class="pointer" onclick="AgregarCierre(<?=$GET_idReporte;?>,'G500 FLETT')"></div> 
      <?php } ?>
      </div>

    <div class="p-2">
    <div class="table-responsive">
    <div id="DivG500Fleet" ></div>
    </div>
    </div>  

    </div>


 <div class="border mb-3">
      <div class="bg-light p-3">
        <strong>EFECTICARD</strong>
        <?php if($tpv == 0){ ?>
        <div class="float-end"><img src="<?=RUTA_IMG_ICONOS;?>agregar.png" class="pointer" onclick="AgregarCierre(<?=$GET_idReporte;?>,'EFECTICARD')"></div> 
        <?php } ?>
      </div>

    <div class="p-2">
    <div class="table-responsive">      
    <div id="DivEfecticard" ></div>
    </div>
    </div>

    </div>



    <div class="border mb-3">
    <div class="bg-light p-3">
        <strong>SODEXO</strong>
        <?php if($tpv == 0){ ?>
        <div class="float-end"><img src="<?=RUTA_IMG_ICONOS;?>agregar.png" class="pointer" onclick="AgregarCierre(<?=$GET_idReporte;?>,'SODEXO')"></div> 
        <?php } ?>
      </div>

    <div class="p-2">
    <div class="table-responsive">       
    <div id="DivSodexo" ></div>
    </div>
    </div>
    </div>

      <div class="border mb-3">
      <div class="bg-light p-3">
        <strong>INBURGAS</strong>
        <?php if($tpv == 0){ ?>
        <div class="float-end"><img src="<?=RUTA_IMG_ICONOS;?>agregar.png" class="pointer" onclick="AgregarCierre(<?=$GET_idReporte;?>,'INBURGAS')"></div> 
      <?php } ?>
    </div>

    <div class="p-2">
    <div class="table-responsive">
    <div id="DivInburgas"></div>
    </div>
    </div>

    </div>
    <?php
    if ($Session_IDEstacion == 3){
    ?>


    <div class="border mb-3">
      <div class="bg-light p-3">
        <strong>ULTRAGAS</strong>
        <?php if($tpv == 0){ ?>
        <div class="float-end"><img src="<?=RUTA_IMG_ICONOS;?>agregar.png" class="pointer" onclick="AgregarCierre(<?=$GET_idReporte;?>,'ULTRAGAS')"></div> 
      <?php } ?>
      </div>

    <div class="p-2">
    <div class="table-responsive">   
    <div id="DivUltragas"></div>
    </div>
    </div>

    </div>
    <?php } ?>
    <?php
    if ($Session_IDEstacion == 3){
    ?>
        <div class="border mb-3">
      <div class="bg-light p-3">
        <strong>ENERGEX</strong>
        <?php if($tpv == 0){ ?>
        <div class="float-end"><img src="<?=RUTA_IMG_ICONOS;?>agregar.png" class="pointer" onclick="AgregarCierre(<?=$GET_idReporte;?>,'ENERGEX')"></div> 
      <?php } ?>
      </div>
        <div class="p-2">
    <div class="table-responsive">   
    <div id="DivEnergex"></div>
    </div>

  </div>
</div>

    <?php } ?>
  </div>


  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mt-2">
    
    <div class="border">
      <div class="bg-light p-3">
        <strong>AMERICAN EXPRESS</strong>
        <?php if($tpv == 0){ ?>
        <div class="float-end"><img src="<?=RUTA_IMG_ICONOS;?>agregar.png" class="pointer" onclick="AgregarCierre(<?=$GET_idReporte;?>,'AMERICAN EXPRESS')"></div> 
      <?php } ?>
      </div>

    <div class="p-2">
    <div class="table-responsive">   
    <div id="DivAmex"></div>
    </div>
    </div>


    </div>

    <div class="border mb-3">
    <div class="bg-light p-3">
    <strong>BBVA BANCOMER SA</strong>
    <?php if($tpv == 0){ ?>
    <div class="float-end"><img src="<?=RUTA_IMG_ICONOS;?>agregar.png" class="pointer" onclick="AgregarCierre(<?=$GET_idReporte;?>,'BBVA BANCOMER SA')"></div> 
      <?php } ?>
    </div>

    <div class="p-2">
    <div class="table-responsive">   
    <div id="DivBANCOMER"></div>
    </div>
    </div>

    </div>

    <div class="border mb-3">
    <div class="bg-light p-3">
    <strong>INBURSA</strong>
    <?php if($tpv == 0){ ?>
    <div class="float-end"><img src="<?=RUTA_IMG_ICONOS;?>agregar.png" class="pointer" onclick="AgregarCierre(<?=$GET_idReporte;?>,'INBURSA')"></div> 
      <?php } ?>
    </div>

    <div class="p-2">
    <div class="table-responsive">   
    <div id="DivINBURSA" ></div>
    </div>
    </div>

    </div>

  </div>
  
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

