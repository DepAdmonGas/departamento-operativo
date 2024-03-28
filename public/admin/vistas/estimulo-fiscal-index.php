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
    });

  function Regresar(){
   sessionStorage.removeItem('idestacion');
   window.history.back();
  }

  function SelEstacion(idestacion,fechainicio,fechatermino){
  sizeWindow(); 
    ListaEstimulo(idestacion,fechainicio,fechatermino);
    ListaPagoEstimulo(idestacion);

  }  

  function ListaEstimulo(idestacion,fechainicio,fechatermino){
   $('#ListaEstimulo').load('../public/admin/vistas/lista-estimulo-fiscal.php?idEstacion=' + idestacion + '&FechaInicio=' + fechainicio + '&FechaTermino=' + fechatermino);
  }   
  function ListaPagoEstimulo(idestacion){
  $('#ListaPagoEstimulo').load('../public/admin/vistas/lista-pago-estimulo-fiscal.php?idEstacion=' + idestacion);
  }

  function BuscarReporte(idestacion){

  var fechainicio = $('#FInicio').val();
  var fechatermino = $('#FTermino').val();

  $('#ListaEstimulo').load('../public/admin/vistas/lista-estimulo-fiscal.php?idEstacion=' + idestacion + '&FechaInicio=' + fechainicio + '&FechaTermino=' + fechatermino);  
  }

  function btnModal(idEstacion){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('../public/admin/vistas/modal-agregar-estimulo-fiscal.php?idEstacion=' + idEstacion); 
  } 

  function Guardar(idEstacion){

  var MFInicio = $('#MFInicio').val();
  var MFTermino = $('#MFTermino').val();

  var data = new FormData();
  var url = '../public/admin/modelo/agregar-estimulo-fiscal.php';
  
  PDF = document.getElementById("PDF");
  PDF_file = PDF.files[0];
  PDF_filePath = PDF.value;

  XML = document.getElementById("XML");
  XML_file = XML.files[0];
  XML_filePath = XML.value;

if (MFInicio != "") {
$('#MFInicio').css('border','');
if (MFTermino != "") {
$('#MFTermino').css('border','');
if (PDF_filePath != "") {
$('#PDF').css('border','');
if (XML_filePath != "") {
$('#XML').css('border','');

    data.append('idEstacion', idEstacion);
    data.append('MFInicio', MFInicio);
    data.append('MFTermino', MFTermino);
    data.append('PDF_file', PDF_file);
    data.append('XML_file', XML_file);


    $.ajax({
    url: url,
    type: 'POST',
    contentType: false,
    data: data,
    processData: false,
    cache: false
    }).done(function(data){

      if(data == 1){
        ListaPagoEstimulo(idEstacion)
        $('#Modal').modal('hide');
        alertify.success('Estimulo fiscal agregado exitosamente.');
      }


    });

}else{
$('#XML').css('border','2px solid #A52525');
}
}else{
$('#PDF').css('border','2px solid #A52525');
}
}else{
$('#MFTermino').css('border','2px solid #A52525');
}
}else{
$('#MFInicio').css('border','2px solid #A52525');
}
  }

  function Eliminar(id,idEstacion){

  var parametros = {
    "idReporte" : id
    };


alertify.confirm('',
 function(){

      $.ajax({
    data:  parametros,
    url:   '../public/admin/modelo/eliminar-estimulo-fiscal.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    ListaPagoEstimulo(idEstacion);
    alertify.success('Registro eliminado exitosamente.'); 

    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();
  }

  function Editar(id,idEstacion,FInicio,FTermino){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('../public/admin/vistas/modal-editar-estimulo-fiscal.php?idEstacion=' + idEstacion +  
    '&IdReporte=' + id   + '&FechaInicio=' + FInicio + '&FechaTermino=' + FTermino); 
  }
 
  function EditarPago(idEstacion,IdReporte){

  var EFInicio = $('#EFInicio').val();
  var EFTermino = $('#EFTermino').val();

  var data = new FormData();
  var url = '../public/admin/modelo/editar-estimulo-fiscal.php';
  
  EPDF = document.getElementById("EPDF");
  EPDF_file = EPDF.files[0];
  EPDF_filePath = EPDF.value;

  EXML = document.getElementById("EXML");
  EXML_file = EXML.files[0];
  EXML_filePath = EXML.value;

  CPDF = document.getElementById("CPDF");
  CPDF_file = CPDF.files[0];
  CPDF_filePath = CPDF.value;

  CXML = document.getElementById("CXML");
  CXML_file = CXML.files[0];
  CXML_filePath = CXML.value;

 alertify.confirm('',
 function(){

    data.append('idEstacion', idEstacion);
    data.append('IdReporte', IdReporte);
    data.append('EFInicio', EFInicio);
    data.append('EFTermino', EFTermino);
    data.append('EPDF_file', EPDF_file);
    data.append('EXML_file', EXML_file);
    data.append('CPDF_file', CPDF_file);
    data.append('CXML_file', CXML_file);

    $.ajax({
    url: url,
    type: 'POST',
    contentType: false,
    data: data,
    processData: false,
    cache: false
    }).done(function(data){

      if(data == 1){
         ListaPagoEstimulo(idEstacion)
        $('#Modal').modal('hide');
        alertify.success('información ha sido editada exitosamente.')
      }


    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea editar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();


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

  $FInicio = date("Y").'-'.date("m").'-01';
  $FTermino = date("Y-m-t", strtotime($FInicio));

  $sql_listaestacion = "SELECT id, nombre, numlista FROM tb_estaciones WHERE numlista <= 8 ORDER BY numlista ASC";
  $result_listaestacion = mysqli_query($con, $sql_listaestacion);
  while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
  $id = $row_listaestacion['id'];
  $estacion = $row_listaestacion['nombre'];

    echo '  
  <li>
    <a class="pointer" onclick="SelEstacion('.$id.',\''.$FInicio.'\', \''.$FTermino.'\' )">
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
  <a class="text-dark" onclick="history.back()">Estimulo Fiscal</a>
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
  
  <div class="col-xl-6 col-lg-5 col-md-10 col-sm-12 mb-3"> 
  <div id="ListaEstimulo" class="cardAG"></div>
  </div> 


  <div class="col-xl-6 col-lg-5 col-md-10 col-sm-12"> 
  <div id="ListaPagoEstimulo" class="cardAG"></div>
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
  <script src="<?=RUTA_JS2 ?>navbar-functions.js"></script>
  
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>


</body>
</html>