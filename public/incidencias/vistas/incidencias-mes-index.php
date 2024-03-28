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

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  sizeWindow();

  if(sessionStorage){
    if (sessionStorage.getItem('idEstacion') !== undefined && sessionStorage.getItem('idEstacion')) {

      idEstacion = sessionStorage.getItem('idEstacion');
      idCategoria = sessionStorage.getItem('idCategoria');
      year = sessionStorage.getItem('year');
      mes = sessionStorage.getItem('mes');

    $('#ListaIncidencia').load('../../../public/incidencias/vistas/lista-incidencias.php?idEstacion=' + idEstacion + '&idCategoria=' + idCategoria + '&year=' + year + '&mes=' + mes);
        
    }     
    }   
 

  }); 

 

  function Regresar(){
  window.history.back();
  }


  function SelIncidencia(idEstacion,idCategoria,year,mes){
    
    sizeWindow();

    sessionStorage.setItem('idEstacion', idEstacion);
    sessionStorage.setItem('idCategoria', idCategoria);
    sessionStorage.setItem('year', year);
    sessionStorage.setItem('mes', mes);
    sessionStorage.setItem('scrollTop', 0);
    
    $('#ListaIncidencia').html('<div class="text-center"> <img width="50" src="../../../imgs/iconos/load-img.gif"></div>'); 
    $('#ListaIncidencia').load('../../../public/incidencias/vistas/lista-incidencias.php?idEstacion=' + idEstacion + '&idCategoria=' + idCategoria + '&year=' + year + '&mes=' + mes);

  }

  //----- MODAL AGREGAR/EDITAR INCIDENCIA -----//
  function Modal(idEstacion,idCategoria,year,mes,id){
    $('#Modal').modal('show'); 
    $('#ContenidoModal').load('../../../public/incidencias/vistas/modal-agregar-incidencias.php?idEstacion=' + idEstacion + '&idCategoria=' + idCategoria + '&year=' + year + '&mes=' + mes + '&id=' + id);
  } 


  //----- MODAL DETALLE INCIDENCIA -----//
  function Detalle(id){
  $('#Modal').modal('show'); 
  $('#ContenidoModal').load('../../../public/incidencias/vistas/modal-detalle-incidencias.php?id=' + id);

  }


  //----- ELIMINAR INCIDENCIA (SERVER) -----//
  function EliminarInc(idEstacion,idCategoria,year,mes,id){

  var parametros = {
  "id" : id
  };


  alertify.confirm('',
 function(){

      $.ajax({
    data:  parametros,
    url:   '../../../public/incidencias/modelo/eliminar-incidencia.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    sizeWindow()
    SelIncidencia(idEstacion,idCategoria,year,mes); 
    alertify.success('Incidencia eliminada exitosamente');  

    }else{
     alertify.error('Error al eliminar la incidencia');  
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la incidencia seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

    

  }    




  //----- AGREGAR INCIDENCIA (SERVER) -----//
  function Guardar(idEstacion,idCategoria,year,mes,id){
  
  var Fecha = $('#fechaInc').val();
  var Asunto = $('#asuntoInc').val();
  var Responsable = $('#responsableInc').val();
  var TiempoAct = $('#tiempoInc').val();
  var Archivo = $('#PDF').val();

  var data = new FormData();
  var url = '../../../public/incidencias/modelo/agregar-incidencias.php';
 
  PDF = document.getElementById("PDF");
  PDF_file = PDF.files[0];
  PDF_filePath = PDF.value;
   

  if(Fecha != ""){
  $('#fechaInc').css('border',''); 

  if(Asunto != ""){
  $('#asuntoInc').css('border',''); 

  if(Responsable != ""){
  $('#responsableInc').css('border',''); 

  if(TiempoAct != ""){
  $('#tiempoInc').css('border',''); 
 
  data.append('Fecha', Fecha);
  data.append('Asunto', Asunto);
  data.append('Responsable', Responsable);
  data.append('TiempoAct', TiempoAct);
  data.append('PDF_file', PDF_file);
  data.append('idEstacion', idEstacion);
  data.append('idCategoria', idCategoria);
  data.append('year', year);
  data.append('mes', mes);
  data.append('id', id);

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
      
      if(id == 0){
        alertify.success('Incidencia agregada exitosamente.');
      }else{
        alertify.success('Incidencia editada exitosamente.');
      }

       $(".LoaderPage").hide();
       $('#Modal').modal('hide'); 

       sizeWindow()
       SelIncidencia(idEstacion,idCategoria,year,mes)
     
     }else{
      $(".LoaderPage").hide();
      alertify.error('Error al crear la incidencia'); 
      $('#Modal').modal('hide'); 
     }
     

    }); 



  }else{
  $('#tiempoInc').css('border','2px solid #A52525'); 
  }

  }else{
  $('#responsableInc').css('border','2px solid #A52525'); 
  }

  }else{
  $('#asuntoInc').css('border','2px solid #A52525'); 
  }

  }else{
  $('#fechaInc').css('border','2px solid #A52525'); 
  }



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

    $sql_listaestacion = "SELECT id, nombre FROM tb_estaciones WHERE numlista <= 8 ORDER BY numlista ASC";
    $result_listaestacion = mysqli_query($con, $sql_listaestacion);

    while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
    $id = $row_listaestacion['id'];
    $estacion = $row_listaestacion['nombre'];

      echo '
      <li>
      <a class="pointer" onclick="SelIncidencia('.$id.', 1, '.$GET_idYear.','.$GET_idMes.')">
      <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
      '.$estacion.'
      </a>
      </li>';

    } 
 
  ?>  
 
  <li>
    <a class="pointer" onclick="SelIncidencia(501, 2,<?=$GET_idYear;?>,<?=$GET_idMes;?>)">
    <i class="fa-solid fa-building" aria-hidden="true" style="padding-right: 10px;"></i>
    Departamento
    </a>
  </li>


    <li>
    <a class="pointer" onclick="SelIncidencia(502, 3,<?=$GET_idYear;?>,<?=$GET_idMes;?>)">
    <i class="fa-solid fa-shuffle" aria-hidden="true" style="padding-right: 10px;"></i>
    Varios
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
  <a class="text-dark" onclick="history.back()">Incidencias, <?=nombremes($GET_idMes);?> <?=$GET_idYear;?></a>
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
  <div id="ListaIncidencia" class="cardAG"></div>
  </div> 

  </div>
  </div> 
  </div>

</div>



<div class="modal fade bd-example-modal-lg" id="Modal">
<div class="modal-dialog">
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
           