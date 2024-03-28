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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

  <style media="screen">
  .grayscale {
    filter: opacity(50%); 
  }
  </style> 

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  SelEstacionLts(<?=$Session_IDEstacion?>,<?=$GET_idYear?>,<?=$GET_idMes?>)
  }); 

 
  function Regresar(){
  window.history.back();
  }
 
  
  function SelEstacionLts(idEstacion,year,mes){
    $('#ListaCuentaLts').html('<div class="text-center"> <img width="50" src="../../imgs/iconos/load-img.gif"></div>'); 
    $('#ListaCuentaLts').load('../../public/admin/vistas/lista-cuenta-litros.php?idEstacion=' + idEstacion + '&year=' + year + '&mes=' + mes);
  }
   

  //---------- FORMULARIO EDITAR CUENTA LITROS ----------
  function EditarCL(idCuentaLitros){
  window.location.href = "../../cuenta-litros-formato/" + idCuentaLitros; 
  }


     //---------- MODAL NUEVO CUENTA LITROS ----------
  function DetalleCL(idCuentaLitros){
  window.location.href = "../../cuenta-litros-detalle/" + idCuentaLitros;  
  }



  //---------- FORMULARIO AGREGAR CUENTA LITROS ----------
  function NuevoCuentaLitros(idEstacion,year,mes){

    var parametros = {
    "idEstacion" : idEstacion,
    "year" : year,
    "mes" : mes
    };

    $.ajax({   
     data:  parametros,
     url:   '../../public/admin/modelo/agregar-formato-cuenta-litros.php',
     type:  'POST',
     beforeSend: function() { 
     
     },  
     complete: function(){
    
     },
     success:  function (response) {
 
    if(response != 0){
    window.location.href = "../../cuenta-litros-formato/" + response; 
    }
 
     } 
     });
 
 
  }


    //---------- ELIMINAR CUENTA LITROS REGISTRO (SERVER) ----------
  function EliminarCL(idCuentaLitros,idEstacion,year,mes){

   var parametros = {
  "idCuentaLitros" : idCuentaLitros
   };


  alertify.confirm('',
  function(){

    $.ajax({
    data:  parametros,    
    url:   '../../public/admin/modelo/eliminar-cuenta-litros-registro.php',
    type:  'post',
    beforeSend: function() {
    }, 
    complete: function(){
 
    },
    success:  function (response) {

    if (response == 1) {
    alertify.success('Registro eliminado exitosamente.')
    SelEstacionLts(idEstacion,year,mes)

    }else{
     alertify.error('Error al eliminar el registro');  
    }

    }
    });

  },
  function(){

  }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar el registro seleccionado?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();



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
    <div class="col-11">

     <h5>Cuenta Litros, <?=nombremes($GET_idMes);?> <?=$GET_idYear;?></h5>
     
    </div>


    <div class="col-1 mb-0">
    <img src="<?=RUTA_IMG_ICONOS;?>agregar.png" class="float-end pointer" onclick="NuevoCuentaLitros(<?=$Session_IDEstacion?>,<?=$GET_idYear?>,<?=$GET_idMes?>)">
    </div> 

    </div>

    </div>
    </div>

  <hr> 

    <div id="ListaCuentaLts" class="cardAG"></div>

  </div>
  </div>
  </div>

  </div>
  </div>

  </div>


  

<div class="modal fade bd-example-modal-xl" id="ModalCL">
<div class="modal-dialog">
<div class="modal-content" style="margin-top: 83px;">
<div id="ContenidoModalCL"></div>
</div>
</div>
</div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>
           