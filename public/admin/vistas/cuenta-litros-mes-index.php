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
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
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
  sizeWindow();

  if(sessionStorage){
    if (sessionStorage.getItem('idEstacion') !== undefined && sessionStorage.getItem('idEstacion')) {

      idEstacion = sessionStorage.getItem('idEstacion');
      year = sessionStorage.getItem('year');
      mes = sessionStorage.getItem('mes');

    $('#ListaCuentaLts').load('../../../public/admin/vistas/lista-cuenta-litros.php?idEstacion=' + idEstacion + '&year=' + year + '&mes=' + mes);
          
    }     
    }   
  

  }); 

 

  function Regresar(){
  window.history.back();
  }


  function SelEstacionLts(idEstacion,year,mes){
    
    sizeWindow();
    sessionStorage.setItem('idEstacion', idEstacion);
    sessionStorage.setItem('year', year);
    sessionStorage.setItem('mes', mes);
    sessionStorage.setItem('scrollTop', 0);
    
    $('#ListaCuentaLts').html('<div class="text-center"> <img width="50" src="../../../imgs/iconos/load-img.gif"></div>'); 
    $('#ListaCuentaLts').load('../../../public/admin/vistas/lista-cuenta-litros.php?idEstacion=' + idEstacion + '&year=' + year + '&mes=' + mes);

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
     url:   '../../../public/admin/modelo/agregar-formato-cuenta-litros.php',
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
    url:   '../../../public/admin/modelo/eliminar-cuenta-litros-registro.php',
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


  function HabilitarCL(idCuentaLitros){

      var parametros = {
  "idCuentaLitros" : idCuentaLitros
   };


  alertify.confirm('',
  function(){

    $.ajax({
    data:  parametros,    
    url:   '../../../public/admin/modelo/habilitar-cuenta-litros.php',
    type:  'post',
    beforeSend: function() {
    }, 
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    alertify.success('Cuenta litros habilitado exitosamente');  
    SelEstacionLts(idEstacion,year,mes)


    }else{
     alertify.error('Error al habilitar cuenta litros');  
    }

    }
    });

  },
  function(){

  }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea habilitar el cuenta litros seleccionado?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();



  }



  </script>
  </head> 
 
<body> 

<div class="LoaderPage"></div>


  <!---------- CONTENIDO Y BARRA DE NAVEGACION ---------->
 <div class="wrapper"> 
  <!---------- BARRA DE NAVEGACION ---------->
  <nav id="sidebar">
          
  <div class="sidebar-header text-center">
  <img class="" src="<?=RUTA_IMG_LOGOS."Logo.png";?>" style="width: 100%;">
  </div>

    <ul class="list-unstyled components">

    <?php
      
      if($Session_IDUsuarioBD == 509){
        $referencia = "href= ../../importacion ";
        $nombreBar2 = "Menu";

      }else{
        $referencia = "href=".SERVIDOR_ADMIN." ";
        $nombreBar2 = "Menu";
      }
      ?>
 
    <li>
    <a class="pointer" <?=$referencia?>>
    <i class="fa-solid fa-house" aria-hidden="true" style="padding-right: 10px;"></i><?=$nombreBar2?>
    </a>
    </li>
    

    <li>
    <a class="pointer" onclick="Regresar()">
    <i class="fas fa-arrow-left" aria-hidden="true" style="padding-right: 10px;"></i>Regresar
    </a>
    </li>
 
 
    <?php

    $sql_listaestacion = "SELECT id, nombre FROM tb_estaciones WHERE numlista <= 8 ORDER BY numlista ASC";
    $result_listaestacion = mysqli_query($con, $sql_listaestacion);

    while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
    $id = $row_listaestacion['id'];
    $estacion = $row_listaestacion['nombre'];

      echo '
      <li>
      <a class="pointer" onclick="SelEstacionLts('.$id.', '.$GET_idYear.','.$GET_idMes.')">
      <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
      '.$estacion.'
      </a>
      </li>';

    } 
 
  ?>  

  </ul>
</nav>
  

  <!---------- DIV - CONTENIDO ----------> 
  <div id="content">
  <!---------- NAV BAR - PRINCIPAL (TOP) ---------->  
 <nav class="navbar navbar-expand navbar-light navbar-bg" >
  
  <i class="fa-solid fa-bars menu-btn rounded pointer" 
  id="sidebarCollapse"></i>

  <div class="pointer">
  <a class="text-dark" onclick="history.back()">Cuenta Litros, <?=nombremes($GET_idMes);?> <?=$GET_idYear;?></a>
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
  <a class="dropdown-item" href="<?=PERFIL_ADMIN?>">
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
  <div id="ListaCuentaLts" class="cardAG"></div>
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
  <script src="<?=RUTA_JS2 ?>navbar-functions.js"></script>
  
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>
           