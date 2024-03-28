<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

function ToSolicitud($idEstacion,$con){


$sql_lista = "SELECT id FROM op_pivoteo WHERE id_estacion = '".$idEstacion."' AND estatus = 1 ";
$result_lista = mysqli_query($con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);
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
    if (sessionStorage.getItem('idestacion') !== undefined && sessionStorage.getItem('idestacion')) {

      idestacion = sessionStorage.getItem('idestacion');
    

      if(idestacion < 11){
      $('#ListaPivoteo').load('../public/admin/vistas/lista-pivoteo.php?idEstacion=' + idestacion);
  
     
    }
      
  
    }   
     
  } 
  
  });

  function Regresar(){
  window.history.back();
  }

    function SelEstacion(idestacion){
    sizeWindow();  
    sessionStorage.setItem('idestacion', idestacion);
    
    $('#ListaPivoteo').load('../public/admin/vistas/lista-pivoteo.php?idEstacion=' + idestacion);

    }

    function Eliminar(idEstacion,id){
        var parametros = {
    "id" : id
    };

 alertify.confirm('',
 function(){

      $.ajax({
    data:  parametros,
    url:   '../public/corte-diario/modelo/eliminar-pivoteo.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

 
    if (response == 1) {
    SelEstacion(idEstacion)
    sizeWindow();
    alertify.success('Pedido eliminado exitosamente.');

    }else{
    alertify.error('Error al eliminar el pedido');
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();
    }

      function Editar(idEstacion,id){
  window.location.href = "pivoteo-editar/" + id;
  }

  function VerPivoteo(id){

  $('#Modal').modal('show');  
  $('#DivContenido').load('../public/corte-diario/vistas/modal-detalle-pivoteo.php?idReporte=' + id);
  }
  
  function PivoteoPDF(id){
  window.location.href = "../pivoteo-pdf/" + id;
  }

  function GMail(idEstacion,id){
 $('#Modal').modal('show');  
  $('#DivContenido').load('../public/admin/vistas/modal-gmail-pivoteo.php?idReporte=' + id + '&idEstacion=' + idEstacion);
  }

  function EnviarCorreo(idReporte,idEstacion){
  let CorreoElectronico = $('#CorreoElectronico').val();

let Asunto = $('#Asunto').val();
let Contenido = $('#Contenido').val();

    var parametros = {
    "idReporte" : idReporte,
    "idEstacion" : idEstacion,
    "CorreoElectronico" : CorreoElectronico,
    "Asunto" : Asunto,
    "Contenido" : Contenido,
    };

    $.ajax({
    data:  parametros,
    url:   '../public/admin/modelo/enviar-correo-pivoteo.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    GMail(idEstacion,idReporte)
    sizeWindow();
    alertify.success('El correo fue enviado');
    }else{
    alertify.error('Error al eliminar el pedido');
    }

    }
    });


  }

  function Nuevo(idEstacion){

    var parametros = {
    "idEstacion" : idEstacion
    };
      $.ajax({
    data:  parametros,
    url:   '../public/corte-diario/modelo/agregar-pivoteo.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response != 0) {
    window.location.href = "pivoteo-editar/" + response;
    }else{
     alertify.error('Error al crear');  
    }

    }
    });

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
   
    <?php if($Session_IDUsuarioBD != 509){ ?>
    <li>
    <a class="pointer" href="<?=SERVIDOR_ADMIN?>">
    <i class="fa-solid fa-house" aria-hidden="true" style="padding-right: 10px;"></i>Menu
    </a>
    </li>
    <?php } ?>

    <li>
    <a class="pointer" onclick="Regresar()">
    <i class="fas fa-arrow-left" aria-hidden="true" style="padding-right: 10px;"></i>Regresar
    </a>
    </li>

    <?php

$sql_listaestacion = "SELECT id, nombre FROM tb_estaciones WHERE numlista <= 8";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);

   while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
    $id = $row_listaestacion['id'];
    $estacion = $row_listaestacion['nombre'];

  $ToSolicitud = ToSolicitud($id,$con);

  if($ToSolicitud > 0){
    $Nuevo = '<div class="float-end"><span class="badge bg-danger text-white rounded-circle"><small>'.$ToSolicitud.'</small></span></div>';
  }else{
   $Nuevo = ''; 
  }

   echo '  
  <li>
    <a class="pointer" onclick="SelEstacion('.$id.')">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$Nuevo.' '.$estacion.'
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
  <a class="text-dark" onclick="history.back()">Pivoteo</a>
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
  <div id="ListaPivoteo" class="cardAG"></div>
  </div> 

  </div>
  </div> 

</div>


    <div class="modal" id="Modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" style="margin-top: 83px;">
      <div id="DivContenido"></div>
      </div>
    </div>
  </div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>navbar-functions.js"></script>
  
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>
