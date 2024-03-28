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
  <link href="<?=RUTA_CSS2;?>navbar-utilities.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

  <script src="<?=RUTA_JS?>size-window.js"></script>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">


  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  sizeWindow();
  
  });
 
  function Regresar(){
  window.history.back();
  }

  function IngresosFactura(idestacion,year){
  sizeWindow();  
  $('#DivContenido').load('../../public/admin/vistas/concentrado-ingresos-facturacion.php?idEstacion=' + idestacion + '&year=' + year );   
  }  
 
  function SelIngresoF(idestacion,year){

    var parametros = {
    "idestacion" : idestacion,
    "year" : year
    };

    $.ajax({
     data:  parametros,
     url:   '../../public/admin/modelo/agregar-ingresos-facturacion.php',
     type:  'post',
     beforeSend: function() {
     },
     complete: function(){
    
     },
     success:  function (response) {

    window.location.href = "../ingresos-facturacion-resumen/" + response;

     }
     });

  } 

  function Entregables(IdReporte){

$('#Modal').modal('show');  
$('#DivContenidoModal').load('../../public/corte-diario/vistas/modal-ingresos-facturacion-entregables.php?idReporte=' + IdReporte);

}

function GuardarArchivo(idReporte){

    var data = new FormData();
    var url = '../../public/corte-diario/modelo/agregar-ingreso-facturacion-archivo.php';

    Archivo = document.getElementById("Archivo");
    Archivo_file = Archivo.files[0];
    Archivo_filePath = Archivo.value;

    if(Archivo_filePath != ""){
    $('#Archivo').css('border','');

    data.append('idReporte', idReporte);
    data.append('Archivo_file', Archivo_file);
    $(".LoaderPage").show();

    $.ajax({
    url: url,
    type: 'POST',
    contentType: false,
    data: data,
    processData: false,
    cache: false
    }).done(function(data){

     if(data == 1){
     $(".LoaderPage").hide();
     $('#DivContenidoModal').load('../../public/corte-diario/vistas/modal-ingresos-facturacion-entregables.php?idReporte=' + idReporte);
     sizeWindow()

     }else{
     $(".LoaderPage").hide();
     alertify.error('Error al guardar el archivo'); 
     }
     
    });  

    }else{
    $('#Archivo').css('border','2px solid #A52525'); 
    }
}

function EliminarDoc(id, idReporte){

  var parametros = {
    "id" : id
    };

  alertify.confirm('',
 function(){

    $.ajax({
    data:  parametros,
    url:   '../../public/corte-diario/modelo/eliminar-ingresos-facturacion-entregables.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
     $('#DivContenidoModal').load('../../public/corte-diario/vistas/modal-ingresos-facturacion-entregables.php?idReporte=' + idReporte);
     sizeWindow();
    }else{
     alertify.error('Error al eliminar el archivo');  
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

}


  </script>
  </head>

<body class="bodyAG"> 

<div class="LoaderPage"></div>

  <!---------- CONTENIDO Y BARRA DE NAVEGACION ---------->
  <div class="wrapper">

  <!---------- BARRA DE NAVEGACION ---------->
  <nav id="sidebar">

  <div class="sidebar-header text-center">
  <img class="" src="<?=RUTA_IMG_LOGOS."Logo.png";?>" style="width: 100%;">
  </div>

  <ul class="list-unstyled components">
    
  <li>
    <a class="pointer" href="<?=SERVIDOR_ADMIN?>">
    <i class="fa-solid fa-house" aria-hidden="true" style="padding-right: 10px;"></i>Menu
    </a>
  </li>


  <li>
    <a class="pointer" onclick="Regresar()">
    <i class="fas fa-arrow-left" aria-hidden="true" style="padding-right: 10px;"></i>Regresar
    </a>
  </li>

    <?php

$sql_listaestacion = "SELECT id, nombre, numlista FROM tb_estaciones WHERE numlista <= 8 ORDER BY numlista ASC";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);

   while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
    $id = $row_listaestacion['id'];
    $estacion = $row_listaestacion['nombre'];

    if ($session_nompuesto == "Contabilidad") {
      
      if ($id == 1 || $id == 2 || $id == 3 || $id == 4 || $id == 5 ) {
       
  echo '  
  <li>
    <a class="pointer" onclick="IngresosFactura('.$id.','.$GET_year.')">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$estacion.'
    </a>
  </li>';

      }

    }else if ($session_nompuesto == "Comercializadora") {
      
      if ($id == 6 || $id == 7 ) {
  echo '  
  <li>
    <a class="pointer" onclick="IngresosFactura('.$id.','.$GET_year.')">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$estacion.'
    </a>
  </li>';
      }

    }else {

      if ($Session_IDUsuarioBD == 293) {
      if ($id == 2) {
  echo '  
  <li>
    <a class="pointer" onclick="IngresosFactura('.$id.','.$GET_year.')">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$estacion.'
    </a>
  </li>';
      }
      }else if ($Session_IDUsuarioBD == 294) {
      if ($id == 1) {
  echo '  
  <li>
    <a class="pointer" onclick="IngresosFactura('.$id.','.$GET_year.')">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$estacion.'
    </a>
  </li>';
      }
      }else if ($Session_IDUsuarioBD == 295) {
      if ($id == 3) {
  echo '  
  <li>
    <a class="pointer" onclick="IngresosFactura('.$id.','.$GET_year.')">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$estacion.'
    </a>
  </li>';
      }
      }else if ($Session_IDUsuarioBD == 296) {
      if ($id == 4) {
  echo '  
  <li>
    <a class="pointer" onclick="IngresosFactura('.$id.','.$GET_year.')">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$estacion.'
    </a>
  </li>';
      }
      }else if ($Session_IDUsuarioBD == 297) {
      if ($id == 5) {
  echo '  
  <li>
    <a class="pointer" onclick="IngresosFactura('.$id.','.$GET_year.')">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$estacion.'
    </a>
  </li>';
      }
      }else{
  echo '  
  <li>
    <a class="pointer" onclick="IngresosFactura('.$id.','.$GET_year.')">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$estacion.'
    </a>
  </li>';
      }
    }
  
   }

?> 
  <li>
    <a class="pointer" onclick="SelIngresoF(11,<?=$GET_year;?>)">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    <strong>Sabino Aguirre</strong>
    </a>
  </li>

  <li>
    <a class="pointer" onclick="SelIngresoF(12,<?=$GET_year;?>)">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    <strong>Acueducto de Guadalupe</strong>
    </a>
  </li>

  <li>
    <a class="pointer" onclick="SelIngresoF(13,<?=$GET_year;?>)">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    <strong>Tultepec</strong>
    </a>
  </li>

  </ul>

  </nav>


  <!---------- DIV - CONTENIDO ----------> 
  <div id="content">
  <!---------- NAV BAR - PRINCIPAL (TOP) ---------->  
 <nav class="navbar navbar-expand navbar-light navbar-bg" >
  
  <i class="fa-solid fa-bars menu-btn rounded pointer" 
  id="sidebarCollapse"></i>

  <div class="pointer">
  <a class="text-dark" onclick="history.back()">Ingresos VS Facturación <?=$GET_year;?></a>
  </div>
 
   
  <div class="navbar-collapse collapse">

  <div class="dropdown-divider"></div>

  <ul class="navbar-nav navbar-align">

  <li class="nav-item dropdown">
  <a class=" dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
  <i class="align-middle" data-feather="settings"></i>
  </a>

 
  <a class="nav-link dropdown-toggle d-none d-sm-inline-block pointer" data-bs-toggle="dropdown">
  
  <img src="<?=RUTA_IMG_ICONOS."usuarioBar.png";?>" class="avatar img-fluid rounded-circle"/>

  <span class="text-dark" style="padding-left: 10px;">
  <?=$session_nompuesto;?>  
  </span>
  </a>
  
  <div class="dropdown-menu dropdown-menu-end">
  
  <div class="user-box">

  <div class="u-text">
  <p class="text-muted">Nombre de usuario:</p>
  <h4><?=$session_nomusuario;?></h4>
  </div>

  </div>


  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="../../../perfil">
  <i class="fa-solid fa-user" style="padding-right: 5px;"></i>Perfil
  </a>
 
  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="<?=RUTA_SALIR2?>salir">
  <i class="fa-solid fa-power-off" style="padding-right: 5px;"></i> Cerrar Sesión
  </a>

  </div>
  </li>
  
  </ul>
  </div>

  </nav>

  <!---------- CONTENIDO PAGINA WEB----------> 
  <div class="contendAG">
  <div class="row">  
  
  <div class="col-12 mb-3">
  <div id="DivContenido" class="cardAG">
    
  <div class="alert alert-secondary text-center" role="alert">
  Seleccione la estación para ver los Ingresos VS Facturación del año <?=$GET_year;?>
  </div>

  </div>
  </div> 

  </div>
  </div> 
  </div>

  </div>



  <div class="modal" id="Modal">
    <div class="modal-dialog" style="margin-top: 83px;">
      <div class="modal-content">
      <div id="DivContenidoModal"></div>
      </div>
    </div>
  </div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>navbar-functions.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>
