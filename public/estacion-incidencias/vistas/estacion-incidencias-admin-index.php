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
      $('#ListaIncidencias').load('../public/estacion-incidencias/vistas/lista-estacion-incidencias.php?idEstacion=' + idEstacion);
         
    }     
    }   

    });

  function Regresar(){
   sessionStorage.removeItem('idEstacion');
   window.history.back();
  }

  function SelEstacion(idEstacion){
    sizeWindow(); 
    sessionStorage.setItem('idEstacion', idEstacion);
    $('#ListaIncidencias').load('../public/estacion-incidencias/vistas/lista-estacion-incidencias.php?idEstacion=' + idEstacion);
  } 


  //---------- MODAL - AGREGAR INCIDENCIAS ----------
  function ModalNuevaIncidencia(idEstacion){
   $('#ModalIncidencias').modal('show'); 
   $('#DivIncidencias').load('../public/estacion-incidencias/vistas/modal-agregar-incidencias.php?idEstacion=' + idEstacion);
  }
 

  //---------- MODAL - VER INCIDENCIAS ----------
  function ModalVerIncidencia(idIncidencia){
    $('#ModalIncidencias').modal('show'); 
   $('#DivIncidencias').load('../public/estacion-incidencias/vistas/modal-ver-incidencias.php?idIncidencia=' + idIncidencia);
  }

   //---------- MODAL - EDITAR INCIDENCIAS ----------
  function ModalEditarIncidencia(idIncidencia){
   $('#ModalIncidencias').modal('show'); 
   $('#DivIncidencias').load('../public/estacion-incidencias/vistas/modal-editar-incidencias.php?idIncidencia=' + idIncidencia);
  }


   //---------- ELIMINAR INCIDENCIAS (SERVER) ----------
  function EliminarIncidencia(idIncidencia,idEstacion){

  var parametros = {
    "idIncidencia" : idIncidencia
    };

 alertify.confirm('',
 function(){

      $.ajax({
    data:  parametros,
    url:   '../public/estacion-incidencias/modelo/eliminar-incidencia.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

 
    if (response == 1) {
  	SelEstacion(idEstacion)
    sizeWindow()
    alertify.success('Incidencia eliminada');    
    }else{
    alertify.error('Error al eliminar incidencia');
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la incidencia seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();


  }


  //---------- GUARDAR INCIDENCIAS (SERVER) ----------
  function GuardarIncidencia(idEstacion){
  
  var FechaInc = $('#FechaInc').val();
  var HoraInc = $('#HoraInc').val();
  var IncidenciaInc = $('#IncidenciaInc').val();
  var ResponsableInc = $('#ResponsableInc').val();
  var AsuntoInc = $('#AsuntoInc').val();
  var ComentariosInc = $('#ComentariosInc').val();

  var DocumentoInc = $('#DocumentoInc').val();


  var data = new FormData();
  var url = '../public/estacion-incidencias/modelo/agregar-incidencia.php';
 
  Archivo = document.getElementById("DocumentoInc");
  Archivo_file = Archivo.files[0];
  Archivo_filePath = Archivo.value;

  if(FechaInc != ""){
  $('#FechaInc').css('border','');

  if(HoraInc != ""){
  $('#HoraInc').css('border','');

  if(IncidenciaInc != ""){
  $('#IncidenciaInc').css('border','');

  if(ResponsableInc != ""){
  $('#ResponsableInc').css('border','');

  if(AsuntoInc != ""){
  $('#AsuntoInc').css('border','');

  if(ComentariosInc != ""){
  $('#ComentariosInc').css('border','');

  if(DocumentoInc != ""){
  $('#DocumentoInc').css('border','');

   data.append('idEstacion', idEstacion);

   data.append('FechaInc', FechaInc);
   data.append('HoraInc', HoraInc);
   data.append('IncidenciaInc', IncidenciaInc);
   data.append('ResponsableInc', ResponsableInc);
   data.append('AsuntoInc', AsuntoInc);
   data.append('ComentariosInc', ComentariosInc);

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
  	  $('#ModalIncidencias').modal('hide'); 
  	  SelEstacion(idEstacion)
  	  sizeWindow()
      alertify.success('Incidencia agregada exitosamente.');
     }else{

      $(".LoaderPage").hide();
      alertify.error('Error al agregar incidencia'); 
     }
     
    });  

  }else{
  $('#DocumentoInc').css('border','2px solid #A52525'); 
  }

  }else{
  $('#ComentariosInc').css('border','2px solid #A52525'); 
  }

  }else{
  $('#AsuntoInc').css('border','2px solid #A52525'); 
  }

  }else{
  $('#ResponsableInc').css('border','2px solid #A52525'); 
  }

  }else{
  $('#IncidenciaInc').css('border','2px solid #A52525'); 
  }

  }else{
  $('#HoraInc').css('border','2px solid #A52525'); 
  }


  }else{
  $('#FechaInc').css('border','2px solid #A52525'); 
  }

  }


    //---------- EDITAR INCIDENCIAS (SERVER) ----------
  function EditarIncidencia(idIncidencia,idEstacion){
  
  var FechaInc = $('#FechaInc').val();
  var HoraInc = $('#HoraInc').val();
  var IncidenciaInc = $('#IncidenciaInc').val();
  var ResponsableInc = $('#ResponsableInc').val();
  var AsuntoInc = $('#AsuntoInc').val();
  var ComentariosInc = $('#ComentariosInc').val();

  var DocumentoInc = $('#DocumentoInc').val();


  var data = new FormData();
  var url = '../public/estacion-incidencias/modelo/editar-incidencia.php';
 
  Archivo = document.getElementById("DocumentoInc");
  Archivo_file = Archivo.files[0];
  Archivo_filePath = Archivo.value;

  if(FechaInc != ""){
  $('#FechaInc').css('border','');

  if(HoraInc != ""){
  $('#HoraInc').css('border','');

  if(IncidenciaInc != ""){
  $('#IncidenciaInc').css('border','');

  if(ResponsableInc != ""){
  $('#ResponsableInc').css('border','');

  if(AsuntoInc != ""){
  $('#AsuntoInc').css('border','');

  if(ComentariosInc != ""){
  $('#ComentariosInc').css('border','');

   data.append('idIncidencia', idIncidencia);

   data.append('FechaInc', FechaInc);
   data.append('HoraInc', HoraInc);
   data.append('IncidenciaInc', IncidenciaInc);
   data.append('ResponsableInc', ResponsableInc);
   data.append('AsuntoInc', AsuntoInc);
   data.append('ComentariosInc', ComentariosInc);

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
  	  $('#ModalIncidencias').modal('hide'); 
  	  SelEstacion(idEstacion)
  	  sizeWindow()
      alertify.success('Incidencia editada exitosamente.');
     }else{

      $(".LoaderPage").hide();
      alertify.error('Error al editar incidencia'); 
     }
     
    });  


  }else{
  $('#ComentariosInc').css('border','2px solid #A52525'); 
  }

  }else{
  $('#AsuntoInc').css('border','2px solid #A52525'); 
  }

  }else{
  $('#ResponsableInc').css('border','2px solid #A52525'); 
  }

  }else{
  $('#IncidenciaInc').css('border','2px solid #A52525'); 
  }

  }else{
  $('#HoraInc').css('border','2px solid #A52525'); 
  }


  }else{
  $('#FechaInc').css('border','2px solid #A52525'); 
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
    <a class="pointer" href="<?=PORTAL?>">
    <i class="fa-solid fa-house" aria-hidden="true" style="padding-right: 10px;"></i>Portal
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
    <a class="pointer" onclick="SelEstacion('.$id.')">
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
  <a class="text-dark" onclick="history.back()">Incidencias</a>
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
  <div id="ListaIncidencias" class="cardAG"></div>
  </div> 

  </div>
  </div> 

</div>



<div class="modal" id="ModalIncidencias">
  <div class="modal-dialog" style="margin-top: 83px;">
    <div class="modal-content">

      <div id="DivIncidencias"></div>
   
    </div>
  </div>
</div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>navbar-functions.js"></script>
  
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>

 