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


  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" ></script>
  <link rel="stylesheet" href="<?php echo RUTA_CSS ?>selectize.css">
  
  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  
  ListaPinturas();

  });
 
  function Regresar(){
   window.history.back();
  }

  function ListaPinturas(){
  $('#ListaPinturas').load('public/corte-diario/vistas/lista-pedido-pinturas.php');
  }

  function NuevoPedido(){

    $.ajax({
    url:   'public/corte-diario/modelo/agregar-reporte-pedido-pinturas.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){ 

    },
    success:  function (response) {

  if(response == 0){
  alertify.error('Error al agregar el reporte');
  }else{

  window.location.href = "pinturas-pedido/" + response; 
  }
 
    }
    });
  }



//------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------
function PedidoPDF(id){
window.location.href = "pedido-pinturas/" + id;
}

function VerPedido(id){
  $('#Modal').modal('show');  
  $('#ContenidoModal').load('public/corte-diario/vistas/modal-detalle-pedido-pinturas.php?idReporte=' + id ); 
}
   
function EditarPedido(idReporte){
window.location.href = "pinturas-pedido/" + idReporte;   
}
 
  function EliminarPedido(idReporte){

    var parametros = {
    "idReporte" : idReporte
    };

 alertify.confirm('',
 function(){

      $.ajax({
    data:  parametros,
    url:   'public/corte-diario/modelo/eliminar-pedido-pinturas.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

 
    if (response == 1) {
    ListaPinturas()
    alertify.success('Pedido eliminado exitosamente');

    }else{
    alertify.error('Error al eliminar el pedido');
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();
  

  }

  //--------------------------------------------------------------------------------

function Almacen(){
window.location.href = "pinturas-inventario"; 
}

function Reporte(){
window.location.href = "pinturas-reporte";   
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

    <div class="col-8">
    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    
    <div class="row">
    <div class="col-12">

    <h5>Pedido pinturas </h5>

    </div>
    </div>

    </div>


    <div class="col-4">
    <img src="<?=RUTA_IMG_ICONOS;?>agregar.png" class="ms-2 float-end pointer" onclick="NuevoPedido()">
    <img src="<?=RUTA_IMG_ICONOS;?>control-despacho.png" width="24px" class="ms-2 float-end pointer" onclick="Reporte()">
    <img src="<?=RUTA_IMG_ICONOS;?>almacen-tb.png" class="ms-2 float-end pointer" onclick="Almacen()">
    </div>

    </div>


  <hr>

    <div id="ListaPinturas"></div>

  </div>
  </div>
  </div>

  </div>
  </div>

  </div>



<div class="modal" id="Modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="margin-top: 83px;">
      <div id="ContenidoModal"></div>    
    </div>
  </div>
</div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>