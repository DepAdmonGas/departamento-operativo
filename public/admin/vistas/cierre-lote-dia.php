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
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
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
  Inbursa(<?=$GET_idReporte;?>,'INBURSA');
  Inburgas(<?=$GET_idReporte;?>,'INBURGAS');

  Ultragas(<?=$GET_idReporte;?>,'ULTRAGAS');
  Energex(<?=$GET_idReporte;?>,'ENERGEX');
  
  
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
     url:   '../../../../public/admin/vistas/lista-cierre-lote.php',
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
     url:   '../../../../public/admin/vistas/lista-cierre-lote.php',
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
     url:   '../../../../public/admin/vistas/lista-cierre-lote.php',
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
     url:   '../../../../public/admin/vistas/lista-cierre-lote.php',
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
     url:   '../../../../public/admin/vistas/lista-cierre-lote.php',
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
     url:   '../../../../public/admin/vistas/lista-cierre-lote.php',
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

    function Inbursa(idReporte,empresa){


          var parametros = {
    "idReporte" : idReporte,
    "empresa" : empresa
    };

   $.ajax({
     data:  parametros,
     url:   '../../../../public/admin/vistas/lista-cierre-lote.php',
     type:  'get',
     beforeSend: function() {
     },
     complete: function(){

     },
     success:  function (response) {

      $('#DivInbursa').html(response);

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
     url:   '../../../../public/admin/vistas/lista-cierre-lote.php',
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
     url:   '../../../../public/admin/vistas/lista-cierre-lote.php',
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
     url:   '../../../../public/admin/vistas/lista-cierre-lote.php',
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


function Pendiente(idReporte,idCierre,empresa){

alertify.confirm('',
function(){

  var parametros = {
    "estado" : 1,
    "idCierre" : idCierre
    };

    $.ajax({
     data:  parametros,
     url:   '../../../../public/corte-diario/modelo/editar-pendiente-cierre-lote.php',
     type:  'post',
     beforeSend: function() {
     },
     complete: function(){
    
     },
     success:  function (response) {

     if (empresa == "TICKETCARD") {
        Ticketcard(idReporte,empresa);
      }else if (empresa == "AMERICAN EXPRESS") {
        Amex(idReporte,empresa);
      }else if (empresa == "G500 FLETT") {
        G500Fleet(idReporte,empresa);
      }else if (empresa == "BBVA BANCOMER SA") {
        BANCOMER(idReporte,empresa);
      }else if (empresa == "EFECTICARD") {
        Efecticard(idReporte,empresa);
      }else if (empresa == "SODEXO") {
        Sodexo(idReporte,empresa);
      }else if (empresa == "INBURSA") {
        Inbursa(idReporte,empresa);
      }else if (empresa == "INBURGAS") {
        Inburgas(idReporte,empresa);
      }else if (empresa == "ULTRAGAS") {
        Ultragas(idReporte,empresa);
      }else if (empresa == "ENERGEX") {
        Energex(idReporte,empresa);
      }

     }
     });

},
function(){
}).setHeader('Pendiente').set({transition:'zoom',message: '¿Desea poner en pendiente el cierre de lote seleccionado?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();


}
function Activar(idReporte,idCierre,empresa){

alertify.confirm('',
function(){

  var parametros = {
    "estado" : 0,
    "idCierre" : idCierre
    };

    $.ajax({
     data:  parametros,
     url:   '../../../../public/corte-diario/modelo/editar-pendiente-cierre-lote.php',
     type:  'post',
     beforeSend: function() {
     },
     complete: function(){
    
     },
     success:  function (response) {

     if (empresa == "TICKETCARD") {
        Ticketcard(idReporte,empresa);
      }else if (empresa == "AMERICAN EXPRESS") {
        Amex(idReporte,empresa);
      }else if (empresa == "G500 FLETT") {
        G500Fleet(idReporte,empresa);
      }else if (empresa == "BBVA BANCOMER SA") {
        BANCOMER(idReporte,empresa);
      }else if (empresa == "EFECTICARD") {
        Efecticard(idReporte,empresa);
      }else if (empresa == "SODEXO") {
        Sodexo(idReporte,empresa);
      }else if (empresa == "INBURSA") {
        Inbursa(idReporte,empresa);
      }else if (empresa == "INBURGAS") {
        Inburgas(idReporte,empresa);
      }else if (empresa == "ULTRAGAS") {
        Ultragas(idReporte,empresa);
      }else if (empresa == "ENERGEX") {
        Energex(idReporte,empresa);
      }

     }
     });

},
function(){
}).setHeader('Cancelar pendiente').set({transition:'zoom',message: '¿Desea cancelar el pendiente del cierre de lote seleccionado?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();
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

     <h5>Cierres de Lote, <?=FormatoFecha($dia);?></h5>
    
    </div>
    </div>

    </div>
    </div>

  <hr>

 
<div class="row">
  
  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
    
  <div class="border mb-3">
      <div class="bg-light p-3">
        <strong>1 TICKETCARD</strong>
      </div>
    
     <div class="p-2">
    <div class="table-responsive">
    <div id="DivTicketcard"></div>

    </div>
    </div>
    
  </div>


  <div class="border mb-3">
      <div class="bg-light p-3">
        <strong>1.1 G500 FLETT</strong>
      </div>

    <div class="p-2">
    <div class="table-responsive">
    <div id="DivG500Fleet" ></div>
    </div>
    </div>  

  </div>



  <div class="border mb-3">
      <div class="bg-light p-3">
        <strong>2 EFECTICARD</strong>
      </div>
    
    <div class="p-2">
    <div class="table-responsive">      
    <div id="DivEfecticard" ></div>
    </div>
    </div>

    </div>



  <div class="border mb-3">
      <div class="bg-light p-3">
        <strong>3 SODEXO</strong>
      </div>

    <div class="p-2">
    <div class="table-responsive">       
    <div id="DivSodexo" ></div>
    </div>
    </div>
    </div>

  <div class="border mb-3">
      <div class="bg-light p-3">
        <strong>4 INBURGAS</strong>
      </div>
    <div class="p-2">
    <div class="table-responsive">
    <div id="DivInburgas"></div>
    </div>
    </div>


    <?php
    if ($Session_IDEstacion == 3){
    ?>
 
  <div class="border mb-3">
      <div class="bg-light p-3">
        <strong>8 ULTRAGAS</strong>
      </div>
    <div class="p-2">
    <div class="table-responsive">   
    <div id="DivUltragas"></div>
    </div>
    </div>

  </div>

  <div class="border mb-3">
      <div class="bg-light p-3">
        <strong>9 ENERGEX</strong>
      </div>
    
        <div class="p-2">
    <div class="table-responsive">   
    <div id="DivEnergex"></div>
    </div>

  </div>
</div>

    <?php
    }
    ?>
  </div>

</div>



  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
    
    <div class="border mb-3">
      <div class="bg-light p-3">
        <strong>5 AMERICAN EXPRESS</strong>
      </div>


    <div class="p-2">
    <div class="table-responsive">   
    <div id="DivAmex"></div>
    </div>
    </div>

   </div>


    <div class="border mb-3">
      <div class="bg-light p-3">
        <strong>6 BBVA BANCOMER SA</strong>
      </div>

    <div class="p-2">
    <div class="table-responsive">   
    <div id="DivBANCOMER"></div>
    </div>
    </div>

    </div>



    <div class="border mb-3">
      <div class="bg-light p-3">
        <strong>7 INBURSA</strong>
      </div>

    <div class="p-2">
    <div class="table-responsive">   
    <div id="DivInbursa"></div>
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

