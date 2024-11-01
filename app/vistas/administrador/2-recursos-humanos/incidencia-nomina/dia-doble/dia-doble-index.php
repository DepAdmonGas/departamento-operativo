<?php
require('app/help.php');

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
  <link href="<?=RUTA_CSS2;?>cards-utilities.min.css" rel="stylesheet" />
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
  if (sessionStorage.getItem('year') !== undefined && sessionStorage.getItem('year')) {

  year = sessionStorage.getItem('year');
  tipo = sessionStorage.getItem('tipo');


  if(tipo == 1 ){
  semana = sessionStorage.getItem('semana');
  sessionStorage.removeItem('quincena'); 
  SelEstacion(year,semana,tipo);

  }else{
  quincena = sessionStorage.getItem('quincena');
  sessionStorage.removeItem('semana');

  SelDireccionOperaciones(year,quincena,tipo);

  }

  }    
  }
 
  });  

  function Regresar(){
  sessionStorage.removeItem('semana');
  window.history.back(); 
  }

  
  function SelEstacion(year,semana,tipo){
  sizeWindow();  
  sessionStorage.setItem('year', year);
  sessionStorage.setItem('semana', semana); 
  sessionStorage.setItem('tipo', tipo);  
  sessionStorage.removeItem('quincena');

  $('#ListaIncidencia').load('../app/vistas/administrador/2-recursos-humanos/incidencia-nomina/dia-doble/lista-dia-doble.php?&year=' + year + '&semana=' + semana);
  }


  function SelDireccionOperaciones(year,quincena,tipo){
  sizeWindow();  
  sessionStorage.setItem('year', year);
  sessionStorage.setItem('quincena', quincena); 
  sessionStorage.setItem('tipo', tipo);  
  sessionStorage.removeItem('semana');

  $('#ListaIncidencia').load('../app/vistas/administrador/2-recursos-humanos/incidencia-nomina/dia-doble/lista-dia-doble-operativo.php?&year=' + year + '&quincena=' + quincena);
  }

  
  function SelNoSemana(year){
  sizeWindow();
  var semana = $('#SemanaEstacion_' + year).val();
  sessionStorage.setItem('semana', semana);

  SelEstacion(year,semana,1)
  }



  //---------- 
  function FormularioDiaDoble(year,quincena){
    
    var parametros = {
    "year": year,
    "quincena": quincena,
    "accion": "agregar-dia-doble-reporte"
    } 
        
    $.ajax({
    data: parametros,
    url: '../app/controlador/2-recursos-humanos/controladorHorario.php',
    //url: 'public/recursos-humanos/modelo/agregar-programar-horario-personal.php',
    type: 'post',
    beforeSend: function () {
    
    },
    complete: function () { 
    
    },
    success: function (response) {

    if (response != 0) {
    window.location.href = "../recursos-humanos-formulario-dia-doble/" + response;
    }

    }
    });

    } 

    function EditFormulario(idReporte){
    window.location.href = "../recursos-humanos-formulario-dia-doble/" + idReporte;
    }

    function Firmar(idReporte){
    window.location.href = "../recursos-humanos-firmar-dia-doble/" + idReporte;
    }


    //---------- ELIMINAR FORMATO 
    function DeleteFormulario(id,year,quincena){
    
    alertify.confirm('',
    function(){
  
    var parametros = { 
    "id" : id,
    "accion" : "eliminar-formato-horario-do"
    };
   
    $.ajax({ 
    data:  parametros,
    url:    '../app/controlador/2-recursos-humanos/controladorHorario.php',
    type:  'post',
    beforeSend: function() {
           
    },
    complete: function(){
  
    }, 
    success:  function (response) {
  
    if(response == 1){ 
    SelDireccionOperaciones(year,quincena,2)
    alertify.success('Registro eliminado exitosamente.');   
    
    }else{
    alertify.error('Error al eliminar el registro');    
    }
  
    }
    });
    },
    function(){
  
    }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar el registro seleccionado?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();
    
    }



  //---------- DETALLE FORMATOS ----------
  function DetalleFormulario(idReporte,idFormato){
  $('#ModalIncidencias').modal('show');  
  $('#ContenidoModal').load('../app/vistas/administrador/2-recursos-humanos/incidencia-nomina/dia-doble/modal-detalle-dia-doble.php?idReporte=' + idReporte); 
  } 


  function DescargarPDF(idReporte,idFormato){
  window.location.href = '../app/vistas/administrador/2-recursos-humanos/incidencia-nomina/dia-doble/pdf-dia-doble.php?idReporte=' + idReporte;
  }

  //---------- DETALLE FORMATOS ----------
  function ModalComentario(idReporte,year,quincena){
  $('#ModalIncidencias').modal('show');  
  $('#ContenidoModal').load('../app/vistas/administrador/2-recursos-humanos/incidencia-nomina/dia-doble/modal-comentario-dia-doble.php?idReporte=' + idReporte + '&year=' + year + '&quincena=' + quincena); 
  } 

  function GuardarComentario(idReporte){
  var Comentario = $('#Comentario').val();

  var parametros = {
  "idReporte" : idReporte,
  "idUsuario" : <?=$Session_IDUsuarioBD?>,
  "Comentario" : Comentario,
  "accion" : "agregar-comentario-dia-doble"
  }; 
    
  if(Comentario != ""){
  $('#Comentario').css('border',''); 

  $.ajax({
  data:  parametros,
  url:   '../app/controlador/2-recursos-humanos/controladorHorario.php', 
  type:  'post',
  beforeSend: function() {

  },
  complete: function(){  

  },
  success:  function (response) {

  if (response == 1) {
  sizeWindow();
  SelDireccionOperaciones(year,quincena,2)
  alertify.success('Comentario agregado exitosamente.');  

  $('#Comentario').val('');
  $('#ContenidoModal').load('../app/vistas/administrador/2-recursos-humanos/incidencia-nomina/dia-doble/modal-comentario-dia-doble.php?idReporte=' + idReporte + '&year=' + year + '&quincena=' + quincena); 

  }else{
  alertify.error('Error al guardar el comentario');  
  }

  } 
  });

  }else{
  $('#Comentario').css('border','2px solid #A52525'); 
  }

  }



    window.addEventListener('pageshow', function(event) {
    if (event.persisted) {
    // Si la página está en la caché del navegador, recargarla
    window.location.reload();
    }
    });


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
   
    <li id="menu-item">
    <a class="pointer" href="<?=SERVIDOR_ADMIN?>">
    <i class="fa-solid fa-house" aria-hidden="true" style="padding-right: 10px;"></i>Menu
    </a>
    </li>


  <!---------- SESIONES CLEAN ---------->
  <script>
  document.addEventListener('DOMContentLoaded', function () {
  var menuItem = document.getElementById('menu-item');
    menuItem.addEventListener('click', function () {
    sessionStorage.removeItem('semana');
    });
  });
  </script>


  <li>
  <a class="pointer" onclick="Regresar()">
  <i class="fas fa-arrow-left" aria-hidden="true" style="padding-right: 10px;"></i>Regresar
  </a>
  </li>

  <?php
  // Obtener la fecha actual
  $currentDate = time(); // Puedes usar una fecha específica con strtotime() si lo deseas

  // Calcular el número de día de la semana (de 1 a 7, donde 4 es jueves y 3 es miércoles)
  $diaSemana = date('N', $currentDate);

  // Si la semana termina el miércoles, ajustamos la fecha para obtener el inicio de la semana
  if ($diaSemana >= 4) {
  $inicioSemana = strtotime('last Wednesday', $currentDate);
  } else {
  $inicioSemana = strtotime('Wednesday last week', $currentDate);
  }

  // Obtener el número de semana actual considerando que la semana comienza el jueves (4)
  $GET_semana = date('W', $inicioSemana);
  ?>
    
  <li>
  <a class="pointer" onclick="SelEstacion(<?=$GET_year?>,<?=$GET_semana?>,1)">
  <i class="fa-solid fa-gas-pump" style="padding-right: 10px;"></i> Estaciones
  </a>
  </li>

  <?php
  // Obtener el número del día en el año actual
  $numeroDiaAnio = date('z') + 1; // Se agrega 1 ya que 'z' cuenta desde 0
  // Calcular el número de quincena
  $GET_quincena = ceil($numeroDiaAnio / 15); // Redondear hacia arriba para obtener el número de quincena
  ?>

  <li>
  <a class="pointer" onclick="SelDireccionOperaciones(<?=$GET_year?>,<?=$GET_quincena?>,2)">
  <i class="fa-solid fa-briefcase" style="padding-right: 10px;"></i> Dirección de operaciones
  </a>
  </li>

  </ul>
  </nav>

  <!---------- DIV - CONTENIDO ----------> 
  <div id="content">
  <!---------- NAV BAR - PRINCIPAL (TOP) ---------->  
  <nav class="navbar navbar-expand navbar-light navbar-bg" >
  
  <i class="fa-solid fa-bars menu-btn rounded pointer" id="sidebarCollapse"></i>

  <div class="pointer"><a class="text-dark" onclick="history.back()">Recursos humanos dia doble</a></div>
 
  <div class="navbar-collapse collapse">
  <div class="dropdown-divider"></div>

  <ul class="navbar-nav navbar-align">

  <li class="nav-item dropdown">
  <a class=" dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
  <i class="align-middle" data-feather="settings"></i>
  </a>

 
  <a class="nav-link dropdown-toggle d-none d-sm-inline-block pointer" data-bs-toggle="dropdown">
  <img src="<?=RUTA_IMG_ICONOS."usuarioBar.png";?>" class="avatar img-fluid rounded-circle"/>
  <span class="text-dark" style="padding-left: 10px;"><?=$session_nompuesto;?>  </span>
  </a>
  
  <div class="dropdown-menu dropdown-menu-end">
  
  <div class="user-box">
  <div class="u-text">
  <p class="text-muted">Nombre de usuario:</p>
  <h4><?=$session_nomusuario;?></h4>
  </div>
  </div>

  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="<?=PERFIL_ADMIN?>"><i class="fa-solid fa-user" style="padding-right: 5px;"></i>Perfil</a>
 
  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="<?=RUTA_SALIR2?>salir"><i class="fa-solid fa-power-off" style="padding-right: 5px;"></i> Cerrar Sesión</a>
  
  </div>

  </li>
  
  </ul>
  </div>

  </nav>
 
  <!---------- CONTENIDO PAGINA WEB----------> 
  <div class="contendAG">
  <div class="row">  
  
  <div class="col-12" id="ListaIncidencia"></div> 

  </div>
  </div> 

  </div>

  </div>


  <!---------- MODAL ----------> 
  <div class="modal fade" id="ModalIncidencias" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  <div class="modal-content" id="ContenidoModal">
  </div>
  </div>
  </div>

  <!---------- MODAL COVID (RIGHT)---------->  
  <div class="modal right fade" id="ModalIncidencia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
  <div class="modal-content" id="DivIncidencia"></div>
  </div>
  </div>
  

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>navbar-functions.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

</body>
</html>